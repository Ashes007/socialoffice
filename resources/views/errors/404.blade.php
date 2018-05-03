@extends('front.layout.error')
 
@section('content')


	   <div class="login-wrap">
	     <div class="login-box">
	      		<h4>{{ trans('error.Sorry_the_page_you_are_looking_for_is_not_found') }}</h4>
	      		<p>{{ trans('error.Go_back_to') }} <a href="{{ URL::to('/') }}">{{ trans('error.home_page') }}</a></p>
	     </div>
	   </div>



@endsection
