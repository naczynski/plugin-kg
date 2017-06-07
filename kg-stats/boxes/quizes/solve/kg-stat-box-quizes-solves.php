<?php

	class KG_Stat_Box_Quizes_Solves extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-quizes-solves', __( 'Rozwiązania quizów', 'kg' ), __FILE__);
		}

		public function render(){
			echo 'Ładowanie...';
		}

		public function render_with_params($page, $sort_column_name, $sort_direction){

			$loop = KG_Get::get('KG_Loop_Quizes_Results_All', array(
				'page' => $page,
				'sort_column_name' => $sort_column_name,
				'sort_direction' => $sort_direction
			));

			$quizes_results = $loop->get();
			$all_pages = $loop->get_page_numbers();

			$params_pagination = array(
				'current' => $page,
				'total' => $all_pages,
				'format' => '?paged=%#%',
				'prev_next' => false,
			);

			$pagination = KG_pagination($params_pagination, true);

			include plugin_dir_path( __FILE__ ) . 'view/kg-quizes-solves.php';	

		}


	}
