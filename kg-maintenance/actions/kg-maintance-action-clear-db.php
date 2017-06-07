<?php
	
	class KG_Maintance_Action_Clear_Db {

		private static $ACTION_NAME = 'clear-db';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'copy_users_meta'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => 'Napraw bazę danych (czyść)',
				'message_finish' => 'Wyczyszczono bazę',
				'but' => 'Wykonaj'
			);
			return $config;
		}

		public function copy_users_meta(){	
			global $wpdb;
			$users = $wpdb->get_results(
				"SELECT ID FROM {$wpdb->users}"
			);

			foreach ($users as $value) {
				$user_id = (int) $value->ID;
				$avatar = get_user_meta($user_id , 'kg_avatar', true);
				$deactive = get_user_meta($user_id , 'kg_deactive', true);
				$networking = get_user_meta($user_id , 'kg_networking', true);
				$email_activated = get_user_meta($user_id , 'kg_email_activated', true);

				if($deactive){
					 KG_update_user($user_id, 'is_active', 0, '%d');
				}

				if($avatar){
					KG_update_user($user_id, 'avatar_file_name', $avatar, '%s');
				}

				if($networking){
					KG_update_user($user_id, 'is_networking', 1, '%d');
				}

				if($email_activated){
					KG_update_user($user_id, 'is_email_activated', 1, '%d');
				}

				
			}

		}
	}