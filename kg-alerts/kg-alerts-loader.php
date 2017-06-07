<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class KG_Alerts_Loader extends KG_Component {

	public $name = 'Powiadomienia dla użytkownika';
	public $dir = 'kg-alerts';
	public $desc = '';

	private function get_alerts_includes(){
		$out = array();
		foreach ($this->alerts as $category => $type) {	
			foreach ($type as $type_db => $name) {
				$path_to_dir = 'alerts/' . $category . '/' . $name . '/';	
				$out[] = $path_to_dir . 'kg-alert-' . $name;
				$out[] = $path_to_dir . 'kg-alert-' . $name . '-action';
			}
		}
		return $out;
	}

	private function init_alerts(){
		foreach ($this->alerts as $category => $type) {	
			foreach ($type as $type_db => $name) {
				$path_to_dir = 'alerts/' . $category . '/' . $name . '/';	
				$action_class_file_name = $path_to_dir . 'kg-alert-' . $name . '-action';
				$single_class_file_name = $path_to_dir . 'kg-alert-' . $name;
				KG_Get::get(
					$this->get_class_name($action_class_file_name), 
					$type_db,
					$this->get_class_name($single_class_file_name)
				);
			}
		}
	}

	protected $alerts = array(

		'users' => array(
			1 => 'enable-networking',
			2 => 'disable-networking',
			3 => 'set-vip',
			4 => 'set-cim',
			5 => 'set-coach',
			6 => 'set-default'
		),

		'presents' => array(
			7 => 'get-present'
		),

		'subscription' => array(
			8 => 'apply-subscription'
		),

		'messages' => array(
			9 => 'new-message'
		),

		'transactions' => array(
			10 => 'complete-transaction',
			12 => 'cancel-transaction',
		),

		'resources' => array(
			11 => 'new-resources-assign'
		),

		'tasks' => array(
			13 => 'task-choose-award',
			14 => 'task-new-response'
		)

	);

	protected $includes;

	protected $c = array();

	protected $static_includes = array(

		// abstract
		'abstract/kg-alert',
		'abstract/kg-alert-actions',

		// functions
		'kg-alerts-functions',
		'kg-alerts-filters',

		// loops
		'loops/kg-loop-alerts',

		// models
		'models/kg-alerts-not-readed-counter',

		// api
		'api/kg-api-alert-set-as-readed',
		'api/kg-api-alert-set-all-as-readed',
		'api/kg-api-alerts-get'
		
	);

	public function init_hooks() {

		$this->alerts_includes = $this->get_alerts_includes(); 
		$this->includes = array_merge($this->static_includes, $this->alerts_includes);
		$this->start_without_create_instances();
		$this->init_alerts();

		KG_Get::get('KG_Alerts_Not_Readed_Counter');
		
	}
	
	public function init() {
		KG_Get::get('KG_Api_Alert_Set_As_Readed');
		KG_Get::get('KG_Api_Alert_Set_All_As_Readed');
		KG_Get::get('KG_Api_Alerts_Get');
	}
	
}

