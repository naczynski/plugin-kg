<?php

	class KG_Api_Get_Users extends KG_Ajax {

		private $resouces;

		private function action() {

			 $out = array();

			 if( !current_user_can('get_resources')) {
			 	return $this->get_object(true, __('Nie masz uprawnień aby pobrać zasoby z bazy.', 'kg'));
			 }
			      
		     $user_loop = KG_Get::get('KG_User_Loop', $_POST, array(
		     	'only_enable_networking' => true,
		     	'only_enable' => true,
				'only_email_activated' => true
		     ));
		     $users = $user_loop->get();

		     return $this->get_object(false, __('Poprawnie pobrano zasoby z bazy.', 'kg'), array(
		     		'users' =>  $users ,
		     		'isLastPage'=> $user_loop->is_last_page(), 
				    'numberAllPages' => $user_loop->get_page_numbers(),
				    'found' =>  $user_loop->get_numbers_found(),
				    'page' => $user_loop->get_curr_page()
		     )); 
		
		}

		public function get_users() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/users/', function()use($context){    
	            $context->get_users();        			
	        });
  		}

	}
	