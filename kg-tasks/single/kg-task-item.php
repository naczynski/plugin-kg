<?php 

	class KG_Task_Item extends KG_Item {

		private $awards_resources = array();
		private $users_participtate_ids = null;
		private $is_user_response = null;

		public function __construct($task_id) {
			parent::__construct($task_id);
		}
	
		public function get_number_of_likes_to_win() {
			if(empty($this->get_resource_meta()['likes_to_win'])) return 0;
			return (int) $this->get_resource_meta()['likes_to_win'];
		}

		public function can_buy() {
			return false;
		}

		public function can_like() {
			return false;
		}

		public function can_present() {
			return false;
		}

		public function can_download($user_id) {
			return false;
		}

		/* ==========================================================================
		   QUESTION
		========================================================================== */

		public function get_question(){
			return apply_filters('kg_short_desc',$this->get_resource_meta()['task_question']);
		}

		public function get_short_desc(){
			return $this->get_question();
		}

		public function get_long_desc(){
			return $this->get_question();
		}

		/* ==========================================================================
		   TYPE
		========================================================================== */

		public function get_task_type() {
			return $this->get_resource_meta()['task_type'];
		}

		public function is_forum(){
			return $this->get_task_type() == 'forum';
		}

		public function is_private(){
			return $this->get_task_type() == 'private';
		}

		public function get_type_tooltip() {
			return $this->is_forum() ? 
				'Możesz udzielić odpowiedzi wielokrotnie, masz również dostęp do wpisów innych użytkowników przed dodaniem własnego.' :
				'Odpowiedzi udzielone przez innych użytkowników możesz zobaczyć dopiero, gdy sam odpowiesz na zadane pytanie.' ;
		}

		public function get_type_name() {
			return $this->is_forum() ? 
				'Typ: Otwarte' :
				'Typ: Zamknięte' ;
		}

		public function get_type_html(){
			return str_replace(
				array(
					'{{tooltip}}',
					'{{class}}',
					'{{name}}'
				),
				array(
					$this->get_type_tooltip(),
					'',
					$this->get_type_name()
				),
				'<span title="{{tooltip}}" data-tooltip class="{{class}}">{{name}}</span>	'
			); 
			
		}

		/* ==========================================================================
		   STATUS
		========================================================================== */

		public function get_task_status() {
			return $this->get_resource_meta()['task_status'];
		}

		public function is_active(){
			return $this->get_task_status() == 'active';
		}

		public function is_closed(){
			return $this->get_task_status() == 'closed';
		}

		public function get_status_tooltip() {
			return $this->is_active() ? 
				'Zadanie aktywne, możesz udzielać odpowiedzi.' :
				'Zadanie zakończone, nie możesz już dodać odpowiedzi' ;
		}

		public function get_status_class() {
			return $this->is_active() ? 
				'gree-text' :
				'red-text' ;
		}

		public function get_status_name() {
			return $this->is_active() ? 
				'Status: Aktywne' :
				'Status: Zakończone' ;
		}

		public function get_status_html(){
			return str_replace(
				array(
					'{{tooltip}}',
					'{{class}}',
					'{{name}}'
				),
				array(
					$this->get_status_tooltip(),
					$this->get_status_class(),
					$this->get_status_name()
				),
				'<span title="{{tooltip}}" data-tooltip class="{{class}}">{{name}}</span>	'
			); 
			
		}

		/* ==========================================================================
		   DATE
		========================================================================== */

		private function get_date_creation(){
			return $this->get_wp_post_instance()->post_date;
		}

		/* ==========================================================================
		   AWARDS
		   ========================================================================== */

		private function get_awards_resources_ids(){
			return !empty($this->get_resource_meta()['resources_to_win']) ? 
					$this->get_resource_meta()['resources_to_win'] :
					array();
		}

		public function get_awards_resources() {
			if(!empty($this->awards_resources)) return $this->awards_resources;
			$award_resources_ids = $this->get_awards_resources_ids();

			foreach ($award_resources_ids as $resource_id) {
				$this->awards_resources[] = KG_get_resource_object($resource_id);	
			}
			return $this->awards_resources;	
		}

		public function is_can_win_this_resource($resource_id) {
			return in_array($resource_id, $this->get_awards_resources_ids());
		}

		/* ==========================================================================
		   IS RESPONSE
		   ========================================================================== */
		
		public function is_user_response($user_id){
			if(!empty($this->is_user_response)) return $this->is_user_response;
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare(
				  "SELECT COUNT(id) AS count FROM " . KG_Config::getPublic('table_tasks_reponses') . " 
				  WHERE task_id = %d AND user_id = %d", 
				  $this->get_ID(), 
				  $user_id
			     ),
				ARRAY_A 
			);
			$this->is_user_response = (int) $data['count'] > 0 ? true : false;
			return $this->is_user_response; 
		}

		/* ==========================================================================
		   USERS
		   ========================================================================== */

		private function get_proper_user_ids_array($array){
			$out = array();
			foreach ($array as $item) {
				$out[] = (int) $item['user_id'];
			}
			return array_unique($out);
		}

		public function get_user_ids_with_participite_in_task(){
			if(!empty($this->users_participtate_ids)) return $this->users_participtate_ids;
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare(
				  "SELECT user_id FROM " . KG_Config::getPublic('table_tasks_user_relations') . " 
				  WHERE task_id = %d", 
				  $this->get_ID() 
			     ),
				ARRAY_A 
			);
			$this->users_participtate_ids = $this->get_proper_user_ids_array($data);
			return $this->users_participtate_ids; 
		}

		public function count_user_participate(){
			return sizeof( $this->get_user_ids_with_participite_in_task() );
		}

		public function get_user_creator() {
			return KG_Get::get('KG_User', $this->get_wp_post_instance()->post_author );
		}

		public function is_user_participate($user_id) {
			return in_array($user_id, $this->get_user_ids_with_participite_in_task());
		}

		/* ==========================================================================
		   JOIN
		   ========================================================================== */

		public function join($user_id){
			if( $this->is_user_participate($user_id)) return;
			global $wpdb;
			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_tasks_user_relations'),
				array(
					'task_id' => $this->get_ID(),
					'user_id' => (int) $user_id,
					'date' => KG_get_time()
				),
				array(
					'%d',
					'%d',
					'%s',
				) 
			);
			if($insert){
				do_action('kg_join_to_task', $user_id, $this);
				if(!empty($this->users_participtate_ids)) $this->users_participtate_ids[] = $user_id;
			}
			return $insert;
		}

		/* ==========================================================================
	   	   LEAVE
	  	   ========================================================================== */

		public function leave($user_id){
			global $wpdb;
			$delete = $wpdb->delete( 
				KG_Config::getPublic('table_tasks_user_relations'),
				array(
					'task_id' => $this->get_ID(),
					'user_id' => (int) $user_id,
				),
				array(
					'%d',
					'%d'
				) 
			);
			if($delete){
				do_action('kg_leave_from_task', $user_id, $this);
			}
			return $delete;
		}

		/* ==========================================================================
	   		INFO
	  	   ========================================================================== */


	  	private function get_participate_text(){
	  		$count = $this->count_user_participate();
	  		if ($count == 0 || $count == 1) return ' Uczestniczy';
	  		if ($count == 2 || $count == 3 || $count == 4) return ' Uczestniczą';	
	  		return 'Uczesnticzy';
	  	 }

	  	private function get_persons_text(){
	  		$count = $this->count_user_participate();
	  		if ($count == 0) return ' osób';
	  		if ($count == 1) return ' osoba';
	  		if ($count == 2 || $count == 3 || $count == 4) return ' osoby';	
	  		return 'osób';
	  	}

	  	public function get_users_participate_info(){
			return $this->get_participate_text() . ": " . $this->count_user_participate() . $this->get_persons_text();
	  	}

	  	public function get_info(){
	  		return str_replace(
				array(
					'{{status}}',
					'{{type}}',
					'{{persons}}',
				), array(
					$this->get_status_html(),
					$this->get_type_html(),
					$this->get_users_participate_info()
				),
				'{{status}} <span class="white-text" layout-margin> | </span> {{type}} <span class="white-text" layout-margin> | </span> {{persons}}'
			);
	  	}

		/* ==========================================================================
		   ADD RESPONSE
		   ========================================================================== */

		public function add_response($response, $user_id){

			if($this->is_user_response($user_id) && $this->is_private()){
				return new WP_Error('already_answered', __( 'Już odpowiedziałeś na to zadanie.', 'kg' ) );
			}

			if($this->is_closed()){
				return new WP_Error('task_closed', __( 'To zadanie jest już zakończone, możesz tylko oglądać odpowiedzi innych.', 'kg' ) );
			}

			global $wpdb;
			$insert = $wpdb->insert( 
				KG_Config::getPublic('table_tasks_reponses'),
				array(
					'user_id' => $user_id,
					'task_id' => $this->get_ID(),
					'response' => $response,
					'date' => KG_get_time()
				),
				array(
					'%d',
					'%d',
					'%s',
					'%s',
				) 
			);

			if($insert) {
				$response_id = $wpdb->insert_id;
				do_action('kg_add_response_to_task', $this, KG_Get::get('KG_Task_Response', array(
					'id' => $response_id,
					'user_id' => $user_id,
					'task_id' => $this->get_ID(),
					'response' => $response,
					'date' => KG_get_time()
				)));
				return $response_id; 
			} else {
				return false;
			}
		}

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */

		public function get_serialized_fields_for($user_id){
			$fields = parent::get_serialized_fields_for($user_id);
			$fields['awards'] =  $this->get_awards_resources();
			$fields['info'] =  $this->get_info();

			$fields['task'] = array(
				'is_user_participate' => $this->is_user_participate($user_id),
				'is_user_answered' => $this->is_user_response($user_id),
				'users_participate' => $this->count_user_participate(),

				'status' => $this->get_task_status(),
				'status_tooltip' => $this->get_status_tooltip(),

				'type' => $this->get_task_type(),
				'type_tooltip' => $this->get_type_tooltip(),

				'id' => $this->get_ID(),
				'user' => $this->get_user_creator(),
				'title' => $this->get_name(),
				'question' => $this->get_question(),
				'date' => $this->get_date_creation(),
				'likes_to_get_award_for_response' => $this->get_number_of_likes_to_win() 
			);
			return $fields;
		}

	}
