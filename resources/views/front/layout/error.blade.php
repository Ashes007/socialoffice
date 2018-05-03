<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}">
    <title>Tawasul : Page Not Found</title>
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet">
    @if(Request::segment(1) == 'ar')
        <link href="{{ asset('frontend/css/ar/custom_ar.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/ar/custom_responsive_ar.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/ar/component_ar.css') }}" />
     @else
        <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/custom_responsive.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/component.css') }}" />
     @endif

    <!------for search area-------->

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>


@yield('content')

  </body>
</html>
