<?php 

	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Users_Loader extends KG_Component {

		public $name = 'Użytkownicy';
		public $dir = 'kg-users';
		public $des = '';

		protected $includes = array(

			// models
			// 'models/kg-user-roles',

			'models/kg-activation-email',
			'models/kg-user-avatars',
			'models/kg-user-password',

			//register
			'register/kg-registration-validation',
			'register/kg-add-user',

			// kg-user
			'single/traits/kg-user-trait-fields',
			'single/traits/kg-user-trait-email',
			'single/traits/kg-user-trait-avatar',
			'single/traits/kg-user-trait-active',
			'single/traits/kg-user-trait-networking',
			'single/traits/kg-user-trait-email-activation',
			'single/traits/kg-user-trait-type',
			'single/traits/kg-user-trait-serializable',
			'single/traits/kg-user-trait-subscriptions',
			'single/traits/kg-user-trait-stats',
			'single/kg-user',

			//cocpit
			'cocpit/user-table/kg-cocpit-users-table-email',
			'cocpit/user-table/kg-cocpit-users-table-avatar',
			'cocpit/user-table/kg-cocpit-users-table-name',
			'cocpit/user-table/kg-cocpit-users-table-edit',
			'cocpit/user-table/kg-cocpit-users-table-networking',
			'cocpit/user-table/kg-cocpit-users-table-email-activation',
			'cocpit/user-table/kg-cocpit-users-table-type',
			'cocpit/user-table/kg-cocpit-users-table-active',
			'cocpit/user-table/kg-cocpit-users-table-subscription',

				//cocpit (edit user tabs)
				'cocpit/kg-edit-user-tab-main',

				//cocpit (pages)
				'cocpit/kg-cocpit-add-user',
				'cocpit/kg-cocpit-edit-student',

				//ajax
				'cocpit/ajax-cocpit/kg-ajax-add-user',
				'cocpit/ajax-cocpit/kg-ajax-activate',
				'cocpit/ajax-cocpit/kg-ajax-networking',
				'cocpit/ajax-cocpit/kg-ajax-email-activation',
				'cocpit/ajax-cocpit/kg-ajax-change-type',

			//api
			'api/kg-api-register',
			'api/kg-api-login',
			'api/kg-api-recover',
			'api/kg-api-profile-avatar',
			'api/kg-api-change-password-settings',
			'api/kg-api-delete-user-settings',
			'api/kg-api-get-users',

			//loops
			'loop/kg-user-loop',

			//function
			'kg-users-functions'

		);

		public function init_hooks() {
			
		}

		public function init(){
			$this->start_with_create_instances();
		}
		
	}
