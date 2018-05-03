<div class="side-nav1 slidemenu">
<button class="left_slide_btn panel"> <span class="menubar_icon_black" style="display: block;"> </span></button>
<?php
//echo Route::getCurrentRoute()->getPath().'@@';?>

  <ul>
    <li  <?php if(request()->segment(2)=='all'): ?> class="active" <?php endif; ?>>
    <a href="<?php echo e(URL::Route('group')); ?>/all">
    <img src="<?php echo e(asset('frontend/images/ic6.png')); ?>" alt=""/>
    <span><?php echo e(trans('group.all_group')); ?></span>
    </a>
    </li>
    <li <?php if(request()->segment(2)=='global'): ?> class="active" <?php endif; ?>>
    <a href="<?php echo e(URL::Route('group')); ?>/global">
    <img src="<?php echo e(asset('frontend/images/ic7.png')); ?>" alt=""/>
    <span><?php echo e(trans('group.global_group')); ?></span>
    </a>
    </li>
    <li <?php if(request()->segment(2)=='departmental'): ?> class="active" <?php endif; ?>>
    <a href="<?php echo e(URL::Route('group')); ?>/departmental">
    <img src="<?php echo e(asset('frontend/images/ic8.png')); ?>" alt=""/>
    <span><?php echo e(trans('group.departmental_group')); ?></span>
    </a>
    </li>

    <li <?php if(request()->segment(2)=='own'): ?> class="active" <?php endif; ?>>
    <a href="<?php echo e(URL::Route('group')); ?>/own">
    <img src="<?php echo e(asset('frontend/images/ic9.png')); ?>" alt=""/>
    <span><?php echo e(trans('group.group_i_create')); ?></span>
    </a>
    </li>

    <li <?php if(request()->segment(2)=='activity'): ?> class="active" <?php endif; ?>>
    <a href="<?php echo e(URL::Route('group')); ?>/activity">
    <i class="fa fa-weixin" aria-hidden="true"></i>
    <span><?php echo e(trans('group.activity_group')); ?></span>
    </a>
    </li>

  </ul>
</div>