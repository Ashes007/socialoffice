<div class="top-wrapper">
     <div class="container">
      <div class="row">
        <div class="col-sm-3">
           <div class="logo">
             <a href="{{ URL::Route('home') }}"><img src="{{ asset('frontend/images/logo.png') }}" alt=""></a>
           </div>
        </div>
        <div class="col-sm-9">

          <div class="lang">
            <ul>
               <!-- <li class="active"><a href="#"><img src="{{ asset('frontend/images/flag1.jpg') }}" alt=""/> عربي </a></li>-->
            </ul>
          </div>

          <div class="top-nav">
            <ul>
              <li><a href="{{ URL::Route('home') }}">{{ trans('header.home') }}</a></li>
              <li><a href="{{ URL::Route('user_logout') }}">{{ trans('header.logout') }}</a></li>
            </ul>
          </div>

          <div class="notification-div dropdown">
            <span class="noti-icon dropdown-toggle unread_notification_bell" id="notific" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="unread_notification" style="display: {{ notification_count(auth()->guard('user')->user()->id)>0 ? 'block' : 'none' }};">{{ (notification_count(auth()->guard('user')->user()->id) >0 )? ((notification_count(auth()->guard('user')->user()->id)>99)?'99+': notification_count(auth()->guard('user')->user()->id)) : ''}}</i><i class="fa fa-bell" aria-hidden="true"></i></span>
            <div class="dropdown-menu" aria-labelledby="notific">
              <div class="notific-top">
                <p>{{ trans('header.Notification') }}</p> 
              </div>
              <div class="notific-cont">
              <?php 
              	$today = date('Y-m-d');
              ?>

              @if(count($notifications)>0) 
              @foreach($notifications as $h_notification)
              @php
              $model=array();
              $model_event=array();
              $model = $h_notification->groups;
              $model_event = $h_notification->events;
              @endphp
               <div class="notific-cont-single">
                 <div class="notific-img-user">
                 @if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' || $h_notification->notificationable_type=='GroupInsert'|| $h_notification->notificationable_type=='GroupUpdate'|| $h_notification->notificationable_type=='GroupDelete'|| $h_notification->notificationable_type=='GroupAccept'|| $h_notification->notificationable_type=='GroupReject'|| $h_notification->notificationable_type=='GroupModeratorAccept'|| $h_notification->notificationable_type=='GroupModeratorReject')
                <?php $group_id = encrypt($h_notification->notificationable_id);?> 
                 <a href="{{ URL::Route('group_details').'/'.$group_id }}">
                  
                 @if(count($model) && $model->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $model->profile_image)))
                  <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/profile_image/'.$model->profile_image) }}&w=68&h=68&q=100" alt="{{ $model->user->id }}"> 
                  @else
                  <img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/no-image-event-list.jpg') }}&w=68&h=68&q=100" alt=""/>
                  @endif 

                 </a>
                 @endif

                  @if($h_notification->notificationable_type=='Event' || $h_notification->notificationable_type=='EventEdit' )
                

                 @if(count($model_event) && $model_event->event_profile_image != NULL && file_exists(public_path('uploads/event_images/profile_image/' . $model_event->event_profile_image)))
                      <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/profile_image/'.$model_event->event_profile_image) }}&w=68&h=68&q=100" alt=""> 
                  @else
                      <img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/no-image-event-list.jpg') }}&w=68&h=68&q=100" alt=""/>
                  @endif 

                 
                 @endif
                 </div>
                 <input type="hidden" name="notification_id" value="{{$h_notification->id}}" id="h_noti_id" />
                 <p><?php echo strip_tags($h_notification->text,"<a>")?></p>
                 <p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> {{ \DateTime::createFromFormat('Y-m-d H:i:s', $h_notification->created_at)->format('dS M Y h:i A') }}</p>
                 @if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' )
                 <p id="status_id_notification_{{$h_notification->id}}" class="notibtn">
                 @if($h_notification->accept_status==0)
                 <input type="button" value="Accept" alt="{{$h_notification->id}}" class="view_all @if($h_notification->notificationable_type=='GroupMember')accept_noti_id @else accept_moderator_noti_id @endif">&nbsp<input type="button" alt="{{$h_notification->id}}" value="Reject"  class="view_all @if($h_notification->notificationable_type=='GroupMember') reject_noti_id @else reject_moderator_noti_id @endif">
                 @elseif($h_notification->accept_status==1)
                 <span class ="attend_status_button">Accepted</span>
                 @else
                <span class ="attend_status_button reject"> Rejected</span>
                 @endif
                 </p>
                 @endif

                 @if($h_notification->notificationable_type=='Event' )
                 @if($h_notification->events->event_start_date <= $today)
                  
                    @if($h_notification->events->getStatus($h_notification->events->id) == 1)
                        <div class="notibtn"><span class="attend_status_button">{{ trans('buttonTxt.attended') }}</span></div>
                    @elseif($h_notification->events->getStatus($h_notification->events->id) == 2)
                        <div class="notibtn"><span class="attend_status_button">{{ trans('buttonTxt.not_attended') }}</span></div>
                    @elseif($h_notification->events->getStatus($h_notification->events->id) == 3)
                        <div class="notibtn"><span class="attend_status_button">{{ trans('buttonTxt.tentative') }}</span></div>
                    @elseif($h_notification->events->getStatus($h_notification->events->id) == 4)
                        <div class="notibtn"><span class="attend_status_button">{{ trans('buttonTxt.interested') }}</span></div>
                    @elseif($h_notification->events->getStatus($h_notification->events->id) == 4)
                        <div class="notibtn"><span class="attend_status_button">{{ trans('buttonTxt.not_interested') }}</span></div>
                    @elseif($h_notification->events->getStatus($h_notification->events->id) == 6)
                       <div class="notibtn"><span class="attend_status_button not">{{ trans('buttonTxt.not_attended') }}</span></div>
                    @else
                       <div class="notibtn"><span class="attend_status_button not">{{ trans('buttonTxt.not_attended') }}</span></div>
                    @endif
                  
               @else
                <div class="notibtn">
                  @if($h_notification->events->event_end_date > $today)
                    
					
                      @if($h_notification->events->getStatus($h_notification->events->id) == 1 || $h_notification->events->getStatus($h_notification->events->id) == 4)
                            <input type="button" class="not_go event_response .canBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="6" value="{{ trans('buttonTxt.not_attend') }}" />
                        @elseif($h_notification->events->getStatus($h_notification->events->id) == 2 || $h_notification->events->getStatus($h_notification->events->id) == 5 || $h_notification->events->getStatus($h_notification->events->id) == 6)
                            <input type="button" class="go event_response atndBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="1" value="{{ trans('buttonTxt.attend') }}" />
                        @elseif($h_notification->events->getStatus($h_notification->events->id) == 3)
                            <input type="button" class="go event_response intBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="1" value="{{ trans('buttonTxt.interested') }}" />
                            <input type="button" class="not_go event_response intBtn" data-eventId = "{{ $h_notification->events->id }}" data-status="6" value="{{ trans('buttonTxt.not_interested') }}" />
                        @else
                            <input type="button" class="go event_response event_btn" data-eventId = "{{ $h_notification->events->id }}" data-status="1" value="{{ trans('buttonTxt.attending') }}" />
                            <input type="button" class="not_go event_response event_btn" data-eventId = "{{ $h_notification->events->id }}" data-status="2" value="{{ trans('buttonTxt.not_attending') }}" />
                            <input type="button" class="not_go event_response event_btn" data-eventId = "{{ $h_notification->events->id }}" data-status="3" value="{{ trans('buttonTxt.tentative') }}" />                      
                    @endif
                  @endif
                  </div> 
                @endif
                @endif


               </div>                      
                              
               @endforeach
               <div class="notific-bottom text-center"><a href="{{URL::Route('notifications')}}">{{ trans('header.View_All') }}</a></div>
               @else
                <div class="notific-cont-single oops_noti">
                 <p>

                <!--  <img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/opps.png') }}&w=68&h=68&q=100" alt=""/>-->

                 {{ trans('header.Oops_You_do_not_have_any_Notifications') }}
                 </p>
                 </div>
               @endif
              </div>
              
            </div>
          </div>

          <div class="search-part">
            <!-- <div id="sb-search" class="sb-search">
              <form>
                <input class="sb-search-input" placeholder="Search..." type="text" value="" name="search" id="search-input">
                <input class="sb-search-submit" type="button" value="">
                <span class="sb-icon-search"></span>
              </form>
            </div> -->
            
            <div class="aa-input-container" id="aa-input-container">
              <input type="search" id="aa-search-input" class="aa-input-search" placeholder="{{ trans('header.search') }}" name="search" autocomplete="off"/>
              <span class="sb-icon-search"></span>
            </div>
            
          </div>

        </div>
      </div>
     </div>
   </div>
    <script>
      $(".accept_noti_id").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "{{URL::Route('acceptmember')}}",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button"> '+"{{ trans('header.Accepted') }}"+' </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button"> '+"{{ trans('header.Accepted') }}"+'</span> ')  ;
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
      $(".reject_noti_id").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "{{URL::Route('rejectmember')}}",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button reject"> '+"{{ trans('header.Rejected') }}"+' </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button reject"> '+"{{ trans('header.Rejected') }}"+'</span> ')  ;
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });

      $(".accept_moderator_noti_id").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "{{URL::Route('acceptmoderator')}}",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button"> '+"{{ trans('header.Accepted') }}"+' </span>')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button"> '+"{{ trans('header.Accepted') }}"+' </span>')  ;
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
      

      $(".reject_moderator_noti_id").click(function () { 
          var notification_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "{{URL::Route('rejectmoderator')}}",
            type: "POST",                       
            data: {'notification_id':notification_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<span class ="attend_status_button reject">'+"{{ trans('header.Rejected') }}"+'</span> ')  ;
            $("#status_notification_"+notification_id).html('<span class ="attend_status_button reject">'+"{{ trans('header.Rejected') }}"+'</span> ')  ; 
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });

      $( document ).on( "keyup", "#aa-search-input", function(event) { 
          
         var $html1 = $('.aa-dataset-1').html();
         if($html1==''){
            $('.aa-dataset-1').hide();
          }
          else
          {
            $('.aa-dataset-1').show();
          }

          var $html2 = $('.aa-dataset-2').html();         
          if($html2==''){
            $('.aa-dataset-2').hide();
          }
          else
          {
            $('.aa-dataset-2').show();
          }

          var $html3 = $('.aa-dataset-3').html();         
          if($html3==''){
            $('.aa-dataset-3').hide();
          }
          else
          {
            $('.aa-dataset-3').show();
          }

      });
      
    </script>
    <script src="{{ asset('frontend/js/jquery.colorbox.js') }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/colorbox.css')}}" />