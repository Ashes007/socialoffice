<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>


   <div class="home-container">
     <div class="container">

       <?php echo $__env->make('front.includes.event_sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       <?php echo $__env->make('front.includes.event_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



       <?php if(Session::has('success')): ?>
       <div class="form_submit_msg">
        <div class="succ_img"><img src="<?php echo e(asset('frontend/images/success.png')); ?> "></div>
            <div class="congratulation"><?php echo e(trans('common.thank_you')); ?></div>
            <div class="message"><?php echo e(Session::get('success')); ?></div>
        </div>
       <?php endif; ?>
    <?php if(session('error')): ?>
     <div class="form_submit_msg">                  
            <div class="message"><?php echo e(session('error')); ?></div>
    </div>
   
    <?php endif; ?>
       
       <div id="exTab2">

			<div class="tab-content cal-con event-boxss ">
			  <div class="tab-pane active">
          <div class="row event_section">

        <?php if($eventList->count()): ?>
              <?php $__currentLoopData = $eventList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         	<div class="col-sm-4 col-xs-6">
           <div class="photo-single group-areas">
             <div class="group-img">
             	<a href="<?php echo e(route('event_details', encrypt($event->id))); ?>">
               <?php if(count($event->eventImage) && file_exists(public_path('uploads/event_images/original/'.$event->eventImage[0]->image_name))): ?> 
                    <img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/event_images/original/'.$event->eventImage[0]->image_name)); ?>&w=356&h=200&q=100" alt="" class="big-img rounded">        
               <?php else: ?>
                  <img src="<?php echo e(asset('frontend/images/no-image-event-list.jpg')); ?>" alt="" class="big-img rounded">
             <?php endif; ?> 
              </a>
             </div>
             <div class="eve-area">
             <div class="dates"><span><?php echo e(\Carbon\Carbon::parse($event->event_start_date)->format('M')); ?></span> <?php echo e(\Carbon\Carbon::parse($event->event_start_date)->format('d')); ?></div>
             <div class="eve-right">
             <h3><a href="<?php echo e(route('event_details', encrypt($event->id))); ?>"><?php echo str_limit($event->name,8,'...'); ?>

                 
                  <?php if($event->event_start_date > $today): ?>
                    <?php if($event->getStatus($event->id) == 1 || $event->getStatus($event->id) == 4): ?>
                      <span> - <?php echo e(trans('common.attending')); ?></span> 
                    <?php elseif($event->getStatus($event->id) == 2 || $event->getStatus($event->id) == 6): ?>
                      <span class="not"> - <?php echo e(trans('common.not_attending')); ?></span>
                    <?php endif; ?>
                  <?php endif; ?>
                
             </a></h3>
             <h5 class="location">

             <?php if( $today > $event->event_end_date ): ?>
                    <i class="fa fa-hourglass-start"></i><?php echo e(trans('common.ended')); ?> 
             <?php else: ?>
               <?php if($event->allday_event =='Yes'): ?> 
                  <?php if($event->event_start_date == date('Y-m-d')): ?> 
                    <i class="fa fa-hourglass-start"></i><?php echo e(trans('common.started')); ?> 
                  <?php else: ?> 
                    <?php echo e(trans('common.allday_event')); ?> 
                  <?php endif; ?> 
               <?php else: ?>  
                  <i class="fa fa-clock-o" aria-hidden="true"></i><span class="timeCounter" data-time="<?php echo e($event->event_start_date); ?> <?php echo e($event->start_time); ?>"><?php echo e($event->start_time); ?> - <?php echo e($event->end_time); ?>  </span> 
                <?php endif; ?>
              <?php endif; ?>  
              </h5>
             <h5 class="location"><i class="fa fa-map-marker"></i><?php echo e(str_limit($event->location,30,'...')); ?></h5>
             </div>
             <div class="clear"></div>
             <div class="button_section">
            
               <?php if($event->event_start_date <= $today): ?>
                  
                    <?php if($event->getStatus($event->id) == 1): ?>
                        <div class="attend_status_button"><?php echo e(trans('buttonTxt.attended')); ?></div>
                    <?php elseif($event->getStatus($event->id) == 2): ?>
                        <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_attended')); ?></div>
                    <?php elseif($event->getStatus($event->id) == 3): ?>
                        <div class="attend_status_button"><?php echo e(trans('buttonTxt.tentative')); ?></div>
                    <?php elseif($event->getStatus($event->id) == 4): ?>
                        <div class="attend_status_button"><?php echo e(trans('buttonTxt.interested')); ?></div>
                    <?php elseif($event->getStatus($event->id) == 4): ?>
                        <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_interested')); ?></div>
                    <?php elseif($event->getStatus($event->id) == 6): ?>
                       <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_attended')); ?></div>
                    <?php else: ?>
                      <div class="attend_status_button not"><?php echo e(trans('buttonTxt.not_attended')); ?></div>
                    <?php endif; ?>
                  
               <?php else: ?>
                
                  <?php if($event->event_end_date > $today): ?>
                    <?php if($isInvited > 0): ?>

                      <?php if($event->getStatus($event->id) == 1 || $event->getStatus($event->id) == 4): ?>
                            <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "<?php echo e($event->id); ?>" data-status="6"><?php echo e(trans('buttonTxt.not_attend')); ?></a>
                        <?php elseif($event->getStatus($event->id) == 2 || $event->getStatus($event->id) == 5 || $event->getStatus($event->id) == 6): ?>
                            <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "<?php echo e($event->id); ?>" data-status="1"><?php echo e(trans('buttonTxt.attend')); ?></a>
                        <?php elseif($event->getStatus($event->id) == 3): ?>
                          <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "<?php echo e($event->id); ?>" data-status="1"><?php echo e(trans('buttonTxt.interested')); ?></a>
                          <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "<?php echo e($event->id); ?>" data-status="6"><?php echo e(trans('buttonTxt.not_interested')); ?></a>
                        <?php else: ?>
                         <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "<?php echo e($event->id); ?>" data-status="1"><?php echo e(trans('buttonTxt.attending')); ?></a>
                         <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "<?php echo e($event->id); ?>" data-status="2"><?php echo e(trans('buttonTxt.not_attending')); ?></a>
                         <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "<?php echo e($event->id); ?>" data-status="3"><?php echo e(trans('buttonTxt.tentative')); ?></a>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endif; ?>
               <?php endif; ?>
                
             


             </div>
             </div>
           </div>
         </div>

         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php else: ?> 

            <?php if($eventDay == 'own'): ?>                
                <div class="no_event_show col-sm-12">  
                                
                  <div class="no_envent_message">
                  <div class="first_line"><?php echo e(trans('eventList.you_have_not_created_any_event_till_date')); ?></div>                  
                  </div>
              </div>
            <?php else: ?>

              <div class="no_event_show col-sm-12"> 
                  
                  <div class="no_envent_message">
                  <div class="first_line"><?php echo e(trans('eventList.No_even_Schedule_fornow_please_check_at_later_date')); ?> </div>
                  <!-- <div class="second_line">Please check at a later date</div> -->
                  </div>
              </div>
            <?php endif; ?>
         <?php endif; ?>



 </div>
</div>


			</div>
      <div class="loadings" data-offset="<?php echo e($limit); ?>" data-event="<?php echo e($eventDay); ?>" data-from ="<?php echo e($fromDate); ?>" data-end="<?php echo e($toDate); ?>" ><div id="loading" style="display: none;"><img src="<?php echo e(asset('frontend/images/Spin.gif')); ?>" alt=""/> <span><?php echo e(trans('common.load_more')); ?>...</span></div></div>
  </div>
</div>
</div>




  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('script'); ?>
  <script src="<?php echo e(asset('frontend/js/jquery.countdown.js')); ?>"></script>
  <script type="text/javascript">

    $( ".timeCounter" ).each(function( index ) {
      var ths = $(this);
      var date = ths.attr('data-time');
      var newDate = new Date(); 
      newDate = new Date(date); 
      ths.countdown(newDate, function(event) {
        if(event.strftime('%D') === '00')
        {
          ths.text(
            event.strftime('%H:%M:%S')
          ); 
          ths.parent('h5').addClass('timer date-red');
          ths.parent('h5').removeClass('location');
          ths.parent().parent().parent().find('.dates').addClass('date-red');
        }

        if(event.strftime('%H:%M:%S') === '00:00:00')
        {
          ths.text('Started'); 
          ths.parent().find('i').addClass('fa fa-hourglass-start');
          ths.parent().find('i').removeClass('fa-clock-o');
          ths.parent('h5').removeClass('date-red');
        }      
      });
    });


 $(window).scroll(function(){  
    if ($(window).scrollTop() + $(window).height() +10 >= $(document).height()){        
        event_load();        
    }
 });

<?php if($eventList->count() >0): ?>
  var load = 'Yes';
<?php else: ?>
  var load = 'No';
<?php endif; ?>
 function event_load()
 {
    if(load == 'No')
      return false;
  var ths     = $('.loadings');
  var offset  = ths.attr('data-offset');
  var event   = ths.attr('data-event');
  var from   = ths.attr('data-from');
  var end   = ths.attr('data-end');

  var newOffset = parseInt(offset) + <?php echo e($limit); ?>;
     $.ajax({
      'type'  : 'POST',
      'data'  : {offset: offset, event: event, from:from, end:end },
      'url'   : BASE_URL+'/event_ajax_list',
      'async' : false,
      'beforeSend': function(){
        $('#loading').show();
      },
      'success': function(msg){
        if(msg == 0)
        {
            load = 'No';
            ths.hide();
            $('.event_section').after('<div class="no_envent_message nogroupcls" style=" display:block;">--- <?php echo e(trans('eventList.Event_List_End_Here')); ?>  ---</div>');
        }
        else
        {
          $('.event_section').append(msg);        
        }
        
        ths.attr('data-offset', newOffset);


        $( ".timeCounter" ).each(function( index ) {
          var ths = $(this);
          var date = ths.attr('data-time');
          var newDate = new Date(); 
          newDate = new Date(date); 
          ths.countdown(newDate, function(event) {
            if(event.strftime('%D') === '00')
            {
              ths.text(
                event.strftime('%H:%M:%S')
              ); 
              ths.parent('h5').addClass('timer date-red');
              ths.parent('h5').removeClass('location');
              ths.parent().parent().parent().find('.dates').addClass('date-red');
            }

            if(event.strftime('%H:%M:%S') === '00:00:00')
            {
              ths.text('Started'); 
              ths.parent().find('i').addClass('fa fa-hourglass-start');
              ths.parent().find('i').removeClass('fa-clock-o');
              ths.parent('h5').removeClass('date-red');
            } 
            $('#loading').hide();     
          });
        });

      }

   });

  }
 
  </script>

  <style type="text/css">
  .eventName{
    white-space: nowrap; 
    width: 100px; 
    overflow: hidden;
    text-overflow: ellipsis;
  }
  </style>

  <?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.event_app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>