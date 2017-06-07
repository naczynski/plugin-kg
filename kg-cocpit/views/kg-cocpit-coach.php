<?php

	class KG_Cocpit_Coach extends KG_Cocpit_View {

		public function __construct() {
	
			$this->modify_cocpit_login_page();
			$this->remove_top_menu();
			$this->remove_dashboards();
			$this->remove_wp_labels();

			$this->remove_update_msg();

			$this->remove_menu_page('profile.php');
			$this->remove_menu_page('edit-comments.php');
			$this->remove_menu_page('tools.php');
			$this->remove_menu_page('options-general.php');
			$this->remove_menu_page('edit.php');
			$this->remove_menu_page('WordPress_Admin_Style');			
			$this->remove_menu_page('edit.php?post_type=acf');
			$this->remove_menu_page('admin.php?page=edit-student');

			$this->remove_user_table_columns();
			$this->clean_user_table();

			$this->add_to_hide('.menu-top.toplevel_page_edit-student'); // remoce edit user page
			$this->add_to_hide('[href="profile.php"]'); // remove edit user page
			
			$this->add_to_hide('[href="user-new.php"]'); 

			$this->add_to_hide('[href="admin.php?page=wc-settings"]'); 
			
			$this->add_to_hide('#wp-admin-bar-new-user'); 
	
			$this->add_to_hide('#inventory_product_data'); 
			$this->add_to_hide('#advanced_product_data'); 

			$this->add_to_hide('[value="administrator"]');

			$this->add_to_hide('#product_attributes'); 
			$this->add_to_hide('#linked_product_data'); 

			$this->add_to_hide('#footer-left'); 
		
			// Transactions
			$this->add_to_hide('.menu-top.toplevel_page_transaction-single');

			$this->add_to_hide('.menu-top.toplevel_page_show-quiz-result');
			$this->add_to_hide('.menu-top.toplevel_page_task-response');

			// User Groups
			$this->add_to_hide('.post-type-user-groups .subsubsub');
			$this->add_to_hide('.post-type-user-groups .tablenav.top');
			$this->add_to_hide('.post-type-user-groups .bulkactions');
			$this->add_to_hide('.post-type-user-groups .row-actions');
			$this->add_to_hide('.post-type-user-groups #minor-publishing');
			$this->add_to_hide('.post-type-user-groups #edit-slug-box');
			$this->add_to_hide('.post-type-user-groups .search-box');

			$this->init();
		}

	}
