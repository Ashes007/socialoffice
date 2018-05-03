<div class="side-nav1 slidemenu">
<button class="left_slide_btn panel"> <span class="menubar_icon_black" style="display: block;"> </span></button>
<?php
//echo Route::getCurrentRoute()->getPath().'@@';?>

  <ul>
    <li  @if(request()->segment(2)=='all') class="active" @endif>
    <a href="{{ URL::Route('group') }}/all">
    <img src="{{ asset('frontend/images/ic6.png') }}" alt=""/>
    <span>{{trans('group.all_group')}}</span>
    </a>
    </li>
    <li @if(request()->segment(2)=='global') class="active" @endif>
    <a href="{{ URL::Route('group') }}/global">
    <img src="{{ asset('frontend/images/ic7.png') }}" alt=""/>
    <span>{{trans('group.global_group')}}</span>
    </a>
    </li>
    <li @if(request()->segment(2)=='departmental') class="active" @endif>
    <a href="{{ URL::Route('group') }}/departmental">
    <img src="{{ asset('frontend/images/ic8.png') }}" alt=""/>
    <span>{{trans('group.departmental_group')}}</span>
    </a>
    </li>

    <li @if(request()->segment(2)=='own') class="active" @endif>
    <a href="{{ URL::Route('group') }}/own">
    <img src="{{ asset('frontend/images/ic9.png') }}" alt=""/>
    <span>{{trans('group.group_i_create')}}</span>
    </a>
    </li>

    <li @if(request()->segment(2)=='activity') class="active" @endif>
    <a href="{{ URL::Route('group') }}/activity">
    <i class="fa fa-weixin" aria-hidden="true"></i>
    <span>{{trans('group.activity_group')}}</span>
    </a>
    </li>

  </ul>
</div>