
(function($){

	'use strict';
	
	$(document).ready(function(){


		var progress = false;

		var $prelaoder = $('.spinner-add-user'),
			$form = $('#add-user-form'),
			data = {},
			$mainMessage = $('.main-message');


		/* Main Message
		   ========================================================================== */
		
		var showMainOkMessage = function(message){

			$mainMessage.attr('class', 'updated');
			$mainMessage.children().html("Poprawnie dodano nowego użytkownia");

		};

		var showMainErrorMessage = function(message){

			message = (typeof message !== 'undefined') ? message : "Wprowadzono niepoprawne dane";

			$mainMessage.attr('class', 'error');
			$mainMessage.children().html(message);

		};


		/* Fields Errors
		   ========================================================================== */
		
		var showFieldError = function(fieldObj) {
			
			var $input = $('[name="'+fieldObj.field+'"]'),
				$row = $input.parent().parent(), // <tr>
				$error = $input.next();

				$row.addClass('form-invalid');
				$error.html(fieldObj.message);

		};


		var showFieldsErrors = function(data){

			data.fieldsErrors.forEach(function(item){

				showFieldError(item);
				
			});

		};

		var resetForm = function(){

			$form[0].reset();

		};

		var hideErrors = function(){

			$('.form-invalid').removeClass('form-invalid');
			$('.error').html(' ');	

		};

		var onSuccecesCall = function(data){

			progress = false;

			window.scrollTo(0 , 0);

			$prelaoder.hide();

			if(data.error) {

				hideErrors();

				if(data.fieldsErrors) {

					showFieldsErrors(data);
					return;
				}

				if(data.message !== '') {

					showMainErrorMessage(data.message);
					return;

				}

				showMainErrorMessage();

			} else {

				hideErrors();
				showMainOkMessage();
				resetForm();

			}

		};
		

		$form.on('submit', function(e){

			e.preventDefault();

			if(progress) return;

			progress = true;

			$prelaoder.show();

			data = $form.serialize();

			$.post(
				ajaxurl,
				data,
				onSuccecesCall,
				'json'
			);
	
		});

	}); 

})(jQuery);
