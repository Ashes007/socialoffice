@if(!empty($recent_updates_all))
@foreach($recent_updates_all as $updates)
<div class="timelineBlock groupblock recentupblock">
<div class="time-postedBy">
  <div class="image-div"> @if($updates['userimage']!='')
  <img src="{{ asset($updates['userimage']) }}" alt="">
  @endif
  </div>
  <h2 style="padding-top: 10px;"><a href="{{URL::Route('user_profile').'/'.($updates['user_id'])}}">{{$updates['user_name']}}</a></h2>
</div>
 @if($updates['image']!='')
<div class="postedTime-image"> 
  <img src="{{ asset('timthumb.php') }}?src={{ asset($updates['image']) }}&w=586&h=175&q=100" alt="">  
</div>
@endif
<div class="likeComment learn">
  <div class="row">
    <div class="col-sm-12">
    <p>{{$updates['text']}} <a href="{{$updates['url']}}">{{$updates['textlink']}}</a> {{ trans('home.on')}} {{ \DateTime::createFromFormat('Y-m-d H:i:s', $updates['created_at'])->format('dS M Y h:i A') }} </p>
    <div class="btn_view" style="text-align:right"> <p><a href="{{$updates['url']}}" class="view_all"> {{ trans('common.learn_more')}}</a></p></div>
    </div>
  </div>
</div>
</div>
@endforeach     
@endif