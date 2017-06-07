<?php  
	
	class KG_Loop_Box_Stat_Session_Table {

		private $user_data;
		private $page;
		private $users_per_page;
		private $sort_column_name;
		private $sort_direction;

		private $quantity_all_users;

		/* ==========================================================================
		   GET FROM DB
		   ========================================================================== */
		
		private function get_from_db() {
			$start_from = ( $this->page-1 ) * $this->users_per_page;
			global $wpdb;

			$columns = 'ID , ' . implode( ',' , KG_Config::getPublic('columns_user_table') );

			$data = $wpdb->get_results( 
				$wpdb->prepare(
					"SELECT {$columns} 
					 FROM {$wpdb->users}
					 ORDER BY {$this->sort_column_name} {$this->sort_direction}
					 LIMIT %d, %d",
					 $start_from, 
					 $this->users_per_page
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		public function render($data_from_db) {
			if (empty($data_from_db) ) return array(); 
			$out = [];
			foreach ($data_from_db as $single_item) {
				$obj =  KG_Get::get('KG_User', $single_item['ID']);
				$obj->set_stats_data($single_item);
				$out[] = $obj;
			}
			return $out;
		}

		public function __construct($params = array()){
			$this->params = $params;

			$this->page = ( !empty($params['page']) ) ? $params['page'] : 1;
			$this->users_per_page = ( !empty($params['users_per_page']) ) ? $params['users_per_page'] : 10;
			$this->sort_column_name = ( !empty($params['sort_column_name']) && in_array($params['sort_column_name'], KG_Config::getPublic('columns_user_table') ) ) ? $params['sort_column_name'] : 'ID';
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
			 return (int) ceil($this->count_all_users() /  $this->users_per_page);
		}

		public function get_curr_page() {
			return $this->page;
		}

		public function get_numbers_found() {
			return $this->count_all_users();
		}
		
	}