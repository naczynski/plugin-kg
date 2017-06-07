<?php

	class KG_Stat_Box_User_Table extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-user-table', __( 'Użytkownicy (ogólnie)', 'kg' ), __FILE__);
		}

		public function render(){
			echo 'Ładowanie...';
		}

		public function render_with_params($page, $sort_column_name, $sort_direction){

			$loop = KG_Get::get('KG_Loop_Box_Stat_Users_Table', array(
				'page' => $page,
				'sort_column_name' => $sort_column_name,
				'sort_direction' => $sort_direction
			));
			$users = $loop->get();
			$all_pages = $loop->get_page_numbers();

			$params_pagination = array(
				'current' => $page,
				'total' => $all_pages,
				'format' => '?paged=%#%',
				'prev_next' => false,
			);

			$pagination = KG_pagination($params_pagination, true);

			include plugin_dir_path( __FILE__ ) . 'view/kg-user-table.php';	

		}


	}
