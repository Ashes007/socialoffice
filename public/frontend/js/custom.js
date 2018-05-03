/*$(window).load(function(){
  $("#exTab2").css({"padding-top":"35px", "padding-bottom":"35px"});
  $("#exTab2").find(".row").css({"padding-bottom":"45px"});
});*/
$(window).scroll(function() {
    if ($(window).scrollTop() >= 100) {
        $('.left-sidebar').addClass('fixed-side');
    } else {
        $('.left-sidebar').removeClass('fixed-side');
    }
});


////////second nav////////////


////////group banner////////////
$(window).scroll(function() {
	var windowSize = $(window).width();
    var sticky = $('.fixme'),
        scroll = $(window).scrollTop();       

    if (scroll >= 220) {
        sticky.addClass('fixedTO');
        $("#exTab2").css({ "margin-top": "88px"});
    } else {
        sticky.removeClass('fixedTO');
        $("#exTab2").removeAttr("style");

    }


});


////////group banner////////////



$(window).scroll(function() {
    'use strict';
    if ($(this).scrollTop() > 330) {
        $('.left-sidebar').addClass("fixedleftbar");
    } else {
        $('.left-sidebar').removeClass("fixedleftbar");
    }
});

window.onload = function(){
	var thisTop = $('.mygrouping').offset().top;
	console.log('thisTop ', thisTop);
	$(window).scroll(function() {
		'use strict';
		if ($(this).scrollTop() > thisTop - 120) {
			$('.mygrouping').addClass("fixedrightbar");
			$(".grouping").css({ "margin-top": "-98px"});
		} else {
			$('.mygrouping').removeClass("fixedrightbar");
			$(".grouping").removeAttr("style");
		}
	});
}


//////////////////////////




/////////////////////////



$(window).scroll(function() {
    var availableScroll = $(document).height() - $(this).height();
    var x = $(this).scrollTop();
    if ($(document).height() >= $(this).scrollTop() + $(this).innerHeight()) {
        if (x > 1525 || Math.abs(x - availableScroll) < 10) {
            $('.emDirectory-seaRch').addClass("fixedsearchbar");
        } else {
            $('.emDirectory-seaRch').removeClass("fixedsearchbar");
        }
    } else {
        return false;
    }

});



$('a.open_close').on("click", function() {
    $('.main-menu').toggleClass('show');
    $('.layer').toggleClass('layer-is-visible');
});

$('a#close_in').on("click", function() {
    $('.main-menu').removeClass('show');

});

$('a.show-submenu').on("click", function() {
    $(this).next().toggleClass("show_normal");
});
$('a.show-submenu-mega').on("click", function() {
    $(this).next().toggleClass("show_mega");
});
if ($(window).width() <= 480) {
    $('a.open_close').on("click", function() {
        $('.cmn-toggle-switch').removeClass('active')
    });
}

$(window).bind('resize load', function() {
    if ($(this).width() < 767) {
        $('.collapse#collapseFilters').removeClass('in');
        $('.collapse#collapseFilters').addClass('out');
    } else {
        $('.collapse#collapseFilters').removeClass('out');
        $('.collapse#collapseFilters').addClass('in');
    }
});

////////back to top////////////

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function() {
        //$('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    //$('#back-to-top').tooltip('show');

});

////////select////////////

$(document).ready(function() {
    $(".btn-select").each(function(e) {
        var value = $(this).find("ul li.selected").html();
        if (value != undefined) {
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
        }
    });
});

$(document).on('click', '.btn-select', function(e) {
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
    } else {
        $('.btn-select').not(this).each(function() {
            $(this).removeClass("active").find("ul").hide();
        });
        ul.slideDown(300);
        $(this).addClass("active");
    }
});

$(document).on('click', function(e) {
    var target = $(e.target).closest(".btn-select");
    if (!target.length) {
        $(".btn-select").removeClass("active").find("ul").hide();
    }
});


////////ebook filter///////////


if ($(window).width() < 767) {
    $(document).ready(function() {
        $('.ebook-left-sidebar h2').click(function() {
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
      var ths = $("[data-eventId='" + eventId + "'][data-status='" + status + "']");

      var AttendHtml = '<input type="button" class="go event_response atndBtn" data-eventId = "'+eventId+'" data-status="1" value="'+lang.get('event.attend')+'"/>';
      var interestedHtml = '<input type="button" class="go event_response intBtn" data-eventId = "'+eventId+'" data-status="1" value="'+lang.get('event.interested')+'"/>';
      var notInterestedHtml = '<input type="button" class="not_go event_response intBtn" data-eventId = "'+eventId+'" data-status="6" value="'+lang.get('event.not_interested')+'"/>';
      var cancelHtml = '<input type="button" class="not_go event_response canBtn" data-eventId = "'+eventId+'" data-status="6" value="'+lang.get('event.not_attend')+'"/>';
      var attendText = '<span> - '+lang.get('event.attending')+'</span>';
      var notAttendText = '<span class="not"> - '+lang.get('event.not_attending')+'</span>';

      $.ajax({
        'type'  : 'post',
        'data'  : {eventId: eventId, status: status},
        'url'   : BASE_URL+'/event_response_ajax',
        'success': function(msg){

          if(msg == 'fail')
          {

                $.alert({
                    title: lang.get('event.sorry'),
                    content: lang.get('event.This_Event_does_not_exists'),
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
            ths.parent().find('.intBtn').remove();
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
            ths.parent().find('.intBtn').remove();
            ths.remove();
          }
          ths.parent().find('.event_btn').remove();

        }
    });
});


/////////////////////cursor blink in top search//////////

$(document).ready(function() {
    $('.sb-icon-search').click(function() {

        if ($(".aa-input-container").hasClass("open")) {
            $('#aa-search-input').focus();

        } else {
            $('#aa-search-input').blur();
        }

    });

    $('#notific').click(function(){
        unread_notification = 0;
        $('.unread_notification').html('');
        $('.unread_notification').hide();
        $.ajax({
            type : 'POST',
            data : {user_id : LoggedInUser},
            url  : BASE_URL+'/update-notification-count',
            success : function(res){
               
            }
       });
    });
});



////////// Realtime Notification /////////////////////////////
    
    socket.on('user_message'+LoggedInUser, function (data) {
        unread_notification++;

        if(unread_notification > 99)
        {
            $('.unread_notification').html('99+');
        }
        else
        {
            $('.unread_notification').html(unread_notification);
        }
        $('.unread_notification').show();
        $( ".notific-cont" ).prepend( "<p>"+data+"</p>" );
        $('.notific-cont-single').last().remove();
      });



////////// Realtime Notification /////////////////////////////

////////// Realtime Recent Update /////////////////////////////


    socket.on('recent_update'+LoggedInUser, function (data) {   
       var  getData     = JSON.parse(data);    
       var feed_id      = getData.feed_id;

       $.ajax({
            type : 'POST',
            data : {feed_id : feed_id},
            url  : BASE_URL+'/socket-recent-update',
            success : function(res){
                if(res != 0)
                {
                    //$('#new_post_alert').show();
                    $( ".recent_update_section" ).prepend( res );    
                    $(".recent_update").last().remove();
                } 
            }
       });

    });

    socket.on('new_post_update'+LoggedInUser, function (data) {        
        $('#new_post_alert').show();
    });


////////// Realtime Recent Update /////////////////////////////

////////// new post button /////////////////////////////

$(window).scroll(function() {
    if ($(window).scrollTop() >= 100) {
        $('.new_post_alert').addClass('fixed-post');
    } else {
        $('.new_post_alert').removeClass('fixed-post');
    }
});