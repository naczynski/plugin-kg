
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
				action : 'kg_count_users',
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
					
					ChartInst = new Chart(document.getElementById("kg-count-users-canvas").getContext("2d")).Line(ajaxData.chart, {
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

	var $typeDataSelect;

	var dateStartCache;
	var dateEndCache;
	var yearCache;

	$(document).ready(function(){

		$typeDataSelect = $('#kg-count-users-stats [name="type_data_count_users"]');

		StatsUtilsKG.timeFiltering($('.kg-count-users-stats'), function(type, dateStart, dateEnd, year){
			dateStartCache = dateStart;
			dateEndCache = dateEnd;
			yearCache = year;
			updateGraph(dateStart, dateEnd, year, $typeDataSelect.val() );
		});

		$typeDataSelect.change(function(){
			updateGraph(dateStartCache, dateEndCache, yearCache, $typeDataSelect.val() );
		});

	});

})(jQuery);
