<?php
	
	/**
	 * Actions form edit resource page
	 */
	class KG_Edit_Resource {

		public function __construct() {
			add_action("admin_enqueue_scripts", array($this, 'add_scripts'));
		}

		public function add_scripts() {
			wp_enqueue_script( 		 	
			 	'kg-cocpit-scripts', 
			 	plugins_url( '../assets/js/kg-cocpit-scripts.js', __FILE__ ),
			 	array( 'jquery' ) 
			 
			 );	
		}

	}
	