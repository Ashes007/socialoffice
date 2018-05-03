@if(count($groups)>0)
  @foreach ($groups as $group)
  <?php  
  //echo $group->group_user_id;
  // $group_id = base64_encode($group->group_id + 100);
  $group_id = encrypt($group->group_user_id);
  ?>
  <div class="col-sm-4 col-xs-6">
    <div class="photo-single group-areas">
      <div class="group-img">
      <a href="{{URL::Route('group_details').'/'.$group_id}}">
      <?php if(file_exists( public_path('uploads/group_images/thumb/'.$group->cover_image) )&& ($group->cover_image!='' || $group->cover_image!=NULL)) {?>               
      <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/'.$group->cover_image) }}&w=356&h=200&q=100"  alt="" class="big-img" />
      <?php }else{ ?>
      <img src="{{ asset('frontend/images/no-image-event-list.jpg') }}"  class="big-img"/>
      <?php  } ?>
      </a>
      <!-- @if(request()->segment(2)!=''&& request()->segment(2)!='all')
      <img src="{{ asset('frontend/images/sg-1.jpg')}}" alt="" class="small-img"/> 
      @endif -->
      </div>
      <h3><a href="{{URL::Route('group_details').'/'.$group_id}}">{{ substr($group->group_name,0,52) }}  @if(strlen($group->group_name)>52) ... @endif</a></h3>
      <h5>{{ get_memeber_group( $group->group_user_id) }} {{trans('group.members')}}</h5>
      @php $group_desc = getDetailsGroupEvent($group->group_description) @endphp
      <p>@php echo substr($group_desc,0,80) @endphp @if(strlen($group->group_description)>80) ... @endif</p>
      <span class="week-active">{{trans('common.active')}} {{ active_memeber_group($group->created_at) }} {{trans('common.ago')}} / <label>
      @if($group_type!='all')
      {{ trans('group.'.$group_type)}} 
      @else
      @if($group->group_type_id==1) {{trans('group.global_group')}} {{trans('common.Groups')}} @elseif($group->group_type_id==2) {{trans('group.departmental_group')}} {{trans('common.Groups')}} @else {{trans('group.activity_group')}} {{trans('common.Groups')}} @endif
      @endif
      </label></span>
    </div>
  </div>
  @endforeach
@endif