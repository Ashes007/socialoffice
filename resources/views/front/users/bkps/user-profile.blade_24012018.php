@extends('front.layout.app')
@section('title','Tawasul')
@section('content')


<div class="home-container">
     <div class="container">
       <div class="top-backs">
       <div class="timeline-photo">
         @if($userdetails->cover_photo != NULL && file_exists(public_path('uploads/user_images/cover_photo/' . $userdetails->cover_photo)))
         <img src="{{ asset('uploads/user_images/cover_photo/thumbnails/'.$userdetails->cover_photo) }}" alt="img" />
         @else
         <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}" alt=""/>
         @endif
         <div class="timeline-cont">
           <div class="row">
             <div class="col-sm-8">
               <div class="timeline-profile">
                 <div class="image-div">
                    @if($userdetails->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $userdetails->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$userdetails->profile_photo) }}" alt=""/>
                  @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                  @endif
                 </div>
                 <h2>{{ $userdetails->display_name }}</h2>
                 <p>@ {{ $userdetails->ad_username }}</p>
               </div>
             </div>
             <div class="col-sm-4">
              
             </div>
           </div>
         </div>
       </div>




     </div><br/>
     <div class="row">

       <div class="col-sm-4">
         <div class="right-sidebar clearfix">
           <div class="recentUpdates">
            <h2 class="white-bg">About</h2>
            <div class="cont-wrap">
                <div class="aboutS">
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Date of Birth</span></p></div>
                      <div class="col-sm-7"><p>@if($userdetails->date_of_birth!=NUll) {{  date("d F ",strtotime($userdetails->date_of_birth)) }} @else -NA- @endif</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Date of Joining</span></p></div>
                      <div class="col-sm-7"><p>@if($userdetails->date_of_joining!=NUll) {{  date("d F Y ",strtotime($userdetails->date_of_joining)) }} @else -NA- @endif</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Designation</span></p></div>
                      <div class="col-sm-7"><p>{{$userdetails->title}}</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Deparment</span></p></div>
                      <div class="col-sm-7"><p>{{$userdetails->department->name}}</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Company</span></p></div>
                      <div class="col-sm-7"><p>{{$userdetails->company->name}}</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Phone</span></p></div>
                      <div class="col-sm-7"><p>{{$userdetails->mobile}}</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-5"><p><span>Email</span></p></div>
                      <div class="col-sm-7"><p>{{$userdetails->email}}</p></div>
                    </div>
                  </div>
                  <div class="aboutS-Single">
                    <div class="row">
                      <div class="col-sm-12"><p style="border-bottom:1px solid #d1d1d1; padding-bottom:5px;"><span>Description</span></p></div>
                      <div class="col-sm-12"><p style="padding-top:5px;">{{$userdetails->description}}</p></div>
                    </div>
                  </div>
                </div>
            </div>
           </div>

          

           <div class="recentUpdates group">
            <h2>{{ $userdetails->display_name }}'s Groups</h2>
            <div class="cont-wrap">
              <div class="cont-wrap-main">
               @if(count($mygroups)>0)
                @foreach($mygroups as $mygroup)
                <div class="recent-block">
                <?php           
                  $group_id = base64_encode($mygroup->group_user_id+ 100);
                  ?>
                  <div class="image-div">
                  <a href="{{URL::Route('group_details').'/'.$group_id}}">
                    <?php if(file_exists( public_path('uploads/group_images/'.$mygroup->cover_image) )&& ($mygroup->cover_image!='' || $mygroup->cover_image!=NULL)) {?>
                     <img src="{{ asset('uploads/group_images/').'/'.$mygroup->cover_image }}" alt="" />
                     <?php }else{ ?>
                      <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}" />
                    <?php  } ?>
                        
                   </a></div>
                  <h4><a href="{{URL::Route('group_details').'/'.$group_id}}">{{$mygroup->group_name}}</a></h4>
                  <!--<div class="user-on-stat"><i class="fa fa-user" aria-hidden="true"></i></div>-->
                </div>
                @endforeach
                @else
                <div class="recent-block">
                No group for now
                </div>
                @endif
               
              </div>
            </div>
           </div>
         </div>
       </div>

       <div class="col-sm-8">
         <!-- <div class="post-timeline">
           <textarea placeholder="What's in your mind today?" name="name"></textarea>
           <div class="post-bar">
             <div class="row">
               <div class="col-sm-6">
                 <ul class="nav-varient">
                   <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                   <li><a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a></li>
                   <li><a href="#"><i class="fa fa-film" aria-hidden="true"></i></a></li>
                   <li><a href="#"><i class="fa fa-microphone" aria-hidden="true"></i></a></li>
                 </ul>
               </div>
               <div class="col-sm-6">
                 <div class="pull-right">
                   <input type="submit" name="" value="Post">
                 </div>
               </div>
             </div>
           </div>
         </div> -->

         <div class="timeline-blockMain">

        
          @if(!empty($feeds))
           @php
            $stat=0;
           @endphp
            @foreach($feeds as $feedrecord)
               @if($feedrecord->type=='Event')
                @php
                  $feed = $feedrecord->event;

                @endphp
                         
                @if($feed['status'] == 'Active')
                @if(count($feed))
                 @php
                    $stat=1;
                 @endphp
                   <!-- ------------ event - -- -->
                   <div class="timelineBlock eventblock margin-null">
                       <div class="time-postedBy">
                         <div class="image-div">
                            @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                          @else
                          <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                          @endif   
                         </div>
                         <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
                         <p>{{ $feed->eventtype->name }} - {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
                       </div>
                       <div class="postedTime-image">
                         @if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) 
                          <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/original/'.$feed->eventImage[0]->image_name) }}&w=799&h=386&q=100" alt="">
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
                             <h3><a href="{{ route('event_details', encrypt($feed->id)) }}">{{ str_limit($feed->name,30,'...') }}
                             @if($feed->event_start_date > $today)
                                @if($feed->getStatusUser($user_id,$feed->id) == 1 || $feed->getStatusUser($user_id,$feed->id) == 4)
                                  <span> - Attending</span> 
                                @elseif($feed->getStatusUser($user_id,$feed->id) == 2 || $feed->getStatusUser($user_id,$feed->id) == 6)
                                  <span class="not"> - Not Attending</span>
                                @endif
                              @endif
                             </a></h3>
                             <h5 class="location"><i class="fa fa-clock-o" aria-hidden="true"></i>{{ \Carbon\Carbon::parse($feed->event_start_date)->format('dS M Y') }} @ @if($feed->allday_event =='Yes') {{ trans('home.all_day') }} @else {{ $feed->start_time }} - {{ $feed->end_time }} @endif</h5>
                             @if($feed->location!='')
                             <h5 class="location"><i class="fa fa-map-marker"></i>{{ $feed->location }}</h5>
                             @endif
                             </div>
                             <div class="clearfix"></div>

                            <!-- <div class="btn-right">
                              


                             @if($feed->event_start_date <= $today)

                                      @if($feed->getStatusUser($user_id,$feed->id) == 1)
                                          <div class="attend_status_button">Attended</div>
                                      @elseif($feed->getStatusUser($user_id,$feed->id) == 2)
                                            <div class="attend_status_button">Not Attended</div>
                                      @elseif($feed->getStatusUser($user_id,$feed->id) == 3)
                                           <div class="attend_status_button">Tentetive</div>
                                      @elseif($feed->getStatusUser($user_id,$feed->id) == 4)
                                            <div class="attend_status_button">Interested</div>
                                      @elseif($feed->getStatusUser($user_id,$feed->id) == 4)
                                           <div class="attend_status_button">Not Interested</div>
                                      @elseif($feed->getStatusUser($user_id,$feed->id) == 6)
                                          <div class="attend_status_button">Cancelled</div>
                                      @endif
                            @else
                              @if($loggedin_user != $feed->user_id)
                                @if($feed->event_end_date > $today)
                                @if($isInvited > 0)
                                  @if($feed->getStatusUser($user_id,$feed->id) == 1 || $feed->getStatusUser($user_id,$feed->id) == 4)
                                        <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "'+eventId+'" data-status="6">Cancel</a>
                                    @elseif($feed->getStatusUser($user_id,$feed->id) == 2 || $feed->getStatusUser($user_id,$feed->id) == 5 || $feed->getStatusUser($user_id,$feed->id) == 6)
                                        <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "'+eventId+'" data-status="1">Attend</a>
                                    @elseif($feed->getStatusUser($user_id,$feed->id) == 3)
                                      <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "'+eventId+'" data-status="1">Interested</a>
                                      <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "'+eventId+'" data-status="6">Not Interested</a>
                                    @else
                                     <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "{{ $feed->id }}" data-status="1">Attending</a>
                                     <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $feed->id }}" data-status="2">Not Attending</a>
                                     <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $feed->id }}" data-status="3">Tentative</a>
                                  @endif
                                @endif
                                @endif
                              @endif
                            @endif
                             </div>-->


                             </div>

                         </div>


                         </div>
                       </div>

                     </div>
                  @endif
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
                
                @if( is_member_group($user_id,$feed->group_user_id)>0 && $feed->status=='Active')
                <?php  $stat=1;?>
           <div class="timelineBlock groupblock">
               <div class="time-postedBy">
                 <div class="image-div"> @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                      @endif </div>
                 <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
                 <p>@if($feed->group_type_id==1) Global group @elseif($feed->group_type_id==2) Departmental group @else Activity Group @endif - {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
               </div>
               <div class="postedTime-image">
                <?php if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {?>
               <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/').'/'.$feed->cover_image }}&w=799&h=386&q=100" alt=""/>
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

                $comm_share_permission_actv_grp = $userdetails->can('comment-share-activity-group'); 
                $comm_share_permission_global_grp = $userdetails->can('comment-share-global-group');
                $comm_share_permission_dept_grp = $userdetails->can('comment-share-departmental-group'); 

                $like_permission_global_group =$userdetails->can('like-global-group');
                $like_permission_departmental_group =$userdetails->can('like-departmental-group');
                $like_permission_activity_group =$userdetails->can('like-activity-group');
                $feed = $feedrecord->post;

                @endphp
                @if(count($feed) && $feed->group_id!=0)    
                <?php 
                 
                
          
                $group_id = base64_encode($feed->group_id+ 100);
                $group_type = group_type($feed->group_id);  
                if($group_type==1) { $permission_share = $comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}

                if($group_type==1) { $permission_like =$like_permission_global_group;} elseif($group_type==2){ $permission_like = $like_permission_departmental_group;} elseif($group_type==3){ $permission_like = $like_permission_activity_group;}
                ?>         
                @if( is_member_group($userdetails->id,$feed->group_id)>0)
                <?php $stat=1;?>
             <div class="timelineBlock">
               <div class="time-postedBy">
                 <div class="image-div">
                   @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                      @endif  
                 </div>
                 <h2><a href="{{URL::Route('user_profile').'/'.($feed->user->ad_username)}}">{{ $feed->user->display_name }}</a></h2>
                 <p>{{$feed->location}} @if($feed->location!='') - @endif {{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
               </div>
               <div class="postedTime-image">
                 
                 @if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image)))
                    <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/post_images/'.$feed->image) }}&w=799&h=386&q=100" alt=""/>
                    @if($feed->text!='')
                    <p>&nbsp;</p>
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
                   
                      @if($permission_like==1)
                      @if(is_liked_post(\Auth::guard('user')->user()->id,$feed->id)==1)


                      <?php $cls = 'active_lk'; ?>
                      @else
                       <?php $cls = ''; ?>
                      @endif
                     <!-- <button class="face-like" type="button" name="button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>-->
                     <button class="face-like {{$cls}}"  type="button" id="lkid_{{$feed->id}}" alt="{{$feed->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
                     @endif
                   </div>
                   <div class="col-sm-12 col-md-6 col-lg-8">
                     <p><a  class='cntlikecls' href="{{URL::Route('likelist').'/'.$feed->id.'/'.$group_id}}"><span id="likecnt_id_{{$feed->id}}" class="likecls">{{count($feed->likes)}} Likes </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$feed->id}}" id="cmncnt_id_{{$feed->id}}">{{count($feed->comments)}} Comments</a></p>
                     <input type="hidden" value="{{count($feed->comments)}}" id="cmntid_{{$feed->id}}" />
                     <input type="hidden" value="{{count($feed->likes)}}" id="likeid_{{$feed->id}}" />
                   </div>
                 </div>
               </div>
               <div class="comment-other" id="comment_2">
                 @if(count($feed->comments))   <?php  $i = 0; ?>           
                 @foreach($feed->comments as $comment) <?php $i ++; ?>

                 @if($i==1 && count($feed->comments)>1)<div id="comment_{{$feed->id}}" style="display:none;">@endif
                   <div class="comment-other-single">
                     <div class="image-div">
                      @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
                            <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
                          @else
                          <img src="{{ asset('uploads/no_img.png') }}" alt="">
                      @endif     </div>
                     <h2><a href="{{URL::Route('user_profile').'/'.($comment->user->ad_username)}}">{{ $comment->user->display_name }}</a> <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}</span></h2>
                     <p>{{$comment->body}}</p>
                   </div>
                    @if($i==(count($feed->comments)-1)) </div> @endif
                  @endforeach                
                 @endif
                <div id="commentsnwid_{{$feed->id}}">
                </div> 

               </div>
               <!-- for later -->
                @if($permission_share==1 ) 
               <div class="comment-field">
                 <div class="image-div">
                  @if($userdetails->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $userdetails->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$userdetails->profile_photo) }}" alt=""/>
                   @else
                    <img src="{{ asset('uploads/no_img.png') }}" alt=""/>
                  @endif
                 </div>
                 <textarea id="commentid_{{$feed->id}}" alt="{{$feed->id}}" class="cmntcls" name="comment_text" placeholder="Press Enter to post comment"></textarea>
               </div>
               @endif
                <!-- for later -->
             </div>   
                @endif      
              <!-- ------------ post with image - -- -->
                @endif
               @endif

            @endforeach
            @else
             <div class="timelineBlock">
              <div class="no_envent_message">
                  <div class="first_line">No feed for now</div>
                 
              </div>
            </div>
            @endif
           @if($stat==0)
           <div class="timelineBlock">
              <div class="no_envent_message">
                  <div class="first_line">No feed for now</div>
                 
              </div>
            </div>
           @endif

           

         </div>

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
   @endsection

   @section('script')
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
            $("#likecnt_id_"+post_id).html(like_cnt+' Likes ')  ;
            $("#likeid_"+post_id).val(like_cnt)   ;  
          }else {
            $("#lkid_"+post_id).removeClass("active_lk");
            var like_cnt = $("#likeid_"+post_id).val(); 
            like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
            $("#likecnt_id_"+post_id).html(like_cnt+' Likes ')  ;
            $("#likeid_"+post_id).val(like_cnt)   ; 
          }                
         
          });
          request.fail(function(jqXHR, textStatus) {
            console.log( "Request failed: " + textStatus );
          });
      });
    });
    </script>
    
   @endsection
<style>
  .active_lk{
    background: #2ec4e7;
    border: 1px solid #109fc0;
    color: #FFF;
} 
	.notification-div{
		margin-top:9px!important;
	}
</style>