@extends('admin/login')
@section('title', 'Reset Password')
@section('content')
    
<div class="login-box">
  <div class="login-logo logo">
    <a href="../../index2.html"><img src="{{ asset('backend/dist/img/logo.png') }}" alt=""></a>
    <p>Reset Password</p>
  </div>
  @include('admin.includes.messages')
  <div class="login-box-body">
    {!! Form::open(array('route'=>array('admin_password_update',$token),'class'=>'form','novalidate'))!!}
      <div class="form-group has-feedback field-wrap">
        {!! Form::password('password', ['class'=>'form-control input-field required', 'data-rule-minlength'=>'6', 'data-msg-minlength'=>'Password needs at least 6 characters', 'id'=>'password', 'placeholder' => 'New Password', 'autocomplete' => 'off']) !!}
      </div>
      <div class="form-group has-feedback field-wrap">
        {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control input-field required', 'placeholder' => 'Confirm Password', 'autocomplete' => 'off']) !!}
      </div>      
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
        <div class="field-wrap text-center">
          <button type="submit" class="submit-btn">Reset Password</button>
          <p>
             <a href="{{ URL::route('admin_login') }}"><small>Back To Login</small></a> 
         </p>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}
    <!-- <a href="#">I forgot my password</a><br> -->
  </div>
  <!-- /.login-box-body -->
</div>

@endsection    
   