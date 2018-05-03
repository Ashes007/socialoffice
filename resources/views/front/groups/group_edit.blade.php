@extends('front.layout.group_app')
@section('title','Tawasul')
@section('content')
<style>
.subMit-bottom.active1{transform: translateY(0px);}
</style>
<div class="home-container createEventPopup">
<section class="createEventSection">
  <div class="createEventSection-close">
  <a href="{{ URL::Route('group') }}">{{trans('common.cancel')}}
  <img src="{{ asset('frontend/images/btn-cancel.png')}}" alt="">
  </a>
  </div>

<div class="container">
<!-- ========= Create Event Circle Container Start ========= -->
  @if (count($errors) > 0)       
  <div class="alert alert-danger alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  @foreach ($errors->all() as $error)
  <span>{{ $error }}</span><br/>
  @endforeach                        

  </div>          
  @endif
  <div class="fullHeight formstartContainer startForm">
  <div class="absCont">
  <div class="fixedfull"></div> 
  <div class="ceCircle">
  <div class="cirlePoint">
  <div class="cirlePointInn"></div>
  </div>
  <div class="ceTitle">{{trans('group.update_group')}}</div>
  </div>
  <!-- ========= Start Container Start ========= -->
  <div class="startContainer">
  <h1>{{trans('common.start')}}!</h1>
  <div class="proceedContainer">
  <h5>
  <a href="javascript:void(0)" id="formStart" class="ceBtnBlue pOSval">{{trans('common.proceed')}}</a> {{trans('common.or')}}
  <span class="pressText">{{trans('common.press')}}</span> {{trans('common.enter')}}</h5>
  <input type="text" style="width: 0;height: 0;border: none;" id="formstart" autofocus />
  </div>
  </div>
  </div>
  </div>
<!-- ========= Type Form Container Start ========= -->
  <div class="typeFormContainer">
  <div class="formContainerInn">
  {{ Form::open(array('route' => ['update_group'],'class'=>'typeForm','id'=>"editfrmid" ,'files' => true)) }}
  {{ csrf_field() }}  
  <input type="hidden" name="id" value="{{$group_encode_id}}" /> 
  <ul class="formList mainForm">
  <li class="formSection formInit">
  <div class="inputTitle">
  <span class="numberText">1</span> {{ trans('group.what_will_be_your')}}
  <span class="textOne">{{ trans('group.group_name')}}</span>? *</div>
  <div class="inputField">
  <input type="text" name="group_name" value="{{ $group_user->group_name }}" id="startForm" maxlength="150" class="formTextField enterinput" placeholder="">
  <p> {{ trans('common.Max_length_150_characters')}}</p>
  </div>
  <div class="proceedContainer spaceOne">
  <h5>
  <a href="javascript:void(0)" id="proceedFirst" class="ceBtnBlue proceedToNext">{{trans('common.proceed')}}</a> {{trans('common.or')}}
  <span class="pressText">{{trans('common.press')}}</span> {{trans('common.enter')}}</h5>
  </div>
  </li>
  <li class="formSection formMove">
  <div class="inputTitle">
  <span class="numberText">2</span> {{trans('group.Can_you_provide_a')}}
  <span class="textOne">{{trans('group.cover_image')}}</span> {{trans('group.for_the_Group')}}? *</div>

  <div class="inputField">

  @if(isset($group_user->cover_image) && $group_user->cover_image!='' && file_exists(public_path('uploads/group_images/'.$group_user->cover_image)))

  <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/'.$group_user->cover_image) }}&w=786&h=175&q=100" alt="img" />
  @else
  <img src="{{ asset('frontend/images/no-image-details.jpg') }}" alt="">
  @endif

  <div class="fiLeCustom">
  <label for="file-upload" class="custom-file-upload">{{ trans('common.drag_and_drop_your_files_here_or')}}
  <strong>{{ trans('common.browse')}}</strong>
  </label>
  <input id="file-upload" name='upload_cont_img' type="file">
  </div>
  <p>{{trans('common.Please_upload_image_file_with_width_greater_than_1280px_and_height_greater_than_382px_and_maximum_file_size_2MB')}}</p>
  </div>

  </li>
  <li class="formSection formMove">
  <div class="inputTitle">
  <span class="numberText">3</span> {{trans('group.Can_you_provide_a')}}
  <span class="textOne">{{trans('group.profile_image')}}</span> {{trans('group.for_the_Group')}}? </div>

  <div class="inputField">
  @if(isset($group_user->profile_image) && $group_user->profile_image!='' && file_exists(public_path('uploads/group_images/profile_image/'.$group_user->profile_image)))
  <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/profile_image/'.$group_user->profile_image) }}&w=200&h=200&q=100" alt="img" />

  @endif

  <div class="fiLeCustom">
  <label for="file-upload" class="custom-file-upload">{{ trans('common.drag_and_drop_your_files_here_or')}}
  <strong> {{ trans('common.browse')}}</strong>
  </label>
  <input id="file-upload-profile" name='upload_profile_img' type="file">
  </div>
  <p>{{ trans('common.Please_upload_image_file_with_width_less_than_300px_and_height_less_than_300px_and_maximum_file_size_2MB') }}  </p>
  </div>
  </li>
  <li class="formSection formMove">
  <div class="inputTitle">
  <span class="numberText">4</span>{{ trans('group.Write_something_about_your')}}
  <span class="textOne">{{ trans('group.group')}}</span>? *</div>
  <div class="inputField textareaOnly">
  <textarea class="formTextField textareaField enterinput" rows="" id="group_description" name="group_description">{{ $group_user->group_description }}</textarea>
  </div>
  <!-- <div class="proceedContainer spaceOne">
  <h5>
  <a href="javascript:void(0)" class="ceBtnBlue proceedToNext">Proceed</a> or
  <span class="pressText">Press</span> ENTER</h5>
  </div>-->
  </li>


  </ul>

  <div class="subMit-bottom">
  <div class="container">
  <div class="proceedContainer">
  <h5>
  <!--<a href="group.html" class="ceBtnBlue">Proceed</a>-->
  <input type="submit" value="{{ trans('buttonTxt.update') }}" id="testsubmit" class="ceBtnBlue">
  <!-- {{trans('common.or')}}
   <span class="pressText" id="submitpresstxt">{{trans('common.press')}}</span> {{trans('common.enter')}} --></h5>
  <input id="lastFocus" type="text" style="width:0; height:0; border-width: 0;">
  </div>
  </div>
  </div>

  </form>
  </div>
  </div>
  </div>



  </section>
  </div>

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


<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('frontend/js/custom.js') }}"></script>

<script src="{{ asset('frontend/js/multiselects.js') }}"></script>

<script>
$(document).ready(function() {
// create MultiSelect from select HTML element
var required = $("#required").kendoMultiSelect().data("kendoMultiSelect");
var optional = $("#optional").kendoMultiSelect({
autoClose: false
}).data("kendoMultiSelect");

$("#get").click(function() {
alert("Attendees:\n\nRequired: " + required.value() + "\nOptional: " + optional.value());
});
//-------------------------
$(".eventType > ul > li").each(function(){
$(this).click(function(){
$(".eventType > ul > li").removeClass('active');              

$(this).addClass('active');
$('#grouptypeid').val($( this).attr( "alt" ));
if($( this).attr( "alt" )==2){
$(".deptcls").attr("required","true");
}
});
});

$('#file-upload').change(function () {
var i = $(this).prev('label').clone();
var file = $('#file-upload')[0].files[0].name;
$(this).prev('label').text(file);




var fileType = $('#file-upload')[0].files[0].type;

var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/gif", "image/bmp"];

if ($.inArray(fileType, ValidImageTypes) < 0) { 
  $.alert({
  title: 'Alert!',
  content: "{{trans('common.only_JPEG_JPG_PNG_are_allowed')}}",
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

$(this).val('');
$(this).prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
return false;
}else{
var file = $('#file-upload')[0].files[0];
var _URL = window.URL || window.webkitURL;
var img = new Image();
img.src = _URL.createObjectURL(file);
img.onload = function() { 
imageWidth = this.width;
imageHeight = this.height;                       

if(imageWidth >= parseInt(1250) && imageHeight >= parseInt(200)){

var sizeKB = file.size / 1000;
sizeKB  = sizeKB.toFixed(1);
if(sizeKB > 2048)
{                                 
  $.alert({
  title: 'Alert!',
  content: "{{trans('common.uploaded_image_size_maximum_2MB_allowed')}}",
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

$('#file-upload').val('');
$('#file-upload').prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
return false;
}
$('#file-upload').closest("li.formSection").next("li.formSection").click();

} else {

  $.alert({
  title: 'Alert!',
  content: "{{ trans('common.please_upload_image_file_with_width_greater_than_1280px_and_height_greater_than_382px')}}",
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

  $('#file-upload').val('');
  $('#file-upload').prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
  return false;
}
};

}

});

$('#file-upload-profile').change(function () {
var i = $(this).prev('label').clone();
var file = $('#file-upload-profile')[0].files[0].name;
$(this).prev('label').text(file);
var fileType = $('#file-upload-profile')[0].files[0].type;
var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/gif", "image/bmp"];

if ($.inArray(fileType, ValidImageTypes) < 0) {  
//reset($('#file-upload'));
// $('#preview').attr('src', $baseURL + 'assets/images/icon/pre_img.png');
  $.alert({
  title: 'Alert!',
  content: "{{trans('common.only_JPEG_JPG_PNG_are_allowed')}}",
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

  $(this).val('');
  $(this).prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
  return false;
}else{
var file = $('#file-upload-profile')[0].files[0];
var _URL = window.URL || window.webkitURL;
var img = new Image();
img.src = _URL.createObjectURL(file);
img.onload = function() { 
imageWidth = this.width;
imageHeight = this.height;                       

if(imageWidth <= parseInt(300) && imageHeight<=parseInt(300)){

if(imageWidth!=imageHeight) {                                
  $.alert({
  title: 'Alert!',
  content: "{{trans('common.Please_upload_a_perfect_squre_image')}}",
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

  $('#file-upload-profile').val('');
  $('#file-upload-profile').prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
  return false;

}else{
var sizeKB = file.size / 1000;
sizeKB  = sizeKB.toFixed(1);
if(sizeKB > 2048)
{                                   

  $.alert({
  title: 'Alert!',
  content: "{{trans('common.uploaded_image_size_maximum_2MB_allowed')}}",
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

  $('#file-upload-profile').val('');
  $('#file-upload-profile').prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
  return false;
}
}
$('#file-upload-profile').closest("li.formSection").next("li.formSection").click();

} else {

  $.alert({
  title: 'Alert!',
  content: "{{trans('common.Please_upload_image_file_with_width_less_than_300px_and_height_less_than_300px')}}",
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

  $('#file-upload-profile').val('');
  $('#file-upload-profile').prev('label').html("{{ trans('common.drag_and_drop_your_files_here_or')}} <strong>{{ trans('common.browse')}}</strong>");
  return false;
}
};
}
/* going to next section
* as per the custom typescript.js clicking on  '.formSection' activate the current area
* next line of code is to click on the next '.formSection'
*/


}); 

$(".fixedfull").click(function () {
$("#formstart").focus();
});

$(".textareaField").keypress(function(event) {
if (event.which == 13) {
event.preventDefault();
$( "#editfrmid" ).submit();
}});

$("#editfrmid").on('submit',(function(e){

var $groupName = $('#startForm').val();
if($groupName == '')
{
  $.alert({
  title: 'Alert!',
  content: "{{trans('group.Please_give_a_group_name')}}",
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
  $('#startForm').closest("li.formSection").find('.enterinput').focus();
  return false;
  }
  }
  }
  });
  $('#startForm').closest("li.formSection").click();
  return false;
}
var $group_desc = $('#group_description').val();
if($group_desc == '')
{
  $.alert({
  title: 'Alert!',
  content: "{{trans('group.Please_enter_group_description')}}",
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
  $('#group_description').closest("li.formSection").find('.enterinput').focus();
  return false;
  }
  }
  }
  });
  $('#group_description').closest("li.formSection").click();
  return false;
}



}));

$('#lastFocus').on('keyup keypress', function(e) {
var keyCode = e.keyCode || e.which;
if (keyCode === 13) {
//e.preventDefault();
//return false;
// $('#editfrmid').submit();
}
});
});
</script>

<!-- ========= for search area ========= -->
<script src="{{ asset('frontend/js/classie.js') }}"></script>
<!-- <script src="{{ asset('frontend/js/uisearch.js') }}"></script>
<script>
new UISearch(document.getElementById('sb-search'));
</script> -->
<!-- <script src="js/index.js"></script> -->
<script src="{{ asset('frontend/js/typescript.js') }}"></script>
<script src="{{ asset('frontend/js/select2.js')}}"></script>
<script src="{{ asset('frontend/js/select2.full.js')}}"></script>
<script>
$(document).ready(function () {
$('.js-example-basic-multiple').select2();
});
</script>
@endsection