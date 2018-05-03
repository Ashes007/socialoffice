// jquery >> Responsive Colorbox >>>>>>>>>>>>>>>>

(function($){
	// -- ColorBox Init --------------------------------------------------------------------------------------------------
	var resizeTimer, ct, winWidth = $(window).width();
	//
	$(window).resize(function(){
		if (resizeTimer) ct = clearTimeout(resizeTimer);
		resizeTimer = window.setTimeout(function() {
			if ($('#cboxOverlay').is(':visible')) {
				$.colorbox.load(true);
			}
		}, 300);
	});
	//
	if (winWidth >= 1024) {
		$('.cb-youtube').colorbox({speed:500, opacity:0.5, iframe:true, innerWidth:'80%', innerHeight:'80%', maxWidth:'80%', maxHeight:'80%'});
		$('.cb-images').colorbox({rel:'image-group', speed:500, opacity:0.5, innerWidth:'80%', innerHeight:'80%', maxWidth:'80%', maxHeight:'80%'});
	} if (winWidth < 1024) {
		$('.cb-youtube').colorbox({transition:'fade', speed:500, opacity:0.5, iframe:true, innerWidth:'80%', innerHeight:'50%', maxWidth:'80%', maxHeight:'50%'});
		$('.cb-images').colorbox({rel:'image-group', speed:500, opacity:0.5, innerWidth:'80%', innerHeight:'50%', maxWidth:'80%', maxHeight:'50%'});
	} // etc...

})(jQuery);