<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}">
    <title>@yield('title')</title>

    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">   
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/dropdownCheckboxes.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/multiselect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/multiselect-style.min.css') }}" rel="stylesheet">

      
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
     <link href="{{ asset('plugins/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet">
    

    <!------Photo upload-------->
   <!-- <link href="{{ asset('frontend/css/imageuploadify.min.css') }}" rel="stylesheet">


    <!------Multiselect-------->

    <!--<link rel="stylesheet" href="{{ asset('frontend/css/dropdownCheckboxes.css') }}">-->

    @if(Request::segment(1) == 'ar')
        <link href="{{ asset('frontend/css/ar/custom_ar.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/ar/custom_responsive_ar.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/ar/component_ar.css') }}" />
        <link href="{{ asset('frontend/css/ar/menu_ar.css') }}" rel="stylesheet">
     @else
        <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/custom_responsive.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/component.css') }}" />
        <link href="{{ asset('frontend/css/menu.css') }}" rel="stylesheet">
     @endif

    <!------for search area-------->   
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/dropdown.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/select2.css') }}" />
   <!-- <script src="{{ asset('frontend/js/modernizr.custom.js') }}"></script>-->
   <!------Guest Listing-------->

    <link rel="stylesheet" href="{{ asset('frontend/css/multiselect.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/multiselect-style.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/tinyscrollbar.css') }}" type="text/css" media="screen"/>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/modernizr.custom.js') }}"></script>
    <script src="{{ asset('frontend/js/lang.js') }}"></script>
    <script src="{{ asset('frontend/js/lang/messages.js') }}"></script>
    <script>lang.setLocale('{{ app()->getLocale() }}');</script>
   
    
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!------for search area-------->
    <script src="{{ asset('frontend/js/classie.js') }}"></script>
  <!--   <script src="{{ asset('frontend/js/uisearch.js') }}"></script> -->
 <script src="{{ asset('plugins/jquery-confirm/jquery-confirm.min.js') }}"></script>
  @php $current_user = \Auth::guard('user')->user()->id; @endphp
    <script>   
        var BASE_URL = "{{ URL::route('home') }}"; 
        var CSRF_TOKEN = "{{ csrf_token() }}";
        var USER_IMAGE_URL = "{{ config('constant.algolia_image_path') }}"; 
        var USER_PROFILE_URL = "{{ config('constant.user_profile_url') }}";
        var GROUP_PROFILE_IMG = "{{ config('constant.group_prof_image_path') }}"; 
        var CURRENT_USER ="{{$current_user }}";
        var LoggedInUser = "{{ auth()->guard('user')->user()->id }}"; 
    </script> 
    <script src="{{ asset('socketjs/socket.io.js') }}"></script>
    <script>
        var unread_notification = {{ notification_count(auth()->guard('user')->user()->id) }};    
        var socket = io('{{ config('constant.socket_url') }}');
    </script>
  </head>



  <body @if(\Request::route()->getName()=='group_add') class=" themeLight" @endif>
 
    @include('front.includes.header')   
    @yield('content')
     <script src="{{ asset('frontend/js/custom.js') }}"></script>
     <!-- for algolia -->
<!--<script src='http://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js'></script> -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('frontend/js/autocomplete_angoliaSearch.js') }}"></script>
<!-- for algolia -->
    @include('front.includes.footer')
 </body>
</html>