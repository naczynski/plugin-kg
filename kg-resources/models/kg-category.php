<?php

	class KG_Category {

		private function get_proper_data_of_term($category_obj) {
			return (object) array(
					 'name' => $category_obj->name,
					 'id' => $category_obj->cat_ID,
					 'hightlight' => $category_obj->slug == 'cim' ? true : false,
					 'main' => $category_obj->category_parent
				);	
		}

		private function is_cim_category_and_not_cim_user($tag_obj) {
			return ( !KG_get_curr_user()->is_cim() && $tag_obj->cat_ID == KG_Config::getPublic('category_cim') );
		}

		private function is_tasks_and_not_networking($tag_obj){
			return ( !KG_get_curr_user()->can_networking() && $tag_obj->cat_ID == KG_Config::getPublic('category_tasks') );
		}

		private function parse_childrens($taxonomies) {
			$out = array();
			foreach ($taxonomies as $term) {
				if( $this->is_cim_category_and_not_cim_user($term)) continue;
				if( $this->is_tasks_and_not_networking($term)) continue;
				$out[] = $this->get_proper_data_of_term($term);
			}
			return $out;
		}

		private function parse_taxonomies($taxonomies, $hierarchical = false) {
			$out = array();
			foreach ($taxonomies as $term) {
				if( $this->is_cim_category_and_not_cim_user($term)) continue;
				if( $this->is_tasks_and_not_networking($term)) continue;
				$tmp = $this->get_proper_data_of_term($term);
				$tmp->children = $this->parse_childrens( $this->get_categories_from_db( $tmp->id ) );
				$out[] = $tmp;
			}
			return $out;
		}

		/* ==========================================================================
		   CATEGORY
		   ========================================================================== */
	
		private function get_categories_from_db($parent = 0) {
			$categories = get_categories(array(
				'orderby' => 'id',
				'hide_empty' => false,
				'parent' => $parent,
			));

			if(is_wp_error($categories) ) {
				return array();
			}
			return $categories;
		}

		public function get_categories() {
			return $this->parse_taxonomies( $this->get_categories_from_db() );
		}

		/* ==========================================================================
		   TAGS
		   ========================================================================== */

		private function get_tags_from_db(){
			$tags = get_categories(array(
				'orderby' => 'id',
				'hide_empty' => false,
				'parent' => 0,
				'taxonomy' => 'subtype'
			));

			if(is_wp_error($tags) ) {
				return array();
			}
			return $tags;
		}

		public function get_tags() {
			return $this->parse_taxonomies( $this->get_tags_from_db() );
		}

	}
