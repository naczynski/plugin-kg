<?php

	defined( 'ABSPATH' ) || exit;

	include 'abstract/kg-component.php';

	/**
	 * Core Component
	 */
	class KG_Core_Loader extends KG_Component {

		public $name = 'Core';
		public $dir = 'kg-core';
		public $des = 'Main core module';

		protected $acf_config = array(
			'../kg-config/acf/kg-config-acf-event',
			'../kg-config/acf/kg-config-acf-links',
			'../kg-config/acf/kg-config-acf-options',
			'../kg-config/acf/kg-config-acf-pdf',
			'../kg-config/acf/kg-config-acf-present',
			'../kg-config/acf/kg-config-acf-price',
			'../kg-config/acf/kg-config-acf-promoted',
			'../kg-config/acf/kg-config-acf-quiz',
			'../kg-config/acf/kg-config-acf-resource-file',
			'../kg-config/acf/kg-config-acf-subscription',
			'../kg-config/acf/kg-config-acf-users-groups',
			'../kg-config/acf/kg-config-acf-task',
			'../kg-config/acf/kg-config-acf-hide-front',
			'../kg-config/acf/kg-config-acf-faq',
			'../kg-config/acf/kg-config-acf-cim',
		);

		protected $includes = array(
			
			// abstact
			'abstract/kg-ajax',
			'abstract/kg-config',
			'abstract/kg-loop',

			// interfaces
			
			'interfaces/kg-edit-user-tab',

			// models

			'models/kg-log',

			//config		
			'../kg-config/kg-config-categories',
			'../kg-config/kg-config-api',
			'../kg-config/kg-config-db',
			'../kg-config/kg-config-dirs',
			'../kg-config/kg-config-email',
			'../kg-config/kg-config-fields',
			'../kg-config/kg-config-resources',
			'../kg-config/kg-config-user-metakeys',
			'../kg-config/kg-config-user-roles',
			'../kg-config/kg-config-posts-keys',
			'../kg-config/kg-config-user-activities',

			//functions
			'kg-core-functions',
			'../kg-config/kg-config-pages-ids',
			'../kg-config/kg-config-main',

			//external apis
			'../kg-config/apps/kg-config-payu',
			'../kg-config/apps/kg-config-linkedin'
		);
		
		public function init_hooks() {
			if(function_exists("register_field_group")){
				$this->includes = array_merge($this->includes, $this->acf_config);
			}
			$this->start_without_create_instances();
		}

		public function init() {

		}

	}

