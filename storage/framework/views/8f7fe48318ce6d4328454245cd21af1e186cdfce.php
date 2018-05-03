 
<?php $__env->startSection('content'); ?>


	   <div class="login-wrap">
	     <div class="login-box">
	      		<h4><?php echo e(trans('error.Sorry_the_page_you_are_looking_for_is_not_found')); ?></h4>
	      		<p><?php echo e(trans('error.Go_back_to')); ?> <a href="<?php echo e(URL::to('/')); ?>"><?php echo e(trans('error.home_page')); ?></a></p>
	     </div>
	   </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>