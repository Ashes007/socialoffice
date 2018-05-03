@extends('front.layout.app')
@section('title','Tawasul')
@section('content')


<div class="home-container">
  <div class="container">
    <div class="top-backs">
      <div class="timeline-photo rounded-ban">
      @if($userdetails->cover_photo != NULL && file_exists(public_path('uploads/user_images/cover_photo/' . $userdetails->cover_photo)))
      <img src="{{ asset('uploads/user_images/cover_photo/thumbnails/'.$userdetails->cover_photo) }}" alt="img" />
      @else
      <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}" alt=""/>
      @endif
      <div class="fixme newfix">
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
      </div>
    </div><br/>
    <div class="row">

      <div class="col-sm-4">
        <div class="right-sidebar clearfix pro-right">
            <div class="recentUpdates">
            <h2 class="white-bg">{{trans('common.about')}}</h2>
              <div class="cont-wrap">
                <div class="aboutS">
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.date_of_birth')}}</span></p></div>
                  <div class="col-sm-8"><p>@if($userdetails->date_of_birth!=NUll) {{  date("d F ",strtotime($userdetails->date_of_birth)) }} @else -NA- @endif</p>@if(isbirthday($userdetails->id)>0) <div class="emailPop1"><a id="linkidocc_1" @if(alreadywish($userdetails->id,\Auth::guard('user')->user()->id,'BDAY',date('Y-m-d'))==0) class='occationcls'  href="{{URL::Route('occasion_birthday').'/'.$userdetails->id.'/'.\Auth::guard('user')->user()->id.'/'.date('Y-m-d').'/1'}}" @endif><div id="occimgid_1"> @if(alreadywish($userdetails->id,\Auth::guard('user')->user()->id,'BDAY',date('Y-m-d'))==0)<img src="{{ asset('frontend/images/b-1.png') }}" alt="">@else <img src="{{ asset('frontend/images/message-icon.png') }}" title="{{trans('home.Your_message_was_sent')}}" alt=""> @endif</div></a></div> @endif</div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.date_of_joining')}}</span></p></div>
                  <div class="col-sm-8"><p>@if($userdetails->date_of_joining!=NUll) {{  date("d F Y ",strtotime($userdetails->date_of_joining)) }} @else -NA- @endif</p>
                    
                  @if(isanniversary($userdetails->id)>0) <div class="emailPop1 spop"><a id="linkidocc_2" @if(alreadywish($userdetails->id,\Auth::guard('user')->user()->id,'ANNIVERSARY',date('Y-m-d'))==0) class='occationcls'  href="{{URL::Route('occasion_anniversary').'/'.$userdetails->id.'/'.\Auth::guard('user')->user()->id.'/'.date('Y-m-d').'/2'}}" @endif><div id="occimgid_2"> @if(alreadywish($userdetails->id,\Auth::guard('user')->user()->id,'ANNIVERSARY',date('Y-m-d'))==0)<img src="{{ asset('frontend/images/b-2.png') }}" alt="">@else <img src="{{ asset('frontend/images/message-icon.png') }}" title="{{trans('home.Your_message_was_sent')}}" alt=""> @endif</div></a></div> @endif
                  </div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.designation')}}</span></p></div>
                  <div class="col-sm-8"><p>{{$userdetails->title}}</p></div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.department')}}</span></p></div>
                  <div class="col-sm-8"><p>{{$userdetails->department->name}}</p></div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.company')}}</span></p></div>
                  <div class="col-sm-8"><p>{{$userdetails->company->name}}</p></div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.phone')}}</span></p></div>
                  <div class="col-sm-8"><p>{{$userdetails->mobile}}</p></div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-4"><p><span>{{trans('userProfile.email')}}</span></p></div>
                  <div class="col-sm-8"><p>{{$userdetails->email}}</p></div>
                  </div>
                  </div>
                  <div class="aboutS-Single">
                  <div class="row">
                  <div class="col-sm-12"><p style="border-bottom:1px solid #d1d1d1; padding-bottom:5px;"><span>{{trans('common.description')}}</span></p></div>
                  <div class="col-sm-12"><p style="padding-top:5px;">{{$userdetails->description}}</p></div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          <div class="recentUpdates group">
          <h2>{{ $userdetails->display_name }}'s {{trans('common.Groups')}}</h2>
            <div class="cont-wrap">
              <div class="cont-wrap-main">
              @if(count($mygroups)>0)
              @foreach($mygroups as $mygroup)
                <div class="recent-block">
                <?php           
                $group_id = encrypt($mygroup->group_user_id);
                ?>
                <div class="image-div">
                <a href="{{URL::Route('group_details').'/'.$group_id}}">
                <?php if(file_exists( public_path('uploads/group_images/profile_image/'.$mygroup->profile_image) )&& ($mygroup->profile_image!='' || $mygroup->profile_image!=NULL)) {?>
                <img src="{{ asset('uploads/group_images/profile_image/').'/'.$mygroup->profile_image }}" alt="" />
                <?php }else{ ?>
                <img src="{{ asset('frontend/images/no-image-event-details.jpg') }}" />
                <?php  } ?>

                </a></div>
                <h4><a href="{{URL::Route('group_details').'/'.$group_id}}">{{$mygroup->group_name}}</a></h4>
                <!--<div class="user-on-stat"><i class="fa fa-user" aria-hidden="true"></i></div>-->
                </div>
              @endforeach
              @else
                <div class="recent-block nocolor">
                {{ trans('homeRight.Oops_You_do_not_have_any_Groups') }}
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
      @if (session('success'))
      <div class="alert alert-success">
      {{ session('success') }}
      </div>
      @endif
        <div id="results">
        @include('front.users.data-profile')
        </div>
        <div class=" ajax-loading"><img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>{{trans('common.load_more')}}...</span></div>

      </div>

      </div>

    </div>
  </div>
</div>
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
  $('.ajax-loading').html('<div class="timelineBlock">   <div class="nofeedcls" style="margin:0px;text-align:center;">   <div class="message">'+"{{trans('home.We_Look_Forward_to_your_first_post')}}"+'</div>  </div>  </div>');
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
  $('.ajax-loading').html('<div class="timelineBlock">   <div class="form_submit_msg nofeedcls" style="margin:0px">   <div class="message">'+"{{trans('home.We_Look_Forward_to_your_first_post')}}"+'</div>  </div>  </div>');
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
  // alert('No response from server');
  });
}
</script>
<script type="text/javascript">
$(document).ready(function() {
$( document ).on( "keypress", ".cmntcls", function(event) { 
//$(".cmntcls").keypress(function(event) {
// alert(1);
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

      $("#cmncnt_id_"+post_id).html(cmnt_cnt+" {{ trans('common.comments')}}")  ;  
      $("#cmntid_"+post_id).val(cmnt_cnt)   ;            
      //$("#commentsnwid").val(msg);
      $("#commentid_"+post_id).val( "" );
    });

    request.fail(function(jqXHR, textStatus) {
    // console.log( "Request failed: " + textStatus );
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

//$(".face-like").click(function () { alert('@@');
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
      $("#likecnt_id_"+post_id).html(like_cnt+" {{ trans('common.likes')}} ")  ;
      $("#likeid_"+post_id).val(like_cnt)   ;  
    }else {
      $("#lkid_"+post_id).removeClass("active_lk");
      var like_cnt = $("#likeid_"+post_id).val(); 
      like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
      $("#likecnt_id_"+post_id).html(like_cnt+" {{ trans('common.likes')}} ")  ;
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
        $("#likeocccnt_id_"+post_id).html(like_cnt+" {{ __('common.likes')}} ")  ;
        $("#likeoccid_"+post_id).val(like_cnt)   ;  
      }else {
        $("#lkoccid_"+post_id).removeClass("active_lk");
        var like_cnt = $("#likeoccid_"+post_id).val(); 
        like_cnt = parseInt(parseInt(like_cnt)-parseInt(1));
        $("#likeocccnt_id_"+post_id).html(like_cnt+" {{ __('common.likes')}} ")  ;
        $("#likeoccid_"+post_id).val(like_cnt)   ; 
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
/*.notification-div{
margin-top:9px!important;
}*/
</style>
<script type="text/javascript">
/*$(document).ready(function() {
$(".cntlikecls").colorbox({innerWidth:500});
});*/
$(document).on('click','.occationcls',function(e) {
e.preventDefault();
$.colorbox({href : this.href});
});
</script>
<script> 

$( document ).on( "click", ".deletepost", function(event) {    
  var post_id  = $( this).attr( "alt" );
  var group_id = $( this).attr( "em" ); 
  var user_name  = "<?php echo $ad_username?>";
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this post?",
    buttons: {
      confirm: function () { 
      window.location.href ="{{URL::Route('posts_delete')}}"+'/'+post_id+ '/'+group_id+'/profile/'+user_name;
      },
      cancel: function () {

      }
    }
  });              

});

$( document ).on( "click", ".deletecomment", function(event) {    
  var comment_id =   $( this).attr( "alt" );
  var group_id =  $( this).attr( "em" ); 
  var user_name  = "<?php echo $ad_username?>";
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this comments?",
    buttons: {
      confirm: function () { 
      window.location.href ="{{URL::Route('comments_delete')}}"+'/'+comment_id+ '/'+group_id+'/profile/'+user_name;
      },
      cancel: function () {

      }
    }
  });              

});
</script> 
@endsection
