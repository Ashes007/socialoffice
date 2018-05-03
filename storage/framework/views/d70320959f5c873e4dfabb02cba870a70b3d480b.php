<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>

<?php 
    $today = date('Y-m-d');
?>
<div class="home-container">

  <div class="container">
    <div class="row">
       <?php echo $__env->make('front.includes.home_left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

      <div class="col-lg-6 col-sm-5"><h2 class="c-recent">Notifications</h2>
        <div class="timeline-blockMain">
          <div class="notific-cont" id="results">              
            <?php echo $__env->make('front.data-notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>     
          </div>           
        </div>
        <div class=" ajax-loading" style="text-align: center;"><img src="<?php echo e(asset('frontend/images/Spin.gif')); ?>" alt=""/> <span><?php echo e(trans('common.load_more')); ?></span></div>
      </div>
      <?php echo $__env->make('front.includes.home_right', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
  </div>
</div>

</div>


   
<style>
.active_lk{
background: #2ec4e7;
border: 1px solid #109fc0;
color: #FFF;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
  var page = 1; //track user scroll as page number, right now page number is 1
  load_more(page);
  $(window).scroll(function() { //detect page scroll  
  if($(window).scrollTop() + $(window).height()+10 >= $(document).height()) { //if user scrolled from top to bottom of the page   
  page++; //page number increment
  load_more(page); //load content   
  }
  }); 
  function load_more(page){ 
  $.ajax( 
  { 
    url: '?page=' + page ,
    type: "get",
    datatype: "html",
    beforeSend: function()
    {              
    $('.ajax-loading').show();
    }
  })
  .done(function(data)
  {
    //alert(data);
    //alert(data.length);
    if(data.length == 0){
    console.log(data.length);

    //notify user if nothing to load
    if(page==1){
    $('.ajax-loading').html("<div class='form_submit_msg'> <div class='succ_img'><img src="+"<?php echo e(asset('frontend/images/opps.png')); ?>"+"></div>  <div class='message'> <?php echo e(trans('group.no_notification')); ?></div>  </div>");
    }else{
    $('.ajax-loading').html('<span class="no_envent_message nogroupcls">'+lang.get('alert.no_more_record_feed')+'</span>');
    }

    return;
    }
    $('.ajax-loading').hide(); //hide loading animation once data is received
    $("#results").append(data); //append data into #results element          
  })
  .fail(function(jqXHR, ajaxOptions, thrownError)
  {
  //alert('No response from server');
  });
  }
</script>
  <script>
      $(".accept_noti_id_page").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "<?php echo e(URL::Route('acceptmember')); ?>",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button"> Accepted </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button"> Accepted </span>')  ;
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
      $(".reject_noti_id_page").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "<?php echo e(URL::Route('rejectmember')); ?>",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {alert(msg);
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button reject"> Rejected </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button reject"> Rejected </span>')  ;
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });

      $(".accept_moderator_noti_id_page").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "<?php echo e(URL::Route('acceptmoderator')); ?>",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button">Accepted </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button"> Accepted </span>')  ;
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
      

      $(".reject_moderator_noti_id_page").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "<?php echo e(URL::Route('rejectmoderator')); ?>",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button reject"> Rejected </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button reject"> Rejected </span>')  ; 
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
    </script>
   
   <?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>