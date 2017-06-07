<?php
	
	class KG_Maintance_Action_Add_Meta_To_Resources {

		private static $ACTION_NAME = 'add_meta_not_show';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'action'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => 'Dodaj meta data dla opcji "Nie pokazuj zasobu we froncie" oraz zasoby tylko dla CIM',
				'message_finish' => 'Dodano meta do nie pokazywania we froncie.',
				'but' => 'Dodaj'
			);
			return $config;
		}

		public function action(){
			global $wpdb;
			$data = $wpdb->get_results( 
				"SELECT ID FROM " . $wpdb->posts. " WHERE post_type IN ('quiz', 'event', 'pdf', 'link', 'task')" ,
				ARRAY_A 
			); 

			foreach ( (array)$data as $post) {
				if(!get_post_meta($post['ID'], 'hide_from_front', true)){
					update_post_meta($post['ID'], 'hide_from_front', '0' );
				}

				if(!get_post_meta($post['ID'], 'only_for_cim', true)){
					update_post_meta($post['ID'], 'only_for_cim', '0' );
				}
			}

		}
		
	}