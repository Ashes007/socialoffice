@extends('admin.login')
@section('title', 'Forgot Password')
@section('content')
    
<div class="login-box">
  <div class="login-logo logo">
    <a href="../../index2.html"><img src="{{ asset('backend/dist/img/logo.png') }}" alt=""></a>
    <p>Forgot Password</p>
  </div>
  @include('admin.includes.messages')
  <div class="login-box-body">
    {!! Form::open(array('route'=>'admin_forgot_password_action','class'=>'form','novalidate'))!!}
      <div class="form-group has-feedback field-wrap">
        {!! Form::email('email', '', ['id' => 'email', 'class' => 'form-control input-field', 'placeholder' => 'Email address', 'required', 'autocomplete' => 'off']) !!}
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
        <div class="field-wrap text-center">
          <button type="submit" class="submit-btn">Submit</button>
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