@extends('admin.innertemplate')
@section('title', $management.' '.$pageType)
@section('content')
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
<section class="content-header">
  <h1>{{ $management.' '.$pageType }} </h1>
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
    <div class="btn btn-default pull-right button-custom">
    <a href="{{ URL::Route('add_group') }}"><i class="fa fa-plus"> Add</i></a>
    </div>
    </div>
  <div class="col-xs-12">
  <!-- /.box -->
  <div class="box">
  <!-- /.box-header -->
  <div class="box-body new-padding new-marg">
  <div class="data-table table-responsive">
    <table id="groupTable" class="table">
      <thead>
      <tr>
      <th width="20%">Department</th> 
      <th width="30%">Name</th> 
      <th>Group Type</th> 
      <th>Group Owner</th>                      
      <th>Status</th>
      <th class="no-sort">Action</th>
      </tr>
      </thead>
      <tbody>
      @if($group_list->count()>0)	
      @foreach($group_list as $group)
      <tr>
      <td>{{ getDepartmentName($group->department_id) }}</td>
      <td>{{ $group->group_name}}</td>
      <td>@if($group->group_type_id==1) Global @elseif($group->group_type_id==2) Departmental @else Activity @endif</td> 
      @php $name= preg_replace('#<a.*?>([^>]*)</a>#i', '$1', member_name($group->user_id));@endphp
      <td>{{ $name}}</td>                                 
      <td align="center">
      <div class="link linklistgroup">
      @if($group->status == 'Inactive')
      <span class="txtcls" id="groupstatid_{{ $group->id }}">
      <a href="javascript:void(0)" class="group_status_approve link" data-id="{{ $group->id }}" data-model="GroupUser" title="Click to approve Status"> <span class="ion-checkmark"></span> </a> 
      <a href="javascript:void(0)" class="group_status_disapprove link" data-id="{{ $group->id }}" data-model="GroupUser" title="Click to disapprove Status" alt="inactive_approve"><span class="ion-android-close"></span> </a> 
      </span>
      @elseif($group->status == 'Active') 
      <span id="groupstatid_{{ $group->id }}">
      <a href="javascript:void(0)"  class="group_status link" data-id="{{ $group->id }}" data-model="GroupUser" title="Click to change Status" alt="inactive"> <span class="ion-checkmark"></span> </a>
      </span>
      @else
      <span id="groupstatid_{{ $group->id }}">
      <a href="javascript:void(0)" class="group_status link" data-id="{{ $group->id }}" data-model="GroupUser" title="Click to change Status" alt="active"><span class="ion-android-close"></span> </a>
      <i class="fa fa-info-circle" data-toggle="tooltip" title = "{{ $group->disapprove_reason }}"></i>
      </span>
      @endif
      </div>
      </td>
      <td align="center"> 
      <a class="link" data-toggle="tooltip"  href="{{ URL::Route('edit_group', $group->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
      <a class="link del" onClick="destroyData('{{ URL::Route('group_delete', $group->id) }}')" data-toggle="tooltip"  href="javascript:void(0)" title="Delete"> <i class="fa fa-trash"></i> </a>
      @if(havePostEventGroup($group->id,'Group')>0)<a class="link" href="{{ URL::Route('group_posts', $group->id) }}" data-toggle="tooltip" data-placement="bottom" title="View Post"><i class="fa fa-folder"></i></a>@endif
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