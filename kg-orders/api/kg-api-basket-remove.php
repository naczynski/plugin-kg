<?php

	class KG_Api_Basket_Remove extends KG_Ajax {


		private function action(){

			if(empty($_POST['key'])){
				return $this->get_object(new WP_Error('no_send_key', __( 'Nie podałeś jaki element chcesz usunąć z koszyka.', 'domain' ) ));
			}

			$key=sanitize_text_field($_POST['key']);

			$order_obj_to_remove = KG_Get::get('KG_Basket')->get_sigle_order_obj_by_key($key);
			$result = KG_Get::get('KG_Basket')->remove($key);

			do_action('kg_remove_from_basket', get_current_user_id(), $order_obj_to_remove);

			if(!$result){
				return $this->get_object(true, __( 'Nie ma takiego elementu w koszyku.', 'kg' ));	
			}
		
			return $this->get_object(
				false, 
				__( 'Wybrany element został usunięty z koszyka.', 'kg'),
				array(
					'basket' => KG_Get::get('KG_Basket') 
				)
			);
		}

		public function remove() {
			echo json_encode($this->action());
			die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/basket/remove', function()use($context){
	            $context->remove();      
	        });
  		}

	}