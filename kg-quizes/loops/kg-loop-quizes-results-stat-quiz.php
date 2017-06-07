<?php  
	
	class KG_Loop_Quizes_Results_Stat_Quiz {

		private $user_id;
		private $quizes_results_data;
		private $page;

		private $quantity_all_quizes_results;

		/* ==========================================================================
		   GET FROM DB
		   ========================================================================== */
		
		private function get_from_db() {
			$start_from = ( $this->page-1 ) * KG_Config::getPublic('quizes_solves_stats_per_page');
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_quizes_results') . "
					ORDER BY {$this->sort_column_name} {$this->sort_direction}
					LIMIT %d, %d
					", $start_from ,
					   KG_Config::getPublic('quizes_solves_stats_per_page')
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		private function count_all_quizes_results() {
			if( !empty($this->quantity_all_quizes_results) ) return $this->quantity_all_quizes_results;
			global $wpdb;
			$this->quantity_all_quizes_results = (int) $wpdb->get_var( "SELECT COUNT(id) FROM " . KG_Config::getPublic('table_quizes_results')); 
			return $this->quantity_all_quizes_results;
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		public function render($data_from_db) {
			if (empty($data_from_db) ) return array(); 
			$out = [];
			foreach ($data_from_db as $quiz_data) {
				$out[] = KG_Get::get('KG_Single_Result_From_Data',  $quiz_data);
			}
			return $out;
		}

		public function __construct($params = array()){
			$this->params = $params;

			$this->page = ( !empty($params['page']) ) ? $params['page'] : 1;
			$this->users_per_page = ( !empty($params['users_per_page']) ) ? $params['users_per_page'] : 10;
			$this->sort_column_name = ( !empty($params['sort_column_name']) && in_array($params['sort_column_name'], KG_Config::getPublic('columns_quiz_results_table') ) ) ? $params['sort_column_name'] : 'ID';
			$this->sort_direction = ( !empty($params['sort_direction']) &&  in_array($params['sort_direction'], array('ASC' , 'DESC') ) )  ? $params['sort_direction'] : 'ASC';
	
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
			 return (int) ceil($this->count_all_quizes_results() / KG_Config::getPublic('quizes_solves_stats_per_page'));
		}

		public function get_curr_page() {
			return $this->page;
		}

		public function get_numbers_found() {
			return $this->count_all_quizes_results();
		}
		
	}