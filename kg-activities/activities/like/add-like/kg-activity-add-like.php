<?php

	class KG_Activity_Add_Like extends KG_Activity {

		public function get_type(){
			return 'Polubił zasób';
		}

		public function get_class_name(){
			return 'like';
		}

		public function get_message(){
			$meta = $this->get_meta();
			$pattern='Użytkownik polubił zasób <a href="{{link_name}}">{{resource_name}}';

			return str_replace(
				array(
					'{{link_name}}',
					'{{resource_name}}'
				), array(
					get_edit_post_link($meta['id']),
					$meta['name']
				), $pattern);

		}
		
	}
