<?php

	/**
	 * Add buttons Accept, NotAccept 
	 */
	
	class KG_Cocpit_Users_Table_Edit {

		public function __construct() {

			if( !current_user_can('edit_kg_user') ) {
				return;
			}

			add_filter("manage_users_custom_column",  array($this, 'add_edit_column'), 10, 3);	
			add_filter("manage_users_columns", array($this, "add_edit_column_content"), 18 );

		}

		public function add_edit_column($val, $column_name, $user_id) {

			if($column_name != 'edit') return $val;

			$kg_user = KG_Get::get('KG_User', $user_id);

			if( !$kg_user->is_koda() && !$kg_user->is_questus() ) {
				return '<a class="button" href="'.KG_Get::get('KG_Cocpit_Edit_Student')->get_url($user_id).'"> Edytuj</a>  ';
			} else {
				return '';
			}
		
		}

		public function add_edit_column_content($columns) {
		    
		    $columns['edit'] = __('Edytuj', 'kg');

		    return $columns;
		
		}
	   
	}
