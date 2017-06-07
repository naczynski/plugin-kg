<?php
	
	class KG_Single_Order_Item_Resource extends KG_Single_Order_Item {

		private static $TYPE = 1;

		private $resource_id;
		private $user_id;
		private $date_added;

		private $default_data = array(
			'resource_id' => 0,
			'user_id' => 0
		);

		public function __construct($data){
			parent::__construct($data);
			if( !$this->is_from_json_data($data) ) {
				$this->resource_id = $data['resource_id'];
				$this->user_id = $data['user_id'];
			}
		}

		public function get_resource(){
			if(!empty($this->data_from_json)) return KG_get_resource_object($this->data_from_json['resource_id']);
			return KG_get_resource_object($this->resource_id);
		}  

		public function get_user(){
			if(!empty($this->data_from_json['user_id'])) return KG_Get::get('KG_User', $this->data_from_json['user_id']);
			return KG_Get::get('KG_User', $this->user_id);
		}
		
    	/* ==========================================================================
		   VIEW IN BASKET
		   ========================================================================== */
		
		public function get_headline(){
			if(!empty($this->data_from_json['headline'])) return $this->data_from_json['headline'];
			return $this->get_resource()->get_name();
		}

		public function get_desc(){
			if(!empty($this->data_from_json['desc'])) return $this->data_from_json['desc'];
			return $this->get_resource()->get_sub_category_name();
		}

		public function get_price(){
			if(!empty($this->data_from_json['price'])) return $this->data_from_json['price'];
			if(is_wp_error($this->get_resource())) return 0;
			return $this->get_resource()->get_price();
		}

		public function get_invoice_label() {
			return $this->get_resource()->get_name_with_subtype();
		}

		/* ==========================================================================
		   VIEW IN ACTIVITY IN COCPIT
		   ========================================================================== */
		
		private function render_activity_mesage($label){
			return $label . ' zasób <a href="' . $this->get_resource()->get_admin_edit_link() . '"> ' . $this->get_resource()->get_name_with_subtype() . ' </a>';
		}

		public function get_add_activity_message(){
			return $this->render_activity_mesage('Dodał');
		}

		public function get_remove_activity_message(){
			return $this->render_activity_mesage('Usunął');
		}

		/* ==========================================================================
		   ACTIONS
		   ========================================================================== */
		
		public function action_after_buy($transaction_id) {
			$this->get_resource()->after_buy();
			$relation = KG_Get::get(
				'KG_Buy_Relation', 
				$this->get_user()->get_ID(),   
				$this->get_resource()->get_ID(),
				$transaction_id
			);
			do_action('kg_buy_resource', $this);

			return $relation->add_to_db();
		}

		public function get_type(){
			return 'Zasób';
		}

		public function get_class(){
			return $this->get_resource()->get_icon_name();
		}

		public function get_class_cocpit(){
			return 'resource';
		}

		/* ==========================================================================
		   PAYU
		   ========================================================================== */

		public function get_payu_data(){
			return array(
				'name' => apply_filters('kg_product_name_payu', $this->get_invoice_label()),
				'unitPrice' => apply_filters('kg_unit_price_payu', $this->get_price() ),
				'quantity' => 1,
			);
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function jsonSerialize() {
     		return array(
     			'key' => $this->unique_code,
     			'class' => $this->get_class(),
     			'headline' => $this->get_resource()->get_name(),
     			'desc' => $this->get_desc(),
     			'price' => $this->get_price(),
     			'type' => self::$TYPE,
     			'resource_id' => $this->get_resource()->get_ID(),
     			'user_id' => $this->get_user()->get_ID()
     		);	
    	}
	}