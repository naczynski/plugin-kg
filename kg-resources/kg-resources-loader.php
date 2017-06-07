<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Resources_Loader extends KG_Component {

		public $name = 'Zasoby';

		public $dir = 'kg-resources';

		public $des = '';

		protected $includes = array(

			//abstract / traits
			
			'abstract/traits/kg-item-trait-likes',
			'abstract/traits/kg-item-trait-meta',
			'abstract/traits/kg-item-trait-related',
			'abstract/traits/kg-item-trait-serialization',
			'abstract/traits/kg-item-trait-subtype',
			'abstract/traits/kg-item-trait-thumnail',
			'abstract/traits/kg-item-trait-category',
			'abstract/traits/kg-item-trait-free-resource',
			'abstract/traits/kg-item-trait-stats',

			//abstract
			'abstract/kg-item',

			//cocpit
			'cocpit/kg-change-category-order',
			'cocpit/kg-edit-resource',
			'cocpit/kg-select-category-new-resource',

			//models
			'models/kg-category',

			//types
			'types/kg-pdf-item',
			'types/kg-event-item',
			'types/kg-link-item',

			//loops
			'loops/kg-resources-loop',

			//api
			'api/kg-api-resources',

			//functions
			'kg-resources-functions',

			//filters
			'kg-resources-filters',

		);

		private function add_media_sizes(){
			add_image_size( 'thumb_big', KG_Config::getPublic('big_thumb_w') , KG_Config::getPublic('big_thumb_h'), true );
		}

		public function init_hooks() {
			$this->start_without_create_instances();
			$this->add_media_sizes();	
		}

		public function init() {
			KG_Get::get('KG_Api_Resources');	
			KG_Get::get('KG_Category');

			//cocpit
			KG_Get::get('KG_Change_Category_Order');
			KG_Get::get('KG_Edit_Resource');
			KG_Get::get('KG_Select_Category_New_Resource');
		}

	}
	