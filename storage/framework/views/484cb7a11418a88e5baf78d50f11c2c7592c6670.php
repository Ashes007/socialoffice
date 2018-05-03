<div class="side-nav1 slidemenu">
   <button class="left_slide_btn panel"> <span class="menubar_icon_black" style="display: block;"> </span></button>
     <ul>
         <li <?php if(isset($eventDay)): ?> <?php if($eventDay == 'today'): ?> class="active" <?php endif; ?> <?php endif; ?>>
           <a href="<?php echo e(route('event', 'today')); ?>">
           <img src="<?php echo e(asset('frontend/images/ic1.png')); ?>" alt=""/>
           <span><?php echo e(trans('eventList.today')); ?></span>
         </a>
         </li>
         <li <?php if(isset($eventDay)): ?>  <?php if($eventDay == 'tomorrow'): ?> class="active" <?php endif; ?> <?php endif; ?>>
           <a href="<?php echo e(route('event', 'tomorrow')); ?>">
           <img src="<?php echo e(asset('frontend/images/ic2.png')); ?>" alt=""/>
           <span><?php echo e(trans('eventList.tomorrow')); ?></span>
         </a>
         </li>
         <li <?php if(isset($eventDay)): ?>  <?php if($eventDay == 'week'): ?> class="active" <?php endif; ?> <?php endif; ?>>
           <a href="<?php echo e(route('event', 'week')); ?>">
           <img src="<?php echo e(asset('frontend/images/ic3.png')); ?>" alt=""/>
           <span><?php echo e(trans('eventList.this_week')); ?></span>
         </a>
         </li>
         <li <?php if(isset($eventDay)): ?>  <?php if($eventDay == 'month'): ?> class="active" <?php endif; ?> <?php endif; ?>>
           <a href="<?php echo e(route('event', 'month')); ?>">
           <img src="<?php echo e(asset('frontend/images/ic4.png')); ?>" alt=""/>
           <span><?php echo e(trans('eventList.this_month')); ?></span>
         </a>
         </li>
         <li <?php if(isset($eventDay)): ?>  <?php if($eventDay == 'search'): ?> class="active" <?php endif; ?> <?php endif; ?>>
           <a href="javascript:void(0);" id="chooseDate1" data-toggle="modal" data-target="#searchSection">
           <img src="<?php echo e(asset('frontend/images/ic5.png')); ?>" alt=""/>
           <span><?php echo e(trans('eventList.Choose_Date')); ?></span>
         </a>
         </li>
         <li <?php if(isset($eventDay)): ?>  <?php if($eventDay == 'own'): ?> class="active" <?php endif; ?> <?php endif; ?>>
           <a href="<?php echo e(route('event', 'own')); ?>">
           <img src="<?php echo e(asset('frontend/images/ic9.png')); ?>" alt=""/>
           <span><?php echo e(trans('eventList.Events_I_Created')); ?></span>
         </a>
         </li>
     </ul>
</div>