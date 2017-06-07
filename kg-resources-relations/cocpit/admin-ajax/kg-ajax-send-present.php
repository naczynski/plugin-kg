<?php

	class KG_Ajax_Send_Present extends KG_Ajax {

		private function check_has_resource($resources_ids){
			foreach ( (array) $resources_ids as $resource_id) {
				$is_have_resource = KG_Get::get('KG_Resource_Relations')->can_download($_POST['to_user_id'], $resource_id);
				if($is_have_resource ){
					return new WP_Error('has_resource', __( 'Użytkownik posiada już zasób: ' . KG_get_resource_object($resource_id)->get_name() , 'kg' ) );
				}
			}
			return true;
		} 

		private $relation_ids = array();
		
		private function add_presents($resources_ids){
			foreach ( (array) $resources_ids as $resource_id) {
				$relation = KG_Get::get(
						'KG_Present_Relation', 
						$_POST['from_user_id'],   
						$_POST['to_user_id'],
						$resource_id,
						$this->message
					);

				 $this->relation_ids[] = $relation->add_to_db();
			}

		}

		private function action() {

			if(!current_user_can( 'send_cocpit_present')){
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie posiadasz wystarczjących uprawnień.', 'kg' ) ) );
			}

			if(empty($_POST['to_user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie wprowadziłeś adresata prezentu.', 'kg' ) ) );
			}

			if(empty($_POST['from_user_id']) ) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Nie wprowadziłeś odbiorcy prezentu.', 'kg' ) ) );
			}

			if(empty($_POST['fields']['resources_ids'][0])) {
				return $this->get_object(new WP_Error('bad_fields', __( 'Musisz wybrać jaki zasób chcesz sprezentować!', 'kg' ) ) );
			}

			if(empty($_POST['message'])) {
				$this->message = " ";
			} else {
				$this->message = $_POST['message']; 
			}

			$resources_ids = $_POST['fields']['resources_ids'];
			$has_user_resource = $this->check_has_resource($resources_ids);

			if(is_wp_error($has_user_resource)){
				return $this->get_object($has_user_resource);
			}
			$this->add_presents($resources_ids);

			do_action('kg_add_present_multi', $resources_ids, (int) $_POST['from_user_id'], (int) $_POST['to_user_id'], $this->message );
			do_action('kg_add_present_multi_relations_obj', $this->relation_ids,  (int) $_POST['to_user_id']);

			return $this->get_object(false, __( 'Przyznano użytkownikowi zasoby poprawnie.', 'kg' ));
			
		}

		public function send_present() {
			check_ajax_referer('send_present', 'security');
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('send_present', array($this, 'send_present') , '', '');
		}
		
	}
