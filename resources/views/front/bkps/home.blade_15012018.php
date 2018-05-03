@extends('front.layout.app')
@section('title','Tawasul')
@section('content')


<div class="home-container">
     <div class="container">
       <div class="row">

         <div class="col-lg-3 col-sm-4">
           <div class="left-sidebar">
             <div class="profile-image-block">
               <div class="profile-image">
               @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
                  @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                  @endif
               </div>
               <h2>{{ \Auth::guard('user')->user()->display_name }}</h2>
               <p>
                 {{ \Auth::guard('user')->user()->designation->name }} <br> 
                {{ \Auth::guard('user')->user()->department->name }}
               </p>
             </div>
             <div class="side-nav">
               <ul>
                 <li class="active"><a href="home.html"><i class="fa fa-user" aria-hidden="true"></i> News feed</a></li>
                 <li><a href="{{ URL::Route('event','month')}}"><i class="fa fa-calendar" aria-hidden="true"></i> Events</a></li>
                 <li><a href="user-directory2.html"><i class="fa fa-handshake-o" aria-hidden="true"></i> Employee Directory</a></li>
                 <li><a href="{{ URL::Route('group')}}"><i class="fa fa-users" aria-hidden="true"></i> Groups</a></li>
                 <li><a href="occasions.html"><i class="fa fa-sign-language" aria-hidden="true"></i> Occasions</a></li>
               </ul>
             </div>
           </div>
         </div>

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
                          <img src="{{ asset('images/no-image-event-home.jpg') }}" alt="">
                         @endif
                       </div>

                       <div class="likeComment learn">
                       <div class="row">
                           <div class="col-sm-12">

                             <div class="eve-area">
                             <div class="dates"><span>Jan</span> 26</div>
                             <div class="eve-right">
                             <h3><a href="event-details.html">{{ $feed->name }}</a></h3>
                             <h5 class="location"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ \Carbon\Carbon::parse($feed->event_start_date)->format('dS M Y') }} @ @if($feed->allday_event =='Yes') {{ trans('home.all_day') }} @else {{ $feed->start_time }} - {{ $feed->end_time }} @endif</h5>
                             @if($feed->location!='')
                             <h5 class="location"><i class="fa fa-map-marker"></i>{{ $feed->location }}</h5>
                             @endif
                             </div>

                             <div class="btn-right">
                               <a href="#" class="go">Attending</a>
                               <a href="#" class="not_go">Not Attending</a>
                               <a href="#" class="not_go">Tentative</a>
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
                
                @if( is_member_group(\Auth::guard('user')->user()->id,$feed->group_user_id)>0)
           <div class="timelineBlock groupblock">
               <div class="time-postedBy">
                 <div class="image-div"> @if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png')}}" alt="">
                      @endif </div>
                 <h2>{{ $feed->user->display_name }}</h2>
                 <p>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $feed->created_at)->format('dS M Y h:i A') }}</p>
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

        <div class="col-lg-3 col-sm-3">
          <div class="right-sidebar clearfix">
            <div class="recentUpdates">
             <h2>Recent Updates</h2>
             <div class="cont-wrap">
               <div class="cont-wrap-main">
                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/avatar-male.jpg') }}" alt=""></div>
                   <h3><a href="#">Jeesmon Steaphen</a> requested on <a href="#">IT help desk</a>. 5 min ago </h3>
                 </div>
                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/avatar-male.jpg') }}" alt=""></div>
                   <h3><a href="#">Jeesmon Steaphen</a> requested on <a href="#">IT help desk</a>. 5 min ago </h3>
                 </div>
                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/avatar-male.jpg') }}" alt=""></div>
                   <h3><a href="#">Jeesmon Steaphen</a> requested on <a href="#">IT help desk</a>. 5 min ago </h3>
                 </div>
                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/avatar-male.jpg') }}" alt=""></div>
                   <h3><a href="#">Jeesmon Steaphen</a> requested on <a href="#">IT help desk</a>. 5 min ago </h3>
                 </div>
               </div>
             </div>
             <div class="btn_view"><a href="#" class="view_all"><i class="fa fa-eye"></i> View All</a></div>
            </div>
            <div class="recentUpdates group">
             <h2>My Groups</h2>
             <div class="cont-wrap">
               <div class="cont-wrap-main">
                @if(count($mygroups)>0)
                @foreach($mygroups as $mygroup)
                 <div class="recent-block">
                  <?php           
                  $group_id = base64_encode($mygroup->group_user_id+ 100);
                  ?>
                   <div class="image-div"><a href="{{URL::Route('group_details').'/'.$group_id}}">
                    <?php if(file_exists( public_path('uploads/group_images/'.$mygroup->cover_image) )&& ($mygroup->cover_image!='' || $mygroup->cover_image!=NULL)) {?>
                     <img src="{{ asset('uploads/group_images/').'/'.$mygroup->cover_image }}" alt="" />
                     <?php }else{ ?>
                      <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}" />
                    <?php  } ?>
                        
                   </a></div>
                   <h4>{{$mygroup->group_name}}</h4>
                 </div>
                 @endforeach
                 @endif
               </div>

              </div>
              <div class="btn_view"><a href="{{ URL::Route('group')}}" class="view_all"><i class="fa fa-eye"></i> View All</a></div>

            </div>


            <div class="recentUpdates group occasion" id="rsidebar">
             <h2>Occasions</h2>
             <div class="cont-wrap">
               <div class="cont-wrap-main">

                 <div id="scrollbar1" class="custom-scroll">
               <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
               <div class="viewport">
                   <div class="overview">

                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/friend-1.jpg') }}" alt=""></div>
                   <h4>Mahendra Kakumanu <br> <span>IT Manager</span></h4>
                   <p>Having Birthday</p>
                   <div class="emailPop"><a href="#" data-toggle="modal" data-target="#occasions"><img src="{{ asset('frontend/images/b-1.png') }}" alt=""></a></div>
                 </div>
                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/friend-3.jpg') }}" alt=""></div>
                   <h4>Mahendra Kakumanu <br> <span>IT Manager</span></h4>
                   <p>completed 2 years</p>
                   <div class="emailPop spop"><a href="#" data-toggle="modal" data-target="#occasionsII"><img src="{{ asset('frontend/images/b-2.png') }}" alt=""></a></div>
                 </div>
                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/friend-4.jpg') }}" alt=""></div>
                   <h4>Mahendra Kakumanu <br> <span>IT Manager</span></h4>
                   <p>Having Birthday</p>
                   <div class="emailPop"><a href="#" data-toggle="modal" data-target="#occasions"><img src="{{ asset('frontend/images/b-1.png') }}" alt=""></a></div>
                 </div>

                 <div class="recent-block">
                   <div class="image-div"><img src="{{ asset('frontend/images/friend-5.jpg') }}" alt=""></div>
                   <h4>Mahendra Kakumanu <br> <span>IT Manager</span></h4>
                   <p>Having Birthday</p>
                   <div class="emailPop"><a href="#" data-toggle="modal" data-target="#occasions"><img src="{{ asset('frontend/images/b-1.png') }}" alt=""></a></div>
                 </div>

                 </div>
                 </div>
                 </div>

               </div>

              </div>
              <div class="btn_view"><a href="occasions.html" class="view_all"><i class="fa fa-eye"></i> View All</a></div>

            </div>


          </div>
        </div>

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
