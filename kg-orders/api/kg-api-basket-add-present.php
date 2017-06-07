<?php

	class KG_Api_Basket_Add_Present extends KG_Ajax {

		private	$from; 
		private	$to;
		private	$resources_ids;
		private	$message;

		private $data;

		private function is_in_basket(){
			return (KG_Get::get('KG_Basket')->is_present_in_basket($this->data));
		}

		private function set_main_params(){
			$this->from = (KG_get_curr_user()->get_ID() ) ? KG_get_curr_user()->get_ID() : 1;
			$this->to = (int) $_POST['to_user_id'];

			//message
			if( !empty($_POST['message']) ) {
				$this->message = sanitize_text_field($_POST['message']);
			} else {
				$this->message = " ";
			}
			
			$this->data = array(
				'type' => 2,
				'user_id_from' => $this->from,
				'user_id_to'=> $this->to,
				'message' => $this->message,
				'user_id' => $this->from,	
			);

			$this->resources_ids = $_POST['resources_ids'];

		}

		/* ==========================================================================
		   VALIDATE
		   ========================================================================== */
		

		private function validate(){
			if(!current_user_can( 'send_present')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczjących uprawnień.', 'kg' ) );
			}

			if(!KG_get_curr_user()->is_have_active_subscription()){
				return new WP_Error('bad_fields', __( 'Musisz posiadać abonament aby wykonać tę akcję.', 'kg' ) );
			}

			// to
			if(empty($_POST['to_user_id']) ) {
				return new WP_Error('bad_fields', __( 'Nie wprowadziłeś adresata prezentu.', 'kg' ) );
			}

			// resources
			if(empty($_POST['resources_ids'])) {
				return new WP_Error('bad_fields', __( 'Musisz wybrać jakie zasoby chcesz sprezentować!', 'kg' ) );
			}
		}

		/* ==========================================================================
		   CHECK IF USER HAVE RESOURCE
		   ========================================================================== */
		
		private function is_user_have_resource($user_id, $resource_id){
			if(KG_Get::get('KG_Resource_Relations')->can_download( $user_id, $resource_id )){
				$name = KG_Get::get('KG_User', $user_id )->get_name_and_surname();
				$resource_name = KG_get_resource_object($resource_id)->get_name_with_subtype();
				return new WP_Error('already_in_basket', __( 'Użytkownik posiada już zasób ' . $resource_name ." , \nspróbuj dodać inny zasób lub wyślij wiadomość bez prezentu.", 'kg' ) );
			}
		}

		private function validate_is_user_have_resources(){
			foreach ( (array) $_POST['resources_ids'] as $resource_id) {		
				$check = $this->is_user_have_resource((int) $_POST['to_user_id'], $resource_id);
				if(is_wp_error($check)) return $check;
			}
			return true;
		}


		/* ==========================================================================
	       ADD
	    ========================================================================== */
	
		private function add_presents_to_basket(){
			foreach ( (array) $this->resources_ids as $id) {
				$data = array_merge($this->data, array(
					'resource_id' => (int) $id
				));

				$present_obj = KG_get_order_object($data);
				$add = KG_Get::get('KG_Basket')->add($present_obj);
				do_action('kg_add_to_basket_present', get_current_user_id(), $present_obj);
			
				if(is_wp_error($add)){
					return $this->get_object($add);
				}
			}
			return true;
		}


		private function action() {

			$validate = $this->validate();
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}

			$validate_ids = $this->validate_is_user_have_resources();
			if(is_wp_error($validate_ids)){
				return $this->get_object($validate_ids);
			}

			$this->set_main_params();

			$add_presents_to_basket = $this->add_presents_to_basket();
			if(is_wp_error($add_presents_to_basket)){
				return $this->get_object($add_presents_to_basket);
			}

			return $this->get_object(
					false, 
					__( 'Prezent został dodany do koszyka.', 'kg'),
					array(
						'basket' => KG_Get::get('KG_Basket') 
					)
				);
		}

		public function send_present() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/basket/add-present', function()use($context){
	            $context->send_present();      
	        });
  		}
		
	}
