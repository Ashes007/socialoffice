@extends('front.layout.event_app')
@section('title','Tawasul')
@section('content')
<div class="home-container createEventPopup">
@if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ Session::get('error') }}
        </div>  
@endif

        <section class="createEventSection">
            <div class="createEventSection-close">
                <a href="{{ URL::Route('event','month')}}">{{ trans('common.cancel') }}
                    <img src="{{ asset('frontend/images/btn-cancel.png')}}" alt="">
                
                </a>
            </div>

            <div class="container nonRelative">
                <!-- ========= Create Event Circle Container Start ========= -->

            <div class="msg">{{ Session::get('success') }}</div>

                <div class="fullHeight formstartContainer startForm">
                    <div class="absCont">
                        <div class="fixedfull"></div>
                        <div class="ceCircle">
                            <div class="cirlePoint">
                                <div class="cirlePointInn"></div>
                            </div>
                            <div class="ceTitle">{{ trans('createEvent.create_event') }}</div>
                        </div>
                        <!-- ========= Start Container Start ========= -->
                        <div class="startContainer">

                            <h1>{{ trans('createEvent.Start') }}</h1>
                            <div class="proceedContainer">
                                <h5>
                                    <a href="javascript:void(0)" id="formStart" class="ceBtnBlue pOSval">{{ trans('buttonTxt.proceed') }}</a> {{ trans('common.or') }}
                                    <span class="pressText">{{ trans('common.press') }}</span> {{ trans('common.enter') }}</h5>
                                <input type="text" style="width: 0;height: 0;border: none;" id="formstart" autofocus />
                            </div>
                        </div>
                    </div>
                </div>





                <!-- ========= Type Form Container Start ========= -->
                <div class="typeFormContainer">
                    <div class="formContainerInn ">


                        <form method="post" action="{{ URL::Route('add_event') }}" class="typeForm" name="eventForm" id="eventForm" enctype = "multipart/form-data" >
                        {{ csrf_field() }}
                            <ul class="formList mainForm">
                                <li class="formSection formInit">
                                    <div class="inputTitle">
                                        <span class="numberText">1</span>{{ trans('createEvent.What_is_your') }}
                                        <span class="textOne">{{ trans('createEvent.Event_Name') }}</span> *</div>
                                    <div class="inputField">
                                        <input id="startForm" name="eventName"  type="text" maxlength="150" class="formTextField enterinput" placeholder="">
                                        <p> {{ trans('common.Max_length_150_characters')}}</p>
                                    </div>
                                    <div class="proceedContainer spaceOne">
                                        <h5>
                                            <a href="javascript:void(0)" id="proceedFirst" class="ceBtnBlue proceedToNext">{{ trans('buttonTxt.proceed') }}</a> {{ trans('common.or') }}
                                            <span class="pressText">{{ trans('common.press') }}</span> {{ trans('common.enter') }}</h5>
                                    </div>
                                </li>
                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">2</span>{{ trans('createEvent.Can_you_provide_a') }}
                                        <span class="textOne">{{ trans('createEvent.Cover_Image') }} </span>{{ trans('createEvent.for_your_Event') }} *</div>
                                    <div class="inputField">
                                        
                                        <div class="fiLeCustom">
                                            <label for="file-upload" class="custom-file-upload">{{ trans('common.drag_and_drop_your_files_here_or') }}
                                                <strong>{{ trans('common.browse') }}</strong>
                                            </label>
                                            <input id="file-upload" name='upload_cont_img' type="file">
                                        </div>
                                        <p>{{ trans('common.Please_upload_image_file_with_width_greater_than_1280px_and_height_greater_than_382px_and_maximum_file_size_2MB') }} </p>


                                    </div>
                                    
                                </li>

                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">3</span>{{ trans('createEvent.Can_you_provide_a') }}
                                        <span class="textOne">{{ trans('createEvent.profile_image') }} </span>{{ trans('createEvent.for_your_Event') }} *</div>
                                    <div class="inputField">
                                        
                                        <div class="fiLeCustom">
                                            <label for="file-upload-profile" class="custom-file-upload">{{ trans('common.drag_and_drop_your_files_here_or') }}
                                                <strong>{{ trans('common.browse') }}</strong>
                                            </label>
                                            <input id="file-upload-profile" name='upload_profile_img' type="file">
                                        </div>
                                        <p>{{ trans('createEvent.Please_upload_image_file_width_less_than_300px_and_height_less_than_300px_and_maximum_file_size_2MB') }}</p>


                                    </div>
                                    
                                </li>
                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">4</span>{{ trans('createEvent.Write_something_about_your') }}
                                        <span class="textOne">{{ trans('createEvent.event') }}</span> *</div>
                                    <div class="inputField textareaOnly">
                                        <textarea name="description" id="description" class="formTextField textareaField enterinput" rows=""></textarea>
                                    </div>
                                    <div class="proceedContainer spaceOne">
                                        <h5>
                                            <a href="javascript:void(0)" class="ceBtnBlue proceedToNext">{{ trans('buttonTxt.proceed') }}</a> {{ trans('common.or') }}
                                            <span class="pressText">{{ trans('common.press') }}</span> {{ trans('common.enter') }}</h5>
                                    </div>
                                    
                                </li>
                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">5</span> {{ trans('createEvent.You') }} 
                                        <span class="textOne">{{ trans('createEvent.Creating') }}</span> {{ trans('createEvent.a') }} * </div>
                                    <div class="inputField eventType">
                                        <ul>
                                        @if(Auth::user()->can('add-global-event')==1 )
                                            <li class="eventOne eventTypeId" data-typeid="1">
                                                <h3>{{ trans('createEvent.Global') }}
                                                    <br>{{ trans('createEvent.Event') }}</h3>
                                            </li>
                                        @endif
                                        @if(Auth::user()->can('add-departmental-event')==1 )
                                            <li class="eventTwo eventTypeId" data-typeid="2">
                                                <h3>{{ trans('createEvent.Departmental') }}
                                                    <br>{{ trans('createEvent.Event') }}</h3>
                                            </li>
                                        @endif
                                        @if(Auth::user()->can('add-activity-event')==1 )
                                            <li class="eventThree eventTypeId" data-typeid="3">
                                                <h3>{{ trans('createEvent.Open') }}
                                                    <br>{{ trans('createEvent.Event') }}</h3>
                                            </li>
                                        @endif
                                        </ul>
                                        <input type="hidden" name="event_type" id="event_type">
                                    </div>
                                    <!-- <div class="proceedContainer spaceOne">
                                        <h5>
                                            <a href="javascript:void(0)" class="ceBtnBlue proceedToNext">Proceed</a>
                                        </h5>
                                    </div> -->
                                   
                                </li>
                                <li class="formSection formMove noAuto dmargin">
                                    <div class="inputTitle">
                                        <span class="numberText">6</span> {{ trans('createEvent.Where_are_you') }}
                                        <span class="textOne">{{ trans('createEvent.conducting') }}</span> {{ trans('createEvent.your_Event') }} *
                                    </div>
                                    <div class="inputField withArr">
                                        <input class="chosen-value formTextField enterinput" id="autocomplete" placeholder="{{ trans('createEvent.Type_or_select_an_option') }}" name="location" onFocus="geolocate()" type="text">
                                        
                                    </div>
                                    
                                </li>

                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">7</span> {{ trans('createEvent.When_you_are') }}
                                        <span class="textOne">{{ trans('createEvent.planning') }}</span> {{ trans('createEvent.to_conduct_the_event') }} *</div>
                                    <div class="spaceOne">
                                        <div class="datepickerTheme" id="datetimepicker1">
                                            <div class="dateHeader">
                                                <div class="clWeek">{{ trans('createEvent.Start_Date') }}</div>
                                                <div class="clDay" id="hidden-val1"></div>
                                            </div>
                                            <input type="hidden" name="date" id="my_hidden_input1" value="">
                                            <input type="hidden" name="event_start_date" id="event_start_date" >
                                            <input type="hidden" name="event_end_date" id="event_end_date" >
                                        </div>
                                        <div class="datepickerTheme" id="datetimepicker2">
                                            <div class="dateHeader">
                                              <div class="clWeek">{{ trans('createEvent.End_Date') }}</div>
                                              <div class="clDay" id="hidden-val2"></div>
                                            </div>
                                            <input type="hidden" name="date" id="my_hidden_input2" value="">
                                        </div>
                                    </div>
                                    
                                </li>

                                <li class="formSection formMove">
                                    <div class="inputTitle">
                                        <span class="numberText">8</span> {{ trans('createEvent.What_is_the') }}
                                        <span class="textOne">{{ trans('createEvent.Start_and_End') }}</span> {{ trans('createEvent.time_of_the_event') }} *
                                    </div>

                                    <div class="row">
                                        <div class="input-custom">
                                            <!-- <input id="check-1" type="checkbox" name="" value=""> -->
                                            <input id="checktime" name="allday_event" type="hidden" value="No">
                                            <div class="col-md-6">

                                                <div class="inp-custom">
                                                    <span class="typeTxt"></span>
                                                    <span class="qFday"> {{ trans('createEvent.Is_it_a_full_day_event') }} 
                                                        <span class="textOne" id="fullday_or"> -{{ trans('createEvent.OR') }} -</span></span>
                                                </div>

                                            </div>
                                            <div class="col-md-6 timer">
                                                <div class="spMb">
                                                    <div class="datepickerTheme forDate" id="datetimepicker3">
                                                        <div class="tmTxT">{{ trans('createEvent.Start_Time') }}</div>
                                                    </div>
                                                    <div class="datepickerTheme forDate" id="datetimepicker4">
                                                        <div class="tmTxT">{{ trans('createEvent.End_Time') }}</div>
                                                    </div>

                                                    <input type="hidden" name="start_time" id="start_time" value="">
                                                    <input type="hidden" name="end_time" id="end_time" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   
                                </li>

                               </ul>
                                <div class="subMit-bottom">
                            <div class="container">
                                <div class="proceedContainer">
                                    <h5>
                                        <input type="submit" value="{{ trans('buttonTxt.submit') }}" class="ceBtnBlue"> {{ trans('common.or') }}
                                        <span class="pressText" id="submitpresstxt">{{ trans('common.press') }}</span> {{ trans('common.enter') }}</h5>
                                        <input id="lastFocus" type="text" style="width:0; height:0; border-width: 0;">
                                </div>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
<script src="{{ asset('frontend/js/moment.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('frontend/js/index.js') }}"></script>



<script src="{{ asset('frontend/js/typescript.js') }}"></script>
<script type="text/javascript">

function currentTime()
{
    var date    = new Date();
    var hour    = date.getHours();
    var minute  = date.getMinutes();
    var endhour = hour+1;
    if(hour<10)
    {
        hour = '0'+hour;
    }
    if(endhour<10)
    {
        endhour = '0'+endhour;
    }
    if(minute<10)
    {
        minute = '0'+minute;
    }
    var time        = hour+':'+minute;
    var endtime     = endhour+':'+minute;
    $('#start_time').val(time);
    $('#end_time').val(time);
}

        $(document).ready(function(){
            //alert("hi");
            currentTime();
            $('#datetimepicker1, #datetimepicker2').datetimepicker({
                inline: true,
                format: 'DD/MM/YYYY',
                useCurrent: false,
                minDate: moment()
            });

            $('#datetimepicker1').on('dp.change', function (event) {
                $('#selected-date1').text(event.date);
                var formatted_date = event.date.format('DD');
                $('#my_hidden_input1').val(formatted_date);
                $('#hidden-val1').text($('#my_hidden_input1').val());
                var incrementDay = moment(new Date(event.date));
                //incrementDay.add(1, 'days');
                $('#datetimepicker2').data('DateTimePicker').minDate(incrementDay);

                var event_start_date = event.date.format('DD/MM/YYYY');
                $('#event_start_date').val(event_start_date);
            });
            $("#datetimepicker1").find(".dateHeader").html();

            // added new - 12/01/2018
            $('#datetimepicker2').on('dp.change', function (event) {
                $('#selected-date2').text(event.date);
                var formatted_date = event.date.format('DD');
                $('#my_hidden_input2').val(formatted_date);
                $('#hidden-val2').text($('#my_hidden_input2').val());
                 var decrementDay = moment(new Date(event.date));
                //decrementDay.subtract(1, 'days');
                $('#datetimepicker1').data('DateTimePicker').maxDate(decrementDay);

                var event_end_date = event.date.format('DD/MM/YYYY');
                $('#event_end_date').val(event_end_date);
                // setTimeout(function(){
                    $("#datetimepicker2").parent(".spaceOne").parent("li.formSection").next("li.formSection").click();
                // },1000);
                
            });
            $("#datetimepicker2").find(".dateHeader").html();
            // added new - 12/01/2018

            $('#datetimepicker3').datetimepicker({
                inline: true,
                format: 'LT'
                //format: 'HH:mm'
            });

            $(' #datetimepicker4').datetimepicker({
                inline: true,
                format: 'LT',   
                //defaultDate: moment(new Date()).hours(new Date().getHours()+1).minutes(new Date().getMinutes())             
                //format: 'HH:mm'
            });



            $('#datetimepicker3').on('dp.change', function (event) {
                var start_time = event.date.format('HH:mm');
                $('#start_time').val(start_time);
            });
            $('#datetimepicker4').on('dp.change', function (event) {
                var end_time = event.date.format('HH:mm');
                $('#end_time').val(end_time);
            });


            $('.eventTypeId').click(function(e){
                e.stopPropagation();
                $('.eventTypeId').removeClass('active');
                $(this).addClass('active');
                var typeid = $(this).attr('data-typeid');
                $('#event_type').val(typeid);
                // 2018-01-31
                $(this).closest("li.formSection").next("li.formSection").click();
                $(this).closest("li.formSection").next("li.formSection").find("input.enterinput").focus();
            });

   
        $('#file-upload').change(function () {
                var ths = $(this);
                var img_validate = 'No';
                var totalFile = this.files.length;
                for (var i = 0; i < totalFile; i++) {

                      var fileInfo = this.files[i];
                      var sizeKB = fileInfo.size / 1000;
                      sizeKB  = sizeKB.toFixed(1);
                      var fileType = fileInfo["type"];
                      var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png"];

                       if ($.inArray(fileType, ValidImageTypes) < 0) {
                            $.alert({
                                    title: '{{ trans('common.Alert') }}',
                                    content: '{{ trans('common.only_JPEG_JPG_PNG_are_allowed') }}',
                                    icon: 'fa fa-rocket',
                                    type: 'blue',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    animateFromElement: false,
                                    buttons: {
                                        okay: {
                                        text: '{{ trans('common.Okay') }}',
                                        btnClass: 'btn-blue'
                                        }
                                    }
                            });
                            $(this).val('');
                            return false;
                      }
                      else if(sizeKB > 2048){

                        $.alert({
                                    title: '{{ trans('common.Alert') }}',
                                    content: '{{ trans('common.uploaded_image_size_maximum_2MB_allowed') }}',
                                    icon: 'fa fa-rocket',
                                    type: 'blue',
                                    animation: 'scale',
                                    closeAnimation: 'scale',
                                    animateFromElement: false,
                                    buttons: {
                                        okay: {
                                        text: '{{ trans('common.Okay') }}',
                                        btnClass: 'btn-blue'
                                        }
                                    }
                                });


                        $(this).val('');
                        return false;
                      }
                      else
                      {
                            var _URL = window.URL || window.webkitURL;
                            var img = new Image();
                            img.src = _URL.createObjectURL(fileInfo);
                            img.onload = function() { 
                            imageWidth = this.width;
                            imageHeight = this.height;
  
                                if(imageWidth < parseInt(1250) || imageHeight < parseInt(200)){
                                    $.alert({
                                        title: '{{ trans('common.Alert') }}',
                                        content: '{{ trans('common.please_upload_image_file_with_width_greater_than_1280px_and_height_greater_than_382px') }}',
                                        icon: 'fa fa-rocket',
                                        type: 'blue',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        animateFromElement: false,
                                        buttons: {
                                            okay: {
                                            text: '{{ trans('common.Okay') }}',
                                            btnClass: 'btn-blue'
                                            }
                                        }
                                    });
                                    
                                    $('#file-upload').val('');
                                    $('#file-upload').prev('label').html('{{ trans('common.drag_and_drop_your_files_here_or')}}  <strong>{{ trans('common.browse')}}</strong>');
                                    return false;
                                }
                                else
                                {
                                   
                                    /* going to next section
                                   * as per the custom typescript.js clicking on  '.formSection' activate the current area
                                   * next line of code is to click on the next '.formSection'
                                   */
                                  ths.closest("li.formSection").next("li.formSection").click();
                                  $("#description").focus();
                                }
                            }
                      }

                }

                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);          
        });


        $('#file-upload-profile').change(function () {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload-profile')[0].files[0].name;
                $(this).prev('label').html(file);
              
                

                  var fileType = $('#file-upload-profile')[0].files[0].type;
                  
                  var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/gif", "image/bmp"];

                  if ($.inArray(fileType, ValidImageTypes) < 0) {
                   
                                var htmlMSG = 'Please upload only image file (jpg,jpeg,png,gif,bmp)';
                                $('#myModalFormMessage_message').html('');
                                $('#myModalFormMessage_message').append(htmlMSG);
                                $('#myModalFormMessage').modal('show'); 
                                //reset($('#file-upload'));
                               // $('#preview').attr('src', $baseURL + 'assets/images/icon/pre_img.png');

                               $.alert({
                                        title: '{{ trans('common.Alert') }}',
                                        content: htmlMSG,
                                        icon: 'fa fa-rocket',
                                        type: 'blue',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        animateFromElement: false,
                                        buttons: {
                                            okay: {
                                            text: '{{ trans('common.Okay') }}',
                                            btnClass: 'btn-blue'
                                            }
                                        }
                                });
                                

                                $(this).val('');
                                $(this).prev('label').html('Drag &amp; Drop your files here! or  <strong>browse</strong>');
                                return false;
                  }else{
                        var file = $('#file-upload-profile')[0].files[0];
                        var _URL = window.URL || window.webkitURL;
                        var img = new Image();
                        img.src = _URL.createObjectURL(file);
                        img.onload = function() { 
                            imageWidth = this.width;
                            imageHeight = this.height;                       
                            

                            if(imageWidth <= parseInt(300) && imageHeight<=parseInt(300)){
                              
                               if(imageWidth!=imageHeight) {
                                 var htmlMSG = 'Please upload a perfect squre image';

                                    $.alert({
                                            title: '{{ trans('common.Alert') }}',
                                            content: htmlMSG,
                                            icon: 'fa fa-rocket',
                                            type: 'blue',
                                            animation: 'scale',
                                            closeAnimation: 'scale',
                                            animateFromElement: false,
                                            buttons: {
                                                okay: {
                                                text: '{{ trans('common.Okay') }}',
                                                btnClass: 'btn-blue'
                                                }
                                            }
                                    });

                                    $('#file-upload-profile').val('');
                                    $('#file-upload-profile').prev('label').html('Drag &amp; Drop your files here! or  <strong>browse</strong>');
                                    return false;

                               }else{
                                var sizeKB = file.size / 1000;
                                  sizeKB  = sizeKB.toFixed(1);
                                  if(sizeKB > 2048)
                                  {
                                    var htmlMSG = 'Uploaded image size maximum 2MB allowed';

                               $.alert({
                                        title: '{{ trans('common.Alert') }}',
                                        content: htmlMSG,
                                        icon: 'fa fa-rocket',
                                        type: 'blue',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        animateFromElement: false,
                                        buttons: {
                                            okay: {
                                            text: '{{ trans('common.Okay') }}',
                                            btnClass: 'btn-blue'
                                            }
                                        }
                                });

                                    $('#file-upload-profile').val('');
                                    $('#file-upload-profile').prev('label').html('Drag &amp; Drop your files here! or  <strong>browse</strong>');
                                    return false;
                                  }
                                  $('#file-upload-profile').closest("li.formSection").next("li.formSection").click();
                              }
                                
                            } else {
                                
                                var htmlMSG = 'Please upload image file with width less than 300px and height less than 300px';

                               $.alert({
                                        title: '{{ trans('common.Alert') }}',
                                        content: htmlMSG,
                                        icon: 'fa fa-rocket',
                                        type: 'blue',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        animateFromElement: false,
                                        buttons: {
                                            okay: {
                                            text: '{{ trans('common.Okay') }}',
                                            btnClass: 'btn-blue'
                                            }
                                        }
                                });

                                $('#file-upload-profile').val('');
                                $('#file-upload-profile').prev('label').html('Drag &amp; Drop your files here! or  <strong>browse</strong>');
                                return false;
                            }
                        };
              }
              /* going to next section
               * as per the custom typescript.js clicking on  '.formSection' activate the current area
               * next line of code is to click on the next '.formSection'
               */
              

            });


        $(".fixedfull").click(function () {
            $("#formstart").focus();
        });
        $(".typeTxt").click(function (e) {
            e.stopPropagation();
            $(this).toggleClass('active');
            $(' #fullday_or').toggle();
            $(".timer").toggle();
            // $("#checktime").
            var hiddenField = $('#checktime'),
                val = hiddenField.val();
            hiddenField.val(val === "Yes" ? "No" : "Yes");
            $("#lastFocus").focus();
        });

        // $('#proceed').click(function(){
        //     $('#eventForm').submit();
        // });
        // ---------------------
         $('#lastFocus').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            //e.preventDefault();
            //return false;
            $('#eventForm').submit();
          }
        });
         // ----------------
        $('#eventForm').on('keyup keypress', function(e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) { 
            e.preventDefault();
            return false;
          }
        });
        // window.onload = function(){
            $("#formstart").focus();
        // };


        $("#eventForm").on('submit',(function(e){

                $eventName = $('#startForm').val();
                if($eventName == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_give_an_event_name') }} ',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $('#startForm').closest("li.formSection").click();
                    return false;
                }

                $file = $('#file-upload').val();

                if($file == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_upload_an_image') }} ',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $('#file-upload').closest("li.formSection").click();
                    return false;
                }

                $description = $('#description').val();
                if($description == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_write_something_about_your_event') }} ',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $('#description').closest("li.formSection").click();
                    return false;
                }

                $event_type = $('#event_type').val();
                if($event_type == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_select_an_event_type') }} ',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $('#event_type').parent(".eventType").closest("li.formSection").click();
                    return false;
                }

                $autocomplete = $('#autocomplete').val();
                if($autocomplete == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_select_an_option') }} ',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $('#autocomplete').closest("li.formSection").click();
                    return false;
                }

                $event_start_date = $('#event_start_date').val();
                if($event_start_date == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_choose_event_start_date') }}',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $("#event_end_date").closest("li.formSection").click();
                    return false;
                }

                $event_end_date = $('#event_end_date').val();
                if($event_end_date == '')
                {
                    $.alert({
                        title: '{{ trans('common.Alert') }}',
                        content: '{{ trans('createEvent.Please_choose_event_end_date') }}',
                        icon: 'fa fa-rocket',
                        type: 'blue',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        animateFromElement: false,
                        buttons: {
                            okay: {
                            text: '{{ trans('common.Okay') }}',
                            btnClass: 'btn-blue',
                            action: function(okay){
                                $(".jconfirm-light.jconfirm-open").remove();
                                return false;
                                }
                            }
                        }
                    });
                    $("#event_end_date").closest("li.formSection").click();
                    return false;
                }

                if($('#checktime').val() === 'No')
                {
                    $start_time = $('#start_time').val();
                    if($start_time == '')
                    {
                        $.alert({
                            title: '{{ trans('common.Alert') }}',
                            content: '{{ trans('createEvent.Please_choose_event_start_time') }}',
                            icon: 'fa fa-rocket',
                            type: 'blue',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            animateFromElement: false,
                            buttons: {
                                okay: {
                                text: '{{ trans('common.Okay') }}',
                                btnClass: 'btn-blue',
                                action: function(okay){
                                    $(".jconfirm-light.jconfirm-open").remove();
                                    return false;
                                    }
                                }
                            }
                        });
                        $("#checktime").closest("li.formSection").click();
                        return false;
                    }

                    $end_time = $('#end_time').val();
                    if($end_time == '')
                    {
                        $.alert({
                            title: '{{ trans('common.Alert') }}',
                            content: '{{ trans('createEvent.Please_choose_event_end_time') }}',
                            icon: 'fa fa-rocket',
                            type: 'blue',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            animateFromElement: false,
                            buttons: {
                                okay: {
                                text: '{{ trans('common.Okay') }}',
                                btnClass: 'btn-blue',
                                action: function(okay){
                                    $(".jconfirm-light.jconfirm-open").remove();
                                    return false;
                                    }
                                }
                            }
                        });
                        $("#checktime").closest("li.formSection").click();
                        return false;
                    }

                    if($start_time == $end_time)
                    {
                        $.alert({
                            title: '{{ trans('common.Alert') }}',
                            content: '{{ trans('createEvent.Start_time_and_end_time_cannot_be_same') }}',
                            icon: 'fa fa-rocket',
                            type: 'blue',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            animateFromElement: false,
                            buttons: {
                                okay: {
                                text: '{{ trans('common.Okay') }}',
                                btnClass: 'btn-blue'
                                }
                            }
                        });
                        return false;
                    }

                    if($start_time > $end_time)
                    {
                        $.alert({
                            title: '{{ trans('common.Alert') }}',
                            content: '{{ trans('createEvent.End_time_must_be_greater_than_start_time') }}',
                            icon: 'fa fa-rocket',
                            type: 'blue',
                            animation: 'scale',
                            closeAnimation: 'scale',
                            animateFromElement: false,
                            buttons: {
                                okay: {
                                text: '{{ trans('common.Okay') }}',
                                btnClass: 'btn-blue'
                                }
                            }
                        });
                        return false;
                    }
                }


         }));
        });
$("#autocomplete").change(function(){
    $(this).closest("li.formSection").next("li.formSection").click();
});

        // $("#eventForm").on('submit',(function(e){
        //           e.preventDefault();

        //             $.ajax({
        //                 'type'  : 'post',
        //                 'data'  : new FormData(this),
        //                 'url'   : BASE_URL+'/add-event',
        //                 contentType: false,
        //                 cache: false,
        //                 processData:false,
        //                 'success': function(msg){
        //                         console.log(msg);
        //                 }
        //           });
        //       }));
        $("#eventForm").find("ul li.formSection:last-child").click(function(){
            $("#lastFocus").focus();
        });
        $("#eventForm").find("ul li.formSection:last-child").find("input").change(function(){
            $("#lastFocus").focus();
        });

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5PfRGTq6z6QS3DW7pS3L6AVvUupeadNY&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script type="text/javascript">
              // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        //autocomplete.addListener('place_changed', fillInAddress);
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

@endsection
