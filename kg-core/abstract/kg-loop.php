<?php

	abstract class KG_Loop {

		abstract public function get($params);
		abstract public function get_default();
		abstract public function is_last_page();
		abstract public function get_page_numbers();
		abstract public function get_curr_page();
		abstract public function get_numbers_found();
	
		protected function get_params_to_query_by_filter_type($filter){

			if( in_array($filter, KG_Config::getPublic('subtypes_main')) ) {
				$meta_name = 'type';
			} else if( in_array($filter, KG_Config::getPublic('subtypes_link')) ){
				$meta_name = 'subtype';
			} else {
				// no subtype, is id of category
				return array(
					'category__in' => (int) $filter
				);
			}

			return array(
				'meta_query'	=> array(
					'relation'		=> 'AND',
					array(
						'key'	 	=> $meta_name,
						'value'	  	=> $filter,
						'compare' 	=> '=',
					),
				)
			);

		}

	}