$(document).ready(function() {
	
	$('#comment_form').submit(function(e){
		 e.preventDefault();
		var filter = $('form[id=comment_form]').attr('data-filter');
		var author = $('#author').val();
		var comment = $('#body').val();
		var id = $('#id').val();
		if(filter == 'photo'){
			var url = '../processes/photo_process.php';
		}
		if(filter == 'card'){
			var url = '../processes/card_process.php';
		}
		if(filter == 'web'){
			var url = '../processes/web_process.php';
		}
		$.ajax({
			type:'POST',
			//url: '../processes/process_test.php',
			url: url,
			//data: formData,
			data: 'author='+author+'&comment='+comment+'&id='+id,
			success: function(data){
				var data = jQuery.parseJSON(data);
				//console.log(data[0]);
				var output = '';
				output += '<div><span class="fa fa-user"></span> ';
            		output += data[0].author+' wrote:';
        		output += '</div>';
        		output += '<div>';
            		output += data[0].body;
				output += '</div>';
				output += '<div class="created"><i>';
					output += data[1];	
				output += '</div></i>';
				//console.log(output);
				$('#comments').prepend(output);
				author = $('#author').val('');
				comment = $('#body').val('');
				$('#no_comment').css('display', 'none');
				$('html, body').animate({
						scrollTop: $('#comments').offset().top
						}, 'slow');
				
			}
		})
	});
	
	//
	
    //var form = $('#comment_form');
//	$(form).submit(function(e) {
//        e.preventDefault()
//		var formData = $(form).serialize();
//		var url = $(form).attr('action', '../../processes/photo_process.php');
//		alert(url);
//		$.ajax({
//			type: 'POST',
//			url: url,
//			data: formData,
//			success: function(data){
//				alert(data);
//			}	
//		})
//		
//    });
});