@extends('admin/innertemplate')
@section('title','User Details')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('user_list') }}">User List</a></li>
        <li class="active">details</li>
      </ol>
    </section>

   

    <!-- Main content -->
    <section class="content">
      
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket">
            <div class="box-header">     
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          
              <div class="box-body user-list">
              
              <div class="row">
              
              	<div class="col-md-6">
                

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Display Name</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $details->display_name }}
                  </div>
                  </div>
                </div>

                @if($details->roles->count()>0)
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Role</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $details->roles[0]->display_name }}
                  </div>
                  </div>
                </div>
                @endif
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Title</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    @if($details->designation != NULL) {{ $details->designation->name }} @endif
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Birth Day</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                  @if($details->date_of_birth != NULL)
                    {{ \DateTime::createFromFormat('Y-m-d', $details->date_of_birth)->format('d/m') }}
                  @endif
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Date Of Join</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                  @if($details->date_of_joining != NULL)
                    {{ \DateTime::createFromFormat('Y-m-d', $details->date_of_joining)->format('d/m/Y') }}
                  @endif
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Mobile</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $details->mobile }}
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Email</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $details->email }}
                  </div>
                  </div>
                </div>

                

                </div>
                
                <div class="col-md-6">
                
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Company</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                   @if($details->company != NULL) {{ $details->company->name }} @endif
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Department</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                   @if($details->department != NULL) {{ $details->department->name }} @endif
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">About</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $details->description }}
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Status</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $details->status }}
                  </div>
                  </div>
                </div>

                
                </div>             
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default pull-right" href="{{ URL::Route('user_list') }}">Back</a>
                
              </div>
              <!-- /.box-footer -->
          </div>
          <!-- /.box -->

      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection