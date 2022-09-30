$(document).ready ( function() {
	
	$('.simple_lightbox_trigger').click(function(e) {
		
		//prevent default action (hyperlink)
		e.preventDefault();
		
		//Get clicked link href
		var image_href = $(this).attr("href");
		
		if ($('#simple_lightbox').length > 0) { // #lightbox exists
			
			//place href as img src value
			$('#simple_lightbox_content').html('<img src="' + image_href + '" />');
		   	
			//show lightbox window - you could use .show('fast') for a transition
			$('#simple_lightbox').show();
		}
		
		else { //#lightbox does not exist - create and insert (runs 1st time only)
			
			//create HTML markup for lightbox window
			var lightbox = 
			'<div id="simple_lightbox">' +
				'<div id="d-flex align-items-start simple_lightbox_content">' + //insert clicked link's href into img src
					'<img src="' + image_href +'" />' +
					'<div class="closeBtn"><i class="fa-solid fa-xmark"></i></div>' +
				'</div>' +	
			'</div>';
				
			//insert lightbox HTML into page
			$('body').append(lightbox);
		}
		
	});
	
	//Click anywhere on the page to get rid of lightbox window
	$('body').on('click', '#simple_lightbox', function() { //must use on, as the lightbox element is inserted into the DOM
		$('#simple_lightbox').hide();
	});

});
