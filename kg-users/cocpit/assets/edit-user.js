
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

		/* Email change
		   ========================================================================== */

		var $formEmailChange = $('#change-email-form'),
			$formEmailChangePreloader = $('.spinner-edit-email');

		$formEmailChangePreloader

		$formEmailChange.on('submit', function(e){
			e.preventDefault();

			callAjax( $formEmailChange.serialize(), false, $formEmailChangePreloader);
		
		});

		/* Change fields
		   ========================================================================== */
		
		var $formFieldsChange = $('#change-filelds-form'),
			$formFieldsChangePreloader = $('.spinner-change-fields');

		$formFieldsChange.on('submit', function(e){
			e.preventDefault();

			callAjax( $formFieldsChange.serialize(), true, $formFieldsChangePreloader );

		});

		/* Networking
	   ========================================================================== */
		
		var $formNetworkingChange = $('#form-networking'),
			$formNetworkingChangePreloader = $('.spinner-change-networking');

		$formNetworkingChange.on('submit', function(e){
			e.preventDefault();

			callAjax( $formNetworkingChange.serialize(), true, $formNetworkingChangePreloader );

		});

		/* Email Activate
	   ========================================================================== */
		
		var $formEmailActivateChange = $('#form-email-activate'),
			$formEmailActivationPreloader = $('.spinner-change-email-activate');

		$formEmailActivateChange.on('submit', function(e){
			e.preventDefault();

			callAjax( $formEmailActivateChange.serialize(), true, $formEmailActivationPreloader );

		});	

		/* Send Email Activation
	   ========================================================================== */
		
		var $formEmailSendActivateChange = $('#form-email-send'),
			$formEmailSendActivationPreloader = $('.spinner-change-email-send');

		$formEmailSendActivateChange.on('submit', function(e){
			e.preventDefault();

			callAjax( $formEmailSendActivateChange.serialize(), true, $formEmailSendActivationPreloader );

		});	


		/* Activate
	   ========================================================================== */
		
		var $formUserActivateChange = $('#form-active'),
			$formUserActivatePreloader = $('.spinner-change-active');

		$formUserActivateChange.on('submit', function(e){
			e.preventDefault();

			callAjax( $formUserActivateChange.serialize(), true, $formUserActivatePreloader );

		});

		/* Change Type
	   ========================================================================== */
		
		var $formTypeChangeForm = $('#form-type'),
		    $typeChangeSelect = $formTypeChangeForm.find('select[name="type"]'),
			$formUserTypePreloader = $('.spinner-change-type');

		$typeChangeSelect.on('change', function(e){

			e.preventDefault();
			callAjax( $formTypeChangeForm.serialize(), true, $formUserTypePreloader );

		});		

	});

})(jQuery);
