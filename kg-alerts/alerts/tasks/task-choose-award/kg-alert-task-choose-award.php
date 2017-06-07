<?php

	class KG_Alert_Task_Choose_Award extends KG_Alert {

		public function get_type(){
			return 'task';
		}

		public function get_task_response_object(){
			return KG_Get::get('KG_Task_Response', $this->get_action_id());
		}

		public function get_task_object(){
			return KG_Get::get('KG_Task_Item', $this->get_task_response_object()->get_task_id());
		}

		public function get_message(){
			return 'Twoja odpowiedź do zadania "' . apply_filters('kg_title_task_alert', $this->get_task_object()->get_name()) . '" zebrała odpowiednio dużo polubień!. Wybierz nagrodę.';
		}
		
		public function get_action_type(){
			return 'lightbox-choose-award';
		}

		public function get_lightbox_data(){
			return array_merge( 
				$this->get_task_object()->get_serialized_fields_for( get_current_user_id() ), 
				array(
					'response' => $this->get_task_response_object()
				) );
		}

		public function get_button_label(){
			return 'Wybierz nagrodę';
		}

		public function get_button_icon(){
			return 'award';
		}

		public function get_link(){
			return '';
		}

	}
