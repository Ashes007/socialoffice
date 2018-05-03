@extends('admin/innertemplate')
@section('title','User Assign Roles')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Assign Roles
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('user_list') }}">User List</a></li>
        <li class="active">Assign Roles</li>
      </ol>
    </section>

   

    <!-- Main content -->
    <section class="content">
      
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket">
            <div class="box-header">   
            @if(session()->has('succmsg'))
              <div class="alert alert-success">
                  {{ session()->get('succmsg') }}
              </div>
          @endif   
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('id'=>'', 'class'=>'form-validate','method'=>'post')) !!} 
              <div class="box-body"> 
              
              <div class="form-group">
                <div class="row">                
                @foreach($roles  as $role)
                

                  <div class="col-md-3 cheiking rdo_area">
                   <!-- {{-- Form::checkbox('role[]', $role->id, $user->hasRole($role->name), ['class' => '']) --}} -->
                   {{ Form::radio('role', $role->id, $user->hasRole($role->name), ['class' => '']) }}
                   <label for="checkbox1">{{ $role->display_name }}</label>
                   
                  </div>
                
                @endforeach 
                
                 </div>
                </div>          

              </div>
          


              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('user_list') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
            {!! Form::close() !!} 
              <!-- /.box-footer -->
          </div>
          <!-- /.box -->

      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection