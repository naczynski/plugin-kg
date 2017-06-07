<?php

	class KG_Api_My_Resources extends KG_Ajax {

		private $resouces;

		private function action() {

			 $out = array();

			 if( !current_user_can('get_resources')) {
			 	return $this->get_object(true, __('Nie masz uprawnień aby pobrać zasoby z bazy.', 'kg'));
			 }
			      
		     $my_respurces_loop = KG_Get::get('KG_My_Resources_Loop', $_POST);

		     return $this->get_object(false, __('Poprawnie pobrano zasoby z bazy.', 'kg'), array(
		     		'resources' =>  $my_respurces_loop->get() ,
		     		'isLastPage'=> $my_respurces_loop->is_last_page(), 
				    'numberAllPages' => $my_respurces_loop->get_page_numbers(),
				    'found' => $my_respurces_loop->get_numbers_found(),
				    'page' => $my_respurces_loop->get_curr_page()
		     )); 
		
		}
		
		public function get_posts() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/my-resources/', function()use($context){    
	            $context->get_posts();        			
	        });
  		}

	}
