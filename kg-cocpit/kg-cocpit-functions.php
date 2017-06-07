<?php

	// Stylizate pagination for cocpit
	function KG_pagination($params, $as_data_attr = false) {
		$pagination = '<div class="page_nav">' .  paginate_links($params) . '</div>';
		if(!$as_data_attr ) return $pagination ;

		return preg_replace(
			' />(\d*)<\/a>/',
			' data-page="$1">$1</a>',
			$pagination
		);
	}