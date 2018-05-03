
@extends('admin.innertemplate')
@section('title','Designation List')
@section('content')

    <section class="content-header">
     
       <h1>
        Designation list
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Designation</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      
      <div class="col-xs-12">
      @include('admin.includes.messages')
      <div class="btn btn-default pull-right button-custom">
      <a  href="{{ URL::Route('designation_sync') }}"><i class="fa fa-refresh"> Sync</i></a>
      </div>
      </div>
      
        <div class="col-xs-12">
          
          <!-- /.box -->

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body new-padding new-marg">
            <div class="data-table table-responsive">
              <table id="dataTable" class="table">
                <thead>
                <tr>
                  <th>Designation name</th>
                  <th>Status</th>
                  <th class="no-sort">Action</th>
                 
                </tr>
                </thead>
                <tbody>
                @if($designation_list->count()>0)	
                @foreach($designation_list as $designation)
                <tr>
                  <td>{{ $designation->name}}</td>
                  <td align="center">
                  <div class="link">
                  <a href="javascript:void(0)" class="status link" data-id="{{ $designation->id }}" data-model="Designation" title="Click to change Status">
                      @if($designation->status == 'Active') 
                      <span class="ion-checkmark"></span>
                      @else
                      <span class="ion-android-close"></span>
                      @endif
                  </a>
                  </div>
                  </td>
                  <td align="center"> <a class="link" href="{{ URL::Route('designation_edit', $designation->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                   <a class="link del" onclick="return confirm('If You delete this all related data will be delete.\n Are You Sure?')"  href="{{ URL::Route('designation_delete', $designation->id) }}" title="Detele"> <i class="fa fa-trash"></i> </a>
                  </td>
                  
                </tr>
                @endforeach
                @endif
                
                </tbody>
                
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>


  @endsection
