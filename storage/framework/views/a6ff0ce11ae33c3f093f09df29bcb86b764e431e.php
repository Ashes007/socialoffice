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
    <link href="<?php echo e(asset('frontend/css/menu.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/dropdown.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/bootstrap-datepicker.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('frontend/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.css')); ?>" rel="stylesheet">
    <!------Photo upload-------->
    <link href="<?php echo e(asset('frontend/css/imageuploadify.min.css')); ?>" rel="stylesheet">

 
    <!------Multiselect-------->

    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/dropdownCheckboxes.css')); ?>">

    <?php if(Request::segment(1) == 'ar'): ?>
        <link href="<?php echo e(asset('frontend/css/ar/custom_ar.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('frontend/css/ar/custom_responsive_ar.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/ar/component_ar.css')); ?>" />
        <link href="<?php echo e(asset('frontend/css/ar/menu_ar.css')); ?>" rel="stylesheet">
     <?php else: ?>
        <link href="<?php echo e(asset('frontend/css/custom.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('frontend/css/custom_responsive.css')); ?>" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontend/css/component.css')); ?>" />
        
     <?php endif; ?>

    <!------for search area-------->
    <script src="<?php echo e(asset('frontend/js/modernizr.custom.js')); ?>"></script>
   <!------Guest Listing-------->

    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/multiselect.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/multiselect-style.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/tinyscrollbar.css')); ?>" type="text/css" media="screen"/>
    <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/js/bootstrap-datepicker.js')); ?>"></script>

    <script src="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.js')); ?>"></script>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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



  <body <?php if(\Request::route()->getName()=='create_event'): ?> class=" themeLight" <?php endif; ?>">
 
    <?php echo $__env->make('front.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('front.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <div class="searchSection modal fade" id="searchSection" style="display: none;" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
   <div class="modal-content alt">
     <div class="modal-body">
      <?php echo e(Form::open(array('route' => ['event','search'],'id'=>'searchFrm', 'files' => true))); ?>


           <div class="form-group">
              <label for="sel1"><?php echo e(trans('common.From_date')); ?>:</label>
              <div class="datetimepickerarea custom custom1">
              <div class='input-group date'>
                                <input type='text'  id='eventFromDate' name="from" class="form-control" placeholder="DD-MM-YYYY" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
               </div>
               
               <div class="clearfix"></div>
               
               <label><?php echo e(trans('common.End_Date')); ?></label>
              <div class="datetimepickerarea custom custom1">
              <div class='input-group date' >
                                <input type='text' id='eventEndDate' name="end" class="form-control" placeholder="DD-MM-YYYY" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
               </div>
               </div>
                
               <div class="clearfix"></div>
                <div class="form-sub datesub">
                <input type="submit" value="Submit"/> <i class="fa fa-caret-right" aria-hidden="true"></i>
            </div>

      <?php echo e(Form::close()); ?>

</div>
</div>
</div>
</div>

    <!------Guest Listing-------->

    <script src="<?php echo e(asset('frontend/js/multiselects.js')); ?>"></script>
    <style>
        .demo-section label {
            display: block;
            margin: 15px 0 5px 0;
        }
        #get {
            float: right;
            margin: 25px auto 0;
        }
    </style>
    <script>
        $(document).ready(function() {
            // create MultiSelect from select HTML element
            var required = $("#required").kendoMultiSelect().data("kendoMultiSelect");
            var optional = $("#optional").kendoMultiSelect({
                autoClose: false
            }).data("kendoMultiSelect");

            $("#get").click(function() {
                alert("Attendees:\n\nRequired: " + required.value() + "\nOptional: " + optional.value());
            });


            $('#chooseDate').click(function(){
                $('#searchSection').show();
            });

            var startDate = new Date();
            var FromEndDate = new Date();
            var ToEndDate = new Date();

             $('#eventFromDate').datepicker({
                    
                    format: 'dd-mm-yyyy',
                    startDate: startDate,
                    autoclose: true
                })
                    .on('changeDate', function(selected){
                        startDate = new Date(selected.date.valueOf());
                        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                        $('#eventEndDate').datepicker('setStartDate', startDate);
                    }); 

                $('#eventEndDate')
                    .datepicker({
                        
                        format: 'dd-mm-yyyy',
                        startDate: startDate,
                        autoclose: true
                    })
                    .on('changeDate', function(selected){
                        
                        FromEndDate = new Date(selected.date.valueOf());
                        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
                        $('#eventFromDate').datepicker('setEndDate', FromEndDate);
                });


        
            $("#searchFrm").on('submit',(function(e){

                if($('#eventFromDate').val() == '' || $('#eventEndDate').val() == '' )
                {
                    return false;
                }
            }));

        });
    </script>

    <!------Guest Listing-------->

  
  

    <!------Photo Upload-------->

   <?php /*?> <script type="text/javascript" src="{{ asset('frontend/js/imageuploadify.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('input[type="file"]').imageuploadify();
            })
        </script><?php */?>

   <!------Photo Upload-------->

   <script type="text/javascript">
   $(document).ready(function(){
   $('.panel').click( function() {
   $('.slidemenu').toggleClass('clicked').addClass('unclicked');
   $('.menubar_icon_black').toggleClass('menubar_icon_cross');
    });
   });
   </script>

   <script src="<?php echo e(asset('frontend/js/lang.js')); ?>"></script>
   <script src="<?php echo e(asset('frontend/js/lang/messages.js')); ?>"></script>
   <script>lang.setLocale('<?php echo e(app()->getLocale()); ?>');</script>
   
   <script src="<?php echo e(asset('frontend/js/custom.js')); ?>"></script>
 <script>
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
