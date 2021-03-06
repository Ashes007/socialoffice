<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <title>Tawasul : Login</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom_responsive.css') }}" rel="stylesheet">
    
    <!------for search area-------->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/component.css') }}" />
	<script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
 
<form action="" method="post">
{{ csrf_field() }}
   <div class="login-wrap">
     <div class="login-box">
     @if(Session::has('err_msg'))
      <p class="alert alert-danger">{{ Session::get('err_msg') }}</p>
    @endif
      <div class="logo">
         <img src="images/logo.png" alt="">
         <p>Access your account</p>
      </div>
      <div class="field-wrap">
         <input class="input-field" type="text" name="username" value="" placeholder="Username">
      </div>
      <div class="field-wrap">
         <input class="input-field" type="password" name="password" value="" placeholder="Password">
      </div>
      <!-- <p class="forgot-pass text-center"><a data-toggle="modal" data-target="#uploadphoto" href="#">Forgot?</a></p> -->
      <div class="field-wrap text-center">
        <input class="submit-btn" type="submit" name="" value="Login">
      </div>
     </div>
   </div>
</form>

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
   
	<a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>

    <script src="{{ asset('js/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js"></script>
    
    <script src="{{ asset('js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
            $(function () {
                $('#datetimepicker').datepicker();
            });
        </script>
  </body>
</html>
