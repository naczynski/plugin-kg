<?php

	trait KG_Field_Utils {

		protected $user_id = null;

		protected $name;
		protected $label;


		/* ==========================================================================
		   ERROR
		   ========================================================================== */
	
		/**
		 * Check if is config for this field
		 * @return boolean [description]
		 */
		protected function is_error() {

			return empty( $this->label ); 

		}

		protected function get_no_config_error() {

			return new WP_Error('no_such_field', __( 'Nie ma takiego pola w pliku konfiguracyjnym', 'kg' ));

		}


		protected function get_no_user_error() {

			return new WP_Error('no_user_id', __( 'Nie sprecyzowano dla jakiego użytkownika mamy zapisać wartość pola', 'kg' ) );
		
		}

		/* ==========================================================================
		   NAME
		========================================================================== */

		public function get_name() {

			return $this->name;
		
		}

		/* ==========================================================================
		   LABEL
		========================================================================== */

		/**
		 * Get value of vield from db
		 * @return sting 
		 */
		public function get_label() {

			if ($this->is_error()) return $this->get_no_config_error();

			return $this->label;

		}
	
	}