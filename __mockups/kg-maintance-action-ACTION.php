<?php
	
	class KG_Maintance_Action_ACTION {

		private static $ACTION_NAME = 'ACTION';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'action'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => '',
				'message_finish' => '',
				'but' => 'Wykonaj'
			);
			return $config;
		}

		public function action(){
			// Action
		}
		
	}