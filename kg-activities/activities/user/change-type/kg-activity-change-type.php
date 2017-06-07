<?php

	class KG_Activity_Change_Type extends KG_Activity {

		public function get_type(){
			return 'Typ konta';
		}

		public function get_class_name(){
			return 'change-user-type';
		}

		public function get_message(){
			$meta = $this->get_meta();

			$pattern = 'Zmieniono typ konta na : {{name}}';

			return str_replace(
				array(
					'{{name}}'	
				), array(
					$meta['name']
				), $pattern);

		}
		
	}
