<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Resources_Free_Loader extends KG_Component {

		public $name = 'Darmowe zasoby';
		public $dir = 'kg-resources-free';
		public $des = '';

		protected $includes = array(

			//models
			'models/kg-free-resources',

			//api
			'api/kg-api-free-resource'
		);

		public function init_hooks() {
			$this->start_with_create_instances();
		}	

		public function init() {
			
		}

	}