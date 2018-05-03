@extends('front.layout.group_app')
@section('title','Tawasul')
@section('content')

   <div class="home-container">
     <div class="container">

       @include('front.includes.group_slidemenu')

       <div class="timeline-photo rounded-ban">
         <img src="{{ asset('uploads/group_images/').'/'.$group_details->cover_image}}" alt="">
         <div class="fixme">
         <div class="timeline-cont group-tag">
         <?php //print_r($group_details);$group_details?>
           <h2> {{$group_details->group_name}}</h2>
         </div>
         </div>
       </div>
       <?php 
              $group_type = $group_details->group_type_id;
              $comm_share_permission_actv_grp = Auth::user()->can('comment-share-activity-group'); 
              $comm_share_permission_global_grp = Auth::user()->can('comment-share-global-group');
              $comm_share_permission_dept_grp = Auth::user()->can('comment-share-departmental-group'); 
              $post_permission_global_group =Auth::user()->can('post-global-group');
              $post_permission_departmental_group =Auth::user()->can('post-departmental-group');
              $post_permission_activity_group =Auth::user()->can('post-activity-group');

              $like_permission_global_group =Auth::user()->can('like-global-group');
              $like_permission_departmental_group =Auth::user()->can('like-departmental-group');
              $like_permission_activity_group =Auth::user()->can('like-activity-group');

              if($group_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}

              if($group_type==1) { $permission_like =$like_permission_global_group;} elseif($group_type==2){ $permission_like = $like_permission_departmental_group;} elseif($group_type==3){ $permission_like = $like_permission_activity_group;}
        ?>
       <div class="row">

         <div class="col-sm-8">
         <!----------------  Post add start ------------------- -->
         <?php if($group_type==1) { $permission_post =$post_permission_global_group;} elseif($group_type==2){ $permission_post = $post_permission_departmental_group;} elseif($group_type==3){ $permission_post = $post_permission_activity_group;}?>
           @if($permission_post==1 )
           <div class="post-timeline">            
            {{ Form::open(array('route' => ['post_add'],'id'=>'PostFrm', 'files' => true)) }}
            {{ csrf_field() }}           
             <textarea placeholder="What's in your mind today?" name="post_text" required=""></textarea>
             <div id="locationid">
             
             </div>
             <div id="targetLayer">
             </div>
             <input type="hidden" name="location" id="locationtxtid">
             <div class="post-bar">
               <div class="row">
                 <div class="col-sm-6">
                   <ul class="nav-varient">
                     <li><a href="javascript:void(0);" id="find_btn"><i class="fa fa-map-marker" aria-hidden="true" ></i></a></li>
                     <li><a href="#" class="con-choose-image"><input name="post_image" id="postimgid" type="file" class="inputFile" onChange="showPreview(this);" /> </a></li>
                   </ul>
                 </div>
                 <input type="hidden" name="groupid" value="{{$groupid}}" />
                 <div class="col-sm-6">
                   <div class="pull-right">
                     <input type="submit" name="" value="Post">
                   </div>
                 </div>
               </div>
             </div>
              </form>
           </div>
           @endif
           <!----------------  Post add end------------------- -->
           <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD0fOLbrmMSe-Des6pZctGqFyrM3kLbGsY"></script>
           <script>
           $(document).ready(function() {
            $("#find_btn").click(function () { 
              if ("geolocation" in navigator){ //check geolocation available
                    //try to get user current location using getCurrentPosition() method                    
                    navigator.geolocation.getCurrentPosition(function(position){
                      
                       var latitude = position.coords.latitude;
                       var  longitude =position.coords.longitude;
                      
                        request = $.ajax({
                        url: "{{URL::Route('getAddress')}}",
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
                          $("#targetLayer").html('<a id="removeimgid" href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGlSURBVGhD7dkxSsRAFMbxiNhY6BlEEAsvoSex0UZsxNYD6AWsLEQEXWtvoeghrGy0UAQb/T7YgRDeZmaS9yZTvAe/Jm7C/jGT3WUaHx+fQbME+/AEv/A3sU+4h21IHkZcgXTBqX3BHiQN/xPSRWrxDmsQnWeQLlCTA+gd3lY1rImYS+iddZBOrM0t9I6HFOYhtfGQRX7gGPghJf09xQNcd47FqIccAWcHhsQwYgWW4WV+LIV6CN88Izi5MSGCcwbSaxYxWSNDYsZEkNliz4kZG0FmIZQSoxFBpiHUF6MVQeYhJMVoRlCREGrHbIBmBBULIcZsQphTkF43RNGQ9u3E6a6ZMYqFtCNOoLtmpHNyFAmRFnZ7zWjEmIf0PZ00Y0xDUh6xWjFmISkRgUaMSUhORDA2Rj1kSEQwJkY9hL/s+KMoNyIIMVvwNj+WwuTWehWO5WBMTgSZLfbSPKQ2HlKbaMgqSCfW5gai8wHSyTU5h+jcgXRyTXYhOtwC/gbpAjV4hOThFnDuF7kSGMEHUtZwC/gQuPE4mxCfUBeQvL/u4+PTnab5B0YbTRTOdbJrAAAAAElFTkSuQmCC"/></a><img src="'+e.target.result+'" class="upload-preview" />');
                    $("#targetLayer").css('opacity','0.7');
                    $(".icon-choose-image").css('opacity','0.5');
                      }
                  fileReader.readAsDataURL(objFileInput.files[0]);
                  }
              }


         

           </script>
           <div class="timeline-blockMain">
           @if(count($group_posts)>0)
            @foreach($group_posts as $post)
             <div class="timelineBlock">

               <div class="time-postedBy">
                 <div class="image-div">
                  <?php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$post->profile_photo) )&& ($post->profile_photo!='' || $post->profile_photo!=NULL)) {?>
               <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/').'/'.$post->profile_photo }}"/>
               <?php }else{ ?>
                <img src="{{ asset('uploads/no_img.png') }}"/>
              <?php  } ?>
                 </div>
                 <h2>{{$post->display_name}}</h2>
                 <p>{{$post->location}} - {{date('F d, Y',strtotime($post->created_at))}}</p>
               </div>
               <div class="postedTime-image">
                <?php if(file_exists( public_path('uploads/post_images/'.$post->image) )&& ($post->image!='' || $post->profile_photo!=NULL)) {?>
               <img src="{{ asset('uploads/post_images/').'/'.$post->image }}" style="max-height:270px;"/>
               <?php }?>               
                 <h2>{{$post->text}}</h2>
                 <input type="hidden" value="{{$post->id}}" class="piscls" alt="{{$post->id}}" id="pid_{{$post->id}}" />
               </div>
               <div class="likeComment">
                 <div class="row">
                   <div class="col-sm-5">
                    @if($permission_like==1)
                    @if(is_liked_post(\Auth::guard('user')->user()->id,$post->id)==1)
                    <?php $cls = 'active'; ?>
                    @else
                     <?php $cls = ''; ?>
                    @endif
                     <button class="face-like {{$cls}}"  type="button" id="lkid_{{$post->id}}" alt="{{$post->id}}" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
                    @endif
                   </div>
                   <div class="col-sm-7">
                     <p><span id="likecnt_id_{{$post->id}}" class="likecls">{{count($post->likes)}} Likes </span>- <a href="javascript:void(0);" class="user-com" data-target="1" id="cmncnt_id_{{$post->id}}">{{count($post->comments)}} Comments</a></p>
                     <input type="hidden" value="{{count($post->comments)}}" id="cmntid_{{$post->id}}" />
                     <input type="hidden" value="{{count($post->likes)}}" id="likeid_{{$post->id}}" />
                   </div>
                 </div>
               </div>
               <div class="comment-other">
                @if(count($post->comments))
               
               @foreach($post->comments as $comment)
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

                @endforeach 

               
               @endif
              <div id="commentsnwid_{{$post->id}}">
              </div> 
              </div>
                @if($permission_share==1 ) 
               <div class="comment-field">
                 <div class="image-div">
                 @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
                        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/>
                      @else
                      <img src="{{ asset('uploads/no_img.png') }}" alt=""/>
                      @endif                      
                  </div> 
                                 
                  <textarea id="commentid_{{$post->id}}" alt="{{$post->id}}" class="cmntcls" name="comment_text" placeholder="Press Enter to post comment"></textarea>                 
               </div>
                @endif
             </div>
             @endforeach
             @else
             <div class="timelineBlock">
             No Post
             </div>
            @endif

           </div>

         </div>
         <script type="text/javascript">           
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
           

           $("#targetLayer").click(function () {
            $("#targetLayer").html('');
            $("#postimgid").val('');
            });
         </script>
         
         <div class="col-sm-4">
           <div class="right-sidebar clearfix">
             <div class="recentUpdates alt">
              <h2 class="white-bg">Action</h2>
              <div class="cont-wrap">
               
                @if($permission_share==1 )
                <button class="normbutton" type="button" name="button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>
                @endif
                <button class="normbutton" type="button" name="button"><i class="fa fa-user-times" aria-hidden="true"></i> Leave group</button>
                <button class="normbutton" type="button" name="button"><i class="fa fa-trash" aria-hidden="true"></i> Delete group</button>
              </div>
             </div>
             <div class="recentUpdates alt">
              <h2 class="white-bg">Description</h2>
              <div class="cont-wrap">
                <p>{{$group_details->group_description}}</p>
              </div>
             </div>

             <div class="recentUpdates alt">
              <h2 class="white-bg"><span>Group Members</span>
              <a data-toggle="modal" data-target="#uploadphoto" href="#" class="go pull-right">Invite <i class="fa fa-plus-circle" aria-hidden="true"></i></a>

              </h2>

              <div id="scrollbar1" class="custom-scroll">
             <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
             <div class="viewport">
                <div class="overview">

                <ul class="eve-list">
               @if($group_memebers->count()>0)
               @foreach($group_memebers as $group_memeber)               
               <li>
               <span class="eve-img">
               <?php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$group_memeber->profile_photo) )&& ($group_memeber->profile_photo!='' || $group_memeber->profile_photo!=NULL)) {?>
               <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/').'/'.$group_memeber->profile_photo }}"/>
               <?php }else{ ?>
                <img src="{{ asset('uploads/no_img.png') }}"/>
              <?php  } ?>
               </span>
               <div class="eve-txt">
               <h3>{{$group_memeber->ad_username}}</h3>
               <p>{{$group_memeber->title}}</p>
               </div>
               <div class="nav-func">
                 <ul>
                   <li><a href=""><i class="fa fa-check" aria-hidden="true"></i></a></li>
                   <li><a href=""><i class="fa fa-ban" aria-hidden="true"></i></a></li>
                 </ul>
                </div>
               </li>
               @endforeach
               @else
               <li>
                 No members
               </li>
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
            <div class="searchSt forSearch">
                   <input type="text" name="" value="" placeholder="Search...">
            </div>
            <div class="table-responsive user-table">
              <table class="table">
                <thead>
                  <tr>
                    <th width="6%">&nbsp;</th>
                    <th width="33%">User</th>
                    <th width="15%">Department</th>
                    <th width="15%">Phone</th>
                    <th width="25%">Email</th>
                    <th width="6%"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-3.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-3.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-6.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-3.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-3.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-1.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-2.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                  <tr>
                    <td valign="middle"><div class="chkbox_area">
                        <input type="checkbox" name="checkbox" value="1">
                        <label for="checkbox1"></label>
                      </div></td>
                    <td valign="middle"><img src="images/friend-4.jpg"/>
                      <h3>Mahendra Kakumanu <span>IT Manager</span></h3></td>
                    <td valign="middle">Information Technology</td>
                    <td valign="middle">06-5199-303</td>
                    <td valign="middle">mahendra.k@shurooq.gov.ae</td>
                    <td valign="middle"><div class="nav-func">
                        <ul>
                          <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                        </ul>
                      </div></td>
                  </tr>
                </tbody>
              </table>
              <div class="fileContainer">
              <input type="submit" value="Confrom"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



	<a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>

  <script>
    new UISearch( document.getElementById( 'sb-search' ) );
</script>

  <!-- custom scrollbar plugin -->

      <script type="text/javascript" src="{{ asset('frontend/js/jquery.tinyscrollbar.min.js') }}"></script>
      <script type="text/javascript">
          $(document).ready(function()
          {
              var $scrollbar = $("#scrollbar1");

              $scrollbar.tinyscrollbar();

          });
      </script>

      <script type="text/javascript">
      $(document).ready(function(){
      $('.panel').click( function() {
      $('.slidemenu').toggleClass('clicked').addClass('unclicked');
      $('.menubar_icon_black').toggleClass('menubar_icon_cross');
       });
      });
      </script>

      <!------for comment area-------->
      <script>
      $(function () {
        $('.user-com').click(function () {
                var index = $(this).data("target");
                jQuery('#comment_'+index).slideToggle("slow");
        });
      });

      </script>

  

  @endsection
