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



   <?php if($post->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $post->user->profile_photo))): ?>
            <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$post->user->profile_photo)); ?>" alt=""/>
          <?php else: ?>
          <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
      <?php endif; ?> 
  </div>
   <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($post->user->ad_username)); ?>"><?php echo e($post->user->display_name); ?></a></h2>
   <p><?php echo e($post->location); ?>  <?php echo e(date('F d, Y',strtotime($post->created_at))); ?></p>

   <?php if(($event_creator == \Auth::guard('user')->user()->id) || $permission_delete_post==1): ?>
               <!--  <div class="nav-func">
                  <ul>
                    <li>
                      <a href="javascript::void(0);" alt="<?php echo e($post->id); ?>" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a>
                    </li>
                  </ul>
                </div> -->
    <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="<?php echo e($post->id); ?>" data-toggle="tooltip" class="deletepost" style="color:#f29134" title="Delete Post"><i class="fa fa-times"></i></a></span></div>            
   <?php endif; ?>
 </div>
 
 <div class="postedTime-image">
     <?php if($post->vimeo_upload == 'Yes'): ?>
        <iframe src="https://player.vimeo.com/video/<?php echo e($post->vimeo_video_id); ?>" width="580" height="420" frameborder="0" mozallowfullscreen webkitallowfullscreen allowfullscreen></iframe>
      <?php endif; ?>
      <?php if(file_exists( public_path('uploads/posts/thumbnails/'.$post->image) )&& ($post->image!='' || $post->profile_photo!=NULL)) {?>
     <img src="<?php echo e(asset('uploads/posts/thumbnails/').'/'.$post->image); ?>"/>
     <?php }?>               
       <h2><?php echo e($post->text); ?></h2>
       <input type="hidden" value="<?php echo e($post->id); ?>" class="piscls" alt="<?php echo e($post->id); ?>" id="pid_<?php echo e($post->id); ?>" />
  </div>
<?php if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1): ?>
                    <?php $cls = 'active'; ?>
                    <?php else: ?>
                     <?php $cls = ''; ?>
                    <?php endif; ?>

<div class="likeComment">
             <div class="row">
               <div class="col-sm-5">
             <?php if($permission_like==1): ?>
                 <button class="face-like <?php echo e($cls); ?>"  type="button" id="lkid_<?php echo e($post->id); ?>" alt="<?php echo e($post->id); ?>" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
              <?php endif; ?>
               </div>
               <div class="col-sm-7">
       <p><span id="likecnt_id_<?php echo e($post->id); ?>" class="likecls"><?php echo e(count($post->likes)); ?> Likes </span>- <a href="javascript:void(0);" class="user-com" data-target="1" id="cmncnt_id_<?php echo e($post->id); ?>"><?php echo e(count($post->comments)); ?> Comments</a></p>
       <input type="hidden" value="<?php echo e(count($post->comments)); ?>" id="cmntid_<?php echo e($post->id); ?>" />
       <input type="hidden" value="<?php echo e(count($post->likes)); ?>" id="likeid_<?php echo e($post->id); ?>" />
     </div>
             </div>
</div>

<div id="commentsnwid_<?php echo e($post->id); ?>" class="comment-other"></div> 
 <div class="comment-field">
     <div class="image-div">
     <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))): ?>
            <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/>
          <?php else: ?>
          <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/>
          <?php endif; ?>                      
      </div> 
      <?php if($permission_share == 1): ?>        
          <textarea data-post_id="<?php echo e($post->id); ?>" class="cmntcls" name="comment_text" placeholder="Press Enter to post comment"></textarea> 
      <?php endif; ?>
                  
   </div>
</div>