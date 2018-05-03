<div class="col-lg-3 col-sm-4">
  <div class="left-sidebar">
    <div class="profile-image-block">
      <div class="profile-image">
      <div class="pro-edit"><a href="{{ URL::Route('update_profile')}}"><i class="fa fa-pencil" aria-hidden="true"></i></a></div>

      @if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo)))
      <a href="{{URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username}}" > <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo) }}" alt=""/></a>
      @else
      <a href="{{URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username}}"><img src="{{ asset('frontend/images/no_user_thumb.png') }}" alt=""/></a>
      @endif
      </div>
      <h2><a href="{{URL::Route('user_profile').'/'.\Auth::guard('user')->user()->ad_username}}" style="color:#fff">{{ \Auth::guard('user')->user()->display_name }}</a></h2>
      <p>
      {{ \Auth::guard('user')->user()->designation->name }} <br> 
      {{ \Auth::guard('user')->user()->department->name }}
      </p>
    </div>
  <div class="side-nav">
  <ul>

    <li class="active"><a href="{{ URL::Route('home')}}"><i class="fa fa-user" aria-hidden="true"></i> {{ trans('homeLeftMenu.news_feeds') }}</a></li>
    <li><a href="{{ URL::Route('event','month')}}"><i class="fa fa-calendar" aria-hidden="true"></i> {{ trans('homeLeftMenu.events') }}</a></li>
    <li><a href="{{ URL::Route('user_directory')}}"><i class="fa fa-handshake-o" aria-hidden="true"></i> {{ trans('homeLeftMenu.employee_directory') }}</a></li>
    <li><a href="{{ URL::Route('group')}}"><i class="fa fa-users" aria-hidden="true"></i> {{ trans('homeLeftMenu.groups') }}</a></li>
    <li><a href="{{ URL::Route('occasion')}}"><i class="fa fa-sign-language" aria-hidden="true"></i> {{ trans('homeLeftMenu.occasions') }}</a></li>

  </ul>
  </div>
  </div>
</div>