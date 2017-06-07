<?php 

	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	
	class KG_Fields_Loader extends KG_Component {

		public $name = 'Zaawansowane pola użytkowników';

		public $dir = 'kg-fields';

		public $des = '';

		protected $includes = array(

			// trait
			'trait/kg-field-utils',

			// single
			'single/kg-user-field',
			'single/kg-user-group-fields',

			// loop
			'loop/kg-user-fields-loop',

			// api
			'api/kg-api-change-field',
			'api/kg-api-update-fields',

			// actions
			'kg-fields-actions',

			//ajax cocpit
			'cocpit/ajax-cocpit/kg-ajax-update-fields'

		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Api_Change_Field');
			KG_Get::get('KG_Ajax_Update_Fields');
			KG_Get::get('KG_Fields_Actions');
			KG_Get::get('KG_Api_Update_Fields');
		}

		public function init() {
			
		}
		
	}
