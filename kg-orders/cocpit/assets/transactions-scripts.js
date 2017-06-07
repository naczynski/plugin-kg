
(function($){

	var download = false;

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

				download = false;

			},'json');

	};

	$(document).ready(function(){

		/* Pay For Transaction
	   ========================================================================== */
		
		

		var $PayTransactionButton = $('.button-pay'),
			$formPayTransactionPrelaoder = $('.spinner-transactions');

		$PayTransactionButton.on('click', function(e){
			e.preventDefault();
			
			if(download) return false;	

			var data = JSON.parse($PayTransactionButton.attr('data-ajax-params'));
			callAjax( data, true, $formPayTransactionPrelaoder );
			return false;
		});		

	});

})(jQuery);
