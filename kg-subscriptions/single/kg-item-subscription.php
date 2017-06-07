<?php

	class KG_Item_Subscription {

		private $id;
		private $meta;

		private $days_durations;
		private $free_resources;
		private $prize;

		public function __construct($data){
			if( is_int($data) ){
				$this->id = $data;
			} else if(is_array($data)) {
				$this->days_durations = $data['days_durations'];
				$this->free_resources = $data['free_resources'];
				$this->price = $data['price'];
				$this->id = $data['subscr_id'];
			}
		}

		private function get_resource_meta() {
			if(empty($this->meta)){
				$this->meta = get_fields($this->id);
			}
			return $this->meta;
		}

		public function get_days_durations(){
			if (!empty($this->days_durations)) return $this->days_durations;
			return !empty($this->get_resource_meta()['days_durations']) ? $this->get_resource_meta()['days_durations'] : 0;
		}

		public function get_how_many_free_resources(){
			if (!empty($this->free_resources)) return $this->free_resources;
			return !empty($this->get_resource_meta()['free_resources']) ? $this->get_resource_meta()['free_resources'] : 0;
		}

		public function get_price(){
			if (!empty($this->price)) return $this->price;
			return !empty($this->get_resource_meta()['price']) ? $this->get_resource_meta()['price'] : 0;
		}

		public function allow_choose_free_resources(){
			return ($this->get_how_many_free_resources() > 0);
		}

		public function get_ID(){
			return $this->id;
		}

		public function get_admin_edit_link() {
			return get_edit_post_link($this->id);
		}

		public function get_name(){
			return WP_Post::get_instance($this->get_ID())->post_title;	
		}

		public function get_label(){

			$name = $this->get_name();
			$free_resources = $this->get_how_many_free_resources();
			$price = $this->get_price();
			$days = $this->get_days_durations();

			return "{$name} ({$free_resources} zasobów | {$price}zł | {$days} dni)";

		}

	}