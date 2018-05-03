@extends('front.layout.event_app')
@section('title','Tawasul')
@section('content')



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

      $delete_permission_global_event =Auth::user()->can('delete-global-event');
      $delete_permission_departmental_event =Auth::user()->can('delete-departmental-event');
      $delete_permission_activity_event =Auth::user()->can('delete-activity-event');

      if($event_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($event_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($event_type==3){ $permission_share = $comm_share_permission_actv_grp;}

      if($event_type==1) { $permission_like =$like_permission_global_event;} elseif($event_type==2){ $permission_like = $like_permission_departmental_event;} elseif($event_type==3){ $permission_like = $like_permission_activity_event;}

      if($event_type==1) { $permission_delete =$delete_permission_global_event;} elseif($event_type==2){ $permission_delete = $delete_permission_departmental_event;} elseif($event_type==3){ $permission_delete = $delete_permission_activity_event;}

      if($event_type==1) { $permission_post =$post_permission_global_event;} elseif($event_type==2){ $permission_post = $post_permission_departmental_event;} elseif($event_type==3){ $permission_post = $post_permission_activity_event;}
?>


<div class="home-container">
     <div class="container">

       @include('front.includes.event_sidebar')

       <div class="timeline-photo eve-top rounded-ban">
         @if(isset($record->eventImage[0]->image_name) && file_exists(public_path('uploads/event_images/original/'.$record->eventImage[0]->image_name)))
            
            <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/original/'.$record->eventImage[0]->image_name) }}&w=1250&h=300&q=100" alt="img" />
          @else
          <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}" alt="">
          @endif


         <div class="fixme">

         <div class="timeline-cont">
           <div class="row">
             <div class="col-sm-12">
               <div class="timeline-profile event-date">
                 <div class="image-div"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                 <h2>{{ \Carbon\Carbon::parse($record->event_start_date)->format('dS') }}</h2>
                 <p>{{ \Carbon\Carbon::parse($record->event_start_date)->format('F') }}</p>
               </div>

               <div class="evetitle"><p>{{ $record->name }}</p></div>
             </div>

           </div>
         </div>

         </div>

       </div>


       <div class="timeline-nav clearfix eventtitle1 border-time">
         <h3>Public, Hosted by <span>{{ $record->user->display_name }}</span></h3>
         <div class="pull-right">
         <!-- <a href="#" class="go">Attending</a>
         <a href="#" class="not_go">Not Attending</a>
         <a href="#" class="not_go">Tentative</a> -->

         @if($record->event_start_date <= $today)
              
                  @if($record->getStatus($record->id) == 1)
                      <div class="attend_status_button">Attended</div>
                  @elseif($record->getStatus($record->id) == 2)
                      <div class="attend_status_button"> Not Attended</div>
                  @elseif($record->getStatus($record->id) == 3)
                      <div class="attend_status_button">Tentetive</div>
                  @elseif($record->getStatus($record->id) == 4)
                      <div class="attend_status_button"> Interested</div>
                  @elseif($record->getStatus($record->id) == 4)
                      <div class="attend_status_button">Not Interested</div>
                  @elseif($record->getStatus($record->id) == 6)
                      <div class="attend_status_button">Cancelled</div>
                  @endif
              
        @else
          @if($logged_in_user != $record->user_id)
            @if($record->event_end_date > $today)
              @if($isInvited > 0)
                @if($record->getStatus($record->id) == 1 || $record->getStatus($record->id) == 4)
                      <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "'+eventId+'" data-status="6">Cancel</a>
                  @elseif($record->getStatus($record->id) == 2 || $record->getStatus($record->id) == 5 || $record->getStatus($record->id) == 6)
                      <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "'+eventId+'" data-status="1">Attend</a>
                  @elseif($record->getStatus($record->id) == 3)
                    <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "'+eventId+'" data-status="4">Interested</a>
                    <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "'+eventId+'" data-status="5">Not Interested</a>
                  @else
                   <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "{{ $record->id }}" data-status="1">Attending</a>
                   <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $record->id }}" data-status="2">Not Attending</a>
                   <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $record->id }}" data-status="3">Tentative</a>
                @endif
              @endif
            @endif
          @endif
        @endif

         </div>
       </div>


       <div class="row">

         <div class="col-sm-8">

         <div class="eve-map">
         <h5 class="cal"><i class="fa fa-calendar-check-o"></i>{{ \Carbon\Carbon::parse($record->event_start_date)->format('dS M Y') }} @if($record->event_end_date > $record->event_start_date) - {{ \Carbon\Carbon::parse($record->event_end_date)->format('dS M Y') }} @endif @ @if($record->allday_event =='Yes') {{ trans('eventDetails.all_day') }} @else {{ $record->start_time }} - {{ $record->end_time }} @endif</h5>
         
         @if($record->location!='')
           <h5 class="location"><i class="fa fa-map-marker"></i>{{ $record->location }}</h5>           
           <div class="map-sec" id="map_canvas" style="height: 192px;">
           </div>
         @endif
         <div class="get_directionSection">
         <input id="origin-input" class="controls" type="text"
        placeholder="Enter your location" onFocus="geolocate()">
         <a href="javascript:void(0);" id="getDirection" class="fileContainer" style="float:left;">Get direction</a>
         <div id="directions-panel" style="display: none;"></div>
         </div>

         </div>
         @if($permission_post == 1)

         {{ Form::open(array('route' => ['event_post_create'],'id'=>'PostFrm', 'files' => true)) }}
         
           <div class="post-timeline">
             <textarea placeholder="What's in your mind today?" id="post_text" name="post_text"></textarea>
             <div id="targetLayer"></div>
             <div id="locationid"></div>
             <input type="hidden" name="location" id="locationtxtid">         
             <input type="hidden" name="event_id" value="{{ $record->id }}">
             <div class="post-bar">
               <div class="row">
                 <div class="col-sm-6">
                   <ul class="nav-varient">
                     <li><a href="javascript:void(0);" id="find_btn"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                     <li><a href="javascript:void(0);" class="con-choose-image"><input name="post_image" id="postimgid" type="file" class="inputFile" onChange="showPreview(this);" /></a>
                     </li>
                   </ul>
                 </div>
                 <div class="col-sm-6">
                   <div class="pull-right">
                     <input type="submit" id="event_post" data-EventId = "{{ $record->id }}" name="event_post" value="Post">
                   </div>
                 </div>
               </div>
             </div>
           </div>

           {{ Form::close() }}
           @endif

           <div class="timeline-blockMain" id="timeline_post">
              @if(count($post_record)>0) 
                @foreach($post_record as $post)

                    <div class="timelineBlock">
                         <div class="time-postedBy">
                           <div class="image-div">
                             
                             @if($post->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $post->user->profile_photo)))
                                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$post->user->profile_photo) }}" alt=""/>
                                      @else
                                      <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt="">
                                  @endif 
                           </div>
                           <h2>{{ $post->user->display_name }}</h2>
                           <p>{{$post->location}} - {{date('F d, Y',strtotime($post->created_at))}}</p>
                         </div>
                         <div class="postedTime-image">
                              <?php if(file_exists( public_path('uploads/posts/thumbnails/'.$post->image) )&& ($post->image!='' || $post->profile_photo!=NULL)) {?>
                             <img src="{{ asset('uploads/posts/thumbnails/').'/'.$post->image }}"/>
                             <?php }?>               
                               <h2>{{$post->text}}</h2>
                               <input type="hidden" value="{{$post->id}}" class="piscls" alt="{{$post->id}}" id="pid_{{$post->id}}" />
                          </div>
                         <!-- <div class="postedTime-image">
                           <h2>{!! $post->text !!}</h2>
                         </div> -->
                         @if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1)
                    <?php $cls = 'active'; ?>
                    @else
                     <?php $cls = ''; ?>
                    @endif
                         <div class="likeComment">
                           <div class="row">
                             <div class="col-sm-5">
                             @if($permission_like == 1)
                               <button class="face-like {{$cls}}"  type="button" id="lkid_{{$post->id}}" alt="{{$post->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
                             @endif
                             </div>
                             <div class="col-sm-7">
                     <p><span id="likecnt_id_{{$post->id}}" class="likecls">{{count($post->likes)}} Likes </span>- <a href="javascript:void(0);" class="user-com" data-target="{{$post->id}}" id="cmncnt_id_{{$post->id}}">{{count($post->comments)}} Comments</a></p>
                     <input type="hidden" value="{{count($post->comments)}}" id="cmntid_{{$post->id}}" />
                     <input type="hidden" value="{{count($post->likes)}}" id="likeid_{{$post->id}}" />
                   </div>
                           </div>
                         </div>
                         <div class="comment-other">
                         @if(count($post->comments)) <?php  $i = 0; ?>  
                         @foreach($post->comments as $comment) <?php $i ++; ?>
                           
                           @if($i==2) <div id="comment_{{$post->id}}" style="display:none;"> @endif
                             <div class="comment-other-single">
                               <div class="image-div">
                                  @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
                                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
                                      @else
                                      <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt="">
                                  @endif 
                               </div>
                               <h2>{{ $comment->user->display_name }} <span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}</span></h2>
                               <p>{{$comment->body}}</p>
                             </div>
                             @if($i==count($post->comments) && $i>=2) </div> @endif
                           
                         @endforeach
                         @endif
                         </div>
                         <!-- <div class="comment-field">
                           <div class="image-div"><img src="images/avatar-male.jpg" alt=""></div>
                           <textarea name="name" placeholder="Press Enter to post comment"></textarea>
                         </div>
                        </div> -->


                        <div id="commentsnwid_{{$post->id}}">
                        </div> 
                         <div class="comment-field">
                           <div class="image-div">
                           @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
                                  <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
                                @else
                                <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                                @endif                      
                            </div> 
                            @if($permission_share == 1)               
                            <textarea data-post_id="{{$post->id}}" class="cmntcls" name="comment_text" placeholder="Press Enter to post comment"></textarea>  
                            @endif               
                         </div>
                       
                       </div>  



                @endforeach
              @endif 
             

           </div>

         </div>


         <div class="col-sm-4">
           <div class="right-sidebar clearfix">

             <div class="recentUpdates alt">
              <h2 class="white-bg">Description</h2>
              <div class="cont-wrap">                
                {!! $record->description !!}
              </div>
             </div>

             <div class="recentUpdates alt event-side">
              <h2 class="white-bg">
              <span>{{ $attend_user_count }} 
              @if($attend_user_count == 1)
                people is 
              @else
                peoples are 
              @endif
              going
              </span>    
              @if($logged_in_user == $record->user_id)
              <a data-toggle="modal" data-target="#uploadphoto" class="go" href="#">Invite <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
              @endif
              </h2>

              <div class="clearfix"></div>

               <div id="scrollbar1" class="custom-scroll">
            	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
            	<div class="viewport">
              <div class="overview">

              	 <ul class="eve-list eve-list2">

                 @if(count($event_attend)>0)
                   @foreach($event_attend as $attand)
                  	<li>
                        <span class="eve-img">
                          @if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo) }}" alt=""/>
                  @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                  @endif

                        </span>
                        <div class="eve-txt">
                        <h3>{{ $attand->user->display_name }}</h3>
                        <p>{{ $attand->user->title }}</p>
                        </div>
                        
                        <div class="iconic attending">
                          <abbr rel="tooltip" title="Attending"><i class="fa fa-check" aria-hidden="true"></i></abbr>
                        </div>                       
                    </li>
                   @endforeach
                 @endif


                 @if(count($event_tentetive)>0)
                   @foreach($event_tentetive as $attand)
                    <li>
                        <span class="eve-img">
                          @if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo) }}" alt=""/>
                  @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                  @endif

                        </span>
                        <div class="eve-txt">
                        <h3>{{ $attand->user->display_name }}</h3>
                        <p>{{ $attand->user->title }}</p>
                        </div>
                          <div class="iconic tentative">
                              <abbr rel="tooltip" title="Tentative"><i class="fa fa-calendar" aria-hidden="true"></i></abbr>
                          </div>                        

                    </li>
                   @endforeach
                 @endif


                 @if(count($event_pending)>0)
                   @foreach($event_pending as $attand)
                    <li>
                        <span class="eve-img">
                          @if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo) }}" alt=""/>
                  @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                  @endif

                        </span>
                        <div class="eve-txt">
                        <h3>{{ $attand->user->display_name }}</h3>
                        <p>{{ $attand->user->title }}</p>
                        </div>
                             <div class="iconic pending">
                          <abbr title="Pending" rel="tooltip"><i class="fa fa-clock-o" aria-hidden="true"></i></abbr>
                        </div> 

                        <div class="nav-func">
                          <ul>
                            <li><a href="javascript:void(0);" class="remove_invite" data-id="{{ $attand->id }}"><i class="fa fa-ban" aria-hidden="true"></i></a></li>
                          </ul>
                         </div>             

                    </li>
                   @endforeach
                 @endif

                 @if(count($event_cancel)>0)
                   @foreach($event_cancel as $attand)
                    <li>
                        <span class="eve-img">
                          @if($attand->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $attand->user->profile_photo)))
                    <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$attand->user->profile_photo) }}" alt=""/>
                  @else
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/>
                  @endif

                        </span>
                        <div class="eve-txt">
                        <h3>{{ $attand->user->display_name }}</h3>
                        <p>{{ $attand->user->title }}</p>
                        </div>

                        <div class="iconic not-attending">
                                <abbr rel="tooltip" title="Not Attending"><i class="fa fa-times" aria-hidden="true"></i></abbr>
                        </div>                  



                        
                    </li>
                   @endforeach
                 @endif
                  

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
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content alt">
      <div class="modal-body friend-list">
        <button type="button" class="close alt" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
        <div class="row">
          <div class="col-sm-12">
          <div id="succMsg"></div>
            <div class="searchSt forSearch">
                   <input type="text" id="searchUser" name="" value="" placeholder="Search..." aria-controls="userTable">
            </div>
            <div class="table-responsive user-table">
              <table class="table userTable table-fixed" id="userTable">
                <thead>
                  <tr>
                    <th width="5%">&nbsp;</th>
                    <th width="25%">User</th>
                    <th width="15%">Department</th>
                    <th width="15%">Phone</th>
                    <th width="25%">Email</th>
                    <th width="15%">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                @if(count($user_list))
                  @foreach($user_list as $user)
                  <tr>
                    <td valign="middle" width="5%"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" class="inviteChk" value="1" data-userId = "{{ $user->id }}">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle" width="25%">
                    @if($user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $user->profile_photo)))
                      <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$user->profile_photo) }}" alt=""/>
                    @else
                      <img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt="">
                    @endif
                      <h3>{{ $user->display_name }} <span>{{ $user->title }}</span></h3></td>
                    <td valign="middle" width="15%">{{ $user->department->name }}</td>
                    <td valign="middle" width="15%">{{ $user->mobile }}</td>
                    <td valign="middle" width="25%">{{ $user->email}}</td>
                    <td valign="middle" width="15%"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  @endforeach
                @endif
                  
                </tbody>
              </table>
              <div class="fileContainer">
              <input type="submit" value="Confirm" id="inviteSubmit" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <div style="display: none;">
        
     <input id="destination-input" class="controls" type="text"
        placeholder="Enter a destination location" value="{{ $record->location }}">

    <input type="hidden" name="waypoints" id="waypoints">

        
  </div>
  @endsection

  @section('script')

<!--------------------------------------------- Invite User Search  -------------------------------->

<script src="{{ asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">

  var table = $('#userTable').DataTable({
                  "paging":   false,
                  "ordering": false,
                  "info":     false,
                });
// #myInput is a <input type="text"> element
    $('#searchUser').on( 'keyup', function () {
        table.search( this.value ).draw();
    } );
</script>
<style type="text/css">
  .dataTables_filter {
    display: none; 
}
</style>

<!------------------------------------------ Invite User Search  -------------------------------->


  <script type="text/javascript" src="{{ asset('frontend/js/jquery.tinyscrollbar.min.js') }}"></script>
  <script type="text/javascript">
      $(document).ready(function()
      {

          $('.user-com').click(function () {
                  var index = $(this).data("target");
                 
                  jQuery('#comment_'+index).slideToggle("slow");
          });

          var $scrollbar = $("#scrollbar1");
          $scrollbar.tinyscrollbar();
          
          $('.remove_invite').click(function(){
            var ths = $(this);
            var id = ths.attr('data-id');

            $.confirm({
              title: 'Confirm',
              content: 'Are you sure to cancel invite',
              buttons: {
                  confirm: function () {
                      $.ajax({
                        'type': 'post',
                        'data': {id:id},
                        'url' : BASE_URL+'/cancel-invite',
                        'success': function(){
                             ths.parent().parent().parent().parent().remove(); 
                        }
                      });
                  },
                  cancel: function () {
                      
                  }
              }
          });

           
          });


          //$('#event_post').click(function(){
          $("#PostFrm").on('submit',(function(e){
              e.preventDefault();  
                var post_text = $('#post_text'). val();
                var eventId = $(this).attr('data-EventId'); 

                $.ajax({
                'type'  : 'post',
                //'data'  : {post_text:post_text,event_id:eventId},
                'data'  : new FormData(this),
                'url'   : BASE_URL+'/event-post',
                contentType: false,
                cache: false,
                processData:false,
                'success': function(msg){  
                    $('#post_text'). val('');
                    $('#timeline_post').prepend(msg);
                    $("#targetLayer").html('');
                    $("#postimgid").val('');


                    $(".cmntcls").keypress(function(event) {
                        if (event.which == 13) {
                            event.preventDefault();
                            var ths = $(this);
                            var post_id      = $( this ).attr( "data-post_id" );
                            var comment_text = $(this).val();
                            

                            request = $.ajax({
                                    url: "{{URL::Route('saveeventcomment')}}",
                                    type: "POST",
                                   beforeSend:function() { 
                                    
                                     //$("#commentid_"+post_id).html("<img src='{{ asset('frontend/images/Spin.gif') }}'>");
                                 },
                                    data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},
                                    
                                  });

                                  request.done(function(msg) {
                                   var html = $("#commentsnwid_"+post_id).html();
                                    html = $("#commentsnwid_"+post_id).html(html+''+msg);
                                    ths.val('');

                                  var cmnt_cnt = $("#cmntid_"+post_id).val();                        
                                  cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));
                                   
                                  $("#cmncnt_id_"+post_id).html(cmnt_cnt+' Comments')  ;  
                                  $("#cmntid_"+post_id).val(cmnt_cnt)   ;            

                                  });

                                  request.fail(function(jqXHR, textStatus) {
                                    alert( "Request failed: " + textStatus );
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
                            $( "#lkid_"+post_id ).addClass( "active" );
                            var like_cnt = $("#likeid_"+post_id).val(); 
                            like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
                            $("#likecnt_id_"+post_id).html(like_cnt+' likes ')  ;
                            $("#likeid_"+post_id).val(like_cnt)   ;  
                          }else {
                            $("#lkid_"+post_id).removeClass("active");
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

                }
              });
          }));

          $('#inviteSubmit').click(function(){
            var userID = [];
            var eventId = '{{ $record->id }}';
            $('.inviteChk').each(function(){                
                if($(this).is(':checked'))
                    userID.push($(this).attr('data-userId'));
            });

            $.ajax({
                'type'  : 'post',
                'data'  : {userId:userID,event_id:eventId},                
                'url'   : BASE_URL+'/event-invite',                
                'success': function(msg){ 
                    $('.inviteChk').each(function(){                
                        if($(this).is(':checked'))
                            table.row( $(this).parents('tr') ).remove().draw();
                    });
                    $('#succMsg').html('Invite sent successfully');
                    
                }
              });
          });

      });
  </script>


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
                      var address = '{{ $record->location }}';
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
            /** @type {!HTMLInputElement} */(document.getElementById('origin-input')),
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
            window.alert('Directions request failed due to ' + status);
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

  $('#getDirection').click(function(){


  });

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      // function initMap() {

      //          var geocoder;
      //         var map;

      //         geocoder = new google.maps.Geocoder();
      //         //var latlng = new google.maps.LatLng(-34.397, 150.644);
      //         var myOptions = {
      //           zoom: 14,
      //          // center: latlng,
      //           mapTypeId: google.maps.MapTypeId.ROADMAP
      //         }
      //         map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
      //                 // var city_state_zip = document.getElementById("city_state_zip").innerHTML;
      //                 // var street_address = document.getElementById("street_address").innerHTML;
      //                 // var address = street_address + " " + city_state_zip;//document.getElementById(street_addres +" "+ city_state_zip).value;
      //                 var address = '{{ $record->location }}';
      //                 geocoder.geocode( { 'address': address}, function(results, status) {
      //                   if (status == google.maps.GeocoderStatus.OK) {
      //                     map.setCenter(results[0].geometry.location);
      //                     var marker = new google.maps.Marker({
      //                         map: map,
      //                         position: results[0].geometry.location
      //                     });
      //                   } else {
      //                     alert("Geocode was not successful for the following reason: " + status);
      //                   }
      //                 });
 


      //   // var map = new google.maps.Map(document.getElementById('map_canvas'), {
      //   //   mapTypeControl: false,
      //   //   center: {lat: -33.8688, lng: 151.2195},
      //   //   zoom: 13
      //   // });

      //   new AutocompleteDirectionsHandler(map);
      // }

      //  /**
      //   * @constructor
      //  */
      // function AutocompleteDirectionsHandler(map) {
      //   this.map = map;
      //   this.originPlaceId = null;
      //   this.destinationPlaceId = null;
      //   this.travelMode = 'WALKING';
      //   var originInput = document.getElementById('origin-input');
      //   var destinationInput = document.getElementById('destination-input');
      //   var modeSelector = document.getElementById('mode-selector');
      //   this.directionsService = new google.maps.DirectionsService;
      //   this.directionsDisplay = new google.maps.DirectionsRenderer;
      //   this.directionsDisplay.setMap(map);

      //   var originAutocomplete = new google.maps.places.Autocomplete(
      //       originInput, {placeIdOnly: true});
      //   var destinationAutocomplete = new google.maps.places.Autocomplete(
      //       destinationInput, {placeIdOnly: true});

      //   this.setupClickListener('changemode-walking', 'WALKING');
      //   this.setupClickListener('changemode-transit', 'TRANSIT');
      //   this.setupClickListener('changemode-driving', 'DRIVING');

      //   this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
      //   this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

      //   this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
      //   this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
      //   this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
      // }

      // // Sets a listener on a radio button to change the filter type on Places
      // // Autocomplete.
      // AutocompleteDirectionsHandler.prototype.setupClickListener = function(id, mode) {
      //   var radioButton = document.getElementById(id);
      //   var me = this;
      //   radioButton.addEventListener('click', function() {
      //     me.travelMode = mode;
      //     me.route();
      //   });
      // };

      // AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
      //   var me = this;
      //   autocomplete.bindTo('bounds', this.map);
      //   autocomplete.addListener('place_changed', function() {
      //     var place = autocomplete.getPlace();
      //     if (!place.place_id) {
      //       window.alert("Please select an option from the dropdown list.");
      //       return;
      //     }
      //     if (mode === 'ORIG') {
      //       me.originPlaceId = place.place_id;
      //     } else {
      //       me.destinationPlaceId = place.place_id;
      //     }
      //     me.route();
      //   });

      // };

      // AutocompleteDirectionsHandler.prototype.route = function() {
      //   if (!this.originPlaceId || !this.destinationPlaceId) {
      //     return;
      //   }
      //   var me = this;

      //   this.directionsService.route({
      //     origin: {'placeId': this.originPlaceId},
      //     destination: {'placeId': this.destinationPlaceId},
      //     travelMode: this.travelMode
      //   }, function(response, status) {
      //     if (status === 'OK') {
      //       me.directionsDisplay.setDirections(response);
      //     } else {
      //       window.alert('Directions request failed due to ' + status);
      //     }
      //   });
      // };

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0fOLbrmMSe-Des6pZctGqFyrM3kLbGsY&libraries=places&callback=initMap"
        async defer></script>


  @if($record->location!='')
  <!-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD0fOLbrmMSe-Des6pZctGqFyrM3kLbGsY"></script> -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmMV_lNLPzh5q5K2CcD7JxCtmYs3wICmQ"></script> -->
  <script>
      // var geocoder;
      // var map;
      // function codeAddress() { 
      // geocoder = new google.maps.Geocoder();
      // //var latlng = new google.maps.LatLng(-34.397, 150.644);
      // var myOptions = {
      //   zoom: 14,
      //  // center: latlng,
      //   mapTypeId: google.maps.MapTypeId.ROADMAP
      // }
      // map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
      //         // var city_state_zip = document.getElementById("city_state_zip").innerHTML;
      //         // var street_address = document.getElementById("street_address").innerHTML;
      //         // var address = street_address + " " + city_state_zip;//document.getElementById(street_addres +" "+ city_state_zip).value;
      //         var address = '{{ $record->location }}';
      //         geocoder.geocode( { 'address': address}, function(results, status) {
      //           if (status == google.maps.GeocoderStatus.OK) {
      //             map.setCenter(results[0].geometry.location);
      //             var marker = new google.maps.Marker({
      //                 map: map,
      //                 position: results[0].geometry.location
      //             });
      //           } else {
      //             alert("Geocode was not successful for the following reason: " + status);
      //           }
      //         });
      //       }



      // window.onload = function(){
      //         codeAddress();
      //    }
</script>
@endif
  <script>
     $(".cmntcls").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                var ths = $(this);
                var post_id      = $( this ).attr( "data-post_id" );
                var comment_text = $(this).val();
                

                request = $.ajax({
                        url: "{{URL::Route('saveeventcomment')}}",
                        type: "POST",
                       beforeSend:function() { 
                        
                         //$("#commentid_"+post_id).html("<img src='{{ asset('frontend/images/Spin.gif') }}'>");
                     },
                        data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},
                        
                      });

                      request.done(function(msg) {
                       var html = $("#commentsnwid_"+post_id).html();
                        html = $("#commentsnwid_"+post_id).html(html+''+msg);
                        ths.val('');

                      var cmnt_cnt = $("#cmntid_"+post_id).val();                        
                      cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));
                       
                      $("#cmncnt_id_"+post_id).html(cmnt_cnt+' Comments')  ;  
                      $("#cmntid_"+post_id).val(cmnt_cnt)   ;            

                      });

                      request.fail(function(jqXHR, textStatus) {
                        alert( "Request failed: " + textStatus );
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
                  $( "#lkid_"+post_id ).addClass( "active" );
                  var like_cnt = $("#likeid_"+post_id).val(); 
                  like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
                  $("#likecnt_id_"+post_id).html(like_cnt+' likes ')  ;
                  $("#likeid_"+post_id).val(like_cnt)   ;  
                }else {
                  $("#lkid_"+post_id).removeClass("active");
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



  
           $(document).ready(function() {
            $("#find_btn").click(function () { 
              if ("geolocation" in navigator){ //check geolocation available
                    //try to get user current location using getCurrentPosition() method                    
                    navigator.geolocation.getCurrentPosition(function(position){
                      
                       var latitude = position.coords.latitude;
                       var  longitude =position.coords.longitude;
                      
                        request = $.ajax({
                        url: "{{URL::Route('getLocation')}}",
                        type: "POST",
                       beforeSend:function() { 
                        
                         $("#locationid").html("<img src='{{ asset('frontend/images/Spin.gif') }}'>");
                     },
                        data: {'latitude' : latitude,'longitude':longitude,'_token':CSRF_TOKEN},
                        
                      });

                      request.done(function(msg) {
                        $("#locationid").html( '--at '+msg );
                         $("#locationtxtid").val(msg);
                      });

                      request.fail(function(jqXHR, textStatus) {
                        alert( "Request failed: " + textStatus );
                      });
                        });
                }else{
                    console.log("Browser doesn't support geolocation!");
                }
             
            });
          });
           
            

              function showPreview(objFileInput) {
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


  
@endsection