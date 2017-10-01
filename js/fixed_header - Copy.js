$(document).ready(function() {
	
	
	$('#header_fixed').css('display', 'none');
	var site_intro = $('#site_intro').outerHeight();
	var header_1 = $('#header_1').height()/2;
	var totalHeight = site_intro + header_1;
	//$('#header_fixed').css('display','none');
	$(window).scroll(function(){
		var scroll_top = $(window).scrollTop();
		if(site_intro < scroll_top){
			$('#header_1').fadeOut('fast');
			$('#header_fixed').fadeIn(1000);
			$('#header_fixed').css('display', 'block');
			//$('#header_fixed').slideDown("slow");
		}
		if(scroll_top < site_intro){
			$('#header_fixed').fadeOut('fast');
			$('#header_fixed').css('display', 'none');
			$('#header_1').fadeIn('slow');
		}
	});
	
	
	
});