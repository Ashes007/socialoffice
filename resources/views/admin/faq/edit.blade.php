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
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Category <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-6">
                    {!! Form::select('category', $faqCategories, $record->faq_category_id, array('class' => 'form-control required','id'=>'','placeholder'=>'Category')) !!}
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
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
                  <div class="form-group">
                    <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">Question <span>*</span></label>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                      {!! Form::text('question['.$lang->code.']', $record->translate($lang->code)->question, array('class' => 'form-control  required'.(($lang->code == 'ar')? ' arbic_lang':''),'id'=>'','placeholder'=>'Question')) !!}
                    </div>
                  </div>                  
                  </div>  

                  <div class="col-md-12">
                  <div class="form-group textares">
                    <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">Answer <span>*</span></label>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                      {!! Form::textarea('answer['.$lang->code.']', $record->translate($lang->code)->answer, array('class' => 'required'.(($lang->code == 'ar')? ' arbic_lang':''),'id'=>'','placeholder'=>'Answer')) !!}
                    </div>
                  </div>                    
                
                </div>
                </div>
                </fieldset>                  
                @endforeach
               </div>
              </div>

                
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Status <span>*</span></label>
                  <div class="col-sm-9 col-md-9 col-lg-6">
                    {!! Form::select('status', ['Active'=>'Active','Inactive'=>'Inactive'], $record->status, array('class' => 'form-control required','id'=>'')) !!}
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>               
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