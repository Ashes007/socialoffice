<div class="custon-ani" >
  <div class="row">
  <div id="succmsg" style="color:green; padding:10px;text-align:center"></div>
    <div class="col-sm-12 dateaftersub" id="occasions">
    <?php $name= preg_replace('#<a.*?>([^>]*)</a>#i', '$1', member_name($user_id));?>
    <h2><i class="fa fa-birthday-cake" style="color:#a3c85b" aria-hidden="true"></i> {{trans('home.Happy_Birthday')}}!</h2>
      <form action="#">
      <div class="form-group">
        <div>
        <textarea class="occasions_textarea form-control" required="" name="post" id="bdpostid" placeholder="{{trans('common.wish')}} {{$name}} {{trans('home.a')}} {{trans('home.Happy_Birthday')}}!"> {{trans('home.Happy_Birthday')}} {{$name}}!</textarea>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="form-sub">
        @if(alreadywish($user_id,\Auth::guard('user')->user()->id,'BDAY',$occasion_date)==0) 
        <input type="button" value="{{trans('common.send')}}" class="bdaybtn"/> <!--<i class="fa fa-caret-right" aria-hidden="true"></i>-->
        @else
        {{trans('home.you_wrote')}} {{trans('home.on')}} {{$name}}'s {{trans('common.timeline')}}
        @endif
      </div>
      </form>
    </div>

  </div>
</div>
<script>
$(".bdaybtn").click(function () { 
  var $user_id = <?php echo $user_id;?>;
  var $login_user_id = <?php echo $login_user_id;?>;
  var $occasion_date ="<?php echo $occasion_date;?>";
  var uid            = "<?php echo $uid?>";
  var $text = $('#bdpostid').val();
  var $name ="{{$name}}";

  request = $.ajax({
  url: "{{URL::Route('occasion_birthday_submit')}}",
  type: "POST",                       
  data: {'user_id':$user_id,'login_user_id': $login_user_id,'text': $text,'occasion_date':$occasion_date,'_token':CSRF_TOKEN},                  
  });

  request.done(function(msg) {
    var res = msg.split("###");
    var post_id =res[1];
    $('.dateaftersub').html("<div class='datesub'>{{trans('home.Your_message_was_sent')}} </div>");
    $("#succmsg").html("<div class='succmsgcls'>{{trans('home.Thank_you_for_your_wish')}}!!</div")  ;
    $('#linkidocc_'+uid).removeAttr("href");
    $('#linkidocc_'+uid).removeAttr("class");
    $('#occimgid_'+uid).html('<img src="{{ asset("frontend/images/message-icon.png") }}" title="'+"{{trans('home.Your_message_was_sent')}}"+'" alt="">');
    var html = $("#commentsnwoccid_"+post_id).html();                       
    html = $("#commentsnwoccid_"+post_id).html(html+''+res[0]); 
    var cmnt_cnt = $("#cmntoccid_"+post_id).val();
    cmnt_cnt = parseInt(parseInt(cmnt_cnt)+parseInt(1));
    $("#cmncntocc_id_"+post_id).html(cmnt_cnt+" {{ trans('common.comments')}}")  ;  
    $("#cmntoccid_"+post_id).val(cmnt_cnt)   ;            
    //$("#commentsnwid").val(msg);
    $("#commentoccid_"+post_id).val( "" );            

  });
  request.fail(function(jqXHR, textStatus) {
  console.log( "Request failed: " + textStatus );
  });
});
</script>
<style>
/*#cboxContent{
border:4px solid #a3c85b !important;
}*/
#cboxContent i{
color:#a3c85b !important;
}
</style>