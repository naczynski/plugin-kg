<?php

	class KG_Cocpit_Page_Quiz_Result {

		private $sections = array();

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
		}

		public function get_url($quiz_result_id) {
			return admin_url('admin.php?page=show-quiz-result&id=' . $quiz_result_id) ;
		}

		public function render() {

			if(empty($_GET['id'])) {
				echo '<p class="update-nag">Nie podałeś numery quizu</p>';
				return;
			}

			$kg_quiz_result = KG_Get::get('KG_Single_Result_From_Solve_Id', (int)$_GET['id']);

			if( !$kg_quiz_result->is_correcnt_id() ) {
				echo '<p class="update-nag">Nie ma takiego rozwiązania o podanym numerze id</p>';
				return;
			}
			
			include plugin_dir_path( __FILE__ ) . 'views/quiz-result.php';
			
		}

		public function add_page_to_menu() {

			add_menu_page( 		
				'Rozwiązanie quizu',
				'Rozwiązanie quizu',
				'quiz_result', 
				'show-quiz-result',
				array($this, 'render' ),
				'dashicons-admin-users'
				);

		}

	}
	