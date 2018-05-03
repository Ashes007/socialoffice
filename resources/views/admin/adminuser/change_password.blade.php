@extends('admin/innertemplate')
@section('title','Change Password')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket changes_pwd_box">
            <!--<div class="box-header with-border">
            </div>-->

            @include('admin.includes.messages')
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('route'=>['admin_update_password'], 'class'=>'form-horizontal form-validate','method'=>'post')) !!}

              <div class="box-body">
                
                <div class="row">              
                <div class="col-md-12">
                <div class="form-group">
                  <label for="name" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 control-label">Current password: <span>*</span></label>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! Form::password('current_password',array('class'=>'form-control required','placeholder'=>'Enter your current password'))!!}
                  </div>
                </div>                  
                </div>


                <div class="col-md-12">
                <div class="form-group">
                  <label for="name" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 control-label">New password: <span>*</span></label>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! Form::password('password',array('class'=>'form-control required','placeholder'=>'Enter your password','id'=>'password'))!!}
                  </div>
                </div>                  
                </div>                
                </div>
                <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="name" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 control-label">Confirm Password: <span>*</span></label>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! Form::password('password_confirmation',array('class'=>'form-control required','placeholder'=>'Confirm your password'))!!}
                  </div>
                </div>                  
                </div>                    
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('admin_dashboard') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            {!! Form::close() !!} 
          </div>
          <!-- /.box -->

      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection