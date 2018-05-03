<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>  

<div class="home-container">
  <div class="container">
    <div class="emDirectory-tiTle">
    <h2>Occasions</h2>
    </div>
  </div>
  <div class="emDirectory-wRapper">
    <div class="emDirectory-block">
      <div class="container">
      <!--+++++++++++++++++++   start ++++++++++++++++++++++-->
      <?php if(!empty($occationlists)): ?> <?php $i=0; ?>
      <?php $__currentLoopData = $occationlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $i++; ?>
        <div class="occasionsblock <?php if($i==1): ?> active <?php endif; ?>">
          <div class="dating">
          <i class="fa fa-calendar" aria-hidden="true"></i>
          <span><?php if($key == date('Y-m-d')): ?> Today <?php else: ?>  <?php echo e(\DateTime::createFromFormat('Y-m-d', $key)->format('M, d (D)')); ?>  <?php endif; ?></span>
          </div>
          <div class="owl-carousel">
            <?php if(!empty($value)): ?>
            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php

            $dob=explode('-',$val['date_of_birth']);
            $joindate=explode('-',$val['date_of_joining']);
            $keys = explode('-',$key);
           
            if((($keys[1].'-'.$keys[2])==($dob[1].'-'.$dob[2]))&& $val['field_type']=='DOB'){ $occasion='bday';}else{$occasion='anniversary';}
            ?>
            <div class="item">
              <div class="emDirectory-block-single">
              <?php if($occasion=='bday'): ?>
              <div class="emailPop"><a id="linkidocc_<?php echo e($val['id']); ?>" alt="<?php echo e($val['id']); ?>" <?php if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'BDAY',$key)==0): ?> class='occationcls'  href="<?php echo e(URL::Route('occasion_birthday').'/'.$val['user_id'].'/'.\Auth::guard('user')->user()->id.'/'.$key.'/'.$val['id']); ?>" <?php endif; ?>><div id="occimgid_<?php echo e($val['id']); ?>"><?php if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'BDAY',$key)==0): ?><img src="<?php echo e(asset('frontend/images/b-1.png')); ?>" alt=""><?php else: ?> <img src="<?php echo e(asset('frontend/images/message-icon.png')); ?>" title="<?php echo e(trans('home.Your_message_was_sent')); ?>" data-toggle="tooltip" data-placement="bottom" alt=""> <?php endif; ?></div></a></div>
              <?php else: ?>
              <div class="emailPop spop"><a id="linkidocc_<?php echo e($val['id']); ?>" alt="<?php echo e($val['id']); ?>" <?php if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'ANNIVERSARY',$key)==0): ?> class='occationcls'  href="<?php echo e(URL::Route('occasion_anniversary').'/'.$val['user_id'].'/'.\Auth::guard('user')->user()->id.'/'.$key.'/'.$val['id']); ?>" <?php endif; ?>><div id="occimgid_<?php echo e($val['id']); ?>"><?php if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'ANNIVERSARY',$key)==0): ?><img src="<?php echo e(asset('frontend/images/b-2.png')); ?>" alt=""><?php else: ?> <img src="<?php echo e(asset('frontend/images/message-icon.png')); ?>" title="<?php echo e(trans('home.Your_message_was_sent')); ?>" data-toggle="tooltip" data-placement="bottom" alt=""> <?php endif; ?></div></a></div>
              <?php endif; ?>
              <div class="blockSingle-img">
              <?php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$val['profile_photo']) )&& ($val['profile_photo']!='' || $val['profile_photo']!=NULL)) { ?>
              <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/').'/'.$val['profile_photo']); ?>" alt="">
              <?php }else{ ?>
              <img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>"/>
              <?php } ?>
              </div>
              <div class="blockSingleCont">
              <h2><a href="<?php if($val['username']!=''): ?><?php echo e(URL::Route('user_profile').'/'.($val['username'])); ?> <?php else: ?> # <?php endif; ?>"><?php echo e($val['name']); ?></a> <br> <span><?php echo e($val['title']); ?></span> </h2>
              <h3><?php if($occasion=='bday'): ?> <?php echo e(trans('home.is_having_birthday')); ?> <?php else: ?> <?php echo e($joindate[0]); ?> - <?php echo e(trans('home.completed')); ?> <?php echo e(date('Y')-$joindate[0]); ?> <?php echo e(trans('home.years')); ?> <?php endif; ?></h3>
              </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?> 
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
      <!--+++++++++++++++++++   end ++++++++++++++++++++++-->
      </div>
    </div>

  </div>
</div>
<!--  <div class="footer">
<div class="container">
<p>Copyright © Shurooq - All rights reserved</p>
</div>
</div> -->
<!-- owl javascript -->

<script src="<?php echo e(asset('frontend/js/owl.carousel.min.js')); ?>"></script>
<script>
//$('[data-toggle="tooltip"]').tooltip();
$(document).ready(function() {
$('.owl-carousel').owlCarousel({
loop: true,
margin: 10,
responsiveClass: true,
responsive: {
0: {
items: 1,
nav: true
},
767: {
items: 2,
nav: false
},
1000: {
items: 3,
nav: true,
loop: false,
margin: 20
}
}
})
})
</script>

<script src="<?php echo e(asset('frontend/js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
<script type="text/javascript">
(function($){
$(window).on("load",function(){
$("#numMenu").mCustomScrollbar({
scrollButtons:{enable:true},
theme:"light-thick",
scrollbarPosition:"outside"
});
});
})(jQuery);

$('#controls li a').click(
function(e){
e.preventDefault();
var that = this,
$that = $(that),
id = that.id,
gallery = $('#gallery');
if (id == 'all') {
gallery.find('li:hidden').show(600);
}
else {
gallery.find('li.' + id + ':hidden').show(600);
gallery.find('li').not('.' + id).hide(600);
}
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$('.panel').click(function() {
$('.slidemenu').toggleClass('clicked').addClass('unclicked');
$('.menubar_icon_black').toggleClass('menubar_icon_cross');
});
});
</script>


<script type="text/javascript">
/*$(document).ready(function() {
$(".cntlikecls").colorbox({innerWidth:500});
});*/

$(document).on('click','.occationcls',function(e) {
e.preventDefault();
$.colorbox({href : this.href});
});
</script>

</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>