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
            <div class="box-header">
            
            </div>
							@include('admin.includes.messages')
            <!-- /.box-header -->
            <!-- form start -->
            <form method ="post" class="form-horizontal form-validate" action="" enctype="multipart/form-data">
            {{ csrf_field() }}

              <div class="box-body"> 
              
              	<div class="row">
              
              	<div class="col-md-6">               
                
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Status <span>*</span></label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <select name="cnt_status" class="form-control input-lg" required="required">
                        <option value="">Select Status</option>
                        <option value="Active" @if($details->status == 'Active') selected @endif >Active</option>
                        <option value="Inactive" @if($details->status == 'Inactive') selected @endif >Inactive</option>
                    </select>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="status" class="col-sm-3 col-md-3 col-lg-2 control-label">Logo</label>
                  <div class="col-sm-9 col-md-9 col-lg-10 custom-file">
                  	<div class="input-group pull-left input-width">
                <label class="input-group-btn">
                    <span class="btn">
                        Browse&hellip; <input type="file" name="logo" id="company_logo" style="display: none;" multiple>
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
                  
                    <!--<input type="file" name="logo" id="company_logo" class="form-control">-->
                    <img class="pull-right" src="{{ asset('uploads/company/thumbnails').'/'.$details->logo }}">
                  </div>
                </div>
                
                </div>
                
                <div class="col-md-6">
                @foreach($lang_locales as $lang)
                <div class="form-group">
                  <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">{{ $lang->language_name }} <span>*</span></label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <input type="text" class="form-control required @if($lang->code == 'ar') arbic_lang @endif" name="name[{{ $lang->code }}]" value="{{ $details->translateOrNew($lang->code)->name }}"  placeholder="Company Name" required="required" @if($lang->code == 'en') readonly="readonly" @endif >
                  </div>
                </div>                  
                  
                @endforeach
								
               	</div>
                </div>
                
                </div>
                
              
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('company_list') }}">Cancel</a>
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