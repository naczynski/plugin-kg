<?php
	
	function KG_filter_price_for_payu($price) {
		return str_replace('.' , '', (string) sprintf("%.2f", $price) );
	}
	add_filter('kg_unit_price_payu', 'KG_filter_price_for_payu', 1, 1);

	
	function KG_filter_product_name_for_pay($name) {
		return strip_tags($name);
	}
	add_filter('kg_product_name_payu', 'KG_filter_product_name_for_pay', 1, 1);
	

	function KG_filter_quouts($name) {
		return str_replace('"', '\'', $name);
	}
	add_filter('kg_product_name_payu', 'KG_filter_quouts', 1, 2);


	function KG_price_netto($price) {
		return (1 - KG_Config::getPublic('vat_tax')) * $price;
	}
	add_filter('kg_price_netto', 'KG_price_netto', 1, 1);
