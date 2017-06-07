<?php

	class KG_Stat_Box_Count_Log_In extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-count-log-in', __( 'Ilość logowań', 'kg' ), __FILE__);
		}

		public function render(){
			include plugin_dir_path( __FILE__ ) . 'view/kg-count-log-in.php';	
		}

		public function get_data_for_chart($date_start, $date_end, $year, $type){

			$table = KG_Config::getPublic('table_sessions');

			$data = KG_Get::get('KG_Data_Base_Chart', 
				$date_start, 
				$date_end,
				$year, 
				$type, 
				"SELECT COUNT(id) AS count, user_id FROM {$table} WHERE {{DATE_WHERE}} GROUP BY(user_id)",
				'date_start',
				'count' );

			return $this->chart_config_obj(
				$data->get_labels(),
				array(
					array(
						'data' => $data->get_data(),
						'label' => $type
					)
				), 
				$type, 
				' ');	

		}

	}
