<?php

	trait KG_Item_Trait_Category {
		
		private $categories = array();

		private $main_category_id = 0;
		private $main_category_name = 0;

		private $sub_category_id = 0;
		private $sub_category_name = 0;

		private function get_categories() {
			if(!empty($categories)) return;
			$categories = get_the_category($this->id);
			foreach($categories as $category) { 
				if($category->category_parent == 0){
					$this->main_category_id = $category->cat_ID;
					$this->main_category_name = $category->name;
				} else {
					$this->sub_category_id = $category->cat_ID;
					$this->sub_category_name = $category->name;		
				}
			}
			return 0;
		}

		public function get_main_category_name(){
			if($this->main_category_name > 0) return $this->main_category_name;
			$this->get_categories();
			return $this->main_category_name;
		}

		public function get_main_category_id(){
			if($this->main_category_id > 0) return $this->main_category_id;
			$this->get_categories();
			return $this->main_category_id;
		}
 		
 		public function get_sub_category_name(){
 			if($this->sub_category_name > 0) return $this->sub_category_name;
			$this->get_categories();
			return $this->sub_category_name;
		}

		public function get_sub_category_id(){
			if($this->sub_category_id > 0) return $this->sub_category_id;
			$this->get_categories();
			return $this->sub_category_id;
		}

		public function is_case_study_category() {
			return ( $this->get_sub_category_id() == KG_Config::getPublic('category_case_study') );
		}


		public function is_knowledge_to_share_category() {
			return ( $this->get_sub_category_id() == KG_Config::getPublic('category_knowledge_to_share') );
		}


		public function is_knowledge_to_master_category() {
			return ( $this->get_sub_category_id() == KG_Config::getPublic('category_knowledge_to_master') );
		}


		public function is_knowledge_to_listen_category() {
			return ( $this->get_sub_category_id() == KG_Config::getPublic('category_knowledge_to_listen') );
		}


		public function is_knowledge_to_inspire_category() {
			return ( $this->get_sub_category_id() == KG_Config::getPublic('category_knowledge_to_inspire') );
		}

		public function get_item_tags(){
			return wp_get_post_terms($this->id, 'subtype');
		}

	}