<?php

	// Overide default ACF relationhip field when assign new users to group
	class KG_Ajax_Box_Assign_Users extends KG_Ajax {

		public function is_user_assign_box($field_name) {
			return ( $field_name == 'field_557f95asx56s8f9Da' );
		}

		private function not_all_user_types($user_types) {
			return !strpos($user_types, ",") && $user_types !='all';
		}

		public function render_element($user, $show_hidden_input = false) {
			$user = is_a($user, 'KG_User') ? $user : KG_Get::get('KG_User', $user);
			return str_replace(
				array(
					'{{edit_user_link}}',
					'{{user_id}}',
					'{{user_type_pretty}}',
					'{{avatar}}',
					'{{user_name}}',
					'{{user_type}}',
					'{{hidden_input}}',
					'{{button_class}}'
				),
				array(
					$user->get_edit_page(),
					$user->get_ID(),
					$user->get_pretty_type(),
					$user->get_avatar(),
					$user->get_name_and_surname(),
					$user->get_type(),
					$show_hidden_input ? '<input type="hidden" name="fields[field_557f95asx56s8f9Da][]" value="' . $user->get_ID() . '" />' : '',
					$show_hidden_input ? 'acf-button-remove' : 'acf-button-add'
				),
				'<li>
					<a href="{{edit_user_link}}" data-post_id="{{user_id}}">
						<span class="relationship-item-info">
							{{user_type_pretty}}
						</span>
						<div class="result-thumbnail user-avatar-{{user_type}} ">
							<img width="21" height="21" src="{{avatar}}" class="attachment-21x21">
						</div>
						{{user_name}}
						<span class="{{button_class}}"></span>
					</a>
					{{hidden_input}}
				</li>'
			);
		}

		private function get_correct_user_types(&$params) {
			if(!empty($params['post_type'])){
				if($params['post_type'] == 'Zwykli'){
					$params['user_type'] = 	'default';
				} else if( $this->not_all_user_types($params['post_type']) ) {
					$params['user_type'] = $params['post_type'];
				} 
			} 
			return $params;
		}

		function query_posts(){

	   		// vars
	   		$r = array(
	   			'next_page_exists' => 1,
	   			'html' => ''
	   		);
	   			
	   		// options
			$options = array(
				'page' =>	!empty($_POST['paged']) ? (int) $_POST['paged'] : 1,
			);
			
			$options = array_merge( $options, $_POST );
					
			// convert user types
			$this->get_correct_user_types($options);

			// query
			$users_loop = KG_Get::get('KG_User_Loop', $options);
			$users = $users_loop->get();

			// loop
			foreach ($users as $user) {
				// update html
				$r['html'] .= $this->render_element($user);
			}
				
			// next page
			if( $users_loop->is_last_page() ) {
				$r['next_page_exists'] = 0;
			}
			
			// return JSON
			echo json_encode( $r );
			
			die();
				
		}
	
		public function __construct() {
			if(!$this->is_user_assign_box( !empty($_POST['field_key']) ? $_POST['field_key'] : '' ) ) return;
			remove_all_actions('wp_ajax_acf/fields/relationship/query_posts');
			remove_all_actions('wp_ajax_nopriv_acf/fields/relationship/query_posts');
			parent::__construct('acf/fields/relationship/query_posts', array($this, 'query_posts') , '', '');

		}
		
	}
