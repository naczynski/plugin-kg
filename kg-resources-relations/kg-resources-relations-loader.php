<?php 

	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Resources_Relations_Loader extends KG_Component {

		public $name = 'Powiązanie zasobó z użytkownikami';
		public $dir = 'kg-resources-relations';
		public $des = '';

		private function get_relations_for_includes(){
			$out = array();
			foreach (KG_Config::getPublic('all_relations') as $relation) {
				$out[] = 'relations/'. $relation['type_name'] . '/kg-'. $relation['type_name'] . '-relation-getter';
				$out[] = 'relations/'. $relation['type_name'] . '/kg-'. $relation['type_name'] . '-relation-single';
				$out[] = 'relations/'. $relation['type_name'] . '/kg-'. $relation['type_name'] . '-relation';
			}
			return $out;
		}

		protected $includes = array(

			//functions
			'kg-resources-relations-functions',

			// traits
			'traits/kg-resources-relations-utils',

			//abstract
			'abstract/kg-relation',
			'abstract/kg-single-relation',
			'abstract/kg-resource-relations-getter',

			//multi
			'models/kg-multi-relation-getter',

			//cocpit
			'cocpit/kg-edit-user-tab-resources',
			
			// actions
			'kg-resources-relations-actions',

			//loops
			'loops/kg-my-resources-loop',
			'loops/kg-resources-lightbox-loop',

			// models
			'models/kg-resource-realations',

			//admin ajax
			'cocpit/admin-ajax/kg-ajax-send-present',
			'cocpit/admin-ajax/kg-ajax-box-relationship',
			'cocpit/admin-ajax/kg-ajax-remove-relation',
			
			// api
			'api/kg-api-my-resources',
			'api/kg-api-resources-lightbox'
		);

		public function init_hooks() {
			$this->includes = array_merge($this->includes, $this->get_relations_for_includes());
			$this->start_without_create_instances();
			KG_Get::get('KG_Edit_User_Tab_Resources');
			KG_Get::get('KG_Ajax_Send_Present');
			KG_Get::get('KG_Api_My_Resources');
			KG_Get::get('KG_Api_Resources_Lightbox');
			KG_Get::get('KG_Ajax_Remove_Relation');
		}	

		public function init() {
			KG_Get::get('KG_Resources_Relations_Actions');
			KG_Get::get('KG_Ajax_Box_Relationship');
		}

	}