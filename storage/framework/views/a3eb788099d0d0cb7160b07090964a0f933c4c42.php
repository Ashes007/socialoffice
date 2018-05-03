<?php $__env->startSection('title', $management.' '.$pageType); ?>
<?php $__env->startSection('content'); ?>

  <section class="content-header">
    <h1><?php echo e($management.' '.$pageType); ?> </h1>
    <ol class="breadcrumb">
        <?php $__currentLoopData = $breadcrumb['LISTPAGE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eachBreadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->first): ?>
                <li><a href="<?php echo e(route('admin_dashboard')); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <?php endif; ?>
            <?php if($eachBreadcrumb['url'] == 'THIS'): ?>
                <li><?php echo e($eachBreadcrumb['label']); ?></li>    
            <?php else: ?>
                <li><a href="<?php echo e($eachBreadcrumb['url']); ?>"><?php echo e($eachBreadcrumb['label']); ?></a></li>  
            <?php endif; ?>                                                        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
    <div class="col-xs-12">
	   <?php echo $__env->make('admin.includes.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="btn btn-default pull-right button-custom">
    <a  href="<?php echo e(URL::Route('event_add')); ?>"><i class="fa fa-plus"> Add</i></a>
    </div>
    </div>
    
      <div class="col-xs-12">
        
        <!-- /.box -->

        <div class="box">
          
          <!-- /.box-header -->
          <div class="box-body new-padding new-marg">
          <div class="data-table table-responsive">
            <table id="eventTable" class="table">
              <thead>
              <tr>
                <th>Department</th>
                <th>Name</th> 
                <th>Type</th>
                <th>Start date</th>
                <th>End date</th> 
                <th>Event Time</th> 
                <th>Event Creator</th>                                 
                <th>Status</th>
                <th class="no-sort">Action</th>
              </tr>
              </thead>
              <tbody>
              <?php if($event_list->count()>0): ?>	
              <?php $__currentLoopData = $event_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e(getDepartmentName($event->user->department_id)); ?></td>
                <td><?php echo e($event->name); ?></td>
                <td><?php echo e($event->eventtype->name); ?></td> 
                <td><?php echo e(\Carbon\Carbon::parse($event->event_start_date)->format('dS M Y')); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($event->event_end_date)->format('dS M Y')); ?></td>
                <td><?php if($event->allday_event == 'Yes'): ?> All Day <?php else: ?> <?php echo e($event->start_time); ?> - <?php echo e($event->end_time); ?> <?php endif; ?></td>   
                <td><?php echo e($event->user->display_name); ?></td>              
                <td align="center">
                <div class="link linklistgroup">

                <?php if($event->status == 'Inactive'): ?>
                  <span class="inactiveStatus">
                  <a href="javascript:void(0)" class="event_status link approveLink"  data-id="<?php echo e($event->id); ?>" data-status="Active" data-model="Event" title="Click to approve Status">
                    <span class="ion-checkmark"></span>
                  </a>
                  <a href="javascript:void(0)" class="event_status_inactive link disapproveLink" data-id="<?php echo e($event->id); ?>" data-status="Disapprove" data-model="Event" title="Click to disapprove Status">
                    <span class="ion-android-close"></span>
                  </a>
                  </span>
                <?php elseif($event->status == 'Active'): ?> 
                <span class="activeStatus">  
                  <a href="javascript:void(0)" class="event_status_inactive link" data-id="<?php echo e($event->id); ?>" data-status="Disapprove" data-model="Event" title="Click to change Status">
                      <span class="ion-checkmark"></span>
                  </a>
                </span>
                <?php else: ?>  
                <span class="inactiveStatus">                  
                  <a href="javascript:void(0)" class="event_status link" data-id="<?php echo e($event->id); ?>" data-status="Active" data-model="Event" title="Click to change Status">
                      <span class="ion-android-close"></span>
                  </a>
                  <i class="fa fa-info-circle" data-toggle="tooltip" title = "<?php echo e($event->disapprove_reason); ?>"></i>
                </span>
                <?php endif; ?>
                </div>
                
                </td>
                <td align="center"> <a class="link" href="<?php echo e(URL::Route('event_edit', $event->id)); ?>" title="Edit"><i class="fa fa-edit"></i></a>
                 <a class="link del" onClick="destroyData('<?php echo e(URL::Route('event_delete', $event->id)); ?>')" href="javascript:void(0)"  title="Delete"> <i class="fa fa-trash"></i> </a>
                 <?php if(havePostEventGroup($event->id,'Event')>0): ?><a class="link" href="<?php echo e(URL::Route('event_posts', $event->id)); ?>" data-toggle="tooltip" title="View Post"><i class="fa fa-folder"></i></a><?php endif; ?>
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