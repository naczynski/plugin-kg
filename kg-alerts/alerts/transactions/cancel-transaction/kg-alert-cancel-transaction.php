<?php

	class KG_Alert_Cancel_Transaction extends KG_Alert {

		private $kg_transaction;

		private function get_transaction_object(){
			return KG_Get::get('KG_Transaction', (int) $this->get_action_id());
		}

		public function get_type(){
			return 'transaction';
		}

		public function get_message(){
			return 'Transakcja nr. ' . $this->get_transaction_object()->get_number_for_user() . ' została anulowana';
		}
		
		public function get_action_type(){
			return 'link';
		}

		public function get_lightbox_data(){
			return array();
		}

		public function get_button_label(){
			return 'Powtórz transakcję';
		}

		public function get_button_icon(){
			return 'buy';
		}

		public function get_link(){
			return $this->get_transaction_object()->get_sent_to_payu_url();
		}

	}
