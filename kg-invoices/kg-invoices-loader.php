<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Invoices_Loader extends KG_Component {

		public $name = 'Faktury';

		public $dir = 'kg-invoices';

		public $des = '';

		protected $includes = array(
			'models/kg-invoice-factory',
			'models/kg-price-words'
		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Invoice_Factory');	
		}

		public function init() {
	
		}

	}
	