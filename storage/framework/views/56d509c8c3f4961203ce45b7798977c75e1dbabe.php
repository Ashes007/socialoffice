<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="<?php echo e(asset('frontend/images/favicon.png')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>

    <link href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet">   
    <link href="<?php echo e(asset('frontend/css/font-awesome.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('frontend/css/dropdownCheckboxes.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/multiselect.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/multiselect-style.min.css')); ?>" rel="stylesheet">

      
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
     <link href="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.css')); ?>" rel="stylesheet">
    

    <!------Photo upload-------->
   <!-- <link href="<?php echo e(asset('frontend/css/imageuploadify.min.css')); ?>" rel="stylesheet">


    <!------Multiselect-------->

    <!--<link rel="stylesheet" href="<?php echo e(asset('frontend/css/dropdownCheckboxes.css')); ?>">-->

    <?php if(Request::segment(1) == 'ar'): ?>
        <link href="<?php echo e(asset('frontend/css/ar/custom_ar.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('frontend/css/ar/custom_responsive_ar.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/ar/component_ar.css')); ?>" />
        <link href="<?php echo e(asset('frontend/css/ar/menu_ar.css')); ?>" rel="stylesheet">
     <?php else: ?>
        <link href="<?php echo e(asset('frontend/css/custom.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('frontend/css/custom_responsive.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/component.css')); ?>" />
        <link href="<?php echo e(asset('frontend/css/menu.css')); ?>" rel="stylesheet">
     <?php endif; ?>

    <!------for search area-------->   
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/dropdown.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/select2.css')); ?>" />
   <!-- <script src="<?php echo e(asset('frontend/js/modernizr.custom.js')); ?>"></script>-->
   <!------Guest Listing-------->

    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/multiselect.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/multiselect-style.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/tinyscrollbar.css')); ?>" type="text/css" media="screen"/>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/modernizr.custom.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/lang.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/lang/messages.js')); ?>"></script>
    <script>lang.setLocale('<?php echo e(app()->getLocale()); ?>');</script>
   
    
    <script src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>
    <!------for search area-------->
    <script src="<?php echo e(asset('frontend/js/classie.js')); ?>"></script>
  <!--   <script src="<?php echo e(asset('frontend/js/uisearch.js')); ?>"></script> -->
 <script src="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.js')); ?>"></script>
  <?php $current_user = \Auth::guard('user')->user()->id; ?>
    <script>   
        var BASE_URL = "<?php echo e(URL::route('home')); ?>"; 
        var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
        var USER_IMAGE_URL = "<?php echo e(config('constant.algolia_image_path')); ?>"; 
        var USER_PROFILE_URL = "<?php echo e(config('constant.user_profile_url')); ?>";
        var GROUP_PROFILE_IMG = "<?php echo e(config('constant.group_prof_image_path')); ?>"; 
        var CURRENT_USER ="<?php echo e($current_user); ?>";
        var LoggedInUser = "<?php echo e(auth()->guard('user')->user()->id); ?>"; 
    </script> 
    <script src="<?php echo e(asset('socketjs/socket.io.js')); ?>"></script>
    <script>
        var unread_notification = <?php echo e(notification_count(auth()->guard('user')->user()->id)); ?>;    
        var socket = io('<?php echo e(config('constant.socket_url')); ?>');
    </script>
  </head>



  <body <?php if(\Request::route()->getName()=='group_add'): ?> class=" themeLight" <?php endif; ?>>
 
    <?php echo $__env->make('front.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
    <?php echo $__env->yieldContent('content'); ?>
     <script src="<?php echo e(asset('frontend/js/custom.js')); ?>"></script>
     <!-- for algolia -->
<!--<script src='http://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js'></script> -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="<?php echo e(asset('frontend/js/autocomplete_angoliaSearch.js')); ?>"></script>
<!-- for algolia -->
    <?php echo $__env->make('front.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 </body>
</html>