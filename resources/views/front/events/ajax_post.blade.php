<div class="timelineBlock">
 <div class="time-postedBy">
   <div class="image-div">


    <?php 
      $event_type = $event_type;
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



   @if($post->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $post->user->profile_photo)))
            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$post->user->profile_photo) }}" alt=""/>
          @else
          <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt="">
      @endif 
  </div>
   <h2><a href="{{URL::Route('user_profile').'/'.($post->user->ad_username)}}">{{ $post->user->display_name }}</a></h2>
   <p>{{$post->location}}  {{date('F d, Y',strtotime($post->created_at))}}</p>

   @if(($event_creator == \Auth::guard('user')->user()->id) || $permission_delete_post==1)
               <!--  <div class="nav-func">
                  <ul>
                    <li>
                      <a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a>
                    </li>
                  </ul>
                </div> -->
    <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" class="deletepost" style="color:#f29134" title="Delete Post"><i class="fa fa-times"></i></a></span></div>            
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
@if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1)
                    <?php $cls = 'active'; ?>
                    @else
                     <?php $cls = ''; ?>
                    @endif

<div class="likeComment">
             <div class="row">
               <div class="col-sm-5">
             @if($permission_like==1)
                 <button class="face-like {{$cls}}"  type="button" id="lkid_{{$post->id}}" alt="{{$post->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
              @endif
               </div>
               <div class="col-sm-7">
       <p><span id="likecnt_id_{{$post->id}}" class="likecls">{{count($post->likes)}} Likes </span>- <a href="javascript:void(0);" class="user-com" data-target="1" id="cmncnt_id_{{$post->id}}">{{count($post->comments)}} Comments</a></p>
       <input type="hidden" value="{{count($post->comments)}}" id="cmntid_{{$post->id}}" />
       <input type="hidden" value="{{count($post->likes)}}" id="likeid_{{$post->id}}" />
     </div>
             </div>
</div>

<div id="commentsnwid_{{$post->id}}" class="comment-other"></div> 
 <div class="comment-field">
     <div class="image-div">
     @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
          @else
          <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
          @endif                      
      </div> 
      @if($permission_share == 1)        
          <textarea data-post_id="{{$post->id}}" class="cmntcls" name="comment_text" placeholder="Press Enter to post comment"></textarea> 
      @endif
                  
   </div>
</div>