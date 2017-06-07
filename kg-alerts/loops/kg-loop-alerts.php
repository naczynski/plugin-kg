<?php  
	
	class KG_Loop_Alerts {

		private $user_id;
		private $alerts_data;
		private $page;

		private $quantity_all_alerts;

		/* ==========================================================================
		   GET FROM DB
		   ========================================================================== */
		
		private function get_from_db() {
			$start_from = ( $this->page-1 ) * KG_Config::getPublic('alerts_per_page');
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_alerts') . "
					WHERE user_id = %d 
					ORDER BY date DESC
					LIMIT %d, %d
					", $this->user_id,
					   $start_from, 
					   KG_Config::getPublic('alerts_per_page')
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		private function count_all_alerts() {
			if( !empty($this->quantity_all_alerts) ) return $this->quantity_all_alerts;
			global $wpdb;
			$this->quantity_all_alerts = (int) $wpdb->get_var( 
				$wpdb->prepare("SELECT COUNT(id) FROM " . KG_Config::getPublic('table_alerts') . " WHERE user_id = %d", (int) $this->user_id)
			); 
			return $this->quantity_all_alerts;
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		public function render($data_from_db) {
			if (empty($data_from_db) ) return array(); 
			$out = [];
			foreach ($data_from_db as $single_item) {
				$out[] = KG_Get_Alert_Object($single_item);
			}
			return $out;
		}

		public function __construct($user_id, $params = array()){
			$this->params = $params;
			$this->user_id = $user_id;

			$this->page = ( !empty($params['page']) ) ? $params['page'] : 1;
		}

		public function get() {	
			$data_from_db = $this->get_from_db();
			return $this->render($data_from_db);
		}

		/* ==========================================================================
		   PROPERTIES
		   ========================================================================== */
		
		public function is_last_page() {
			if ( $this->get_numbers_found() == 0) return true;
			return ( $this->page == $this->get_page_numbers() ) ? true : false;
		}
		
		public function get_page_numbers() {
			 return (int) ceil($this->count_all_alerts() / KG_Config::getPublic('alerts_per_page'));
		}

		public function get_curr_page() {
			return $this->page;
		}

		public function get_numbers_found() {
			return $this->count_all_alerts();
		}
		
	}