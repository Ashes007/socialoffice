<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth, \Validator, \Hash, \Redirect;
use App\User, App\EmailTemplate, App\Sitesetting;
use App\Mail\FlyEmail;
use App\Ticket;
use App\Event;


class DashboardController extends Controller
{
	public function index(){
        $data['openTicket'] = Ticket::where('status','Open')->where('parent_id','0')->count();
        $data['closeTicket'] = Ticket::where('status','Closed')->where('parent_id','0')->count();
        $data['activeUser'] = User::where('status','Active')->count();
        $data['newUser']    = User::where('status','Active')->where('first_time_login','Yes')->orderBy('id','desc')->limit(8)->get();
        $data['openTicketList'] = Ticket::where('status','Open')->where('parent_id','0')->orderBy('id','desc')->limit(8)->get();
        $data['currentEvent'] = Event::where('status','Active')->orderBy('id','desc')->limit(3)->get();
        
		return view('admin.adminuser.dashboard',$data);	
	}

    public function change_password(){
        $data['profile'] = User::find(Auth::guard('admin')->user()->id);
        return view('admin.adminuser.change_password',$data);
    }
    
    public function change_password_action(Request $request){
        $validator              = Validator::make($request->all(), ['current_password'           =>'required',
                                                                    'password'               => 'required|Min:6|confirmed',
                                                                    'password_confirmation'  => 'required']);
            
        if($validator->fails()){
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $old_password           = $request->current_password;
            $new_password           = $request->password;
            $profile = User::find(Auth::guard('admin')->user()->id);
            if(Hash::check($old_password,$profile->password)){
                $profile->password = $new_password;
                $profile->save();
                return Redirect::route('admin_change_password')->with('success','Password is updated successfully');
            }else{
               return Redirect::route('admin_change_password')->with('error','Current Password is not matched');
            }
        }
    }

    public function forgot_password(){
        $data = array();
        return view('admin.adminuser.forgot_password',$data);
    }
    
    public function forgot_password_action(Request $request)
    { 
        $validator = Validator::make(
                                $request->all(),
                                 [
                                      'email'     => 'required|email'
                                 ]
        );
    if ($validator->fails())
    {
            $messages = $validator->messages();
            return Redirect::back()->withErrors($validator)->withInput();
    }
    else
    {
            $user_details = User::where('email', $request->email)->wherehas('roleuser', function($q){
                $q->where('role_id',1);
            })->first();
                
            if($user_details && $user_details->count()){ 
                $token =  encrypt($user_details->email);
                $user_details->reset_token = $token;
                $user_details->save();
                                                        
                $info_email           = Sitesetting::findValByLebel('info_email');
                $site_name            = Sitesetting::findValByLebel('site_name');                
                $email_signature      = Sitesetting::findValByLebel('email_signature');
                $email_template       = EmailTemplate::where('slug','admin_forgot_password')->first();                
                $emailContent         = $email_template->email_content;
        
                $emailContent = str_replace('{{USER_NAME}}',ucwords($user_details->first_name.' '.$user_details->last_name), $emailContent);
                $emailContent = str_replace('#{{PASSWORD_RESET_LINK}}', \URL::route('admin_reset_newpassword',[$token]), $emailContent);
                $emailContent = str_replace('{{PASSWORD_RESET_LINK}}', \URL::route('admin_reset_newpassword',[$token]), $emailContent);
                $emailContent = str_replace('{{SIGNATURE}}',$email_signature, $emailContent);
                
                $data['template']           = $email_template->template_file;
                $data['from_email']         = $info_email;
                $data['subject']            = $email_template->email_subject;
                $data['form_name']          = $site_name;
                $data['to_email']           = $user_details->email; 
                //$data['to_email']           = 'kingshuk@matrixnmedia.com';
                $data['email_content']      = $emailContent;
                \Mail::to($data['to_email'])->send(new FlyEmail($data));                
                     
                     return Redirect::back()->with('success','A reset password link has been sent to your email. Please check your email to reset password.');                       
                 }else{
                     return Redirect::back()->with('error','Sorry! we did not find your email in our system');           
                 }
    }
    }    
 
    public function password_reset($token){
        $data = array();
        $data['token'] = $token;
        return view('admin.adminuser.password_reset',$data);
    }
    
    public function password_update(Request $request,$token){
        $validator = Validator::make(
                            $request->all(),
                            [                                  
                                'password'              => 'required|Min:6|confirmed',
                                'password_confirmation' => 'required'                                                                                    
                            ]
                            );
        if ($validator->fails())
        {
             return Redirect::back()->withErrors($validator)->withInput();
        }
        else
        {
                $user_details = User::where('reset_token',$token)->first();
                 if(isset($user_details->reset_token)){
                    $user_details->password = $request->password;
                    $user_details->reset_token = '';
                    $user_details->save();
                    return Redirect::route('admin_login')->with('success', 'You have successfully reset your password. Please login with your new password');
                 }else{
                    return redirect::back()->with('error', 'Sorry! token miss matched.');
                 }
               
        }
    }    	
    
}
