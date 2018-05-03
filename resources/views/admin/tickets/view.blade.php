@extends('admin/innertemplate')
@section('title','Ticket Details')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ticket Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin_dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin_ticket_list') }}">Ticket</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

   

    <!-- Main content -->
    <section class="content">
      
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket">
            <div class="box-header">     
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          
              <div class="box-body user-list">
              
              <div class="row">
              
              	<div class="col-md-6">
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Title</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{$record->title}}
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Ticket</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    #{{$record->ticket_no}}
                  </div>
                  </div>
                </div>

                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Priority</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{$record->priority}}
                  </div>
                  </div>
                </div>
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Status</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{$record->status}}
                  </div>
                  </div>
                </div> 
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Name</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $record->user->display_name }}
                  </div>
                  </div>
                </div>                               
                </div>
                
                <div class="col-md-6">
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Created Date</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ date('F d, Y', strtotime($record->created_at)) }}
                  </div>
                  </div>
                </div>
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Email</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $record->user->email }}
                  </div>
                  </div>
                </div>
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Department</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ $record->department->name }}
                  </div>
                  </div>
                </div>
                <div class="form-group">
                <div class="row">
                  <label for="code" class="col-xs-6 col-sm-3 col-md-3 col-lg-3 control-label">Phone</label>
                  <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
                    {{ ($record->user->mobile)? $record->user->mobile: 'N/A' }}
                  </div>
                  </div>
                </div>
               </div>

              </div>             
                
                @foreach($tickets as $ticket)
                  <div class="row">
                    <div class="col-md-10">
                      <div class="pro-img"><i class="fa fa-user" aria-hidden="true"></i></div>
                      <div class="pro-txt">
                      <h5>{{ $ticket->user->display_name }}</h5>
                      <span>to {{ $ticket->department->name }}</span>
                      <label>@if(count($ticket->attachments))<i class="fa fa-paperclip" aria-hidden="true"></i> @endif {{ date('F d, Y', strtotime($ticket->created_at)) }}</label>
                      </div>
                      </div>
                      <div class="col-md-2 ticket-atchicons">
                      @foreach($ticket->attachments as $attachment)
                        @php
                        $ext = pathinfo(public_path('uploads/tickets/'.$attachment->file), PATHINFO_EXTENSION);
                        $rootUrl = "/tawasul/public";

                        @endphp                      
                        <a href="{{ $rootUrl }}/download.php?f={{asset('uploads/tickets/'.$attachment->file)}}">
                            <i class="{{ getFileIcon($ext) }}" style="font-size:30px;color:red"></i>
                          </a>
                      @endforeach
                      </div>
                  </div>                
                  <div class="row">
                    <div class="col-md-12 txt-areas">
                      {!! $ticket->message !!}
                      </div>
                  </div>
                  
                  <div class="divider"></div>

                @endforeach

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default pull-right" href="{{ URL::Route('admin_ticket_list') }}">Back</a>
                
              </div>
              <!-- /.box-footer -->
          </div>
          <!-- /.box -->

      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection