
(function($){

	'use strict';
	
	var page = 1;

	var ChartInst = null;

	var $contentBox;
	var downloading = false;

	var bindEvents = function(){
		$('#kg-top-users [name=column_name]').change(function(){
			updateGraph($(this).val());
		});
	};

	var updateGraph = function(type){

		if(downloading) return;
		downloading = true;

		$.post(
			ajaxurl,
			jQuery.param({
				action : 'stat_top_users',
				type : type
			}),
			function(ajaxData) {
				downloading = false;
				
				if(ajaxData.error){
					alert(ajaxData.message);
				} else {

					if(ChartInst){
						ChartInst.destroy();
					}
					
					ChartInst = new Chart(document.getElementById("top-users-chart-canvas").getContext("2d")).Bar(ajaxData.chart, {
						responsive : true,
						scaleLabel : function(data){
							return StatsUtilsKG.chartJsLabels(ajaxData.chart.labelType, data.value)(data.value);
						},
						tooltipTemplate : function(data){		
							return data.datasetLabel == 'sum_time_spent' ? StatsUtilsKG.secondsToTimeFormat(data.value) : data.value;
						}
					});	
				}
			    
			}, 'json');
	
	};	

	$(document).ready(function(){

		$contentBox = $('#kg_stat_box_user_table .inside');
		bindEvents();
		updateGraph('sum_log_in');

	});

})(jQuery);
