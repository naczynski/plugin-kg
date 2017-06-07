<?php  
	
	class KG_Loop_Tasks_Responses {

		private $task_id;
		private $tasks_data;
		private $page;

		private $quantity_all_tasks;

		/* ==========================================================================
		   GET FROM DB
		   ========================================================================== */
		
		private function get_from_db() {
			$start_from = ( $this->page-1 ) * KG_Config::getPublic('tasks_responces_per_page');
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_tasks_reponses') . "
					WHERE task_id = %d 
					ORDER BY date ASC
					LIMIT %d, %d
					", $this->task_id,
					   $start_from, 
					   KG_Config::getPublic('tasks_responces_per_page')
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		private function count_all_tasks() {
			if( !empty($this->quantity_all_tasks) ) return $this->quantity_all_tasks;
			global $wpdb;
			$this->quantity_all_tasks = (int) $wpdb->get_var( 
				$wpdb->prepare("SELECT COUNT(id) FROM " . KG_Config::getPublic('table_tasks_reponses') . " WHERE task_id = %d", (int) $this->task_id)
			); 
			return $this->quantity_all_tasks;
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		public function render($data_from_db) {
			if (empty($data_from_db) ) return array(); 
			$out = [];
			foreach ($data_from_db as $single_item) {
				$out[] = KG_Get::get('KG_Task_Response', $single_item);
			}
			return $out;
		}

		public function __construct($task_id, $params = array()){
			$this->params = $params;
			$this->task_id = $task_id;
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
			 return (int) ceil($this->count_all_tasks() / KG_Config::getPublic('tasks_responces_per_page'));
		}

		public function get_curr_page() {
			return $this->page;
		}

		public function get_numbers_found() {
			return $this->count_all_tasks();
		}
		
	}