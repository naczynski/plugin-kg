<?php

	class KG_Data_Base_Chart {

		private $date_start;
		private $date_end;

		private $date_where;

		private $query_pattern;

		private $data = array();
		private $labels = array();

		private $date_column = 'date';
		private $name_query = 'data';

		public function __construct($date_start, $date_end, $year, $type, $query, $date_column = 'date', $column_name = 'data'){
			$this->date_start = $date_start;
			$this->date_end = $date_end;
			$this->type = $type;
			$this->year = $year;
			$this->date_column = $date_column;
			$this->column_name = $column_name ;
		
			$this->query_pattern = $query;
			$this->run_query();
		}


		private function exec_query($query){
			global $wpdb;

			$query_result =  $wpdb->get_row( $query, ARRAY_A );
			
			if($query_result[$this->column_name]) {
				$this->data[] = $query_result[$this->column_name];
			} else {
				$this->data[] = 0;
			}

		}

		private function is_future_date($day, $month, $year){
			$date = new DateTime($day . '-' . $month . '-' . $year);
			$current_date = new DateTime();
			return $date > $current_date;
		}

		private function run_query_week_type(){
			global $wpdb;

			for ($i=0; $i < 7 ; $i++) { 
				$date = Ouzo\Utilities\Clock::at($this->date_start)->plusDays($i);

				$query = $this->parse_query(
					$this->query_pattern,
					$this->get_date_where_query_weeks(
						$date->format('d'),
						$date->format('m'),
						$date->format('Y')
					)
				);
				if(!$query) break; // future date
				$this->exec_query($query);
				$this->labels[] = $date->format('d-m-Y');
			}	
		}

		private function run_query_year_type(){
			global $wpdb;
			for ($i=0; $i < 12 ; $i++) { 

				$query = $this->parse_query(
					$this->query_pattern,
					$this->get_date_where_query_year($i + 1),
					$this->get_date_end_for_date_value($i + 1),
					$this->get_prev_month_where_data($i + 1)
				);
				if(!$query) break; // future date
				$this->exec_query($query);
				$this->labels[] = KG_polish_month($i + 1, $this->year);
			}	
		}

		private function run_query(){
			if( $this->type== 'year'){
				$this->run_query_year_type();		
			} else {
				$this->run_query_week_type();	
			}

		}

		private function get_date_end_for_date_value($month){
			$month = $month < 10 ? '0' . $month : $month;
			return $this->year . '-' . $month .'-' . '31';
		}

		private function get_prev_month_where_data($month){
			
			$year = $this->year;
			if($month == 1){
				$month = 12;
				$year--;
			} else if($month == 12){
				$month = 1;
				$year++;
			}

			$month = $month < 10 ? '0' . $month : $month;
			return $this->get_date_where_query_year($month );
		}


		private function get_date_where_query_year($month) {
			if($this->is_future_date(1, $month, $this->year)) return false;
			return str_replace(
				array(
					'{{column_name}}',
					'{{month}}',
					'{{year}}'
				),
				array(
					$this->date_column,
					$month,
					$this->year
				),
				" MONTH({{column_name}}) = {{month}} AND YEAR({{column_name}}) = {{year}}"
			);
		}

		private function get_date_where_query_weeks($day, $month, $year) {
			return str_replace(
				array(
					'{{column_name}}',
					'{{day}}',
					'{{month}}',
					'{{year}}'
				),
				array(
					$this->date_column,
					$day,
					$month,
					$year
				),
				"DAY({{column_name}}) = {{day}} AND MONTH({{column_name}}) = {{month}} AND YEAR({{column_name}}) = {{year}}"
			);
		}

		private function parse_query($query, $where, $date_for_query = '', $where_prev_month = ''){
			if(!$where) return false;

			return str_replace(
				array(
					'{{DATE_WHERE}}',
					'{{DATE_WHERE_PREV_MONTH}}',
					'{{DATE}}'
				),
				array(
					$where,
					$where_prev_month,
					$date_for_query
				),	
				$query
			);
		}

		public function get_labels(){
			if(empty($this->data)) $this->run_query();
			return $this->labels;
		}

		public function get_data(){
			if(empty($this->data)) $this->run_query();
			return $this->data;
		}
		
	}