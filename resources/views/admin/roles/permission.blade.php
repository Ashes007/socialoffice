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
                  <td colspan="12" align="center">Role: {{$role->display_name}}</td>
                </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <th align="center">Create</th>
                    <th align="center">Edit</th>
                   <!--  <th align="center">Deactive</th> -->
                    <th align="center">Comment / Share</th>
                    <th align="center">Deactive</th>
                    <th align="center">Post</th>
                    <th align="center">Like</th>
                    <th align="center">Invite</th>
                    <th align="center">Leave</th>
                    <th align="center">Delete Posts</th>
                    <th align="center">Delete Comments</th>
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
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['add']['id'], $role->hasPermission($permissions['global-group']['add']['name']), ['class' => '','id'=>'global-group-add']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['edit']['id'], $role->hasPermission($permissions['global-group']['edit']['name']), ['class' => '','id'=>'global-group-edit']) }}</label>
                      </div>
                    </td>
                   <!--  <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['deactive']['id'], $role->hasPermission($permissions['global-group']['deactive']['name']), ['class' => '','id'=>'global-group-deactive']) }}</label>
                      </div>
                    </td> -->
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['commentShare']['id'], $role->hasPermission($permissions['global-group']['commentShare']['name']), ['class' => '','id'=>'global-group-commentShare']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['delete']['id'], $role->hasPermission($permissions['global-group']['delete']['name']), ['class' => '','id'=>'global-group-delete']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['post']['id'], $role->hasPermission($permissions['global-group']['post']['name']), ['class' => '','id'=>'global-group-post']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['like']['id'], $role->hasPermission($permissions['global-group']['like']['name']), ['class' => '','id'=>'global-group-like']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['invite']['id'], $role->hasPermission($permissions['global-group']['invite']['name']), ['class' => '','id'=>'global-group-invite']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['leave']['id'], $role->hasPermission($permissions['global-group']['leave']['name']), ['class' => '','id'=>'global-group-leave']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['post_delete']['id'], $role->hasPermission($permissions['global-group']['post_delete']['name']), ['class' => '','id'=>'global-group-post-delete']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-group']['comment_delete']['id'], $role->hasPermission($permissions['global-group']['comment_delete']['name']), ['class' => '','id'=>'global-group-comment-delete']) }}</label>
                      </div>
                    </td>                                                        
                  </tr> 

                  <tr>
                    <td>Departmental Groups</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['add']['id'], $role->hasPermission($permissions['departmental-group']['add']['name']), ['class' => '','id'=>'departmental-group-add']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['edit']['id'], $role->hasPermission($permissions['departmental-group']['edit']['name']), ['class' => '','id'=>'departmental-group-edit']) }}</label>
                      </div>
                    </td>
                    <!-- <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['deactive']['id'], $role->hasPermission($permissions['departmental-group']['deactive']['name']), ['class' => '','id' =>'departmental-group-deactive']) }}</label>
                      </div>
                    </td> -->
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['commentShare']['id'], $role->hasPermission($permissions['departmental-group']['commentShare']['name']), ['class' => '','id'=>'departmental-group-commentShare']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['delete']['id'], $role->hasPermission($permissions['departmental-group']['delete']['name']), ['class' => '','id'=>'departmental-group-delete']) }}</label>
                      </div>
                    </td> 
                     <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['post']['id'], $role->hasPermission($permissions['departmental-group']['post']['name']), ['class' => '','id'=>'departmental-group-post']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['like']['id'], $role->hasPermission($permissions['departmental-group']['like']['name']), ['class' => '','id'=>'departmental-group-like']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['invite']['id'], $role->hasPermission($permissions['departmental-group']['invite']['name']), ['class' => '','id'=>'departmental-group-invite']) }}</label>
                      </div>
                    </td>   
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['leave']['id'], $role->hasPermission($permissions['departmental-group']['leave']['name']), ['class' => '','id'=>'departmental-group-leave']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['post_delete']['id'], $role->hasPermission($permissions['departmental-group']['post_delete']['name']), ['class' => '','id'=>'departmental-group-post-delete']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-group']['comment_delete']['id'], $role->hasPermission($permissions['departmental-group']['comment_delete']['name']), ['class' => '','id'=>'departmental-group-comment-delete']) }}</label>
                      </div>
                    </td>                                                               
                  </tr> 
                   <tr>
                    <td>Activity Groups</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['add']['id'], $role->hasPermission($permissions['activity-group']['add']['name']), ['class' => '','id'=>'activity-group-add']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['edit']['id'], $role->hasPermission($permissions['activity-group']['edit']['name']), ['class' => '','id'=>'activity-group-edit']) }}</label>
                      </div>
                    </td>
                   <!--  <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['deactive']['id'], $role->hasPermission($permissions['activity-group']['deactive']['name']), ['class' => '','id'=>'activity-group-deactive']) }}</label>
                      </div>
                    </td> -->
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['commentShare']['id'], $role->hasPermission($permissions['activity-group']['commentShare']['name']), ['class' => '','id'=>'activity-group-commentShare']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['delete']['id'], $role->hasPermission($permissions['activity-group']['delete']['name']), ['class' => '','id'=>'activity-group-delete']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['post']['id'], $role->hasPermission($permissions['activity-group']['post']['name']), ['class' => '','id'=>'activity-group-post']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['like']['id'], $role->hasPermission($permissions['activity-group']['like']['name']), ['class' => '','id'=>'activity-group-like']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['invite']['id'], $role->hasPermission($permissions['activity-group']['invite']['name']), ['class' => '','id'=>'activity-group-invite']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['leave']['id'], $role->hasPermission($permissions['activity-group']['leave']['name']), ['class' => '','id'=>'activity-group-leave']) }}</label>
                      </div>
                    </td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['post_delete']['id'], $role->hasPermission($permissions['activity-group']['post_delete']['name']), ['class' => '','id'=>'activity-group-post-delete']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-group']['comment_delete']['id'], $role->hasPermission($permissions['activity-group']['comment_delete']['name']), ['class' => '','id'=>'activity-group-comment-delete']) }}</label>
                      </div>
                    </td>                                                          
                  </tr> 
                  <!---------------------------------------------- -->



                  <tr>
                    <td>Global Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['add']['id'], $role->hasPermission($permissions['global-event']['add']['name']), ['class' => '','id'=>'global-event-add']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      
                    </td>
                    <!-- <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['deactive']['id'], $role->hasPermission($permissions['global-event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> -->
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['commentShare']['id'], $role->hasPermission($permissions['global-event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['delete']['id'], $role->hasPermission($permissions['global-event']['delete']['name']), ['class' => '','id'=>'global-event-delete']) }}</label>
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
                    <td  align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['invite']['id'], $role->hasPermission($permissions['global-event']['invite']['name']), ['class' => '','id'=>'global-event-invite']) }}</label>
                      </div>
                    </td> 
                    <td></td> 
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['post_delete']['id'], $role->hasPermission($permissions['global-event']['post_delete']['name']), ['class' => '','id'=>'global-event-post-delete']) }}</label>
                      </div>
                    </td>  
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['global-event']['comment_delete']['id'], $role->hasPermission($permissions['global-event']['comment_delete']['name']), ['class' => '','id'=>'global-event-comment-delete']) }}</label>
                      </div>
                    </td>                                                          
                  </tr> 

                  <tr>
                    <td>Departmental Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['add']['id'], $role->hasPermission($permissions['departmental-event']['add']['name']), ['class' => '','id'=>'departmental-event-add']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      
                    </td>
                    <!-- <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['deactive']['id'], $role->hasPermission($permissions['departmental-event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> -->
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['commentShare']['id'], $role->hasPermission($permissions['departmental-event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['delete']['id'], $role->hasPermission($permissions['departmental-event']['delete']['name']), ['class' => '','id'=>'departmental-event-delete']) }}</label>
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
                    <td  align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['invite']['id'], $role->hasPermission($permissions['departmental-event']['invite']['name']), ['class' => '','id'=>'departmental-event-invite']) }}</label>
                      </div>
                    </td>  
                    <td></td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['post_delete']['id'], $role->hasPermission($permissions['departmental-event']['post_delete']['name']), ['class' => '','id'=>'departmental-event-post-delete']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['departmental-event']['comment_delete']['id'], $role->hasPermission($permissions['departmental-event']['comment_delete']['name']), ['class' => '','id'=>'departmental-event-comment-delete']) }}</label>
                      </div>
                    </td>                                                            
                  </tr> 
                   <tr>
                    <td>Activity Events</td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['add']['id'], $role->hasPermission($permissions['activity-event']['add']['name']), ['class' => '','id'=>'activity-event-add']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      
                    </td>
                    <!-- <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['deactive']['id'], $role->hasPermission($permissions['activity-event']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> -->
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['commentShare']['id'], $role->hasPermission($permissions['activity-event']['commentShare']['name']), ['class' => '']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['delete']['id'], $role->hasPermission($permissions['activity-event']['delete']['name']), ['class' => '','id'=>'activity-event-delete']) }}</label>
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
                    <td  align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['invite']['id'], $role->hasPermission($permissions['activity-event']['invite']['name']), ['class' => '','id'=>'activity-event-invite']) }}</label>
                      </div>
                    </td>
                    <td></td>   
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['post_delete']['id'], $role->hasPermission($permissions['activity-event']['post_delete']['name']), ['class' => '','id'=>'activity-event-post-delete']) }}</label>
                      </div>
                    </td>
                    <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['activity-event']['comment_delete']['id'], $role->hasPermission($permissions['activity-event']['comment_delete']['name']), ['class' => '','id'=>'activity-event-comment-delete']) }}</label>
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
                   <!--  <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['poll']['deactive']['id'], $role->hasPermission($permissions['poll']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> -->
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
                    <td></td>
                    <td></td> 
                    <td></td> 
                    <td></td> 
                    <td></td>                                                        
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
                   <!--  <td align="center">
                      <div class="checkbox icheck">
                        <label>{{ Form::checkbox('permission[]', $permissions['survey']['deactive']['id'], $role->hasPermission($permissions['survey']['deactive']['name']), ['class' => '']) }}</label>
                      </div>
                    </td> -->
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
                    <td></td>
                    <td></td> 
                    <td></td> 
                    <td></td> 
                    <td></td>                                                           
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
<script>
  $(document).ready(function() {
    var chk1 = $('#global-group-add');
    var chk2 = $('#global-group-edit');
    var chk3 = $('#global-group-delete');
    chk1.on('change', function(){
    chk2.prop('checked',this.checked);
    chk3.prop('checked',this.checked);
    });

    var chk4 = $('#departmental-group-add');
    var chk5 = $('#departmental-group-edit');
    var chk6 = $('#departmental-group-delete');
    chk4.on('change', function(){
    chk5.prop('checked',this.checked);
    chk6.prop('checked',this.checked);
    });

    var chk7 = $('#activity-group-add');
    var chk8 = $('#activity-group-edit');
    var chk9 = $('#activity-group-delete');
    chk7.on('change', function(){
    chk8.prop('checked',this.checked);
    chk9.prop('checked',this.checked);
    });


    var chk10 = $('#global-event-add');
    var chk11 = $('#global-event-delete');
    
    chk10.on('change', function(){
    chk11.prop('checked',this.checked);
    
    });

    var chk12 = $('#departmental-event-add');    
    var chk13 = $('#departmental-event-delete');
    chk12.on('change', function(){
    chk13.prop('checked',this.checked);
   
    });
    var chk14 = $('#activity-event-add');    
    var chk15 = $('#activity-event-delete');
    chk14.on('change', function(){
    chk15.prop('checked',this.checked);
   
    });

    var chk16 = $('#global-group-post-delete');    
    var chk17 = $('#global-group-comment-delete');
    chk16.on('change', function(){
    chk17.prop('checked',this.checked);   
    });

    var chk18 = $('#departmental-group-post-delete');    
    var chk19 = $('#departmental-group-comment-delete');
    chk18.on('change', function(){
    chk19.prop('checked',this.checked);   
    });

    var chk20 = $('#activity-group-post-delete');    
    var chk21 = $('#activity-group-comment-delete');
    chk20.on('change', function(){
    chk21.prop('checked',this.checked);   
    });


  });
  </script>

  @endsection