<?php

	class KG_Ajax_Stat_Quizes_Solves extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'stat-user-table')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function make() {
			
			KG_Get::get('KG_Stat_Box_Quizes_Solves')->render_with_params(
				(int) $_POST['page'], 
				$_POST['sort_column_name'], 
				$_POST['sort_direction']
				);

		}

		private function action() {

			$validate = $this->validate();
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}

			$make = $this->make();
		
		}

		public function quiz_solves() {
			echo $this->action();
			die;
		}

		public function __construct() {
			parent::__construct('quiz_solves', array($this, 'quiz_solves') , '', '');
		}
			
	}
