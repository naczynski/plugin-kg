<?php

	class KG_Cocpit_Maintance_Actions {

		private $actions = array();

		public function __construct() {
			add_action('admin_menu', array($this, 'add_page_to_menu'), 3);
			$this->actions = apply_filters('kg_add_maintance_action', array());
		}

		/* parse Url
		   ========================================================================== */

		private function get_action_from_url() {
			return !empty($_GET['action']) ? $_GET['action'] : false;
		}

		private function get_page_url() {
			return '/wp-admin/admin.php?page=maintance-actions';
		}

		public function get_action_url($action) {
			return $this->get_page_url() . '&action='. $action;
		}

		public function render_table() {
			$_GLOBAL['maintance_actions'] = $this->actions;
			include plugin_dir_path( __FILE__ ) . 'views/actions-table.php';
		}

		public function render() {
			if(!current_user_can('maintance_actions')) return;
			do_action('kg_add_maintance_action_do_' . $this->get_action_from_url());

			echo '<h1>Akcje</h1>';
			if(!empty($this->get_action_from_url())) {
				echo str_replace(
					'{{message}}', 
					$this->actions[$this->get_action_from_url()]['message_finish'], 
					'<p style="margin: 20px 0;" class="update-nag message-no-relations">{{message}}</p>');
			}

			$this->render_table();
		}

		public function add_page_to_menu() {
			add_menu_page( 
				'Akcje',
				'Akcje',
				'maintance_actions', 
				'maintance-actions',
				array($this, 'render' ),
				'dashicons-hammer'
			);
			
		}

	}
	