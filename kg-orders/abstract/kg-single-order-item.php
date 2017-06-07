<?php

	abstract class KG_Single_Order_Item implements JsonSerializable {
	
		protected $unique_code;
		protected $data_from_json = array();

		protected function is_from_json_data($data){
			return !empty( $data['key'] );
		}

		public function __construct($data){
			if( $this->is_from_json_data($data) ) {
				$this->unique_code = $data['key'];
				$this->data_from_json = $data;
				return;
			}
			$this->unique_code = wp_generate_password(6, false, false);
		}

		public function get_key(){
			return $this->unique_code;
		}

		public function get_price_brutto() {
			return sprintf("%.2f", (int) $this->get_price());
		}

		public function get_price_netto() {
			return sprintf("%.2f", apply_filters('kg_price_netto', $this->get_price_brutto()) );
		}

		public function get_vat() {
			return sprintf("%.2f", $this->get_price_brutto() - $this->get_price_netto());
		}
			
		abstract public function action_after_buy($transaction_id);
		abstract public function get_price();
		abstract public function get_headline();
		abstract public function get_desc();
		abstract public function get_type();
		abstract public function get_class();
		abstract public function get_invoice_label();
		abstract public function get_payu_data();
	}