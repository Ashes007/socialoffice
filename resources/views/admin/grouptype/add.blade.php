@extends('admin/innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>{{ $management }} </h1>
      <ol class="breadcrumb">
          @foreach($breadcrumb['LISTPAGE'] as $eachBreadcrumb)
              @if($loop->first)
                  <li><a href="{{ URL::route('admin_dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                  <li><a href="{{ URL::route('admin_dashboard') }}">Dashboard</a></li> 
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

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">     
            </div>

             @include('admin.includes.messages')
            <!-- /.box-header -->
            <!-- form start -->
            <form method ="post" class="form-horizontal" action="">
            {{ csrf_field() }}

              <div class="box-body">
                
                <div class="form-group">
                  <label for="status" class="col-sm-3 col-md-3 col-lg-2 control-label">Status</label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <select name="status" class="form-control" required="required">
                        <option value="">Select Status</option>
                        <option value="Active" @if(old('status') == 'Active') selected="selected" @endif >Active</option>
                        <option value="Inactive" @if(old('status') == 'Inactive') selected="selected" @endif >Inactive</option>
                    </select>
                  </div>
                </div>
                @foreach($language as $id=> $lang)
                <div class="form-group">
                  <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">{{ $lang }}</label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <input type="text" class="form-control @if($lang->code == 'ar') arbic_lang @endif" name="name[{{ $id }}]" @if($id == 1) required="required" @endif placeholder="Group Type Name" value="{{ old('name.'.$id) }}">
                  </div>
                </div>
                @endforeach
                
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('grouptype_list') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->


  @endsection