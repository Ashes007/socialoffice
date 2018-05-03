<?php $__env->startSection('title','User List'); ?>
<?php $__env->startSection('content'); ?>

    <section class="content-header">

       <h1>
        User list
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo e(route('admin_dashboard')); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        <?php echo $__env->make('admin.includes.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- <div class="btn btn-default pull-right button-custom">
        <a  href="<?php echo e(URL::Route('user_sync')); ?>"><i class="fa fa-refresh"> Sync</i></a>
        </div> -->
      </div>

        <div class="col-xs-12">
          
          <!-- /.box -->

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body new-padding new-marg">
            	<div class="data-table table-responsive">
              <table id="dataTable" class="table">
                <thead>
                <tr>
                  <th width="30">Display name</th>
                  <th width="30">Title</th>
                  <th width="15">Email</th>
                  <th width="10" class="no-sort" style="text-align: center;">Status</th>
                  <th width="20" class="no-sort">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if($user_list->count()>0): ?>	 
                <?php $__currentLoopData = $user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($user->display_name); ?></td>
                  <td><?php echo e($user->title); ?></td>
                  <td> <?php echo e($user->email); ?> </td>
                  <td align="center"><a href="javascript:void(0)" class="status link" data-model = "User" data-id="<?php echo e($user->id); ?>"  data-toggle="tooltip" title="Click to change Status">
                  <?php if($user->status == 'Active'): ?> <span class="ion-checkmark"></span>
                  <?php else: ?>
                  <span class="ion-android-close"></span>
                  <?php endif; ?>
                  </a> </td> 
                  <td align="center"><a class="link edits" href="<?php echo e(URL::Route('user_details',$user->id )); ?>" data-toggle="tooltip" class="user_view" title="Click to view details"><span class="ion-eye"></span> </a> 
                  <a class="link edits" href="<?php echo e(URL::Route('user_addedit_role',$user->id )); ?>" data-toggle="tooltip" class="user_view" title="Click to assign role"><span class="fa fa-group"></span> </a> 
                   <?php if(havePostEventGroup($user->id,'Wish')>0): ?><a class="link" href="<?php echo e(URL::Route('occasion_list', $user->id)); ?>" data-toggle="tooltip" title="View occasion wishes"><i class="fa fa-folder"></i></a><?php endif; ?>
                  </td>   
                  
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                
                </tbody>
                
              </table>
              	</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>


  <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.innertemplate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>