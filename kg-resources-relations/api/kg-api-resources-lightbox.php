<?php

	class KG_Api_Resources_Lightbox extends KG_Ajax {

		private $resouces;

		private function action() {

			 $out = array();

			 if( !current_user_can('get_resources_lightbox')) {
			 	return $this->get_object(true, __('Nie masz uprawnień aby pobrać zasoby z bazy.', 'kg'));
			 }
			      
		     $resouces_loop = KG_Get::get('KG_Resources_Lightbox_Loop', array(
		     	'not_show_hidden' => true
		     ));

		     return $this->get_object(false, __('Poprawnie pobrano zasoby z bazy.', 'kg'), array(
		     		'resources' =>  $resouces_loop->get($_POST) ,
		     		'isLastPage'=> $resouces_loop->is_last_page(), 
				    'numberAllPages' => $resouces_loop->get_page_numbers(),
				    'found' =>  $resouces_loop->get_numbers_found(),
				    'page' => $resouces_loop->get_curr_page()
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
	        $slim->post('/slim/api/lightbox-resources/', function()use($context){    
	            $context->get_posts();        			
	        });
  		}
	}