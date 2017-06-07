<?php  
	
	class KG_Loop_Ativities extends KG_Loop {

		private $wp_query;

		public function render() {
			if (empty($this->posts) ) return array(); 
			$out = [];
			foreach ($this->posts as $item) {
				$out[] = KG_Get::get('OBJECT_NAME', $item);
			}
			return $out;
		}

		private function get_params() {

			return $out = array(
				// 'post_type' => array('transaction'),
				// 'posts_per_page' => -1,
				// 'author' => get_current_user_id()
			);

		}

		public function get($params) {
			$this->wp_query = new WP_Query($this->get_params());
			$this->posts = $this->wp_query->get_posts(); 
			return $this->render();
		}

		public function get_default() {

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