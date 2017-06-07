<?php

	abstract class KG_Cocpit_View {

		private static $selectors;
		private static $pages_to_remove;

		private $remove_top_menu = false;
		private $remove_dashboard = false;
		private $modify_login = false;

		private $remove_update_msg = false;

		private $remove_user_table_columns = false;

		/* Notifications
		   ========================================================================== */
		
		public function remove_update_msg_hook() {
			global $wp_version;
			return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
		}

		public function remove_update_msg() {

			$this->remove_update_msg = true;
			
		}

		/* Top Menu
		   ========================================================================== */
		
		public function remove_top_menu_hook() {

           global $wp_admin_bar;

		   $wp_admin_bar->remove_menu('wp-logo'); 
           $wp_admin_bar->remove_menu('updates');
           $wp_admin_bar->remove_menu('comments');  
           $wp_admin_bar->remove_menu('wpseo-menu');    
           $wp_admin_bar->remove_menu('new-post');               
           $wp_admin_bar->remove_menu('new-media');       
           $wp_admin_bar->remove_menu('new-page');

           $wp_admin_bar->remove_node('edit-profile');

           // 

		}

		protected function remove_top_menu() {
			$this->remove_top_menu = true;
		}

		/* DahsBoard
		   ========================================================================== */
		
		public function remove_dashboard_hook() {

			global $wp_meta_boxes;
    
		    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
		    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
		    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
		    unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
		    unset( $wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now'] );
		    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
		    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
		    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
		    unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

		    unset( $wp_meta_boxes['dashboard']['side']['low']['woocommerce_endpoints_nav_link'] );

		    

		}

		protected function remove_dashboards() {

			$this->remove_dashboard = true;

		}


		/* Login Page
		   ========================================================================== */


		public function login_page_modify_hook() {
    
		    $logo_url = get_template_directory_uri().'/assets/logo-cocpit.png';
		    
		    echo '<style>
		    	
		    	html, body{
					
					background: #2196F3!important;
					
		    	}

		        .login h1 a {display: none}
		        
		        #login{
		            padding: 15px 0 0 0;
		        }
		        
		        .login h1{
		           
		            background: url('.$logo_url.');
		            height: 126px;
		            margin: 68px 0 57px 101px;
		            padding: 0;
		            width: 126px;
		            text-indent: -9999px;
		            outline: 0;
		            overflow: hidden;
		            
		            }
		            
		         #nav, 
		         #nav a,
		         #backtoblog a{
					display: none;
		            color: #fff !important;
		        }
		     
		    </style>';
         
		}

		public function modify_cocpit_login_page() {

			$this->modify_login = true;

		}

		/* Remove Menu Pages
		   ========================================================================== */
		
		protected function remove_menu_page($page) {

			self::$pages_to_remove[] = $page;

		}

		public function remove_pages() {


			foreach (self::$pages_to_remove as $page) {
				
				remove_menu_page($page);			

			}

		}

		/* User Table Modification
		   ========================================================================== */
		
		public function remove_user_table_columns() {


			$this->remove_user_table_columns = true;

		}


		/* WooCommerce
		   ========================================================================== */
		

		public function rename_woocoomerce() {
		   
		    global $menu;
		    global $submenu;

		    return;

		    if(current_user_can('questus-admin')) {
		    		
	    		$wooCommerce = $this->recursive_array_search_php_91365( 'WooCommerce', $menu );
			    	$wooCommerceDodatki = $this->recursive_array_search_php_91365( 'Dodatki', $submenu['woocommerce'] );
			    	$wooCommerceStatus = $this->recursive_array_search_php_91365( 'Status Systemu', $submenu['woocommerce'] );
			    	$wooCommerceZamowienie= $this->recursive_array_search_php_91365( 'Zamówienie do PDF', $submenu['woocommerce'] );

			    if( $wooCommerce )  $menu[$wooCommerce][0] = 'Ustawienia sklepu';
			    if($wooCommerceDodatki) unset($submenu['woocommerce'][$wooCommerceDodatki]);
			    if($wooCommerceStatus) unset($submenu['woocommerce'][$wooCommerceStatus]);
			    if($wooCommerceZamowienie) unset($submenu['woocommerce'][$wooCommerceZamowienie]);

			}
	
		}


		function recursive_array_search_php_91365( $needle, $haystack ) {
		    foreach( $haystack as $key => $value ) 
		    {
		        $current_key = $key;
		        if( 
		            $needle === $value 
		            OR ( 
		                is_array( $value )
		                && $this->recursive_array_search_php_91365( $needle, $value ) !== false 
		            )
		        ) 
		        {
		            return $current_key;
		        }
		    }
		    return false;
		}


		/* Selectors
		   ========================================================================== */
		
		public function hide_elements_by_selectors() {

			$electors= implode(',', self::$selectors );

 			echo "<style> $electors {display: none!important;} </style>";
        
		}

		public function add_to_hide($selector) {

			self::$selectors[] = $selector;

		}

		/* 
		   ========================================================================== */
		
		
		/**
		 * Call after adding all setings to plugins
		 * @return void 
		 */
		public function init() {
	

			/* Top Menus
			   ========================================================================== */
			

			if( $this->remove_top_menu ) {

				add_action( 'wp_before_admin_bar_render', array($this, 'remove_top_menu_hook' ) ) ;

			}

			/* Dasboards
			   ========================================================================== */
			
			if( $this->remove_dashboard ) {

				add_action( 'wp_dashboard_setup', array($this, 'remove_dashboard_hook' ) ) ;

			}

			/* Login Page
			   ========================================================================== */
			

			if( $this->modify_login ) {

				add_action('login_head', array($this, 'login_page_modify_hook'));

			}

			/* Elements
			   ========================================================================== */
			

			if(!empty(self::$selectors)) {

				add_action('admin_head', array($this, 'hide_elements_by_selectors')); 

			}

			/* Menu
			   ========================================================================== */
			
			if(!empty(self::$pages_to_remove)) {

				add_action('admin_menu', array($this, 'remove_pages')); 

			}

			if($this->remove_update_msg) {

				add_filter('pre_site_transient_update_core', array($this, 'remove_update_msg_hook') );
				add_filter('pre_site_transient_update_plugins', array($this, 'remove_update_msg_hook'));
				add_filter('pre_site_transient_update_themes', array($this, 'remove_update_msg_hook'));

			}


			/* Users columns delete
			   ========================================================================== */
			
			if($this->remove_user_table_columns) {

				add_filter("manage_users_columns", array($this, "remove_user_columns_filter") );

			}

			/* Remove update notifications
			   ========================================================================== */
			
			add_action( 'admin_head', array($this, 'hide_update_notice'), 1 );

			add_action( 'admin_menu', array($this, 'rename_woocoomerce') , 999 );



			/* Add styles
			   ========================================================================== */
			
			add_action( 'admin_enqueue_scripts', array($this, 'add_styles'), 20 );

		}

		public function add_styles() {

			global $wp_scripts;

			 wp_register_style( 
			 	
			 	'kg_cocpit_styles', 
			 	plugins_url( '../assets/css/style-cocpit.css', __FILE__ )
			 
			 );	

			 wp_enqueue_style( 'kg_cocpit_styles' );

		}


		function hide_update_notice() {
		    
		     remove_action( 'admin_notices', 'update_nag', 3 );
		    
		}

		protected function remove_wp_labels() {

			$this->add_to_hide('#footer-thankyou');
			$this->add_to_hide('#footer-upgrade');
			$this->add_to_hide('.column-username .edit');

		}

		protected function clean_user_table() {

			$this->add_to_hide('#changeit');
			$this->add_to_hide('select[name="new_role"]');
			$this->add_to_hide('input[type="checkbox"]#user_' . KG_Config::getPublic('questus_user_id')); // cant remove questus
			$this->add_to_hide('tr#user-' . KG_Config::getPublic('koda_user_id') .' input[type="checkbox"]');  // cant remove koda
	
		}

		public function remove_user_columns_filter($columns) {

			unset($columns['username']);
			unset($columns['name']);
			// unset($columns['role']);
			unset($columns['posts']);

			return $columns;

		} 


	}
