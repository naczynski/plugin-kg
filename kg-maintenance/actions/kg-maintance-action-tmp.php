<?php
	
	class KG_Maintance_Action_Tmp {

		private static $ACTION_NAME = 'tmp';

		public function __construct(){
			add_filter('kg_add_maintance_action', array($this, 'add_maintace_action'), 1, 1);
			add_action('kg_add_maintance_action_do_' . self::$ACTION_NAME, array($this, 'action'), 1, 0);
		}

		public function add_maintace_action($config){
			$config[self::$ACTION_NAME] = array(
				'name' => self::$ACTION_NAME,
				'message' => 'Zadania.',
				'message_finish' => 'Zrobiono.',
				'but' => 'Zrób'
			);
			return $config;
		}

		public function action(){
	
			$task_obj = KG_Get::get('KG_Task_Item', 1028); 			

			$task_response = new KG_Task_Response(59);

			// $error = $task_response->add_award(674);
			$json = json_encode($task_response);
			$data_response = json_decode($json, true);

			// for ($i=0; $i < 50; $i++) { 
			// 	$task_response->like( $i );
			// }

			// for ($i= 135; $i < 559 ; $i++) { 
			// 	$task_obj->add_response(
			// 		"Lorem Ipum coś tam, coś tam", 
			// 		$i
			// 	);				
			// }
			
		}
		
	}