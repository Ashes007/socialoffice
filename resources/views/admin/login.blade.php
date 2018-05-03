<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
  <title>Tawasul Administrator: @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/square/blue.css') }}">
  <!-- custom -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/custom.css') }}">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-wrap">
  @yield('content')
<!-- /.login-box -->
</div>
</div>

<div class="copyright">
     <div class="container cent-vertically">
        <p>Copyright © Shurooq - All rights reserved</p>
     </div>
   </div>

<div class="modal fade" id="uploadphoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content alt">
      <div class="modal-body">
        <button type="button" class="close alt" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
        <div class="row">
          <div class="col-sm-12">
            <h2><i class="fa fa-unlock-alt" aria-hidden="true"></i>  Forgot Password page?</h2>
  <form action="/action_page.php">
    <div class="form-group">
      <label for="title">Username:</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>
    
    
    <div class="form-group">
      <label for="title">Full Name:</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>
    
    <div class="form-group">
      <label for="title">Department Name:</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>
    
    <div class="form-group">
  <label for="sel1">Date of birth:</label>
  <div class="datetimepickerarea">
  <div class='input-group date' id='datetimepicker'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
   </div>
   </div>
    
    
   <div class="clearfix"></div>
    <div class="form-sub">
    <input type="submit" value="Submit"/> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
    </div>
    <a href="#" class="log-sigin">Sign in</a>
  </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery 3 -->
<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script src="{{ asset('backend/dist/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
            $(function () {
                $('#datetimepicker').datepicker();
            });
    </script>
</body>
</html>
