<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Department;
use App\DepartmentTranslation;
use App\Designation;
use App\DesignationTranslation;
use App\Company;
use App\CompanyTranslation;
use App\GroupType;
use App\GroupTypeTranslation;
use App\GroupUser;
use App\UserGroupUser;
use App\Event;
use App\EventInvite;
use URL;

use Ixudra\Curl\Facades\Curl;
require base_path('vendor/autoload.php');
require base_path('vendor/algolia/algoliasearch-client-php/algoliasearch.php');

class LoginController extends Controller
{

    public function algoliaSave($user_detail){

        $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");

        $index = $client->initIndex('TAWASUL');

        $batch = array();
        foreach ($user_detail as $key => $value) {
            $object[$key]=$value;
        }
        array_push($batch,$object);
        $index->addObjects($batch);
    }

	public function index()
	{ 
        if(\Auth::guard('user')->check())
        {
            return \Redirect::Route('home');
        }
		return view('front.users.login');
	}


    public function userLogin(Request $request)
    {   
        $daya = array();
    	$Validator = Validator::make($request->all(),[
    			'username' 	=> 'required',
    			'password'	=> 'required'
    		]);

    	if($Validator->fails())
    	{
    		
            if(empty($request->input('password')) && empty($request->input('username'))) {
              //return \Redirect::back()->with('error','Username or password is wrong');
                $data['validate'] = 'Error';
                $data['message'] = 'Username and Password should not be blank';
            } elseif(empty(trim($request->input('username')))){
                $data['validate'] = 'Error';
                $data['message'] = 'Username should not be blank'; 
            } elseif(empty(trim($request->input('password')))){
                $data['validate'] = 'Error';
                $data['message'] = 'Password should not be blank'; 
            }
    	}
    	else
    	{
    		
            $username = $request->input('username');
            $password = $request->input('password');

            
            $response = Curl::to(config('constant.USER_API'))
                        ->withData( array( 'key' => 'ADF767DGH', 'username' => $username, 'password' => $password ) )
                        ->asJson()
                         ->get();

	        if(isset($response->Message))
	        {
	        		$data['validate'] 	= 'Error';
		            $data['message'] 	= 'Contact System Administrator.'; 
	        }
	        else
	        {
         
		         if($response == 'Invalid password' || $response == 'Username or password is wrong')
		         {
		            //exit('ss');
		           //return \Redirect::back()->with('error','Invalid Username or Password');
		           $data['validate'] = 'Error';
		           $data['message'] = 'Invalid Username or Password'; 
		         }
		         else
		         {

		            $user = User::where('ad_username', $username)->first();

		            $companyName     = $response[0]->userCompany;
		            $departmentName  = $response[0]->userDepartment;
		            $groupName       = $response[0]->userGroup;
		            $userEmail       = $response[0]->userEmail;
		            $display_name    = $response[0]->displayName; 
		            $userTitle       = $response[0]->userTitle;
		            $userPhone       = $response[0]->userPhone;
		            $userDateOfJoin  = $response[0]->userDateOfJoin;
		            $userDateOfBirth = $response[0]->userDateOfBirth;   

		            $CompanyDetails = CompanyTranslation::where('name', $companyName )->get();

		            if($CompanyDetails->count() == 0)
		            {
		                $company        = new Company;               


		                $company->status = 'Active';
		                $company->save();
		                $company_id = $company->id;

		                foreach ($this->lang_locales as $locale) {
		                    $CompanyDetails = new CompanyTranslation;
		                    $CompanyDetails->company_id = $company->id;
		                    $CompanyDetails->locale = $locale->code;
		                    $CompanyDetails->name = $companyName;
		                    $CompanyDetails->save();
		                }
		                
		                
		            }
		            else
		            {
		                $company_id = $CompanyDetails[0]->company_id;
		            }

		            $departmentDetails = DepartmentTranslation::where('name', $departmentName )->get();

		            if($departmentDetails->count() == 0)
		            {
		                $department        = new Department;
		                

		                $department->status = 'Active';
		                $department->save();
		                $department_id = $department->id;

		                foreach ($this->lang_locales as $locale) {
		                    $departmentDetails = new DepartmentTranslation;
		                    $departmentDetails->department_id = $department->id;
		                    $departmentDetails->locale = $locale->code;
		                    $departmentDetails->name = $departmentName;
		                    $departmentDetails->save();
		                }
		                                
		            }
		            else
		            {
		                $department_id = $departmentDetails[0]->department_id;
		            }

		            $designationDetails = DesignationTranslation::where('name', $userTitle )->get();

		            if($designationDetails->count() == 0)
		            {
		                $designation        = new Designation;
		                

		                $designation->status = 'Active';
		                $designation->save();
		                $designation_id = $designation->id;

		                foreach ($this->lang_locales as $locale) {
		                    $designationDetails = new DesignationTranslation;
		                    $designationDetails->designation_id = $designation->id;
		                    $designationDetails->locale = $locale->code;
		                    $designationDetails->name = $userTitle;
		                    $designationDetails->save();
		                }
		                                
		            }
		            else
		            {
		                $designation_id = $designationDetails[0]->designation_id;
		            }


		            $grouptypeDetails = GroupTypeTranslation::where('name', $groupName )->get();

		            if($grouptypeDetails->count() == 0)
		            {
		               
		                $grouptype        = new GroupType;               

		                $grouptype->status = 'Active';
		                $grouptype->save();
		                $group_id = $grouptype->id;

		                foreach ($this->lang_locales as $locale) {
		                    $grouptypeDetails = new GroupTypeTranslation;
		                    $grouptypeDetails->group_type_id = $grouptype->id;
		                    $grouptypeDetails->locale = $locale->code;
		                    $grouptypeDetails->name = $groupName;
		                    $grouptypeDetails->save();
		                }
		                
		                
		            }
		            else
		            {
		                
		                $group_id = $grouptypeDetails[0]->group_type_id;
		            }
		  
		            

		             $newUser = 'No';
		             if($user == NULL)
		             {            
		                $user = new User;
		                $user->access_token  = \Hash::make(time());
		                $user->first_time_login = 'Yes';
		                $user->ad_username = $username; 
		                $newUser = 'Yes';

		                if($userDateOfJoin != '')
			            $user->date_of_joining = \DateTime::createFromFormat('d/m/Y', $userDateOfJoin)->format('Y-m-d');
			            if($userDateOfBirth != '')
			            $user->date_of_birth= \DateTime::createFromFormat('d/m/Y', $userDateOfBirth)->format('Y-m-d');
		             
		             }

		              //////////////////////////////////////// algolia insert ////////////////////////////////////

		            $user_detail = array();
		            $user_detail['alpha'] = strtolower(substr($display_name,0, 1));
		            $user_detail['employeeName'] = $display_name;
		            $user_detail['designation'] = $userTitle;
		            $user_detail['department'] = $departmentName;
		            $user_detail['telno'] = $userPhone;
		            $user_detail['email'] = $userEmail;
		            $user_detail['_highlightResult']['employeeName']['value'] = $display_name;
		            $user_detail['_highlightResult']['matchLevel']['value'] = 'none';
		            $user_detail['_highlightResult']['matchedWords']['value'] = array();
		            $user_detail['_highlightResult']['designation']['value'] = $userTitle;
		            $user_detail['_highlightResult']['matchLevel']['value'] = 'none';
		            $user_detail['_highlightResult']['matchedWords']['value'] = array();
		            $user_detail['_highlightResult']['department']['value'] = $departmentName;
		            $user_detail['_highlightResult']['matchLevel']['value'] = 'none';
		            $user_detail['_highlightResult']['matchedWords']['value'] = array();
		            $user_detail['profile_photo'] = "no_user_thumb.png";
		            //$user_detail['profile_photo'] = URL::to("/")."/uploads/user_images/profile_photo/thumbnails/".$user->profile_photo;

		            if($newUser == 'No')
		            {
		                if(trim($userTitle) != trim($user->designation->name) || trim($departmentName) != trim($user->department->name)){
		                    $user_detail['userID'] = $user->id;
		                    if(file_exists(public_path()."/uploads/user_images/profile_photo/thumbnails/".$user->profile_photo)){
		                        $user_detail['profile_photo'] = $user->profile_photo;
		                    } else {
		                        $user_detail['profile_photo'] = "no_user_thumb.png";
		                    }
		                    if($user->profile_photo == '' || $user->profile_photo == NULL)
		                    {
		                        $user_detail['profile_photo'] = "no_user_thumb.png";   
		                    }
		                    else
		                    {
		                        $user_detail['profile_photo'] = $user->profile_photo;
		                    }
		                    $user_detail['objectID'] = $user->ad_username;
		                    $this->algoliaSave($user_detail);
		                }
		            }

		            ///////////////////////////////////////// algolia insert //////////////////////////////////////
		            
		            $user->title       = $userTitle;
		            $user->email       = $userEmail;
		            $user->password    = $password;
		            $user->display_name = $display_name;
		            $user->group_id    = $group_id;
		            $user->company_id  = $company_id;
		            $user->department_id = $department_id;
		            $user->designation_id = $designation_id;
		            $user->mobile = $userPhone;
		            $user->last_login 	= date('y-m-d H:i:s'); 
		            
		            $user->save();



		            if($newUser == 'Yes')
		            { 

		                $user_detail['userID'] = $user->id;
		                if(file_exists(public_path()."/uploads/user_images/profile_photo/thumbnails/".$user->profile_photo)){
		                    $user_detail['profile_photo'] = $user->profile_photo;
		                } else {
		                    $user_detail['profile_photo'] = "no_user_thumb.png";
		                }
		                if($user->profile_photo == '' || $user->profile_photo == NULL)
		                {
		                    $user_detail['profile_photo'] = "no_user_thumb.png";   
		                }
		                else
		                {
		                    $user_detail['profile_photo'] = $user->profile_photo;
		                }
		                
		                $user_detail['objectID'] = $user->ad_username;
		                $this->algoliaSave($user_detail);
		                //$this->group_assign($user->id,$department_id); 
		                //$this->event_assign($user->id,$department_id);
		                $user->attachRole(5);
		                
		            }

		            $auth = auth()->guard('user')->attempt([
		                'email'     => $user->email,
		                'password'  => $password,
		                'status'    => 'Active'
		            ]);            

		            if($auth)
		            {
		               
		                if($user->first_time_login == 'Yes')
		                {
		                    $this->group_assign($user->id,$department_id);
		                    $this->event_assign($user->id,$department_id);
		                    $user->first_time_login = 'No';
		                    $user->save();
		                   
		                    //return \Redirect::Route('afterlogin');
		                    $data['validate'] = 'Success';
		                    $data['redirect_page'] = 'after-login'; 
		                }
		                else
		                {
		                    //return \Redirect::Route('home');   
		                    $data['validate'] = 'Success';
		                    $data['redirect_page'] = '';  
		                }

		                
		            }
		            else
		            {
		                //return \Redirect::back()->with('error','Invalid Username or Password.');
		                $data['validate'] = 'Error';
		                $data['message'] = 'Invalid Username or Password'; 
		            }
		    }

        }
    		
    	}
         //echo "validate";
         echo json_encode($data);
    }

    public function logout()
    { 

        \Auth::guard('user')->logout();
        return \Redirect::Route('login');
    }

    public function group_assign($user_id,$department_id){
        //dd($department_id);
        $dept_id =array();
        array_push($dept_id,$department_id);
        $groups = GroupUser::select('id')->where('group_type_id',1)->get();
        //dd($groups);
        if(!empty($groups)){
             foreach($groups as $group){
               $group_id =$group->id;
               //dd($group_id);
                $groupusercnt = UserGroupUser::where('user_id',$user_id)->where('group_id',$group_id)->count();
                if($groupusercnt==0){
                    $usergroupuser = new UserGroupUser;
                    $usergroupuser->user_id = $user_id;
                    $usergroupuser->group_id = $group_id;   
                    $usergroupuser->save();
                }

             }  
        }

       $groupdept= GroupUser::select('id')->whereIn('department_id',$dept_id)->get();
       if(!empty($groupdept)){
             foreach($groupdept as $groupdpt){
                $group_iddept =$groupdpt->id;
                $groupusercnt = UserGroupUser::where('user_id',$user_id)->where('group_id',$group_iddept)->count();
                if($groupusercnt==0){
                    $usergroupuserd = new UserGroupUser;
                    $usergroupuserd->user_id = $user_id;
                    $usergroupuserd->group_id = $group_iddept;   
                    $usergroupuserd->save();
                }
            }
        }

       
    }

    public function event_assign($user_id,$department_id)
    {
            $global_event = Event::where('type_id','1')->get();
            if(!empty($global_event))
            {
                foreach ($global_event as $key => $event) 
                {                
                    $eventInvite = new EventInvite;
                    $eventInvite->sender_id = $event->user_id;
                    $eventInvite->user_id   = $user_id;
                    $eventInvite->event_id  = $event->id;
                    $eventInvite->save();
                }
            }

            $departmental_event = Event::where('type_id','2')->get();
            if(!empty($departmental_event))
            {
                foreach ($departmental_event as $key => $event) 
                {   
                    if($event->user->departmet->id == $department_id)    
                    {         
                        $eventInvite = new EventInvite;
                        $eventInvite->sender_id = $event->user_id;
                        $eventInvite->user_id   = $user_id;
                        $eventInvite->event_id  = $event->id;
                        $eventInvite->save();
                    }
                }
            }
            
    }
    
}
