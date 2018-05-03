@extends('admin/innertemplate')
@section('title','Permission')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Permission
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permission</a></li>
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

            @if(session()->has('succmsg'))
                <div class="alert alert-success">
                    {{ session()->get('succmsg') }}
                </div>
            @endif 

            </div>
            <!-- /.box-header -->
            <!-- form start -->
          <form action="" method="post">
          {{ csrf_field() }}
              <div class="box-body">   
              <ul>

                @foreach($menu_list  as $menu)
               <li>{{ $menu->name }}
                  <ul>
                    @foreach($menu->accessType as $access)
                    <li><input type="checkbox" name="accessTypeIds[]" value="{{ $access->id }}" @php if(in_array($access->id,$selectedPermission )) echo "checked"; @endphp >{{ $access->name }}</li>
                    @endforeach
                  </ul>
               </li>
                @endforeach            
              </ul>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="{{ URL::Route('grouptype_list') }}">Cancel</a>
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
            </form>
              <!-- /.box-footer -->
                

          </div>
          <!-- /.box -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->


    <!-- /.content -->


  @endsection