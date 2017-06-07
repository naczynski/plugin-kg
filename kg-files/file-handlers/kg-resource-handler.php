<?php

	class KG_Resource_Handler implements KG_File_Handler {

		private static $TYPE = 'resource';

		public function __construct(){

		}

		public function can_download($item_id){
			return KG_Get::get('KG_Resource_Relations')->can_download(get_current_user_id(), $item_id);
		}

		public function get_headers($item_id){

		}

		public function get_file_content(){

		}

	}