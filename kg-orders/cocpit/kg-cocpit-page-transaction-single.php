<?php

	class KG_Cocpit_Page_Transaction_Single {

		private $sections = array();

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
			add_action('admin_enqueue_scripts', array($this, 'add_scripts') );
		}

		public function get_edit_link($id) {
			return '/wp-admin/admin.php?page=transaction-single&id=' . $id;
		}

		public function render() {
			if(empty($_GET['id'])) {
				echo '<p class="update-nag">Nie podałeś numeru transakcji</p>';
				return;
			}

			$kg_transaction = KG_Get::get('KG_Transaction', (int) $_GET['id']);

			if( $kg_transaction->is_error() ) {
				echo '<p class="update-nag">Nie transakcji o podanym numerze id</p>';
				return;
			}
			
			include plugin_dir_path( __FILE__ ) . 'views/transaction-single.php';
		}

		public function get_transaction_obj(){
			return KG_Get::get('KG_Transaction', (int) $_GET['id']);
		}

		public function get_view($name){
			include plugin_dir_path( __FILE__ ) . 'views/'. $name .'.php';
		}

		public function add_scripts() {

			 if(get_current_screen()->id == 'toplevel_page_transaction-single') {
				
				 wp_register_script( 
				 	'kg_tranasactions_scripts', 
				 	plugins_url( 'assets/transactions-scripts.js', __FILE__ )
				 );	
				 wp_enqueue_script('kg_tranasactions_scripts' );
			}
		}

		public function add_page_to_menu() {

			add_menu_page( 		
				'Transakcje (pojedyncza)',
				'Transakcje (pojedyncza)',
				'show-transactions', 
				'transaction-single',
				array($this, 'render' ),
				'dashicons-cart',
				999);

		}

	}
