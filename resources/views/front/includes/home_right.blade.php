<div class="col-lg-3 col-sm-3">
  <div class="right-sidebar clearfix">
  
  	@if(count($occasions)>0)
    <div class="recentUpdates group occasion" id="rsidebar">
    <h2>Occasions</h2>
      <div class="cont-wrap">
        <div class="cont-wrap-main">
          <div id="scrollbar1" class="custom-scroll">
            <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
            <div class="viewport">
              <div class="overview">@php $i=0;@endphp
              
                @foreach($occasions as $occasion)

                <div class="recent-block">
                  <div class="image-div">
                  @php $i++;
                  $dob=explode('-',$occasion->date_of_birth);
                  $joindate=explode('-',$occasion->date_of_joining);
                  if($occasion->field_type=='DOB') { $occ= 'bday';}else{ $occ='anniversary';}
                  if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$occasion->profile_photo) ) && ($occasion->profile_photo!='' || $occasion->profile_photo!=NULL)) { @endphp
                  <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/').'/'.$occasion->profile_photo }}" alt="">
                  @php }else{ @endphp
                  <img src="{{ asset('frontend/images/no_user_thumb.png') }}"/>
                  @php } @endphp
                  </div>
                  <h4><a href="{{URL::Route('user_profile').'/'.$occasion->ad_username}}">{{$occasion->display_name}} </a><br> <span>{{$occasion->title}}</span></h4>
                  <p>@if($occ=='bday') {{ trans('home.having')}} {{ trans('home.birthday')}} @else {{ trans('home.completed')}} {{date('Y')-$joindate[0]}} {{ trans('home.years')}} @endif</p>
                    @if($occ=='bday')
                      <div class="emailPop"><a id="linkidocc_{{$i}}" @if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'BDAY',date('Y-m-d'))==0) class='occationcls'  href="{{URL::Route('occasion_birthday').'/'.$occasion->id.'/'.\Auth::guard('user')->user()->id.'/'.date('Y-m-d').'/'.$i}}" @endif><div id="occimgid_{{$i}}"> @if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'BDAY',date('Y-m-d'))==0)<img src="{{ asset('frontend/images/b-1.png') }}" alt="">@else <img src="{{ asset('frontend/images/message-icon.png') }}" title="{{trans('home.Your_message_was_sent')}}" alt=""> @endif</div></a></div>
                    @else
                      <div class="emailPop spop" style="background: #f29134 !important;"><a id="linkidocc_{{$i}}" @if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'ANNIVERSARY',date('Y-m-d'))==0) class='occationcls'  href="{{URL::Route('occasion_anniversary').'/'.$occasion->id.'/'.\Auth::guard('user')->user()->id.'/'.date('Y-m-d').'/'.$i}}" @endif><div id="occimgid_{{$i}}">@if(alreadywish($occasion->id,\Auth::guard('user')->user()->id,'ANNIVERSARY',date('Y-m-d'))==0)<img src="{{ asset('frontend/images/b-2.png') }}" alt="">@else <img src="{{ asset('frontend/images/message-icon.png') }}" title="{{trans('home.Your_message_was_sent')}}" alt=""> @endif</div></a></a></div>
                    @endif
                </div>
                @endforeach
              </div>
            </div>
          </div> 
        <!-- -->
        </div>
      </div>
    <div class="btn_view"><a href="{{ URL::Route('occasion')}}" class="view_all"><i class="fa fa-eye"></i> {{ trans('homeRight.View_All') }}</a></div>
    </div>
    @endif
    
    <div class="recentUpdates grouping">
    <h2>{{ trans('homeRight.Recent_Updates') }}</h2>
    @if(!empty($recent_updates))
    <div class="cont-wrap">
      <div class="cont-wrap-main recent_update_section">

      @foreach($recent_updates as $updates)
      <div class="recent-block recent_update">
      <div class="image-div"><img src="{{ asset($updates['profile_image']) }}" alt=""></div>
      <h3><a href="{{URL::Route('user_profile').'/'.($updates['user_id'])}}"> {{$updates['user_name']}} </a> {{$updates['text']}} <a href="{{$updates['url']}}">{{$updates['textlink']}}</a> {{ trans('home.on') }} {{ \DateTime::createFromFormat('Y-m-d H:i:s', $updates['created_at'])->format('dS M Y h:i A') }} </h3>
      </div> 
      @endforeach
      </div>
    </div>
    <div class="btn_view"><a href="{{ URL::Route('recent_updates')}}" class="view_all"><i class="fa fa-eye"></i> {{ trans('homeRight.View_All') }}</a></div>
    @else
    <div class="cont-wrap">
      <div class="cont-wrap-main nocolor">
      {{ trans('homeRight.Oops_You_do_not_have_any_Recent_updates') }}
      </div>
    </div>  
    @endif 
    </div>
    
    <div class="recentUpdates group mygrouping">
    <h2>{{ trans('homeRight.My_Groups') }}</h2>
    @if(count($mygroups)>0)
    <div class="cont-wrap">
      <div class="cont-wrap-main">
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
          <img src="{{ asset('frontend/images/no-image-event-list.jpg') }}" />
          <?php  } ?>
          </a>
        </div>
        <h4><a href="{{URL::Route('group_details').'/'.$group_id}}">{{substr($mygroup->group_name,0,20)}} @if( strlen($mygroup->group_name)>20) ... @endif</a></h4>
        </div>
        @endforeach
      </div>
    </div>
    <div class="btn_view"><a href="{{ URL::Route('group')}}" class="view_all"><i class="fa fa-eye"></i> {{ trans('homeRight.View_All') }}</a></div>
    @else
    <div class="cont-wrap">
      <div class="cont-wrap-main nocolor">
      {{ trans('homeRight.Oops_You_do_not_have_any_Groups') }}
      </div>
    </div>
    @endif
    </div>
    
  </div>
</div>
<script type="text/javascript">
/*$(document).ready(function() {
$(".cntlikecls").colorbox({innerWidth:500});
});*/
$(document).on('click','.occationcls',function(e) {
e.preventDefault();
$.colorbox({href : this.href});
});
</script>