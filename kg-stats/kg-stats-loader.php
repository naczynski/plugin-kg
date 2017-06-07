<?php 

	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class KG_Stats_Loader extends KG_Component {

		public $name = 'Statystyki';

		public $dir = 'kg-stats';

		public $des = '';

		protected $includes = array(

			'abstract/kg-stat-box',

			'kg-stats-functions',
			'kg-stats-filters',

			'models/kg-date-formatter-to-time-ago',
			'models/kg-user-stats',
			'models/kg-resources-stats',
			'models/kg-sessions-db',
			'models/kg-date-base-chart',
			
			'loops/kg-loop-box-stat-users-table',

			// users table
			'boxes/users/user-table/admin-ajax/kg-ajax-stat-user-table',
			'boxes/users/user-table/kg-stat-box-user-table',

			// users (TOP 10)
			'boxes/users/top-users/admin-ajax/kg-ajax-stat-top-users',
			'boxes/users/top-users/kg-stat-box-top-users',

			// average time on platform
			'boxes/users/average-time-on-platform/admin-ajax/kg-ajax-stat-average-time-on-platform',
			'boxes/users/average-time-on-platform/kg-stat-box-average-time-on-platform',

			// count log in
			'boxes/users/count-log-in/admin-ajax/kg-ajax-stat-count-log-in',
			'boxes/users/count-log-in/kg-stat-box-count-log-in',
			
			// count users
			'boxes/users/count-users/admin-ajax/kg-ajax-stat-count-users',
			'boxes/users/count-users/kg-stat-box-count-users',

			// count total
			'boxes/transactions/count-total/admin-ajax/kg-ajax-stat-count-total',
			'boxes/transactions/count-total/kg-stat-box-count-total',

			// count tarnsaction
			'boxes/transactions/count/admin-ajax/kg-ajax-stat-count',
			'boxes/transactions/count/kg-stat-box-count',
			
			// quizes table
			'boxes/quizes/solve/admin-ajax/kg-ajax-stat-quizes-solves',
			'boxes/quizes/solve/kg-stat-box-quizes-solves',

			//total
			'boxes/total/kg-stat-box-total',

		);

		public function add_scripts() {

			 wp_register_script( 
			 	'kg_stats_utils', 
			 	plugins_url( 'assets/utils.js', __FILE__ ),
			 	array('kg_chartjs_sketter', 'kg_moment')
			 );	

			 wp_register_script( 
			 	'kg_chartjs', 
			 	plugins_url( 'bower_components/Chart.js/Chart.min.js', __FILE__ )
			 );	

			 wp_register_script( 
			 	'kg_moment', 
			 	plugins_url( 'bower_components/moment/min/moment.min.js', __FILE__ )
			 );	

			  wp_register_script( 
			 	'kg_chartjs_sketter', 
			 	plugins_url( 'bower_components/Chart.Scatter.js/Chart.Scatter.min.js', __FILE__ ),
			 	array('kg_chartjs')
			 );	
		}

		public function init_hooks() {
			add_action('admin_enqueue_scripts', array($this, 'add_scripts') );	
			$this->start_with_create_instances();
		}

		public function init(){
			
		}

	}
	