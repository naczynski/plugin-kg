
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

			var $ACTION_FORM = $('#sent_message'),
				$PRELOADER = $('.spinner-send-message');

			$ACTION_FORM.on('submit', function(e){
				e.preventDefault();
				callAjax( $ACTION_FORM.serialize(), true, $PRELOADER );
			});

		});

	})(jQuery);
