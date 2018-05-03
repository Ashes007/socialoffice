@extends('admin/innertemplate')
@section('title','Designation Add')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Designation Add
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Designation</a></li>
        <li class="active">Add</li>
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
            <form method ="post" class="form-horizontal" action="">
            {{ csrf_field() }}

              <div class="box-body">
              
              <div class="row">
              
              	<div class="col-md-6">
                

                <div class="form-group">
                  <label for="status" class="col-sm-3 col-md-3 col-lg-2 control-label">Status</label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <select name="status" class="form-control input-lg" required="required">
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>
                
                </div>
                
                <div class="col-md-6">

								@foreach($lang_locales as $lang)	

                <div class="form-group">
                  <label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label">{{ $lang->language_name }}</label>

                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <input type="text" class="form-control required @if($lang->code == 'ar') arbic_lang @endif" name="name[{{ $lang->code }}]" value="{{ old('name.'.$lang->code) }}"  placeholder="Designation Name" required="required">
                  </div>
                </div>
                @endforeach									

                </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('designation_list') }}">Cancel</a>
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