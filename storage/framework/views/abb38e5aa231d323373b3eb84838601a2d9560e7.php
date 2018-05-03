<div class="col-lg-3 col-sm-4">
  <div class="left-sidebar">
    <div class="profile-image-block">
      <div class="profile-image">
      <div class="pro-edit"><a href="<?php echo e(URL::Route('update_profile')); ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>

      <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))): ?>
      <a href="<?php echo e(URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username); ?>" > <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/></a>
      <?php else: ?>
      <a href="<?php echo e(URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username); ?>"><img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/></a>
      <?php endif; ?>
      </div>
      <h2><a href="<?php echo e(URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username); ?>" style="color:#fff"><?php echo e(\Auth::guard('user')->user()->display_name); ?></a></h2>
      <p>
      <?php echo e(\Auth::guard('user')->user()->designation->name); ?> <br> 
      <?php echo e(\Auth::guard('user')->user()->department->name); ?>

      </p>
    </div>
  <div class="side-nav">
  <ul>

    <li class="active"><a href="<?php echo e(URL::Route('home')); ?>"><i class="fa fa-user" aria-hidden="true"></i> <?php echo e(trans('homeLeftMenu.news_feeds')); ?></a></li>
    <li><a href="<?php echo e(URL::Route('event','month')); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo e(trans('homeLeftMenu.events')); ?></a></li>
    <li><a href="<?php echo e(URL::Route('user_directory')); ?>"><i class="fa fa-handshake-o" aria-hidden="true"></i> <?php echo e(trans('homeLeftMenu.employee_directory')); ?></a></li>
    <li><a href="<?php echo e(URL::Route('group')); ?>"><i class="fa fa-users" aria-hidden="true"></i> <?php echo e(trans('homeLeftMenu.groups')); ?></a></li>
    <li><a href="<?php echo e(URL::Route('occasion')); ?>"><i class="fa fa-sign-language" aria-hidden="true"></i> <?php echo e(trans('homeLeftMenu.occasions')); ?></a></li>

  </ul>
  </div>
  </div>
</div>