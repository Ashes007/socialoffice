<div class="side-nav1 slidemenu">
   <button class="left_slide_btn panel"> <span class="menubar_icon_black" style="display: block;"> </span></button>
     <ul>
         <li @if(isset($eventDay)) @if($eventDay == 'today') class="active" @endif @endif>
           <a href="{{ route('event', 'today') }}">
           <img src="{{ asset('frontend/images/ic1.png') }}" alt=""/>
           <span>{{ trans('eventList.today') }}</span>
         </a>
         </li>
         <li @if(isset($eventDay))  @if($eventDay == 'tomorrow') class="active" @endif @endif>
           <a href="{{ route('event', 'tomorrow') }}">
           <img src="{{ asset('frontend/images/ic2.png') }}" alt=""/>
           <span>{{ trans('eventList.tomorrow') }}</span>
         </a>
         </li>
         <li @if(isset($eventDay))  @if($eventDay == 'week') class="active" @endif @endif>
           <a href="{{ route('event', 'week') }}">
           <img src="{{ asset('frontend/images/ic3.png') }}" alt=""/>
           <span>{{ trans('eventList.this_week') }}</span>
         </a>
         </li>
         <li @if(isset($eventDay))  @if($eventDay == 'month') class="active" @endif @endif>
           <a href="{{ route('event', 'month') }}">
           <img src="{{ asset('frontend/images/ic4.png') }}" alt=""/>
           <span>{{ trans('eventList.this_month') }}</span>
         </a>
         </li>
         <li @if(isset($eventDay))  @if($eventDay == 'search') class="active" @endif @endif>
           <a href="javascript:void(0);" id="chooseDate1" data-toggle="modal" data-target="#searchSection">
           <img src="{{ asset('frontend/images/ic5.png') }}" alt=""/>
           <span>{{ trans('eventList.Choose_Date') }}</span>
         </a>
         </li>
         <li @if(isset($eventDay))  @if($eventDay == 'own') class="active" @endif @endif>
           <a href="{{ route('event', 'own') }}">
           <img src="{{ asset('frontend/images/ic9.png') }}" alt=""/>
           <span>{{ trans('eventList.Events_I_Created') }}</span>
         </a>
         </li>
     </ul>
</div>