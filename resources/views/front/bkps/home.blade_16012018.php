@extends('front.layout.app')
@section('title','Tawasul')
@section('content')


<div class="home-container">
     <div class="container">
       <div class="row">

          @include('front.includes.home_left')

         <div class="col-lg-6 col-sm-5">
           <!--<div class="post-timeline">
             <textarea placeholder="What's in your mind today?" name="name"></textarea>
             <div class="post-bar">
               <div class="row">
                 <div class="col-sm-6">
                   <ul class="nav-varient">
                     <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a></li>
                   </ul>
                 </div>
                 <div class="col-sm-6">
                   <div class="pull-right">
                     <input type="submit" name="" readonly="" value="Post">
                   </div>
                 </div>
               </div>
             </div>
           </div>-->

           <div class="timeline-blockMain">

            @if(!empty($feeds))
            @foreach($feeds as $feedrecord)
               @if($feedrecord->type=='Event')
                @php
                  $feed = $feedrecord->event;
                @endphp
                @if(count($feed))
                   <!-- ------------ event - -- -->
                   <div class="timelineBlock eventblock">
                       <div class="time-postedBy">
                         <div class="image-div">
                            @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                          @else
                          <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                          @endif   
                         </div>
                         <h2>{{ $feed->user->display_name }}</h2>
                         <p>{{ $feed->eventtype->name }} - {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
                       </div>
                       <div class="postedTime-image">
                         @if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) 
                          <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/original/'.$feed->eventImage[0]->image_name) }}&w=586&h=175&q=100" alt="">
                          @else
                          <img src="{{ asset('frontend/images/no-image-event-home.jpg') }}" alt="">
                         @endif
                       </div>

                       <div class="likeComment learn">
                       <div class="row">
                           <div class="col-sm-12">

                             <div class="eve-area">
                             <div class="dates"><span>{{ \Carbon\Carbon::parse($feed->event_start_date)->format('M') }}</span> {{ \Carbon\Carbon::parse($feed->event_start_date)->format('d') }}</div>
                             <div class="eve-right">
                             <h3><a href="{{ route('event_details', encrypt($feed->id)) }}">{{ $feed->name }}
                                @if($feed->getStatus($feed->id) == 1 || $feed->getStatus($feed->id) == 4)
                                  <span> - Attending</span> 
                                @elseif($feed->getStatus($feed->id) == 2 || $feed->getStatus($feed->id) == 5)
                                  <span class="not"> - Not Attending</span>
                                @endif
                             </a></h3>
                             <h5 class="location"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($feed->event_start_date)->format('dS M Y') }} @ @if($feed->allday_event =='Yes') {{ trans('home.all_day') }} @else {{ $feed->start_time }} - {{ $feed->end_time }} @endif</h5>
                             @if($feed->location!='')
                             <h5 class="location"><i class="fa fa-map-marker"></i>{{ $feed->location }}</h5>
                             @endif
                             </div>
                             <div class="clearfix"></div>

                             <div class="btn-right">
                               <!-- <a href="#" class="go">Attending</a>
                               <a href="#" class="not_go">Not Attending</a>
                               <a href="#" class="not_go">Tentative</a> -->


                             @if($feed->event_start_date <= $today)

                                      @if($feed->getStatus($feed->id) == 1)
                                          Attended
                                      @elseif($feed->getStatus($feed->id) == 2)
                                            Not Attended
                                      @elseif($feed->getStatus($feed->id) == 3)
                                           Tentetive
                                      @elseif($feed->getStatus($feed->id) == 4)
                                            Interested
                                      @elseif($feed->getStatus($feed->id) == 4)
                                           Not Interested
                                      @elseif($feed->getStatus($feed->id) == 6)
                                          Cancelled
                                      @endif
                            @else
                                @if($feed->event_end_date > $today)
                                @if($isInvited > 0)
                                  @if($feed->getStatus($feed->id) == 1 || $feed->getStatus($feed->id) == 4)
                                        <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "'+eventId+'" data-status="6">Cancel</a>
                                    @elseif($feed->getStatus($feed->id) == 2 || $feed->getStatus($feed->id) == 5 || $feed->getStatus($feed->id) == 6)
                                        <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "'+eventId+'" data-status="1">Attend</a>
                                    @elseif($feed->getStatus($feed->id) == 3)
                                      <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "'+eventId+'" data-status="4">Interested</a>
                                      <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "'+eventId+'" data-status="5">Not Interested</a>
                                    @else
                                     <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "{{ $feed->id }}" data-status="1">Attending</a>
                                     <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $feed->id }}" data-status="2">Not Attending</a>
                                     <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $feed->id }}" data-status="3">Tentative</a>
                                  @endif
                                @endif
                                @endif
                            @endif
                             </div>


                             </div>

                         </div>


                         </div>
                       </div>

                     </div>
             <!-- ------------ event - -- -->
             @endif
               @elseif($feedrecord->type=='Group')

                <!-- ------------ group - -- -->
                 @php
                  $feed = $feedrecord->group;
                @endphp
                @if(count($feed)) 
                <?php        
                  $group_id = base64_encode($feed->group_user_id+ 100);
                ?>
                
                @if( is_member_group(\Auth::guard('user')->user()->id,$feed->group_user_id)>0 && $feed->status=='Active')
           <div class="timelineBlock groupblock">
               <div class="time-postedBy">
                 <div class="image-div"> @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                      @endif </div>
                 <h2>{{ $feed->user->display_name }}</h2>
                 <p>@if($feed->group_type_id==1) Global group @elseif($feed->group_type_id==2) Departmental group @else Activity Group @endif - {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
               </div>
               <div class="postedTime-image">
                <?php if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {?>
               <img src="{{ asset('uploads/group_images/').'/'.$feed->cover_image }}" alt=""/>
               <?php }else{ ?>
                <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}"  />
              <?php  } ?>
               </div>

               <div class="likeComment learn">
               <div class="row">
                 <div class="col-sm-12 col-lg-9">

                 <p>A new <strong>{{ $feed->group_name }}</strong> has been published</p>
                 </div>
                   <div class="col-sm-12 col-lg-3">
                   <a href="{{URL::Route('group_details').'/'.$group_id}}" class="view_all pull-right"> Learn More</a>
                   </div>
                 </div>
               </div>

             </div>
             @endif
             @endif
             <!-- ------------ group - -- -->

               @elseif($feedrecord->type=='Post')

               <!-- ------------ post with image - -- -->
                @php
                $feed = $feedrecord->post;
                @endphp
                @if(count($feed))    
                <?php        
                  $group_id = base64_encode($feed->group_id+ 100);
                ?>         
                @if( is_member_group(\Auth::guard('user')->user()->id,$feed->group_id)>0)
             <div class="timelineBlock">
               <div class="time-postedBy">
                 <div class="image-div">
                   @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                      @endif  
                 </div>
                 <h2>{{ $feed->user->display_name }}</h2>
                 <p>{{$feed->location}} @if($feed->location!='') - @endif {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
               </div>
               <div class="postedTime-image">
                 
                 @if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image)))
                    <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/post_images/'.$feed->image) }}&w=586&h=175&q=100" alt=""/>
                    @if($feed->text!='')
                      <p>{{ $feed->text }}</p>
                    @endif        
                  @else
                    @if($feed->text!='')
                      <h2>{{ $feed->text }}</h2>
                    @endif

                  @endif 
                   - <b>Posted in <a href ="{{URL::Route('group_details').'/'.$group_id}}">{{ group_name($feed->group_id) }} </b></a>
               </div>
               <div class="likeComment">
                 <div class="row">
                   <div class="col-sm-12 col-md-6 col-lg-4">
                      @if(is_liked_post(\Auth::guard('user')->user()->id,$feed->id)==1)
                      <?php $cls = 'active_lk'; ?>
                      @else
                       <?php $cls = ''; ?>
                      @endif
                     <button class="face-like {{$cls}}"  type="button" id="lkid_{{$feed->id}}" alt="{{$feed->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
                   </div>
                   <div class="col-sm-12 col-md-6 col-lg-8">
                     <p><span id="likecnt_id_{{$feed->id}}" class="likecls">{{count($feed->likes)}} Likes </span>- <a href="javascript:void(0);" class="user-com" data-target="{{$feed->id}}" id="cmncnt_id_{{$feed->id}}">{{count($feed->comments)}} Comments</a></p>
                     <input type="hidden" value="{{count($feed->comments)}}" id="cmntid_{{$feed->id}}" />
                     <input type="hidden" value="{{count($feed->likes)}}" id="likeid_{{$feed->id}}" />
                   </div>
                 </div>
               </div>
               <div class="comment-other" id="comment_2">
                 @if(count($feed->comments))   <?php  $i = 0; ?>           
                 @foreach($feed->comments as $comment) <?php $i ++; ?>

                 @if($i==2) <div id="comment_{{$feed->id}}" style="display:none;"> @endif
                   <div class="comment-other-single">
                     <div class="image-div">
                      @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
                            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
                          @else
                          <img src="{{ asset('uploads/no_img.png') }}" alt="">
                      @endif     </div>
                     <h2>{{ $comment->user->display_name }} <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}</span></h2>
                     <p>{{$comment->body}}</p>
                   </div>
                    @if($i==count($feed->comments) && $i>=2) </div> @endif
                  @endforeach                
                 @endif
                <div id="commentsnwid_{{$feed->id}}">
                </div> 

               </div>
               <!-- for later -->
               <div class="comment-field">
                 <div class="image-div">
                  @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
                   @else
                    <img src="{{ asset('uploads/no_img.png') }}" alt=""/>
                  @endif
                 </div>
                 <textarea id="commentid_{{$feed->id}}" alt="{{$feed->id}}" class="cmntcls" name="comment_text" placeholder="Press Enter to post comment"></textarea>
               </div>
                <!-- for later -->
             </div>   
                @endif      
              <!-- ------------ post with image - -- -->
                @endif
               @endif

            @endforeach
            @endif
           
            
            

           </div>

           <div class="loadings"><!--<img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>Load More...</span>--></div>


         </div>

        @include('front.includes.home_right')

       </div>
     </div>
   </div>

   <script type="text/javascript">
      $(document).ready(function() {

      $(".cmntcls").keypress(function(event) {
          if (event.which == 13) {
            event.preventDefault();
            var post_id      = $( this).attr( "alt" );
            var comment_text = $('#commentid_'+post_id).val();               
            
            request = $.ajax({
                    url: "{{URL::Route('savepostcomment')}}",
                    type: "POST",
                    beforeSend:function() { 
                    
                     $("#commentid_"+post_id).html("<img src='{{ asset('frontend/images/Spin.gif') }}'>");
                    },
                    data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},
                    
                  });

                  request.done(function(msg) {                       
                  
                  var html = $("#commentsnwid_"+post_id).html();                       
                  html = $("#commentsnwid_"+post_id).html(html+''+msg); 
                  var cmnt_cnt = $("#cmntid_"+post_id).val(); 
                   
                  cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));
                   
                  $("#cmncnt_id_"+post_id).html(cmnt_cnt+' Comments')  ;  
                  $("#cmntid_"+post_id).val(cmnt_cnt)   ;            
                     //$("#commentsnwid").val(msg);
                  $("#commentid_"+post_id).val( "" );
                  });

                  request.fail(function(jqXHR, textStatus) {
                    console.log( "Request failed: " + textStatus );
                  });
          }
      });  
      
      $(".face-like").click(function () { 
          var post_id = $( this).attr( "alt" );

          request = $.ajax({
            url: "{{URL::Route('likeunlike')}}",
            type: "POST",                       
            data: {'post_id':post_id,'_token':CSRF_TOKEN},                  
          });

          request.done(function(msg) {
          if(msg==1) {                    
           /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
            $( "#lkid_"+post_id ).addClass( "active_lk" );
            var like_cnt = $("#likeid_"+post_id).val(); 
            like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
            $("#likecnt_id_"+post_id).html(like_cnt+' likes ')  ;
            $("#likeid_"+post_id).val(like_cnt)   ;  
          }else {
            $("#lkid_"+post_id).removeClass("active_lk");
            var like_cnt = $("#likeid_"+post_id).val(); 
            like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
            $("#likecnt_id_"+post_id).html(like_cnt+' likes ')  ;
            $("#likeid_"+post_id).val(like_cnt)   ; 
          }                
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
      });
   </script>
<style>
  .active_lk{
    background: #2ec4e7;
    border: 1px solid #109fc0;
    color: #FFF;
}
  
  </style>
   @endsection

   @section('script')

    <script>

      $(document).on('click','.event_response',function(){

        var ths     = $(this);
        var eventId = ths.attr('data-eventId');
        var status  = ths.attr('data-status');

        var AttendHtml = '<a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "'+eventId+'" data-status="1">Attend</a>';
        var interestedHtml = '<a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "'+eventId+'" data-status="4">Interested</a>';
        var notInterestedHtml = '<a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "'+eventId+'" data-status="5">Not Interested</a>';
        var cancelHtml = '<a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "'+eventId+'" data-status="6">Cancel</a>';
        var attendText = '<span> - Attending</span>';
        var notAttendText = '<span class="not"> - Not Attending</span>';

        $.ajax({
          'type'  : 'post',
          'data'  : {eventId: eventId, status: status},
          'url'   : BASE_URL+'/event_response_ajax',
          'success': function(msg){
            
            if(status == 1)
            {
              ths.parent().append(cancelHtml); 
              ths.parent().parent().find('h3').find('a').find('span').remove(); 
              ths.parent().parent().find('h3').find('a').append(attendText); 
              ths.parent().find('.atndBtn').remove(); 

            }
            if(status == 2)
            {
              ths.parent().append(AttendHtml); 
              ths.parent().parent().find('h3').find('a').find('span').remove();
              ths.parent().parent().find('h3').find('a').append(notAttendText);
            }
            if(status == 3)
            {
              ths.parent().append(interestedHtml);
              ths.parent().append(notInterestedHtml);                     
            }          
            if(status == 4)
            {
              ths.parent().append(cancelHtml);
              ths.parent().parent().find('h3').find('a').find('span').remove(); 
              ths.parent().parent().find('h3').find('a').append(attendText);
              ths.parent().find('.intBtn').remove();
            }
            if(status == 5)
            {
              ths.parent().append(AttendHtml); 
              ths.parent().parent().find('h3').find('a').find('span').remove();
              ths.parent().parent().find('h3').find('a').append(notAttendText);
              ths.parent().find('.intBtn').remove();
            }
            if(status == 6)
            {
              
              ths.parent().append(AttendHtml); 
              ths.parent().parent().find('h3').find('a').find('span').remove();
              ths.parent().parent().find('h3').find('a').append(notAttendText);
              ths.remove();
            }
            ths.parent().find('.event_btn').remove();
            
          }
        }); 
    })


    </script>
   @endsection
