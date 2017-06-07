<?php

	/**
	 * Download resource page
	 */
	class KG_Download_Handler {

		public function construct() {
			
		}
		
		/* ==========================================================================
		   FILE PATH
		   ========================================================================== */

		public function get_invoice_path($transaction_id) {
			$upload_dir = wp_upload_dir();
			return $upload_dir['path'] . '/' . KG_Config::getPublic('dir_invoices') . '/' . $transaction_id . '.pdf';
		}

		public function get_file_path($url) {
			$upload_dir = wp_upload_dir();
			$file_name = $this->get_file_name($url);
			$ext = $this->get_ext_from_url($url);
			return $upload_dir['path'] . '/' . $ext . '/' . $file_name . '.' . $ext ;	
		}

		private function get_ext_from_url($url) {
			$path = parse_url($url, PHP_URL_PATH);
			return pathinfo($path, PATHINFO_EXTENSION);
		}

		private function get_file_name($url) {
			$path = parse_url($url, PHP_URL_PATH);
			return pathinfo($path, PATHINFO_FILENAME);
		}

		/* ==========================================================================
		   RENDER
		   ========================================================================== */
		
		private function render_invoice_file($transaction_id) {
		
			$kg_transaction = KG_Get::get('KG_Transaction', $transaction_id);
			
			if($kg_transaction->is_error()) return; // no such transaction
			if(!$kg_transaction->can_download_invoice(get_current_user_id())) return;
			$kg_transaction->generate_invoice();
			
			$path = $kg_transaction->get_invoice_path();
			
			header('Cache-control: public');
			header("Expires: Sat, 26 Jul 2030 05:00:00 GMT");
			header('Content-Disposition: inline; filename="faktura-' . $kg_transaction->get_number_for_user() .'.pdf"');
			header('Pragma: cache');
			header('Content-type: application/pdf');

			echo file_get_contents($path);

			exit;

		}

		private function render_resource_file() {

			do_action('kg_download_resource', get_current_user_id(),  $this->resource_obj->get_ID());

			$file = $this->resource_obj->get_private_file();
			$path = $this->get_file_path( $file['url'] );
			$ext = $this->get_ext_from_url( $file['url'] );

			header('Cache-control: public');
			header("Expires: Sat, 26 Jul 2030 05:00:00 GMT");
			header('Content-Disposition: inline; filename="' . $file['title'] . '.' . $ext . '"');
			header('Pragma: cache');
			header('Content-type: '. $file['mime_type']);

			echo file_get_contents($path);

			exit;

		}

		public function init() {

     		 if( empty($_GET['type']) || !is_user_logged_in() ) {
     		 	return;
     		 }

     		 if($_GET['type'] == 'resource') {
     		 	$resource_id = ( !empty($_GET['resource_id']) ) ? (int) $_GET['resource_id'] : 0;
     		 	if( !$this->can_download(get_current_user_id(), $resource_id ) ) return;
     		 	$this->resource_obj  = KG_get_resource_object($resource_id);
     		 	$this->render_resource_file();
     		 }

     		  if($_GET['type'] == 'invoice') {
     		 	$transaction_id = ( !empty($_GET['id']) ) ? (int) $_GET['id'] : 0;
     		 	$this->render_invoice_file($transaction_id);
     		 }

		}
		
		public function can_download($user_id, $resource_id) {
			return KG_Get::get('KG_Resource_Relations')->can_download($user_id, $resource_id);
		}

	}