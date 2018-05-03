<div class="col-lg-3 col-sm-3">
  <div class="right-sidebar clearfix">
  
  	<?php if(count($occasions)>0): ?>
    <div class="recentUpdates group occasion" id="rsidebar">
    <h2>Occasions</h2>
      <div class="cont-wrap">
        <div class="cont-wrap-main">
          <div id="scrollbar1" class="custom-scroll">
            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
            <div class="viewport">
              <div class="overview"><?php $i=0;?>
              
                <?php $__currentLoopData = $occasions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occasion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="recent-block">
                  <div class="image-div">
                  <?php $i++;
                  $dob=explode('-',$occasion->date_of_birth);
                  $joindate=explode('-',$occasion->date_of_joining);
                  if($occasion->field_type=='DOB') { $occ= 'bday';}else{ $occ='anniversary';}
                  if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$occasion->profile_photo) ) && ($occasion->profile_photo!='' || $occasion->profile_photo!=NULL)) { ?>
                  <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/').'/'.$occasion->profile_photo); ?>" alt="">
                  <?php }else{ ?>
                  <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>"/>
                  <?php } ?>
                  </div>
                  <h4><a href="<?php echo e(URL::Route('user_profile').'/'.$occasion->ad_username); ?>"><?php echo e($occasion->display_name); ?> </a><br> <span><?php echo e($occasion->title); ?></span></h4>
                  <p><?php if($occ=='bday'): ?> <?php echo e(trans('home.having')); ?> <?php echo e(trans('home.birthday')); ?> <?php else: ?> <?php echo e(trans('home.completed')); ?> <?php echo e(date('Y')-$joindate[0]); ?> <?php echo e(trans('home.years')); ?> <?php endif; ?></p>
                    <?php if($occ=='bday'): ?>
                      <div class="emailPop"><a id="linkidocc_<?php echo e($i); ?>" <?php if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'BDAY',date('Y-m-d'))==0): ?> class='occationcls'  href="<?php echo e(URL::Route('occasion_birthday').'/'.$occasion->id.'/'.\Auth::guard('user')->user()->id.'/'.date('Y-m-d').'/'.$i); ?>" <?php endif; ?>><div id="occimgid_<?php echo e($i); ?>"> <?php if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'BDAY',date('Y-m-d'))==0): ?><img src="<?php echo e(asset('frontend/images/b-1.png')); ?>" alt=""><?php else: ?> <img src="<?php echo e(asset('frontend/images/message-icon.png')); ?>" title="<?php echo e(trans('home.Your_message_was_sent')); ?>" alt=""> <?php endif; ?></div></a></div>
                    <?php else: ?>
                      <div class="emailPop spop" style="background: #f29134 !important;"><a id="linkidocc_<?php echo e($i); ?>" <?php if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'ANNIVERSARY',date('Y-m-d'))==0): ?> class='occationcls'  href="<?php echo e(URL::Route('occasion_anniversary').'/'.$occasion->id.'/'.\Auth::guard('user')->user()->id.'/'.date('Y-m-d').'/'.$i); ?>" <?php endif; ?>><div id="occimgid_<?php echo e($i); ?>"><?php if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'ANNIVERSARY',date('Y-m-d'))==0): ?><img src="<?php echo e(asset('frontend/images/b-2.png')); ?>" alt=""><?php else: ?> <img src="<?php echo e(asset('frontend/images/message-icon.png')); ?>" title="<?php echo e(trans('home.Your_message_was_sent')); ?>" alt=""> <?php endif; ?></div></a></a></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div> 
        <!-- -->
        </div>
      </div>
    <div class="btn_view"><a href="<?php echo e(URL::Route('occasion')); ?>" class="view_all"><i class="fa fa-eye"></i> <?php echo e(trans('homeRight.View_All')); ?></a></div>
    </div>
    <?php endif; ?>
    
    <div class="recentUpdates grouping">
    <h2><?php echo e(trans('homeRight.Recent_Updates')); ?></h2>
    <?php if(!empty($recent_updates)): ?>
    <div class="cont-wrap">
      <div class="cont-wrap-main recent_update_section">

      <?php $__currentLoopData = $recent_updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $updates): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="recent-block recent_update">
      <div class="image-div"><img src="<?php echo e(asset($updates['profile_image'])); ?>" alt=""></div>
      <h3><a href="<?php echo e(URL::Route('user_profile').'/'.($updates['user_id'])); ?>"> <?php echo e($updates['user_name']); ?> </a> <?php echo e($updates['text']); ?> <a href="<?php echo e($updates['url']); ?>"><?php echo e($updates['textlink']); ?></a> <?php echo e(trans('home.on')); ?> <?php echo e(\DateTime::createFromFormat('Y-m-d H:i:s', $updates['created_at'])->format('dS M Y h:i A')); ?> </h3>
      </div> 
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    <div class="btn_view"><a href="<?php echo e(URL::Route('recent_updates')); ?>" class="view_all"><i class="fa fa-eye"></i> <?php echo e(trans('homeRight.View_All')); ?></a></div>
    <?php else: ?>
    <div class="cont-wrap">
      <div class="cont-wrap-main nocolor">
      <?php echo e(trans('homeRight.Oops_You_do_not_have_any_Recent_updates')); ?>

      </div>
    </div>  
    <?php endif; ?> 
    </div>
    
    <div class="recentUpdates group mygrouping">
    <h2><?php echo e(trans('homeRight.My_Groups')); ?></h2>
    <?php if(count($mygroups)>0): ?>
    <div class="cont-wrap">
      <div class="cont-wrap-main">
        <?php $__currentLoopData = $mygroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mygroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="recent-block">
        <?php           
        $group_id = encrypt($mygroup->group_user_id);
        ?>
        <div class="image-div">
          <a href="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>">
          <?php if(file_exists( public_path('uploads/group_images/profile_image/'.$mygroup->profile_image) )&& ($mygroup->profile_image!='' || $mygroup->profile_image!=NULL)) {?>
          <img src="<?php echo e(asset('uploads/group_images/profile_image/').'/'.$mygroup->profile_image); ?>" alt="" />
          <?php }else{ ?>
          <img src="<?php echo e(asset('frontend/images/no-image-event-list.jpg')); ?>" />
          <?php  } ?>
          </a>
        </div>
        <h4><a href="<?php echo e(URL::Route('group_details').'/'.$group_id); ?>"><?php echo e(substr($mygroup->group_name,0,20)); ?> <?php if( strlen($mygroup->group_name)>20): ?> ... <?php endif; ?></a></h4>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    <div class="btn_view"><a href="<?php echo e(URL::Route('group')); ?>" class="view_all"><i class="fa fa-eye"></i> <?php echo e(trans('homeRight.View_All')); ?></a></div>
    <?php else: ?>
    <div class="cont-wrap">
      <div class="cont-wrap-main nocolor">
      <?php echo e(trans('homeRight.Oops_You_do_not_have_any_Groups')); ?>

      </div>
    </div>
    <?php endif; ?>
    </div>
    
  </div>
</div>
<script type="text/javascript">
/*$(document).ready(function() {
$(".cntlikecls").colorbox({innerWidth:500});
});*/
$(document).on('click','.occationcls',function(e) {
e.preventDefault();
$.colorbox({href : this.href});
});
</script>