<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Generators_Loader extends KG_Component {

		public $name = 'Generowanie contentu do testu';

		public $dir = 'kg-generators';

		public $des = '';

		protected $includes = array(

			//abstract
			'abstract/kg-generator',
			
			//single
			'single/kg-user-generator',

			//function
			'kg-generators-functions'

		);

		public function init_hooks() {
			$this->start_with_create_instances();
		}

		public function init() {
			
		}

	}
	