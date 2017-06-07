<?php

	/**
	 *  Adde email address to user table
	 */
	
	class KG_Cocpit_Users_Table_Email {

		public function __construct() {

			add_filter("manage_users_custom_column",  array($this, 'add_edit_column'), 10, 3);	
			add_filter("manage_users_columns", array($this, "add_edit_column_content"), 14 );

		}

		public function add_edit_column($val, $column_name, $user_id) {
	    	
	    	if($column_name != 'user_email') return $val;

	    	return KG_Get::get('KG_User', $user_id)->get_email();

		}

		public function add_edit_column_content($columns) {

		    $columns['user_email'] = __('Email', 'kg');

		    return $columns;
		
		}
	   
	}
