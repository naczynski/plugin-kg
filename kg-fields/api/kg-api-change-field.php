<?php	

	class KG_Api_Change_Field extends KG_Ajax {


		private function validate($name) {

		    check_ajax_referer('ajax-change-field', 'security');

			if( !current_user_can('modify_own_field') ) {
				return new WP_Error('no_logged', __( 'Nie posiadasz wystarczającyh uprawnień aby zmienić te informacje', 'kg' ));
			}

			if( empty(KG_Config::getPublic($name)) ) {
				return new WP_Error('no_such_field', __( 'Nie ma takiego pola w systemie.', 'kg' ));
			}

			if( empty($_POST['value']) ) {
				return new WP_Error('no_field_value', __( 'Nie podałeś nowej wartości dla pola.', 'kg' ));
			}

			return true;

		}

		public function change($name) {

			$validate = $this->validate($name);

			if( is_wp_error($validate) ) {
				echo json_encode($this->get_object(true, $validate->get_error_messages() ));
				return;
			}

			$field = KG_Get::get('KG_User_Field', $name, get_current_user_id() );

			$ret = $field->set_value( sanitize_text_field( $_POST['value'] ));

			if(is_wp_error($ret)) {
				echo json_encode($this->get_object($ret));
			} else {
				echo json_encode( $this->get_object(false, __( 'Dane zostały zaktualizowane.', 'kg' )));
			}

		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        
	        $context = $this;
	     
	        $slim->post( KG_Config::getPublic('api_change_field') . '/:name',function($name)use($context){
	     
	        	 if(empty($name)) {
	        	  		echo json_encode($context->get_object(true, __( 'Nie przesłano nazwy pola które chcesz edytować', 'kg')));
	        	  } else {
	              		$context->change($name);      
	        	  }  

	        });

  		}

	}
