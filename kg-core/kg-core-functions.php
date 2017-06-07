<?php
	
	function KG_get_api_url($name) {
		return home_url(). KG_Config::getPublic($name);
	}

	function KG_is_local() {
		return ($_SERVER["HTTP_HOST"] == "kg.dev");
	}

	function KG_is_develop() {
		return ($_SERVER["HTTP_HOST"] == "kg.kodafive.com");
	}

	function KG_is_production() {
		return ($_SERVER["HTTP_HOST"] == "knowledgegarden.pl");
	}

	function KG_get_time() {
		return Ouzo\Utilities\Clock::now()->format('Y-m-d H:i:s');
	}

	function KG_get_time_obj() {
		return Ouzo\Utilities\Clock::now();
	}
