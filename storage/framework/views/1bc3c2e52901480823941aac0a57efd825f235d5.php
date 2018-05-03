<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>
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
    url: "<?php echo e(URL::Route('getAddress')); ?>",
    type: "POST",
    beforeSend:function() { 

    $("#locationid").html("<img src='<?php echo e(asset('frontend/images/Spin.gif')); ?>'>");
    },
    data: {'latitude' : latitude,'longitude':longitude,'_token':CSRF_TOKEN},

    });

    request.done(function(msg) {
    $("#locationid").html( '--at '+msg );
    $("#locationtxtid").val(msg);
    });

    request.fail(function(jqXHR, textStatus) {
    alert( "Request failed: Something went wrong. Please try again." );
    });
    });
    }else{
    console.log("Browser doesn't support geolocation!");
    }

  });
}); 
</script>
<div class="home-container">
<div class="container">

<?php echo $__env->make('front.includes.group_slidemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="timeline-photo rounded-ban gro-top time1 ">
<?php if(isset($group_details->cover_image) &&  $group_details->cover_image!= NULL && file_exists('uploads/group_images/'.$group_details->cover_image)): ?>

<img src="<?php echo e(asset('timthumb.php')); ?>?src=<?php echo e(asset('uploads/group_images/').'/'.$group_details->cover_image); ?>&w=1250&h=200&q=100" alt="img" />
<?php else: ?>
<img src="<?php echo e(asset('frontend/images/no-image-event-details.jpg')); ?>" alt=""/>
<?php endif; ?>
<div class="fixme">
<div class="timeline-cont group-tag">

<?php //print_r($group_details);$group_details?>
<h2> <?php echo e($group_details->group_name); ?></h2>
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

$delete_permission_global_group =Auth::user()->can('delete-global-group');
$delete_permission_departmental_group =Auth::user()->can('delete-departmental-group');
$delete_permission_activity_group =Auth::user()->can('delete-activity-group');

$edit_permission_global_group =Auth::user()->can('edit-global-group');
$edit_permission_departmental_group =Auth::user()->can('edit-departmental-group');
$edit_permission_activity_group =Auth::user()->can('edit-activity-group');

$invite_permission_global_group =Auth::user()->can('invite-global-group');
$invite_permission_departmental_group =Auth::user()->can('invite-departmental-group');
$invite_permission_activity_group =Auth::user()->can('invite-activity-group');

$leave_permission_global_group =Auth::user()->can('leave-global-group');
$leave_permission_departmental_group =Auth::user()->can('leave-departmental-group');
$leave_permission_activity_group =Auth::user()->can('leave-activity-group');

if($group_type==1) { $permission_share =$comm_share_permission_global_grp;} elseif($group_type==2){ $permission_share = $comm_share_permission_dept_grp;} elseif($group_type==3){ $permission_share = $comm_share_permission_actv_grp;}

if($group_type==1) { $permission_like =$like_permission_global_group;} elseif($group_type==2){ $permission_like = $like_permission_departmental_group;} elseif($group_type==3){ $permission_like = $like_permission_activity_group;}

if($group_type==1) { $permission_delete =$delete_permission_global_group;} elseif($group_type==2){ $permission_delete = $delete_permission_departmental_group;} elseif($group_type==3){ $permission_delete = $delete_permission_activity_group;}

if($group_type==1) { $permission_edit =$edit_permission_global_group;} elseif($group_type==2){ $permission_edit = $edit_permission_departmental_group;} elseif($group_type==3){ $permission_edit = $edit_permission_activity_group;}

if($group_type==1) { $permission_invite =$invite_permission_global_group;} elseif($group_type==2){ $permission_invite = $invite_permission_departmental_group;} elseif($group_type==3){ $permission_invite = $invite_permission_activity_group;}

if($group_type==1) { $permission_leave =$leave_permission_global_group;} elseif($group_type==2){ $permission_leave = $leave_permission_departmental_group;} elseif($group_type==3){ $permission_leave = $leave_permission_activity_group;}
?>
<div class="row">

<div class="col-sm-8">
<?php if(session('success')): ?>
<div class="alert alert-success">
<?php echo e(session('success')); ?>

</div>
<?php endif; ?>
<?php if(count($errors) > 0): ?>       
<div class="alert alert-danger alert-dismissable">
<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<span><?php echo e($error); ?></span><br/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        

</div>          
<?php endif; ?>
<!----------------  Post add start ------------------- -->
<?php if($group_type==1) { $permission_post =$post_permission_global_group;} elseif($group_type==2){ $permission_post = $post_permission_departmental_group;} elseif($group_type==3){ $permission_post = $post_permission_activity_group;}?>
<?php if($permission_post==1 || ($group_details->user_id == \Auth::guard('user')->user()->id) || (is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0)): ?>
<div class="post-timeline new-post">            
    <?php echo e(Form::open(array('route' => ['post_add'],'id'=>'PostFrm', 'files' => true))); ?>

    <?php echo e(csrf_field()); ?>           
    <textarea placeholder="<?php echo __('common.what_is_in_your_mind');?>" name="post_text" id="post_text_id" class="postsubmitcls"></textarea>
    
    <div id="targetLayer">
    </div>
   
    <div class="post-bar">
    <div id="locationid"> </div>
     <input type="hidden" name="location" id="locationtxtid">
        <div class="row">
        <div class="col-sm-10">
        <ul class="nav-varient">
        <li><a href="javascript:void(0);" id="find_btn"><i class="fa fa-map-marker" aria-hidden="true" ></i></a></li>
        <li><a href="#" class="con-choose-image"><input name="post_image" id="postimgid" type="file" class="inputFile postsubmitcls" onChange="showPreview(this);" /> </a></li>
        <li><a href="#" class="con-choose-video"><input name="post_video" id="post_video" type="file" onChange="checkVideo(this);" /></a> </li>
        <li><span id="video_name"></span> <span style="display: none;" id="remove_video"  class="remove_video">X</span></li>
        <li id="uploading_video" style="display: none; color:#41c1e4; font-weight:bold; font-size: 12px;">Uploading <img src="<?php echo e(asset('frontend/images/uploading.gif')); ?>" alt="" width="120"></li>
        </ul>
        </div>
        <input type="hidden" name="groupid" id="groupid" value="<?php echo e($groupid); ?>" />
        <div class="col-sm-2">
        <div class="pull-right">
        <input type="submit" name="" value="<?php echo e(__('buttonTxt.post')); ?>">
        </div>
        </div>
        </div>
    </div>
</form>
</div>
<?php endif; ?>

<div class="modal fade" id="myModalFormMessage" tabindex="-1" role="dialog" aria-labelledby="myModalFormMessageLabel"
aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" onclick="redirection('');">×</button>
<h3>Alert!</h3>
</div>
<input type="hidden" name="myModalFormMessage_entity" id="myModalFormMessage_entity" value="<?php if(isset($entity)) echo $entity;?>"/>     
<input type="hidden" name="myModalFormMessage_id" id="myModalFormMessage_id" value=""/>
<input type="hidden" name="myModalFormMessage_action" id="myModalFormMessage_action" value=""/> 
<input type="hidden" name="myModalFormMessage_redirect" id="myModalFormMessage_redirect" value="false"/>        
<div class="modal-body" id="myModalFormMessage_message">
<p>Here settings can be configured...</p>
</div>
<div class="modal-footer">
<a href="javascript:void(0);" onclick="redirection('');" class="btn btn-blue" data-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>
<!----------------  Post add end------------------- -->
<script>
function showPreview(objFileInput) {
if (objFileInput.files[0]) {
var fileType = objFileInput.files[0].type;
var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/gif", "image/bmp"];

if($.inArray(fileType, ValidImageTypes) < 0) {

$.alert({
    title: 'Alert!',
    content: "<?php echo e(trans('common.only_JPEG_JPG_PNG_are_allowed')); ?>",
    icon: 'fa fa-rocket',
    type: 'blue',
    animation: 'scale',
    closeAnimation: 'scale',
    animateFromElement: false,
    buttons: {
    okay: {
    text: 'Okay',
    btnClass: 'btn-blue',
    action: function(okay){
    $(".jconfirm-light.jconfirm-open").remove();
    return false;
    }
    }
    }
    });
//reset($('#file-upload'));
// $('#preview').attr('src', $baseURL + 'assets/images/icon/pre_img.png');                                

$('#postimgid').val('');
$(this).prev('label').html("<?php echo e(trans('common.drag_and_drop_your_files_here_or')); ?> <strong><?php echo e(trans('common.browse')); ?></strong>");
return false;
}else{
var sizeKB = objFileInput.files[0].size / 1000;
sizeKB  = sizeKB.toFixed(1);
if(sizeKB > 2048)
{

$.alert({
    title: 'Alert!',
    content: "<?php echo e(trans('common.uploaded_image_size_maximum_2MB_allowed')); ?>",
    icon: 'fa fa-rocket',
    type: 'blue',
    animation: 'scale',
    closeAnimation: 'scale',
    animateFromElement: false,
    buttons: {
    okay: {
    text: 'Okay',
    btnClass: 'btn-blue',
    action: function(okay){
    $(".jconfirm-light.jconfirm-open").remove();
    return false;
    }
    }
    }
    });

$('#postimgid').val('');
$('#file-upload').prev('label').html("<?php echo e(trans('common.drag_and_drop_your_files_here_or')); ?> <strong><?php echo e(trans('common.browse')); ?></strong>");
return false;
}else{
var fileReader = new FileReader();
fileReader.onload = function (e) {
$("#targetLayer").html('<a id="removeimgid" href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGlSURBVGhD7dkxSsRAFMbxiNhY6BlEEAsvoSex0UZsxNYD6AWsLEQEXWtvoeghrGy0UAQb/T7YgRDeZmaS9yZTvAe/Jm7C/jGT3WUaHx+fQbME+/AEv/A3sU+4h21IHkZcgXTBqX3BHiQN/xPSRWrxDmsQnWeQLlCTA+gd3lY1rImYS+iddZBOrM0t9I6HFOYhtfGQRX7gGPghJf09xQNcd47FqIccAWcHhsQwYgWW4WV+LIV6CN88Izi5MSGCcwbSaxYxWSNDYsZEkNliz4kZG0FmIZQSoxFBpiHUF6MVQeYhJMVoRlCREGrHbIBmBBULIcZsQphTkF43RNGQ9u3E6a6ZMYqFtCNOoLtmpHNyFAmRFnZ7zWjEmIf0PZ00Y0xDUh6xWjFmISkRgUaMSUhORDA2Rj1kSEQwJkY9hL/s+KMoNyIIMVvwNj+WwuTWehWO5WBMTgSZLfbSPKQ2HlKbaMgqSCfW5gai8wHSyTU5h+jcgXRyTXYhOtwC/gbpAjV4hOThFnDuF7kSGMEHUtZwC/gQuPE4mxCfUBeQvL/u4+PTnab5B0YbTRTOdbJrAAAAAElFTkSuQmCC"/></a><img src="'+e.target.result+'" class="upload-preview" />');
$("#targetLayer").css('opacity','0.7');
$(".icon-choose-image").css('opacity','0.5');
}
fileReader.readAsDataURL(objFileInput.files[0]);
}
}
}
}         

</script>
<?php if(session('video_message')): ?>
    <div class="form_submit_msg" id="success_message">
      <div class="succ_img" id="uploaded_message"><?php echo e(session('video_message')); ?></div>
    </div>
<?php endif; ?>
<div class="timeline-blockMain"> 
<div id="results">

<?php echo $__env->make('front.groups.data_group_details', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div>  
</div>
<div class=" ajax-loading"><img src="<?php echo e(asset('frontend/images/Spin.gif')); ?>" alt=""/> <span><?php echo e(trans('common.load_more')); ?></span></div>
</div>

<script>
var page = 1; //track user scroll as page number, right now page number is 1


load_more(page);
var total_post = <?php echo $total_post ?>;
  //alert(cntgroup);
if(total_post!=0){

$(window).scroll(function() { //detect page scroll     

if($(window).scrollTop() + $(window).height()+10 >= $(document).height()) { //if user scrolled from top to bottom of the page   

page++; //page number increment
load_more(page); //load content   
}
}); 

}else{
  $('.ajax-loading').html('<div id="no_post" class="no_post timelineBlock"> <?php echo e(trans("common.be_the_first_one_to_post_here")); ?></div>');
}

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
if(data.length == 0){
console.log(data.length);
//notify user if nothing to load
if(page==1){
$('.ajax-loading').html('<div id="no_post" class="no_post timelineBlock"> <?php echo e(trans("common.be_the_first_one_to_post_here")); ?></div>');
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

<div class="col-sm-4">
    <div class="right-sidebar clearfix">
    <?php if((($group_details->user_id != \Auth::guard('user')->user()->id)  && $permission_leave==1) || (((is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0) || ($group_details->user_id == \Auth::guard('user')->user()->id) ) &&$permission_delete==1) || (((is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0) || ($group_details->user_id == \Auth::guard('user')->user()->id) ) &&$permission_edit==1)): ?>   
        <div class="recentUpdates alt">
        <h2 class="white-bg"><?php echo e(__('common.action')); ?></h2>
        <div class="cont-wrap">

        <?php if($permission_share==1 ): ?>
        <!-- <button class="normbutton" type="button" name="button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>-->
        <?php endif; ?>
        <?php if(($group_details->user_id != \Auth::guard('user')->user()->id)  && $permission_leave==1): ?>
        <button class="normbutton" type="button" name="button" id="leavegroupid"><i class="fa fa-user-times" aria-hidden="true"></i> <?php echo e(__('buttonTxt.leave')); ?></button>
        <?php endif; ?>
        <?php if(((is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0) || ($group_details->user_id == \Auth::guard('user')->user()->id) ) || $permission_delete==1): ?>
        <button class="normbutton" type="button" name="button" id="delgroupid"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(__('buttonTxt.delete')); ?></button>
        <?php endif; ?>

        <?php if(((is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0) || ($group_details->user_id == \Auth::guard('user')->user()->id) ) || $permission_edit==1): ?>
        <button  id="editbtngroup" class="normbutton" alt="<?php echo e($group_encode_id); ?>"><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo e(__('buttonTxt.edit')); ?></button>
        <?php endif; ?>
        </div>
        </div>
    <?php endif; ?>

    <div class="recentUpdates alt">
        <h2 class="white-bg"><?php echo e(__('common.description')); ?></h2>
        <div class="cont-wrap">
        <p><?php echo strip_tags($group_details->group_description,"<a>,<p>,<br>")?></p>
        </div>
    </div>

    <div class="recentUpdates alt">
        <h2 class="white-bg"><span><?php echo e(__('group.group_member')); ?></span>
        <?php if(((is_moderator_group(\Auth::guard('user')->user()->id,$groupid)>0) || ($group_details->user_id == \Auth::guard('user')->user()->id) ) && $permission_invite==1): ?>
        <a data-toggle="modal" data-target="#uploadphoto" id="invitemembrid" href="#" class="go pull-right"><?php echo e(__('buttonTxt.invite')); ?> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
        <?php endif; ?>
        </h2>

        <div id="scrollbar1" class="custom-scroll">
        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
        <div class="viewport">
        <div class="overview">

        <ul class="eve-list gro-detail">
        <?php if($group_memebers->count()>0): ?>
        <?php $__currentLoopData = $group_memebers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>               
        <li>
        <span class="eve-img">
        <?php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$group_member->profile_photo) )&& ($group_member->profile_photo!='' || $group_member->profile_photo!=NULL)) {?>
        <img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/').'/'.$group_member->profile_photo); ?>"/>
        <?php }else{ ?>
        <img src="<?php echo e(asset('uploads/no_img.png')); ?>"/>
        <?php  } ?>
        </span>
        <div class="eve-txt">
        <h3><a href="<?php echo e(URL::Route('user_profile').'/'.($group_member->ad_username)); ?>"><?php echo e($group_member->display_name); ?></a></h3>
        <p><?php echo e($group_member->title); ?></p>
        </div>
        <?php if(($group_member->user_id != $group_details->user_id)&& (($group_details->user_id== \Auth::guard('user')->user()->id) || is_moderator_group($group_member->user_id,$groupid)==1)): ?>
        <?php if(is_moderator_group($group_member->user_id,$groupid)!=1 ): ?>
        <div class="nav-func">
        <?php if(moderatorRequestCheck($groupid,$group_member->user_id)==0): ?>
        <ul>
        <li><a href="javascript:void(0);" alt="<?php echo e($group_member->user_id); ?>" class="addmoderatorcls" id="addmoderatorid_<?php echo e($group_member->user_id); ?>"><i class="fa fa-users" aria-hidden="true" title="Add as Moderator"></i></a></li>
        <li><a href="javascript:void(0);" class="removemoderatorcls" id="removeusrid_<?php echo e($group_member->user_id); ?>" alt="<?php echo e($group_member->user_id); ?>"><i class="fa fa-ban" aria-hidden="true" title="Remove User"></i></a></li>
        </ul>
        <?php else: ?>
        ~Request Send
        <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="nav-func">~Moderator <a href="javascript:void(0);" class="moderatorclsremove" id="removemoderatorid_<?php echo e($group_member->user_id); ?>" alt="<?php echo e($group_member->user_id); ?>"><i class="fa fa-ban" aria-hidden="true" title="Remove Moderator"></i></a></div>
        <?php endif; ?>
        <?php elseif($group_member->user_id == $group_details->user_id): ?>
        <div class="nav-func">~Owner</div>
        <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <li>
        No members
        </li>
        <?php endif; ?>
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

<script type="text/javascript">   
$(document).ready(function()
{
    $('#success_message').delay(90000).hide(4000,'linear');
        var exit_page = 1;
        window.onbeforeunload = function(){
            if (exit_page != 1)
            {            
                return '';
            }
        } 
});      

$( document ).on( "keypress", ".cmntcls", function(event) {  
if(event.which == 13) {
event.preventDefault();
var ths =$(this);
var post_id      = $( this).attr( "alt" );
var comment_text = $('#commentid_'+post_id).val();               

request = $.ajax({
url: "<?php echo e(URL::Route('savepostcomment')); ?>",
type: "POST",
'async' : false,                        
beforeSend:function() { 

// $("#commentid_"+post_id).html("<img src='<?php echo e(asset('frontend/images/Spin.gif')); ?>'>");
//$('.custom-loader').css('display', 'flex');
},
data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},

});

request.done(function(msg) {                       

var html = $("#commentsnwid_"+post_id).html();                       
html = $("#commentsnwid_"+post_id).html(html+''+msg);
ths.val('');
//$('.custom-loader').hide(); 
var cmnt_cnt = $("#cmntid_"+post_id).val(); 

cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));

$("#cmncnt_id_"+post_id).html(cmnt_cnt+" <?php echo e(__('common.comments')); ?>")  ;  
$("#cmntid_"+post_id).val(cmnt_cnt)   ;            
//$("#commentsnwid").val(msg);
$("#commentid_"+post_id).val( "" );
});

request.fail(function(jqXHR, textStatus) {
console.log( "Request failed: " + textStatus );
});
}
});
$("#invitemembrid").click(function () { 
$('#succMsg').hide();    
});

//$(".face-like").click(function () { 
$( document ).on( "click", ".face-like", function() {
var post_id = $( this).attr( "alt" );

request = $.ajax({
url: "<?php echo e(URL::Route('likeunlike')); ?>",
type: "POST",                       
data: {'post_id':post_id,'_token':CSRF_TOKEN},                  
});

request.done(function(msg) {
if(msg==1) {                    
/* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
$( "#lkid_"+post_id ).addClass( "active_lk" );
var like_cnt = $("#likeid_"+post_id).val(); 
like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
$("#likecnt_id_"+post_id).html(like_cnt+" <?php echo e(__('common.likes')); ?>")  ;
$("#likeid_"+post_id).val(like_cnt)   ;  
}else {
$("#lkid_"+post_id).removeClass("active_lk");
var like_cnt = $("#likeid_"+post_id).val(); 
like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
$("#likecnt_id_"+post_id).html(like_cnt+" <?php echo e(__('common.likes')); ?>")  ;
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

$("#delgroupid").click(function () {
var groupid =  $('#groupid').val();
$.confirm({
title: "<?php echo e(trans('common.Confirm')); ?>",
content: "<?php echo e(trans('group.confirm_delete_group')); ?>",
buttons: {
confirm: function () {
/* $.ajax({
'type': 'get',                            
'url' : "<?php echo e(URL::Route('delete_group')); ?>"+'/'+groupid,
'success': function(){
ths.parent().parent().parent().parent().remove(); 
}
});*/

window.location.href ="<?php echo e(URL::Route('delete_group')); ?>"+'/'+groupid;
},
cancel: function () {

}
}
});              

});

$("#leavegroupid").click(function () {
var groupid =  $('#groupid').val();  
$.confirm({
title: "<?php echo e(trans('common.Confirm')); ?>",
content: "<?php echo e(trans('group.confirm_leave_group')); ?>",
buttons: {
confirm: function () {
// $.ajax({
//   'type': 'get',                            
//   'url' : "<?php echo e(URL::Route('leave_group')); ?>"+'/'+groupid+'/'+<?php //echo \Auth::guard('user')->user()->id; ?>,
//   'success': function(){
//        ths.parent().parent().parent().parent().remove(); 
//   }
// });
window.location.href ="<?php echo e(URL::Route('leave_group')); ?>"+'/'+groupid+'/'+<?php echo \Auth::guard('user')->user()->id; ?>

},
cancel: function () {

}
}
});             

});

$(".removemoderatorcls").click(function () {             
var ths = $(this);
var groupid =  $('#groupid').val();
var userid      = $( this).attr( "alt" );
$.confirm({
title: "<?php echo e(trans('common.Confirm')); ?>",
content: "<?php echo e(trans('group.confirm_delete_member')); ?>",
buttons: {
confirm: function () {
$.ajax({
'type': 'get',                            
'url' : "<?php echo e(URL::Route('leave_group')); ?>"+'/'+groupid+'/'+userid,
'success': function(){
ths.parent().parent().parent().parent().remove(); 
}
});
//window.location.href ="<?php echo e(URL::Route('leave_group')); ?>"+'/'+ groupid +'/'+ userid;
},
cancel: function () {

}
}
});
});

//--------------------- ------------

$(".moderatorclsremove").click(function () {             
var ths     = $(this);
var groupid = $('#groupid').val();
var userid  = $( this).attr( "alt" );
$.confirm({
title: "<?php echo e(trans('common.Confirm')); ?>",
content: "<?php echo e(trans('group.confirm_delete_moderator')); ?>",
buttons: {
confirm: function () {
// $.ajax({
// 'type': 'get',                            
// 'url' : "<?php echo e(URL::Route('remove_moderator')); ?>"+'/'+groupid+'/'+userid,
// 'success': function(){
// ths.parent().parent().parent().parent().remove(); 
// }
// });
window.location.href ="<?php echo e(URL::Route('remove_moderator')); ?>"+'/'+ groupid +'/'+ userid;
},
cancel: function () {

}
}
});

});

//---------------------------//

$(".addmoderatorcls").click(function () {             


var groupid =  $('#groupid').val();
var userid      = $( this).attr( "alt" ); 

$.confirm({
title: "<?php echo e(trans('common.Confirm')); ?>",
content: "<?php echo e(trans('group.confirm_add_member_as_moderator')); ?>",
buttons: {
confirm: function () {
/*$.ajax({
'type': 'get',                            
'url' : "<?php echo e(URL::Route('add_moderator')); ?>"+'/'+groupid+'/'+userid,
'success': function(){
ths.parent().parent().parent().parent().remove(); 
}
});*/
window.location.href ="<?php echo e(URL::Route('add_moderator')); ?>"+'/'+groupid+'/'+userid;

},
cancel: function () {

}
}
});   
});
$(".postsubmitcls").keypress(function(event) { 
if (event.which == 13) {
event.preventDefault();
$("#PostFrm").submit();
}
});



  $("#PostFrm").on('submit',(function(e){
  //e.preventDefault();          
  var post_text = $('#post_text_id'). val();
  var image = $('#postimgid').val();
  var post_video = $('#post_video').val();
  if(post_text=='' && image =='' && post_video == '')
  {
    $.alert({
      title: '<?php echo e(trans("common.Alert")); ?>',
      content: '<?php echo e(trans("home.Either_enter_text_or_select_image_file")); ?>',
      icon: 'fa fa-rocket',
      type: 'blue',
      animation: 'scale',
      closeAnimation: 'scale',
      animateFromElement: false,
      buttons: {
        okay: {
          text: '<?php echo e(trans("common.Okay")); ?>',
          btnClass: 'btn-blue',
          action: function(okay){
            $(".jconfirm-light.jconfirm-open").remove();
            return false;
          }
        }
      }
    });

    return false;
  }
  else if(image !='' && post_video != '')
    {
      $.alert({
        title: '<?php echo e(trans("common.Alert")); ?>',
        content: '<?php echo e(trans("home.You_can_select_only_Image_or_Video")); ?>',
        icon: 'fa fa-rocket',
        type: 'blue',
        animation: 'scale',
        closeAnimation: 'scale',
        animateFromElement: false,
        buttons: {
          okay: {
            text: '<?php echo e(trans("common.Okay")); ?>',
            btnClass: 'btn-blue',
            action: function(okay){
              $(".jconfirm-light.jconfirm-open").remove();
              return false;
            }
          }
        }
      });

      return false;
    }
    else
    {
        if(post_video == '')
          {            
            $('.custom-loader').css('display', 'flex');
          }
          else
          {
            exit_page = 0;
            $('#pstsubmit').prop('disabled', true);
            $('.modal-backdrop').hide();
            //$('#post_video').val('');
            $('#video_name').html('');
            $('#remove_video').hide();
            $('#uploading_video').show();
            $('#uploaded_message').html('');
            $('#locationid').html('');
            $('#locationtxtid').val();
          }
    }


  }));




</script>

<div class="modal fade" id="uploadphoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-xl cus-modals" role="document">
<div class="modal-content alt">
<div class="modal-body friend-list">
<button type="button" class="close alt" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
<div class="row">
<div class="col-sm-12">

<div class="searchSt forSearch">
<input type="text" id="searchUser" name="" value="" placeholder="<?php echo e(__('common.search')); ?>..." aria-controls="userTable">
</div>
<div class="table-responsive user-table listing-table">
<div class="scroll-table">
<table class="table userTable" id="userTable">
<thead>
<tr>
<th width="5%"><?php echo e(__('group.employee')); ?></th>
<th width="95%">&nbsp;</th>
</tr>
</thead>
<tbody>
<?php if(count($user_list)): ?>
<?php $__currentLoopData = $user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td valign="middle" width="5%"><div class="chkbox_area">
<input type="checkbox" name="checkbox" class="inviteChk" value="1" data-userId = "<?php echo e($user->id); ?>">
<label for="checkbox1"></label>
</div></td>
<td valign="middle" width="95%"> <?php if($user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $user->profile_photo))): ?>
<img src="<?php echo e(asset('uploads/user_images/profile_photo/thumbnails/'.$user->profile_photo)); ?>" alt=""/>
<?php else: ?>
<img src="<?php echo e(asset('frontend/images/no_user_thumb.png')); ?>" alt="">
<?php endif; ?>
<h3><?php echo e($user->display_name); ?> <span><?php echo e($user->title); ?>, <?php echo e($user->department->name); ?></span></h3></td>

</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
</tbody>
</table>
</div>
<div class="fileContainer">
<input type="submit" value="<?php echo e(__('buttonTxt.invite')); ?>" id="inviteSubmit"/>
<input type="button" value="OKAY" id="confirmid" style="display:none;" />
</div>
<div id="succMsg" class="succMesg no_envent_message" style="color:green"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>



<a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>

<!--<script>
new UISearch( document.getElementById( 'sb-search' ) );
</script>-->

<!--------------------------------------------- Invite User Search  -------------------------------->

<script src="<?php echo e(asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>

<script type="text/javascript">

var table = $('#userTable').DataTable({
"paging":   false,
"ordering": false,
"info":     false,
});
// #myInput is a <input type="text"> element
$('#searchUser').on( 'keyup', function () {

// if(this.value !='' ){
//     $('#confirmid').show();
//     $('#inviteSubmit').hide();
// } else{
//     $('#confirmid').hide();
//     $('#inviteSubmit').show(); 
// }
    table.search( this.value ).draw();
} );
$('#confirmid').click(function(){
    $('#searchUser').val('');
    
    $('#searchUser').on( 'click', function () { 
     table.search( this.value ).draw();
    } );
    $('#searchUser').trigger( 'click' );
   
    $('#confirmid').hide();
    $('#inviteSubmit').show(); 
});


</script>
<style type="text/css">
.dataTables_filter {
display: none; 
}
</style>

<!------------------------------------------ Invite User Search  -------------------------------->

<!-- custom scrollbar plugin -->

<script type="text/javascript" src="<?php echo e(asset('frontend/js/jquery.tinyscrollbar.min.js')); ?>"></script>
<script type="text/javascript">
$(document).ready(function()
{
$('#succMsg').hide();
var $scrollbar = $("#scrollbar1");

$scrollbar.tinyscrollbar();




// $('#searchUser').on( 'click', function () { 
//      table.search( this.value ).draw();
//     } );
//     $('#searchUser').trigger( 'click' );

$('#inviteSubmit').click(function(){ 

    $('#searchUser').val('');

    $('#searchUser').on( 'click', function () { 
     table.search( this.value ).draw();
    } );
    $('#searchUser').trigger( 'click' );

    var groupid =  $('#groupid').val();                
    var userID = [];
    $('.inviteChk').each(function(){                
    if($(this).is(':checked'))
    userID.push($(this).attr('data-userId'));
    });

    

    $.ajax({
    'type'  : 'post',
    'data'  : {userId:userID,group_id:groupid,'_token':CSRF_TOKEN},                
    'url'   : "<?php echo e(URL::Route('group_invite')); ?>", 
    beforeSend:function() { 

    $('#succMsg').hide();
    },               
    'success': function(msg){ 
            // $('.inviteChk').each(function(){                
            // if($(this).is(':checked'))
            // table.row( $(this).parents('tr') ).remove().draw();
            // });
            // $('#succMsg').html("<?php echo e(__('common.invitation_success_msg')); ?>");
            // $('#searchUser').val('');



            // $('#searchUser').on( 'click', function () { 
            //  table.search( this.value ).draw();
            // } );
            // $('#searchUser').trigger( 'click' );
            // $('#succMsg').show();

            $('#uploadphoto').modal('hide');
            location.reload();

    }
    });

});

});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('.panel').click( function() {
$('.slidemenu').toggleClass('clicked').addClass('unclicked');
$('.menubar_icon_black').toggleClass('menubar_icon_cross');
});

$('#editbtngroup').click( function() {
var group_encode_id      = $( this).attr( "alt" );
location.href = "<?php echo e(URL::Route('group_edit')); ?>"+'/'+ group_encode_id;
});
});
</script>

<!------for comment area-------->
<script>
$(function () {
//$('.user-com').click(function () {
$( document ).on( "click", ".user-com", function() {  
var index = $(this).data("target");               
jQuery('#comment_'+index).slideToggle("slow");
});
});

</script>
<script> 

$( document ).on( "click", ".deletepost", function(event) {    
  var post_id =   $( this).attr( "alt" );
  var group_id =  <?php echo decrypt($groupid)?>;
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this post?",
    buttons: {
      confirm: function () { 
      window.location.href ="<?php echo e(URL::Route('posts_delete')); ?>"+'/'+post_id+ '/'+group_id;
      },
      cancel: function () {

      }
    }
  });              

});

$( document ).on( "click", ".deletecomment", function(event) {    
  var comment_id =   $( this).attr( "alt" );
  var group_id =  <?php echo decrypt($groupid)?>;
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this comments?",
    buttons: {
      confirm: function () { 
      window.location.href ="<?php echo e(URL::Route('comments_delete')); ?>"+'/'+comment_id+ '/'+group_id;
      },
      cancel: function () {

      }
    }
  });              

});


$('#uploadphoto').on('hide.bs.modal', function () {
    
    $('#searchUser').val('');
    $('#searchUser').on( 'click', function () { 
     table.search( this.value ).draw();
    } );
    $('#searchUser').trigger( 'click' );
    $('.inviteChk').removeAttr('checked');
})

  function checkVideo(objFileInput) {
  if (objFileInput.files[0]) {
      var fileType = objFileInput.files[0].type;
      var ValidImageTypes = ["video/mp4", "video/x-ms-wmv", "video/x-msvideo", "video/avi", "video/msvideo", "video/x-flv", "video/mpeg"];

      if ($.inArray(fileType, ValidImageTypes) < 0) {                  
          $.alert({
            title: 'Alert!',
            content: 'Please upload only video file[.mp4, .wmv, .avi, .flv, .mpeg, .mpg]',
            icon: 'fa fa-rocket',
            type: 'blue',
            animation: 'scale',
            closeAnimation: 'scale',
            animateFromElement: false,
            buttons: {
              okay: {
                text: 'Okay',
                btnClass: 'btn-blue',
                action: function(okay){
                $(".jconfirm-light.jconfirm-open").remove();
                return false;
                }
              }
            }
          });                            

          $('#post_video').val('');
          return false;
      }else{

            var sizeKB = objFileInput.files[0].size / 1000;
            sizeKB  = sizeKB.toFixed(1);
            if(sizeKB > 20480)
            {  
                $.alert({
                    title: 'Alert!',
                    content: "Maximum 20MB allowed.",
                    icon: 'fa fa-rocket',
                    type: 'blue',
                    animation: 'scale',
                    closeAnimation: 'scale',
                    animateFromElement: false,
                    buttons: {
                      okay: {
                        text: 'Okay',
                        btnClass: 'btn-blue',
                        action: function(okay){
                            $(".jconfirm-light.jconfirm-open").remove();
                            return false;
                        }
                      }
                    }
                }); 

              $('#post_video').val('');              
              return false;
            }
            else
            {
              var video_name = $('#post_video').val().split('\\').pop();
              $('#video_name').html(video_name);
              $('#remove_video').show();
            }
          }
      }
  }

  $('#remove_video').click(function(){
      $('#post_video').val('');
      $('#video_name').html('');
      $('#remove_video').hide();
  });   

</script> 


<style>
.active_lk{
background: #2ec4e7;
border: 1px solid #109fc0;
color: #FFF;
} </style>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.group_app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>