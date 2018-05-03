@php

$stat=0;
@endphp

@if(!empty($feeds))

@foreach($feeds as $feedrecord) 
@if($feedrecord->type=='Event')
@php
$feed = $feedrecord->event;
@endphp                      

@if(count($feed))

@php
$stat=1;

@endphp
<!-- ------------ event - -- -->
<div class="timelineBlock eventblock margin-null">
  <div class="time-postedBy">
    <div class="image-div">
    @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
    @else
    <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
    @endif   
    </div>
    <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
    <p>{{ $feed->eventtype->name }} - {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
  </div>
  <div class="postedTime-image">
  @if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) 
  <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/original/'.$feed->eventImage[0]->image_name) }}&w=799&h=176&q=100" alt="">
  @else
  <img src="{{ asset('frontend/images/no-image-event-home.jpg') }}" alt="">
  @endif
  </div>

  <div class="likeComment learn">
    <div class="row">
      <div class="col-sm-12">

        <div class="eve-area">
        <div class="dates"><span>{{ \Carbon\Carbon::parse($feed->event_start_date)->format('M') }}</span> {{ \Carbon\Carbon::parse($feed->event_start_date)->format('d') }}</div>
        <div class="eve-right">
        <h3><a href="{{ route('event_details', encrypt($feed->id)) }}">{{ str_limit($feed->name,30,'...') }}

        @if($feed->event_start_date > $today)
        @if($feed->getStatusUser($user_id,$feed->id) == 1 || $feed->getStatusUser($user_id,$feed->id) == 4)
        <span> - {{ trans('common.attending') }}</span> 
        @elseif($feed->getStatusUser($user_id,$feed->id) == 2 || $feed->getStatusUser($user_id,$feed->id) == 6)
        <span class="not"> - {{ trans('common.not_attending') }}</span>
        @endif
        @endif
        </a></h3>
        <h5 class="location"><i class="fa fa-clock-o" aria-hidden="true"></i>{{ \Carbon\Carbon::parse($feed->event_start_date)->format('dS M Y') }} @ @if($feed->allday_event =='Yes') {{ trans('home.all_day') }} @else {{ $feed->start_time }} - {{ $feed->end_time }} @endif</h5>
        @if($feed->location!='')
        <h5 class="location"><i class="fa fa-map-marker"></i>{{ $feed->location }}</h5>
        @endif
        </div>
        <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ------------ event - -- -->
@endif
@elseif($feedrecord->type=='Group')

<!-- ------------ group - -- -->
@php
$feed = $feedrecord->group;
@endphp
@if(count($feed)) 
<?php        
$group_id = encrypt($feed->group_user_id);
?>

@if( is_member_group($user_id,$feed->group_user_id)>0 && is_member_group(\Auth::guard('user')->user()->id,$feed->group_user_id))
<?php  $stat=1;?>
<div class="timelineBlock groupblock">
  <div class="time-postedBy">
    <div class="image-div"> @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
    @else
    <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
    @endif 
    </div>
    <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
    <p>@if($feed->group_type_id==1) {{trans('group.global')}} @elseif($feed->group_type_id==2) {{trans('group.departmental')}} @else {{trans('group.activity_group')}} @endif - {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
  </div>
  <div class="postedTime-image">
    <?php if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {?>
    <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/').'/'.$feed->cover_image }}&w=799&h=176&q=100" alt=""/>
    <?php }else{ ?>
    <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}"  />
    <?php  } ?>
  </div>

  <div class="likeComment learn">
    <div class="row">
      <div class="col-sm-12 col-lg-9">

      <p>{{trans('group.A_new_group')}} <strong>{{ $feed->group_name }}</strong> {{trans('group.has_been_published')}}</p>
      </div>
      <div class="col-sm-12 col-lg-3">
      <a href="{{URL::Route('group_details').'/'.$group_id}}" class="view_all pull-right"> {{ trans('common.learn_more')}} </a>
      </div>
    </div>
  </div>

</div>
@endif
@endif
<!-- ------------ group - -- -->

<!-- ++++++++++++++++++++++++ occasion ++++++++++++++++++++++++++++++++ -->
@elseif($feedrecord->type=='Occasion')
@php $feed = $feedrecord->occasion; 
$joindate=explode('-',$feed->user->date_of_joining);              
@endphp
<div class="timelineBlock">

  <div class="time-postedBy">
  <div class="image-div">
  @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
  <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
  @else
  <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
  @endif  
  </div>
  <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
  <p>{{ trans('home.having')}} @if($feed->type=='BDAY'){{ trans('home.birthday')}} @else {{ trans('home.job_anniversary')}} @endif {{ trans('home.on')}} {{ \DateTime::createFromFormat('Y-m-d', $feed->occation_date)->format('dS M Y ') }}</p>
  </div>
  @if($feed->type=='BDAY')
  <div class="postedTime-image birth-area birth-area1">
  <img src="{{ asset('frontend/images/birthday.jpg')}}" alt="">
  <span><label>{{ trans('home.is_having')}}</label> {{ trans('home.birthday')}} @if($feed->occation_date == date('Y-m-d')){{ trans('common.today')}}! @else  {{ trans('home.on')}} {{ \DateTime::createFromFormat('Y-m-d', $feed->occation_date)->format('dS M') }}! @endif</span>

  </div>
  @else
  <div class="postedTime-image birth-area">
  <img src="{{ asset('frontend/images/aniversory.jpg')}}" alt="">
  <span><label>{{$joindate[0]}}</label> {{ trans('home.completed')}} {{date('Y')-$joindate[0]}} {{ trans('home.years')}}</span>

  </div>
  @endif

<div class="likeComment">
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4">

    @if(is_liked_occasion(\Auth::guard('user')->user()->id,$feed->id)==1)

    <?php $cls = 'active_lk'; ?>
    @else
    <?php $cls = ''; ?>
    @endif
    <button class="face-like face-like-occation {{$cls}}"  type="button" id="lkoccid_{{$feed->id}}" alt="{{$feed->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ trans('common.like') }}</button>
    <!--<button class="face-like" type="button" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>-->
    </div>

    <div class="col-sm-12 col-md-6 col-lg-8">
    <p><a  class='cntlikecls' href="{{URL::Route('likelistocc').'/'.$feed->id}}"><span id="likeocccnt_id_{{$feed->id}}" class="likecls">{{count($feed->likes)}} {{ trans('common.likes') }} </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$feed->id}}" id="cmncntocc_id_{{$feed->id}}">{{count($feed->comments)}} {{ trans('common.comments') }}</a></p>
    <input type="hidden" value="{{count($feed->comments)}}" id="cmntoccid_{{$feed->id}}" />
    <input type="hidden" value="{{count($feed->likes)}}" id="likeoccid_{{$feed->id}}" />
    </div>
  </div>
</div>
<div class="comment-other">
  @if(count($feed->comments))   <?php  $i = 0; ?>           
  @foreach($feed->comments as $comment) <?php $i ++; ?>

  @if($i==1 && count($feed->comments)>1)<div id="comment_{{$feed->id}}" style="display:none;">@endif
  <div class="comment-other-single">
    <div class="image-div">
    @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
    @else
    <img src="{{ asset('uploads/no_img.png') }}" alt="">
    @endif     </div>
    <h2><a href="{{URL::Route('user_profile').'/'.($comment->user->ad_username)}}">{{ $comment->user->display_name }} </a><span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}</span></h2>
    <p>{{$comment->body}}</p>
  </div>
  @if($i==(count($feed->comments)-1)) </div> @endif
  @endforeach                
  @endif
  <div id="commentsnwoccid_{{$feed->id}}">
  </div> 

</div>
<div class="comment-field">
  <div class="image-div">
  @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
  <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
  @else
  <img src="{{ asset('uploads/no_img.png') }}" alt=""/>
  @endif
  </div>
  <textarea id="commentoccid_{{$feed->id}}" alt="{{$feed->id}}" class="cmntclsocc" name="comment_text" placeholder="{{ trans('common.press_enter_to_post_comment') }}"></textarea>
</div>
</div>



<!-- ++++++++++++++++++++++++ occasion ++++++++++++++++++++++++++++++++ -->

@elseif($feedrecord->type=='Post')
<!-- ------------ post with image - -- -->
@php
$comm_share_permission_actv_grp = $userdetails->can('comment-share-activity-group'); 
$comm_share_permission_global_grp = $userdetails->can('comment-share-global-group');
$comm_share_permission_dept_grp = $userdetails->can('comment-share-departmental-group'); 
$like_permission_global_group =$userdetails->can('like-global-group');
$like_permission_departmental_group =$userdetails->can('like-departmental-group');
$like_permission_activity_group =$userdetails->can('like-activity-group');

$post_delete_permission_global_group =Auth::user()->can('post-delete-global-group');
$post_delete_permission_departmental_group =Auth::user()->can('post-delete-departmental-group');
$post_delete_permission_activity_group =Auth::user()->can('post-delete-activity-group');

$comment_delete_permission_global_group =Auth::user()->can('comment-delete-global-group');
$comment_delete_permission_departmental_group =Auth::user()->can('comment-delete-departmental-group');
$comment_delete_permission_activity_group =Auth::user()->can('comment-delete-activity-group');

$feed = $feedrecord->post;
@endphp
@if(count($feed) && $feed->group_id!=0)    
<?php 
$group_id = encrypt($feed->group_id);
$group_type = group_type($feed->group_id);  
if($group_type==1) { $permission_share = $comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}

if($group_type==1) { $permission_like =$like_permission_global_group;} elseif($group_type==2){ $permission_like = $like_permission_departmental_group;} elseif($group_type==3){ $permission_like = $like_permission_activity_group;}

if($group_type==1) { $permission_delete_post =$post_delete_permission_global_group;} elseif($group_type==2){ $permission_delete_post = $post_delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete_post = $post_delete_permission_activity_group;}

if($group_type==1) { $permission_delete_comment =$comment_delete_permission_global_group;} elseif($group_type==2){ $permission_delete_comment = $comment_delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete_comment = $comment_delete_permission_activity_group;}
?>         
@if( is_member_group($userdetails->id,$feed->group_id)>0 && is_member_group(\Auth::guard('user')->user()->id,$feed->group_id))
<?php $stat=1;?>
<div class="timelineBlock">
  <div class="time-postedBy">
  <div class="image-div">
  @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
  <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
  @else
  <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
  @endif  
  </div>
  <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
  <p>{{$feed->location}} @if($feed->location!='') - @endif {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
  @if((get_owner_group($feed->group_id) == \Auth::guard('user')->user()->id) || $permission_delete_post==1 || (is_moderator_group(\Auth::guard('user')->user()->id,encrypt($feed->group_id))>0))
  <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="{{$feed->id}}" data-toggle="tooltip" em="{{$feed->group_id}}" class="deletepost" title="Delete Post" style="color:#f29134"><i class="fa fa-times" aria-hidden="true"></i></a></span> </div>

 <!-- <div class="nav-func">
  <ul>
    <li><a href="javascript::void(0);" alt="{{$feed->id}}" data-toggle="tooltip" em="{{$feed->group_id}}" class="deletepost" title="Delete Post"><i class="fa fa-times" aria-hidden="true"></i></a></li>
  </ul>
</div> -->
  @endif
  </div>
<div class="postedTime-image">
@if($feed->vimeo_upload == 'Yes')
  <iframe src="https://player.vimeo.com/video/{{ $feed->vimeo_video_id }}" width="580" height="420" frameborder="0" mozallowfullscreen webkitallowfullscreen allowfullscreen></iframe>

@endif
@if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image)))
<img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/post_images/'.$feed->image) }}&w=799&h=175&q=100" alt=""/>
@if($feed->text!='')
<p>&nbsp;</p>
<p>@php echo nl2br($feed->text) @endphp</p>
@endif        
@else
@if($feed->text!='')
<h2>@php echo nl2br($feed->text) @endphp</h2>
@endif

@endif 
<p>&nbsp;</p> - <b>{{ trans('home.posted_in')}} <a href ="{{URL::Route('group_details').'/'.$group_id}}">{{ group_name($feed->group_id) }} </b></a>
</div>
  <div class="likeComment">
  <div class="row">
  <div class="col-sm-12 col-md-6 col-lg-4">

  @if($permission_like==1)
  @if(is_liked_post(\Auth::guard('user')->user()->id,$feed->id)==1)


  <?php $cls = 'active_lk'; ?>
  @else
  <?php $cls = ''; ?>
  @endif
  <!-- <button class="face-like" type="button" name="button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>-->
  <button class="face-like-post face-like {{$cls}}"  type="button" id="lkid_{{$feed->id}}" alt="{{$feed->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ trans('common.like') }}</button>
  @endif
  </div>
  <div class="col-sm-12 col-md-6 col-lg-8">
  <p><a  class='cntlikecls' href="{{URL::Route('likelist').'/'.$feed->id.'/'.$group_id}}"><span id="likecnt_id_{{$feed->id}}" class="likecls">{{count($feed->likes)}} {{ trans('common.likes') }} </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$feed->id}}" id="cmncnt_id_{{$feed->id}}">{{count($feed->comments)}} {{ trans('common.comments') }}</a></p>
  <input type="hidden" value="{{count($feed->comments)}}" id="cmntid_{{$feed->id}}" />
  <input type="hidden" value="{{count($feed->likes)}}" id="likeid_{{$feed->id}}" />
  </div>
  </div>
  </div>
<div class="comment-other" id="comment_2">
  @if(count($feed->comments))   <?php  $i = 0; ?>           
  @foreach($feed->comments as $comment) <?php $i ++; ?>

  @if($i==1 && count($feed->comments)>1)<div id="comment_{{$feed->id}}" style="display:none;">@endif
  <div class="comment-other-single">
    <div class="image-div">
    @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
    @else
    <img src="{{ asset('uploads/no_img.png') }}" alt="">
    @endif     </div>
    <h2><a href="{{URL::Route('user_profile').'/'.($comment->user->ad_username)}}">{{ $comment->user->display_name }}</a> 
    @if((get_owner_group($feed->group_id) == \Auth::guard('user')->user()->id) || $permission_delete_comment==1 || (is_moderator_group(\Auth::guard('user')->user()->id,encrypt($feed->group_id))>0))
    <span style="float: right;"><a href="javascript::void(0);" alt="{{$comment->id}}" em="{{$feed->group_id}}"  data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"><i class="fa fa-times" aria-hidden="true"></i></a></span>&nbsp; 
    @endif<span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}&nbsp;&nbsp;</span></h2>
    <p>{{$comment->body}}</p>
  </div>
  @if($i==(count($feed->comments)-1)) </div> @endif
  @endforeach                
  @endif
  <div id="commentsnwid_{{$feed->id}}">
  </div> 

</div>
<!-- for later -->
@if($permission_share==1 ) 
<div class="comment-field">
  <div class="image-div">
  @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' .\Auth::guard('user')->user()->profile_photo)))
  <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
  @else
  <img src="{{ asset('uploads/no_img.png') }}" alt=""/>
  @endif
  </div>
  <textarea id="commentid_{{$feed->id}}" alt="{{$feed->id}}" class="cmntcls" name="comment_text" placeholder="{{ trans('common.press_enter_to_post_comment') }}"></textarea>
</div>
@endif
<!-- for later -->
</div>   
@endif      
<!-- ------------ post with image - -- -->
@endif
@endif
@endforeach
@endif