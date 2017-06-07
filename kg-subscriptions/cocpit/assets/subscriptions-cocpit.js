
	acf.o = {};
	acf.o.ajaxurl = ajaxurl;
	acf.screen = {};
	acf.o.post_id = 0;
	acf.screen.post_id = 0;

	acf.l10n = {"core":{"expand_details":"Expand Details","collapse_details":"Collapse Details"},"validation":{"error":"Walidacja nie powiod\u0142a si\u0119. Jedno lub wi\u0119cej p\u00f3l jest wymaganych."},"image":{"select":"Wybierz obrazek","edit":"Edytuj zdj\u0119cie","update":"Aktualizuj obrazek","uploadedTo":"uploaded to this post"},"file":{"select":"Wybierz plik","edit":"Edytuj plik","update":"Aktualizuj plik","uploadedTo":"uploaded to this post"},"relationship":{"max":"Maksymalna liczba zosta\u0142a osi\u0105gni\u0119ta ( {max} )","tmpl_li":"\n\t\t\t\t\t\t\t<li>\n\t\t\t\t\t\t\t\t<a href=\"#\" data-post_id=\"<%= post_id %>\"><%= title %><span class=\"acf-button-remove\"><\/span><\/a>\n\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"<%= name %>[]\" value=\"<%= post_id %>\" \/>\n\t\t\t\t\t\t\t<\/li>\n\t\t\t\t\t\t\t"},"google_map":{"locating":"Locating","browser_support":"Sorry, this browser does not support geolocation"},"date_picker":{"closeText":"Done","currentText":"Today","monthNames":["Stycze\u0144","Luty","Marzec","Kwiecie\u0144","Maj","Czerwiec","Lipiec","Sierpie\u0144","Wrzesie\u0144","Pa\u017adziernik","Listopad","Grudzie\u0144"],"monthNamesShort":["sty","lut","mar","kwi","maj","cze","lip","sie","wrz","pa\u017a","lis","gru"],"monthStatus":"Show a different month","dayNames":["niedziela","poniedzia\u0142ek","wtorek","\u015broda","czwartek","pi\u0105tek","sobota"],"dayNamesShort":["nie","pon","wt","\u015br","czw","pt","sob"],"dayNamesMin":["N","P","W","\u015a","C","P","S"],"isRTL":false},"repeater":{"min":"Minimum rows reached ( {min} rows )","max":"Maximum rows reached ( {max} rows )"}};
	

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


			/* Activate
		   ========================================================================== */
			
			var $formUserAddSubscription = $('#add-subscription'),
				$formUserAddSubscriptionPreloader = $('.spinner-add-subscription');

			$formUserAddSubscription.on('submit', function(e){
				e.preventDefault();

				callAjax( $formUserAddSubscription.serialize(), true, $formUserAddSubscriptionPreloader );

			});

		});

	})(jQuery);
