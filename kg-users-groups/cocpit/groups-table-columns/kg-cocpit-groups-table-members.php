<?php


	class KG_Cocpit_Groups_Table_Members{

		public function __construct() {

			add_filter("manage_user-groups_posts_columns",  array($this, 'add_column'), 40, 1);	
			add_action("manage_user-groups_posts_custom_column", array($this, "add_content"), 18 , 2);

		}

		public function add_content($column_name, $group_id) {
			if($column_name != 'members' ) return;
			
			$kg_group = KG_Get::get('KG_Single_Users_Group', $group_id);
			echo $kg_group->get_quantity_of_memebers();

		}

		public function add_column($columns) {
		   
		   if(!empty($columns['date'])) unset($columns['date']);
		   if(!empty($columns['title'])) unset($columns['title']); 
		   if(!empty($columns['cb'])) unset($columns['cb']);
		   if(!empty($columns['wpseo-score'])) unset($columns['wpseo-score']);
		   if(!empty($columns['wpseo-title'])) unset($columns['wpseo-title']);
		   if(!empty($columns['wpseo-metadesc'])) unset($columns['wpseo-metadesc']);
		   if(!empty($columns['wpseo-focuskw'])) unset($columns['wpseo-focuskw']);

		    $columns['members'] = __('Ilość członków', 'kg');
		    return $columns;
		
		}
	   
	}
