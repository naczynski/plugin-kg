
(function($){

	'use strict';
	
	var page = 1;

	var $contentBox;
	var downloading = false;

	var bindEvents = function(){
		var $links = $('#kg-user-table .inside .page-numbers:not(.dots)');
		$links.on('click', function(e){
			e.preventDefault();
			page = parseInt($(this).attr('data-page'));
			onClick(page);
		});
		$('#kg-user-table .inside [name=column_name]').change(function(){
			onClick(page);
		});
		$('#kg-user-table .inside [name=order]').change(function(){
			onClick(page);
		});
	};


	var onClick = function(page){

		if(downloading) return;
		downloading = true;

		$.post(
			ajaxurl,
			jQuery.param({
				action : 'stat_user_table',
				page : page,
				sort_column_name : $('#kg-user-table [name=column_name]').val(),
				sort_direction : $('#kg-user-table [name=order]').val()
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

		$contentBox = $('#kg-user-table .inside');

		setTimeout(function(){
			onClick(1);
		}, 1500);
		
	});

})(jQuery);
