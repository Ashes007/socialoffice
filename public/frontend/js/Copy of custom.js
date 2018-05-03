$(window).scroll(function(){
    if ($(window).scrollTop() >= 100) {
       $('.left-sidebar').addClass('fixed-side');
    }
    else {
       $('.left-sidebar').removeClass('fixed-side');
    }
});





////////second nav////////////
/*$(window).scroll(function(){
    'use strict';
    if ($(this).scrollTop() > 160){  
        $('.fixme').addClass("sccondbar");
    }
    else{
        $('.fixme').removeClass("sccondbar");
    }
});*/

$(window).scroll(function(){
 var availableScroll = $(document).height() - $(window).height();
     var x = $(window).scrollTop();
       if (x > 1525 || Math.abs(x - availableScroll) < 10) {
         $('.fixme').addClass("sccondbar");
     }
     else{
        $('.fixme').removeClass("sccondbar");
    }
 });

////////second nav////////////


////////group banner////////////
$(window).scroll(function(){
    'use strict';
    if ($(this).scrollTop() > 160){  
        $('.fixme .group-tag').addClass("fullbanner");
    }
    else{
        $('.fixme .group-tag').removeClass("fullbanner");
    }
});
////////group banner////////////



 $(window).scroll(function(){
    'use strict';
    if ($(this).scrollTop() > 330){  
        $('.left-sidebar').addClass("fixedleftbar");
    }
    else{
        $('.left-sidebar').removeClass("fixedleftbar");
    }
});


$(window).scroll(function(){
    'use strict';
    if ($(this).scrollTop() > 820){  
        $('.occasion').addClass("fixedrightbar");
    }
    else{
        $('.occasion').removeClass("fixedrightbar");
    }
});


/*$(window).scroll(function(){
    'use strict';
    if (($(this).scrollTop() > 80) || ($(this).scrollTop() > 1000)) {  
        $('.emDirectory-seaRch').addClass("fixedsearchbar");
    }
    else{
        $('.emDirectory-seaRch').removeClass("fixedsearchbar");
    }
});*/



$(window).scroll(function(){
 var availableScroll = $(document).height() - $(window).height();
     var x = $(window).scrollTop();
       if (x > 1525 || Math.abs(x - availableScroll) < 10) {
         $('.emDirectory-seaRch').addClass("fixedsearchbar");
     }
     else{
        $('.emDirectory-seaRch').removeClass("fixedsearchbar");
    }
 });




$('a.open_close').on("click",function() {
	$('.main-menu').toggleClass('show');
	$('.layer').toggleClass('layer-is-visible');
});

$('a#close_in').on("click",function() {
	$('.main-menu').removeClass('show');
	
});

$('a.show-submenu').on("click",function() {
	$(this).next().toggleClass("show_normal");
});
$('a.show-submenu-mega').on("click",function() {
	$(this).next().toggleClass("show_mega");
});
if($(window).width() <= 480){
	$('a.open_close').on("click",function() {
	$('.cmn-toggle-switch').removeClass('active')
});
}

$(window).bind('resize load',function(){
if( $(this).width() < 767 )
{
$('.collapse#collapseFilters').removeClass('in');
$('.collapse#collapseFilters').addClass('out');
}
else
{
$('.collapse#collapseFilters').removeClass('out');
$('.collapse#collapseFilters').addClass('in');
}   
});

////////back to top////////////

$(document).ready(function(){
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');

});

////////select////////////

$(document).ready(function () {
    $(".btn-select").each(function (e) {
        var value = $(this).find("ul li.selected").html();
        if (value != undefined) {
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
        }
    });
});

$(document).on('click', '.btn-select', function (e) {
    e.preventDefault();
    var ul = $(this).find("ul");
    if ($(this).hasClass("active")) {
        if (ul.find("li").is(e.target)) {
            var target = $(e.target);
            target.addClass("selected").siblings().removeClass("selected");
            var value = target.html();
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
        }
        ul.hide();
        $(this).removeClass("active");
    }
    else {
        $('.btn-select').not(this).each(function () {
            $(this).removeClass("active").find("ul").hide();
        });
        ul.slideDown(300);
        $(this).addClass("active");
    }
});

$(document).on('click', function (e) {
    var target = $(e.target).closest(".btn-select");
    if (!target.length) {
        $(".btn-select").removeClass("active").find("ul").hide();
    }
});


////////ebook filter///////////


if($(window).width() < 767)
{
   $(document).ready(function(){
	$('.ebook-left-sidebar h2').click(function(){
		$('.cat-list').slideToggle();
	});
});

} else {
   // change functionality for larger screens
}

$(document).on('click','.event_response',function () {   
      var ths     = $(this);
      var eventId = ths.attr('data-eventId');
      var status  = ths.attr('data-status');

      var AttendHtml = '<input type="button" class="go event_response atndBtn" data-eventId = "'+eventId+'" data-status="1" value="Attend"/>';
      var interestedHtml = '<input type="button" class="go event_response intBtn" data-eventId = "'+eventId+'" data-status="4" value="Interested"/>';
      var notInterestedHtml = '<input type="button" class="not_go event_response intBtn" data-eventId = "'+eventId+'" data-status="5" value="Not Interested"/>';
      var cancelHtml = '<input type="button" class="not_go event_response .canBtn" data-eventId = "'+eventId+'" data-status="6" value="Not Attend"/>';
      var attendText = '<span> - Attending</span>';
      var notAttendText = '<span class="not"> - Not Attending</span>';

      $.ajax({
        'type'  : 'post',
        'data'  : {eventId: eventId, status: status},
        'url'   : BASE_URL+'/event_response_ajax',
        'success': function(msg){

          if(msg == 'fail')
          {
                $.alert({
                      title: 'Sorry!',
                      content: 'This Event does not exists.',
                      icon: 'fa fa-close',
                      type: 'blue',
                      animation: 'scale',
                      closeAnimation: 'scale',
                      animateFromElement: false,
                      buttons: {
                          okay: {
                          text: 'Okay',
                          btnClass: 'btn-blue'
                          }
                      }
                  });
                return false;
          }
          
          if(status == 1)
          {
            ths.parent().append(cancelHtml); 
            ths.parent().parent().find('h3').find('a').find('span').remove(); 
            ths.parent().parent().find('h3').find('a').append(attendText); 
            ths.parent().find('.atndBtn').remove(); 

          }
          if(status == 2)
          {
            ths.parent().append(AttendHtml); 
            ths.parent().parent().find('h3').find('a').find('span').remove();
            ths.parent().parent().find('h3').find('a').append(notAttendText);
          }
          if(status == 3)
          {
            ths.parent().append(interestedHtml);
            ths.parent().append(notInterestedHtml);                     
          }          
          if(status == 4)
          {
            ths.parent().append(cancelHtml);
            ths.parent().parent().find('h3').find('a').find('span').remove(); 
            ths.parent().parent().find('h3').find('a').append(attendText);
            ths.parent().find('.intBtn').remove();
          }
          if(status == 5)
          {
            ths.parent().append(AttendHtml); 
            ths.parent().parent().find('h3').find('a').find('span').remove();
            ths.parent().parent().find('h3').find('a').append(notAttendText);
            ths.parent().find('.intBtn').remove();
          }
          if(status == 6)
          {
            
            ths.parent().append(AttendHtml); 
            ths.parent().parent().find('h3').find('a').find('span').remove();
            ths.parent().parent().find('h3').find('a').append(notAttendText);
            ths.remove();
          }
          ths.parent().find('.event_btn').remove();
          
        }
      });
    });