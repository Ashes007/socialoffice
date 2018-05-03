<?php if(count($groups)>0): ?>
  <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php  
  //echo $group->group_user_id;
  // $group_id = base64_encode($group->group_id + 100);
  $group_id = encrypt($group->group_user_id);
  ?>
  <div class="col-sm-4 col-xs-6">
    <div class="photo-single group-areas">
      <div class="group-img">
      <a href="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>">
      <?php if(file_exists( public_path('uploads/group_images/thumb/'.$group->cover_image) )&& ($group->cover_image!='' || $group->cover_image!=NULL)) {?>               
      <img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/group_images/'.$group->cover_image)); ?>&w=356&h=200&q=100"  alt="" class="big-img" />
      <?php }else{ ?>
      <img src="<?php echo e(asset('frontend/images/no-image-event-list.jpg')); ?>"  class="big-img"/>
      <?php  } ?>
      </a>
      <!-- <?php if(request()->segment(2)!=''&& request()->segment(2)!='all'): ?>
      <img src="<?php echo e(asset('frontend/images/sg-1.jpg')); ?>" alt="" class="small-img"/> 
      <?php endif; ?> -->
      </div>
      <h3><a href="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>"><?php echo e(substr($group->group_name,0,52)); ?>  <?php if(strlen($group->group_name)>52): ?> ... <?php endif; ?></a></h3>
      <h5><?php echo e(get_memeber_group( $group->group_user_id)); ?> <?php echo e(trans('group.members')); ?></h5>
      <?php $group_desc = getDetailsGroupEvent($group->group_description) ?>
      <p><?php echo substr($group_desc,0,80) ?> <?php if(strlen($group->group_description)>80): ?> ... <?php endif; ?></p>
      <span class="week-active"><?php echo e(trans('common.active')); ?> <?php echo e(active_memeber_group($group->created_at)); ?> <?php echo e(trans('common.ago')); ?> / <label>
      <?php if($group_type!='all'): ?>
      <?php echo e(trans('group.'.$group_type)); ?> 
      <?php else: ?>
      <?php if($group->group_type_id==1): ?> <?php echo e(trans('group.global_group')); ?> <?php echo e(trans('common.Groups')); ?> <?php elseif($group->group_type_id==2): ?> <?php echo e(trans('group.departmental_group')); ?> <?php echo e(trans('common.Groups')); ?> <?php else: ?> <?php echo e(trans('group.activity_group')); ?> <?php echo e(trans('common.Groups')); ?> <?php endif; ?>
      <?php endif; ?>
      </label></span>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>