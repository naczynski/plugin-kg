<?php

	class KG_Cocpit_Page_Transaction_Archive {

		private $sections = array();

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'));
		}

		public function get_url(){
			return '/wp-admin/admin.php?page=transactions';
		}

		public function render() {
			include plugin_dir_path( __FILE__ ) . 'views/transaction-archive.php';
		}

		public function add_page_to_menu() {
			add_menu_page( 		
				'Transakcje',
				'Transakcje',
				'show-transactions', 
				'transactions',
				array($this, 'render' ),
				'dashicons-cart',
				108);
		}

	}
