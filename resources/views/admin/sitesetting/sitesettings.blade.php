
@extends('admin.innertemplate')
@section('title', $management.' '.$pageType)
@section('content')

    <section class="content-header">
      <h1>{{ $management }} </h1>
      <ol class="breadcrumb">
          @foreach($breadcrumb['LISTPAGE'] as $eachBreadcrumb)
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
     
      </div>
      
        <div class="col-xs-12">
        
          <!-- /.box -->

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body new-padding new-marg">
            <div class="data-table table-responsive">
              <table class="sitesettings">               
                <tbody>
                @if($Sitesetting_list->count()>0)	
           
                @foreach($Sitesetting_list as $Sitesetting)
                  <tr>
                    <td width="25%"><strong>{{ $Sitesetting->sitesettings_name }}</strong></td>
                    <td width="60%"><span class="settingsContent">{!! $Sitesetting->sitesettings_value !!} </span>

                      <span class="settingsEditContent"></span>
                      
                    </td>
                    <td width="15%">
                    <a href="javascript:void(0);" class="btn btn-info btn-xs editLink" data-label="{{ $Sitesetting->sitesettings_lebel }}" data-id="{{ $Sitesetting->id }}" 
                    data-type="{{ $Sitesetting->sitesettings_type }}" ><i class="fa fa-pencil"></i> Edit</a>
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
