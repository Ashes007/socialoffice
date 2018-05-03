@extends('admin.innertemplate')
@section('content')
<script src="{{ asset('frontend/js/jquery.colorbox.js') }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/colorbox.css')}}" />
  <section class="content-header">
    <h1>Occasion list </h1>
    <ol class="breadcrumb">
     	<li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     	<li><a href="{{ route('user_list') }}"> User</a></li>
     	<li> Occasion</li>
    </ol>
  </section>
<!-- Main content -->
<section class="content">
@if(count($occasion)>0)
@foreach($occasion as $feed)
@php $joindate=explode('-',$feed->user->date_of_joining);  @endphp
<div class="timelineBlock">
	<div class="time-postedBy">
		<div class="image-div">
		@if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
		<img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
		@else
		<img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="" />
		@endif  
		</div>
		<h2>{{ $feed->user->display_name }}</h2>
		<p>{{ trans('home.having')}} @if($feed->type=='BDAY'){{ trans('home.birthday')}} @else {{ trans('home.job_anniversary')}} @endif {{ trans('home.on')}} {{ \DateTime::createFromFormat('Y-m-d', $feed->occation_date)->format('dS M Y ') }}</p>
	</div>
	@if($feed->type=='BDAY')
		<div class="postedTime-image birth-area birth-area1">
		<img src="{{ asset('frontend/images/birthday.jpg')}}" alt="" />
		<span><label>{{ trans('home.is_having')}}</label> {{ trans('home.birthday')}} @if($feed->occation_date == date('Y-m-d')){{ trans('common.today')}}! @else  {{ trans('home.on')}} {{ \DateTime::createFromFormat('Y-m-d', $feed->occation_date)->format('dS M') }}! @endif</span>
		</div>
	@else
		<div class="postedTime-image birth-area">
		<img src="{{ asset('frontend/images/aniversory.jpg')}}" alt="" />
		<span><label>{{$joindate[0]}}</label> {{ trans('home.completed')}} {{date('Y')-$joindate[0]}} {{ trans('home.years')}}</span>
		</div>
	@endif
	<div class="likeComment">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-lg-4">	
			</div>
			<div class="col-sm-12 col-md-6 col-lg-8">
			<p><a  class='cntlikecls' href="{{URL::Route('likelistocc').'/'.$feed->id}}"><span id="likeocccnt_id_{{$feed->id}}" class="likecls">{{count($feed->likes)}} {{ trans('common.likes') }} </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$feed->id}}" id="cmncntocc_id_{{$feed->id}}">{{count($feed->comments)}} {{ trans('common.comments') }}</a></p>
			<input type="hidden" value="{{count($feed->comments)}}" id="cmntoccid_{{$feed->id}}" />
			<input type="hidden" value="{{count($feed->likes)}}" id="likeoccid_{{$feed->id}}" />
			</div>
		</div>
	</div>
	<div class="comment-other">
	<div class="commentscrollcls">
	@if(count($feed->comments))   <?php  $i = 0; ?>           
	@foreach($feed->comments as $comment) <?php $i ++; ?>	
	<div class="comment-other-single">
	<div class="image-div">
		@if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
		<img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
		@else
		<img src="{{ asset('uploads/no_img.png') }}" alt="">
		@endif     
	</div>
	<h2>{{ $comment->user->display_name }} <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}</span></h2>
	<p>{{$comment->body}}</p>
	</div>	
	@endforeach                
	@endif
	<div id="commentsnwoccid_{{$feed->id}}">
	</div> 
	</div>	
	</div>	
</div>
@endforeach
@else
<div class="timelineBlock">
	<div class="time-postedBy">
	<p>No wishes for you!</p>
	</div>
</div>
@endif
</section>
<script src="{{ asset('frontend/js/jquery.colorbox.js') }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/colorbox.css')}}" />
<script type="text/javascript">

$(document).on('click','.cntlikecls',function(e) {
e.preventDefault();
$.colorbox({href : this.href, width:"30%"});
});
</script>
@endsection