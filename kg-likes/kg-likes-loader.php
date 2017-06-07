<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Likes_Loader extends KG_Component {

		public $name = 'Likowanie';

		public $dir = 'kg-likes';

		public $des = '';

		protected $includes = array(

			'api/kg-api-like',
			'models/kg-likes'

		);

		public function init_hooks() {
			$this->start_with_create_instances();
		}

		public function init() {
			
		}

	}
	