<?php 

	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Files_Loader extends KG_Component {

		public $name = 'Zarządzanie plikami w systemie';

		public $dir = 'kg-files';

		public $des = '';

		protected $includes = array(

			// interfaces
			'interfaces/kg-file-handler',

			// file handlers
			'file-handlers/kg-invoice-handler',
			'file-handlers/kg-resource-handler',

			'models/kg-download-handler',
			'models/kg-files-name-filter',

		);

		public function init_hooks() {
			$this->start_with_create_instances();
		}

		public function init(){
			
		}

	}
	