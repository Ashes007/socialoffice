 <div class="recent-block recent_update">
  <div class="image-div"><img src="<?php echo e(asset($profile_image)); ?>" alt=""></div>
  <h3><a href="<?php echo e(URL::Route('user_profile').'/'.$user_id); ?>"> <?php echo e($user_name); ?> </a> <?php echo e($text); ?> <a href="<?php echo e($url); ?>"><?php echo e($textlink); ?></a> <?php echo e(trans('home.on')); ?> <?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $created_at)->format('dS M Y h:i A')); ?> </h3>
  </div> 