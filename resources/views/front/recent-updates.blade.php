@extends('front.layout.app')
@section('title','Tawasul')
@section('content')
<div class="home-container">
  <div class="container">
    <div class="row">
    @include('front.includes.home_left')
    <div class="col-lg-6 col-sm-5"><h2 class="c-recent">Recent Updates</h2>
      <div class="timeline-blockMain">
      <div id="results">
      @include('front.data-recent-updates')
      </div>
      </div>
    <div class=" ajax-loading" style="text-align: center;"><img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>{{ trans('common.load_more') }}</span></div>
    </div>
    @include('front.includes.home_right')
    </div>
  </div>
</div>
<script>
  var page = 1; //track user scroll as page number, right now page number is 1
  load_more(page);
  $(window).scroll(function() { //detect page scroll  
  if($(window).scrollTop() + $(window).height()+10 >= $(document).height()) { //if user scrolled from top to bottom of the page   
  page++; //page number increment
  load_more(page); //load content   
  }
  }); 
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
    //alert(data);
    //alert(data.length);
    if(data.length == 0){
    console.log(data.length);

    //notify user if nothing to load
    if(page==1){
    $('.ajax-loading').html("<div class='form_submit_msg'> <div class='succ_img'><img src="+"{{ asset('frontend/images/opps.png')}}"+"></div>  <div class='message'> {{ trans('group.no_recent_updates') }}</div>  </div>");
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
  $(".cmntcls").keypress(function(event) {
    if(event.which == 13) {
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
@section('script')
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
@endsection
