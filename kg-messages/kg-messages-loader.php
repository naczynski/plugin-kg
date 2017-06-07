<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Messages_Loader extends KG_Component {

		public $name = 'Wiadomości';
		public $dir = 'kg-messages';
		public $des = '';
		protected $includes = array(

			'kg-messages-filters',

			// loops
			'loops/kg-loop-messages',

			// api
			'api/kg-api-sent-message',
			'api/kg-api-chat-messages',

			// single
			'single/kg-single-message',

			// cocpit
				'cocpit/kg-edit-user-tab-messages',
				'cocpit/kg-cocpit-sent-message-to-all',
		
				'cocpit/admin-ajax/kg-ajax-sent-message',
				'cocpit/admin-ajax/kg-ajax-sent-message-to-all'
		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Edit_User_Tab_Messages');
		}

		public function init() {		
			KG_Get::get('KG_Ajax_Sent_Message');
			KG_Get::get('KG_Ajax_Sent_Message_To_All');

			KG_Get::get('KG_Loop_Messages');
			
			KG_Get::get('KG_Api_Sent_Message');
			KG_Get::get('KG_Api_Chat_Messages');
			
			KG_Get::get('KG_Cocpit_Sent_Message_To_All');
		}

	}
	