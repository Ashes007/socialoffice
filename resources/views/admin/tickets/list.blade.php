
@extends('admin.innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <section class="content-header">
      <h1>{{ $management }} </h1>
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
      <!-- <div class="btn btn-default pull-right button-custom">
      <a  href=""><i class="fa fa-plus"> Add</i></a>
      </div> -->
      </div>
      
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body new-padding new-marg">
            <div class="data-table table-responsive">
              <table id="dataTable" class="table">
                <thead>
                <tr>
                  <th>#Id</th>
                  <th>Department</th>
                  <th>Title</th>
                  <th>Date</th>
                  <th>From</th>
                  <th>Status</th>
                  <th>Priority</th>
                  <th class="no-sort">Action</th>
                 
                </tr>
                </thead>
                <tbody>
                @if($records->count()>0)  
                      @foreach($records as $record)
                        <tr>
                          <td>{{ $record->ticket_no }}</td>
                          <td>{{ $record->department->name }}</td>
                          <td>{{ $record->title }}</td>
                          <td>{{ date('F d, Y', strtotime($record->created_at)) }}</td>
                          <td>{{ $record->user->display_name }} </td>
                          <td>{{ $record->status }}</td>
                          <td><a href="#" class="but">{{ $record->priority }}</a></td>
                          <td align="center"><a class="link edits" href="{{ route('admin_view_ticket', $record->id)}}" class="user_view" title="Click to view details"><span class="ion-eye"></span> </a> </td>
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
