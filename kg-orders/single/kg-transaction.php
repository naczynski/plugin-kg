<?php

	class KG_Transaction implements JsonSerializable {

		private $data_from_db = array();
		private $id = 0;

		private $have_resource = false;
		private $have_present = false;
		private $have_subscription = false;
		private $have_event = false;

		private function is_need_to_get_from_db($data){
			return is_int($data);
		}

		/* ==========================================================================
		   DB
		   ========================================================================== */

		private function prepare_data($data){
			if(!empty($data['items']) && is_string($data['items'])) $data['items']= json_decode($data['items'], true);
			if(!empty($data['invoice_data']) && is_string($data['invoice_data'] )) $data['invoice_data']= json_decode($data['invoice_data'], true);
			return $data;
		}

		private function get_data_from_db($transaction_id){
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_transactions') . "
					WHERE id = %d
					", (int) $transaction_id ),
				ARRAY_A 
			); 
			return $this->prepare_data($data);
		}

		private function update($key, $value, $format){
			global $wpdb;
			$update =  $wpdb->update(
				KG_Config::getPublic('table_transactions'),
				array($key => $value ),
				array('id' => $this->get_ID()),
				array($format),
				array('%d')
			);

			if($update){
				$this->data_from_db[$key] = $value;
			}
			return $update;
		}

		public function __construct($data){
			if($this->is_need_to_get_from_db($data)){
				$this->data_from_db = $this->get_data_from_db($data);
				$this->id = $data;
			} else {
				$this->data_from_db = $this->prepare_data($data);
				$this->id = $data['id'];
			}
		}

		public function is_error(){
			return empty($this->data_from_db);
		}

		public function get_items(){
			if($this->is_error()) return false;
			if(!empty($this->items)) return $this->items;

			foreach ( (array) $this->data_from_db['items']  as $data) {
				$object =  KG_get_order_object($data); 
				if($object) {
					$this->items[] = $object;
					if(is_a($object, 'KG_Single_Order_Item_Resource')) {
						$this->have_resource = true;
						if($object->get_resource()->get_type() == 'event') $this->have_event = true;
					}
					if(is_a($object, 'KG_Single_Order_Item_Present')) $this->have_present = true;
					if(is_a($object, 'KG_Single_Order_Item_Subscription')) $this->have_subscription = true;
				}
			}

			return $this->items;
		}

		/* ==========================================================================
		   ID
		   ========================================================================== */

		public function get_payu_transaction_id() {
			if($this->is_error()) return false;
			return $this->data_from_db['payu_id'];
		}

		public function set_payu_transaction_id($transaction_payu_id) {
			return $this->update('payu_id', $transaction_payu_id, '%s');
		}

		public function get_number_for_user(){
			if($this->is_error()) return false;
			return $this->id + 2344754346;
		}

		public function get_ID(){
			if($this->is_error()) return false;
			return $this->id;
		}

		/* ==========================================================================
		   IS CONTAIN...
		   ========================================================================== */
		
		public function is_containt_resource(){
			$this->get_items();
			return $this->have_resource;
		} 

		public function is_contain_only_resources(){
			$this->get_items();
			return ($this->have_resource && !$this->have_present && !$this->have_subscription);
		}

		public function is_containt_present(){
			$this->get_items();
			return $this->have_present;
		} 

		public function is_containt_subscription(){
			$this->get_items();
			return $this->have_subscription;
		} 

		public function is_contain_only_subscription(){
			$this->get_items();
			return ($this->have_subscription && ($this->get_count_items() == 1));
		}

		public function is_containt_event(){
			$this->get_items();
			return $this->have_event;
		} 

		public function is_containt_only_event(){
			$this->get_items();
			return $this->have_event && !$this->have_present && !$this->have_subscription;
		}

		/* ==========================================================================
		   GET
		   ========================================================================== */
		
		public function get_count_items(){
			if($this->is_error()) return false;
			return sizeof( $this->get_items() );	
		}

		public function get_date(){
			if($this->is_error()) return false;
			return $this->data_from_db['date'];
		}

		public function get_user_id(){
			if($this->is_error()) return false;
			return (int) $this->data_from_db['user_id'];
		}

		public function get_user(){
			if($this->is_error()) return false;
			return KG_Get::get('KG_User', $this->get_user_id());
		}

		public function get_total_brutto(){
			if($this->is_error()) return false;
			return sprintf("%.2f",  $this->data_from_db['total_brutto'] );
		}

		public function get_total_netto(){
			if($this->is_error()) return false;
			return sprintf("%.2f", $this->data_from_db['total_netto'] );
		}

		public function get_total_vat(){
			if($this->is_error()) return false;
			return sprintf("%.2f", $this->get_total_brutto() - $this->get_total_netto());
		}

		public function get_admin_edit_link() {
			return KG_Get::get('KG_Cocpit_Page_Transaction_Single')->get_edit_link($this->get_ID());
		}

		public function can_download_invoice($user_id) {
			if (KG_Get::get('KG_User', $user_id)->can_admin()) return true;
			if ($user_id == $this->get_user_id()) return true;
			return false;
		}

		public function get_invoice_data(){
			if($this->is_error()) return array();
			return (array) $this->data_from_db['invoice_data'];
		}

		public function is_current_user_transaction() {
			return $this->can_download_invoice(get_current_user_id());
		}

		public function get_invoice_url() {
			return '/pobierz?type=invoice&id=' . $this->get_ID();
		}

		public function get_count_presents(){
			if($this->is_error()) return false;
			return (int) $this->data_from_db['count_presents'];
		}

		/* ==========================================================================
		   STATES
		   ========================================================================== */
		
		public function get_type() {
			if($this->is_canceled()) return 'Anulowana';
			if($this->is_payment_complete()) return 'Zakończona';
			return 'Oczekiwanie na wpłatę';
		}

		public function change_status($type){
			switch($type){
				case 'CANCELED': $this->set_canceled(); break;
				case 'COMPLETED': $this->pay(); break;
			}
		}

		/* Canceled
		   ========================================================================== */

		public function set_canceled() {
			if($this->is_error()) return false;
			if($this->is_canceled()) return new WP_Error('is_paid', __( 'Dana transakcja została już anulowana', 'kg' ));

			$this->update('status', 'CANCELED', '%s');
			do_action('kg_cancel_transaction', $this);
		}

		public function is_canceled() {
			if($this->is_error()) return false;
			return $this->data_from_db['status'] == 'CANCELED';
		}

		/* Complete
	   ========================================================================== */

	   	public function set_complete() {
			if($this->is_error()) return false;
			return $this->update('status', 'COMPLETED', '%s');
		}

		public function is_payment_complete(){
			if($this->is_error()) return false;
			return $this->data_from_db['status'] == 'COMPLETED';
		}


		/* ==========================================================================
		   PAY
		   ========================================================================== */

		public function pay(){
			if($this->is_error()) return false;
			if($this->is_payment_complete()) return new WP_Error('is_paid', __( 'Dana transakcja została już opłacona', 'kg' ));

			foreach ( (array) $this->get_items() as $item) {
				$item->action_after_buy($this->get_ID());
			}
			do_action('kg_payment_complete', $this);
			return $this->set_complete();
		}

	   /* ==========================================================================
	   PAYU
	   ========================================================================== */
	
	   public function get_sent_to_payu_url() {
	   	  if($this->is_error()) return '/';
	   	  return get_permalink( KG_Config::getPublic('sent_payment') ) . '?id=' . $this->get_ID();
	   }

		public function get_status_of_transaction_from_payu() {
			try{
				$response = OpenPayU_Order::retrieve($this->get_payu_transaction_id());
				$status = $response->getResponse()->orders[0]->status;
			} catch (OpenPayU_Exception $e) {
				
				return 'ERROR';	
			}
			return $status;
		}

		public function get_products_data_for_payu(){
			$out = array();
			foreach ($this->get_items() as $item) {
				$out[] = $item->get_payu_data(); 
			}
			return $out;
		}

		public function get_payu_total() {
			return apply_filters('kg_unit_price_payu', $this->get_total_brutto()); 
		}

		/* ==========================================================================
		   INVOICE...
		   ========================================================================== */
		
		public function generate_invoice(){
			return KG_Get::get('KG_Invoice_Factory')->generate($this);
		}

		public function get_invoice_path(){
			$upload_dir = wp_upload_dir();
			return $upload_dir['basedir'] . '/' . KG_Config::getPublic('dir_invoices') . '/' . $this->get_number_for_user() . '.pdf';
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */
	
		public function jsonSerialize(){
			return array(
	    		'date' => strtotime($this->get_date()),
				'number' => $this->get_number_for_user(),
				'status' => $this->get_type(),
				'priceWithTax' => $this->get_total_brutto(),
				'priceWithoutTax' => $this->get_total_netto(),
				'invoiceUrl' => $this->get_invoice_url(),
				'hideInvoiceButton' => !$this->is_payment_complete(),
				'entries' => $this->get_items()
    		);
		}		
	}