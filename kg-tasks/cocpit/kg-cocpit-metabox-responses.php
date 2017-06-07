<?php

	class KG_Cocpit_Metabox_Responses {

		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action('admin_enqueue_scripts', array($this, 'add_scripts') );

		}
		
		public function add_meta_box( $post_type ) { 
       		if($post_type != 'task') return;
			
			add_meta_box(
				'add_responses_meta'
				, __( 'Odpowiedzi', 'kg' )
				, array( $this, 'render' )
				,'task'
				,'advanced'
				,'core'
			);
		}

		public function add_scripts() {

			 if(get_current_screen()->id == 'task') {
				
				 wp_register_script( 
				 	'kg_responses_scripits', 
				 	plugins_url( 'assets/get-responses.js', __FILE__ )
				 );	

				 wp_enqueue_script('kg_responses_scripits' );
			}

		}

		public function render( $post ) {	
			echo 'Ładowanie...';
		}
	
	}