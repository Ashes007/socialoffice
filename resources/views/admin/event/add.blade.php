@extends('admin/innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{ $management.' '.$pageType }} </h1>
      <ol class="breadcrumb">
          @foreach($breadcrumb['CREATEPAGE'] as $eachBreadcrumb)
              @if($loop->first)
                  <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              @endif
              @if($eachBreadcrumb['url'] == 'THIS')
                  <li>{{ $eachBreadcrumb['label'] }}</li>    
              @else
                  <li><a href="{{ $eachBreadcrumb['url'] }}">{{ $eachBreadcrumb['label'] }}</a></li>  
              @endif                                                        
          @endforeach        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket">
          <!--
            <div class="box-header">     
            </div>
           --> 

            @include('admin.includes.messages')
            <!-- /.box-header -->
            <!-- form start -->
            <form method ="post" class="form-horizontal form-validate" action="" enctype="multipart/form-data">
            {{ csrf_field() }}

              <div class="box-body">
              
              <div class="row">
              
              <div class="col-md-12">
              @foreach($lang_locales as $lang)
              
              <fieldset class="scheduler-border">
              <legend class="scheduler-border">Language: {{ $lang->language_name }} <span>*</span></legend
              ><div class="row">  
              <div class="col-md-12">         
                <div class="form-group">
                  <label for="name" class="col-sm-12 col-md-3 col-lg-2 control-label"> Name <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
										<input type="text" class="form-control required @if($lang->code == 'ar') arbic_lang @endif" name="name[{{ $lang->code }}]" value="{{ old('name.'.$lang->code) }}"  placeholder="Event Name" required="required">
                  </div>
                </div>
                
                </div>
                
									

                <div class="col-md-12">         
                <div class="form-group textares">
                  <label for="name" class="col-sm-12 col-md-3 col-lg-2 control-label"> Description <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
										<textarea class="summernote @if($lang->code == 'ar') arbic_lang @endif" name="description[{{ $lang->code }}]">{{ old('description.'.$lang->code) }}</textarea>
                  </div>
                </div>                
                </div>  

                 <!-- <div class="col-md-12">         
                    <div class="form-group textares">
                      <label for="name" class="col-sm-12 col-md-3 col-lg-2 control-label"> Short Description <span>*</span></label>

                      <div class="col-sm-12 col-md-9 col-lg-10">
                        <textarea class="@if($lang->code == 'ar') arbic_lang @endif required" name="short_description[{{ $lang->code }}]">{{ old('short_description.'.$lang->code) }}</textarea>
                      </div>
                    </div>                
                </div> -->
                                               
                </div> 
                
                </fieldset>

                @endforeach
              </div>
              <div class="col-md-12">
              <div class="col-md-6">         
                <div class="form-group">
                  <label for="name" class="col-sm-12 col-md-4 col-lg-4 control-label"> Location <span>*</span></label>

                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <input type="text" id="autocomplete" name="location" value="{{ old('location') }}" class="form-control " placeholder="Enter Location" required="required" onFocus="geolocate()">
                  </div>
                </div>                
                </div>
              </div>

              <div class="col-md-12">
                <div class="col-md-6">                
                <div class="form-group">
                  <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Event Type <span>*</span></label>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <select class="form-control input-lg required" name="eventtype_id" readonly >
                                          
                      @foreach($eventtype_list as $k=>$eventtype )
                      @if($eventtype->id == 1)
                        <option value="{{ $eventtype->id }}">{{ $eventtype->name }}</option>
                      @endif
                      @endforeach
                    </select>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                  <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Status <span>*</span></label>

                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <select name="status" class="form-control input-lg" required="required">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>
                </div>
                </div>

                <div class="col-md-12">
                <div class="col-md-6">
                <div class="form-group">
                  <label for="event_start_date" class="col-sm-12 col-md-4 col-lg-4 control-label">Start Date <span>*</span></label>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                  <div class="icon-time">
                  <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="event_start_date" value="{{ old('event_start_date') }}" id="event_start_date" placeholder="Event Start Date" required="required" readonly="readonly">
                    </div>
                  </div>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                  <label for="event_end_date" class="col-sm-12 col-md-4 col-lg-4 control-label">End Date <span>*</span></label>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                  <div class="icon-time">
                  <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="event_end_date" id="event_end_date" value="{{ old('event_end_date') }}" placeholder="Event End Date" required="required" readonly="readonly">
                    </div>
                  </div>
                </div>
                </div>
                </div>

                <div class="col-md-12">
                  <div class="col-md-12">
                  <div class="form-group">   

                  <div class="col-sm-9 col-md-9 col-lg-10 chkbox_area">
                     <input type="checkbox" name="allday_event" id="allday_event" value="Yes">
                     <label for="checkbox1">All Day Event</label>

                  </div>
                  

                </div>
                </div>
                </div>

                <div class="col-md-12" id="time_section">
                <div class="col-md-6">
                <div class="form-group">
                  <label for="start_time" class="col-sm-12 col-md-4 col-lg-4 control-label">Start Time</label>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                  <div class="icon-time">
                  <span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                    <input type="text" class="form-control timepicker" name="start_time" id="start_time" {{ old('start_time') }} placeholder="Event Start Time" readonly="readonly" >
                    </div>
                  </div>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                  <label for="end_time" class="col-sm-12 col-md-4 col-lg-4 control-label">End Time</label>
                  <div class="col-sm-12 col-md-8 col-lg-8">
                  <div class="icon-time">
                  <span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                    <input type="text" class="form-control timepicker" name="end_time" id="end_time" {{ old('end_time') }} placeholder="Event End Time" readonly="readonly">
                    </div>
                  </div>
                </div>
                </div>
                </div>
                
                <div class="col-md-12">        
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Image</label>

                      <div class="col-sm-12 col-md-8 col-lg-8 custom-file">
                      <div class="input-group pull-left">
                    <label class="input-group-btn">
                        <span class="btn">
                            Browse&hellip; <input type="file" name="event_image" id="event_image" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <span><strong>(Maximum file size 2MB and minimum width 1250 pixel allowed)</strong></span>
                        <!--<input type="file" class="form-control" name="event_image[]" multiple="multiple">-->
                      </div>
                    </div>

                </div>
                </div>

                <div class="col-md-12">        
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Profile Image</label>

                      <div class="col-sm-12 col-md-8 col-lg-8 custom-file">
                      <div class="input-group pull-left">
                    <label class="input-group-btn">
                        <span class="btn">
                            Browse&hellip; <input type="file" name="event_profile_image" id="event_profile_image" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>
                <span><strong>(Please upload image file with width less than 300px and height less than 300px and maximum file size 2MB)</strong></span>
                        <!--<input type="file" class="form-control" name="event_image[]" multiple="multiple">-->
                      </div>
                    </div>

                </div>
                </div>
                
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('event_list') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection