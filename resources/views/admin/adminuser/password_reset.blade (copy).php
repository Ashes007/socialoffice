@extends('admin.layouts.login')
@section('title', 'Reset Password')
@section('content')
    
    <div class="container">	
		<div class="row">
			<div class="account-col text-center">
				<h1>Gift Cash - Admin</h1>
				<h3>Reset Password</h3>
				{!! Form::open(array('route'=>array('admin_password_update',$token),'class'=>'form','novalidate'))!!}
					{{-- messages section start--}}
					@include('admin.includes.messages')
					{{-- messages section end--}}
					
					<div class="form-group">
						{!! Form::password('password', ['class'=>'form-control required', 'data-rule-minlength'=>'6', 'data-msg-minlength'=>'Password needs at least 6 characters', 'id'=>'password', 'placeholder' => 'New Password', 'autocomplete' => 'off']) !!}
					</div>
						
					<div class="form-group">
						{!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control required', 'placeholder' => 'Confirm Password', 'autocomplete' => 'off']) !!}
					</div>						

					<button type="submit" class="btn btn-primary btn-block ">Reset Password</button>
					<a href="{{ URL::route('admin_login') }}"><small>Back To Login</small></a>                
					<p>Gift Cash Admin &copy; {{ date('Y') }}</p>
				{!! Form::close() !!}
			</div>
		</div>	
    </div>
		
@endsection    