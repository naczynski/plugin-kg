<?php

	trait KG_Item_Trait_Stats {


		private $stats_from_db;

		public function get_stat_data(){
			if(!empty($this->stats_from_db)) return $this->stats_from_db;
			
			global $wpdb;
			$data = $wpdb->get_row(
				$wpdb->prepare( 
					"SELECT " . implode( ' , ' , KG_Config::getPublic('columns_posts_table') ) .
					" FROM " . $wpdb->posts .
					" WHERE ID = %d", 
					$this->id, 
					ARRAY_A
				)
			);
			$this->stats_from_db = ( !empty($data) ) ? (array) $data : null;
			return $this->stats_from_db; 
		}

		public function get_stat_value($name){
			if( !in_array($name, KG_Config::getPublic('columns_posts_table')) ) return null;
			return $this->get_stat_data()[$name];
		}

	}