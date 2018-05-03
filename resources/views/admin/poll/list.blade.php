
@extends('admin.innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <section class="content-header">
      <h1>{{ $management }} </h1>
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
      <div class="row">
      
      <div class="col-xs-12">
			@include('admin.includes.messages')
      <div class="btn btn-default pull-right button-custom">
      <a  href="{{ URL::Route($addPage) }}"><i class="fa fa-plus"> Add</i></a>
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
                  <th>Title</th> 
                  <th>Category</th>        
                  <th>Status</th>
                  <th class="no-sort">Action</th>
                 
                </tr>
                </thead>
                <tbody>
                @if($records->count()>0)	
                @foreach($records as $record)
                
                <tr>
                  <td>{{ $record->title }}</td> 
                  <td>{{ $record->category->name }}</td>                           
                  <td align="center">
                  <div class="link">
                  <a href="javascript:void(0)" class="status link" data-id="{{ $record->id }}" data-model="Howto" title="Click to change Status">
                      @if($record->status == 'Active') 
                      <span class="ion-checkmark"></span>
                      @else
                      <span class="ion-android-close"></span>
                      @endif
                  </a>
                  </div>
                  </td>
                  <td align="center"> <a class="link" href="{{ URL::Route($editPage, $record->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                   <a class="link del" onClick="destroyData('{{ URL::Route($deletePage, $record->id) }}')" href="javascript:void(0)" title="Detele"> <i class="fa fa-trash"></i> </a>
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
