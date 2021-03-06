<?php  
	
	class KG_Loop_My_Quizes_Results {

		private $user_id;
		private $quizes_results_data;
		private $page;

		private $quantity_all_quizes_results;

		/* ==========================================================================
		   GET FROM DB
		   ========================================================================== */
		
		private function get_from_db() {
			$start_from = ( $this->page-1 ) * KG_Config::getPublic('quizes_results_per_page');
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("
					SELECT quiz_id FROM " . KG_Config::getPublic('table_quizes_results') . "
					WHERE user_id = %d 
					ORDER BY id DESC
					", $this->user_id,
					   KG_Config::getPublic('quizes_results_per_page')
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		private function count_all_quizes_results() {
			if( !empty($this->quantity_all_quizes_results) ) return $this->quantity_all_quizes_results;
			global $wpdb;
			$this->quantity_all_quizes_results = (int) $wpdb->get_var( 
				$wpdb->prepare("SELECT COUNT(id) FROM " . KG_Config::getPublic('table_quizes_results') . " WHERE user_id = %d", (int) $this->user_id)
			); 
			return $this->quantity_all_quizes_results;
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		public function render($data_from_db) {
			if (empty($data_from_db) ) return array(); 
			$out = [];
			foreach ($data_from_db as $quiz_data) {
				if($this->as_array){
					$out[] = KG_Get::get('KG_Quiz_Item', (int) $quiz_data['quiz_id'])->get_serialized_fields_for(get_current_user_id());
				} else {
					$out[] = KG_Get::get('KG_Quiz_Item', (int) $quiz_data['quiz_id'] );
				}
			}
			return $out;
		}

		public function __construct($user_id, $params = array()){
			$this->params = $params;
			$this->user_id = $user_id;
			$this->as_array = isset($params['as_array']) ? (bool) $params['as_array'] : true;
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
			 return (int) ceil($this->count_all_quizes_results() / KG_Config::getPublic('quizes_results_per_page'));
		}

		public function get_curr_page() {
			return $this->page;
		}

		public function get_numbers_found() {
			return $this->count_all_quizes_results();
		}
		
	}