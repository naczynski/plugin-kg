<?php  
	

	class KG_Resources_Loop extends KG_Loop {

		private $wp_query;

		private $post_types = array('link','ebook','event','pdf','quiz', 'task');
		private $posts;
		private $page; // current page
		
		public function __construct() {
		}

		public function render() {
			if (empty($this->posts) ) return array(); 
			$out = [];
			foreach ($this->posts as $resource) {
				$out[] = KG_get_resource_object($resource->ID, $resource->post_type)->get_serialized_fields_for(get_current_user_id());
			}
			return $out;
		}

		private function add_sorted_column_hook($params){
			if(empty($params['sorted'])) return;
			if (!in_array($params['sorted'], array('likes','actions'))) return;

			add_filter('posts_orderby', function($query) use($params){
				if($params['sorted'] == 'likes') $column_name = 'sum_likes';
				if($params['sorted'] == 'actions') $column_name = 'sum_actions';
				return str_replace('post_date', $column_name, $query);	
			});
			
		}

		private function is_show_only_cim_resources($params){
			if( !KG_get_curr_user()->is_cim() ) return false;
			if (empty($params['show_only_cim_resources'])) return false;
			// check if select to show
		
			return ($params['show_only_cim_resources'] =='true');
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
			
			if( !empty($params['type']) ) {
				$out['post_type'] = (array) $params['type'];			
			} else {
				$out['post_type'] = array('quiz');
			}

			/* Tags & Categories
			   ========================================================================== */

			if( empty($params['tags'][0]) && empty($params['categories'][0]) ){
				$out['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => KG_Config::getPublic('categories_all'),
						'operator' => 'IN',
					)
				);
			} else if( !empty($params['tags'][0]) && empty($params['categories'][0]) ){
				$out['tax_query'] = array(
					array(
						'taxonomy' => 'subtype',
						'field'    => 'term_id',
						'terms'    => $params['tags'],
						'operator' => 'IN',
					)
				);
				
			} else if( empty($params['tags'][0]) && !empty($params['categories'][0]) ){
				$out['tax_query'] = array(
					'relations' => 'AND',
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $params['categories'],
						'operator' => 'IN',
					)
				);
			} else {
				$out['tax_query'] = array(
					'relations' => 'AND',
					array(
						'taxonomy' => 'subtype',
						'field'    => 'term_id',
						'terms'    => $params['tags'],
						'operator' => 'IN',
					),
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => (array) $params['categories'],
						'operator' => 'IN',
					)
				);
			}

			if( !KG_get_curr_user()->can_networking() ){
				$out['tax_query'][] = array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => (array) KG_Config::getPublic('category_tasks'),
						'operator' => 'NOT IN',
				);
			}

			/* HIDE FROM FRONT
		   ========================================================================== */

			$out['meta_query'] = array(
				'AND',
				array(
					'key'     => 'hide_from_front',
					'value'   => '0',
				),
			);

			/* CIM
			   ========================================================================== */

			if($this->is_show_only_cim_resources($params)){
				$out['meta_query'] = array(
				'AND',
					array(
						'key'     => 'only_for_cim',
						'value'   => '1',
					),
				);
			} else if(!KG_get_curr_user()->is_cim()) {
				$out['meta_query'] = array(
				'AND',
					array(
						'key'     => 'only_for_cim',
						'value'   => '0',
					),
				);	
			}

			/* Order
			   ========================================================================== */

			$out['meta_key'] = 'promoted';
			$out['orderby'] = 'meta_value_num date';
			$out['order'] = 'DESC DESC';

			/* Search
			   ========================================================================== */
			
			if( !empty($params['search']) ) $out['s'] = sanitize_text_field ( $params['search'] );

			/* Id
			   ========================================================================== */
			
			if( !empty($params['ids']) ) {
				$out['post__in'] = (array) $params['ids'];
				$out['orderby'] = 'post__in';
			}

			$out = apply_filters('kg_resource_query_params', $out);
			return $out;

		}

		public function get($params) {
			
			// $params['show_only_cim_resources'] = 'false';
			// $params['sorted'] = 'likes';
			$this->add_sorted_column_hook($params);
			$this->wp_query = new WP_Query($this->get_params($params));
			// kg_log($this->wp_query->request);
			$this->posts = $this->wp_query->get_posts(); 
			
			return $this->render();
		}

		public function get_default(){
			return $this->get(array(
				'page' => 1,
				'type' => ['pdf','event','ebook','link','quiz','task']
			));
		}

		public function is_last_page() {
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