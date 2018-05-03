@extends('front.layout.app')
@section('title','Tawasul')
@section('content')
<div class="home-container">
<div class="container">
<div class="row">
@include('front.includes.home_left')
<div class="col-lg-6 col-sm-5">
<span class="new_post_alert" style="display: none;" id="new_post_alert" ><a href="javascript:void(0);" onclick="load_more(1);">
<!-- <i class="fa fa-long-arrow-up"></i> --> New Posts</a></span>
@if (session('error'))
<div class="form_submit_msg msg_section">
  <div class="message">{{ session('error') }}</div>
</div>
@endif
@if (session('success'))
<div class="form_submit_msg msg_section">
  <div class="succ_img">{{ session('success') }}</div>
</div>
@endif
<?php
$post_permission_global_group =Auth::user()->can('post-global-group');
$post_permission_departmental_group =Auth::user()->can('post-departmental-group');
$post_permission_activity_group =Auth::user()->can('post-activity-group');
?>
@if($post_permission_global_group || $post_permission_departmental_group || $post_permission_activity_group)
<div class="post-timeline new-post">
{{ Form::open(array('route' => ['post_home'],'id'=>'PostFrm', 'files' => true)) }}
{{ csrf_field() }}  
<textarea placeholder="{{ trans('common.what_is_in_your_mind') }}" name="post_text" id="post_text_id"  class="postcls expand"></textarea>

<div id="targetLayer">
</div>
<input type="hidden" name="location" id="locationtxtid">
  <div class="post-bar">
  <div id="locationid"></div>
    <div class="row">
      <div class="col-sm-10">
        <ul class="nav-varient">
          <li><a href="javascript:void(0);" id="find_btn"><i class="fa fa-map-marker" aria-hidden="true" ></i></a></li>
          <li><a href="#" class="con-choose-image"><input name="post_image" id="postimgid" type="file" class="inputFile postsubmitcls" onChange="showPreview(this);" /></a> </li>
          <li><a href="#" class="con-choose-video"><input name="post_video" id="post_video" type="file" onChange="checkVideo(this);" /></a> </li>
          <li><span id="video_name"></span> <span style="display: none;" id="remove_video"  class="remove_video">X</span></li>
          <li id="uploading_video" style="display: none; color:#41c1e4; font-weight:bold; font-size: 12px;">Uploading <img src="{{ asset('frontend/images/uploading.gif') }}" alt="" width="120"></li>
        </ul>
      </div>
      <div class="col-sm-2">
        <div class="pull-right">
          <a class="view_all" id ="pstsubmit"  readonly="">{{ trans('buttonTxt.post') }}</a> 
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade birth-modal" id="allgroups" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content alt">
        <div class="modal-body">
        <button type="button" class="close alt" data-dismiss="modal" aria-label="Close"></button>
          <div class="row">
            <div class="col-sm-12 request-area group-select">
            <h2><i class="fa fa-users" aria-hidden="true"></i>{{ trans('home.All_Groups') }} </h2>
            
            @if(count($mygroupall)>0)
              <div class="total-check">
              @foreach($mygroupall as $groupall)

              @if((($groupall->group_type_id==1  && Auth::user()->can('post-global-group'))|| ($groupall->user_id == \Auth::guard('user')->user()->id)||is_moderator_group(\Auth::guard('user')->user()->id,encrypt($groupall->id))>0) || (($groupall->group_type_id==2  && Auth::user()->can('post-departmental-group'))||is_moderator_group(\Auth::guard('user')->user()->id,encrypt($groupall->id))>0|| ($groupall->user_id == \Auth::guard('user')->user()->id)) || (($groupall->group_type_id==3  && Auth::user()->can('post-activity-group'))|| ($groupall->user_id == \Auth::guard('user')->user()->id) || is_moderator_group(\Auth::guard('user')->user()->id,encrypt($groupall->id))>0))
                <div class="left-check">
                  <div class="chkbox_area">
                  <!-- <input type="checkbox" name="groupids[]" class="inviteChk" value="{{ $groupall->id }}" data-userId = "{{ $groupall->id }}"> -->
                  <input type="radio" name="groupids" class="inviteChk" value="{{ $groupall->id }}" data-userId = "{{ $groupall->id }}"/>
                  <label for="checkbox1">{{$groupall->group_name}}</label>
                  </div>
                <div class="clearfix"></div>
                </div>
              @endif
              @endforeach
              </div> 
            <div class="fileContainer set-save"><input type="submit" id="cnfsubmitpost" value="{{ trans('common.Confirm') }}"></div>
            @else
            <div class="total-check"> <div class="left-check nogroup">{{ trans('home.No_Group_Unable_to_post') }}</div></div>
            @endif 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</div>

@endif

<div class="form_submit_msg" id="success_message" style="display: none;">
  <div class="succ_img" id="uploaded_message"></div>
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
      <p>{{ trans('home.Here_settings_can_be_configured') }}</p>
      </div>
      <div class="modal-footer">
      <a href="javascript:void(0);" onclick="redirection('');" class="btn btn-blue" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
<div class="timeline-blockMain">

<div id="results">
@include('front.home-data')

</div>
</div>
<div class=" ajax-loading" style="text-align: center;"><img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>{{ trans('common.load_more') }}</span></div>
</div>
@include('front.includes.home_right')
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
<script>
  var page = 1; //track user scroll as page number, right now page number is 1

  var cntgroup = <?php echo $total_feed_count ?>;
  //alert(cntgroup);
  if(cntgroup!=0){
  load_more(page);

  $(window).scroll(function() { //detect page scroll     

  if($(window).scrollTop() + $(window).height()+10 >= $(document).height()) { //if user scrolled from top to bottom of the page   

  page++; //page number increment
  load_more(page); //load content   
  }
  }); 

  }else{
  $('.ajax-loading').html('<div class="timelineBlock">   <div class="nofeedcls" style="margin:0px">     <div class="message">{{ trans("home.We_Look_Forward_to_your_first_post") }}</div>  </div>  </div>');
  }

  function load_more(page){ 
      if(page==1){
        $("#results").html('');
        $('#new_post_alert').hide();
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera   
      }

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
    $('.ajax-loading').html('<div class="timelineBlock">   <div class="form_submit_msg nofeedcls" style="margin:0px">     <div class="message">We Look Forward to your first post</div>  </div>  </div>');
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
  <script type="text/javascript">


  $(document).ready(function() {

  	//$('.msg_section').delay(10000).hide(4000,'linear');

    var exit_page = 1;
    window.onbeforeunload = function(){
        if (exit_page != 1)
        {            
            return '';
        }
    }

  $( document ).on( "click", "#pstsubmit", function() {     
    var post_text = $('#post_text_id'). val();
    var image = $('#postimgid').val();
    var post_video = $('#post_video').val();
    if($.trim(post_text)=='' && image =='' && post_video == '')
    {
      $.alert({
        title: '{{ trans("common.Alert") }}',
        content: '{{ trans("home.Either_enter_text_or_select_image_file") }}',
        icon: 'fa fa-rocket',
        type: 'blue',
        animation: 'scale',
        closeAnimation: 'scale',
        animateFromElement: false,
        buttons: {
          okay: {
            text: '{{ trans("common.Okay") }}',
            btnClass: 'btn-blue',
            action: function(okay){
              $(".jconfirm-light.jconfirm-open").remove();
              return false;
            }
          }
        }
      });

      $('.eventType').closest("li.formSection").click();
      return false;
    }
    else if(image !='' && post_video != '')
    {
      $.alert({
        title: '{{ trans("common.Alert") }}',
        content: '{{ trans("home.You_can_select_only_Image_or_Video") }}',
        icon: 'fa fa-rocket',
        type: 'blue',
        animation: 'scale',
        closeAnimation: 'scale',
        animateFromElement: false,
        buttons: {
          okay: {
            text: '{{ trans("common.Okay") }}',
            btnClass: 'btn-blue',
            action: function(okay){
              $(".jconfirm-light.jconfirm-open").remove();
              return false;
            }
          }
        }
      });

      $('.eventType').closest("li.formSection").click();
      return false;
    }
    else{
      $('#allgroups').modal('show');
    }

  }); 





  // $(".postcls").keypress(function(event) {
  // if (event.which == 13) {
  //   event.preventDefault();
  //   var post_text = $('#post_text_id'). val();
  //   var image = $('#postimgid').val();
  //   if($.trim(post_text)=='' && image =='')
  //   {
  //     $.alert({
  //     title: '{{ trans("common.Alert") }}',
  //     content: '{{ trans("home.Either_enter_text_or_select_image_file") }}',
  //     icon: 'fa fa-rocket',
  //     type: 'blue',
  //     animation: 'scale',
  //     closeAnimation: 'scale',
  //     animateFromElement: false,
  //     buttons: {
  //     okay: {
  //     text: '{{ trans("common.Okay") }}',
  //     btnClass: 'btn-blue',
  //     action: function(okay){
  //     $(".jconfirm-light.jconfirm-open").remove();
  //     return false;
  //     }
  //     }
  //     }
  //     });

  //     $('.eventType').closest("li.formSection").click();
  //     return false;
  //   }else{
  //     $('#allgroups').modal('show');
  //   }
  
  // }
  // });

  $( document ).on( "keypress", ".cmntcls", function(event) {
  //$(".cmntcls").keypress(function(event) {
  if (event.which == 13) {
  event.preventDefault();
  var ths =$(this);
  var post_id      = $( this).attr( "alt" );
  var comment_text = $('#commentid_'+post_id).val();               

  request = $.ajax({
  url: "{{URL::Route('savepostcomment')}}",
  type: "POST",
  'async' : false,
  beforeSend:function() { 

  $("#commentid_"+post_id).html("<img src='{{ asset('frontend/images/Spin.gif') }}'>");
  },
  data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},

  });

  request.done(function(msg) {                       

  var html = $("#commentsnwid_"+post_id).html();                       
  html = $("#commentsnwid_"+post_id).html(html+''+msg); 
  ths.val('');
  var cmnt_cnt = $("#cmntid_"+post_id).val(); 

  cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));

  $("#cmncnt_id_"+post_id).html(cmnt_cnt+" {{ __('common.comments')}}")  ;  
  $("#cmntid_"+post_id).val(cmnt_cnt)   ;            
  //$("#commentsnwid").val(msg);
  $("#commentid_"+post_id).val( "" );
  });

  request.fail(function(jqXHR, textStatus) {
  console.log( "Request failed: " + textStatus );
  });
  }
  }); 



  $( document ).on( "keypress", ".cmntclsocc", function(event) {
  //$(".cmntcls").keypress(function(event) {
  if (event.which == 13) {
  event.preventDefault();
  var ths =$(this);
  var post_id      = $( this).attr( "alt" );
  var comment_text = $('#commentoccid_'+post_id).val();               

  request = $.ajax({
  url: "{{URL::Route('savepostcommentocc')}}",
  type: "POST",
  'async' : false,
  beforeSend:function() { 

  $("#commentoccid_"+post_id).html("<img src='{{ asset('frontend/images/Spin.gif') }}'>");
  },
  data: {'comment_text' : comment_text,'post_id':post_id,'_token':CSRF_TOKEN},

  });

  request.done(function(msg) {                       

  var html = $("#commentsnwoccid_"+post_id).html();                       
  html = $("#commentsnwoccid_"+post_id).html(html+''+msg); 
  ths.val('');
  var cmnt_cnt = $("#cmntoccid_"+post_id).val(); 

  cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));

  $("#cmncntocc_id_"+post_id).html(cmnt_cnt+" {{ __('common.comments')}}")  ;  
  $("#cmntoccid_"+post_id).val(cmnt_cnt)   ;            
  //$("#commentsnwid").val(msg);
  $("#commentoccid_"+post_id).val( "" );
  });

  request.fail(function(jqXHR, textStatus) {
  console.log( "Request failed: " + textStatus );
  });
  }
  }); 


  //$(".face-like").click(function () { 
  $( document ).on( "click", ".face-like-post", function() {
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
  $("#likecnt_id_"+post_id).html(like_cnt+" {{ __('common.likes')}}")  ;
  $("#likeid_"+post_id).val(like_cnt)   ;  
  }else {
  $("#lkid_"+post_id).removeClass("active_lk");
  var like_cnt = $("#likeid_"+post_id).val(); 
  like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
  $("#likecnt_id_"+post_id).html(like_cnt+" {{ __('common.likes')}}")  ;
  $("#likeid_"+post_id).val(like_cnt)   ; 
  }                

  });
  request.fail(function(jqXHR, textStatus) {
  console.log( "Request failed: " + textStatus );
  });
  });


  $( document ).on( "click", ".face-like-occation", function() {
  var post_id = $( this).attr( "alt" );

  request = $.ajax({
  url: "{{URL::Route('likeunlikeoccation')}}",
  type: "POST",                       
  data: {'post_id':post_id,'_token':CSRF_TOKEN},                  
  });

  request.done(function(msg) {
  if(msg==1) {                    
  /* $("#lkid_"+post_id).css({"background-color": "#2ec4e7", "border": "1px solid #109fc0",'color':"#FFF"});*/
  $( "#lkoccid_"+post_id ).addClass( "active_lk" );
  var like_cnt = $("#likeoccid_"+post_id).val(); 
  like_cnt = parseInt(parseInt(like_cnt)+parseInt(1));
  $("#likeocccnt_id_"+post_id).html(like_cnt+" {{ __('common.likes')}}")  ;
  $("#likeoccid_"+post_id).val(like_cnt)   ;  
  }else {
  $("#lkoccid_"+post_id).removeClass("active_lk");
  var like_cnt = $("#likeoccid_"+post_id).val(); 
  like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
  $("#likeocccnt_id_"+post_id).html(like_cnt+" {{ __('common.likes')}}")  ;
  $("#likeoccid_"+post_id).val(like_cnt)   ; 
  }                

  });
  request.fail(function(jqXHR, textStatus) {
  console.log( "Request failed: " + textStatus );
  });
  });


  $("#PostFrm").on('submit',(function(e){
  //$("#cnfsubmitpost").on('click',(function(e){
  	$('#new_post_alert').css({ opacity: 0 });
  e.preventDefault();          
   var groupID = [];
   $('.inviteChk').each(function(){                
   if($(this).is(':checked'))
   groupID.push($(this).attr('data-userId'));
   });
  //var groupID = $('#post_text_id'). val();
  var post_text = $('#post_text_id'). val();
  var image = $('#postimgid').val();
  var post_video = $('#post_video').val();
  if(post_text=='' && image =='' && post_video == '')
  {
    $.alert({
      title: '{{ trans("common.Alert") }}',
      content: '{{ trans("home.Either_enter_text_or_select_image_file") }}',
      icon: 'fa fa-rocket',
      type: 'blue',
      animation: 'scale',
      closeAnimation: 'scale',
      animateFromElement: false,
      buttons: {
        okay: {
          text: '{{ trans("common.Okay") }}',
          btnClass: 'btn-blue',
          action: function(okay){
            $(".jconfirm-light.jconfirm-open").remove();
            return false;
          }
        }
      }
    });

  $('.eventType').closest("li.formSection").click();
  return false;
  }
  else if(image !='' && post_video != '')
    {
      $.alert({
        title: '{{ trans("common.Alert") }}',
        content: '{{ trans("home.You_can_select_only_Image_or_Video") }}',
        icon: 'fa fa-rocket',
        type: 'blue',
        animation: 'scale',
        closeAnimation: 'scale',
        animateFromElement: false,
        buttons: {
          okay: {
            text: '{{ trans("common.Okay") }}',
            btnClass: 'btn-blue',
            action: function(okay){
              $(".jconfirm-light.jconfirm-open").remove();
              return false;
            }
          }
        }
      });

      $('.eventType').closest("li.formSection").click();
      return false;
    }
  else if(groupID.length===0){
    $.alert({
      title: 'Alert!',
      content: 'select group',
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

    $('.eventType').closest("li.formSection").click();
    return false;
  }else{
    //$('#allgroups').hide();
    //$('.custom-loader').css('display', 'flex');
    //$('#PostFrm').submit();
    $('#allgroups').modal('hide');
    $.ajax({
      'type'  : 'POST',
      'data'  : new FormData(this),                
      'url'   : "{{URL::Route('post_home')}}", 
      'beforeSend' : function(){
      	$('#post_text_id'). val('');
      	$('.inviteChk').removeAttr("checked");
        if(post_video == '')
          {            
            $('.custom-loader').css('display', 'flex');
          }
          else
          {
            exit_page = 0;
            $('#pstsubmit').prop('disabled', true);
            $('.modal-backdrop').hide();
            $('#post_video').val('');
            $('#video_name').html('');
            $('#remove_video').hide();
            $('#uploading_video').show();
            $('#uploaded_message').html('');
            $('#locationid').html('');
            $('#locationtxtid').val();
          }
      },
      //'async' : false,
      contentType: false,
      dataType : 'html',
      cache: false,
      processData:false,  
          
      'success': function(msg){ 
        //$('#pstsubmit').prop('disabled', false);
        $('#pstsubmit').removeAttr("disabled");
        if(msg == 1){
           window.location.href = "{{URL::Route('home')}}";              
        }
        if(msg == 2)
        {
           exit_page = 1;
           $('#uploading_video').hide();
           $('#success_message').show();
           $('#uploaded_message').html('Your video is being processed and will be published shortly');
           $('#success_message').delay(90000).hide(4000,'linear');
           $('#new_post_alert').css({ opacity: 1 });
        }

      }
    });
  }

  }));
  });





  function showPreview(objFileInput) {
  if (objFileInput.files[0]) {
  var fileType = objFileInput.files[0].type;
  var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/gif", "image/bmp"];

  if ($.inArray(fileType, ValidImageTypes) < 0) {                  
  /*var htmlMSG = 'Please upload only image file';
  $('#myModalFormMessage_message').html('');
  $('#myModalFormMessage_message').append(htmlMSG);
  $('#myModalFormMessage').modal('show'); */
   $.alert({
  title: 'Alert!',
  content: 'Please upload only image file',
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
  $('#postimgid').prev('label').html('{{ trans("common.drag_and_drop_your_files_here_or") }} <strong>{{ trans("common.browse") }}</strong>');
  return false;
  }else{

  var sizeKB = objFileInput.files[0].size / 1000;
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

  $('#postimgid').val('');
  $('#postimgid').prev('label').html('{{ trans("common.drag_and_drop_your_files_here_or") }}  <strong>{{ trans("common.browse") }}</strong>');
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

  $("#targetLayer").click(function () {
    $("#targetLayer").html('');
    $("#postimgid").val('');
  });
</script>
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
    //alert( "Request failed: Something went wrong. Please try again." );
    });
    });
    }else{
    console.log("Browser doesn't support geolocation!");
    }

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
<script> 

$( document ).on( "click", ".deletepost", function(event) {    
  var post_id =   $( this).attr( "alt" );
  var group_id = $( this).attr( "em" ); 
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this post?",
    buttons: {
      confirm: function () { 
      window.location.href ="{{URL::Route('posts_delete')}}"+'/'+post_id+ '/'+group_id+'/home';
      },
      cancel: function () {

      }
    }
  });              

});

$( document ).on( "click", ".deletecomment", function(event) {    
  var comment_id =   $( this).attr( "alt" );
  var group_id =  $( this).attr( "em" ); 
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this comments?",
    buttons: {
      confirm: function () { 
      window.location.href ="{{URL::Route('comments_delete')}}"+'/'+comment_id+ '/'+group_id+'/home';
      },
      cancel: function () {

      }
    }
  });              

});
</script> 
<!--  <script>

$('textarea.expand').focus(function () {
    $(this).animate({ height: "7em" }, 500);
});
$("textarea.expand").focusout(function() {
   $(this).animate({ height: "2.7em" }, 500);
});
</script>  -->
@endsection

@section('script')

@endsection
