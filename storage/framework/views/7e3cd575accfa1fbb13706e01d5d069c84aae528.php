<div class="top-backs">
  <div class="timeline-photo">
  <?php if(\Auth::guard('user')->user()->cover_photo != NULL && file_exists(public_path('uploads/user_images/cover_photo/' . \Auth::guard('user')->user()->cover_photo))): ?>
  <img src="<?php echo e(asset('uploads/user_images/cover_photo/thumbnails/'.\Auth::guard('user')->user()->cover_photo)); ?>" alt="img" />
  <?php else: ?>
  <img src="<?php echo e(asset('frontend/images/no-image-event-details.jpg')); ?>" alt=""/>
  <?php endif; ?>
    <div class="timeline-cont">
      <div class="row">
        <div class="col-sm-8">
          <div class="timeline-profile">
            <div class="image-div"> 
            <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))): ?>
            <a href="<?php echo e(URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username); ?>" ><img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/></a>
            <?php else: ?>
            <a href="<?php echo e(URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username); ?>" ><img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/></a>
            <?php endif; ?>
            </div>
           <h2><a href="<?php echo e(URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username); ?>" style="color:#fff"> <?php echo e(\Auth::guard('user')->user()->display_name); ?></a></h2>
            <p>@ <?php echo e(\Auth::guard('user')->user()->ad_username); ?></p>
          </div>
        </div>
        <div class="col-sm-4">
        </div>
      </div>
    </div>
  </div>
  <div class="fixme">
    <div class="timeline-nav clearfix">
      <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
        <div class="main-menu">
        <div id="header_menu">
        <img src="<?php echo e(asset('frontend/images/logo.png')); ?>" alt="" data-retina="true">
        </div>
        <a href="#" class="open_close" id="close_in"><i class="fa fa-times" aria-hidden="true"></i></a>

        <ul>
        <li><a href="<?php echo e(URL::Route('home')); ?>"><?php echo e(trans('common.News_Feed')); ?></a></li>
        <li><a href="<?php echo e(URL::Route('event','month')); ?>"><?php echo e(trans('common.Events')); ?></a></li>

        <li><a href="<?php echo e(URL::Route('user_directory')); ?>"><?php echo e(trans('common.Employee_Directory')); ?> </a></li>
        <li class="active"><a href="<?php echo e(URL::Route('group')); ?>"><?php echo e(trans('common.Groups')); ?></a></li>
        <li><a href="<?php echo e(URL::Route('occasion')); ?>"><?php echo e(trans('homeLeftMenu.occasions')); ?></a></li>
        </ul>
        </div><!-- End main-menu -->
      <!-- <label class="fileContainer">
      <a href="<?php echo e(URL::Route('group')); ?>/own">Own Group </a> 
      </label>-->
        <?php    
        $add_permission_actv_grp = Auth::user()->can('add-activity-group'); 
        $add_permission_global_grp = Auth::user()->can('add-global-group');
        $add_permission_dept_grp = Auth::user()->can('add-departmental-group'); ?>
        <?php if(($add_permission_actv_grp==1 || $add_permission_dept_grp==1 || $add_permission_global_grp==1)): ?>
        <label class="fileContainer">
        <a href="<?php echo e(URL::Route('group_add')); ?>"><?php echo e(trans('group.create_group')); ?> </a> 
        </label>
        <?php endif; ?>
    </div>
  </div>
</div>