@extends('admin.innertemplate')
@section('content')
<script src="{{ asset('frontend/js/jquery.colorbox.js') }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/colorbox.css')}}" />
  <section class="content-header">
    <h1>{{ $management.' '.$pageType }} </h1>
    <ol class="breadcrumb">
    @foreach($breadcrumb['POSTPAGE'] as $eachBreadcrumb)
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
    <p>Group Name : {{group_name($group_id)}}</p>
  </section>
<!-- Main content -->
  <section class="content"> @include('admin.includes.messages')
    @if(count($group_posts)>0)
    @foreach($group_posts as $post)
      <div class="timelineBlock" >
        <div class="time-postedBy">
        <div class="image-div">
        <?php if(file_exists( public_path('uploads/user_images/profile_photo/thumbnails/'.$post->profile_photo) )&& ($post->profile_photo!='' || $post->profile_photo!=NULL)) {?>
        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/').'/'.$post->profile_photo }}"/>
        <?php }else{ ?>
        <img src="{{ asset('uploads/no_img.png') }}"/>
        <?php  } ?>
        </div>
        <h2>{{$post->display_name}}</h2>
        <p>{{$post->location}} @if($post->location!='') - @endif {{date('F d, Y',strtotime($post->created_at))}}</p>
        <span class="delpost"><a href="javascript::void(0);" alt="{{$post->id}}" data-toggle="tooltip" class="deletepost" title="Delete Post"><i class="fa fa-trash"></i></a></span>
        </div>
        <div class="postedTime-image">
        <?php if(file_exists( public_path('uploads/post_images/'.$post->image) )&& ($post->image!='' || $post->image!=NULL)) {?>
        <img src="{{ asset('uploads/post_images/').'/'.$post->image }}"/>
        <?php }?>               
        <h2>{{$post->text}}</h2>
        <input type="hidden" value="{{$post->id}}" class="piscls" alt="{{$post->id}}" id="pid_{{$post->id}}" />
        </div>
        <div class="likeComment">
        <div class="row">
        <div class="col-sm-10">         

        </div>
        <div class="col-sm-2">
        <p><a  class='cntlikecls' href="{{URL::Route('likelist').'/'.$post->id.'/'.encrypt($group_id)}}"><span id="likecnt_id_{{$post->id}}" class="likecls">{{count($post->likes)}} {{ __('common.likes')}} </span></a>- <a href="javascript:void(0);" class="user-com" data-target="{{$post->id}}" id="cmncnt_id_{{$post->id}}">{{count($post->comments)}} {{ __('common.comments')}}</a></p>
        <input type="hidden" value="{{count($post->comments)}}" id="cmntid_{{$post->id}}" />
        <input type="hidden" value="{{count($post->likes)}}" id="likeid_{{$post->id}}" />
        </div>
        </div>
        </div>
        <div class="comment-other">
        <div class="commentscrollcls">
        @if(count($post->comments))   <?php  $i = 0; ?>           
        @foreach($post->comments as $comment) <?php $i ++; ?>

        <div class="comment-other-single">
        <div class="image-div">
        @if($comment->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $comment->user->profile_photo)))
        <img src="{{ asset('uploads/user_images/profile_photo/thumbnails/'.$comment->user->profile_photo) }}" alt=""/>
        @else
        <img src="{{ asset('uploads/no_img.png') }}" alt="">
        @endif     </div>
        <h2>{{ $comment->user->display_name }} <span style="float: right;"><a href="javascript::void(0);" alt="{{$comment->id}}" data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"><i class="fa fa-trash"></i></a></span>&nbsp;<span>{{ \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A') }}&nbsp;&nbsp;</span></h2>
        <p>{{$comment->body}}</p>
        
        </div>

        @endforeach  

        @endif
        <div id="commentsnwid_{{$post->id}}">
        </div> 
        </div>
        </div>
      </div>

    @endforeach 
    @php echo $group_posts->links(); @endphp   
    @else
      <div class="timelineBlock" >
      <div class="time-postedBy">
        No Post for this group
      </div>
      </div>       
    @endif
  </section>
<script> 

$( document ).on( "click", ".deletepost", function(event) {    
  var post_id =   $( this).attr( "alt" );
  var group_id =  <?php echo $group_id?>;
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this post?",
    buttons: {
      confirm: function () { 
      window.location.href ="{{URL::Route('delete_posts')}}"+'/'+post_id+ '/'+group_id;
      },
      cancel: function () {

      }
    }
  });              

});

$( document ).on( "click", ".deletecomment", function(event) {    
  var comment_id =   $( this).attr( "alt" );
  var group_id =  <?php echo $group_id?>;
  $.confirm({
    title: "Confirm",
    content: "Are you sure to delete this comments?",
    buttons: {
      confirm: function () { 
      window.location.href ="{{URL::Route('delete_comments')}}"+'/'+comment_id+ '/'+group_id;
      },
      cancel: function () {

      }
    }
  });              

});
</script> 
<script type="text/javascript">

$(document).on('click','.cntlikecls',function(e) {
e.preventDefault();
$.colorbox({href : this.href, width:"30%"});
});
</script>
@endsection