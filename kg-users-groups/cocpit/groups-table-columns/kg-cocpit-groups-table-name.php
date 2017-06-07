<?php


	class KG_Cocpit_Groups_Table_Name{

		public function __construct() {

			add_filter("manage_user-groups_posts_columns",  array($this, 'add_column'), 20, 1);	
			add_action("manage_user-groups_posts_custom_column", array($this, "add_content"), 30 , 2);

		}

		public function add_content($column_name, $group_id) {
			if($column_name != 'name' ) return;
			
			$kg_group = KG_Get::get('KG_Single_Users_Group', $group_id);
			echo '<a href="' . $kg_group->get_edit_link() . '">' . $kg_group->get_name() . '</a>';

		}

		public function add_column($columns) {

		    $columns['name'] = __('Nazwa', 'kg');
		    return $columns;
		
		}
	   
	}
