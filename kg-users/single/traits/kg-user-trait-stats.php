<?php

	trait KG_User_Trait_Stats {

		private $user_stats_from_db;

		public function set_stats_data($data){
			$this->user_stats_from_db = $data;
		}

		public function get_stat_data(){
			if(!empty($this->user_stats_from_db)) return $this->user_stats_from_db;
			
			global $wpdb;
			$data = $wpdb->get_row(
				$wpdb->prepare( 
					"SELECT " . implode( ' , ' , KG_Config::getPublic('columns_user_table') ) .
					" FROM " . $wpdb->users .
					" WHERE ID = %d", 
					$this->user_id, 
					ARRAY_A
				)
			);
			$this->user_stats_from_db = ( !empty($data) ) ? (array) $data : null;
			return $this->user_stats_from_db; 
		}

		private function render_time_value($time){
			return strtotime("1970-01-01 $time UTC");
		}

		public function get_stat_value($name){
			if( !in_array($name, KG_Config::getPublic('columns_user_table')) ) return null;
			if( $name == 'sum_time_spent') return $this->render_time_value( $this->get_stat_data()[$name] );
			return $this->get_stat_data()[$name];
		}

		public function get_sum_downloads(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_downloads'] : 0 ;
		}

		public function get_sum_log_in(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_log_in'] : 0 ;
		}

		public function get_time_spend(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_time_spent'] : '00:00:00' ;
		}

		public function get_sum_donations(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_donations'] : 0 ;
		}

		public function get_sum_message(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_messages'] : 0 ;		
		}

		public function get_sum_likes_resources(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_likes_resources'] : 0 ;
		}

		public function get_sum_likes_responses(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_likes_tasks_responses'] : 0 ;
		}

		public function get_sum_quiz_results(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_quiz_results'] : 0 ;
		}

		public function get_sum_tasks_responses(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_task_responses'] : 0 ;
		}

		public function get_sum_presents(){
			return is_array($this->get_stat_data()) ? $this->get_stat_data()['sum_presents'] : 0 ;
		}

		public function get_last_login_formatted() {
			$date = !empty( $this->get_stat_data()['last_logged'] ) ? $this->get_stat_data()['last_logged'] : false;
			if ($date) {
				return 'Online: ' . KG_Get::get('KG_Date_Formatter_To_Time_Ago')->format($date);;
			} else {
				return '';
			}
		}  

	}