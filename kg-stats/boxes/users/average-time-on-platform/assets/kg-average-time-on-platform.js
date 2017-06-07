
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
				action : 'average_time_on_platform',
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

					ChartInst = new Chart(document.getElementById("average-time-canvas").getContext("2d")).Line(ajaxData.chart, {
						responsive : true,
						scaleLabel : function(data){
							return StatsUtilsKG.chartJsLabels(ajaxData.chart.labelType, data.value)(data.value);
						},
						tooltipTemplate : function(data){		
							return StatsUtilsKG.secondsToTimeFormat(data.value);
						}
					});	
				}
			    
			}, 'json');
	
	};	


	$(document).ready(function(){
		StatsUtilsKG.timeFiltering($('.sort-average-time-spent'), function(type, dateStart, dateEnd, year){
			updateGraph(dateStart, dateEnd, year, type);
		});
	});

})(jQuery);
