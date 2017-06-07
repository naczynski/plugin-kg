<?php

	trait KG_Item_Trait_Meta {

		public function is_cim_resource(){
			return ( !empty( $this->get_resource_meta()['only_for_cim']) ) ? (bool) $this->get_resource_meta()['only_for_cim'] : false;
		}

		public function get_link() {
			return get_permalink($this->id);
		}

		public function get_type() {
			return $this->get_wp_post_instance()->post_type;
		}

		public function is_extra_name(){
			return in_array($this->get_main_category_id(), KG_Config::getPublic('categories_additional_desc') );
		}

		public function get_item_date_creation(){
			return $this->get_wp_post_instance()->post_date_gmt; 
		}

		public function get_name() {

			if ( $this->is_extra_name() ) {	
				$title = apply_filters('kg_name_before_subtype', $this->get_wp_post_instance()->post_title, KG_Config::getPublic('max_characters_title') );
				return apply_filters('kg_name_after_subtype' , $title );
			} 

			return apply_filters('kg_name_no_subtype', $this->get_wp_post_instance()->post_title, KG_Config::getPublic('max_characters_title') );
		}

		public function get_short_desc() {
			return ( !empty( $this->get_resource_meta()['excerpt']) ) ? apply_filters('kg_short_desc', $this->get_resource_meta()['excerpt'], KG_Config::getPublic('max_characters_short_desc') ) : '';
		}

		public function get_long_desc() {
			return apply_filters('kg_long_desc', $this->get_wp_post_instance()->post_content ) ;
		}
		
		public function get_ID() {
			return $this->id;
		}

		public function get_admin_edit_link() {
			return get_edit_post_link($this->id);
		}


	}