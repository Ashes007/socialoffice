<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;


class LoginController extends Controller
{
    public function login()
    {
        if(\Auth::guard('admin')->check()){    
            return \Redirect::route('user_list');
        }else{
            return view('admin.adminuser.login');
        }
    	
    }

    public function dologin(Request $request)
    {
    	$Validator = Validator::make($request->all(),[
    			'email' 	=> 'required',
    			'password'	=> 'required'
    		]);

    	if($Validator->fails())
    	{
    		$request->session()->flash('error','Please Enter All Fields');
    		return \Redirect('login')->withErrors($Validator);
    	}
    	else
    	{

            $checkUserstatus = User::where('email', $request->input('email'))->where('status','Active')->wherehas('roleuser', function($q){
                $q->where('role_id', 1);
            })->first();

            if( count($checkUserstatus) > 0 ){
                $auth = auth()->guard('admin')->attempt([
                    'email'     => $request->input('email'),
                    'password'  => $request->input('password')
                ]);

                if($auth)
                {
                    return \Redirect::Route('user_list');
                }
                else
                {
                    $request->session()->flash('error','Invalid Username or Password');
                    return \Redirect::Route('admin_login');
                }                
            }else{
                $request->session()->flash('error','You are not an authorized user');
                return \Redirect::Route('admin_login');                
            }


    	}
    }

    public function logout()
    {
        \Auth::guard('admin')->logout();
    	return \Redirect::Route('admin_login');
    }
}
