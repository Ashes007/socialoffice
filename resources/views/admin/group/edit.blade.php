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
										<input type="text" class="form-control required @if($lang->code == 'ar') arbic_lang @endif" name="name[{{ $lang->code }}]" value="{{ $details->translateOrNew($lang->code)->group_name }}"  placeholder="Group Name" required="required">

                  </div>
                </div>
                
                </div>
                
									

                <div class="col-md-12">         
                <div class="form-group textares">
                  <label for="name" class="col-sm-12 col-md-3 col-lg-2 control-label"> Description <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
										<textarea class="summernote @if($lang->code == 'ar') arbic_lang @endif" name="description[{{ $lang->code }}]">{{ $details->translateOrNew($lang->code)->group_description }}</textarea>
                  </div>
                </div>                
                </div> 
                                               
                </div>                 
                </fieldset>
                @endforeach
              </div>            
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Owner</label>
                  @php $name= preg_replace('#<a.*?>([^>]*)</a>#i', '$1', member_name($details->user_id));@endphp
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    {{$name}}                    
                  </div>
                </div>
                </div>
                </div> 
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Status <span>*</span></label>

                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <select name="status" id="statusgroupid" class="form-control input-lg" required="required">
                        @if($details->status == 'Inactive')
                        <option value="Active" @if($details->status == 'Active') selected @endif >Approve</option>
                        <option value="Disapprove" @if($details->status == 'Inactive'||$details->status == 'Disapprove') selected @endif >Disapprove</option>
                        @else
                        <option value="Active" @if($details->status == 'Active') selected @endif >Active</option>
                        <option value="Disapprove" @if($details->status == 'Inactive'||$details->status == 'Disapprove') selected @endif >Inactive</option>
                        @endif
                    </select>
                    <input type="text" name="disapprove_reason" id="disapprove_reason" placeholder="Disapprove Reason" class="form-control" style="display: {{ ($details->status == 'Disapprove')?'block':'none' }}" value="{{ $details->disapprove_reason }}">
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>
                </div>
                </div>                
                <div class="col-md-12">        
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="code" class="col-sm-12 col-md-4 col-lg-4 control-label">Cover Image</label>

                      <div class="col-sm-12 col-md-8 col-lg-8 custom-file">
                      <div class="input-group pull-left">
                      <label class="input-group-btn">
                          <span class="btn">
                              Browse&hellip; <input type="file" name="group_image" id="group_image" style="display: none;">
                          </span>
                      </label>
                      <input type="text" class="form-control" readonly>
                      </div>
                      <span><strong>(Please upload image file with width greater than 1280px and height greater than 382px and maximum file size 2MB)</strong></span>
                        <!--<input type="file" class="form-control" name="event_image[]" multiple="multiple">-->
                      </div>
                    </div>

                </div>
                @if(isset($details->cover_image) && $details->cover_image!='' && file_exists(public_path('uploads/group_images/'.$details->cover_image)))  
                <div class="col-sm-12 col-md-6 ">
                  <div class="img-box">                            
                  <img class="edit_box_img" src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/'.$details->cover_image) }}&w=786&h=175&q=100" alt="img" />                  
                  </div>
                  </div>
                @endif
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
                 @if(isset($details->profile_image) && $details->profile_image!='' && file_exists(public_path('uploads/group_images/profile_image/'.$details->profile_image))) 
                <div class="col-sm-12 col-md-6 ">
                  <div class="img-box">
                            
                  <img class="edit_box_img" src="{{ asset('timthumb.php') }}?src={{ asset('uploads/group_images/profile_image/'.$details->profile_image) }}&w=300&h=300&q=100" alt="img" />                  
                  
                 
                  
                  </div>
                  </div> 
                  @endif
                </div>
               

                <!-- <div class="col-md-12">         
                <div class="form-group">
                  <label for="name" class="col-sm-12 col-md-3 col-lg-2 control-label"> Group Type <span>*</span></label>

                  <div class="col-sm-12 col-md-9 col-lg-10">
                    <select name="group_type_id" readonly>
                      <option value="1">Global Group</option>
                    </select>
                  </div>
                </div>
                
                </div> -->
                <input type="hidden" name="group_type_id" value="{{$details->group_type_id}}">
                 <input type="hidden" name="reason" id="reason_disapprove">
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
    <!-- <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog"> 
       
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Write the reason of disapprove</h4>
          </div>
          <div class="modal-body">
            <p><input type="text" class="bootbox-input bootbox-input-text form-control" name="reason_modal" required="" id="reasonid" /></p>
          </div>
          <div class="modal-footer">
           <input type="button" value="Submit" id="reasonsubmit" class="btn btn-success"/> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
 
      </div>
    </div> -->
   <!--  <script type="text/javascript">
      
      $(document).ready(function(){
     
     $("body").on("change","#statusgroupid",function(){
          if($("#statusgroupid").val()=='Disapprove'){
            $("#myModal").modal("show");         
            
          }             
              
      });

     $('#reasonsubmit').click(function(){
       var reason = $('#reasonid').val();
       if(reason=='')
       {
          return false;
       }else{
          $('#reason_disapprove').val(reason);
          $("#myModal").modal("close");  
       }
     });
 
});
    </script> -->
 
  @endsection