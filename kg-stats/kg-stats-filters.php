<?php

	function KG_time_data_stat($time){
		if(is_array($time)){
			foreach ($time as $key => $time_single) {
				$time[$key] = strtotime("1970-01-01 $time_single UTC");
			}
		} else {
			$time = strtotime("1970-01-01 $time UTC");
		}

		return $time ? $time : 0;
	}

	add_filter('kg_time_stat_data', 'KG_time_data_stat', 1, 1);