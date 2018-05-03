@extends('front.layout.event_app')
@section('title','Tawasul')
@section('content')


   <div class="home-container">
     <div class="container">

       @include('front.includes.event_sidebar')
       @include('front.includes.event_header')



       @if(Session::has('success'))
       <div class="form_submit_msg">
        <div class="succ_img"><img src="{{ asset('frontend/images/success.png')}} "></div>
            <div class="congratulation">{{ trans('common.thank_you') }}</div>
            <div class="message">{{ Session::get('success') }}</div>
        </div>
       @endif
    @if (session('error'))
     <div class="form_submit_msg">                  
            <div class="message">{{ session('error') }}</div>
    </div>
   
    @endif
       
       <div id="exTab2">

			<div class="tab-content cal-con event-boxss ">
			  <div class="tab-pane active">
          <div class="row event_section">

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
                    {{ trans('common.allday_event') }} 
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

            @if($eventDay == 'own')                
                <div class="no_event_show col-sm-12">  
                                
                  <div class="no_envent_message">
                  <div class="first_line">{{ trans('eventList.you_have_not_created_any_event_till_date') }}</div>                  
                  </div>
              </div>
            @else

              <div class="no_event_show col-sm-12"> 
                  
                  <div class="no_envent_message">
                  <div class="first_line">{{ trans('eventList.No_even_Schedule_fornow_please_check_at_later_date') }} </div>
                  <!-- <div class="second_line">Please check at a later date</div> -->
                  </div>
              </div>
            @endif
         @endif



 </div>
</div>


			</div>
      <div class="loadings" data-offset="{{ $limit }}" data-event="{{ $eventDay }}" data-from ="{{ $fromDate }}" data-end="{{ $toDate }}" ><div id="loading" style="display: none;"><img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>{{ trans('common.load_more') }}...</span></div></div>
  </div>
</div>
</div>




  @endsection

  @section('script')
  <script src="{{ asset('frontend/js/jquery.countdown.js') }}"></script>
  <script type="text/javascript">

    $( ".timeCounter" ).each(function( index ) {
      var ths = $(this);
      var date = ths.attr('data-time');
      var newDate = new Date(); 
      newDate = new Date(date); 
      ths.countdown(newDate, function(event) {
        if(event.strftime('%D') === '00')
        {
          ths.text(
            event.strftime('%H:%M:%S')
          ); 
          ths.parent('h5').addClass('timer date-red');
          ths.parent('h5').removeClass('location');
          ths.parent().parent().parent().find('.dates').addClass('date-red');
        }

        if(event.strftime('%H:%M:%S') === '00:00:00')
        {
          ths.text('Started'); 
          ths.parent().find('i').addClass('fa fa-hourglass-start');
          ths.parent().find('i').removeClass('fa-clock-o');
          ths.parent('h5').removeClass('date-red');
        }      
      });
    });


 $(window).scroll(function(){  
    if ($(window).scrollTop() + $(window).height() +10 >= $(document).height()){        
        event_load();        
    }
 });

@if($eventList->count() >0)
  var load = 'Yes';
@else
  var load = 'No';
@endif
 function event_load()
 {
    if(load == 'No')
      return false;
  var ths     = $('.loadings');
  var offset  = ths.attr('data-offset');
  var event   = ths.attr('data-event');
  var from   = ths.attr('data-from');
  var end   = ths.attr('data-end');

  var newOffset = parseInt(offset) + {{ $limit }};
     $.ajax({
      'type'  : 'POST',
      'data'  : {offset: offset, event: event, from:from, end:end },
      'url'   : BASE_URL+'/event_ajax_list',
      'async' : false,
      'beforeSend': function(){
        $('#loading').show();
      },
      'success': function(msg){
        if(msg == 0)
        {
            load = 'No';
            ths.hide();
            $('.event_section').after('<div class="no_envent_message nogroupcls" style=" display:block;">--- {{ trans('eventList.Event_List_End_Here') }}  ---</div>');
        }
        else
        {
          $('.event_section').append(msg);        
        }
        
        ths.attr('data-offset', newOffset);


        $( ".timeCounter" ).each(function( index ) {
          var ths = $(this);
          var date = ths.attr('data-time');
          var newDate = new Date(); 
          newDate = new Date(date); 
          ths.countdown(newDate, function(event) {
            if(event.strftime('%D') === '00')
            {
              ths.text(
                event.strftime('%H:%M:%S')
              ); 
              ths.parent('h5').addClass('timer date-red');
              ths.parent('h5').removeClass('location');
              ths.parent().parent().parent().find('.dates').addClass('date-red');
            }

            if(event.strftime('%H:%M:%S') === '00:00:00')
            {
              ths.text('Started'); 
              ths.parent().find('i').addClass('fa fa-hourglass-start');
              ths.parent().find('i').removeClass('fa-clock-o');
              ths.parent('h5').removeClass('date-red');
            } 
            $('#loading').hide();     
          });
        });

      }

   });

  }
 
  </script>

  <style type="text/css">
  .eventName{
    white-space: nowrap; 
    width: 100px; 
    overflow: hidden;
    text-overflow: ellipsis;
  }
  </style>

  @endsection
