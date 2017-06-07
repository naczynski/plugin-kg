<?php

	class KG_Stat_Box_Top_Users extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-top-users', __( 'Użytkownicy (TOP 10)', 'kg' ), __FILE__);
		}

		public function render(){
			include plugin_dir_path( __FILE__ ) . 'view/kg-top-users.php';	
		}

		public function get_data_for_chart($type){

			$loop = KG_Get::get('KG_Loop_Box_Stat_Users_Table', array(
				'page' => 1,
				'sort_column_name' => $type,
				'sort_direction' => 'DESC',
				'users_per_page' => 10
			));
			$users = $loop->get();
			
			$data_names = array();
			$data_values = array();

			foreach ($users as $user) {
				$data_names[] = $user->get_name_and_surname();
				$data_values[] = $user->get_stat_value($type);
			}

			$label_type = ($type == 'sum_time_spent') ? 'time' : ' ';
			return $this->chart_config_obj(
				$data_names, 
				array(
					array(
						'data' => $data_values,
						'label' => $type
					)
				),
				$type, 
				$label_type);	
		}

	}
