<?php  
	
	class KG_Loop_Transactions {

		private $user_id;
		private $alerts_data;
		private $page;

		private $quantity_all_user_transactions;

		/* ==========================================================================
		   GET FROM DB
		   ========================================================================== */
		
		private function get_from_db() {
			$start_from = ( $this->page-1 ) * KG_Config::getPublic('transactions_per_page_cocpit');
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_transactions') . "
					ORDER BY {$this->sort_column} DESC
					LIMIT %d, %d
					", 
					   $start_from, 
					   KG_Config::getPublic('transactions_per_page_cocpit')
					 ),
				ARRAY_A 
			); 
			return $data;
		}

		private function count_all_user_transactions() {
			if( !empty($this->quantity_all_user_transactions) ) return $this->quantity_all_user_transactions;
			global $wpdb;
			$this->quantity_all_user_transactions = (int) $wpdb->get_var( 
				"SELECT COUNT(id) FROM " . KG_Config::getPublic('table_transactions')
			); 
			return $this->quantity_all_user_transactions;
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		public function render($data_from_db) {
			if (empty($data_from_db) ) return array(); 
			$out = [];
			foreach ($data_from_db as $single_item) {
				$out[] = KG_Get::get('KG_Transaction', $single_item);
			}
			return $out;
		}

		public function __construct($params = array()){
			$this->params = $params;
			
			$this->page = ( !empty($params['page']) ) ? $params['page'] : 1;
			$this->sort_column = ( !empty($params['sort_column']) ) ? $params['sort_column'] : 'date';
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
			 return (int) ceil($this->count_all_user_transactions() / KG_Config::getPublic('transactions_per_page_cocpit'));
		}

		public function get_curr_page() {
			return $this->page;
		}

		public function get_numbers_found() {
			return $this->count_all_user_transactions();
		}
		
	}