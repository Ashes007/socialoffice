<?php $__env->startSection('title','Tawasul'); ?>
<?php $__env->startSection('content'); ?>


<div class="home-container">
    <div class="container">
     <div class="emDirectory-tiTle">
       <h2 class="animated zoomIn"><?php echo e(trans('home.Employee_Directory_Search')); ?></h2>
     </div>
    </div>
    <div class="emDirectory-wRapper">
       <div class="emDirectory-seaRch">
         <div class="container">
           <div class="row">
             <div class="col-sm-7">
                <div class="emDirectory-tiTle">
         		<!-- <h2><?php echo e(trans('home.Employee_Directory')); ?></h2> -->
       			</div>
             </div>
             <div class="col-sm-5">
               <div class="searchSt forSearch">
                 <input type="text" name="search" value="" placeholder="<?php echo e(trans('home.Search')); ?>..." id="search-box">
                 <div id="stats"></div>
               </div>
             </div>
           </div>
         </div>
       </div>

      <div class="numWrap">
       <div id="numMenu" class="content slidemenu">
          <button class="left_slide_btn panel"> <span class="menubar_icon_black" style="display: block;"> </span></button>
         <ul id="controls">
          <li><a id='all' href=''><span><?php echo e(trans('home.All')); ?></span></a></li>
         <?php 
          foreach (range('A', 'Z') as $column){
            $colId = strtolower($column);
              echo "<li><a id='$colId' href=''><span>$column</span></a></li>";
          }   
         ?>
         </ul>
       </div>
      </div>

       <script id="movie" type="text/x-handlebars-template">
         <li class="{{alpha}}">
             <div class="emDirectory-block-single">
             <div class="emailPop"><a href="mailto:{{email}}"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></div>
             <div class="blockSingle-img"><img src="<?php echo e($image_url); ?>{{profile_photo}}" alt=""></div>
             <div class="blockSingleCont">
               <h2><a href="user-profile/{{objectID}}"> {{{_highlightResult.employeeName.value}}} </a><br> <span>{{designation}}</span> </h2>
               <h3>{{department}}</h3>
               <h4><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:{{telno}}"> {{telno}}</a></h4>
               <h4><a href="mailto:{{email}}"><i class="fa fa-envelope-o" aria-hidden="true"></i> {{email}}</a></h4>
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
           <!-- <span class="noRecord" style="display: none;">No Record Found</span> -->
         </div>
      </div>
    </div>
</div>

<link href="<?php echo e(asset('frontend/css/jquery.mCustomScrollbar.min.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('frontend/js/bootstrap-select.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
<script type="text/javascript">
(function($){
  $(window).on("load",function(){
    $("#numMenu").mCustomScrollbar({
      scrollButtons:{enable:true},
      theme:"light-thick",
      scrollbarPosition:"outside"
    });
  });
})(jQuery);

$('#controls li a').click(
function(e){
    e.preventDefault();
    var that = this,
        $that = $(that),
        id = that.id,
        gallery = $('#gallery');
    if(id != ''){
      if (id == 'all') {
        id = '';
        gallery.find('li:hidden').show(600);
        gallery.find('li:hidden').parent().show(600);
        //search.helper.setQuery(id).search();
        $('.ais-hits').removeClass('ais-hits__empty');
        if($('.ais-hits').find('.noResult').length > 0){
          $('.noResult').remove();
        }
      }
      else {
        if(gallery.find('li').hasClass(id)){
          gallery.find('li.' + id + ':hidden').show(600);
          gallery.find('li').not('.' + id).hide(600);
          gallery.find('li.' + id + ':hidden').parent().show(600);
          gallery.find('li').not('.' + id).parent().hide(600);
          //$('.noRecord').css('display','none');
          $('.ais-hits').removeClass('ais-hits__empty');
          $('.noResult').remove();
        } else {
          gallery.find('li.' + id + ':hidden').show(600);
          gallery.find('li').not('.' + id).hide(600);
          gallery.find('li.' + id + ':hidden').parent().show(600);
          gallery.find('li').not('.' + id).parent().hide(600);
          //$('.noRecord').css('display','block');
          $('.ais-hits').addClass('ais-hits__empty');
          if($('.ais-hits').find('.noResult').length == 0){
            $('.ais-hits').append('<span class="noResult">No results</span>');
          }
        }
        //search.helper.setQuery(id).search();
      }
    }

});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.panel').click(function() {
    $('.slidemenu').toggleClass('clicked').addClass('unclicked');
    $('.menubar_icon_black').toggleClass('menubar_icon_cross');
  });
});
</script>

<link rel='stylesheet prefetch' href='https://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css'>
<script src='https://cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js'></script>
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="<?php echo e(asset('frontend/js/angoliaSearch.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>