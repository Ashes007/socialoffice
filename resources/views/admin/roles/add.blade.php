@extends('admin/innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{ $management.' '.$pageType }} </h1>
      <ol class="breadcrumb">
          @foreach($breadcrumb['EDITPAGE'] as $eachBreadcrumb)
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
            <div class="box-header with-border">
            
            </div>

            @include('admin.includes.messages')
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('id'=>'', 'class'=>'form-horizontal form-validate','method'=>'post')) !!}

              <div class="box-body">
                
                <div class="row">
              
                <div class="col-md-6">
                <div class="form-group">
                  <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">Name <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-10">
                    {!! Form::text('display_name', '', array('class' => 'form-control required','id'=>'','placeholder'=>'Role')) !!}
                  </div>
                </div>                  
                </div>


                <div class="col-md-6">
                <div class="form-group">
                  <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">Description <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-10">
                    {!! Form::text('description', '', array('class' => 'form-control required','id'=>'','placeholder'=>'Description')) !!}
                  </div>
                </div>                  
                </div>                
                

                </div>
                
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('role_list') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            {!! Form::close() !!} 
          </div>
          <!-- /.box -->

      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection