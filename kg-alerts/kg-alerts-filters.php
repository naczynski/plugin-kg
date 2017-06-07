<?php

	function KG_substing_text($string, $characters = 8){
		if(strlen($string) <= $characters) return $string;
		return substr($string, 0, $characters ) . '...';
	}
	add_filter('kg_title_task_alert', 'KG_substing_text', 1, 2);