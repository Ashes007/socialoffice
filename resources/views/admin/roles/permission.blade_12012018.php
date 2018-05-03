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
                    <th align="center">Post</th>
                    <th align="center">Like</th>
                  </tr>
                  <!--<tr>
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
                  </tr>-->
                <!--------------------------------------------- -->

                 <tr>
                    <td>Global Groups</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['add']['id'], $role->hasPermission($permissions['global-group']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['edit']['id'], $role->hasPermission($permissions['global-group']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['deactive']['id'], $role->hasPermission($permissions['global-group']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['commentShare']['id'], $role->hasPermission($permissions['global-group']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['delete']['id'], $role->hasPermission($permissions['global-group']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['post']['id'], $role->hasPermission($permissions['global-group']['post']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['like']['id'], $role->hasPermission($permissions['global-group']['like']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                           
                  </tr> 

                  <tr>
                    <td>Departmental Groups</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['add']['id'], $role->hasPermission($permissions['departmental-group']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['edit']['id'], $role->hasPermission($permissions['departmental-group']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['deactive']['id'], $role->hasPermission($permissions['departmental-group']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['commentShare']['id'], $role->hasPermission($permissions['departmental-group']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['delete']['id'], $role->hasPermission($permissions['departmental-group']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> 
                     <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['post']['id'], $role->hasPermission($permissions['departmental-group']['post']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['like']['id'], $role->hasPermission($permissions['departmental-group']['like']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                             
                  </tr> 
                   <tr>
                    <td>Activity Groups</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['add']['id'], $role->hasPermission($permissions['activity-group']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['edit']['id'], $role->hasPermission($permissions['activity-group']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['deactive']['id'], $role->hasPermission($permissions['activity-group']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['commentShare']['id'], $role->hasPermission($permissions['activity-group']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['delete']['id'], $role->hasPermission($permissions['activity-group']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['post']['id'], $role->hasPermission($permissions['activity-group']['post']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['like']['id'], $role->hasPermission($permissions['activity-group']['like']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                            
                  </tr> 
                  <!---------------------------------------------- -->



                  <tr>
                    <td>Global Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['add']['id'], $role->hasPermission($permissions['global-event']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['edit']['id'], $role->hasPermission($permissions['global-event']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['deactive']['id'], $role->hasPermission($permissions['global-event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['commentShare']['id'], $role->hasPermission($permissions['global-event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['delete']['id'], $role->hasPermission($permissions['global-event']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['post']['id'], $role->hasPermission($permissions['global-event']['post']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['like']['id'], $role->hasPermission($permissions['global-event']['like']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                           
                  </tr> 

                  <tr>
                    <td>Departmental Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['add']['id'], $role->hasPermission($permissions['departmental-event']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['edit']['id'], $role->hasPermission($permissions['departmental-event']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['deactive']['id'], $role->hasPermission($permissions['departmental-event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['commentShare']['id'], $role->hasPermission($permissions['departmental-event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['delete']['id'], $role->hasPermission($permissions['departmental-event']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> 
                     <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['post']['id'], $role->hasPermission($permissions['departmental-event']['post']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['like']['id'], $role->hasPermission($permissions['departmental-event']['like']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                             
                  </tr> 
                   <tr>
                    <td>Activity Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['add']['id'], $role->hasPermission($permissions['activity-event']['add']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['edit']['id'], $role->hasPermission($permissions['activity-event']['edit']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['deactive']['id'], $role->hasPermission($permissions['activity-event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['commentShare']['id'], $role->hasPermission($permissions['activity-event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['delete']['id'], $role->hasPermission($permissions['activity-event']['delete']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['post']['id'], $role->hasPermission($permissions['activity-event']['post']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['like']['id'], $role->hasPermission($permissions['activity-event']['like']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>                                                            
                  </tr> 

                  <!-- ---------------------------------------- -->  


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
                    <td>&nbsp;</td>                                                           
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
                    <td>&nbsp;</td>                                                            
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