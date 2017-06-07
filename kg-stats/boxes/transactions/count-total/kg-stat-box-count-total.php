<?php

	class KG_Stat_Box_Count_Total extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-count-total', __( 'Zyski', 'kg' ), __FILE__);
		}

		public function render(){
			include plugin_dir_path( __FILE__ ) . 'view/kg-count-total.php';	
		}

		private function get_data_obj($column_name){
			$table = KG_Config::getPublic('table_transactions');

			return KG_Get::get('KG_Data_Base_Chart', 
				$this->date_start, 
				$this->date_end,
				$this->year, 
				$this->type, 
				"SELECT {$column_name} AS count FROM {$table} WHERE {{DATE_WHERE}} AND status='COMPLETED' ",
				'date',
				'count' 
			);
	
		}

		public function get_data_for_chart($date_start, $date_end, $year, $type){

			$this->date_start = $date_start;
			$this->date_end = $date_end;
			$this->year = $year;
			$this->type = $type;

			$data_presents_obj = $this->get_data_obj('SUM(total_presents)');
			$data_resources_obj = $this->get_data_obj('SUM(total_resources)');
			$data_subscriptions_obj = $this->get_data_obj('SUM(total_subscriptions)');
			
			$data_total = array();
			foreach ($data_presents_obj->get_data() as $key => $value) {
				$data_total[] = $value + $data_resources_obj->get_data()[$key] + $data_subscriptions_obj->get_data()[$key];
			}

			return $this->chart_config_obj(
				$data_presents_obj->get_labels(), 
				array(
					array(
						'label' => 'Zysk z prezentów',
						'data' => $data_presents_obj->get_data()
					),
					array(
						'label' => 'Zysk z kupna abonamentów',
						'data' => $data_subscriptions_obj->get_data()
					),
					array(
						'label' => 'Zysk z kupna zasobów',
						'data' => $data_resources_obj->get_data()
					),
					array(
						'label' => 'Suma',
						'data' => $data_total
					)	
				), 
				$type,
				'price',
				array(
					'sum-presents' => array_sum($data_presents_obj->get_data()),
					'sum-resources' => array_sum($data_resources_obj->get_data()),
					'sum-subsctiptions' => array_sum($data_subscriptions_obj->get_data()),
					'sum-total' => array_sum($data_total)
				)
			);	

		}

	}
