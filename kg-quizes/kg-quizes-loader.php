<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class KG_Quizes_Loader extends KG_Component {
	
	public $name = 'Quizy';
	public $dir = 'kg-quizes';
	public $des = '';

	protected $includes = array(

		'models/kg-quiz-result-factory',

		'abstract/kg-quiz-result',

		'single/kg-single-question',
		'single/kg-quiz-item',
		'single/kg-single-result-from-data',
		'single/kg-single-result-from-db',
		'single/kg-single-result-from-solve-id',

		'api/kg-api-check-quiz',
		'api/kg-api-assign-award',

		'loops/kg-loop-my-quizes-results',
		'loops/kg-loop-quizes-results-all',
		'loops/kg-loop-quizes-results-stat-quiz',
		
		'cocpit/kg-cocpit-metabox-quiz-stats',
		'cocpit/kg-cocpit-page-quiz-result',
		'cocpit/kg-edit-user-tab-quizes'

	);

	public function init_hooks() {
		$this->start_without_create_instances();
		KG_Get::get('KG_Api_Check_Quiz');
		KG_Get::get('KG_Api_Assign_Award');
		KG_Get::get('KG_Cocpit_Page_Quiz_Result');
		KG_Get::get('KG_Edit_User_Tab_Quizes');
		KG_Get::get('KG_Cocpit_Metabox_Quiz_Stats');
	}

	public function init() {
			
	}

}