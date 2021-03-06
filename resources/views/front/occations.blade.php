@extends('front.layout.app')
@section('title','Tawasul')
@section('content')  

<div class="home-container">
  <div class="container">
    <div class="emDirectory-tiTle">
    <!-- <h2>Occasions</h2> -->
    </div>
  </div>
  <div class="emDirectory-wRapper">
    <div class="emDirectory-block">
      <div class="container">
      <!--+++++++++++++++++++   start ++++++++++++++++++++++-->
      @if(!empty($occationlists)) @php $i=0; @endphp
      @foreach($occationlists as $key=>$value)
      @php $i++; @endphp
        <div class="occasionsblock @if($i==1) active @endif">
          <div class="dating">
          <i class="fa fa-calendar" aria-hidden="true"></i>
          <span>@if($key == date('Y-m-d')) Today @else  {{ \DateTime::createFromFormat('Y-m-d', $key)->format('M, d (D)') }}  @endif</span>
          </div>
          <div class="owl-carousel">
            @if(!empty($value))
            @foreach($value as $val)

            @php

            $dob=explode('-',$val['date_of_birth']);
            $joindate=explode('-',$val['date_of_joining']);
            $keys = explode('-',$key);
           
            if((($keys[1].'-'.$keys[2])==($dob[1].'-'.$dob[2]))&& $val['field_type']=='DOB'){ $occasion='bday';}else{$occasion='anniversary';}
            @endphp
            <div class="item">
              <div class="emDirectory-block-single">
              @if($occasion=='bday')
              <div class="emailPop"><a id="linkidocc_{{$val['id']}}" alt="{{$val['id']}}" @if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'BDAY',$key)==0) class='occationcls'  href="{{URL::Route('occasion_birthday').'/'.$val['user_id'].'/'.\Auth::guard('user')->user()->id.'/'.$key.'/'.$val['id']}}" @endif><div id="occimgid_{{$val['id']}}">@if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'BDAY',$key)==0)<img src="{{ asset('frontend/images/b-1.png') }}" alt="">@else <img src="{{ asset('frontend/images/message-icon.png') }}" title="{{trans('home.Your_message_was_sent')}}" data-toggle="tooltip" data-placement="bottom" alt=""> @endif</div></a></div>
              @else
              <div class="emailPop spop"><a id="linkidocc_{{$val['id']}}" alt="{{$val['id']}}" @if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'ANNIVERSARY',$key)==0) class='occationcls'  href="{{URL::Route('occasion_anniversary').'/'.$val['user_id'].'/'.\Auth::guard('user')->user()->id.'/'.$key.'/'.$val['id']}}" @endif><div id="occimgid_{{$val['id']}}">@if(alreadywish($val['user_id'],\Auth::guard('user')->user()->id,'ANNIVERSARY',$key)==0)<img src="{{ asset('frontend/images/b-2.png') }}" alt="">@else <img src="{{ asset('frontend/images/message-icon.png') }}" title="{{trans('home.Your_message_was_sent')}}" data-toggle="tooltip" data-placement="bottom" alt=""> @endif</div></a></div>
              @endif
              <div class="blockSingle-img">
              @php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$val['profile_photo']) )&& ($val['profile_photo']!='' || $val['profile_photo']!=NULL)) { @endphp
              <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/').'/'.$val['profile_photo'] }}" alt="">
              @php }else{ @endphp
              <img src="{{ asset('frontend/images/no_user_thumb.png') }}"/>
              @php } @endphp
              </div>
              <div class="blockSingleCont">
              <h2><a href="@if($val['username']!=''){{URL::Route('user_profile').'/'.($val['username'])}} @else # @endif">{{$val['name']}}</a> <br> <span>{{$val['title']}}</span> </h2>
              <h3>@if($occasion=='bday') {{ trans('home.is_having_birthday')}} @else {{$joindate[0]}} - {{ trans('home.completed')}} {{date('Y')-$joindate[0]}} {{ trans('home.years')}} @endif</h3>
              </div>
              </div>
            </div>
            @endforeach
            @endif 
          </div>
        </div>
      @endforeach
      @endif
      <!--+++++++++++++++++++   end ++++++++++++++++++++++-->
      </div>
    </div>

  </div>
</div>
<!--  <div class="footer">
<div class="container">
<p>Copyright © Shurooq - All rights reserved</p>
</div>
</div> -->
<!-- owl javascript -->

<script src="{{ asset('frontend/js/owl.carousel.min.js')}}"></script>
<script>
//$('[data-toggle="tooltip"]').tooltip();
$(document).ready(function() {
$('.owl-carousel').owlCarousel({
loop: true,
margin: 10,
responsiveClass: true,
responsive: {
0: {
items: 1,
nav: true
},
767: {
items: 2,
nav: false
},
1000: {
items: 3,
nav: true,
loop: false,
margin: 20
}
}
})
})
</script>

<script src="{{ asset('frontend/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script type="text/javascript">
(function($){
$(window).on("load",function(){
$("#numMenu").mCustomScrollbar({
scrollButtons:{enable:true},
theme:"light-thick",
scrollbarPosition:"outside"
});
});
})(jQuery);

$('#controls li a').click(
function(e){
e.preventDefault();
var that = this,
$that = $(that),
id = that.id,
gallery = $('#gallery');
if (id == 'all') {
gallery.find('li:hidden').show(600);
}
else {
gallery.find('li.' + id + ':hidden').show(600);
gallery.find('li').not('.' + id).hide(600);
}
});
</script>
<script type="text/javascript">
$(document).ready(function(){
$('.panel').click(function() {
$('.slidemenu').toggleClass('clicked').addClass('unclicked');
$('.menubar_icon_black').toggleClass('menubar_icon_cross');
});
});
</script>


<script type="text/javascript">
/*$(document).ready(function() {
$(".cntlikecls").colorbox({innerWidth:500});
});*/

$(document).on('click','.occationcls',function(e) {
e.preventDefault();
$.colorbox({href : this.href});
});
</script>

</body>
@endsection
