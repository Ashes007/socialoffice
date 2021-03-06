<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="<?php echo e(asset('frontend/images/favicon.png')); ?>">
    <title>Tawasul : <?php echo $__env->yieldContent('title'); ?></title>
    <link href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.css')); ?>" rel="stylesheet">
    <?php if(Request::segment(1) == 'ar'): ?>
        <link href="<?php echo e(asset('frontend/css/ar/custom_ar.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('frontend/css/ar/custom_responsive_ar.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/ar/component_ar.css')); ?>" />
     <?php else: ?>
        <link href="<?php echo e(asset('frontend/css/custom.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('frontend/css/custom_responsive.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/component.css')); ?>" />
     <?php endif; ?>

    <?php echo $__env->yieldContent('css'); ?>
    
    <!------for search area-------->
    <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/modernizr.custom.js')); ?>"></script>

    <script src="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.js')); ?>"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <script>   
        var BASE_URL = "<?php echo e(URL::route('home')); ?>"; 
        var CSRF_TOKEN = "<?php echo e(csrf_token()); ?>";
    </script> 

<?php echo $__env->yieldContent('content'); ?>

  <a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>




    <script type="text/javascript">

    $(document).ready(function(){
      $('#username').focus();
    });
            $("#btn-loading-animation").click(function(){
            $('#error_msg').html('&nbsp;'); 
            $("#btn-loading-animation").addClass("btn-animate");
            var username = $('#username').val();
            var password = $('#password').val();
            
            $.ajax({
                  type  : 'POST',
                  url : BASE_URL + '/login',
                  data  : {'_token': CSRF_TOKEN,'username':  username, password: password },
                  success: function(msg){
                    msg = JSON.parse(msg);
                    if(msg.validate == 'Error')
                    {
                      $('#error_msg').html(msg.message);
                      $("#btn-loading-animation").removeClass("btn-animate");
                    }

                    if(msg.validate == 'Success')
                    {
                      window.location.href= BASE_URL+ "/"+msg.redirect_page;
                    }

                      
                  }
                });
            });

            $(".animate_login").keypress(function(event) {
              if (event.which == 13) {
                 $("#btn-loading-animation").addClass("btn-animate");
                var username = $('#username').val();
                var password = $('#password').val();
            
                $.ajax({
                  type  : 'POST',
                  url : BASE_URL + '/login',
                  data  : {'_token': CSRF_TOKEN,'username':  username, password: password },
                  success: function(msg){
                    msg = JSON.parse(msg);
                    if(msg.validate == 'Error')
                    {
                      $('#error_msg').html(msg.message);
                      $("#btn-loading-animation").removeClass("btn-animate");
                    }

                    if(msg.validate == 'Success')
                    {
                      window.location.href= BASE_URL+ "/"+msg.redirect_page;
                    }

                      
                  }
                });
              }
            });
    </script>

    <?php echo $__env->yieldContent('script'); ?>
  </body>
</html>
