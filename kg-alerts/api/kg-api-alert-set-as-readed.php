<?php

	class KG_Api_Alert_Set_As_Readed extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'set_alert_as_readed')){
				return new WP_Error('no_caps', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['alert_id'])){
				return new WP_Error('no_alert_id', __( 'Nie przekazałeś jaki alert chcesz oznaczyć jako przeczytany.', 'kg' ) );
			}

		}

		private function make() {

			$alert = KG_Get::get('KG_Alert_Enable_Networking', (int) $_POST['alert_id']); 
			return $alert->set_as_readed();
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
				__( 'Poprawnie zaznaczono jako przeczytany.', 'kg' ),
				array(
					'not_readed' => KG_Get::get('KG_Alerts_Not_Readed_Counter')->get_quantity_not_read(get_current_user_id())
				)
			);

		}

		public function set_as_readed() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post(KG_Config::getPublic('api_set_as_readed'), function()use($context){
	            $context->set_as_readed();      
	        });
  		}
			
	}
