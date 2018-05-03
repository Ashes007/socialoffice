@php
    $group_type = $group_details->group_type_id;
    $comm_share_permission_actv_grp = Auth::user()->can('comment-share-activity-group'); 
    $comm_share_permission_global_grp = Auth::user()->can('comment-share-global-group');
    $comm_share_permission_dept_grp = Auth::user()->can('comment-share-departmental-group'); 
    $post_permission_global_group =Auth::user()->can('post-global-group');
    $post_permission_departmental_group =Auth::user()->can('post-departmental-group');
    $post_permission_activity_group =Auth::user()->can('post-activity-group');

    $like_permission_global_group =Auth::user()->can('like-global-group');
    $like_permission_departmental_group =Auth::user()->can('like-departmental-group');
    $like_permission_activity_group =Auth::user()->can('like-activity-group');

    $post_delete_permission_global_group =Auth::user()->can('post-delete-global-group');
    $post_delete_permission_departmental_group =Auth::user()->can('post-delete-departmental-group');
    $post_delete_permission_activity_group =Auth::user()->can('post-delete-activity-group');

    $comment_delete_permission_global_group =Auth::user()->can('comment-delete-global-group');
    $comment_delete_permission_departmental_group =Auth::user()->can('comment-delete-departmental-group');
    $comment_delete_permission_activity_group =Auth::user()->can('comment-delete-activity-group');

    if($group_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}

    if($group_type==1) { $permission_like =$like_permission_global_group;} elseif($group_type==2){ $permission_like = $like_permission_departmental_group;} elseif($group_type==3){ $permission_like = $like_permission_activity_group;}

    if($group_type==1) { $permission_delete_post =$post_delete_permission_global_group;} elseif($group_type==2){ $permission_delete_post = $post_delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete_post = $post_delete_permission_activity_group;}

    if($group_type==1) { $permission_delete_comment =$comment_delete_permission_global_group;} elseif($group_type==2){ $permission_delete_comment = $comment_delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete_comment = $comment_delete_permission_activity_group;}
@endphp   
@if(count($group_posts)>0)
@foreach($group_posts as $post)
@if(($post->vimeo_upload == 'No') || ($post->vimeo_upload == 'Yes' && $post->is_video_published == 'Yes'))
  <div class="timelineBlock" >
    <div class="time-postedBy">
      <div class="image-div">
      <?php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$post->profile_photo) )&& ($post->profile_photo!='' || $post->profile_photo!=NULL)) {?>
      <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/').'/'.$post->profile_photo }}"/>
      <?php }else{ ?>
      <img src="{{ asset('uploads/no_img.png') }}"/>
      <?php  } ?>
      </div>
      <h2><a href="{{URL::Route('user_profile').'/'.($post->ad_username)}}">{{$post->display_name}}</a></h2>
      <p>{{$post->location}} @if($post->location!='') - @endif {{date('F d, Y',strtotime($post->created_at))}}</p>

      @if(($group_details->user_id == \Auth::guard('user')->user()->id) || $permission_delete_post==1 || (is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0))
      <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" class="deletepost" title="Delete Post"  style="color:#f29134" ><i class="fa fa-times" aria-hidden="true"></i></a></span></div>
      
      <!-- <div class="nav-func">
       <ul>
         <li><a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times" aria-hidden="true"></i></a></li>
       </ul>
      </div> -->
      @endif
    </div>
    <div class="postedTime-image">
    @if($post->vimeo_upload == 'Yes')
                <iframe src="https://player.vimeo.com/video/{{ $post->vimeo_video_id }}" width="580" height="420" frameborder="0" mozallowfullscreen webkitallowfullscreen allowfullscreen></iframe>
              @endif
    <?php if(file_exists( public_path('uploads/post_images/'.$post->image) )&& ($post->image!='' || $post->image!=NULL)) {?>
    <img src="{{ asset('uploads/post_images/').'/'.$post->image }}" width="799"/>
    <?php }?>               
    <h2>@php echo nl2br($post->text) @endphp</h2>
    <input type="hidden" value="{{$post->id}}" class="piscls" alt="{{$post->id}}" id="pid_{{$post->id}}" />
    </div>
    <div class="likeComment">
      <div class="row">
        <div class="col-sm-5">
          @if($permission_like==1)
          @if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1)
          <?php $cls = 'active_lk'; ?>
          @else
          <?php $cls = ''; ?>
          @endif
          <button class="face-like {{$cls}}"  type="button" id="lkid_{{$post->id}}" alt="{{$post->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> {{ __('common.like')}}</button>
          @endif
        </div>
        <div class="col-sm-7">
          <p><a  class='cntlikecls' href="{{URL::Route('likelist').'/'.$post->id.'/'.$group_encode_id}}"><span id="likecnt_id_{{$post->id}}" class="likecls">{{count($post->likes)}} {{ __('common.likes')}} </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$post->id}}" id="cmncnt_id_{{$post->id}}">{{count($post->comments)}} {{ __('common.comments')}}</a></p>
          <input type="hidden" value="{{count($post->comments)}}" id="cmntid_{{$post->id}}" />
          <input type="hidden" value="{{count($post->likes)}}" id="likeid_{{$post->id}}" />
        </div>
      </div>
    </div>
    <div class="comment-other">
      @if(count($post->comments))   <?php  $i = 0; ?>           
      @foreach($post->comments as $comment) <?php $i ++; ?>
      @if($i==1 && count($post->comments)>1)<div id="comment_{{$post->id}}" style="display:none;">@endif
      <div class="comment-other-single">
        <div class="image-div">
        @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
        @else
        <img src="{{ asset('uploads/no_img.png') }}" alt="">
        @endif    
        </div>
        <h2><a href="{{URL::Route('user_profile').'/'.($comment->user->ad_username)}}">{{ $comment->user->display_name }}</a>
        @if(($group_details->user_id == \Auth::guard('user')->user()->id) || $permission_delete_comment==1 || (is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0))
        <span style="float: right;"><a href="javascript::void(0);" alt="{{$comment->id}}" data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"><i class="fa fa-times" aria-hidden="true"></i></a></span>&nbsp; 
        @endif
        <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}&nbsp;&nbsp;</span></h2>
        <p>{{$comment->body}}</p>
      </div>
      @if($i==(count($post->comments)-1)) </div> @endif
      @endforeach                
      @endif
      <div id="commentsnwid_{{$post->id}}">
      </div> 
    </div>
    @if($permission_share==1 || ($group_details->user_id == \Auth::guard('user')->user()->id)) 
    <div class="comment-field">
      <div class="image-div">
        @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
        @else
        <img src="{{ asset('uploads/no_img.png') }}" alt=""/>
        @endif                      
      </div>                      
      <textarea id="commentid_{{$post->id}}" alt="{{$post->id}}" class="cmntcls" name="comment_text" placeholder="{{ __('common.press_enter_to_post_comment')}}"></textarea>                 
    </div>
    @endif
  </div>
@endif
@endforeach            
@endif
