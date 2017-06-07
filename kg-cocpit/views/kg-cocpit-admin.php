<?php

	class KG_Cocpit_Admin extends KG_Cocpit_View {


		public function __construct() {

			$this->modify_cocpit_login_page();
			$this->remove_top_menu();
			$this->remove_dashboards();
			$this->remove_wp_labels();

			$this->add_to_hide('.menu-top.toplevel_page_edit-student'); // remoce edit user page
			$this->add_to_hide('[href="profile.php"]'); // remoce edit user page

			$this->init();

		}

	}
	