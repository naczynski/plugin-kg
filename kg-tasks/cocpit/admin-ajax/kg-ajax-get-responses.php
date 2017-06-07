<?php

	class KG_Ajax_Get_Responses extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'show-responses')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

			if(empty($_POST['page'])){
				return new WP_Error('no_page_id', __( 'Nie podałeś numeru strony', 'kg' ) );
			}

			if(empty($_POST['task_id'])){
				return new WP_Error('no_page_id', __( 'Nie podałeś numeru zadania', 'kg' ) );
			}

		}

		private function make() {
			$task_id = (int) $_POST['task_id'];
			$page = (int) $_POST['page'];

			include plugin_dir_path( __FILE__ ) . '../views/responses.php';	
		}

		private function action() {
			$validate = $this->validate();
			if(is_wp_error($validate)){
				return json_encode($this->get_object($validate));
			}
			
			$this->make();
		}

		public function get_task_responses() {
			echo $this->action();
			die;
		}

		public function __construct() {
			parent::__construct('get_task_responses', array($this, 'get_task_responses') , '', '');
		}
			
	}
