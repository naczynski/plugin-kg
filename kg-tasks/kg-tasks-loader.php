<?php 

	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Tasks_Loader extends KG_Component {

		public $name = 'Zadania';
		public $dir = 'kg-tasks';
		public $des = '';
		
		protected $includes = array(

			'models/kg-task-response-likes',

			'loops/kg-loop-tasks-responses',
			'loops/kg-loop-my-tasks',

			'single/kg-task-item',
			'single/kg-task-response',
			'single/kg-my-task',

			'kg-tasks-functions',

			'api/kg-api-get-answers',
			'api/kg-api-like-response',
			'api/kg-api-add-response',
			'api/kg-api-choose-award',
			'api/kg-api-leave-task',

			'cocpit/kg-cocpit-page-task-response',

			'cocpit/admin-ajax/kg-ajax-get-responses',
			'cocpit/admin-ajax/kg-ajax-remove-response',

			'cocpit/kg-cocpit-metabox-responses'

		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Api_Get_Answers');
			KG_Get::get('KG_Api_Add_Response');
			KG_Get::get('KG_Api_Like_Response');
			KG_Get::get('KG_Api_Choose_Award');
			KG_Get::get('KG_Api_Leave_Task');


			KG_Get::get('KG_Cocpit_Metabox_Responses');
			KG_Get::get('KG_Ajax_Get_Responses');
			KG_Get::get('KG_Ajax_Remove_Response');
			KG_Get::get('KG_Cocpit_Page_Task_Response');
		}

		public function init(){
			
		}

	}
