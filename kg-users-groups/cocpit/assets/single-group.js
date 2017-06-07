
(function($){

	'use strict';
	
	var callAjax = function(data, reloaderAfter, $preloader) {

		$preloader.show();

		$.post(
			ajaxurl,
			data,
			function(response) {

				$preloader.hide();
				alert(response.message);

				if(reloaderAfter && !response.error) {
					window.location.reload();
				}

			},'json');

	};

	$(document).ready(function(){
	
		// Sent message

		var $Form = $('form[name=post]'),
			$PreloaderMessage = $('.spinner-send-message'),
			$ButtonSentMessage = $('.button-send-message');
			
		$ButtonSentMessage.on('click', function(e){
			var data = $Form.serialize().replace('&action=editpost', '&action=sent_message_group'); 
			e.preventDefault();
			callAjax(data , true, $PreloaderMessage );
			return false;
		});

		// Add present

		var $Form = $('form[name=post]'),
			$PreloaderPresent = $('.spinner-send-present'),
			$ButtonSentPresent = $('.button-send-present');
			
		$ButtonSentPresent.on('click', function(e){
			var message = $('[ name="message_present" ]').val();
			var present_ids = [];
			var presents = $('input[ name="fields[resources_ids][]" ]');
				
				presents.each(function(key, item){
					present_ids.push( parseInt(item.value) );
				});
				
			var data = $Form.serialize().replace('&action=editpost', '&action=send_present_group&ids=' + JSON.stringify(present_ids) + '&message_present=' + message ); 
			e.preventDefault();
			callAjax(data , true, $PreloaderPresent );
			return false;
		});

	});

})(jQuery);
