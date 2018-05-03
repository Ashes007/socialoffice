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

										<input type="text" class="form-control required @if($lang->code == 'ar') arbic_lang @endif" name="name[{{ $lang->code }}]" value="{{ old('name.'.$lang->code) }}"  placeholder="Group Name" required="required">

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
             

              <!--<div class="col-md-12">
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
                </div>-->

               
                <div class="col-md-12">        
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Cover Image*</label>

                      <div class="col-sm-12 col-md-8 col-lg-8 custom-file">
                      <div class="input-group pull-left">
                    <label class="input-group-btn">
                        <span class="btn">
                            Browse&hellip; <input type="file" name="group_image" id="group_image" required="" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" required readonly>
                </div>
                <span><strong>(Please upload image file with width greater than 1280px and height greater than 382px and maximum file size 2MB )</strong></span>
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

                            Browse&hellip; <input type="file" name="upload_profile_img" id="upload_profile_img" style="display: none;">

                        </span>
                    </label>
                    <input type="text" class="form-control" readonly>
                </div>

                <span><strong>(Please upload image file with width less than 300px and height less than 300px and maximum file size 2MB )</strong></span>

                        <!--<input type="file" class="form-control" name="event_image[]" multiple="multiple">-->
                      </div>
                    </div>

                </div>
                </div>
               

                <div class="col-md-12">         
                <div class="form-group">
                  <label for="name" class="col-sm-12 col-md-3 col-lg-2 control-label"> Group Type <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
                    <select name="group_type_id" readonly>
                      <option value="1">Global Group</option>
                    </select>
                  </div>
                </div>
                
                </div>

                
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('group_list') }}">Cancel</a>
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