<?php

$stat=0;
?>

<?php if(!empty($feeds)): ?>

<?php $__currentLoopData = $feeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedrecord): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
<?php if($feedrecord->type=='Event'): ?>
<?php
$feed = $feedrecord->event;
?>                      

<?php if(count($feed)): ?>

<?php
$stat=1;

?>
<!-- ------------ event - -- -->
<div class="timelineBlock eventblock margin-null">
  <div class="time-postedBy">
    <div class="image-div">
    <?php if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))): ?>
    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo)); ?>" alt=""/>
    <?php else: ?>
    <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
    <?php endif; ?>   
    </div>
    <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($feed->user->ad_username)); ?>"><?php echo e($feed->user->display_name); ?></a></h2>
    <p><?php echo e($feed->eventtype->name); ?> - <?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A')); ?></p>
  </div>
  <div class="postedTime-image">
  <?php if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))): ?> 
  <img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/event_images/original/'.$feed->eventImage[0]->image_name)); ?>&w=799&h=176&q=100" alt="">
  <?php else: ?>
  <img src="<?php echo e(asset('frontend/images/no-image-event-home.jpg')); ?>" alt="">
  <?php endif; ?>
  </div>

  <div class="likeComment learn">
    <div class="row">
      <div class="col-sm-12">

        <div class="eve-area">
        <div class="dates"><span><?php echo e(\Carbon\Carbon::parse($feed->event_start_date)->format('M')); ?></span> <?php echo e(\Carbon\Carbon::parse($feed->event_start_date)->format('d')); ?></div>
        <div class="eve-right">
        <h3><a href="<?php echo e(route('event_details', encrypt($feed->id))); ?>"><?php echo e(str_limit($feed->name,30,'...')); ?>


        <?php if($feed->event_start_date > $today): ?>
        <?php if($feed->getStatusUser($user_id,$feed->id) == 1 || $feed->getStatusUser($user_id,$feed->id) == 4): ?>
        <span> - <?php echo e(trans('common.attending')); ?></span> 
        <?php elseif($feed->getStatusUser($user_id,$feed->id) == 2 || $feed->getStatusUser($user_id,$feed->id) == 6): ?>
        <span class="not"> - <?php echo e(trans('common.not_attending')); ?></span>
        <?php endif; ?>
        <?php endif; ?>
        </a></h3>
        <h5 class="location"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo e(\Carbon\Carbon::parse($feed->event_start_date)->format('dS M Y')); ?> @ <?php if($feed->allday_event =='Yes'): ?> <?php echo e(trans('home.all_day')); ?> <?php else: ?> <?php echo e($feed->start_time); ?> - <?php echo e($feed->end_time); ?> <?php endif; ?></h5>
        <?php if($feed->location!=''): ?>
        <h5 class="location"><i class="fa fa-map-marker"></i><?php echo e($feed->location); ?></h5>
        <?php endif; ?>
        </div>
        <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ------------ event - -- -->
<?php endif; ?>
<?php elseif($feedrecord->type=='Group'): ?>

<!-- ------------ group - -- -->
<?php
$feed = $feedrecord->group;
?>
<?php if(count($feed)): ?> 
<?php        
$group_id = encrypt($feed->group_user_id);
?>

<?php if( is_member_group($user_id,$feed->group_user_id)>0 && is_member_group(\Auth::guard('user')->user()->id,$feed->group_user_id)): ?>
<?php  $stat=1;?>
<div class="timelineBlock groupblock">
  <div class="time-postedBy">
    <div class="image-div"> <?php if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))): ?>
    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo)); ?>" alt=""/>
    <?php else: ?>
    <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
    <?php endif; ?> 
    </div>
    <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($feed->user->ad_username)); ?>"><?php echo e($feed->user->display_name); ?></a></h2>
    <p><?php if($feed->group_type_id==1): ?> <?php echo e(trans('group.global')); ?> <?php elseif($feed->group_type_id==2): ?> <?php echo e(trans('group.departmental')); ?> <?php else: ?> <?php echo e(trans('group.activity_group')); ?> <?php endif; ?> - <?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A')); ?></p>
  </div>
  <div class="postedTime-image">
    <?php if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {?>
    <img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/group_images/').'/'.$feed->cover_image); ?>&w=799&h=176&q=100" alt=""/>
    <?php }else{ ?>
    <img src="<?php echo e(asset('frontend/images/no-image-event-details.jpg')); ?>"  />
    <?php  } ?>
  </div>

  <div class="likeComment learn">
    <div class="row">
      <div class="col-sm-12 col-lg-9">

      <p><?php echo e(trans('group.A_new_group')); ?> <strong><?php echo e($feed->group_name); ?></strong> <?php echo e(trans('group.has_been_published')); ?></p>
      </div>
      <div class="col-sm-12 col-lg-3">
      <a href="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>" class="view_all pull-right"> <?php echo e(trans('common.learn_more')); ?> </a>
      </div>
    </div>
  </div>

</div>
<?php endif; ?>
<?php endif; ?>
<!-- ------------ group - -- -->

<!-- ++++++++++++++++++++++++ occasion ++++++++++++++++++++++++++++++++ -->
<?php elseif($feedrecord->type=='Occasion'): ?>
<?php $feed = $feedrecord->occasion; 
$joindate=explode('-',$feed->user->date_of_joining);              
?>
<div class="timelineBlock">

  <div class="time-postedBy">
  <div class="image-div">
  <?php if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))): ?>
  <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo)); ?>" alt=""/>
  <?php else: ?>
  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
  <?php endif; ?>  
  </div>
  <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($feed->user->ad_username)); ?>"><?php echo e($feed->user->display_name); ?></a></h2>
  <p><?php echo e(trans('home.having')); ?> <?php if($feed->type=='BDAY'): ?><?php echo e(trans('home.birthday')); ?> <?php else: ?> <?php echo e(trans('home.job_anniversary')); ?> <?php endif; ?> <?php echo e(trans('home.on')); ?> <?php echo e(\DateTime::createFromFormat('Y-m-d', $feed->occation_date)->format('dS M Y ')); ?></p>
  </div>
  <?php if($feed->type=='BDAY'): ?>
  <div class="postedTime-image birth-area birth-area1">
  <img src="<?php echo e(asset('frontend/images/birthday.jpg')); ?>" alt="">
  <span><label><?php echo e(trans('home.is_having')); ?></label> <?php echo e(trans('home.birthday')); ?> <?php if($feed->occation_date == date('Y-m-d')): ?><?php echo e(trans('common.today')); ?>! <?php else: ?>  <?php echo e(trans('home.on')); ?> <?php echo e(\DateTime::createFromFormat('Y-m-d', $feed->occation_date)->format('dS M')); ?>! <?php endif; ?></span>

  </div>
  <?php else: ?>
  <div class="postedTime-image birth-area">
  <img src="<?php echo e(asset('frontend/images/aniversory.jpg')); ?>" alt="">
  <span><label><?php echo e($joindate[0]); ?></label> <?php echo e(trans('home.completed')); ?> <?php echo e(date('Y')-$joindate[0]); ?> <?php echo e(trans('home.years')); ?></span>

  </div>
  <?php endif; ?>

<div class="likeComment">
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4">

    <?php if(is_liked_occasion(\Auth::guard('user')->user()->id,$feed->id)==1): ?>

    <?php $cls = 'active_lk'; ?>
    <?php else: ?>
    <?php $cls = ''; ?>
    <?php endif; ?>
    <button class="face-like face-like-occation <?php echo e($cls); ?>"  type="button" id="lkoccid_<?php echo e($feed->id); ?>" alt="<?php echo e($feed->id); ?>" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo e(trans('common.like')); ?></button>
    <!--<button class="face-like" type="button" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>-->
    </div>

    <div class="col-sm-12 col-md-6 col-lg-8">
    <p><a  class='cntlikecls' href="<?php echo e(URL::Route('likelistocc').'/'.$feed->id); ?>"><span id="likeocccnt_id_<?php echo e($feed->id); ?>" class="likecls"><?php echo e(count($feed->likes)); ?> <?php echo e(trans('common.likes')); ?> </span></a>- <a href="javascript:void(0);" class="user-com" data-target="<?php echo e($feed->id); ?>" id="cmncntocc_id_<?php echo e($feed->id); ?>"><?php echo e(count($feed->comments)); ?> <?php echo e(trans('common.comments')); ?></a></p>
    <input type="hidden" value="<?php echo e(count($feed->comments)); ?>" id="cmntoccid_<?php echo e($feed->id); ?>" />
    <input type="hidden" value="<?php echo e(count($feed->likes)); ?>" id="likeoccid_<?php echo e($feed->id); ?>" />
    </div>
  </div>
</div>
<div class="comment-other">
  <?php if(count($feed->comments)): ?>   <?php  $i = 0; ?>           
  <?php $__currentLoopData = $feed->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php $i ++; ?>

  <?php if($i==1 && count($feed->comments)>1): ?><div id="comment_<?php echo e($feed->id); ?>" style="display:none;"><?php endif; ?>
  <div class="comment-other-single">
    <div class="image-div">
    <?php if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo))): ?>
    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo)); ?>" alt=""/>
    <?php else: ?>
    <img src="<?php echo e(asset('uploads/no_img.png')); ?>" alt="">
    <?php endif; ?>     </div>
    <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($comment->user->ad_username)); ?>"><?php echo e($comment->user->display_name); ?> </a><span><?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A')); ?></span></h2>
    <p><?php echo e($comment->body); ?></p>
  </div>
  <?php if($i==(count($feed->comments)-1)): ?> </div> <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                
  <?php endif; ?>
  <div id="commentsnwoccid_<?php echo e($feed->id); ?>">
  </div> 

</div>
<div class="comment-field">
  <div class="image-div">
  <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))): ?>
  <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/>
  <?php else: ?>
  <img src="<?php echo e(asset('uploads/no_img.png')); ?>" alt=""/>
  <?php endif; ?>
  </div>
  <textarea id="commentoccid_<?php echo e($feed->id); ?>" alt="<?php echo e($feed->id); ?>" class="cmntclsocc" name="comment_text" placeholder="<?php echo e(trans('common.press_enter_to_post_comment')); ?>"></textarea>
</div>
</div>



<!-- ++++++++++++++++++++++++ occasion ++++++++++++++++++++++++++++++++ -->

<?php elseif($feedrecord->type=='Post'): ?>
<!-- ------------ post with image - -- -->
<?php
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
?>
<?php if(count($feed) && $feed->group_id!=0): ?>    
<?php 
$group_id = encrypt($feed->group_id);
$group_type = group_type($feed->group_id);  
if($group_type==1) { $permission_share = $comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}

if($group_type==1) { $permission_like =$like_permission_global_group;} elseif($group_type==2){ $permission_like = $like_permission_departmental_group;} elseif($group_type==3){ $permission_like = $like_permission_activity_group;}

if($group_type==1) { $permission_delete_post =$post_delete_permission_global_group;} elseif($group_type==2){ $permission_delete_post = $post_delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete_post = $post_delete_permission_activity_group;}

if($group_type==1) { $permission_delete_comment =$comment_delete_permission_global_group;} elseif($group_type==2){ $permission_delete_comment = $comment_delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete_comment = $comment_delete_permission_activity_group;}
?>         
<?php if( is_member_group($userdetails->id,$feed->group_id)>0 && is_member_group(\Auth::guard('user')->user()->id,$feed->group_id)): ?>
<?php $stat=1;?>
<div class="timelineBlock">
  <div class="time-postedBy">
  <div class="image-div">
  <?php if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))): ?>
  <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo)); ?>" alt=""/>
  <?php else: ?>
  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
  <?php endif; ?>  
  </div>
  <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($feed->user->ad_username)); ?>"><?php echo e($feed->user->display_name); ?></a></h2>
  <p><?php echo e($feed->location); ?> <?php if($feed->location!=''): ?> - <?php endif; ?> <?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A')); ?></p>
  <?php if((get_owner_group($feed->group_id) == \Auth::guard('user')->user()->id) || $permission_delete_post==1 || (is_moderator_group(\Auth::guard('user')->user()->id,encrypt($feed->group_id))>0)): ?>
  <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="<?php echo e($feed->id); ?>" data-toggle="tooltip" em="<?php echo e($feed->group_id); ?>" class="deletepost" title="Delete Post" style="color:#f29134"><i class="fa fa-times" aria-hidden="true"></i></a></span> </div>

 <!-- <div class="nav-func">
  <ul>
    <li><a href="javascript::void(0);" alt="<?php echo e($feed->id); ?>" data-toggle="tooltip" em="<?php echo e($feed->group_id); ?>" class="deletepost" title="Delete Post"><i class="fa fa-times" aria-hidden="true"></i></a></li>
  </ul>
</div> -->
  <?php endif; ?>
  </div>
<div class="postedTime-image">

<?php if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image))): ?>
<img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/post_images/'.$feed->image)); ?>&w=799&h=175&q=100" alt=""/>
<?php if($feed->text!=''): ?>
<p>&nbsp;</p>
<p><?php echo nl2br($feed->text) ?></p>
<?php endif; ?>        
<?php else: ?>
<?php if($feed->text!=''): ?>
<h2><?php echo nl2br($feed->text) ?></h2>
<?php endif; ?>

<?php endif; ?> 
<p>&nbsp;</p> - <b><?php echo e(trans('home.posted_in')); ?> <a href ="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>"><?php echo e(group_name($feed->group_id)); ?> </b></a>
</div>
  <div class="likeComment">
  <div class="row">
  <div class="col-sm-12 col-md-6 col-lg-4">

  <?php if($permission_like==1): ?>
  <?php if(is_liked_post(\Auth::guard('user')->user()->id,$feed->id)==1): ?>


  <?php $cls = 'active_lk'; ?>
  <?php else: ?>
  <?php $cls = ''; ?>
  <?php endif; ?>
  <!-- <button class="face-like" type="button" name="button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>-->
  <button class="face-like-post face-like <?php echo e($cls); ?>"  type="button" id="lkid_<?php echo e($feed->id); ?>" alt="<?php echo e($feed->id); ?>" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo e(trans('common.like')); ?></button>
  <?php endif; ?>
  </div>
  <div class="col-sm-12 col-md-6 col-lg-8">
  <p><a  class='cntlikecls' href="<?php echo e(URL::Route('likelist').'/'.$feed->id.'/'.$group_id); ?>"><span id="likecnt_id_<?php echo e($feed->id); ?>" class="likecls"><?php echo e(count($feed->likes)); ?> <?php echo e(trans('common.likes')); ?> </span></a>- <a href="javascript:void(0);" class="user-com" data-target="<?php echo e($feed->id); ?>" id="cmncnt_id_<?php echo e($feed->id); ?>"><?php echo e(count($feed->comments)); ?> <?php echo e(trans('common.comments')); ?></a></p>
  <input type="hidden" value="<?php echo e(count($feed->comments)); ?>" id="cmntid_<?php echo e($feed->id); ?>" />
  <input type="hidden" value="<?php echo e(count($feed->likes)); ?>" id="likeid_<?php echo e($feed->id); ?>" />
  </div>
  </div>
  </div>
<div class="comment-other" id="comment_2">
  <?php if(count($feed->comments)): ?>   <?php  $i = 0; ?>           
  <?php $__currentLoopData = $feed->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php $i ++; ?>

  <?php if($i==1 && count($feed->comments)>1): ?><div id="comment_<?php echo e($feed->id); ?>" style="display:none;"><?php endif; ?>
  <div class="comment-other-single">
    <div class="image-div">
    <?php if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo))): ?>
    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo)); ?>" alt=""/>
    <?php else: ?>
    <img src="<?php echo e(asset('uploads/no_img.png')); ?>" alt="">
    <?php endif; ?>     </div>
    <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($comment->user->ad_username)); ?>"><?php echo e($comment->user->display_name); ?></a> 
    <?php if((get_owner_group($feed->group_id) == \Auth::guard('user')->user()->id) || $permission_delete_comment==1 || (is_moderator_group(\Auth::guard('user')->user()->id,encrypt($feed->group_id))>0)): ?>
    <span style="float: right;"><a href="javascript::void(0);" alt="<?php echo e($comment->id); ?>" em="<?php echo e($feed->group_id); ?>"  data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"><i class="fa fa-times" aria-hidden="true"></i></a></span>&nbsp; 
    <?php endif; ?><span><?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A')); ?>&nbsp;&nbsp;</span></h2>
    <p><?php echo e($comment->body); ?></p>
  </div>
  <?php if($i==(count($feed->comments)-1)): ?> </div> <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                
  <?php endif; ?>
  <div id="commentsnwid_<?php echo e($feed->id); ?>">
  </div> 

</div>
<!-- for later -->
<?php if($permission_share==1 ): ?> 
<div class="comment-field">
  <div class="image-div">
  <?php if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' .\Auth::guard('user')->user()->profile_photo))): ?>
  <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo)); ?>" alt=""/>
  <?php else: ?>
  <img src="<?php echo e(asset('uploads/no_img.png')); ?>" alt=""/>
  <?php endif; ?>
  </div>
  <textarea id="commentid_<?php echo e($feed->id); ?>" alt="<?php echo e($feed->id); ?>" class="cmntcls" name="comment_text" placeholder="<?php echo e(trans('common.press_enter_to_post_comment')); ?>"></textarea>
</div>
<?php endif; ?>
<!-- for later -->
</div>   
<?php endif; ?>      
<!-- ------------ post with image - -- -->
<?php endif; ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>