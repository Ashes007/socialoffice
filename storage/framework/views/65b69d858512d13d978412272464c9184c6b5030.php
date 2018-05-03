<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>



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

      $invite_permission_global_event =Auth::user()->can('invite-global-event');
      $invite_permission_departmental_event =Auth::user()->can('invite-departmental-event');
      $invite_permission_activity_event =Auth::user()->can('invite-activity-event');


      if($event_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($event_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($event_type==3){ $permission_share = $comm_share_permission_actv_grp;}

      if($event_type==1) { $permission_like =$like_permission_global_event;} elseif($event_type==2){ $permission_like = $like_permission_departmental_event;} elseif($event_type==3){ $permission_like = $like_permission_activity_event;}

      if($event_type==1) { $permission_post =$post_permission_global_event;} elseif($event_type==2){ $permission_post = $post_permission_departmental_event;} elseif($event_type==3){ $permission_post = $post_permission_activity_event;}

      if($event_type==1) { $permission_delete_post =$post_delete_permission_global_event;} elseif($event_type==2){ $permission_delete_post = $post_delete_permission_departmental_event;} elseif($event_type==3){ $permission_delete_post = $post_delete_permission_activity_event;}

      if($event_type==1) { $permission_delete_comment =$comment_delete_permission_global_event;} elseif($event_type==2){ $permission_delete_comment = $comment_delete_permission_departmental_event;} elseif($event_type==3){ $permission_delete_comment = $comment_delete_permission_activity_event;}

      if($event_type==1) { $permission_invite =$invite_permission_global_event;} elseif($event_type==2){ $permission_invite = $invite_permission_departmental_event;} elseif($event_type==3){ $permission_invite = $invite_permission_activity_event;}
?>


<div class="home-container">
     <div class="container">

       <?php echo $__env->make('front.includes.event_sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

       <div class="timeline-photo eve-top rounded-ban">
         <?php if(isset($record->eventImage[0]->image_name) && file_exists(public_path('uploads/event_images/original/'.$record->eventImage[0]->image_name))): ?>
            
            <img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/event_images/original/'.$record->eventImage[0]->image_name)); ?>&w=1250&h=200&q=100" alt="img" />
          <?php else: ?>
          <img src="<?php echo e(asset('frontend/images/no-image-event-details.jpg')); ?>" alt="">
          <?php endif; ?>


         <div class="fixme">

         <div class="timeline-cont">
           <div class="row">
             <div class="col-sm-12">
               <div class="timeline-profile event-date">
                 <div class="image-div"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                 <h2><?php echo e(\Carbon\Carbon::parse($record->event_start_date)->format('dS')); ?></h2>
                 <p><?php echo e(\Carbon\Carbon::parse($record->event_start_date)->format('F')); ?></p>
               </div>

               <div class="evetitle"><p><?php echo e($record->name); ?></p></div>
             </div>

           </div>
         </div>

         </div>

       </div>


       <div class="timeline-nav clearfix eventtitle1 border-time">
         <h3><?php if($record->type_id == 1): ?> <?php echo e(trans('eventDetails.Global')); ?>  <?php elseif($record->type_id == 2): ?> <?php echo e(trans('eventDetails.Departmental')); ?>  <?php elseif($record->type_id == 3): ?> <?php echo e(trans('eventDetails.Activity')); ?>  <?php endif; ?> <?php echo e(trans('eventDetails.Event')); ?>, <?php echo e(trans('eventDetails.created_by')); ?><span><a href="<?php echo e(URL::Route('user_profile').'/'.($record->user->ad_username)); ?>"> <?php echo e($record->user->display_name); ?> </a></span></h3>
         
         <div class="pull-right">
             <div class="status_button">
                  <?php if($record->event_start_date <= $today): ?>
                      
                          <?php if($record->getStatus($record->id) == 1): ?>
                              <div class="attend_status_button"><?php echo e(trans('buttonTxt.attended')); ?></div>
                          <?php elseif($record->getStatus($record->id) == 2): ?>
                              <div class="attend_status_button"> <?php echo e(trans('buttonTxt.not_attended')); ?></div>
                          <?php elseif($record->getStatus($record->id) == 3): ?>
                              <div class="attend_status_button"><?php echo e(trans('buttonTxt.tentative')); ?></div>
                          <?php elseif($record->getStatus($record->id) == 4): ?>
                              <div class="attend_status_button"> <?php echo e(trans('buttonTxt.interested')); ?></div>
                          <?php elseif($record->getStatus($record->id) == 4): ?>
                              <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_interested')); ?></div>
                          <?php elseif($record->getStatus($record->id) == 6): ?>
                              <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_attended')); ?></div>
                          <?php else: ?>
                              <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_attended')); ?></div>
                          <?php endif; ?>
                      
                  <?php else: ?>
                        
                          <?php if($record->event_end_date > $today): ?>
                            <?php if($isInvited > 0): ?>
                              <?php if($record->getStatus($record->id) == 1 || $record->getStatus($record->id) == 4): ?>
                                    <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "<?php echo e($record->id); ?>" data-status="6"><?php echo e(trans('buttonTxt.not_attend')); ?></a>
                                <?php elseif($record->getStatus($record->id) == 2 || $record->getStatus($record->id) == 5 || $record->getStatus($record->id) == 6): ?>
                                    <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "<?php echo e($record->id); ?>" data-status="1"><?php echo e(trans('buttonTxt.attend')); ?></a>
                                <?php elseif($record->getStatus($record->id) == 3): ?>
                                  <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "<?php echo e($record->id); ?>" data-status="1"><?php echo e(trans('buttonTxt.interested')); ?></a>
                                  <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "<?php echo e($record->id); ?>" data-status="6"><?php echo e(trans('buttonTxt.not_interested')); ?></a>
                                <?php else: ?>
                                 <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "<?php echo e($record->id); ?>" data-status="1"><?php echo e(trans('buttonTxt.attending')); ?></a>
                                 <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "<?php echo e($record->id); ?>" data-status="2"><?php echo e(trans('buttonTxt.not_attending')); ?></a>
                                 <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "<?php echo e($record->id); ?>" data-status="3"><?php echo e(trans('buttonTxt.tentative')); ?></a>
                              <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                        
                <?php endif; ?>
            </div>
         </div>
       </div>


       <div class="row">       
         <div class="col-sm-8">
         <?php if(session('success')): ?>
          <div class="alert alert-success">
          <?php echo e(session('success')); ?>

          </div>
          <?php endif; ?>

         <div class="eve-map">
         <h5 class="cal"><i class="fa fa-calendar-check-o"></i><?php echo e(\Carbon\Carbon::parse($record->event_start_date)->format('dS M Y')); ?> <?php if($record->event_end_date > $record->event_start_date): ?> - <?php echo e(\Carbon\Carbon::parse($record->event_end_date)->format('dS M Y')); ?> <?php endif; ?> @ <?php if($record->allday_event =='Yes'): ?> <?php echo e(trans('eventDetails.all_day')); ?> <?php else: ?> <?php echo e($record->start_time); ?> - <?php echo e($record->end_time); ?> <?php endif; ?></h5>
         
         <?php if($record->location!=''): ?>
           <h5 class="location"><i class="fa fa-map-marker"></i><?php echo e($record->location); ?></h5>           
           <div class="map-sec" id="map_canvas" style="height: 192px;">
           </div>
         <?php endif; ?>
         <?php if($record->location!=''): ?>
         <div class="get_directionSection">
         <input id="origin-input" class="controls" type="text"
        placeholder="<?php echo e(trans('eventDetails.Enter_your_location')); ?>" onFocus="geolocate()">
         <a href="javascript:void(0);" id="getDirection" class="fileContainer"><?php echo e(trans('buttonTxt.get_direction')); ?></a>
         <div id="directions-panel" style="display: none;"></div>
         </div>
         <?php endif; ?>
         
         </div>
         <?php if($permission_post == 1): ?>

         <?php echo e(Form::open(array('route' => ['event_post_create'],'id'=>'PostFrm', 'files' => true))); ?>

         
           <div class="post-timeline new-post">
             <textarea placeholder="<?php echo e(trans('common.what_is_in_your_mind')); ?>" id="post_text" name="post_text"></textarea>
             <div id="targetLayer"></div>
             
             <input type="hidden" name="location" id="locationtxtid">         
             <input type="hidden" name="event_id" value="<?php echo e($record->id); ?>">
             <div class="post-bar">
              <div id="locationid"></div>
               <div class="row">
                 <div class="col-sm-10">
                   <ul class="nav-varient">
                    <li><a href="javascript:void(0);" id="find_btn"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li> 
                     <li><a href="javascript:void(0);" class="con-choose-image"><input name="post_image" id="postimgid" type="file" class="inputFile" onChange="showPreview(this);" /></a>
                     </li>
                     <li><a href="#" class="con-choose-video"><input name="post_video" id="post_video" type="file" onChange="checkVideo(this);" /></a> </li>
                     <li><span id="video_name"></span> <span style="display: none;" id="remove_video"  class="remove_video">X</span></li>
                     <li id="uploading_video" style="display: none; color:#41c1e4; font-weight:bold; font-size: 12px;">Uploading <img src="<?php echo e(asset('frontend/images/uploading.gif')); ?>" alt="" width="120"></li>
                   </ul>
                 </div>
                 <div class="col-sm-2">
                   <div class="pull-right">
                     <input type="submit" id="event_post" data-EventId = "<?php echo e($record->id); ?>" name="event_post" value="<?php echo e(trans('buttonTxt.post')); ?>">
                   </div>
                 </div>
               </div>
             </div>
           </div>

           <?php echo e(Form::close()); ?>

           <?php endif; ?>


          <div class="form_submit_msg" id="success_message" style="display: none;">
            <div class="succ_img" id="uploaded_message"></div>
          </div>
           <div class="timeline-blockMain" id="timeline_post">
              <?php if(count($post_record)>0): ?> 
                <?php $__currentLoopData = $post_record; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if(($post->vimeo_upload == 'No') || ($post->vimeo_upload == 'Yes' && $post->is_video_published == 'Yes')): ?>
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
                            <div class="nav-func postcrossicon"><span class="delpost"><a href="javascript::void(0);" alt="<?php echo e($post->id); ?>" style="color:#f29134" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a></span></div>
                              <!-- <div class="nav-func">
                                <ul>
                                  <li>
                                      <a href="javascript::void(0);" alt="<?php echo e($post->id); ?>" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-times"></i></a>
                                  </li>
                                </ul>
                              </div> -->
                            <?php endif; ?>
                         </div>
                         <div class="postedTime-image">
                            <?php if($post->vimeo_upload == 'Yes'): ?>
                              <iframe src="https://player.vimeo.com/video/<?php echo e($post->vimeo_video_id); ?>" width="100%" height="420" frameborder="0" mozallowfullscreen webkitallowfullscreen allowfullscreen></iframe>
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
                                   <h2><a href="<?php echo e(URL::Route('user_profile').'/'.($comment->user->ad_username)); ?>"><?php echo e($comment->user->display_name); ?></a>
                                   <?php if(($record->user_id == \Auth::guard('user')->user()->id) || $permission_delete_comment==1 ): ?>
                                      <span style="float: right;">
                                                  <a href="javascript::void(0);" alt="<?php echo e($comment->id); ?>" data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"> &nbsp;&nbsp;<i class="fa fa-times"></i></a>
                                      </span>
                                    <?php endif; ?>
                                   <span><?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A')); ?></span></h2>
                                   <p><?php echo e($comment->body); ?></p>
                                 </div>
                                 <?php if($i==(count($post->comments)-1)): ?> </div> <?php endif; ?>
                               
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php endif; ?> 

                             <div id="commentsnwid_<?php echo e($post->id); ?>" class="commentsnwid" style="display: none;" ></div>                    
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
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>  
                  <div id="no_post" class="no_post timelineBlock"><?php echo e(trans('common.be_the_first_one_to_post_here')); ?></div>
              <?php endif; ?>              
              
           </div>
           <div class=" ajax-loading" style="text-align: center;"><img src="<?php echo e(asset('frontend/images/Spin.gif')); ?>" alt=""/> <span><?php echo e(trans('common.load_more')); ?></span></div>

         </div>


         <div class="col-sm-4">
          <div class="right-sidebar clearfix">
          <?php if($record->event_start_date > $today): ?>
            <?php if($logged_in_user == $record->user_id): ?>
            <div class="recentUpdates alt">
              <h2 class="white-bg"><?php echo e(trans('common.action')); ?></h2>
              <div class="cont-wrap">          

                  <button class="normbutton" type="button" name="button" id="delete_event"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('buttonTxt.delete')); ?></button>
                  <button class="normbutton" alt="Edit" id="edit_event" ><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo e(trans('buttonTxt.edit')); ?></button>
              </div>
            </div>
            <?php endif; ?>
          <?php endif; ?>

            <div class="recentUpdates alt">
              <h2 class="white-bg"><?php echo e(trans('common.description')); ?></h2>
              <div class="cont-wrap">                
                <?php echo $record->description; ?>

              </div>
            </div>

             <div class="recentUpdates alt event-side">
              <h2 class="white-bg">
              <span><?php echo e($attend_user_count); ?> 
              <?php if($attend_user_count == 1): ?>
                <?php echo e(trans('eventDetails.people_is')); ?> 
              <?php else: ?>
                <?php echo e(trans('eventDetails.people_are')); ?>

              <?php endif; ?>
              <?php echo e(trans('eventDetails.going')); ?>

              </span>   

              <?php if($logged_in_user == $record->user_id && $permission_invite == 1): ?>
                <?php if($record->status == 'Active' && $record->event_start_date > $today): ?>
                  <a data-toggle="modal" data-target="#uploadphoto" id="invitemembrid" class="go" href="#"><?php echo e(trans('buttonTxt.invite')); ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                <?php endif; ?>
              <?php endif; ?>
              </h2>

              <div class="clearfix"></div>

               <div id="scrollbar1" class="custom-scroll">
            	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
            	<div class="viewport">
              <div class="overview">

              	 <ul class="eve-list eve-list2">

                 <?php if(count($event_attend)>0): ?>
                   <?php $__currentLoopData = $event_attend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  	<li>
                        <span class="eve-img">
                          <?php if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo))): ?>
                    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo)); ?>" alt=""/>
                  <?php else: ?>
                  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/>
                  <?php endif; ?>

                        </span>
                        <div class="eve-txt">
                        <h3><a href="<?php echo e(URL::Route('user_profile').'/'.($attand->user->ad_username)); ?>"> <?php echo e($attand->user->display_name); ?> </a></h3>
                        <p><?php echo e($attand->user->title); ?></p>
                        </div>
                        
                        <div class="iconic attending">
                          <abbr rel="tooltip" title="<?php echo e(trans('common.attending')); ?>"><i class="fa fa-check" aria-hidden="true"></i></abbr>
                        </div> 
                        <?php if($record->event_start_date > $today): ?>
                          <?php if($attand->user->id != $logged_in_user && $logged_in_user == $record->user_id): ?>
                            <div class="nav-func">
                              <ul>
                                <li><a href="javascript:void(0);" class="remove_invite" data-status="attend" data-eventId="<?php echo e($attand->event_id); ?>" data-userId="<?php echo e($attand->user_id); ?>" data-id="<?php echo e($attand->id); ?>"><i class="fa fa-ban" aria-hidden="true"></i></a></li>
                              </ul>
                             </div>
                          <?php endif; ?>
                        <?php endif; ?>

                    </li>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>


                 <?php if(count($event_tentetive)>0): ?>
                   <?php $__currentLoopData = $event_tentetive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <span class="eve-img">
                          <?php if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo))): ?>
                    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo)); ?>" alt=""/>
                  <?php else: ?>
                  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/>
                  <?php endif; ?>

                        </span>
                        <div class="eve-txt">
                        <h3><a href="<?php echo e(URL::Route('user_profile').'/'.($attand->user->ad_username)); ?>"> <?php echo e($attand->user->display_name); ?> </a></h3>
                        <p><?php echo e($attand->user->title); ?></p>
                        </div>
                          <div class="iconic tentative">
                              <abbr rel="tooltip" title="<?php echo e(trans('common.tentative')); ?>"><i class="fa fa-calendar" aria-hidden="true"></i></abbr>
                          </div>
                        <?php if($record->event_start_date > $today): ?>  
                          <?php if($logged_in_user == $record->user_id && $attand->user_id != $record->user_id): ?>
                            <div class="nav-func">
                              <ul>
                                <li><a href="javascript:void(0);" class="remove_invite" data-status="tentative" data-eventId="<?php echo e($attand->event_id); ?>" data-userId="<?php echo e($attand->user_id); ?>" data-id="<?php echo e($attand->id); ?>"><i class="fa fa-ban" aria-hidden="true"></i></a></li>
                              </ul>
                             </div>
                          <?php endif; ?> 
                        <?php endif; ?>                       

                    </li>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>


                 <?php if(count($event_pending)>0): ?>
                   <?php $__currentLoopData = $event_pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                    
                        <span class="eve-img">
                          <?php if($attand->user['profile_photo'] != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user['profile_photo']))): ?>
                              <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user['profile_photo'])); ?>" alt=""/>
                          <?php else: ?>
                              <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/>
                          <?php endif; ?>

                        </span>
                        <div class="eve-txt">
                        <h3><a href="<?php echo e(URL::Route('user_profile').'/'.($attand->user['ad_username'])); ?>"> <?php echo e($attand->user['display_name']); ?> </a></h3>
                        <p><?php echo e($attand->user['title']); ?></p>
                        </div>
                             <div class="iconic pending">
                          <abbr title="<?php echo e(trans('common.pending')); ?>" rel="tooltip"><i class="fa fa-clock-o" aria-hidden="true"></i></abbr>
                        </div> 
                        <?php if($record->event_start_date > $today): ?>
                          <?php if($logged_in_user == $record->user_id && $attand->user_id != $record->user_id): ?>
                            <div class="nav-func">
                              <ul>
                                <li><a href="javascript:void(0);" class="remove_invite" data-status="pending" data-eventId="<?php echo e($attand->event_id); ?>" data-userId="<?php echo e($attand->user_id); ?>" data-id="<?php echo e($attand->id); ?>"><i class="fa fa-ban" aria-hidden="true"></i></a></li>
                              </ul>
                            </div>
                          <?php endif; ?> 
                        <?php endif; ?>            

                    </li>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>

                 <?php if(count($event_cancel)>0): ?>
                   <?php $__currentLoopData = $event_cancel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <span class="eve-img">
                          <?php if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo))): ?>
                    <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo)); ?>" alt=""/>
                  <?php else: ?>
                  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt=""/>
                  <?php endif; ?>

                        </span>
                        <div class="eve-txt">
                        <h3><a href="<?php echo e(URL::Route('user_profile').'/'.($attand->user->ad_username)); ?>"> <?php echo e($attand->user->display_name); ?> </a></h3>
                        <p><?php echo e($attand->user->title); ?></p>
                        </div>

                        <div class="iconic not-attending">
                                <abbr rel="tooltip" title="<?php echo e(trans('common.not_attending')); ?>"><i class="fa fa-times" aria-hidden="true"></i></abbr>
                        </div>                  
                        <?php if($record->event_start_date > $today): ?>
                          <?php if($logged_in_user == $record->user_id && $attand->user_id != $record->user_id): ?>
                            <div class="nav-func">
                              <ul>
                                <li><a href="javascript:void(0);" class="remove_invite" data-status="cancel" data-eventId="<?php echo e($attand->event_id); ?>" data-userId="<?php echo e($attand->user_id); ?>"  data-id="<?php echo e($attand->id); ?>"><i class="fa fa-ban" aria-hidden="true"></i></a></li>
                              </ul>
                             </div>
                          <?php endif; ?>
                        <?php endif; ?>
                        
                    </li>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php endif; ?>
                  

              </ul>

                </div>
                </div>
                </div>

             </div>


           </div>
         </div>

       </div>
     </div>
   </div>


<div class="modal fade" id="uploadphoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xl cus-modals" role="document">
    <div class="modal-content alt">
      <div class="modal-body friend-list">
        <button type="button" class="close alt" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
        <div class="row">
          <div class="col-sm-12">

            <div class="searchSt forSearch">
                   <input type="text" id="searchUser" name="" value="" placeholder="Search..." aria-controls="userTable">
            </div>
            <div class="table-responsive user-table listing-table">
            <div class="scroll-table">
              <table class="table userTable table-fixed" id="userTable">
                <thead>
                  <tr>
                    <th width="5%"><?php echo e(trans('common.employee')); ?></th>
                    <th width="95%">&nbsp;</th>
                    
                    <!-- <th width="5%">&nbsp;</th> -->
                  </tr>
                </thead>
                <tbody>
                <?php if(count($user_list)): ?>
                  <?php $__currentLoopData = $user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td valign="middle" width="3%"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" class="inviteChk" value="1" data-userId = "<?php echo e($user->id); ?>">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle" width="95%">
                    <?php if($user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $user->profile_photo))): ?>
                      <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$user->profile_photo)); ?>" alt=""/>
                    <?php else: ?>
                      <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
                    <?php endif; ?>
                      <h3><?php echo e($user->display_name); ?> <span><?php echo e($user->title); ?>, <?php echo e($user->department->name); ?></span></h3></td>
                    
                     <!-- <td valign="middle" width="5%"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td> -->
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                  
                </tbody>
              </table>
            </div>
              <div class="fileContainer">
              <input type="submit" value="Invite" id="inviteSubmit" />
              <input type="button" value="OKAY" id="confirmid" style="display:none;" />
              </div>
            </div>
            <div class="succMesg" style="color:green;" ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <div style="display: none;">
        
     <input id="destination-input" class="controls" type="text"
        placeholder="Enter a destination location" value="<?php echo e($record->location); ?>">

    <input type="hidden" name="waypoints" id="waypoints">

        
  </div>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('script'); ?>

<!--------------------------------------------- Invite User Search  -------------------------------->

<script src="<?php echo e(asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script type="text/javascript">

var table = $('#userTable').DataTable({
                  "paging":   false,
                  "ordering": false,
                  "info":     false,
                });
// #myInput is a <input type="text"> element
    $('#searchUser').on( 'keyup', function () {
        // if(this.value !='' ){
        //     $('#confirmid').show();
        //     $('#inviteSubmit').hide();
        // } else{
        //     $('#confirmid').hide();
        //     $('#inviteSubmit').show(); 
        // }
        table.search( this.value ).draw();
    } );

    // $('#confirmid').click(function(){
    //   $('#searchUser').val('');
      
    //   $('#searchUser').on( 'click', function () { 
    //    table.search( this.value ).draw();
    //   } );
    //   $('#searchUser').trigger( 'click' );
     
    //   $('#confirmid').hide();
    //   $('#inviteSubmit').show(); 
    // });
    $("#invitemembrid").click(function () { 
      $('.succMesg').hide();    
    });
</script>
<style type="text/css">
  .dataTables_filter {
    display: none; 
}
</style>

<!------------------------------------------ Invite User Search  -------------------------------->


  <script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.tinyscrollbar.min.js')); ?>"></script>
  <script type="text/javascript">
      $(document).ready(function()
      {

        var exit_page = 1;
        window.onbeforeunload = function(){
            if (exit_page != 1)
            {            
                return '';
            }
        }


          var load = 'Yes';
          var page = 2; //track user scroll as page number, right now page number is 1          
          load_more_post(page);
          $(window).scroll(function() { 
            if($(window).scrollTop() + $(window).height()+10 >= $(document).height()) { //if user scrolled from top to bottom of the page   
              page++; //page number increment
              load_more_post(page); //load content   
            }
          }); 

          function load_more_post()
          {
            if(load == 'No')
              return false;
            $.ajax({
              url       : '?page='+page,
              type      : 'get',
              datatype  : 'html',
              'async'   : false,
              beforeSend: function()
              {              
                $('.ajax-loading').show();
              },
              success   : function(data){
                $('.ajax-loading').hide();
                if(data.length == 0){
                  load = 'No';
                  console.log(page);
                  if(page>2)
                  {
                    $('.ajax-loading').show();
                    $('.ajax-loading').html('<span class="no_envent_message nogroupcls">'+lang.get('alert.no_more_record_feed')+'</span>');                    
                  }
                  
                }else{                   
                   $('#timeline_post').append(data); 

                }
              }

            });
          }

          $( document ).on( "click", ".user-com", function() {  
                  var index = $(this).data("target");                 
                  jQuery('#comment_'+index).slideToggle("slow");
          });

          var $scrollbar = $("#scrollbar1");
          $scrollbar.tinyscrollbar();
          
          $('.remove_invite').click(function(){
            var ths = $(this);
            var id = ths.attr('data-id');
            var event_id = ths.attr('data-eventId');
            var user_id = ths.attr('data-userId');
            var status = ths.attr('data-status');

            $.confirm({
              title: '<?php echo e(trans('common.Confirm')); ?>',
              content: '<?php echo e(trans('eventDetails.are_you_sure_to_cancel_invite')); ?>',
              buttons: {
                  <?php echo e(trans('common.Confirm')); ?>: function () {                      
                      $.ajax({
                        'type': 'post',
                        'data': {id:id,event_id:event_id,user_id:user_id,status:status},
                        'url' : BASE_URL+'/cancel-invite',
                        'success': function(){
                             ths.parent().parent().parent().parent().remove(); 
                        }
                      });
                  },
                  <?php echo e(trans('common.cancel')); ?>: function () {
                      
                  }
              }
          });

           
          });

          $('#delete_event').click(function(){
            $.confirm({
              title: '<?php echo e(trans('common.Confirm')); ?>',
              content: '<?php echo e(trans('eventDetails.Are_you_sure_to_delete')); ?>',
              buttons: {
                  <?php echo e(trans('common.Confirm')); ?>: function () {
                     window.location.href = '<?php echo e(route('delete_event', encrypt($record->id))); ?>';
                  },
                  <?php echo e(trans('common.cancel')); ?>: function () {
                     
                  }
              }
            });
          });

          $('#edit_event').click( function() {
                window.location.href = '<?php echo e(route('edit_event', encrypt($record->id))); ?>';
          });

///////////////// Post Section Start ////////////////////////////////////////////////////////////////

         $("#post_text").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#PostFrm").submit();

            }
          });


          $("#PostFrm").on('submit',(function(e){
              e.preventDefault();  
                var post_text = $('#post_text'). val();
                var eventId = $(this).attr('data-EventId'); 
                var image = $('#postimgid').val();
                var post_video = $('#post_video').val();
                if(post_text.trim() == '' &&  image == '' && post_video == '')
                {
                  $.alert({
                      title: '<?php echo e(trans('common.Alert')); ?>',
                      content: "<?php echo e(trans('eventDetails.please_write_something_in_whats_in_your_mind')); ?>",
                      icon: 'fa fa-rocket',
                      type: 'blue',
                      animation: 'scale',
                      closeAnimation: 'scale',
                      animateFromElement: false,
                      buttons: {
                          okay: {
                          text: '<?php echo e(trans('common.Okay')); ?>',
                          btnClass: 'btn-blue'
                          }
                      }
                  });
                  return false;
                }
                else if(image !='' && post_video != '')
                {
                  $.alert({
                    title: '<?php echo e(trans("common.Alert")); ?>',
                    content: '<?php echo e(trans("home.You_can_select_only_Image_or_Video")); ?>',
                    icon: 'fa fa-rocket',
                    type: 'blue',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    animateFromElement: false,
                    buttons: {
                      okay: {
                        text: '<?php echo e(trans("common.Okay")); ?>',
                        btnClass: 'btn-blue',
                        action: function(okay){
                          $(".jconfirm-light.jconfirm-open").remove();
                          return false;
                        }
                      }
                    }
                  });
                  return false;
                }
                 

                $.ajax({
                'type'  : 'post',
                //'data'  : {post_text:post_text,event_id:eventId},
                'data'  : new FormData(this),
                'url'   : BASE_URL+'/event-post',
                'beforeSend' : function(){
                  if(post_video == '')
                  {            
                    $('.custom-loader').css('display', 'flex');
                  }
                  else
                  {
                    exit_page = 0;
                    $('#event_post').prop('disabled', true);
                    $('.modal-backdrop').hide();
                    $('#post_video').val('');
                    $('#video_name').html('');
                    $('#remove_video').hide();
                    $('#uploading_video').show();
                    $('#uploaded_message').html('');
                    $('#locationid').html('');
                    $('#locationtxtid').val();
                  }
                },
                //'async' : false,
                contentType: false,
                cache: false,
                processData:false,
                'success': function(msg){ 

                    //location.reload();

                    if(msg == 2)
                    {
                       exit_page = 1;
                       $('#event_post').removeAttr("disabled");
                       $('#uploading_video').hide();
                       $('#success_message').show();
                       $('#uploaded_message').html('Your video is being processed and will be published shortly');
                       $('#success_message').delay(90000).hide(4000,'linear');
                    }
                    else
                    {
                       $('#timeline_post').prepend(msg);
                    }

                    $('#post_text'). val('');
                   
                    $("#targetLayer").html('');
                    $("#postimgid").val('');
                    $('#no_post').remove();
                    $('#post_video').val('');
                    $('#video_name').html('');
                    $('#remove_video').hide();

                    $('.custom-loader').hide();
                    // $( document ).on( "keypress", ".cmntcls", function(event) {                    
                    //     if (event.which == 13) {
                    //         event.preventDefault();
                    //         var ths = $(this);
                    //         var post_id      = $( this ).attr( "data-post_id" );
                    //         var comment_text = $(this).val();
                            

                    //         request = $.ajax({
                    //                 url: "<?php echo e(URL::Route('saveeventcomment')); ?>",
                    //                 type: "POST",
                    //                 'async' : false,
                    //                beforeSend:function() { 
                    //                 $('.custom-loader').css('display', 'flex');
                    //                  //$("#commentid_"+post_id).html("<img src='<?php echo e(asset('frontend/images/Spin.gif')); ?>'>");
                    //              },
                    //                 data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},
                                    
                    //               });

                    //               request.done(function(msg) {
                    //                var html = $("#commentsnwid_"+post_id).html();
                    //                 html = $("#commentsnwid_"+post_id).html(html+''+msg);
                    //                 ths.val('');
                    //                 $('.custom-loader').hide();
                    //               var cmnt_cnt = $("#cmntid_"+post_id).val();                        
                    //               cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));
                                   
                    //               $("#cmncnt_id_"+post_id).html(cmnt_cnt+' Comments')  ;  
                    //               $("#cmntid_"+post_id).val(cmnt_cnt)   ;            

                    //               });

                                  
                    //     }
                    // });
                    
                    $( document ).on("click",".face-like",function () { 
                          var post_id = $( this).attr( "alt" );

                          request = $.ajax({
                            url: "<?php echo e(URL::Route('likeunlike')); ?>",
                            type: "POST",                       
                            data: {'post_id':post_id,'_token':CSRF_TOKEN},                  
                          });

                          request.done(function(msg) {
                          if(msg==1) {                    
                           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
                            $( "#lkid_"+post_id ).addClass( "active" );
                            var like_cnt = $("#likeid_"+post_id).val(); 
                            like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
                            $("#likecnt_id_"+post_id).html(like_cnt+' <?php echo e(trans('common.likes')); ?> ')  ;
                            $("#likeid_"+post_id).val(like_cnt)   ;  
                          }else {
                            $("#lkid_"+post_id).removeClass("active");
                            var like_cnt = $("#likeid_"+post_id).val(); 
                            like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
                            $("#likecnt_id_"+post_id).html(like_cnt+' <?php echo e(trans('common.likes')); ?> ')  ;
                            $("#likeid_"+post_id).val(like_cnt)   ; 
                          }                
                         
                          });
                          
                    });

                }
              });
          }));

          $('#inviteSubmit').click(function(){

          	$('#searchUser').val('');
    		    $('#searchUser').on( 'click', function () { 
      		     table.search( this.value ).draw();
  		      });
		        $('#searchUser').trigger( 'click' );

            $('.succMsg').removeClass('no_envent_message');
            $('.succMsg').html('');
            $('.succMesg').show();  
            var userID = [];
            var eventId = '<?php echo e($record->id); ?>';
            $('.inviteChk').each(function(){                
                if($(this).is(':checked'))
                    userID.push($(this).attr('data-userId'));
            });

            $.ajax({
                'type'  : 'post',
                'data'  : {userId:userID,event_id:eventId},                
                'url'   : BASE_URL+'/event-invite',                
                'success': function(msg){ 
                    // $('.inviteChk').each(function(){                
                    //     if($(this).is(':checked'))
                    //       table.row( $(this).parents('tr') ).remove().draw();
                    //       $('#searchUser').val('');                
                    //       $('#searchUser').on( 'click', function () {
                    //           table.search( this.value ).draw();
                    //       } );
                    //       $('#searchUser').trigger( 'click' );                       
                    //  });
                    // $('.succMesg').addClass('no_envent_message');
                    // $('.succMesg').html('<?php echo e(trans('eventDetails.invitation_sent_successfully')); ?>');

                    $('#uploadphoto').modal('hide');
                    location.reload();
                    
                }
              });
          });

      });

///////////////// Post Section End ////////////////////////////////////////////////////////////////

  </script>

  <?php if($record->location!=''): ?>
  <script type="text/javascript">

     function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        
        var geocoder;
              var map;

              geocoder = new google.maps.Geocoder();
              //var latlng = new google.maps.LatLng(-34.397, 150.644);
              var myOptions = {
                zoom: 14,
               // center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              }
              map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                      // var city_state_zip = document.getElementById("city_state_zip").innerHTML;
                      // var street_address = document.getElementById("street_address").innerHTML;
                      // var address = street_address + " " + city_state_zip;//document.getElementById(street_addres +" "+ city_state_zip).value;
                      var address = '<?php echo e($record->location); ?>';
                      geocoder.geocode( { 'address': address}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                          map.setCenter(results[0].geometry.location);
                          var marker = new google.maps.Marker({
                              map: map,
                              position: results[0].geometry.location
                          });
                        } else {
                          alert("Geocode was not successful for the following reason: " + status);
                        }
                      });

        directionsDisplay.setMap(map);

        document.getElementById('getDirection').addEventListener('click', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        });

        autocomplete = new google.maps.places.Autocomplete(
            /** @type  {!HTMLInputElement} */(document.getElementById('origin-input')),
            {types: ['geocode']});
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
          origin: document.getElementById('origin-input').value,
          destination: document.getElementById('destination-input').value,
          //waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (var i = 0; i < route.legs.length; i++) {
              var routeSegment = i + 1;
              //summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +'</b><br>';
              //summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              //summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
          } else {
            //window.alert('Directions request failed due to ' + status);
          }
        });
      }


      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }

  </script>

  <script>

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0fOLbrmMSe-Des6pZctGqFyrM3kLbGsY&libraries=places&callback=initMap"
        async defer></script>

<?php endif; ?>
  <script>
     $( document ).on( "keypress", ".cmntcls", function(event) { 
            if (event.which == 13) {
                event.preventDefault();
                var ths = $(this);
                var post_id      = $( this ).attr( "data-post_id" );
                var comment_text = $(this).val();
                
                if(comment_text == '')
                {
                  $.alert({
                      title: '<?php echo e(trans('common.Alert')); ?>',
                      content: '<?php echo e(trans('eventDetails.please_write_something')); ?>',
                      icon: 'fa fa-rocket',
                      type: 'blue',
                      animation: 'scale',
                      closeAnimation: 'scale',
                      animateFromElement: false,
                      buttons: {
                          okay: {
                          text: '<?php echo e(trans('common.Okay')); ?>',
                          btnClass: 'btn-blue'
                          }
                      }
                  });
                  return false;
                }
                

                request = $.ajax({
                        url: "<?php echo e(URL::Route('saveeventcomment')); ?>",
                        type: "POST",
                        'async' : false,
                       beforeSend:function() { 
                        $('.custom-loader').css('display', 'flex');
                         //$("#commentid_"+post_id).html("<img src='<?php echo e(asset('frontend/images/Spin.gif')); ?>'>");
                     },
                        data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},
                        
                      });

                      request.done(function(msg) {
                       var html = $("#commentsnwid_"+post_id).html();
                        html = $("#commentsnwid_"+post_id).html(html+''+msg);
                        $('.commentsnwid').show();
                        ths.val('');
                        $('.custom-loader').hide();
                      var cmnt_cnt = $("#cmntid_"+post_id).val();                        
                      cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));
                       
                      $("#cmncnt_id_"+post_id).html(cmnt_cnt+' Comments')  ;  
                      $("#cmntid_"+post_id).val(cmnt_cnt)   ;            

                      });

            }
        }); 

        $( document ).on("click",".face-like",function () { 
                var post_id = $( this).attr( "alt" );

                request = $.ajax({
                  url: "<?php echo e(URL::Route('likeunlike')); ?>",
                  type: "POST",                       
                  data: {'post_id':post_id,'_token':CSRF_TOKEN},                  
                });

                request.done(function(msg) {
                if(msg==1) {                    
                 /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
                  $( "#lkid_"+post_id ).addClass( "active" );
                  var like_cnt = $("#likeid_"+post_id).val(); 
                  like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
                  $("#likecnt_id_"+post_id).html(like_cnt+' <?php echo e(trans('common.likes')); ?> ')  ;
                  $("#likeid_"+post_id).val(like_cnt)   ;  
                }else {
                  $("#lkid_"+post_id).removeClass("active");
                  var like_cnt = $("#likeid_"+post_id).val(); 
                  like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
                  $("#likecnt_id_"+post_id).html(like_cnt+' <?php echo e(trans('common.likes')); ?> ')  ;
                  $("#likeid_"+post_id).val(like_cnt)   ; 
                }                
               
                });
                
            });   



  
           $(document).ready(function() {
            $("#find_btn").click(function () { 
              if ("geolocation" in navigator){ //check geolocation available
                    //try to get user current location using getCurrentPosition() method                    
                    navigator.geolocation.getCurrentPosition(function(position){
                      
                       var latitude = position.coords.latitude;
                       var  longitude =position.coords.longitude;
                      
                        request = $.ajax({
                        url: "<?php echo e(URL::Route('getLocation')); ?>",
                        type: "POST",
                       beforeSend:function() { 
                        
                         $("#locationid").html("<img src='<?php echo e(asset('frontend/images/Spin.gif')); ?>'>");
                     },
                        data: {'latitude' : latitude,'longitude':longitude,'_token':CSRF_TOKEN},
                        
                      });

                      request.done(function(msg) {
                        $("#locationid").html( '--at '+msg );
                         $("#locationtxtid").val(msg);
                      });

                      request.fail(function(jqXHR, textStatus) {
                      //alert( "Request failed: Something went wrong. Please try again." );
                      });
                      });
                }else{
                    console.log("Browser doesn't support geolocation!");
                }
             
            });
          });
           
    

  function showPreview(objFileInput) {


    var totalFile = objFileInput.files.length;
    for (var i = 0; i < totalFile; i++) {

          var fileInfo = objFileInput.files[i];
          var sizeKB = fileInfo.size / 1000;
          sizeKB  = sizeKB.toFixed(1);
          if(sizeKB > 2048)
          {
            $.alert({
                        title: '<?php echo e(trans('common.Alert')); ?>',
                        content: '<?php echo e(trans('common.uploaded_image_size_maximum_2MB_allowed')); ?>',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '<?php echo e(trans('common.Okay')); ?>',
                            btnClass: 'btn-blue'
                            }
                        }
                    });


            $(objFileInput).val('');
            return false;
          }

          var fileType = fileInfo["type"];
          var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];
          if ($.inArray(fileType, ValidImageTypes) < 0) {

                $.alert({
                        title: '<?php echo e(trans('common.Alert')); ?>',
                        content: '<?php echo e(trans('common.only_JPEG_JPG_PNG_are_allowed')); ?>',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '<?php echo e(trans('common.Okay')); ?>',
                            btnClass: 'btn-blue'
                            }
                        }
                    });

                $(objFileInput).val('');
                return false;
          }

    }



      if (objFileInput.files[0]) {
          var fileReader = new FileReader();
          fileReader.onload = function (e) {
              $("#targetLayer").html('<a id="removeimgid" href="javascript:void(0);"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGlSURBVGhD7dkxSsRAFMbxiNhY6BlEEAsvoSex0UZsxNYD6AWsLEQEXWtvoeghrGy0UAQb/T7YgRDeZmaS9yZTvAe/Jm7C/jGT3WUaHx+fQbME+/AEv/A3sU+4h21IHkZcgXTBqX3BHiQN/xPSRWrxDmsQnWeQLlCTA+gd3lY1rImYS+iddZBOrM0t9I6HFOYhtfGQRX7gGPghJf09xQNcd47FqIccAWcHhsQwYgWW4WV+LIV6CN88Izi5MSGCcwbSaxYxWSNDYsZEkNliz4kZG0FmIZQSoxFBpiHUF6MVQeYhJMVoRlCREGrHbIBmBBULIcZsQphTkF43RNGQ9u3E6a6ZMYqFtCNOoLtmpHNyFAmRFnZ7zWjEmIf0PZ00Y0xDUh6xWjFmISkRgUaMSUhORDA2Rj1kSEQwJkY9hL/s+KMoNyIIMVvwNj+WwuTWehWO5WBMTgSZLfbSPKQ2HlKbaMgqSCfW5gai8wHSyTU5h+jcgXRyTXYhOtwC/gbpAjV4hOThFnDuF7kSGMEHUtZwC/gQuPE4mxCfUBeQvL/u4+PTnab5B0YbTRTOdbJrAAAAAElFTkSuQmCC"/></a><img src="'+e.target.result+'" class="upload-preview" />');
        $("#targetLayer").css('opacity','0.7');
        $(".icon-choose-image").css('opacity','0.5');
          }
      fileReader.readAsDataURL(objFileInput.files[0]);
      }
  }


   $("#targetLayer").click(function () { 
   $("#targetLayer").html('');
   $("#postimgid").val('');
 });


</script>

<script> 

$( document ).on( "click", ".deletepost", function(event) {    
  var post_id =   $( this).attr( "alt" );
  var event_id =  '<?php echo e($record->id); ?>';
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this post?",
    buttons: {
      confirm: function () { 
      window.location.href ="<?php echo e(URL::Route('posts_delete')); ?>"+'/'+post_id+ '/'+event_id+'/event';
      },
      cancel: function () {

      }
    }
  });              

});

$( document ).on( "click", ".deletecomment", function(event) {    
  var comment_id =   $( this).attr( "alt" );
  var event_id =  '<?php echo e($record->id); ?>';
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this comments?",
    buttons: {
      confirm: function () { 
      window.location.href ="<?php echo e(URL::Route('comments_delete')); ?>"+'/'+comment_id+ '/'+event_id+'/event';
      },
      cancel: function () {

      }
    }
  });              

});


function checkVideo(objFileInput) {
  if (objFileInput.files[0]) {
      var fileType = objFileInput.files[0].type;
      var ValidImageTypes = ["video/mp4", "video/x-ms-wmv", "video/x-msvideo", "video/avi", "video/msvideo", "video/x-flv", "video/mpeg"];

      if ($.inArray(fileType, ValidImageTypes) < 0) {                  
          $.alert({
            title: 'Alert!',
            content: 'Please upload only video file[.mp4, .wmv, .avi, .flv, .mpeg, .mpg]',
            icon: 'fa fa-rocket',
            type: 'blue',
            animation: 'scale',
            closeAnimation: 'scale',
            animateFromElement: false,
            buttons: {
              okay: {
                text: 'Okay',
                btnClass: 'btn-blue',
                action: function(okay){
                $(".jconfirm-light.jconfirm-open").remove();
                return false;
                }
              }
            }
          });                            

          $('#post_video').val('');
          return false;
      }else{

            var sizeKB = objFileInput.files[0].size / 1000;
            sizeKB  = sizeKB.toFixed(1);
            if(sizeKB > 20480)
            {  
                $.alert({
                    title: 'Alert!',
                    content: "Maximum 20MB allowed.",
                    icon: 'fa fa-rocket',
                    type: 'blue',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    animateFromElement: false,
                    buttons: {
                      okay: {
                        text: 'Okay',
                        btnClass: 'btn-blue',
                        action: function(okay){
                            $(".jconfirm-light.jconfirm-open").remove();
                            return false;
                        }
                      }
                    }
                }); 

              $('#post_video').val('');              
              return false;
            }
            else
            {
              var video_name = $('#post_video').val().split('\\').pop();
              $('#video_name').html(video_name);
              $('#remove_video').show();
            }
          }
      }
  } 

  $('#remove_video').click(function(){
      $('#post_video').val('');
      $('#video_name').html('');
      $('#remove_video').hide();
  });  

$('#uploadphoto').on('hide.bs.modal', function () {

	
	$('#searchUser').val('');
    $('#searchUser').on( 'click', function () { 
     table.search( this.value ).draw();
    } );
    $('#searchUser').trigger( 'click' );

    $('.inviteChk').removeAttr('checked');

		// $.confirm({
		//     title: "Confirm",
		//     content: "Do you want to close invite box.",
		//     buttons: {
		//       confirm: function () { 
		//       	location.reload();
		//       },
		//       cancel: function () {

		//       }
		//     }
		//   }); 
		// return false;
})

</script> 
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.event_app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>