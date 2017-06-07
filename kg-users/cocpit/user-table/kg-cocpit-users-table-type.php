<?php

	/**
	 *  Adde type to user table
	 */
	
	class KG_Cocpit_Users_Table_Type {

		public function __construct() {

			add_filter("manage_users_custom_column",  array($this, 'add_edit_column'), 10, 3);	
			add_filter("manage_users_columns", array($this, "add_edit_column_content"), 17 );

		}

		public function add_edit_column($val, $column_name, $user_id) {
	    	
	    	if($column_name != 'type') return $val;

	    	$user = KG_Get::get('KG_User', $user_id);

	    	if($user->is_coach()){
	    		return '<span class="role user-coach">Coach</span>';
	    	} else if($user->is_vip()) {
	    		return '<span class="role user-vip">Vip</span>';
	    	} else if($user->is_cim()) {
	    		return '<span class="role user-cim">Cim</span>';
	    	} else if($user->is_questus()) {
	    		return '<span class="role user-questus">Questus</span>';
	    	} else if($user->is_koda()) {
	    		return '<span class="role user-koda">Koda</span>';
	    	} else if($user->is_default()){
	    		return '<span class="role user-default">Zwykły</span>';
	    	}

		}

		public function add_edit_column_content($columns) {

		    $columns['type'] = __('Typ', 'kg');

		    return $columns;
		
		}
	   
	}
