@extends('admin.innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

  <section class="content-header">
    <h1>{{ $management.' '.$pageType }} </h1>
    <ol class="breadcrumb">
        @foreach($breadcrumb['LISTPAGE'] as $eachBreadcrumb)
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
    <div class="row">
    <div class="col-xs-12">
	   @include('admin.includes.messages')
    <div class="btn btn-default pull-right button-custom">
    <a  href="{{ URL::Route('event_add') }}"><i class="fa fa-plus"> Add</i></a>
    </div>
    </div>
    
      <div class="col-xs-12">
        
        <!-- /.box -->

        <div class="box">
          
          <!-- /.box-header -->
          <div class="box-body new-padding new-marg">
          <div class="data-table table-responsive">
            <table id="eventTable" class="table">
              <thead>
              <tr>
                <th>Department</th>
                <th>Name</th> 
                <th>Type</th>
                <th>Start date</th>
                <th>End date</th> 
                <th>Event Time</th> 
                <th>Event Creator</th>                                 
                <th>Status</th>
                <th class="no-sort">Action</th>
              </tr>
              </thead>
              <tbody>
              @if($event_list->count()>0)	
              @foreach($event_list as $event)
              <tr>
                <td>{{ getDepartmentName($event->user->department_id) }}</td>
                <td>{{ $event->name}}</td>
                <td>{{ $event->eventtype->name}}</td> 
                <td>{{ \Carbon\Carbon::parse($event->event_start_date)->format('dS M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($event->event_end_date)->format('dS M Y') }}</td>
                <td>@if($event->allday_event == 'Yes') All Day @else {{ $event->start_time }} - {{ $event->end_time }} @endif</td>   
                <td>{{ $event->user->display_name }}</td>              
                <td align="center">
                <div class="link linklistgroup">

                @if($event->status == 'Inactive')
                  <span class="inactiveStatus">
                  <a href="javascript:void(0)" class="event_status link approveLink"  data-id="{{ $event->id }}" data-status="Active" data-model="Event" title="Click to approve Status">
                    <span class="ion-checkmark"></span>
                  </a>
                  <a href="javascript:void(0)" class="event_status_inactive link disapproveLink" data-id="{{ $event->id }}" data-status="Disapprove" data-model="Event" title="Click to disapprove Status">
                    <span class="ion-android-close"></span>
                  </a>
                  </span>
                @elseif($event->status == 'Active') 
                <span class="activeStatus">  
                  <a href="javascript:void(0)" class="event_status_inactive link" data-id="{{ $event->id }}" data-status="Disapprove" data-model="Event" title="Click to change Status">
                      <span class="ion-checkmark"></span>
                  </a>
                </span>
                @else  
                <span class="inactiveStatus">                  
                  <a href="javascript:void(0)" class="event_status link" data-id="{{ $event->id }}" data-status="Active" data-model="Event" title="Click to change Status">
                      <span class="ion-android-close"></span>
                  </a>
                  <i class="fa fa-info-circle" data-toggle="tooltip" title = "{{ $event->disapprove_reason }}"></i>
                </span>
                @endif
                </div>
                
                </td>
                <td align="center"> <a class="link" href="{{ URL::Route('event_edit', $event->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                 <a class="link del" onClick="destroyData('{{ URL::Route('event_delete', $event->id) }}')" href="javascript:void(0)"  title="Delete"> <i class="fa fa-trash"></i> </a>
                 @if(havePostEventGroup($event->id,'Event')>0)<a class="link" href="{{ URL::Route('event_posts', $event->id) }}" data-toggle="tooltip" title="View Post"><i class="fa fa-folder"></i></a>@endif
                </td>
                
              </tr>
              @endforeach
              @endif
              
              </tbody>
              
            </table>
          </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

  @endsection