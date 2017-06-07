
(function($){

	'use strict';
	
	var $contentBox;
	var downloading = false;

	var bindEvents = function(){
		var $links = $('.page-numbers:not(.dots)');
		$links.on('click', function(e){
			e.preventDefault();
			var page = parseInt($(this).attr('data-page'));
			onClick(page);
		});

		var $removeButtons = $('.remove-response-button');
		$removeButtons.on('click', function(e){
			e.preventDefault();
			var $but = $(this);
			var responseId = parseInt($but.attr('data-id'));
			remove(responseId, $but);
		});
	};

	var remove = function(responseId, $but){

		if(downloading) return;
		downloading = true;

		var $prelaoder = $but.prev();
		$prelaoder.addClass('is-active');
		$prelaoder.show();

		$.post(
			ajaxurl,
			jQuery.param({
				response_id : responseId,
 				action : 'remove_response',
			}),
			function(data) {
				downloading = false;
				$prelaoder.removeClass('is-active');
				$prelaoder.hide();
				if(data.error){
					alert(data.message);
				} else {
					alert(data.message);
					$but.parent().parent().remove();	
				}	
			}, 'json');
	};

	var onClick = function(page){

		if(downloading) return;
		downloading = true;

		$.post(
			ajaxurl,
			jQuery.param({
				page : page,
				task_id : acf.post_id,
 				action : 'get_task_responses',
			}),
			function(data) {
				downloading = false;
				try { 
			        json = JSON.parse(data);
			    } catch(e){
			        $contentBox.html(data);
			        bindEvents();
			        return;
			    }
			    alert(json.message);	
			});
	
	};	

	$(document).ready(function(){

		$contentBox = $('#add_responses_meta .inside');

		setTimeout(function(){
			onClick(1);
		}, 1500);
		
	});

})(jQuery);
