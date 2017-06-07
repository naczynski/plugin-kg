
(function($){
	
	'use strict';
	
	var secondsToTimeFormat = function(seconds){
		var totalSec = parseInt(seconds);
		
		if(isNaN(totalSec)) return '00:00:00';

		var hours = parseInt( totalSec / 3600 ) % 24;
		var minutes = parseInt( totalSec / 60 ) % 60;
		var seconds = totalSec % 60;

		return (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);
	};


	var chartJsLabels = function(type, value){
		
		switch(type){
			case 'time' : return function(value){ return secondsToTimeFormat(value); }; break;
			case 'currency' : return value + 'zł'; return;
			default: return function(value){ return value; };
		};
	};


	/* Time filtering
	   ========================================================================== */
	
	var timeFiltering = function($filterWrapper, afterChange){

		var $typeSelect;
		var $yearSelect;
		var $weekSelect;

		var afterChangeHook;


		var dateStartSelected;
		var dateEndSelected;
		var selectedYear;

		var typeTimeFiltering = 'year';

		var getYearWeeksNumber = function(year){
			return moment('01 01 ' + year, "DD MM YYYY").isoWeeksInYear();
		};

		var getDateStartAndEndOfWeek = function(weekNo, year){

			var startDate = moment('01 01 ' + year, "DD MM YYYY").startOf('isoWeek').add( (weekNo - 1) * 7, 'days');
			var endDate = moment('01 01 ' + year, "DD MM YYYY").startOf('isoWeek').add( weekNo * 7, 'days');

			return {
				start : startDate,
				end : endDate
			};
		};

		var isCurrectWeekOfYear = function(startDate, endDate){	
			return moment().isBetween(startDate, endDate);
		};

		var getDataForYearWeekRange = function(year){
			var numberWeeks = getYearWeeksNumber(year);			
			var html = "";
			for (var week = 1; week <= numberWeeks; week++) {
				var data = getDateStartAndEndOfWeek(week, year);
				var selected = isCurrectWeekOfYear(data.start, data.end) ? 'selected' : '';
				var dateStartFormatted = data.start.format("DD-MM-YYYY");
				var dateEndFormatted = data.end.format("DD-MM-YYYY");

				if(week === 1 || selected=='selected'){
					dateStartSelected = dateStartFormatted;
					dateEndSelected = dateEndFormatted;
				}

				html += [
					'<option data-start="'+ dateStartFormatted +'" data-end="'+ dateEndFormatted  +'" ' + selected +'>',
						'Tydzień ' + week + ' (' + dateStartFormatted +' / ' + dateEndFormatted +') ',
					'</option>'
				].join('');

				if( selected !== '' ) {
					break;	
				}
			
			}

			return html;
		};

		var updateWeeksSelect = function(year){
			$weekSelect.html( getDataForYearWeekRange(year) );
		};

		var setTypeYear = function(){
			$weekSelect.hide();
			typeTimeFiltering = 'year';
			dateStartSelected = '01-01-'+selectedYear;
			dateEndSelected = '31-12-'+selectedYear;
		};

		var setTypeWeeks = function(){
			$weekSelect.show();
			updateWeeksSelect( selectedYear );
			typeTimeFiltering = 'week';
		};

		var callAfterChange = function(){
			afterChangeHook(typeTimeFiltering, dateStartSelected, dateEndSelected, selectedYear);
		};

		$typeSelect = $filterWrapper.find('select[name=type]');
		$yearSelect = $filterWrapper.find('select[name=year]');
		$weekSelect = $filterWrapper.find('select[name=week]');

		afterChangeHook = afterChange;

		$typeSelect.change(function(){
			var val = $(this).val();
			if(val == 'week'){
				setTypeWeeks();
			} else {
				setTypeYear();
			}
			callAfterChange();
		});

		$yearSelect.change(function(){
			var $this = $(this);
			selectedYear = $this.val();
			
			if(typeTimeFiltering == 'week'){
				updateWeeksSelect( selectedYear );
			}

			callAfterChange();
		});

		$weekSelect.change(function(event){
			var $this = $(this);
			var $optionSelected = $this.children(":selected");
			dateStartSelected = $optionSelected.attr('data-start');
			dateEndSelected = $optionSelected.attr('data-end');
			callAfterChange();
		});

		selectedYear = ( new Date() ).getFullYear();
		setTypeYear();
		callAfterChange();

	};

	window.StatsUtilsKG = {
		chartJsLabels : chartJsLabels,
		secondsToTimeFormat : secondsToTimeFormat,
		timeFiltering : timeFiltering
	};
	 
})(jQuery);
