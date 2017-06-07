<?php

	class KG_Alert_Task_New_Response extends KG_Alert {

		public function get_type(){
			return 'task';
		}

		public function get_task_object(){
			return KG_Get::get('KG_Task_Item', $this->get_action_id());
		}

		public function get_message(){
			return 'Nowa odpowiedź do zadania "' . apply_filters('kg_title_task_alert', $this->get_task_object()->get_name(), 70) . '"';
		}
		
		public function get_action_type(){
			return 'link';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function get_button_label(){
			return 'Zobacz zadanie';
		}

		public function get_button_icon(){
			return 'response';
		}

		public function get_link(){
			return $this->get_task_object()->get_link();
		}

	}
