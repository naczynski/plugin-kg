<?php

	class KG_Single_Users_Group {

		private $users = array();

		public function __construct($id = 0) {
			$this->id = $id;
		}

		protected function get_group_meta() {
			if(empty($this->meta)){
				$this->meta = get_fields($this->id);
			}
			return $this->meta;
		}
		
		protected function get_wp_post_instance() {
			if(empty($this->wp_post)){
				$this->wp_post = WP_Post::get_instance($this->id);
			}

			return $this->wp_post;
		}

		public function get_members(){
			if(!empty($this->users)) return $this->users;
			$users_ids = $this->get_group_meta()['users_assign'];
			foreach ($users_ids as $user_id) {
				$this->users[] = KG_Get::get('KG_User', (int) $user_id);
			}
			return $this->users;
		}

		public function get_quantity_of_memebers(){
			return sizeof($this->get_group_meta()['users_assign']);
		} 

		public function get_name(){
			return $this->get_wp_post_instance()->post_title;
		}

		public function get_edit_link(){
			return get_edit_post_link($this->id);
		}

		public function sent_message($message){
			foreach ($this->get_members() as $user) {
				$action = $user->sent_message($message);
				if(is_wp_error($action)){
					return $action;
				}
			}
		}
		
		public function sent_presents($resources_ids, $message){
			foreach ($this->get_members() as $user) {
				$relation_ids = array();
				foreach ( (array) $resources_ids as $resource_id) {
					$relation = KG_Get::get(
							'KG_Present_Relation', 
							get_current_user_id(),   
							$user->get_ID(),
							$resource_id,
							$message
						);

					 $relation_ids[] = $relation->add_to_db();
				}
				do_action('kg_add_present_multi', $resources_ids, get_current_user_id(), $user->get_ID(), $message );
				do_action('kg_add_present_multi_relations_obj', $relation_ids, $user->get_ID());
			}	
		}

	}