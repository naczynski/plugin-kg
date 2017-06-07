<?php

	class KG_Single_Order_Item_Present extends KG_Single_Order_Item  {

		private static $TYPE = 2;

		private $present_relation_obj;
		private $default_data = array(
			'user_id_from' => 0,
			'user_id_to'=> 0,
			'message' => '',
			'resource_id' => 0,
		);

		public function __construct($data){
			parent::__construct($data);
			if( !$this->is_from_json_data($data) ) {
				$this->present_relation_obj = KG_Get::get('KG_Present_Relation_Single', $data);
			}
		}

		public function get_resource(){
			if(!empty($this->data_from_json)) return KG_get_resource_object($this->data_from_json['resource_id']);
			return $this->present_relation_obj->get_resource();
		}

		public function get_from_user(){
			if(!empty($this->data_from_json['user_from_id'])) return KG_Get::get('KG_user', $this->data_from_json['user_from_id']);
			return $this->present_relation_obj->get_from_user();
		}

		public function get_from_user_id(){
			if(!empty($this->data_from_json['user_from_id'])) return $this->data_from_json['user_from_id'];
			return $this->present_relation_obj->get_from_user_id();
		}

		public function get_to_user(){
			if(!empty($this->data_from_json['user_to_id'])) return KG_Get::get('KG_user', $this->data_from_json['user_to_id']);
			return $this->present_relation_obj->get_to_user();
		}

		public function get_to_user_id(){
			if(!empty($this->data_from_json['user_to_id'])) return $this->data_from_json['user_to_id'];
			return $this->present_relation_obj->get_to_user_id();
		}

		public function get_message(){
			if(!empty($this->data_from_json['message'])) return $this->data_from_json['message'];
			return $this->present_relation_obj->get_message();
		}

		public function get_type(){
			return 'Prezent';
		}

		public function get_class(){
			return 'present';
		}

		public function get_class_cocpit(){
			return 'present';
		}

		public function is_has_message(){
			return !empty(trim($this->get_message()));
		}

		public function get_invoice_label() {
			return $this->get_resource()->get_name_with_subtype();
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
			return __( 'Prezent dla: <strong>', 'kg' ) . $this->get_to_user()->get_name_and_surname() . '</strong>';
		}

		public function get_price(){
			if(!empty($this->data_from_json['price'])) return $this->data_from_json['price'];
			if($this->present_relation_obj) {
				return $this->present_relation_obj->get_price();	
			}
			return 0;
		}

		/* ==========================================================================
		   VIEW IN ACTIVITY IN COCPIT
		   ========================================================================== */
		
		private function render_activity_mesage($label){

			$pattern = $this->is_has_message() ?
				'{{label}} prezent <a href="{{resource_link}}">{{resource_name}}</a> do koszyka dla <a href="{{user_to_link}}"> {{user_to_name}} </a> z wiadomością "<i>{{message}}</i>"' :
				'{{label}} prezent <a href="{{resource_link}}">{{resource_name}}</a> do koszyka dla <a href="{{user_to_link}}"> {{user_to_name}} </a>';

			return str_replace(
				array(
					'{{resource_name}}',
					'{{resource_link}}',
					'{{user_to_name}}',
					'{{user_to_link}}',
					'{{message}}',
					'{{label}}'
				), array(
					$this->get_resource()->get_name_with_subtype(),
					$this->get_resource()->get_admin_edit_link(),
					$this->get_to_user()->get_name_and_surname(),
					$this->get_to_user()->get_edit_page(),
					$this->get_message(),
					$label
				),
				$pattern
			);
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
			$relation = KG_Get::get(
				'KG_Present_Relation', 
				$this->get_from_user_id(),   
				$this->get_to_user_id(),
				$this->get_resource()->get_ID(),
				$this->get_message()
			);
			$relation_id = $relation->add_to_db();
			
			if($relation_id){
				do_action('kg_add_present_single', KG_Get::get('KG_Present_Relation_Single', array(
					'relation_id' => $relation_id,
					'user_id_from' => $this->get_from_user_id(),
					'user_id_to' => $this->get_to_user_id(),
					'user_id' => $this->get_to_user_id(),
					'message' => $this->get_message(),
					'resource_id' => $this->get_resource()->get_ID(),
					'date' => KG_get_time(),
					'action_id' => 23
				)));
				do_action('kg_sent_present', $this);
			}
			
			return $relation_id;
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
     			'type' => self::$TYPE,
     			'class' => $this->get_class(),
     			'key' => $this->unique_code,
     			'headline' => $this->get_headline(),
     			'desc' => $this->get_desc(),
     			'price' => $this->get_price(),
     			'message' => $this->get_message(),
     			'user_from_id' => $this->get_from_user_id(),
     			'user_to_id' => $this->get_to_user_id(),
     			'resource_id' => $this->get_resource()->get_ID(),
     			'user_id' => $this->get_from_user_id()
     		);	
    	}
	}