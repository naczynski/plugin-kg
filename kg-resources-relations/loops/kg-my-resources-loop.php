<?php  
	
	
	class KG_My_Resources_Loop {

		private $posts;
		private $page;
		
		public function render() {
			if (empty($this->posts) ) return array(); 
			$out = [];
			$this->posts = array_reverse($this->posts);
			foreach ($this->posts as $resource) {
				$out[] = KG_get_resource_object($resource->ID, $resource->post_type)->get_serialized_fields_for(get_current_user_id());
			}
			
			return $out;
		}

		private function get_relation_type($params){
			if(!empty($params['relation_type'])){
			}
			return ( !empty($params['relation_type']) ) ? 
				(array) $params['relation_type'] : 
				KG_Get::get('KG_Resource_Relations')->get_all_relation_types();
		}

		private function get_resources_ids($types){
			return KG_Get::get('KG_Multi_Relation_Getter', $types)->get_ids(get_current_user_id());
		}

		private function get_params($params) {

			$out = array();

			/* Post In
			   ========================================================================== */

			$out['post__in'] = $this->get_resources_ids( $this->get_relation_type($params) );
			
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

			$out['post_type'] = KG_Config::getPublic('all_resources_post_types');			

			/* Search
			   ========================================================================== */
			
			if( !empty($params['s']) ) $out['s'] = sanitize_text_field ( $params['s'] );

			/* Order
			   ========================================================================== */
			
			$out['orderby'] = 'post__in';
			$out['order'] = 'DESC';
		
			return $out;

		}

		public function __construct($params = array()){
			$this->params = $this->get_params($params);
			if(empty($this->params['post__in'])) $this->params['post_type'] = array('none'); //dont show any
			$this->wp_query = new WP_Query(	$this->params );
		}

		public function get() {
			$this->posts = $this->wp_query->get_posts(); 
			return $this->render();
		}
		
		public function get_default() {
			if(empty($this->params['post__in'])) return array();
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