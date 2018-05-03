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
              <li><a href="{{ URL::Route('home') }}">Home</a></li>
              <li><a href="{{ URL::Route('user_logout') }}">Logout</a></li>
            </ul>
          </div>

          <div class="notification-div dropdown">
            <span class="noti-icon dropdown-toggle" id="notific" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-bell" aria-hidden="true"></i></span>
            <div class="dropdown-menu" aria-labelledby="notific">
              <div class="notific-top">
                <p>Notification</p> 
              </div>
              <div class="notific-cont">
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
                 @if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' )
                <?php $group_id = base64_encode($h_notification->notificationable_id+ 100);?> 
                 <a href="{{ URL::Route('group_details').'/'.$group_id }}">

                 @if(count($model) && $model->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $model->user->profile_photo)))
                  <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/user_images/profile_photo/thumbnails/'.$model->user->profile_photo) }}&w=68&h=68&q=100" alt="{{ $model->user->id }}"> 
                  @else
                  <img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/no_user_thumb.png') }}&w=68&h=68&q=100" alt=""/>
                  @endif 

                 </a>
                 @endif

                  @if($h_notification->notificationable_type=='Event'  )
                

                 @if(count($model_event) && $model_event->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $model_event->user->profile_photo)))
                  <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/user_images/profile_photo/thumbnails/'.$model_event->user->profile_photo) }}&w=68&h=68&q=100" alt="{{ $model_event->user->id }}"> 
                  @else
                  <img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/no_user_thumb.png') }}&w=68&h=68&q=100" alt=""/>
                  @endif 

                 
                 @endif
                 </div>
                 <input type="hidden" name="notification_id" value="{{$h_notification->id}}" id="h_noti_id" />
                 <p>{{$h_notification->text}}</p>
                 <p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> {{ \DateTime::createFromFormat('Y-m-d H:i:s', $h_notification->created_at)->format('dS M Y h:i A') }}</p>
                 @if($h_notification->notificationable_type=='GroupMember' || $h_notification->notificationable_type=='GroupModerator' )
                 <p id="status_id_notification_{{$h_notification->id}}"><br>
                 @if($h_notification->accept_status==0)
                 <input type="button" value="accept" alt="{{$h_notification->id}}" class="view_all @if($h_notification->notificationable_type=='GroupMember')accept_noti_id @else accept_moderator_noti_id @endif">&nbsp<input type="button" alt="{{$h_notification->id}}" value="reject"  class="view_all @if($h_notification->notificationable_type=='GroupMember') reject_noti_id @else reject_moderator_noti_id @endif">
                 @elseif($h_notification->accept_status==1)
                 Accepted
                 @else
                 Rejected
                 @endif
                 </p>
                 @endif
               </div>                      
                              
               @endforeach
               @else
                <div class="notific-cont-single">
                 <p>

                <!--  <img src="{{ asset('timthumb.php') }}?src={{ asset('frontend/images/opps.png') }}&w=68&h=68&q=100" alt=""/>-->

                 Oops! You do not have any Notifications!
                 </p>
                 </div>
               @endif
              </div>
              <div class="notific-bottom text-center"><a href="{{URL::Route('notifications')}}">View All</a></div>
            </div>
          </div>

          <div class="search-part">
          <div id="sb-search" class="sb-search">
            <form>
              <input class="sb-search-input" placeholder="Search..." type="text" value="" name="search" id="search">
              <input class="sb-search-submit" type="submit" value="">
              <span class="sb-icon-search"></span>
            </form>
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
            
            $("#status_id_notification_"+notification_id).html('<br> Accepted ')  ;
            $("#status_notification_"+notification_id).html('<br> Accepted ')  ;
            
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

          request.done(function(msg) {alert(msg);
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<br> Rejected ')  ;
            $("#status_notification_"+notification_id).html('<br> Rejected ')  ;
            
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
            
            $("#status_id_notification_"+notification_id).html('<br> Accepted ')  ;
            $("#status_notification_"+notification_id).html('<br> Accepted ')  ;
            
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

          request.done(function(msg) {alert(msg);
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            
            $("#status_id_notification_"+notification_id).html('<br> Rejected ')  ;
            $("#status_notification_"+notification_id).html('<br> Rejected ')  ; 
            
          }          
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
    </script>
    <script src="{{ asset('frontend/js/jquery.colorbox.js') }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/colorbox.css')}}" />