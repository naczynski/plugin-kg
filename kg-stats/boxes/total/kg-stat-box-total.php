<?php

	class KG_Stat_Box_Total extends KG_Stat_Box {

		public function __construct(){
			parent::__construct('kg-stats-total', __( 'Ogólne', 'kg' ), __FILE__);
		}

		public function get_total_subscriptions(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT SUM(total_subscriptions) AS data
					 FROM . " . KG_Config::getPublic('table_transactions') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_total_resources(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT SUM(total_resources) AS data
					 FROM . " . KG_Config::getPublic('table_transactions') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_total_presents(){
				global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT SUM(total_presents) AS data
					 FROM . " . KG_Config::getPublic('table_transactions') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_total(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT SUM(total_brutto) AS data
					 FROM . " . KG_Config::getPublic('table_transactions') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_total_solve_quizes(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT COUNT(id) AS data
					 FROM . " . KG_Config::getPublic('table_quizes_results') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_total_sent_messages(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT COUNT(id) AS data
					 FROM . " . KG_Config::getPublic('table_messages') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_avg_spent(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(`time_spent`))) AS data
					 FROM . " . KG_Config::getPublic('table_sessions') ."
					",
				ARRAY_A 
			); 
			return str_split($data['data'], 8)[0];
		}

		public function get_total_log_in(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT COUNT(id) AS data
					 FROM . " . KG_Config::getPublic('table_sessions') ."
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function get_total_users(){
			global $wpdb;
			$data = $wpdb->get_row( 
					"SELECT COUNT(id) AS data
					 FROM {$wpdb->users}
					",
				ARRAY_A 
			); 
			return $data['data'];
		}

		public function render(){
			include plugin_dir_path( __FILE__ ) . 'view/kg-stats-total.php';	
		}

	}
