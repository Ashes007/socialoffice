<?php if(count($header_notifications)>0): ?> 
<?php $__currentLoopData = $header_notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h_notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$model=array();
$model_event=array();
$model = $h_notification->groups;
$model_event = $h_notification->events;
$today = date('Y-m-d');
?>
<div class="timelineBlock groupblock">
<div class="notify-postedBy">
<div class="postedTime-image">
<?php if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' || $h_notification->notificationable_type=='GroupInsert'|| $h_notification->notificationable_type=='GroupUpdate'|| $h_notification->notificationable_type=='GroupDelete' || $h_notification->notificationable_type=='GroupAccept'|| $h_notification->notificationable_type=='GroupReject'|| $h_notification->notificationable_type=='GroupModeratorAccept'|| $h_notification->notificationable_type=='GroupModeratorReject'): ?>
<?php $group_id = encrypt($h_notification->notificationable_id);?> 
<!--<a href="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>">-->

<?php if(count($model) && $model->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $model->profile_image))): ?>
<img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/group_images/profile_image/'.$model->profile_image)); ?>&w=68&h=68&q=100" alt="<?php echo e($model->user->id); ?>"> 
<?php else: ?>
<img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('frontend/images/no-image-event-list.jpg')); ?>&w=68&h=68&q=100" alt=""/>
<?php endif; ?> 
<!--</a>-->
<?php endif; ?>
<?php if($h_notification->notificationable_type=='Event' ): ?>
<?php if(count($model_event) && $model_event->event_profile_image != NULL && file_exists(public_path('uploads/event_images/profile_image/'.$model_event->event_profile_image))): ?>
<img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/event_images/profile_image/'.$model_event->event_profile_image)); ?>&w=68&h=68&q=100" alt=""> 
<?php else: ?>
<img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('frontend/images/no-image-event-list.jpg')); ?>&w=68&h=68&q=100" alt=""/>
<?php endif; ?> 
<?php endif; ?>
</div>
<div class="notify-con">
<input type="hidden" name="notification_id" value="<?php echo e($h_notification->id); ?>" id="h_noti_id" />
<p><?php echo strip_tags($h_notification->text,"<a>")?></p>
<p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $h_notification->created_at)->format('dS M Y h:i A')); ?> &nbsp;</p>
<?php if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' ): ?>
<p id="status_notification_<?php echo e($h_notification->id); ?>" class="notibtn"><br>
<?php if($h_notification->accept_status==0): ?>
<input type="button" value="Accept" alt="<?php echo e($h_notification->id); ?>" class="view_all <?php if($h_notification->notificationable_type=='GroupMember'): ?>accept_noti_id_page <?php else: ?> accept_moderator_noti_id_page <?php endif; ?>">&nbsp<input type="button" alt="<?php echo e($h_notification->id); ?>" value="Reject"  class="view_all <?php if($h_notification->notificationable_type=='GroupMember'): ?> reject_noti_id_page <?php else: ?> reject_moderator_noti_id_page <?php endif; ?>">
<?php elseif($h_notification->accept_status==1): ?>
<span class ="attend_status_button">Accepted</span>
<?php else: ?>
<span class ="attend_status_button reject">Rejected</span>
<?php endif; ?>
</p>
<?php endif; ?>
<div class="notibtn">
<?php if($h_notification->notificationable_type=='Event'  ): ?>
<?php if($h_notification->events->event_start_date <= $today): ?>

<?php if($h_notification->events->getStatus($h_notification->events->id) == 1): ?>
<div class="attend_status_button">Attended</div>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 2): ?>
<div class="attend_status_button">Not Attended</div>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 3): ?>
<div class="attend_status_button">Tentative</div>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 4): ?>
<div class="attend_status_button">Interested</div>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 4): ?>
<div class="attend_status_button">Not Interested</div>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 6): ?>
<div class="attend_status_button not">Not Attended</div>
<?php else: ?>
<div class="attend_status_button not">Not Attended</div>
<?php endif; ?>

<?php else: ?>                
<?php if($h_notification->events->event_end_date > $today): ?>                    

<?php if($h_notification->events->getStatus($h_notification->events->id) == 1 || $h_notification->events->getStatus($h_notification->events->id) == 4): ?>
    <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="6">Not Attend</a>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 2 || $h_notification->events->getStatus($h_notification->events->id) == 5 || $h_notification->events->getStatus($h_notification->events->id) == 6): ?>
    <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="1">Attend</a>
<?php elseif($h_notification->events->getStatus($h_notification->events->id) == 3): ?>
  <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="1">Interested</a>
  <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="6">Not Interested</a>
<?php else: ?>
 <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="1">Attending</a>
 <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="2">Not Attending</a>
 <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "<?php echo e($h_notification->events->id); ?>" data-status="3">Tentative</a>

<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
</div>
</div>
</div> 
</div>                   
      
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>