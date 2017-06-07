<?php
	
	class KG_Maintance_Action_Delete_Invoices {

		private static $ACTION_NAME = 'delete-ivoices';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'action'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => 'Usuń wszystkie wygenerowane faktury.',
				'message_finish' => 'Poprawnie usunięto wszystkie faktury.',
				'but' => 'Usuń'
			);
			return $config;
		}

		public function action(){
			$dir = KG_Get::get('KG_Invoice_Handler')->get_dir_path();
			$files = glob( $dir . '*'); 
			foreach($files as $file){ 
			  if(is_file($file))
			    unlink($file);
			}
		}
		
	}