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
            {!! Form::open(array('id'=>'', 'class'=>'form-horizontal form-validate','method'=>'post')) !!}

              <div class="box-body">
              
              <div class="row">
              
              <div class="col-md-12">
              @foreach($lang_locales as $lang)
              
              <fieldset class="scheduler-border">
              <legend class="scheduler-border">Language: {{ $lang->language_name }} <span>*</span></legend
              ><div class="row">  
              <div class="col-md-12">         
                <div class="form-group">
                  <label for="title" class="col-sm-12 col-md-3 col-lg-2 control-label"> Title <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
										
                    {!! Form::text('title['.$lang->code.']', '', array('class' => 'form-control required '.(($lang->code == 'ar')? 'arbic_lang':'')  ,'id'=>'','placeholder'=>'Title')) !!}
                  </div>
                </div>
                
                </div>
                
									

                <div class="col-md-12">         
                <div class="form-group textares">
                  <label for="description" class="col-sm-12 col-md-3 col-lg-2 control-label"> Description <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
										
                    {!! Form::textarea('description['.$lang->code.']', '', array('class' => 'form-control required summernote '.(($lang->code == 'ar')? 'arbic_lang':'')  ,'id'=>'','placeholder'=>'Description')) !!}
                  </div>
                </div>                
                </div>  

                <div class="col-md-12">         
                <div class="form-group textares">
                  <label for="short_description" class="col-sm-12 col-md-3 col-lg-2 control-label"> Short Description</label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
                    
                    {!! Form::textarea('short_description['.$lang->code.']', '', array('class' => 'form-control'.($lang->code == "ar")?"arbic_lang":""  ,'id'=>'','placeholder'=>'Short Description')) !!}
                  </div>
                </div>                
                </div>                               
                </div>
                
                </fieldset>

                @endforeach
              </div>
              <div class="col-md-12">
              <div class="form-group">
                  <label for="page_name" class="col-sm-3 col-md-3 col-lg-2 control-label">Page Name <span>*</span></label>

                  <div class="col-sm-9 col-md-9 col-lg-10">                    
                    {!! Form::text('page_name', '', array('class' => 'form-control required','id'=>'','placeholder'=>'Page Name')) !!}
                  </div>
                </div>

                <div class="form-group">
                  <label for="meta_title" class="col-sm-3 col-md-3 col-lg-2 control-label">Meta Title </label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    
                    {!! Form::text('meta_title', '', array('class' => 'form-control ','id'=>'','placeholder'=>'Meta Title')) !!}
                  </div>
                </div>

                <div class="form-group">
                  <label for="meta_key" class="col-sm-3 col-md-3 col-lg-2 control-label">Meta Key </label>

                  <div class="col-sm-9 col-md-9 col-lg-10">                    
                    {!! Form::text('meta_key', '', array('class' => 'form-control ','id'=>'','placeholder'=>'Meta Key')) !!}
                  </div>
                </div>

                <div class="form-group">
                  <label for="page_name" class="col-sm-3 col-md-3 col-lg-2 control-label">Meta Description</label>

                  <div class="col-sm-9 col-md-9 col-lg-10">                   
                    {!! Form::textarea('meta_description', '', array('class' => 'form-control','id'=>'','placeholder'=>'Meta Description')) !!}
                  </div>
                </div>


                <div class="form-group">
                  <label for="status" class="col-sm-3 col-md-3 col-lg-2 control-label">Status <span>*</span></label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    
                    {!! Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive'),null, array('class' => 'form-control required','id'=>'')) !!}

                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>
                
              </div>

                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('cms_list') }}">Cancel</a>
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