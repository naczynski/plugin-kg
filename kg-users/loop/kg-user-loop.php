<?php  
	
	class KG_User_Loop {

		private $params;
		private $user_types = array('coach','cim','vip','default');
		private $users;
		private $page; // current page

		private $default_options = array(
			'pagination' => true,
			'only_enable' => false,
			'only_enable_networking' => false,
			'only_email_activated' => false
		);

		public function __construct($params = array(), $default_options = array()){
			$this->params = $params;
			$this->default_options = wp_parse_args( $default_options, $this->default_options );

			add_filter( 'user_search_columns', function( $search_columns ) {
			    $search_columns[] = 'display_name';
			    return $search_columns;
			} );
			add_action('pre_user_query', function($data){

				if( $this->default_options['only_enable']){
					$data->query_where .= ' AND is_active = 1';
				}

				if( $this->default_options['only_enable_networking']){
					$data->query_where .= ' AND is_networking = 1';
				}

				if( $this->default_options['only_email_activated']){
					$data->query_where .= ' AND is_email_activated = 1';
			}

				$data->query_where = str_replace('\\\%', '%', $data->query_where);
			
			});
		}

		private function get_user_type($params){
			return !empty($params['user_type']) ? (array) $params['user_type'] : $this->user_types;
		}

		private function get_new_offset($page, $users_per_page){
			return (int) $users_per_page * ($page - 1);
		}

		/* ==========================================================================
		   META KEYS
		   ========================================================================== */
		
		private function get_only_active(){
			return array(
					'key' => KG_Config::getPublic('user_deactivate'),
					'compare' => 'NOT EXISTS'
				);
		}

		private function get_only_with_activated_email(){
			return array(
					'key' => KG_Config::getPublic('user_email_activated'),
					'value' => 'true',
					'compare' => '='
				);
		}

		private function get_only_with_networking_enable(){
			return array(
					'key' => KG_Config::getPublic('user_networing_active'),
					'value' => 'true',
					'compare' => '='
				);
		}

		private function get_with_specific_roles($roles){
			global $wpdb;
			$page_id = get_current_blog_id();
			
			return array(
			    'key' => $wpdb->get_blog_prefix() . 'capabilities',
			    'value' => '"(' . implode('|', array_map('preg_quote', $roles)) . ')"',
			    'compare' => 'REGEXP'
			);
		}

		private function get_meta_values($params){
			$out = array(
				'relation' => 'AND',
				$this->get_with_specific_roles( $this->get_user_type($params) ),
			);

			return $out;
		}

		private function get_meta_values_with_search($params){
			return array_merge($this->get_meta_values($params), array(
				array(
					 'relation' => 'OR',
					 array(
				 		'key' => 'kg_field_name',
						'value' => $params['s'],
						'compare' => 'LIKE'
					 ),
					 array(
				 		'key' => 'kg_field_surname',
						'value' => $params['s'],
						'compare' => 'LIKE'
					 )	
				)
			));
		}

		/* ==========================================================================
		   PARAMS
		   ========================================================================== */

		private function get_params($params) {
			$out = array();

			/* Paggination
			   ========================================================================== */
			
			if( $this->default_options['pagination'] ) {
				if( !empty($params['page']) ) {
					$this->page = (int) $params['page'];
				} else {
					$this->page = 1;
				}

				$out['offset'] = $this->get_new_offset($this->page, KG_Config::getPublic('users_per_page'));
				$out['page'] = $this->page;
				$out['number'] = KG_Config::getPublic('users_per_page');
			}

			$out['exclude'] = array(get_current_user_id());

			/* Search
			   ========================================================================== */
			
			if( !empty($params['s']) ) {
				$out['search'] = '%' . $params['s'] . '%'; 
				$out['search_columns'] = array('display_name');
			} 

			$out['meta_query'] = $this->get_meta_values($params);
			return $out;
		}


		public function render() {
			if (empty($this->users) ) return array();

			$out = array(); 
			foreach ($this->users as $wp_user) {
				$out[] = KG_Get::get('KG_User', $wp_user);
			}
			return $out;
		}


		public function get() {
			global $wpdb;
			$this->wp_user_query = new WP_User_Query($this->get_params($this->params));
			$this->users = $this->wp_user_query->get_results(); 
			return $this->render();
		}


		public function get_default(){
			return $this->get(array());
		}


		public function is_last_page() {
			if ( sizeof($this->users) == 0 || !$this->default_options['pagination'] ) return true;
			return ( $this->page == $this->get_page_numbers() ) ? true : false;
		}
	

		public function get_page_numbers(){
			if ( !$this->default_options['pagination'] ) return 1;
			return ceil($this->get_numbers_found() / KG_Config::getPublic('users_per_page'));
		}


		public function get_curr_page() {
			return $this->page;
		}


		public function get_numbers_found() {
			return $this->wp_user_query->get_total();
		}
	}