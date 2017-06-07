<?php

	class KG_Basket implements JsonSerializable {

		private $items = array();
		private $total = 0;

		private $total_presents = 0;
		private $total_resources = 0;
		private $total_subscriptions = 0;

		private $count_presents = 0;
		private $count_resources = 0;
		private $count_subscriptions = 0;

		public function __construct(){
			$this->get();
		}

		private function after_change(){
			$this->count_total();
			$this->save();
		}

		/* ==========================================================================
		   TYPES
		   ========================================================================== */
  
		private function is_resource($object){
			return ($object instanceof KG_Single_Order_Item_Resource);
		}

		private function is_present($object){
			return ($object instanceof KG_Single_Order_Item_Present);
		}

		private function is_subscription($object){
			return ($object instanceof KG_Single_Order_Item_Subscription);
		}

		/* ==========================================================================
		   SESSION
		   ========================================================================== */
	
		private function save(){
			$items = json_encode($this->items, JSON_UNESCAPED_UNICODE);
			global $wpdb;
			$table = KG_Config::getPublic('table_basket');
			$res = $wpdb->query(
				$wpdb->prepare("INSERT INTO {$table} (user_id, date, items) VALUES(%d, %s, %s) ON DUPLICATE KEY UPDATE    
					date=VALUES(date), items=VALUES(items)",
					 get_current_user_id(),
					 KG_get_time(),
					 $items)
			);
			return $res;
		}

		private function parse_items($json){
			$array_of_data = json_decode($json, true);

			$this->items = array();
			foreach ((array) $array_of_data as $data) {
				$object =  KG_get_order_object($data); 
				if($object) $this->items[$data['key']] = $object;
			}
			$this->count_total();
		}

		private function get(){
			global $wpdb;
			$table = KG_Config::getPublic('table_basket');
			$basket = $wpdb->get_row(
				$wpdb->prepare(
				    "SELECT items FROM {$table} WHERE user_id = %d", 
					get_current_user_id()		
				), 
				ARRAY_A
			);
			if(isset($basket['items'])){
				$this->parse_items($basket['items']);
			}
		
		}

		public function clear(){
			global $wpdb;
			$wpdb->delete(
				KG_Config::getPublic('table_basket'),
				array(
					'user_id' => get_current_user_id()
				),
				array('%d')
			);
			$this->items = array();
		}

		/* ==========================================================================
		   COUNTER
		   ========================================================================== */
		
		public function count_items(){
			return sizeof($this->items);
		}

		public function is_empty(){
			return $this->count_items() == 0;
		}

		/* ==========================================================================
		   TOTAL
		   ========================================================================== */
		
		private function count_total(){
			$this->total = 0;

			$this->total_presents = 0;
			$this->total_resources = 0;
			$this->total_subscriptions = 0;

			$this->count_presents = 0;
			$this->count_resources = 0;
			$this->count_subscriptions = 0;

			foreach ($this->items as $item) {
				if(is_wp_error($item)) continue;
				$this->total += $item->get_price();
				
				if($this->is_present($item)){
					$this->total_presents += $item->get_price();
					$this->count_presents++;
				} 

				if($this->is_resource($item)){
					$this->total_resources += $item->get_price();
					$this->count_resources++;
				}

				if($this->is_subscription($item)){
					$this->total_subscriptions += $item->get_price();
					$this->count_subscriptions++;	
				}	

			}
			return $this->total;
		}

		public function get_total_brutto(){
			return $this->count_total();
		}

		public function get_total_netto(){
			return apply_filters('kg_price_netto', $this->count_total());
		}

		/* ==========================================================================
		   CHECK
		   ========================================================================== */
		
		public function is_in_basket($resource_id){
			foreach ($this->items as $item) {
				if( !($this->is_resource($item)) ) continue;

				if ($item->get_resource()->get_ID() == $resource_id){
					return true;
				}
			}
			return false;
		}

		private function is_subscription_in_basket(){
			foreach ($this->items as $item) {
				if($this->is_subscription($item)){
					return true;
				}
			}
			return false;
		}

		private function is_correct_present($present_obj, $data){
			$ok = true;
			if(!empty($data['from']) && $data['from'] != $present_obj->get_from_user_id()) $ok = false;
			if(!empty($data['to']) && $data['to'] != $present_obj->get_to_user_id()) $ok = false;
			if(!empty($data['resource_id']) && $data['resource_id'] != $present_obj->get_resource()->get_ID()) $ok = false;
			return $ok;
		}

		public function is_present_in_basket($data){
			foreach ($this->items as $item) {
				if( !($this->is_present($item)) ) continue;
				if( $this->is_correct_present($item, $data)){
					return true;
				}
			}
			return false;
		}

		private function is_resource_and_in_basket($kg_single_order_item){
			return ( $this->is_resource($kg_single_order_item) &&
					 $this->is_in_basket($kg_single_order_item->get_resource()->get_ID()) );
		}

		private function if_event_and_not_have_enought_seats($order_item){
			return(
				$this->is_resource($order_item) &&
				$order_item->get_resource()->get_type() == 'event' &&
				!$order_item->get_resource()->is_enought_seats()
			);
		}

		/* ==========================================================================
		   ADD
		   ========================================================================== */
		
		private function add_to_storage($kg_single_order_item){
			$this->items[] = $kg_single_order_item;
			$this->after_change();
		}

		public function add($kg_single_order_item){
			if(!is_a($kg_single_order_item, 'KG_Single_Order_Item')){
				return new WP_Error('bad_object_type', __( 'To nie jest poprawny obiekt dla koszyka.', 'kg' ) );
			}

			if($this->is_resource_and_in_basket($kg_single_order_item)){
				return new WP_Error('resource_already_in_basket', 'Już posiadasz ten zasób w koszyku.');
			}

			if($this->is_subscription_in_basket() && $this->is_subscription($kg_single_order_item)){
				return new WP_Error('subscription_already_in_basket', __( 'W koszyku może znajdować się tylko jeden abonament.', 'kg' ) );
			}

			if($this->if_event_and_not_have_enought_seats($kg_single_order_item)){
				return new WP_Error('no_available_sets', __( 'Przykro nam, ale wszystkie miejsca na to wydarzenie zostały wykupione.', 'kg' ) );
			}

			$this->add_to_storage($kg_single_order_item);
			return $kg_single_order_item->get_key();
		
		}

		/* ==========================================================================
		   REMOVE
		   ========================================================================== */

	   private function get_index_of_element($item_key){
		   foreach ($this->items as $index => $item) {
				if($item->get_key() === $item_key){
					return $index;
				} 
			}
			return false;
	   }

	    public function get_items(){
	   		return $this->items;
	    }

	    public function get_sigle_order_obj_by_key($key){
	    	return $this->items[$this->get_index_of_element($key)];
	    }

		public function remove($key){
			if(isset($this->items[$key])){
				unset($this->items[$key]);	
			}
			$this->after_change();

			return true;
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function data_for_order(){
			return array(
				'date' => KG_get_time(),
				'user_id' => get_current_user_id(),
				'total_brutto' => $this->get_total_brutto(),
				'total_netto' => $this->get_total_netto(),
				'status' => 'PENDING',
				'count_presents' => $this->count_presents,
				'count_resources' => $this->count_resources,
				'count_subscriptions' => $this->count_subscriptions,
				'total_presents' => $this->total_presents,
				'total_resources' => $this->total_resources,
				'total_subscriptions' => $this->total_subscriptions,
				'items' => json_encode($this->get_items(), JSON_UNESCAPED_UNICODE)
			);
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function jsonSerialize() {
			
     		return array(
     			'items_in_basket' => $this->count_items() ,
     			'total' => $this->get_total_brutto(),
     			'items' => $this->items
     		);			
    	}
	}