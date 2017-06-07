<?php

	class KG_Invoice_Handler implements KG_File_Handler {

		public function get_dir_path(){
			$upload_dir = wp_upload_dir();
			return $upload_dir['path'] . '/' . KG_Config::getPublic('dir_invoices') . '/';
		}

	}