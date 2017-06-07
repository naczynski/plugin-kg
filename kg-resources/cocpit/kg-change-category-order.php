<?php
	
	/**
	 * Change order categories to by id in cocpit
	 */
	class KG_Change_Category_Order {

		public function taxonomy_checklist_checked_ontop_filter($args){
		    $args['checked_ontop'] = false;
		    return $args;
		}

		public function my_order_cats($args, $taxonomies){
		    
		    if(is_admin()){
		        $taxonomy = $taxonomies[0]; 
		        $screen = get_current_screen();
		              
	            $args['orderby']='id'; //preserves order of subcategories.
	            $args['order']='asc'; //or desc
	        
		    }

		    return $args;
		
		}

		public function __construct() {
			add_action('get_terms_args', array($this, 'my_order_cats') , 10, 2);
			add_filter('wp_terms_checklist_args', array($this, 'taxonomy_checklist_checked_ontop_filter') );
		}


	}