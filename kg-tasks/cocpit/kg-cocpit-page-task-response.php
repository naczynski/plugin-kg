<?php

	class KG_Cocpit_Page_Task_Response {

		private $sections = array();

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
		}


		public function get_url($quiz_result_id) {
			return admin_url('admin.php?page=task-response&id=' . $quiz_result_id) ;
		}

		public function render() {

			if(empty($_GET['id'])) {
				echo '<p class="update-nag">Nie podałeś numery odpowiedzi</p>';
				return;
			}

			$kg_task_response = KG_Get::get('KG_Task_Response', (int) $_GET['id']);

			if( !$kg_task_response->is_correct_id() ) {
				echo '<p class="update-nag">Nie ma takiej odpowiedzi o podanym numerze id</p>';
				return;
			}
			
			include plugin_dir_path( __FILE__ ) . 'views/page-response.php';
			
		}

		public function add_page_to_menu() {

			add_menu_page( 		
				'Odpowiedź do zadania',
				'Odpowiedź do zadania',
				'show-task-response-cocpit', 
				'task-response',
				array($this, 'render' ),
				'dashicons-admin-users'
				);

		}

	}
	