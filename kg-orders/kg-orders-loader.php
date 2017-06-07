<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Orders_Loader extends KG_Component {

		public $name = 'Tranzakcje, Koszyk';
		public $dir = 'kg-orders';
		public $des = '';

		protected $includes = array(

			'kg-orders-functions',

			'kg-orders-filters',

			'abstract/kg-single-order-item',

			'models/kg-basket',

			'single/kg-single-order-item-present',
			'single/kg-single-order-item-resource',
			'single/kg-single-order-item-subscription',
			'single/kg-transaction',

			// api
			'api/kg-api-basket-add-present',
			'api/kg-api-basket-add-resource',
			'api/kg-api-basket-add-subscription',
			'api/kg-api-basket-remove',
			'api/kg-api-finalize',

			// cocpit

				// admin ajax
				'cocpit/admin-ajax/kg-ajax-change-transaction-status',

				'cocpit/kg-cocpit-page-transaction-archive',
				'cocpit/kg-cocpit-page-transaction-single',

				'cocpit/kg-edit-user-tab-transactions',

			// loop
			'loops/kg-my-transactions-loop',
			'loops/kg-loop-transactions'
			
		);

		public function init_hooks() {
			$this->start_without_create_instances();
			KG_Get::get('KG_Edit_User_Tab_Transactions');
		}

		public function init() {

			KG_Get::get('KG_Api_Basket_Add_Present');
			KG_Get::get('KG_Api_Basket_Remove');
			KG_Get::get('KG_Api_Basket_Add_Resource');
			KG_Get::get('KG_Api_Basket_Add_Subscription');
			KG_Get::get('KG_Api_Finalize');

			// Cocpit
				 // Admin Ajax

				KG_Get::get('KG_Ajax_Change_Transaction_Status');
				KG_Get::get('KG_Cocpit_Page_Transaction_Archive');
				KG_Get::get('KG_Cocpit_Page_Transaction_Single');
		
		}

	}
	