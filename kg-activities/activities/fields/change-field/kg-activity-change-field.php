<?php

	class KG_Activity_Change_Field extends KG_Activity {

		public function get_type(){
			return 'Zmiana danych';
		}

		public function get_class_name(){
			return 'change-data';
		}

		public function get_message(){
			$meta = $this->get_meta();
			$pattern = 'Zmiana pola <strong>{{label}}</strong> na <i>"{{value}}"</i>';

			return str_replace(
				array(
					'{{label}}',
					'{{value}}'
				), array(
					$meta['label'],
					$meta['value']
				), $pattern);

		}
		
	}
