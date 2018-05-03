@extends('front.layout.group_app')
@section('title','Tawasul')
@section('content')

   <div class="home-container">
     <div class="container">
     @include('front.includes.group_slidemenu')
 	 @include('front.includes.group_header')     
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  	<style type="text/css">
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
  	</style>
       <div id="exTab2">
			<div class="tab-content cal-con grop-time ">
			  <div class="tab-pane active">
                <div class="row" id="post-data">

         <?php //print_r($groups);?>
        

			@include('front.groups.data_group')
        </div>
		</div>

		</div>
      <div class=" loadings ajax-load " style="display:none"><img src="{{ asset('frontend/images/Spin.gif') }}" alt=""/> <span>Load More...</span></div>
  </div>
    <script type="text/javascript">
	var page = 1;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    }
	});


	function loadMoreData(page){ alert(page);
		
	  $.ajax(
	        {

	            url: '?page='+ page,
	            type: "get",
	            beforeSend: function()
	            {	            	
	                $('.ajax-load').show();
	            },
	            success: function(data){
	        	alert(data);
	            if(data.html == " "){
	                $('.ajax-load').html("No more records found");
	                return;
	            }
	            $('.ajax-load').hide();
	            $("#post-data").append(data.html);
	           }
	        });
	        /*.done(function(data)
	        {
	        	alert(data);
	            if(data.html == " "){
	                $('.ajax-load').html("No more records found");
	                return;
	            }
	            $('.ajax-load').hide();
	            $("#post-data").append(data.html);
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {

	              alert('server not responding...');
	        });*/
	}
</script>

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


    
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!------for search area-------->
    <script src="{{ asset('frontend/js/classie.js') }}"></script>
		<script src="{{ asset('frontend/js/uisearch.js') }}"></script>
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


    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    @endsection
 
