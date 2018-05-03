<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="<?php echo e(asset('frontend/images/favicon.png')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="_token" content="<?php echo csrf_token(); ?>"/>
    <link href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/font-awesome.min.css')); ?>" rel="stylesheet">    
    <link href="<?php echo e(asset('frontend/css/development.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('frontend/css/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/lightbox.min.css')); ?>" rel="stylesheet">

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

  <!-- custom scrollbar stylesheet -->
  <script src="<?php echo e(asset('frontend/js/lightbox-plus-jquery.min.js')); ?>"></script>
  <link rel="stylesheet" href="<?php echo e(asset('frontend/css/tinyscrollbar.css')); ?>" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/owl.carousel.min.css')); ?>">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/modernizr.custom.js')); ?>"></script>
    <?php $current_user = \Auth::guard('user')->user()->id; ?>
    <script>   
        var BASE_URL = "<?php echo e(URL::route('home')); ?>"; 
        var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
        var USER_IMAGE_URL = "<?php echo e(config('constant.algolia_image_path')); ?>"; 
        var USER_PROFILE_URL = "<?php echo e(config('constant.user_profile_url')); ?>";
        var GROUP_PROFILE_IMG = "<?php echo e(config('constant.group_prof_image_path')); ?>";
        var EVENT_PROFILE_IMG = "<?php echo e(config('constant.event_profile_image')); ?>";
        var CURRENT_USER ="<?php echo e($current_user); ?>";
        var LoggedInUser = "<?php echo e(auth()->guard('user')->user()->id); ?>"; 
    </script> 

    <script src="<?php echo e(asset('socketjs/socket.io.js')); ?>"></script>
    <script>
        var unread_notification = <?php echo e(notification_count(auth()->guard('user')->user()->id)); ?>;    
        var socket = io('<?php echo e(config('constant.socket_url')); ?>');
    </script>

    <script src="<?php echo e(asset('frontend/js/lang.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/lang/messages.js')); ?>"></script>
    <script>lang.setLocale('<?php echo e(app()->getLocale()); ?>');</script>

    <script src="<?php echo e(asset('frontend/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>

    <script src="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/lang.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/lang/messages.js')); ?>"></script>
    
    


  </head>



  <body <?php if(\Request::route()->getName()=='occasion'): ?> class="themeLight occasions-back" <?php endif; ?>>
 
    <?php echo $__env->make('front.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('front.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('front.includes.modal_box', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 



    
    

    <!-- custom scrollbar plugin -->

        <script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.tinyscrollbar.min.js')); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                var $scrollbar = $("#scrollbar1");

                $scrollbar.tinyscrollbar();

            });
        </script>

    
    <!------for search area-------->
    <script src="<?php echo e(asset('frontend/js/classie.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/uisearch.js')); ?>"></script>
    <script>
      //new UISearch( document.getElementById( 'sb-search' ) );
 
    $(function () {
        $( document ).on( "click", ".user-com", function() {
        //$('.user-com').click(function () {
            var index = $(this).data("target");
            jQuery('#comment_'+index).slideToggle("slow");
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
</script>
<!-- for algolia -->
<!--<script src='http://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js'></script> -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="<?php echo e(asset('frontend/js/autocomplete_angoliaSearch.js')); ?>"></script>
<!-- for algolia -->
    
    <?php echo $__env->yieldContent('script'); ?>
 
  </body>
</html>
