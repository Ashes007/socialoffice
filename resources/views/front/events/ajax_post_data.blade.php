    <?php 
      $event_type = $record->type_id;
      $comm_share_permission_actv_grp = Auth::user()->can('comment-share-activity-event'); 
      $comm_share_permission_global_grp = Auth::user()->can('comment-share-global-event');
      $comm_share_permission_dept_grp = Auth::user()->can('comment-share-departmental-event'); 
      $post_permission_global_event =Auth::user()->can('post-global-event');
      $post_permission_departmental_event =Auth::user()->can('post-departmental-event');
      $post_permission_activity_event =Auth::user()->can('post-activity-event');

      $like_permission_global_event =Auth::user()->can('like-global-event');
      $like_permission_departmental_event =Auth::user()->can('like-departmental-event');
      $like_permission_activity_event =Auth::user()->can('like-activity-event');

      $post_delete_permission_global_event =Auth::user()->can('post-delete-global-event');
      $post_delete_permission_departmental_event =Auth::user()->can('post-delete-departmental-event');
      $post_delete_permission_activity_event =Auth::user()->can('post-delete-activity-event');

      $comment_delete_permission_global_event =Auth::user()->can('comment-delete-global-event');
      $comment_delete_permission_departmental_event =Auth::user()->can('comment-delete-departmental-event');
      $comment_delete_permission_activity_event =Auth::user()->can('comment-delete-activity-event');

 
      if($event_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($event_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($event_type==3){ $permission_share = $comm_share_permission_actv_grp;}

      if($event_type==1) { $permission_like =$like_permission_global_event;} elseif($event_type==2){ $permission_like = $like_permission_departmental_event;} elseif($event_type==3){ $permission_like = $like_permission_activity_event;}

      if($event_type==1) { $permission_post =$post_permission_global_event;} elseif($event_type==2){ $permission_post = $post_permission_departmental_event;} elseif($event_type==3){ $permission_post = $post_permission_activity_event;}

      if($event_type==1) { $permission_delete_post =$post_delete_permission_global_event;} elseif($event_type==2){ $permission_delete_post = $post_delete_permission_departmental_event;} elseif($event_type==3){ $permission_delete_post = $post_delete_permission_activity_event;}

      if($event_type==1) { $permission_delete_comment =$comment_delete_permission_global_event;} elseif($event_type==2){ $permission_delete_comment = $comment_delete_permission_departmental_event;} elseif($event_type==3){ $permission_delete_comment = $comment_delete_permission_activity_event;}
?>


@if(count($post_record)>0) 
@foreach($post_record as $post)

    <div class="timelineBlock">
         <div class="time-postedBy">
           <div class="image-div">
             
             @if($post->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $post->user->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$post->user->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt="">
                  @endif 
           </div>
           <h2><a href="{{URL::Route('user_profile').'/'.($post->user->ad_username)}}">{{ $post->user->display_name }}</a></h2>
           <p>{{$post->location}} {{date('F d, Y',strtotime($post->created_at))}}</p>

           @if(($record->user_id == \Auth::guard('user')->user()->id) || $permission_delete_post==1)
              <!-- <div class="nav-func">
                  <ul>
                    <li>
                      <a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a>
                    </li>
                  </ul>
                </div> -->
                <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" style="color:#f29134" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a></span></div>
           @endif
         </div>
         <div class="postedTime-image">
             @if($post->vimeo_upload == 'Yes')
                <iframe src="https://player.vimeo.com/video/{{ $post->vimeo_video_id }}" width="580" height="420" frameborder="0" mozallowfullscreen webkitallowfullscreen allowfullscreen></iframe>
              @endif
              <?php if(file_exists( public_path('uploads/posts/thumbnails/'.$post->image) )&& ($post->image!='' || $post->profile_photo!=NULL)) {?>
             <img src="{{ asset('uploads/posts/thumbnails/').'/'.$post->image }}"/>
             <?php }?>               
               <h2>{{$post->text}}</h2>
               <input type="hidden" value="{{$post->id}}" class="piscls" alt="{{$post->id}}" id="pid_{{$post->id}}" />
          </div>
         <!-- <div class="postedTime-image">
           <h2>{!! $post->text !!}</h2>
         </div> -->
         @if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1)
    <?php $cls = 'active'; ?>
    @else
     <?php $cls = ''; ?>
    @endif
         

<div class="likeComment">
 <div class="row">
   <div class="col-sm-5">
    @if($permission_like==1)
    @if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1)
    <?php $cls = 'active_lk'; ?>
    @else
     <?php $cls = ''; ?>
    @endif
     <button class="face-like {{$cls}}"  type="button" id="lkid_{{$post->id}}" alt="{{$post->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ trans('common.like') }}</button>
    @endif
   </div>
   <div class="col-sm-7">
     <p><a  class='cntlikecls' href="{{URL::Route('eventlikelist').'/'.$post->id.'/'.encrypt($record->id)}}"><span id="likecnt_id_{{$post->id}}" class="likecls">{{count($post->likes)}} {{ trans('common.likes') }} </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$post->id}}" id="cmncnt_id_{{$post->id}}">{{count($post->comments)}} {{ trans('common.comments') }}</a></p>
     <input type="hidden" value="{{count($post->comments)}}" id="cmntid_{{$post->id}}" />
     <input type="hidden" value="{{count($post->likes)}}" id="likeid_{{$post->id}}" />
   </div>
 </div>
</div>


<div class="comment-other">
     @if(count($post->comments)) <?php  $i = 0; ?>  
     @foreach($post->comments as $comment) <?php $i ++; ?>
       
       @if($i==1 && count($post->comments)>1) <div id="comment_{{$post->id}}" style="display:none;"> @endif
         
         <div class="comment-other-single">
           <div class="image-div">
              @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
              @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt="">
              @endif 
           </div>
           <h2><a href="{{URL::Route('user_profile').'/'.($comment->user->ad_username)}}">{{ $comment->user->display_name }}</a> <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}</span></h2>
           <p>{{$comment->body}}</p>
         </div>
         @if($i==(count($post->comments)-1)) </div> @endif
       
     @endforeach
     @endif
     <div id="commentsnwid_{{$post->id}}" class="comment-other"></div>
 </div>
        
@if($permission_share == 1)   
   <div class="comment-field">
     <div class="image-div">
     @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
          @else
          <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
          @endif                      
      </div>                                       
      <textarea data-post_id="{{$post->id}}" class="cmntcls" name="comment_text" placeholder="{{ trans('common.press_enter_to_post_comment') }}"></textarea> 
    </div>                       
@endif 
       </div>  
@endforeach

@endif