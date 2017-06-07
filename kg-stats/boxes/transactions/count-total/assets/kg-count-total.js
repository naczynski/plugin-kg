
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
				action : 'kg_count_total',
				year: year,
				type: type,
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
					
					ChartInst = new Chart(document.getElementById("kg-count-total-canvas").getContext("2d")).Bar(ajaxData.chart, {
						responsive : true,
						scaleLabel : function(data){
							return StatsUtilsKG.chartJsLabels(ajaxData.chart.labelType, data.value)(data.value);
						},
						tooltipTemplate : function(data){		
							return ajaxData.chart.labelType == 'time' ? StatsUtilsKG.secondsToTimeFormat(data.value) : data.value;
						},
						multiTooltipTemplate: function(data){

							console.log(data);
					
							return data.datasetLabel + " (" + data.value + "zł) ";
						}
					});	

					$('#kg-count-total .sum-total').html(ajaxData.chart['sum-total']);
					$('#kg-count-total .sum-presents').html(ajaxData.chart['sum-presents']);
					$('#kg-count-total .sum-resources').html(ajaxData.chart['sum-resources']);
					$('#kg-count-total .sum-subsctiptions').html(ajaxData.chart['sum-subsctiptions']);
	
				}
			    
			}, 'json');
	
	};	

	var $typeDataSelect;

	var dateStartCache;
	var dateEndCache;
	var yearCache;

	$(document).ready(function(){

		StatsUtilsKG.timeFiltering($('.kg-count-total'), function(type, dateStart, dateEnd, year){
			dateStartCache = dateStart;
			dateEndCache = dateEnd;
			yearCache = year;
			updateGraph(dateStart, dateEnd, year, type);
		});

	});

})(jQuery);
