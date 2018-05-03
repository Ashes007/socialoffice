@extends('front.layout.login_layout')
@section('title','Login')
@section('content') 

   <div class="login-wrap">
     <div class="login-box">
      <div class="logo"> <a href="home.html"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a>
         <p>Access your account</p>
      </div>
      <div class="log-field">
      <div class="field-wrap">
      <span class="icons"><img src="{{ asset('frontend/images/log-icon1.png') }}" alt=""></span>
         <input class="input-field" id="username" type="text" name="" value="" placeholder="User Name">
      </div>
      <div class="field-wrap">
      <span class="icons"><img src="{{ asset('frontend/images/log-icon2.png') }}" alt=""></span>
         <input class="input-field" id="password" type="password" name="" value="" placeholder="Password">
      </div>

      <!--<p class="forgot-pass text-center"><a data-toggle="modal" data-target="#uploadphoto" href="#">Forgot?</a></p>-->
      <div class="log-sub">
        <!--<input class="submit-btn" type="submit" name="" value="Login">-->
        <a href="javascript:void(0)" id="btn-loading-animation">Login</a>
      </div>

      <div id="error_msg" class="error_msg"></div>
      </div>
     </div>
   </div>

@endsection