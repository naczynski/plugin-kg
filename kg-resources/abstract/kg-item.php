<?php

	abstract class KG_Item {

		protected $id; // post id
		private $wp_post; // object WP_Post
		private $meta; // form acf plugin meta

		protected $related;

		public function __construct($id) {
			$this->id = $id;
		}

		/* ==========================================================================
		   DATA GETTER
		========================================================================== */

		protected function get_resource_meta() {
			if(empty($this->meta)){
				$this->meta = get_fields($this->id);
			}
			return $this->meta;
		}
		
		protected function get_wp_post_instance() {
			if(empty($this->wp_post)){
				$this->wp_post = WP_Post::get_instance($this->id);
			}

			return $this->wp_post;
		}
		
		/* ==========================================================================
		   RELATED
		   ========================================================================== */

		use KG_Item_Trait_Related;

	
		/* ==========================================================================
		   THUMNAILS
		   ========================================================================== */

		use KG_Item_Trait_Thumnail;


		/* ==========================================================================
		   META
		   ========================================================================== */
		
		use KG_Item_Trait_Meta;
		

		/* ==========================================================================
		   LIKES
		   ========================================================================== */
		
		use KG_Item_Trait_Likes;


		/* ==========================================================================
		   SUBTYPE
		   ========================================================================== */

		use KG_Item_Trait_Subtype;
		

		/* ==========================================================================
		   FREE RESOURCES
		   ========================================================================== */
		
		use KG_Item_Trait_Free_Resource;


		/* ==========================================================================
		   STATS
		   ========================================================================== */
		
		use KG_Item_Trait_Stats;
		

		/* ==========================================================================
		   BASKET
		   ========================================================================== */
		
		public function is_in_basket(){
			return KG_Get::get('KG_Basket')->is_in_basket($this->id);
		}

		/* ==========================================================================
		   CAN DOWNLOAD
		   ========================================================================== */
		
		public function can_download($user_id){
			return KG_Get::get('KG_Resource_Relations')->can_download($user_id, $this->id);
		}

		public function show_download_button(){
			if ($this->get_type() == 'link' || $this->get_type() == 'quiz' || $this->get_type() == 'event') return false;
			return $this->can_download(get_current_user_id());
		}

		/* ==========================================================================
		   PROMOTED
		   ========================================================================== */
		
		public function is_promoted() {
			return ( !empty($this->get_resource_meta()['promoted']) ) ? (bool) $this->get_resource_meta()['promoted'] : false ;
		}

		/* ==========================================================================
		   FILTER
		   ========================================================================== */
		
		public function get_filter_type(){			
			return $this->get_sub_category_id();
		}

		/* ==========================================================================
			MAIN CATEGORY 
			========================================================================== */
		
		use KG_Item_Trait_Category;

		/* ==========================================================================
		   SERIALIZATION
		   ========================================================================== */
		   
		use KG_Item_Trait_Serialization;


		/* ==========================================================================
		   AFTER BUY
		   ========================================================================== */
		   
		// overide by children
		public function after_buy(){

		}

		 /* ==========================================================================
		   ABSTRACT
		   ========================================================================== */
		   
		 abstract public function can_buy();
		 abstract public function can_like();
		 abstract public function can_present();

	}
