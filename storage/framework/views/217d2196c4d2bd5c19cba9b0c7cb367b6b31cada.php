<?php if(count($errors) > 0): ?>       
        <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span><?php echo e($error); ?></span><br/>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        
                
        </div>	        
<?php endif; ?>

<?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable __web-inspector-hide-shortcut__">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php echo e(Session::get('success')); ?>

        </div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
        <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php echo e(Session::get('error')); ?>

        </div>	
<?php endif; ?>