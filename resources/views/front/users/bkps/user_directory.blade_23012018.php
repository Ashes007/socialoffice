@extends('front.layout.app')
@section('title','Tawasul')
@section('content')

<div class="home-container">
    <div class="container">
     <div class="emDirectory-tiTle">
       <h2 class="animated zoomIn">Employee Directory Search</h2>
     </div>
    </div>
    <div class="emDirectory-wRapper">
       <div class="emDirectory-seaRch">
         <div class="container">
           <div class="row">
             <div class="col-sm-7">
               <!-- <div class="dropSelect fixedWidth">
                 <select class="selectpicker">
                    <option>Company</option>
                    <option>Company-2</option>
                    <option>Company-3</option>
                 </select>
               </div> -->
               <div class="dropSelect fixedWidth depertment" id="the-basics">
                 <!-- <select class="selectpicker">
                    <option>Department</option>
                    <option>Department-2</option>
                    <option>Department-3</option>
                 </select> -->
                 <!-- <input type="text" placeholder="Department" /> -->
                 <!-- <input class="typeahead" type="text" placeholder="Department"> -->
                 <!-- <input class="form-control" id="search-input" name="contacts" type="text" placeholder='Search by Department' /> -->
               </div>
             </div>
             <div class="col-sm-5">
               <div class="searchSt forSearch">
                 <input type="text" name="search" value="" placeholder="Search..." id="search-box">
                 <div id="stats"></div>
               </div>
             </div>
           </div>
         </div>
       </div>

      <!-- <div class="numWrap">
       <div id="numMenu" class="content slidemenu">
          <button class="left_slide_btn panel"> <span class="menubar_icon_black" style="display: block;"> </span></button>
         <ul id="controls">
           <li><a id="a" href="#"><span>A</span></a></li>
           <li><a id="b" href="#"><span>B</span></a></li>
           <li><a href="#"><span>C</span></a></li>
           <li><a href="#"><span>D</span></a></li>
           <li><a href="#"><span>E</span></a></li>
           <li><a href="#"><span>F</span></a></li>
           <li><a href="#"><span>G</span></a></li>
           <li><a href="#"><span>H</span></a></li>
           <li><a href="#"><span>I</span></a></li>
           <li><a href="#"><span>J</span></a></li>
           <li><a href="#"><span>K</span></a></li>
           <li><a href="#"><span>L</span></a></li>
           <li><a href="#"><span>M</span></a></li>
           <li><a href="#"><span>N</span></a></li>
           <li><a href="#"><span>O</span></a></li>
           <li><a href="#"><span>P</span></a></li>
           <li><a href="#"><span>Q</span></a></li>
           <li><a href="#"><span>R</span></a></li>
           <li><a href="#"><span>S</span></a></li>
           <li><a href="#"><span>T</span></a></li>
           <li><a href="#"><span>U</span></a></li>
           <li><a href="#"><span>V</span></a></li>
           <li><a href="#"><span>W</span></a></li>
           <li><a href="#"><span>X</span></a></li>
           <li><a href="#"><span>Y</span></a></li>
           <li><a href="#"><span>Z</span></a></li>
         </ul>
       </div>
      </div> -->

       <script id="movie" type="text/x-handlebars-template">
             <li class="a" onclick="location.href='employee_profile.html';">
                 <div class="emDirectory-block-single">
                 <div class="emailPop"><a href="mailto:@{{email}}"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></div>
                 <div class="blockSingle-img"><img src="@{{profile_photo}}" alt=""></div>
                 <div class="blockSingleCont">
                   <h2>@{{{_highlightResult.employeeName.value}}} <br> <span>@{{designation}}</span> </h2>
                   <h3>@{{department}}</h3>
                   <h4><i class="fa fa-phone" aria-hidden="true"></i> @{{telno}}</h4>
                   <h4><a href="mailto:@{{email}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> @{{email}}</a></h4>
                 </div>
                </div>
             </li>
       </script>

      <div class="emDirectory-block">
         <div class="container">
           <ul id="gallery" class="msGrid clearfix">
            <div id="hits"></div>
            <div id="pagination"></div>
           </ul>
         </div>
      </div>
    </div>
</div>



<link rel='stylesheet prefetch' href='http://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.css'>
<link rel='stylesheet prefetch' href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css'>
<script src='http://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js'></script>
<!-- for autocomplete -->
<!-- <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script> -->
<script src="{{ asset('frontend/js/angoliaSearch.js') }}"></script>
@endsection