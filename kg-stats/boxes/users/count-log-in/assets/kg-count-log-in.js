
(function($){

	'use strict';
	
	var $contentBox;
	var downloading = false;

	var ChartInst = null;

	var updateGraph = function(dateStart, dateEnd, year, type){

		if(downloading) return;
		downloading = true;

		$.post(
			ajaxurl,
			jQuery.param({
				action : 'count_log_in',
				type : type,
				year: year,
				date_start : dateStart,
				date_end : dateEnd 
			}),
			function(ajaxData) {
				downloading = false;
				
				if(ajaxData.error){
					alert(ajaxData.message);
				} else {

					if(ChartInst){
						ChartInst.destroy();
					}

					ChartInst = new Chart(document.getElementById("count-log-in-canvas").getContext("2d")).Line(ajaxData.chart, {
						responsive : true,
						scaleLabel : function(data){
							return StatsUtilsKG.chartJsLabels(ajaxData.chart.labelType, data.value)(data.value);
						},
						tooltipTemplate : function(data){		
							return ajaxData.chart.labelType == 'time' ? StatsUtilsKG.secondsToTimeFormat(data.value) : data.value;
						}
					});	
				}
			    
			}, 'json');
	
	};	


	$(document).ready(function(){
		StatsUtilsKG.timeFiltering($('.kg-count-log-in'), function(type, dateStart, dateEnd, year){
			updateGraph(dateStart, dateEnd, year, type);
		});
	});

})(jQuery);
