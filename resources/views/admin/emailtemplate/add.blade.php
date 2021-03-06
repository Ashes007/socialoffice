@extends('admin/innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{ $management.' '.$pageType }} </h1>
      <ol class="breadcrumb">
          @foreach($breadCrumb as $eachBreadcrumb)
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
            <div class="box-header">     
            </div>
						@include('admin.includes.messages')	
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('id'=>'', 'class'=>'form-horizontal form-validate','method'=>'post')) !!}

              <div class="box-body">
              
              <div class="row">
              	<div class="col-md-12">
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Template File <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-6">
                    {!! Form::select('template_file', $templateFiles, '', array('class' => 'form-control required','id'=>'','placeholder'=>'Template File')) !!}
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>               
                </div>
                </div>

              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Slug <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-6">
                    {!! Form::text('slug', '', array('class' => 'form-control  required','id'=>'','placeholder'=>'Slug')) !!}
                  </div>
                </div>               
                </div>
                </div> 

              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Name <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-6">
                    {!! Form::text('template_name', '', array('class' => 'form-control  required','id'=>'','placeholder'=>'Name')) !!}
                  </div>
                </div>               
                </div>
                </div>

              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Subject <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-6">
                    {!! Form::text('email_subject', '', array('class' => 'form-control  required','id'=>'','placeholder'=>'Subject')) !!}
                  </div>
                </div>               
                </div>
                </div> 

              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                   <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">Template Variables <span>*</span></label>
                   <div class="col-sm-9 col-md-9 col-lg-10">                    
                    {!! Form::text('template_variables', '', array('class' => 'form-control  required','id'=>'','placeholder'=>'Template Variables')) !!}
                  </div>
                </div>               
                </div>
                </div>                                                                                                

                <div class="row">
                <div class="col-md-12">
                  @foreach($lang_locales as $lang)
                  <fieldset class="scheduler-border">
                  <legend class="scheduler-border">Language: {{ $lang->language_name }} <span>*</span></legend>                   
                  <div class="row">
                  <div class="col-md-12">
                  <div class="form-group textares">
                    <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">{{ $lang->language_name }} Content <span>*</span></label>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                      {!! Form::textarea('email_content['.$lang->code.']', '', array('class' => 'summernote required'.(($lang->code == 'ar')? ' arbic_lang':''),'id'=>'','placeholder'=>'Content')) !!}
                    </div>
                  </div>                    
                
                </div>
                </div>
                </fieldset>
                @endforeach
               </div>
              </div>                                              
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route($listPage) }}">Cancel</a>
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