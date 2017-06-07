<?php

	// Overide default ACF relationhip field when sending preset
	class KG_Ajax_Box_Relationship extends KG_Ajax {

		private function is_show_only_which_can_buy() {
			return ( !empty($_POST['field_key']) && 
					  ($_POST['field_key']=='field_557f65b48f9cb' || $_POST['field_key']=='field_554866fd59a721')
				   );
		}

		function get_result( $post, $field, $the_post, $options = array() ) {
		
			// right aligned info
			$title = '<span class="relationship-item-info">';
				if( in_array('post_type', $field['result_elements']) ) {			
					$post_type_object = get_post_type_object( $post->post_type );
					$title .= $post_type_object->labels->singular_name;			
				}
			$title .= '</span>';
			
			// featured_image
			if( in_array('featured_image', $field['result_elements']) ) {	
				$image = '';
				if( $post->post_type == 'attachment' ) {
					$image = wp_get_attachment_image( $post->ID, array(21, 21) );
				} else {
					$image = get_the_post_thumbnail( $post->ID, array(21, 21) );	
				}
				$title .= '<div class="result-thumbnail">' . $image . '</div>';
			}
			
			// title
			$post_title = get_the_title( $post->ID );
			
			// empty
			if( $post_title === '' ) {	
				$post_title = __('(brak tytułu)', 'acf');
			}
			
			$title .= $post_title;
			
			// status
			if( get_post_status( $post->ID ) != "publish" ) {	
				$title .= ' (' . get_post_status( $post->ID ) . ')';
			}
					
			// filters
			$title = apply_filters('acf/fields/relationship/result', $title, $post, $field, $the_post);
			$title = apply_filters('acf/fields/relationship/result/name=' . $field['_name'] , $title, $post, $field, $the_post);
			$title = apply_filters('acf/fields/relationship/result/key=' . $field['key'], $title, $post, $field, $the_post);
				
			// return
			return $title;

		}
	
	
		function query_posts(){

	   		// vars
	   		$r = array(
	   			'next_page_exists' => 1,
	   			'html' => ''
	   		);
	   			
	   		// options
			$options = array(
				'post_type'					=>	'all',
				'taxonomy'					=>	'all',
				'posts_per_page'			=>	10,
				'paged'						=>	1,
				'orderby'					=>	'title',
				'order'						=>	'ASC',
				'post_status'				=>	'any',
				'suppress_filters'			=>	false,
				's'							=>	'',
				'lang'						=>	false,
				'update_post_meta_cache'	=>	false,
				'field_key'					=>	'',
				'nonce'						=>	'',
				'ancestor'					=>	false,
			);
			
			$options = array_merge( $options, $_POST );
					
			// convert types
			$options['post_type'] = explode(',', $options['post_type']);
			$options['taxonomy'] = explode(',', $options['taxonomy']);
			
			
			// load all post types by default
			if( in_array('all', $options['post_type']) ){
				$options['post_type'] = apply_filters('acf/get_post_types', array());
			}
			
			
			// attachment doesn't work if it is the only item in an array???
			if( is_array($options['post_type']) && count($options['post_type']) == 1 ){
				$options['post_type'] = $options['post_type'][0];
			}
			
			// load field
			$field = array();
			if( $options['ancestor'] ){
				$ancestor = apply_filters('acf/load_field', array(), $options['ancestor'] );
				$field = acf_get_child_field_from_parent_field( $options['field_key'], $ancestor );
			} else {
				$field = apply_filters('acf/load_field', array(), $options['field_key'] );
			}
			
			
			// get the post from which this field is rendered on
			$the_post = get_post( $options['post_id'] );
				
			// filters
			$options = apply_filters('acf/fields/relationship/query', $options, $field, $the_post);
			$options = apply_filters('acf/fields/relationship/query/name=' . $field['_name'], $options, $field, $the_post );
			$options = apply_filters('acf/fields/relationship/query/key=' . $field['key'], $options, $field, $the_post );
			
			
			// query
			$wp_query = ($this->is_show_only_which_can_buy() ) ? KG_Get::get('KG_Resources_Lightbox_Loop')->get_wp_query(array(
				'page' =>  $options['paged']
			)) : new WP_Query( $options );
	
			// global
			global $post;
						
			// loop
			while( $wp_query->have_posts() ) {
				
				$wp_query->the_post();
					
				// get title
				$title = $this->get_result($post, $field, $the_post, $options);
						
				// update html
				$r['html'] .= '<li><a href="' . get_permalink($post->ID) . '" data-post_id="' . $post->ID . '">' . $title .  '<span class="acf-button-add"></span></a></li>';
					
			}
			
			// next page
			if( (int)$options['paged'] >= $wp_query->max_num_pages ) {
				$r['next_page_exists'] = 0;
			}
			
			// reset
			wp_reset_postdata();
			
			// return JSON
			echo json_encode( $r );
			
			die();
				
		}
		
		public function __construct() {
			
			remove_all_actions('wp_ajax_acf/fields/relationship/query_posts');
			remove_all_actions('wp_ajax_nopriv_acf/fields/relationship/query_posts');
			parent::__construct('acf/fields/relationship/query_posts', array($this, 'query_posts') , '', '');

		}
		
	}
