<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Authenticate_Loader extends KG_Component {

		public $name = 'Autoryzacja';

		public $dir = 'kg-authenticate';

		public $des = '';

		protected $includes = array(

			'lib/linkedin',

			'models/kg-authenticate',
			'models/kg-linkedin'
		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Authenticate');
		}

		public function init() {
		
		}

	}
	