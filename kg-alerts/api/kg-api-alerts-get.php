<?php

	class KG_Api_Alerts_Get extends KG_Ajax {

		private $resouces;

		private function action() {

			 $out = array();

			 if( !current_user_can('get_resources')) {
			 	return $this->get_object(true, __('Nie masz uprawnień aby zobaczyć alerty.', 'kg'));
			 }

			 if( empty($_POST['page']) ) {
			 	return $this->get_object(true, __('Nie podałeś numery strony.', 'kg'));
			 }

		     $alert_loop = KG_Get::get('KG_Loop_Alerts', 
		     	 get_current_user_id(), 
		     	 // 554,
		     	 array(
		     		'page' => (int) $_POST['page']
		     	)
		     );

		     $alerts = $alert_loop->get();

		     return $this->get_object(false, __('Poprawnie pobrano alerty.', 'kg'), array(
		     		'alerts' =>  $alerts,
		     		'unreaded' => KG_Get::get('KG_Alerts_Not_Readed_Counter')->get_quantity_not_read( get_current_user_id() ),
		     		'isLastPage'=> $alert_loop->is_last_page(), 
				    'numberAllPages' => $alert_loop->get_page_numbers(),
				    'found' =>  $alert_loop->get_numbers_found(),
				    'page' => $alert_loop->get_curr_page()
		     )); 
		
		}
		
		public function get_alerts() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_get_alerts'), function()use($context){    
	            $context->get_alerts();        			
	        });
  		}

	}
	
