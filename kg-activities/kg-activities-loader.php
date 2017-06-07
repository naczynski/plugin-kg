<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class KG_Activities_Loader extends KG_Component {

	public $name = 'Historia użytkownika w kokpicie';
	public $dir = 'kg-activities';
	public $desc = '';

	private function get_activities_includes(){
		$out = array();
		foreach ($this->activities as $category => $type) {	
			foreach ($type as $type_db => $name) {
				$path_to_dir = 'activities/' . $category . '/' . $name . '/';	
				$out[] = $path_to_dir . 'kg-activity-' . $name;
				$out[] = $path_to_dir . 'kg-activity-' . $name . '-action';
			}
		}
		return $out;
	}

	private function init_activities(){
		foreach ($this->activities as $category => $type) {	
			foreach ($type as $type_db => $name) {
				$path_to_dir = 'activities/' . $category . '/' . $name . '/';	
				$action_class_file_name = $path_to_dir . 'kg-activity-' . $name . '-action';
				$single_class_file_name = $path_to_dir . 'kg-activity-' . $name;
				KG_Get::get(
					$this->get_class_name($action_class_file_name), 
					$type_db,
					$this->get_class_name($single_class_file_name)
				);
			}
		}
	}

	protected $activities = array(

		'basket' => array(
			1 => 'add-to-basket-resource',
			2 => 'add-to-basket-present',
			3 => 'add-to-basket-subscription',
			4 => 'remove-from-basket'
		),

		'like' => array(
			5 => 'add-like',
			6 => 'remove-like'
		),

		'download' => array(
			7 => 'download-resource',
		),

		'user' => array(
			8 => 'change-type',
			9 => 'add-networking',
			10 => 'remove-networking',
			11 => 'activate',
			12 => 'deactivate',
			22 => 'change-avatar'
		),

		'email-activation' => array(
			13 => 'email-accept',
			14 => 'sent-email-activation'
		),

		'password' => array(
			15 => 'sent-email-recover',
			16 => 'change-password'
		),

		'fields' => array(
			17 => 'change-field'
		),

		'subscritpion' => array(
			18 => 'apply-subscription-cocpit',
			19 => 'apply-subscription-front'
		),

		'transactions' => array(
			20 => 'new-transaction',
			21 => 'payment-complete'
		),

		'quiz' => array(
			23 => 'solve-quiz',
			24 => 'assign-award'
		),

		'tasks' => array(
			25 => 'add-response',
			26 => 'like-response',
			27 => 'enought-likes',
			28 => 'join',
			29 => 'assign-award-task',
			30 => 'leave'
		)
		
	);

	private $activities_includes = array();

	protected $includes;

	protected $c = array();

	protected $static_includes = array(

		// abstract
		'abstract/kg-activity',
		'abstract/kg-activity-actions',

		// functions
		'kg-activities-functions',
		'kg-activities-filters',

		// loops
		'loops/kg-loop-activities',

		// cocpit
		'cocpit/kg-edit-user-tab-activities'
		
	);

	public function init_hooks() {

		$this->activities_includes = $this->get_activities_includes(); 

		$this->includes = array_merge($this->static_includes, $this->activities_includes);
		$this->start_without_create_instances();

		$this->init_activities();

		KG_Get::get('KG_Edit_User_Tab_Activites');
		
	}

	public function init() {
		
	}
	
}

