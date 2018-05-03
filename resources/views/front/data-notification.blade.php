@if(count($header_notifications)>0) 
@foreach($header_notifications as $h_notification)
@php
$model=array();
$model_event=array();
$model = $h_notification->groups;
$model_event = $h_notification->events;
$today = date('Y-m-d');
@endphp
<div class="timelineBlock groupblock">
<div class="notify-postedBy">
<div class="postedTime-image">
@if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' || $h_notification->notificationable_type=='GroupInsert'|| $h_notification->notificationable_type=='GroupUpdate'|| $h_notification->notificationable_type=='GroupDelete' || $h_notification->notificationable_type=='GroupAccept'|| $h_notification->notificationable_type=='GroupReject'|| $h_notification->notificationable_type=='GroupModeratorAccept'|| $h_notification->notificationable_type=='GroupModeratorReject')
<?php $group_id = encrypt($h_notification->notificationable_id);?> 
<!--<a href="{{ URL::Route('group_details').'/'.$group_id }}">-->

@if(count($model) && $model->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $model->profile_image)))
<img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/profile_image/'.$model->profile_image) }}&w=68&h=68&q=100" alt="{{ $model->user->id }}"> 
@else
<img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/no-image-event-list.jpg') }}&w=68&h=68&q=100" alt=""/>
@endif 
<!--</a>-->
@endif
@if($h_notification->notificationable_type=='Event' )
@if(count($model_event) && $model_event->event_profile_image != NULL && file_exists(public_path('uploads/event_images/profile_image/'.$model_event->event_profile_image)))
<img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/profile_image/'.$model_event->event_profile_image) }}&w=68&h=68&q=100" alt=""> 
@else
<img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/no-image-event-list.jpg') }}&w=68&h=68&q=100" alt=""/>
@endif 
@endif
</div>
<div class="notify-con">
<input type="hidden" name="notification_id" value="{{$h_notification->id}}" id="h_noti_id" />
<p><?php echo strip_tags($h_notification->text,"<a>")?></p>
<p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> {{ \DateTime::createFromFormat('Y-m-d H:i:s', $h_notification->created_at)->format('dS M Y h:i A') }} &nbsp;</p>
@if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' )
<p id="status_notification_{{$h_notification->id}}" class="notibtn"><br>
@if($h_notification->accept_status==0)
<input type="button" value="Accept" alt="{{$h_notification->id}}" class="view_all @if($h_notification->notificationable_type=='GroupMember')accept_noti_id_page @else accept_moderator_noti_id_page @endif">&nbsp<input type="button" alt="{{$h_notification->id}}" value="Reject"  class="view_all @if($h_notification->notificationable_type=='GroupMember') reject_noti_id_page @else reject_moderator_noti_id_page @endif">
@elseif($h_notification->accept_status==1)
<span class ="attend_status_button">Accepted</span>
@else
<span class ="attend_status_button reject">Rejected</span>
@endif
</p>
@endif
<div class="notibtn">
@if($h_notification->notificationable_type=='Event'  )
@if($h_notification->events->event_start_date <= $today)

@if($h_notification->events->getStatus($h_notification->events->id) == 1)
<div class="attend_status_button">Attended</div>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 2)
<div class="attend_status_button">Not Attended</div>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 3)
<div class="attend_status_button">Tentative</div>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 4)
<div class="attend_status_button">Interested</div>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 4)
<div class="attend_status_button">Not Interested</div>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 6)
<div class="attend_status_button not">Not Attended</div>
@else
<div class="attend_status_button not">Not Attended</div>
@endif

@else                
@if($h_notification->events->event_end_date > $today)                    

@if($h_notification->events->getStatus($h_notification->events->id) == 1 || $h_notification->events->getStatus($h_notification->events->id) == 4)
    <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="6">Not Attend</a>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 2 || $h_notification->events->getStatus($h_notification->events->id) == 5 || $h_notification->events->getStatus($h_notification->events->id) == 6)
    <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="1">Attend</a>
@elseif($h_notification->events->getStatus($h_notification->events->id) == 3)
  <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="1">Interested</a>
  <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="6">Not Interested</a>
@else
 <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "{{ $h_notification->events->id }}" data-status="1">Attending</a>
 <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $h_notification->events->id }}" data-status="2">Not Attending</a>
 <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $h_notification->events->id }}" data-status="3">Tentative</a>

@endif
@endif
@endif
@endif
</div>
</div>
</div> 
</div>                   
      
@endforeach
@endif