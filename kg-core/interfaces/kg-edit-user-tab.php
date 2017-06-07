<?php
	
	interface KG_Edit_User_Tab{
		public function add_tab($config);
		public function render_page();
		public function add_scripts();
	}
	