<?php


if ( ! defined( 'WPINC' ) ) {
	die;
}

class KG_Maintenance_Loader extends KG_Component {
	
	public $name = 'Optymalizacja, zadania podczas integracji zadań, zmiany struktury bazy danych...';

	public $dir = 'kg-maintenance';

	public $des = '';

	protected $includes = array(

		'../kg-users/models/kg-user-roles',

		'actions/kg-maintance-action-copy-data-to-transaction-meta-table',
		'actions/kg-maintance-action-add-meta-to-resources',
		'actions/kg-maintance-action-delete-invoices',
		'actions/kg-maintance-action-clear-db',
		'actions/kg-maintance-action-tmp',
		'actions/kg-maintance-action-user-roles',

		'cocpit/kg-cocpit-maintance-actions'
	);

	public function init_hooks() {
				
	}

	public function init() {
		$this->start_with_create_instances();
	}
}