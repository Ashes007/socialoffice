<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>">
  <title>Tawasul Administrator: <?php echo $__env->yieldContent('title'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/font-awesome/css/font-awesome.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/Ionicons/css/ionicons.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/dist/css/AdminLTE.min.css')); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/dist/css/skins/_all-skins.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/morris.js/morris.css')); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/jvectormap/jquery-jvectormap.css')); ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.css')); ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/plugins/iCheck/square/blue.css')); ?>">
  <!------- Timepicker ---------->
  <link href="<?php echo e(asset('backend/css/jquery.timepicker.min.css')); ?>" rel="stylesheet">
  <!-- custom -->
  <link rel="stylesheet" href="<?php echo e(asset('backend/dist/css/custom.css')); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/summernote/dist/summernote.css')); ?>" />
  <script src="<?php echo e(asset('backend/bower_components/jquery/dist/jquery.min.js')); ?>"></script>
  <link href="<?php echo e(asset('backend/css/admin_custom.css')); ?>" rel="stylesheet">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
  <?php echo $__env->make('admin.layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <?php echo $__env->make('admin.layout.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <?php echo $__env->yieldContent('content'); ?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <!--<b>Version</b> 2.4.0-->
    </div>
    <strong>Copyright &copy; 2017-<?php echo e(date('Y')); ?> <a href="#">Shurooq</a>.</strong> - All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(asset('backend/bower_components/jquery-ui/jquery-ui.min.js')); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

<script src="<?php echo e(asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<!-- Morris.js charts -->
<!-- Sparkline -->
<script src="<?php echo e(asset('backend/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')); ?>"></script>
<!-- jvectormap -->
<script src="<?php echo e(asset('backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo e(asset('backend/bower_components/jquery-knob/dist/jquery.knob.min.js')); ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo e(asset('backend/bower_components/moment/min/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>
<!-- datepicker -->
<script src="<?php echo e(asset('backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo e(asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo e(asset('backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('backend/bower_components/fastclick/lib/fastclick.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('backend/dist/js/adminlte.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo e(asset('backend/dist/js/pages/dashboard.js')); ?>"></script>
<!------------------ Alert Box ------------>
<link href="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('plugins/jquery-confirm/jquery-confirm.min.js')); ?>"></script> 

<!------------------ Timepicker ------------>
<script src="<?php echo e(asset('backend/js/jquery.timepicker.min.js')); ?>"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(asset('backend/dist/js/demo.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/jquery-validation/jquery.validate.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/jquery-validation/additional-methods.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/summernote/dist/summernote.min.js')); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5PfRGTq6z6QS3DW7pS3L6AVvUupeadNY&libraries=places&callback=initAutocomplete"
        async defer></script>
<!-- <script src="https://thrilleratplay.github.io/jquery-validation-bootstrap-tooltip/js/jquery-validate.bootstrap-tooltip.js"></script> -->
<script>
$(function() {


  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});
</script>

<script>
      var csrf_token = '<?php echo e(csrf_token()); ?>';
      var base_url = "<?php echo e(url('/')); ?>/admin/";
</script>

<!-- iCheck -->
<!-- <script src="<?php echo e(asset('backend/plugins/iCheck/icheck.min.js')); ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script> -->

<?php echo $__env->yieldContent('script'); ?>

<script src="<?php echo e(asset('backend/js/custom.js')); ?>"></script>

<form id="frmDelete" name="frmDelete" method="POST" action="">
    <?php echo e(csrf_field()); ?>

</form> 
</body>
</html>
