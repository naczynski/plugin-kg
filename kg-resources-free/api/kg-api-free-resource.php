<?php

	class KG_Api_Free_Resource extends KG_Ajax {

		private $subscription_entry;

		private function validate(){
			if(empty($_POST['resource_id'])) {
				return new WP_Error('no_resource', __( 'Nie podałeś jakiego zasoby chcesz użyć.', 'kg' ));
			}
		}

		private function add(){

			$this->subscription_entry = KG_get_curr_user()->get_current_subscription();
			if(!$this->subscription_entry) {
				return new WP_Error('no_subscription', __( 'Nie posiadasz aktualnie żadnego abonamentu.', 'kg' ) );
			}
			return $this->subscription_entry->use_free_resource( (int) $_POST['resource_id'] );
		}

		private function action() {

			$validate = $this->validate();
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}

			$add = $this->add();
			if(is_wp_error($add)){
				return $this->get_object($add);
			}

			return $this->get_object(
				false, 
				__( 'Zasób został dodany do zakładki “moje zasoby” w ramach abonamentu.', 'kg' ),
				array(
					'data' => $this->subscription_entry->get_status()
				)		
			);

		}
		
		public function set_as_free() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/free-resource/', function()use($context){    
	            $context->set_as_free();        			
	        });
  		}

	}
