<?php

	class KG_Cocpit_Metabox_Quiz_Stats {

		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action('admin_enqueue_scripts', array($this, 'add_scripts') );
		}
		
		public function add_meta_box( $post_type ) { 
       		if($post_type != 'quiz') return;
			
			add_meta_box(
				'quiz_stats'
				, __( 'Rozwiązania', 'kg' )
				, array( $this, 'render' )
				,'quiz'
				,'advanced'
				,'core'
			);

		}

		public function get_best_solved_users(){
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare(
					"SELECT DISTINCT user_id
					 FROM " . KG_Config::getPublic('table_quizes_results') . "
					 WHERE quiz_id = %d AND correct_answ = (
						SELECT MAX(correct_answ)
						FROM " . KG_Config::getPublic('table_quizes_results') . "	
						WHERE quiz_id = %d	
					 )", 
				$this->id, 
				$this->id), 
				ARRAY_A 
			); 
			$out = '';
			foreach ($data as $key => $user) {
				if($key != 0 ) $out .= ' , ';
				$user = KG_Get::get('KG_User', $user['user_id']);
				$out .= '<a target="_blank" href="' . $user->get_edit_page() . '">' . $user->get_name_and_surname() . '</a>';
			}
			return $out;
		}

		public function get_average_result_in_percange(){
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare(
					"SELECT AVG(correct_answ) AS avg 
					FROM " . KG_Config::getPublic('table_quizes_results') . "
					WHERE quiz_id = %d"
				, $this->id),
				ARRAY_A 
			); 
			return round( (int) $data[0]['avg'] / $this->quiz_obj->get_number_questions() * 100);;
		}

		public function most_frequently_choose_award(){
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare(
					"   SELECT award_resource_id, COUNT(award_resource_id) as how_many 
					    FROM " . KG_Config::getPublic('table_quizes_results') . "
					    WHERE quiz_id = %d
					    GROUP BY award_resource_id
					   	ORDER BY how_many DESC
						LIMIT 1;
					"
				, $this->id), 
				ARRAY_A 
			); 
			if(empty($data)){
				return 'Nikt nie wybrał nagrody za ten quiz';
			} 
			$kg_award = KG_get_resource_object($data[0]['award_resource_id']);
			return str_replace(
				array(
					'{{link}}',
					'{{name}}',
					'{{how_many}}'
				),
				array(
					$kg_award->get_admin_edit_link(),
					$kg_award->get_name_with_subtype(),
					$data[0]['how_many']
				),
				'<a target="_blank" href="{{link}}">{{name}}</a> ({{how_many}})'
			);
		}

		public function add_scripts() {
			 if(get_current_screen()->id == 'quiz') {
				 wp_register_script( 
				 	'kg_quiz_stats', 
				 	plugins_url( 'assets/quiz-stats.js', __FILE__ )
				 );	
				 wp_enqueue_script('kg_quiz_stats' );
			}
		}

		public function render( $post ) {

			  if($post->post_status == 'publish') {
			  		$this->id = $post->ID;
			  		$this->quiz_obj = KG_Get::get('KG_Quiz_Item', $this->id);
			  		$this->quizes_results = KG_Get::get('KG_Loop_Quizes_Results_Stat_Quiz', $this->id)->get();
			  		include plugin_dir_path( __FILE__ ) . 'views/quiz-stats.php';	
			  		return;
			  }
			  echo '<p>Brak statystyk dla danego quizu.</p>';
		}
		
								
	}