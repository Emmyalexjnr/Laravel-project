$(document).ready(function() {
		var contentWidth = $('#content-box').width(),
		    initialHeight = $('#pix').height() + $('#site_intro').height() + $('#header_1').height() - 400,
			cssObj = {
				'position' : 'relative', 
				'left' : -contentWidth - 50
				//'display' : 'none'
				};
			
		$('#content-box').css(cssObj);	
		
		//alert(Math.floor(initialHeight));
		
		var window_height = $(window).height() - 400;
		var scroll_top1 = $(window).scrollTop();
		//var difference = scroll_top1 - window_height;
		if(scroll_top1 >= Math.floor(initialHeight)){
				$('#content-box').animate({ left: "0" }, 1000, "swing");
				}
		
		if(scroll_top1 > window_height){
				$('#arrow_up').fadeIn(1000);
			}else{
				$('#arrow_up').css('display', 'none');
			}
		$(window).scroll(function(){
			var window_height = $(window).height() - 400;
			var scroll_top = $(window).scrollTop();
			
			if(scroll_top > window_height){
				$('#arrow_up').fadeIn(1000);
			}
			if(scroll_top < window_height){
				$('#arrow_up').fadeOut(1000);
			}
			
			if(scroll_top >= Math.floor(initialHeight)){
				$('#content-box').animate({ left: "0" }, 2000, "swing");
				}
			
		});
		
		$('#arrow_up').click(function(){
			$('html, body').animate({ scrollTop: 0}, 1000, 'swing');
		});
		
		

});