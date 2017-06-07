<?php 


	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Users_Groups_Loader extends KG_Component {

		public $name = 'Grupowanie użytkowników';

		public $dir = 'kg-users-groups';

		public $des = '';

		protected $includes = array(
			'cocpit/admin-ajax/kg-ajax-box-assign-users',
			'cocpit/admin-ajax/kg-ajax-sent-message-group',
			'cocpit/admin-ajax/kg-ajax-send-present-group',
			'cocpit/kg-users-group-sent-message',
			'cocpit/kg-users-group-add-present',

			'single/kg-single-users-group',

			'cocpit/groups-table-columns/kg-cocpit-groups-table-members',
			'cocpit/groups-table-columns/kg-cocpit-groups-table-name'

		);

		public function init_hooks() {
		}

		public function init() {
			$this->start_with_create_instances();
		}

	}
	