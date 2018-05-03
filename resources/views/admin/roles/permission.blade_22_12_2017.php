@extends('admin/innertemplate')
@section('title','Role Permission')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Role Permission
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('role_list') }}">Role</a></li>
        <li class="active">Add/Edit</li>
      </ol>
    </section>

   

    <!-- Main content -->
    <section class="content">
      
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket">
            <div class="box-header">    
            </div>
            @include('admin.includes.messages')
            <!-- /.box-header -->
            <!-- form start -->
          {!! Form::open(array('id'=>'', 'class'=>'form-horizontal form-validate','method'=>'post')) !!}  
              <div class="box-body"> 
              <div class="data-table table-responsive permison">
              
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="6" align="center">Role: {{$role->display_name}}</td>
                </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <th align="center">Create</th>
                    <th align="center">Edit</th>
                    <th align="center">Deactive</th>
                    <th align="center">Comment / Share</th>
                    <th align="center">Delete</th>
                  </tr>
                  <tr>
                    <td>Groups</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['group']['add']['id'], $role->hasPermission($permissions['group']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['group']['edit']['id'], $role->hasPermission($permissions['group']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['group']['deactive']['id'], $role->hasPermission($permissions['group']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        &nbsp;
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['group']['delete']['id'], $role->hasPermission($permissions['group']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                            
                  </tr>                  
                  <tr>
                    <td>Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
              		      <label>{{ Form::checkbox('permission[]', $permissions['event']['add']['id'], $role->hasPermission($permissions['event']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['event']['edit']['id'], $role->hasPermission($permissions['event']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['event']['deactive']['id'], $role->hasPermission($permissions['event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['event']['commentShare']['id'], $role->hasPermission($permissions['event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['event']['delete']['id'], $role->hasPermission($permissions['event']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                            
                  </tr>
                  <tr>
                    <td>Polls</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['poll']['add']['id'], $role->hasPermission($permissions['poll']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['poll']['edit']['id'], $role->hasPermission($permissions['poll']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['poll']['deactive']['id'], $role->hasPermission($permissions['poll']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['poll']['commentShare']['id'], $role->hasPermission($permissions['poll']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['poll']['delete']['id'], $role->hasPermission($permissions['poll']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                            
                  </tr>
                  <tr>
                    <td>Survey</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['survey']['add']['id'], $role->hasPermission($permissions['survey']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['survey']['edit']['id'], $role->hasPermission($permissions['survey']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['survey']['deactive']['id'], $role->hasPermission($permissions['survey']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['survey']['commentShare']['id'], $role->hasPermission($permissions['survey']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['survey']['delete']['id'], $role->hasPermission($permissions['survey']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                            
                  </tr>                                    
                </table>


              </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('role_list') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
            {!! Form::close() !!} 
              <!-- /.box-footer -->
                

          </div>
          <!-- /.box -->

      <!-- /.row -->


    <!-- /.content -->


  @endsection