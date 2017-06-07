<?php

	class KG_Api_Alert_Set_All_As_Readed extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'set_alert_as_readed')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function make() {
			return KG_Get::get('KG_Alerts_Not_Readed_Counter')->set_all_readed(get_current_user_id()); 
		}

		private function action() {

			$validate = $this->validate();
			
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}
		
			$make = $this->make();

			if(is_wp_error($make)){
				return $this->get_object($make);
			}

			return $this->get_object(
				false, 
				__( 'Poprawnie zaznaczono wszystko jako przeczytane.', 'kg' ),
				array(
					'not_readed' => 0
				)
			);

		}

		public function set_all_as_readed() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_set_all_as_readed'), function()use($context){
	            $context->set_all_as_readed();      
	        });
  		}
			
	}
