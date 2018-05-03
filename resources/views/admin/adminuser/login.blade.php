@extends('admin/login')
@section('title','Tawasul | Log in')
@section('content')

<div class="login-box">
  <div class="login-logo logo">
    <a href="../../index2.html"><img src="{{ asset('backend/dist/img/logo-black.png') }}" alt=""></a>
    <p>Access your account</p>
  </div>
  @include('admin.includes.messages')
  <div class="login-box-body">
    <form action="" method="post">
    {{ csrf_field() }}
      <div class="form-group has-feedback field-wrap">
        <input type="email" name="email" class="form-control input-field" placeholder="Email" required >
      </div>
      <div class="form-group has-feedback field-wrap">
        <input type="password" name="password" class="form-control input-field" placeholder="Password" required>
      </div>
      <p class="forgot-pass text-center"><a href="{{ route('admin_forgot_password') }}">Forgot Password?</a></p>
      <div class="row">
        <!--<div class="col-xs-8">
           <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-12">
        <div class="field-wrap text-center">
          <button type="submit" class="submit-btn">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!-- <a href="#">I forgot my password</a><br> -->
  </div>
  <!-- /.login-box-body -->
</div>

@endsection