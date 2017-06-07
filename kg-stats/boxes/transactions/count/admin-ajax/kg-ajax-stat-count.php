<?php

	class KG_Ajax_Stat_Count extends KG_Ajax {

		private function validate() {

			if(!current_user_can( 'stat-user-table')){
				return new WP_Error('bad_fields', __( 'Nie posiadasz wystarczających uprawnień.', 'kg' ) );
			}

		}

		private function make() {
			return KG_Get::get('KG_Stat_Box_Count')->get_data_for_chart(
				$_POST['date_start'],
				$_POST['date_end'],
				$_POST['year'], 
				$_POST['type']
			);
		}

		private function action() {

			$validate = $this->validate();
			if(is_wp_error($validate)){
				return $this->get_object($validate);
			}

			$make = $this->make();
				if(is_wp_error($validate)){
				return $this->get_object($make);
			}
			
			return $this->get_object(false, '', array(
				'chart' => $make 
			));

		}

		public function stat_user_table() {
			echo json_encode($this->action());
			die;
		}

		public function __construct() {
			parent::__construct('kg_count', array($this, 'stat_user_table') , '', '');
		}
			
	}
