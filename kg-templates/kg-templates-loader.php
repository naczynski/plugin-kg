<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Templates_Loader extends KG_Component {

		public $name = 'Szablony';

		public $dir = 'kg-templates';

		public $des = '';


		protected $includes = array(

			//models
			'models/kg-redirections',

			//function
			'kg-templates-functions'
		

		);


		public function init_hooks() {
			$this->start_with_create_instances();
		}

		public function init() {

			add_action( 'admin_head-index.php', function(){
				 add_screen_option(
			        'layout_columns',
			        array(
			            'max'     => 2,
			            'default' => 1
			        )
			    );
			});

		}

	}
