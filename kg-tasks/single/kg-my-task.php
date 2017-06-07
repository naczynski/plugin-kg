<?php

	class KG_My_Task implements JsonSerializable{

		private $task_id;
		private $task_obj;
		private $awards_data;

		public function __construct($data){
			$this->task_id = (int) $data['task_id'];
			$this->task_obj = KG_Get::get('KG_Task_Item', $this->task_id);
		}


		private function parse_result_data($data){
			$out = array();
			foreach ((array) $data as $entry) {
				$out[]= (int) $entry['award_resource_id']; 
			}

			return $out;
		}

		private function get_awards_data(){
			if(!empty($this->awards_data)) return $this->awards_data;
			global $wpdb;
			$data = $wpdb->get_results( 
				$wpdb->prepare(
				  "SELECT award_resource_id FROM " . KG_Config::getPublic('table_tasks_reponses') . " 
				  WHERE task_id = %d AND user_id = %d AND award_resource_id IS NOT NULL", 
				  $this->task_id,
				  get_current_user_id()
			     ),
				ARRAY_A 
			);
			$this->awards_data = $this->parse_result_data($data);
			return $this->awards_data;
		}

		private function is_user_win(){
			return sizeof($this->get_awards_data()) > 0;
		}

		private function prize_icon_tooltip(){
			if( !$this->is_user_win() ) return '';
			$out = 'Wygrałeś w tym zadaniu: ';
			$awards = $this->get_awards_data();
			foreach ($awards as $resource_id) {
				$out.= "<br />" . KG_get_resource_object($resource_id)->get_name_with_subtype() ;
			}
			return $out;
		}

		public function jsonSerialize(){
			return array(
				'task_id' => $this->task_obj->get_ID(),
				'name' => $this->task_obj->get_name(),
				'status' => $this->task_obj->get_task_status(), 
				'type' => $this->task_obj->get_task_type(),
				'users_joined' => $this->task_obj->count_user_participate( ),
				'type_tooltip' => $this->task_obj->get_type_tooltip(), 
				'status_tooltip' => $this->task_obj->get_status_tooltip(), 
				'link' => $this->task_obj->get_link(),
				'thumb' => $this->task_obj->get_thumbnail_big(),
				'user_participate_label' => $this->task_obj->get_users_participate_info(),
				'is_user_win' => $this->is_user_win(), 
				'prize_icon_tooltip' => $this->prize_icon_tooltip()
			);	
		} 

	}