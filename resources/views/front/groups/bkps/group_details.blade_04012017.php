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
        ?>
       <div class="row">

         <div class="col-sm-8">
         <!----------------  Post add start ------------------- -->
         <?php if($group_type==1) { $permission_post =$post_permission_global_group;} elseif($group_type==2){ $permission_post = $post_permission_departmental_group;} elseif($group_type==3){ $permission_post = $post_permission_activity_group;}?>
           @if($permission_post==1 )
           <div class="post-timeline">            
            {{ Form::open(array('route' => ['post_add'],'id'=>'PostFrm', 'files' => true)) }}
            {{ csrf_field() }}           
             <textarea placeholder="What's in your mind today?" name="post_text"></textarea>
             <div>
             --at sector 5
             </div>
             <div class="post-bar">
               <div class="row">
                 <div class="col-sm-6">
                   <ul class="nav-varient">
                     <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
                     <li><a href="#"><i class="fa fa-camera" aria-hidden="true"></i></a></li>
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

           <div class="timeline-blockMain">
           @if(count($group_posts)>0)
            @foreach($group_posts as $post)
             <div class="timelineBlock">

               <div class="time-postedBy">
                 <div class="image-div"><img src="images/avatar-male.jpg" alt=""></div>
                 <h2>Mahendra Kakumanu</h2>
                 <p>Shared publicly - 7.30 PM Today</p>
               </div>
               <div class="postedTime-image">
                 <h2>{{$post->text}}</h2>
               </div>
               <div class="likeComment">
                 <div class="row">
                   <div class="col-sm-5">
                     <button class="face-like" type="button" name="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</button>
                   </div>
                   <div class="col-sm-7">
                     <p>127 Likes - <a href="javascript:void(0);" class="user-com" data-target="1">3 Comments</a></p>
                   </div>
                 </div>
               </div>
               <div class="comment-other">
                 <div class="comment-other-single">
                   <div class="image-div"><img src="images/avatar-male.jpg" alt=""></div>
                   <h2>Albert Velian <span>8.03 PM Today</span></h2>
                   <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the</p>
                 </div>

                 <div id="comment_1" style="display:none;">
                 <div class="comment-other-single">
                   <div class="image-div"><img src="images/avatar-male.jpg" alt=""></div>
                   <h2>Jeesmon Steaphen <span>8.03 PM Today</span></h2>
                   <p>Lorem Ipsum is simply dummy text</p>
                 </div>
               </div>

               </div>
               <div class="comment-field">
                 <div class="image-div"><img src="images/avatar-male.jpg" alt=""></div>
                 <textarea name="name" placeholder="Press Enter to post comment"></textarea>
               </div>
             </div>
             @endforeach
             @else
             <div class="timelineBlock">
             No Post
             </div>
            @endif

           </div>

         </div>


         <div class="col-sm-4">
           <div class="right-sidebar clearfix">
             <div class="recentUpdates alt">
              <h2 class="white-bg">Action</h2>
              <div class="cont-wrap">
                <?php if($group_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}?>
                @if($permission_share==1 )
                <button class="normbutton" type="button" name="button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>
                @endif
                <button class="normbutton" type="button" name="button"><i class="fa fa-user-times" aria-hidden="true"></i> Leave group</button>
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
