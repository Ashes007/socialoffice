@extends('front.layout.login_layout')
@section('title','Login')
@section('content') 

   <div class="login-wrap">
     <div class="login-box">
      <div class="logo"><img src="{{ asset('frontend/images/logo.png') }}" alt="">
         <p>{{ trans('userLogin.Access_your_account') }}</p>
      </div>
      <div class="log-field">
      <div class="field-wrap">
      <span class="icons"><img src="{{ asset('frontend/images/log-icon1.png') }}" alt=""></span>
         <input class="input-field animate_login" id="username" type="text" name="" value="" placeholder="{{ trans('userLogin.username') }}">
      </div>
      <div class="field-wrap">
      <span class="icons"><img src="{{ asset('frontend/images/log-icon2.png') }}" alt=""></span>
         <input class="input-field animate_login" id="password" type="password" name="" value="" placeholder="{{ trans('userLogin.password') }}">
      </div>

      <!--<p class="forgot-pass text-center"><a data-toggle="modal" data-target="#uploadphoto" href="#">Forgot?</a></p>-->
      <div class="log-sub">
        <!--<input class="submit-btn" type="submit" name="" value="Login">-->
        <a href="javascript:void(0)"  id="btn-loading-animation">{{ trans('userLogin.login') }}</a>
      </div>

      <div id="error_msg" class="error_msg">&nbsp;</div>
      </div>
     </div>
   </div>

@endsection