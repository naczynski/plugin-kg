
(function($){
	
	'use strict';

	var $document = $(document);
	
	$document.ready(function(){

		/**
		 * Count character of input
		 * @param input $el
		 * @param string label   
		 * @param int maxWords
		 */
		var Counter = function($el, label, maxWords) {

			var $remainingDiv = $( '<div class="remaining">').insertAfter($el);

			var update = function(words) {

				$remainingDiv.html(words + ' znaków pozostało');

			};

			$el.on('keyup', function() {

			    var lenght = $el.val().length;
			    var remaining = maxWords - lenght;
			   
			    update(remaining);

			});

			$el.trigger('keyup');

			// update(maxWords);

		};


		//title
		
		var $titles = $('[name=post_title]'); 
		
		$titles.each(function(){

			Counter($(this), 'title', 46 ); // title	

		});

	});


})(jQuery);
