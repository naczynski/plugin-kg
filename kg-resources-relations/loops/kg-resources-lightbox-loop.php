<?php  
	
	class KG_Resources_Lightbox_Loop extends KG_Loop {

		private $posts;
		private $page;
		private $options = array(
			'not_show_hidden' => false
		);
			
		public function __construct($options = array()){
			$this->options = wp_parse_args($options, $this->options);
			add_action('parse_tax_query', array($this, 'parse_correct_categories'));
		}

		public function parse_correct_categories($wp_query) {
			if ( empty($wp_query->tax_query->queries[2]) ) return;		
			$wp_query->tax_query->queries = array(
				$wp_query->tax_query->queries[2]
			);
		}

		public function render() {
			if (empty($this->posts) ) return array(); 
			$out = [];
			$this->posts = array_reverse($this->posts);
			foreach ($this->posts as $resource) {
				$out[] = KG_get_resource_object($resource->ID, $resource->post_type)->get_serialized_fields_for(get_current_user_id());
			}			
			return $out;
		}

		private function get_params($params) {

			$out = array();

			/* Curr page
			   ========================================================================== */
			
			if( !empty($params['page']) ) {
				$out['paged'] = (int) $params['page'];
				$this->page = (int) $params['page'];
			} else {
				$this->page = 1;
			}

			/* Post Types
			   ========================================================================== */

			$out['post_type'] = KG_Config::getPublic('postypes_in_present_lightbox');

			/* Categories
			   ========================================================================== */
			   
			$out['category__in'] = KG_Config::getPublic('categories_in_lightbox');

			/* Search
			   ========================================================================== */
			
			if( !empty($params['search']) ) $out['s'] = sanitize_text_field($params['search']);


			/* Not show if set in cocpit
			   ========================================================================== */

		   if($this->options['not_show_hidden'] == true){

		   		$out['meta_query'] = array(
					array(
						'key'     => 'hide_from_front',
						'value'   => '0',
					),
				);

		   }

			/* Order
			   ========================================================================== */
			
			$out['order'] = 'DESC';
			return $out;

		}

		public function get($params) {
			global $wpdb;
			$this->wp_query = new WP_Query($this->get_params($params));
			$this->posts = $this->wp_query->get_posts(); 
			return $this->render();
		}

		public function get_wp_query($params) {
			return new WP_Query($this->get_params($params));
		}
	
		public function get_default(){
			return $this->get(array());
		}

		public function is_last_page() {
			if (empty($this->wp_query)) return true;
			if ( $this->wp_query->found_posts == 0) return true;
			return ( $this->page == $this->wp_query->max_num_pages ) ? true : false;
		}
		
		public function get_page_numbers() {
			 return (int) $this->wp_query->max_num_pages;
		}

		public function get_curr_page() {
			return (int) $this->page;
		}

		public function get_numbers_found() {
			return (int) $this->wp_query->found_posts;
		}

	}