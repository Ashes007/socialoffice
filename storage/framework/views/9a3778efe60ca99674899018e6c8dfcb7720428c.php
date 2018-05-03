<?php $__env->startSection('title','Login'); ?>
<?php $__env->startSection('content'); ?> 

   <div class="login-wrap">
     <div class="login-box">
      <div class="logo"><img src="<?php echo e(asset('frontend/images/logo.png')); ?>" alt="">
         <p><?php echo e(trans('userLogin.Access_your_account')); ?></p>
      </div>
      <div class="log-field">
      <div class="field-wrap">
      <span class="icons"><img src="<?php echo e(asset('frontend/images/log-icon1.png')); ?>" alt=""></span>
         <input class="input-field animate_login" id="username" type="text" name="" value="" placeholder="<?php echo e(trans('userLogin.username')); ?>">
      </div>
      <div class="field-wrap">
      <span class="icons"><img src="<?php echo e(asset('frontend/images/log-icon2.png')); ?>" alt=""></span>
         <input class="input-field animate_login" id="password" type="password" name="" value="" placeholder="<?php echo e(trans('userLogin.password')); ?>">
      </div>

      <!--<p class="forgot-pass text-center"><a data-toggle="modal" data-target="#uploadphoto" href="#">Forgot?</a></p>-->
      <div class="log-sub">
        <!--<input class="submit-btn" type="submit" name="" value="Login">-->
        <a href="javascript:void(0)"  id="btn-loading-animation"><?php echo e(trans('userLogin.login')); ?></a>
      </div>

      <div id="error_msg" class="error_msg">&nbsp;</div>
      </div>
     </div>
   </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.login_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>