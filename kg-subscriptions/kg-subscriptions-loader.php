<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Subscriptions_Loader extends KG_Component {

		public $name = 'Abonament';
		public $dir = 'kg-subscriptions';
		public $des = '';

		protected $includes = array(
			
			'traits/kg-subscription-utils',

			'models/kg-subscriptions',

			'single/kg-item-subscription',
			'single/kg-user-subscription-entry',

			'cocpit/kg-edit-user-tab-resources',
			'cocpit/admin-ajax/kg-ajax-add-subscription'
		
		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Edit_User_Tab_Subscriptions');
		}	

		public function init() {
			KG_Get::get('KG_Ajax_Add_Subscription');
		}

	}