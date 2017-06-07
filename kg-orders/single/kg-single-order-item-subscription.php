<?php

	class KG_Single_Order_Item_Subscription extends KG_Single_Order_Item  {

		private static $TYPE = 3;

		private $subscription_obj;
		private $subscription_entry;

		private $present_relation_obj;
		private $default_data = array(
			'subscription_id' => 0,
			'user_id' => 1
		);

		public function __construct($data){
			parent::__construct($data);
			$this->subscription_obj = KG_Get::get('KG_Item_Subscription', $data['subscription_id']);
			$this->user_id = $data['user_id'];
			if( !$this->is_from_json_data($data) ) {
				$this->subscription_entry = KG_Get::get('KG_Subscriptions')->get_subscription_entry_obj_from_data($this->subscription_obj, $data['user_id']);
			}	
		}

		public function get_subscription(){
			return $this->subscription_obj;
		}

		public function get_subscription_id(){
			if(!empty($this->data_from_json['subscription_id'])) return $this->data_from_json['subscription_id'];
			return $this->subscription_obj->get_ID();
		}
		
		/* ==========================================================================
		   VIEW IN BASKET
		   ========================================================================== */

		public function get_headline(){
			if(!empty($this->data_from_json['headline'])) return $this->data_from_json['headline'];
			return __( 'Przedłużenie abonamentu', 'kg' );
		}

		public function get_desc(){
			if(!empty($this->data_from_json['desc'])) return $this->data_from_json['desc'];
			
			$start = $this->subscription_entry->get_start_date();
			$end = $this->subscription_entry->get_end_date();
			$free_resources = $this->subscription_obj->get_how_many_free_resources();
		
			$pattern = ((int) $free_resources > 0) ? '<strong>%s / %e</strong> z darmowymi zasobami: <strong>%r</strong> sztuk' : '<strong>%s / %e</strong>';

			return str_replace(array(
					'%s',
					'%e',
					'%r'
				), array(
					$start,
					$end,
					$free_resources
				), $pattern);
		}

		public function get_price(){
			if(!empty($this->data_from_json['price'])) return $this->data_from_json['price'];
			return  $this->subscription_obj->get_price();
		}

		public function get_user(){
			if(!empty($this->data_from_json['user_id'])) return KG_Get::get('KG_User', $this->data_from_json['user_id']);
			return KG_Get::get('KG_User',  $this->subscription_entry->get_user_id());
		}

		public function get_user_id(){
			if(!empty($this->data_from_json['user_id'])) $this->data_from_json['user_id'];
			return $this->user_id;
		}

		public function get_type(){
			return 'Abonament';
		}

		public function get_class(){
			return 'subscription';
		}

		public function get_class_cocpit(){
			return 'subscription';
		}

		public function get_invoice_label() {
			return "Abonament '" . $this->get_subscription()->get_name() . "' (" . $this->get_desc() . ')'; 
		}

			/* ==========================================================================
		   VIEW IN ACTIVITY IN COCPIT
		   ========================================================================== */
		
		private function render_activity_mesage($label){

			$pattern = '{{label}} abonament <a href="{{subscr_link}}">{{subscr_name}}</a> ({{subscr_desc}})';

			return str_replace(
				array(
					'{{subscr_link}}',
					'{{subscr_name}}',
					'{{subscr_desc}}',
					'{{label}}'			
				),
				array(
					$this->get_subscription()->get_admin_edit_link(),
					$this->get_subscription()->get_name(),
					$this->get_desc(),
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
			return KG_Get::get('KG_Subscriptions')->add_from_front($this->get_subscription(), $this->get_user_id());
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
     			'headline' => $this->get_headline(),
     			'desc' => $this->get_desc(),
     			'price' => $this->get_price(),
     			'type' => self::$TYPE,
     			'subscription_id' => $this->get_subscription_id(),
     			'user_id' => $this->get_user_id()
     		);	
    	}
	}