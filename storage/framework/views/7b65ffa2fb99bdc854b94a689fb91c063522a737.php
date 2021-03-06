
<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>

<div class="home-container">
  <div class="container">
  <?php echo $__env->make('front.includes.group_slidemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('front.includes.group_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>     
  <style>
  .wrapper > ul#results li {
  margin-bottom: 1px;
  background: #f9f9f9;

  list-style: none;
  }
  .ajax-loading{
  text-align: center;
  }
  </style>
  <div id="exTab2">


  <?php if(session('success')): ?>
  <div class="form_submit_msg">
    <div class="succ_img"><img src="<?php echo e(asset('frontend/images/success.png')); ?> "></div>
    <div class="congratulation"><?php echo e(trans('common.thank_you')); ?></div>
    <div class="message"><?php echo e(session('success')); ?></div>
  </div>
  <?php endif; ?>
  <?php if(session('error')): ?>
  <div class="form_submit_msg">
    <div class="succ_img"><!--<img src="<?php echo e(asset('frontend/images/sorry.png')); ?> ">--></div>
    <div class="message"><?php echo e(session('error')); ?></div>
  </div>   
  <?php endif; ?>
  <div class="tab-content cal-con grop-time ">
    <div class="tab-pane active">
    <div class="row" id="results">
    <?php echo $__env->make('front.groups.data_group', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    </div>
  </div>
  <div class=" ajax-loading"><img src="<?php echo e(asset('frontend/images/Spin.gif')); ?>" alt=""/> <span><?php echo e(trans('common.load_more')); ?>...</span></div>
  <div class=" text" ></div>
  </div>
  </div>
</div>  

<div class="modal fade" id="uploadphoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

</div>
</div>


<div class="modal fade" id="uploadphoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

<div class="modal-dialog modal-lg" role="document">
<div class="modal-content alt">
<div class="modal-body">
<button type="button" class="close alt" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
<div class="row">
<div class="col-sm-12">
<h2><i class="fa fa-users" aria-hidden="true"></i> Create Group</h2>
<form action="/action_page.php">
<div class="form-group">
<label for="title">Group Name:</label>
<input type="text" class="form-control" id="title" name="title">
</div>
<div class="form-group">
<label for="pwd">Upload Group Banner Image:</label>
<input type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
</div>

<div class="form-group">
<label for="title">Group Description:</label>
<input type="text" class="form-control" id="title" name="title">
</div>

<div class="form-group">
<label for="sel1">Select list:</label>
<div class="form-select">
<div class="arrow" for="sel1"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
<select class="form-control" id="sel1">
<option>All Group</option>
<option>All Group2</option>
<option>All Group 3</option>
<option>All Group 4</option>
</select>
</div>
</div>


<div class="clearfix"></div>
<div class="form-sub">
<input type="submit" value="Create"/> <i class="fa fa-check-circle" aria-hidden="true"></i></i>
</div>
</form>
</div>

</div>
</div>
</div>
</div>
</div>

<a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
<?php if($group_type=='own'){ $err = trans('group.you_have_not_created_any_group_till_date'); }else{ $err = trans('group.no_groups_created_for_now');} ?>
<script>
var page = 1; //track user scroll as page number, right now page number is 1
var cntgroup = <?php echo $total_group_count ?>;
var title1 = <?php echo $title; ?>;
var err = <?php echo $err; ?>;
//alert(title1);
if(cntgroup!=0){
load_more(page);
//if(cntgroup >3){
$(window).scroll(function() { //detect page scroll


if($(window).scrollTop() + $(window).height()+10 >= $(document).height()) { //if user scrolled from top to bottom of the page   

page++; //page number increment
load_more(page); //load content   
}

}); 
/*}else{ 
$('.text').html('<span class="no_envent_message nogroupcls">'+lang.get('alert.no_more_record')+'</span>');

}   */ 
}else{
$('.ajax-loading').html('<div class="no_event_show"> <div class="no_envent_message"> <div class="first_line">'+err+'</div> </div></div>');
//initial content load
}

function load_more(page){ 
$.ajax( 
{ 
url: '?page=' + page,
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
       $('.ajax-loading').html('<div class="no_event_show"> <div class="no_envent_message"> <div class="first_line">'+err+'</div> </div></div>');
    }else{
      $('.ajax-loading').html('<span class="no_envent_message nogroupcls">'+lang.get('alert.no_more_record')+'</span>');
    }
    
    return;
}
$('.ajax-loading').hide(); //hide loading animation once data is received
$("#results").append(data); //append data into #results element          
})
.fail(function(jqXHR, ajaxOptions, thrownError)
{
 
});
}
</script>

<script type="text/javascript">
$(document).ready(function(){
$('.panel').on('click', function() {
$('.slidemenu').toggleClass('clicked').addClass('unclicked');
$('.menubar_icon_black').toggleClass('menubar_icon_cross');
});
});
</script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('front.layout.group_app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>