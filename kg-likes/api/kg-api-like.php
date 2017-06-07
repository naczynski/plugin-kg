<?php

	class KG_Api_Like extends KG_Ajax {

		private $resource;
		
		private function like_resource($resource_id){
			$result = $this->resource->like(get_current_user_id()); 

			if(is_wp_error($result)) {
				echo json_encode( $this->get_object(true, $result->get_error_message()) );
				return;
			} else {
				do_action('like_resource', get_current_user_id(), $resource_id);
				echo json_encode($this->get_object(false , __( 'Zasób został dodany do ulubionych.', 'kg' ) ));
				return;
			}
		}

		private function dislike_resource($resource_id){

			$result = $this->resource->remove_like(get_current_user_id()); 

			if(is_wp_error($result)) {
				echo json_encode( $this->get_object(true, $result->get_error_message()) );
				return;
			
			} else {

				$relation = KG_Get::get('KG_Like_Relation', get_current_user_id(), $resource_id, 0);
				$relation->remove();
				do_action('dislike_resource', get_current_user_id(), $resource_id);
				echo json_encode($this->get_object(false , __( 'Zasób został usunięty z ulubionych.', 'kg' ) ));
				return;
			}

		}

		public function like($resource_id) {

			if(!current_user_can( 'like_resource' )){
				echo json_encode($this->get_object(true, __('Nie posiadasz odpowiednich uprawnień aby polubić ten zasób. ', 'kg')));
				return;
			} 

			if(!KG_get_curr_user()->is_have_active_subscription()){
				echo json_encode($this->get_object(true, __('Musisz posiadać abonament aby wykonać tę akcję. ', 'kg')));
				return;
			}

			$this->resource = KG_get_resource_object($resource_id);

			if(empty( $this->resource ) || is_wp_error($this->resource)) {
				echo json_encode($this->get_object(true, __('W naszej bazie nie ma zasobu który chcesz polubić.', 'kg')));
				return;
			}

			if($this->resource->is_user_like(get_current_user_id())){
				$this->dislike_resource($resource_id);
			} else {
				$this->like_resource($resource_id);
			}
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim_mapping') );            
    	}

   		public function slim_mapping($slim){
	        
	        $context = $this;

	        $slim->post('/slim/api/like/:id',function($id)use($context){

	        	  if(empty($id)) {
	        	  		echo json_encode($context->get_object(true, __( 'Powiedz nam jaki zasób chcesz polubić :)', 'kg')));
	        	  } else {
	              		$context->like( (int) $id);     
	        	  }      			
	        });

  		}

	}
	