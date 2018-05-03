 @if($eventList->count())
              @foreach($eventList as $event)
         	<div class="col-sm-4 col-xs-6">
           <div class="photo-single group-areas">
             <div class="group-img">
             	<a href="{{ route('event_details', encrypt($event->id)) }}">
               @if(count($event->eventImage) && file_exists(public_path('uploads/event_images/original/'.$event->eventImage[0]->image_name))) 
                        <img src="{{ asset('timthumb.php') }}?src={{ asset('uploads/event_images/original/'.$event->eventImage[0]->image_name) }}&w=356&h=200&q=100" alt="" class="big-img rounded">                       
                        @else
                        <img src="{{ asset('frontend/images/no-image-event-list.jpg') }}" alt="" class="big-img rounded">
                       @endif 
              </a>
             </div>
             <div class="eve-area">
             <div class="dates"><span>{{ \Carbon\Carbon::parse($event->event_start_date)->format('M') }}</span> {{ \Carbon\Carbon::parse($event->event_start_date)->format('d') }}</div>
             <div class="eve-right">
             <h3><a href="{{ route('event_details', encrypt($event->id)) }}">{!! str_limit($event->name,8,'...') !!}
             
                @if($event->event_start_date > $today)
                  @if($event->getStatus($event->id) == 1 || $event->getStatus($event->id) == 4)
                      <span> - {{ trans('common.attending') }}</span> 
                    @elseif($event->getStatus($event->id) == 2 || $event->getStatus($event->id) == 6)
                      <span class="not"> - {{ trans('common.not_attending') }}</span>
                  @endif
                @endif
             
             </a></h3>
             <h5 class="location">
             @if( $today > $event->event_end_date )
                    <i class="fa fa-hourglass-start"></i>{{ trans('common.ended') }}  
             @else
               @if($event->allday_event =='Yes') 
                  @if($event->event_start_date == date('Y-m-d')) 
                    <i class="fa fa-hourglass-start"></i>{{ trans('common.started') }} 
                  @else 
                    Allday Event 
                  @endif 
               @else  
                  <i class="fa fa-clock-o" aria-hidden="true"></i><span class="timeCounter" data-time="{{ $event->event_start_date }} {{ $event->start_time }}">{{ $event->start_time }} - {{ $event->end_time }}  </span> 
                @endif
              @endif
              </h5>
             <h5 class="location"><i class="fa fa-map-marker"></i>{{ str_limit($event->location,30,'...') }}</h5>
             </div>
             <div class="clear"></div>
             <div class="button_section">
             
                @if($event->event_start_date <= $today)
                
                    @if($event->getStatus($event->id) == 1)
                        <div class="attend_status_button">{{ trans('buttonTxt.attended') }}</div>
                    @elseif($event->getStatus($event->id) == 2)
                        <div class="attend_status_button not">{{ trans('buttonTxt.not_attended') }}</div>
                    @elseif($event->getStatus($event->id) == 3)
                        <div class="attend_status_button">{{ trans('buttonTxt.tentative') }}</div>
                    @elseif($event->getStatus($event->id) == 4)
                        <div class="attend_status_button">{{ trans('buttonTxt.interested') }}</div>
                    @elseif($event->getStatus($event->id) == 4)
                        <div class="attend_status_button not">{{ trans('buttonTxt.not_interested') }}</div>
                    @elseif($event->getStatus($event->id) == 6)
                       <div class="attend_status_button not">{{ trans('buttonTxt.not_attended') }}</div>
                    @else
                      <div class="attend_status_button not">{{ trans('buttonTxt.not_attended') }}</div>
                    @endif
                
               @else
                
                  @if($event->event_end_date > $today)
                    @if($isInvited > 0)
                        @if($event->getStatus($event->id) == 1 || $event->getStatus($event->id) == 4)
                                <a href="javascript:void(0);" class="not_go event_response .canBtn" data-eventId = "{{ $event->id }}" data-status="6">{{ trans('buttonTxt.not_attend') }}</a>
                            @elseif($event->getStatus($event->id) == 2 || $event->getStatus($event->id) == 5 || $event->getStatus($event->id) == 6)
                                <a href="javascript:void(0);" class="go event_response atndBtn" data-eventId = "{{ $event->id }}" data-status="1">{{ trans('buttonTxt.attend') }}</a>
                            @elseif($event->getStatus($event->id) == 3)
                              <a href="javascript:void(0);" class="go event_response intBtn" data-eventId = "{{ $event->id }}" data-status="1">{{ trans('buttonTxt.interested') }}</a>
                              <a href="javascript:void(0);" class="not_go event_response intBtn" data-eventId = "{{ $event->id }}" data-status="6">{{ trans('buttonTxt.not_interested') }}</a>
                            @else

                            <a href="javascript:void(0);" class="go event_response event_btn" data-eventId = "{{ $event->id }}" data-status="1">{{ trans('buttonTxt.attending') }}</a>
                             <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $event->id }}" data-status="2">{{ trans('buttonTxt.not_attending') }}</a>
                             <a href="javascript:void(0);" class="not_go event_response event_btn" data-eventId = "{{ $event->id }}" data-status="3">{{ trans('buttonTxt.tentative') }}</a>
                          @endif
                       @endif
                   @endif                
                @endif
             
             </div>
             </div>
           </div>
         </div>

         @endforeach
         @else
              <div class="col-sm-4">
                  {{ trans('eventList.No_more_events') }}
              </div>

         @endif