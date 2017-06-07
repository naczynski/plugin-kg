<?php

	class KG_Maintance_Action_User_Roles {

		private static $ACTION_NAME = 'add-roles';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'action'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => 'Nadaj odpowiednie role',
				'message_finish' => 'Nadano.',
				'but' => 'Nadaj'
			);
			return $config;
		}

		public function action(){
			KG_Get::get('KG_User_Roles');
		}
		
	}