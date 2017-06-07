<?php

	class KG_Activity_Download_Resource extends KG_Activity {

		public function get_type(){
			return 'Pobieranie';
		}

		public function get_class_name(){
			return 'download';
		}

		public function get_message(){
			$meta = $this->get_meta();

			$pattern = 'Pobrał zasób <a href="{{link_name}}">{{resource}}</a>';

			return str_replace(
				array(
					'{{link_name}}',
					'{{resource}}'
				), array(
					get_edit_post_link($meta['id']),
					$meta['name']
				), $pattern);
		
		}

		


	}
