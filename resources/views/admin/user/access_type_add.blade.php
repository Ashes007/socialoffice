@extends('admin/innertemplate')
@section('title','Access Type Add')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Access Type Add
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Access Type</a></li>
        <li class="active">Add</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-8 col-md-offset-2">
          <!-- Horizontal Form -->
          <div class="box box-info new-ticket">
            <div class="box-header with-border">     
            </div>

            @if (count($errors) > 0)
                 <div class = "alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                 </div>
            @endif
            <!-- /.box-header -->
            <!-- form start -->
            <form method ="post" class="form-horizontal" action="">
            {{ csrf_field() }}

              <div class="box-body">
                
                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Menu</label>
                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <select class="form-control input-lg" name="menu">
                      @foreach($menu_list as $id=>$menu )
                      <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                      @endforeach
                    </select>
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                  </div>
                </div>

                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Access Name</label>
                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Access Name" required="required">
                  </div>
                </div>

                <div class="form-group">
                  <label for="code" class="col-sm-3 col-md-3 col-lg-2 control-label">Route Name</label>
                  <div class="col-sm-9 col-md-9 col-lg-10">
                    <input type="text" class="form-control" name="route_name" id="route_name" placeholder="Route Name" required="required">
                  </div>
                </div>
               
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">           
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