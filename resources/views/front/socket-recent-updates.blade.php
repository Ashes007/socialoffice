 <div class="recent-block recent_update">
  <div class="image-div"><img src="{{ asset($profile_image) }}" alt=""></div>
  <h3><a href="{{URL::Route('user_profile').'/'.$user_id}}"> {{$user_name}} </a> {{$text}} <a href="{{$url}}">{{$textlink}}</a> {{ trans('home.on') }} {{ \DateTime::createFromFormat('Y-m-d H:i:s', $created_at)->format('dS M Y h:i A') }} </h3>
  </div> 