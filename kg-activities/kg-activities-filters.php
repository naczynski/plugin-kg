<?php

	function KG_parse_browser_string($string){
		$data = parse_user_agent($string);
		return $data['browser'] . ' ('. $data['version'] . ')';
	}
	add_filter('kg_parse_browser_string', 'KG_parse_browser_string', 1, 1);

	function KG_parse_device_string($string){
		return parse_user_agent($string)['platform'];
	}
	add_filter('kg_parse_device_string', 'KG_parse_device_string', 1, 1);