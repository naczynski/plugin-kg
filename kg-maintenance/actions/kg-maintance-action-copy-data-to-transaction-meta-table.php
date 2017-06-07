<?php
	
	class KG_Maintance_Action_Copy_Data_To_Transaction_Meta_Table {

		private static $ACTION_NAME = 'data_to_transacton_meta_table';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'action'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => 'Przepisuje wszystkie dane transakacji z tabeli post_meta do transaction_meta',
				'message_finish' => 'Poprawnie przepisano wszystkie dane',
				'but' => 'Przepisz'
			);
			return $config;
		}

		public function action(){
			// Action
		}
		
	}