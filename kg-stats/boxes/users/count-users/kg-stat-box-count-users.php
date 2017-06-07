<?php

	class KG_Stat_Box_Count_Users extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-count-users-stats', __( 'Ilość użytkowników', 'kg' ), __FILE__);
		}

		public function render(){
			include plugin_dir_path( __FILE__ ) . 'view/kg-count-users.php';	
		}

		private function get_col_name($type){
			if($type == 'count_users') return 'user_registered';
			return 'date_start';
		}

		private function get_query($type, $date_end){
			global $wpdb;
			switch($type){
				case 'count_users' :
					$table = $wpdb->users;
					return "SELECT COUNT('ID') AS data FROM {$table} WHERE user_registered < '{{DATE}}' "; 
					break;

				case 'count_active_users' :
					$table = KG_Config::getPublic('table_sessions');
					return "SELECT COUNT(distinct user_id) AS data FROM {$table} WHERE {{DATE_WHERE}} AND actions > 0";  
					break;

				case 'count_user_spent_more_than_before' :
					$table = KG_Config::getPublic('table_sessions');
					return "SELECT COUNT(distinct user_id) AS data FROM {$table} WHERE {{DATE_WHERE}} AND COUNT(spent_money) > (
						SELECT COUNT(spent_money) FROM {$table} WHERE 'user_id' = user_id AND {{DATE_WHERE_PREV_MONTH}} )
					"; 
					break;

				case 'count_user_spent_money' :
					$table = KG_Config::getPublic('table_sessions');
					return "SELECT COUNT(distinct user_id) AS data FROM {$table} WHERE {{DATE_WHERE}} AND spent_money > 0"; 
					break;
			}
		}

		public function get_data_for_chart($date_start, $date_end, $year, $type){

			$data = KG_Get::get('KG_Data_Base_Chart', 
				$date_start, 
				$date_end,
				$year, 
				'year', 
				$this->get_query($type, $date_end),
				$this->get_col_name($type)
			);

			return $this->chart_config_obj(
				$data->get_labels(), 
				array(
					array(
						'data' => $data->get_data(),
						'label' => $type
					)
				),
				$type

			);	

		}

	}
