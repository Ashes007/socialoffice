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


<?php if(count($post_record)>0): ?> 
<?php $__currentLoopData = $post_record; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="timelineBlock">
         <div class="time-postedBy">
           <div class="image-div">
             
             <?php if($post->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $post->user->profile_photo))): ?>
                        <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$post->user->profile_photo)); ?>" alt=""/>
                      <?php else: ?>
                      <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
                  <?php endif; ?> 
           </div>
           <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($post->user->ad_username)); ?>"><?php echo e($post->user->display_name); ?></a></h2>
           <p><?php echo e($post->location); ?> <?php echo e(date('F d, Y',strtotime($post->created_at))); ?></p>

           <?php if(($record->user_id == \Auth::guard('user')->user()->id) || $permission_delete_post==1): ?>
              <!-- <div class="nav-func">
                  <ul>
                    <li>
                      <a href="javascript::void(0);" alt="<?php echo e($post->id); ?>" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a>
                    </li>
                  </ul>
                </div> -->
                <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="<?php echo e($post->id); ?>" data-toggle="tooltip" style="color:#f29134" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a></span></div>
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
         <!-- <div class="postedTime-image">
           <h2><?php echo $post->text; ?></h2>
         </div> -->
         <?php if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1): ?>
    <?php $cls = 'active'; ?>
    <?php else: ?>
     <?php $cls = ''; ?>
    <?php endif; ?>
         

<div class="likeComment">
 <div class="row">
   <div class="col-sm-5">
    <?php if($permission_like==1): ?>
    <?php if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1): ?>
    <?php $cls = 'active_lk'; ?>
    <?php else: ?>
     <?php $cls = ''; ?>
    <?php endif; ?>
     <button class="face-like <?php echo e($cls); ?>"  type="button" id="lkid_<?php echo e($post->id); ?>" alt="<?php echo e($post->id); ?>" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo e(trans('common.like')); ?></button>
    <?php endif; ?>
   </div>
   <div class="col-sm-7">
     <p><a  class='cntlikecls' href="<?php echo e(URL::Route('eventlikelist').'/'.$post->id.'/'.encrypt($record->id)); ?>"><span id="likecnt_id_<?php echo e($post->id); ?>" class="likecls"><?php echo e(count($post->likes)); ?> <?php echo e(trans('common.likes')); ?> </span></a>- <a href="javascript:void(0);" class="user-com" data-target="<?php echo e($post->id); ?>" id="cmncnt_id_<?php echo e($post->id); ?>"><?php echo e(count($post->comments)); ?> <?php echo e(trans('common.comments')); ?></a></p>
     <input type="hidden" value="<?php echo e(count($post->comments)); ?>" id="cmntid_<?php echo e($post->id); ?>" />
     <input type="hidden" value="<?php echo e(count($post->likes)); ?>" id="likeid_<?php echo e($post->id); ?>" />
   </div>
 </div>
</div>


<div class="comment-other">
     <?php if(count($post->comments)): ?> <?php  $i = 0; ?>  
     <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php $i ++; ?>
       
       <?php if($i==1 && count($post->comments)>1): ?> <div id="comment_<?php echo e($post->id); ?>" style="display:none;"> <?php endif; ?>
         
         <div class="comment-other-single">
           <div class="image-div">
              <?php if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo))): ?>
                    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo)); ?>" alt=""/>
              <?php else: ?>
                  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
              <?php endif; ?> 
           </div>
           <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($comment->user->ad_username)); ?>"><?php echo e($comment->user->display_name); ?></a> <span><?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A')); ?></span></h2>
           <p><?php echo e($comment->body); ?></p>
         </div>
         <?php if($i==(count($post->comments)-1)): ?> </div> <?php endif; ?>
       
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     <?php endif; ?>
     <div id="commentsnwid_<?php echo e($post->id); ?>" class="comment-other"></div>
 </div>
        
<?php if($permission_share == 1): ?>   
   <div class="comment-field">
     <div class="image-div">
     <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))): ?>
            <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/>
          <?php else: ?>
          <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/>
          <?php endif; ?>                      
      </div>                                       
      <textarea data-post_id="<?php echo e($post->id); ?>" class="cmntcls" name="comment_text" placeholder="<?php echo e(trans('common.press_enter_to_post_comment')); ?>"></textarea> 
    </div>                       
<?php endif; ?> 
       </div>  
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>