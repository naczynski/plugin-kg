<?php

	class KG_Stat_Box_Average_Time_On_Platform extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-average-time-on-platform', __( 'Średni czas spędzony na platformie', 'kg' ), __FILE__);
		}

		public function render(){
			include plugin_dir_path( __FILE__ ) . 'view/kg-average-time-on-platform.php';	
		}

		public function get_data_for_chart($date_start, $date_end, $year, $type){

			$table = KG_Config::getPublic('table_sessions');

			$data = KG_Get::get('KG_Data_Base_Chart', 
				$date_start, 
				$date_end,
				$year, 
				$type, 
				"SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(`time_spent`))) AS average FROM {$table} WHERE {{DATE_WHERE}} ",
				'date_start',
				'average' );

			return $this->chart_config_obj(
				$data->get_labels(),
				array(
					array(
						'data' => apply_filters('kg_time_stat_data', $data->get_data() ),
						'label' => $type
					)
				),
				$type, 
				'time');	

		}

	}
	