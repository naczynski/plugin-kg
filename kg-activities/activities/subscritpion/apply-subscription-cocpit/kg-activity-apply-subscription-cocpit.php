<?php

	class KG_Activity_Apply_Subscription_Cocpit extends KG_Activity {

		public function get_type(){
			return 'Abonament';
		}

		public function get_class_name(){
			return 'subscription';
		}

		public function get_message(){
			$meta = $this->get_meta();
			$subscription_obj = KG_Get::get('KG_Item_Subscription', $meta['subscr_id']);

			$pattern = 'Questus przyznał abonament <a href="{{link}}">{{name}}</a> na okres {{start}}-{{end}}';

			return str_replace(
				array(
					'{{link}}',
					'{{name}}',
					'{{start}}',
					'{{end}}'
				), array(
					$subscription_obj->get_admin_edit_link(),
					$subscription_obj->get_name(),
					$meta['start'],
					$meta['end']
				), $pattern);

		}
		
	}
