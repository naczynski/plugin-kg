<?php

	class KG_Task_Response implements jsonSerializable {

		private $data;

		private function get_data_from_db($response_id) {
			global $wpdb;
			$data = $wpdb->get_row( 
				$wpdb->prepare("
					SELECT * FROM " . KG_Config::getPublic('table_tasks_reponses') . "
					WHERE id = %d
					", (int) $response_id ),
				ARRAY_A 
			); 
			return $data;
		}

		private function is_need_to_get_from_db($data){
			return is_int($data);
		}

		public function __construct($data){
			if($this->is_need_to_get_from_db($data)){
				$this->data = $this->get_data_from_db($data);
			} else {
				$this->data = $data;
			}
		}

		public function get_content(){
			if(empty($this->data['response'])) return '';
			return apply_filters('kg_message_content', $this->data['response']); 
		}

		public function get_content_plain(){
			if(empty($this->data['response'])) return '';
			return $this->data['response']; 
		}

		public function get_ID(){
			if(empty($this->data['id'])) return 0;
			return (int) $this->data['id']; 
		}

		public function is_correct_id(){
			return !empty($this->data['task_id']);
		}

		public function get_task_id() {
			if(empty($this->data['task_id'])) return false;
			return (int) $this->data['task_id']; 
		}

		public function get_task_obj(){
			return KG_Get::get('KG_Task_Item', $this->get_task_id());
		}

		public function get_user() {
			if(empty($this->data['user_id'])) return false;
			return KG_Get::get('KG_User', $this->data['user_id']); 
		}

		public function get_user_id() {
			if(empty($this->data['user_id'])) return false;
			return (int) $this->data['user_id']; 
		}

		public function get_date() {
			if(empty($this->data['date'])) return false;
			return $this->data['date']; 
		}		

		public function get_task_object() {
			return KG_Get::get('KG_Task_Item', $this->get_task_id());	
		}

		/* ==========================================================================
		ICONS   
		========================================================================== */

		public function is_show_present_icon(){
			return $this->get_user_id() != get_current_user_id();
		}

		public function is_show_message_icon(){
			return $this->get_user_id() != get_current_user_id();	
		}

		/* ==========================================================================
		LIKES   
		========================================================================== */

		public function is_can_like($user_id){
			return $this->get_user_id() != $user_id && !$this->is_user_liked($user_id);
		}

		private function is_enought_likes_to_get_prize($likes){
			return ( (int) $likes >= $this->get_task_object()->get_number_of_likes_to_win() );
		}

		public function update_number_likes($likes){
			global $wpdb;

			if( $this->sent_choose_award_alerts($likes)) {
				do_action('kg_can_choose_award_for_response', $this);
			}
			$this->data['likes']++;
			return $wpdb->update( 
				KG_Config::getPublic('table_tasks_reponses'), 
				array( 
					'likes' => (int) $likes,
				), 
				array( 'id' => $this->get_ID() ), 
				array( 
					'%d',
				), 
				array('%d') 
			);
		}

		public function get_admin_edit_url(){
			return KG_Get::get('KG_Cocpit_Page_Task_Response')->get_url($this->get_ID());
		}

		public function get_number_likes() {
			return (int) $this->data['likes'];
		}

		public function is_user_liked($user_id) {
			return KG_Get::get('KG_Task_Response_Likes')->is_liked_by_user($this->get_ID(), $user_id);
		}

		public function remove_like($user_id){
			return KG_Get::get('KG_Task_Response_Likes')->remove_like($this->get_ID(), $user_id);
		}

		public function like($user_id){
			if(!$this->is_can_like($user_id)){
				return new WP_Error('cant_like', __( 'Nie możesz polubić własnej odpowiedzi.', 'kg' ) );
			}
			do_action('kg_like_task_response', $user_id, $this);
			KG_Get::get('KG_Task_Response_Likes')->like($this->get_ID(), $user_id);
		}

		/* ==========================================================================
			AWARD   
			========================================================================== */

		public function sent_choose_award_alerts($likes){
			return ( (int) $likes == $this->get_task_object()->get_number_of_likes_to_win() );
		}

		public function is_user_choose_award(){
			return $this->data['award_resource_id'] != null ? true : false ;
		}

		public function get_award_resource(){
			if(!$this->is_user_choose_award()) return false;
			return KG_get_resource_object( (int) $this->data['award_resource_id']);
		}

		public function get_award_relation_id(){
			if(!$this->is_user_choose_award()) return false;
			return (int) $this->data['award_relation_id'];
		}

		public function is_get_prize() {
			return $this->is_enought_likes_to_get_prize( $this->get_number_likes() );
		}

		private function assign_award_in_db($resource_id, $relation_id){
			global $wpdb;

			return $wpdb->update( 
				KG_Config::getPublic('table_tasks_reponses'), 
				array( 
					'award_resource_id' => $resource_id,
					'award_relation_id' => $relation_id
				), 
				array( 'id' => $this->get_ID() ), 
				array( 
					'%d',
					'%d'
				), 
				array('%d') 
			);
		}

		public function add_award($resource_id){
			if($this->is_user_choose_award()) {
				return new WP_Error('no_passed_quiz', __( 'Już wybrałeś nagrodę za tę odpowiedź.', 'kg' ));
			}

			if(!$this->is_get_prize()) {
				return new WP_Error('get_prize', __( 'Przykro nam, ale nie zdobyłeś wystarczającej ilości polubień, by wygrać zasób.', 'kg' ));
			}

			if(!$this->get_task_object()->is_can_win_this_resource($resource_id)){
				return new WP_Error('bad_resource', __( 'Przykro nam, ale nie możesz wybrać tego zasobu jako nagrody.', 'kg' ));
			}

			if(KG_Get::get('KG_Resource_Relations')->can_download($this->get_user_id(), $resource_id)){
				return new WP_Error('bad_resource', __( 'Już posiadasz dany zasób.', 'kg' ));
			}

			$relation_obj = KG_Get::get('KG_Task_Relation', 
					$this->get_user_id(), 
					$resource_id, 
					$this->get_task_id());

			$relation_id = $relation_obj->add_to_db();
			$result = $this->assign_award_in_db($resource_id, $relation_id);
			
			if($result) {
				$this->data['award_resource_id'] = $resource_id;
				$this->data['award_relation_id'] = $relation_id;
				do_action('kg_task_assign_award', $this);
			}

			return $result;
		}

		public function remove_award() {
			global $wpdb;

			$result = $wpdb->update( 
				KG_Config::getPublic('table_tasks_reponses'), 
				array( 
					'award_resource_id' => null,
					'award_relation_id' => null
				), 
				array( 'id' => $this->get_ID() ), 
				array( 
					'%d',
					'%d'
				), 
				array( '%d' ) 
			);

			if($result) {
				$this->quiz_result_data['award_resource_id'] = $resource_id;
				$this->quiz_result_data['award_relation_id'] = $relation_id;
			}

			return $result;
		}

		/* ==========================================================================
			REMOVE   
		========================================================================== */

		public function remove(){
			global $wpdb;
			$result = $wpdb->delete( 
				KG_Config::getPublic('table_tasks_reponses'), 
				array( 'id' => $this->get_ID() ), 
				array( '%d' ) 
			);
			do_action('kg_remove_task_response', $this->get_ID());
			return $result;
		}

		/* ==========================================================================
			UPDATE   
		========================================================================== */

		public function update($response){
			global $wpdb;
			$result = $wpdb->update( 
				KG_Config::getPublic('table_tasks_reponses'),
				array(
					'response' => $response
				), 
				array( 'id' => $this->get_ID() ), 
				array( '%s' ),
				array( '%d' ) 
			);
			if($result){
				$this->data['response'] = $response;	
			}
			return $result;
		}

		/* ==========================================================================
			COCPIT   
		========================================================================== */

		public function get_cocpit_class(){
			return $this->is_get_prize() ? 'task-get-prize' : '';
		}

		public function jsonSerialize() {
			return array(

				'id' => $this->get_ID(),
				'user' => $this->get_user(),
				'date' => $this->get_date(),
				
				'content' => $this->get_content(),

				'is_get_prize' => $this->is_get_prize(),
				'likes' => $this->get_number_likes(),
				'is_user_liked' => $this->is_user_liked( get_current_user_id() ),

				'is_user_choose_award' => $this->is_user_choose_award(),
				'prize' => $this->get_award_resource(),

				'show_present_icon' => $this->is_show_present_icon(),
				'show_message_icon' => $this->is_show_message_icon(),
				'can_like' => $this->is_can_like( get_current_user_id() ),

			);
		}

	}