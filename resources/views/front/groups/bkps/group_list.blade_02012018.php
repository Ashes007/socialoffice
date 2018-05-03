@extends('front.layout.group_app')
@section('title','Tawasul')
@section('content')

   <div class="home-container">
     <div class="container">
     @include('front.includes.group_slidemenu')
 	 @include('front.includes.group_header')     

       <div id="exTab2">
			<div class="tab-content cal-con grop-time ">
			  <div class="tab-pane active">
                <div class="row">

        
         @if(count($groups)>0)
         @foreach ($groups as $group)       	
         <?php $group_id = base64_encode($group->group_id + 100);?>
         <div class="col-sm-4 col-xs-6">
           <div class="photo-single group-areas">
             <div class="group-img">
             	<a href="{{URL::Route('group_details').'/'.$group_id}}"><img src="{{ asset('uploads/group_images/').'/'.$group->cover_image }}" alt="" class="big-img"/></a>
             	@if(request()->segment(2)!=''&& request()->segment(2)!='all')
                 <img src="{{ asset('frontend/images/sg-1.jpg')}}" alt="" class="small-img"/> 
                @endif
             </div>
             <h3><a href="group.html">{{ $group->group_name }}</a></h3>
             <h5>{{ get_memeber_group($group->group_id) }} members</h5>
             <p>{{ $group->group_description }}</p>
             <span class="week-active">Active {{ active_memeber_group($group->created_at) }} ago / <label>{{ ucwords($group_type)}} Group</label></span>
           </div>
         </div>
       
         @endforeach
         @endif


        </div>
		</div>

		</div>
      <div class="loadings"><img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>Load More...</span></div>
  </div>

    

   <div class="modal fade" id="uploadphoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content alt">
      <div class="modal-body">
        <button type="button" class="close alt" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
        <div class="row">
          <div class="col-sm-12">
            <h2><i class="fa fa-users" aria-hidden="true"></i> Create Group</h2>
  <form action="/action_page.php">
    <div class="form-group">
      <label for="title">Group Name:</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
      <label for="pwd">Upload Group Banner Image:</label>
      <input type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
    </div>

    <div class="form-group">
      <label for="title">Group Description:</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>

    <div class="form-group">
  <label for="sel1">Select list:</label>
  <div class="form-select">
  <div class="arrow" for="sel1"><i class="fa fa-angle-down" aria-hidden="true"></i></div>
  <select class="form-control" id="sel1">
    <option>All Group</option>
    <option>All Group2</option>
    <option>All Group 3</option>
    <option>All Group 4</option>
  </select>
  </div>
   </div>


   <div class="clearfix"></div>
    <div class="form-sub">
    <input type="submit" value="Create"/> <i class="fa fa-check-circle" aria-hidden="true"></i></i>
    </div>
  </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

	<a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>


   
		<script>
			new UISearch( document.getElementById( 'sb-search' ) );
	</script>

    <!------Photo Upload-------->

    <script type="text/javascript" src="{{ asset('frontend/js/imageuploadify.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('input[type="file"]').imageuploadify();
            })
        </script>

   <!------Photo Upload-------->

   <script type="text/javascript">
   $(document).ready(function(){
   $('.panel').on('click', function() {
   $('.slidemenu').toggleClass('clicked').addClass('unclicked');
   $('.menubar_icon_black').toggleClass('menubar_icon_cross');
});
});
   </script>


   
    @endsection
 
