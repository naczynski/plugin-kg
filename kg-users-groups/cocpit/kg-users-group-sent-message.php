<?php

	class KG_Users_Group_Sent_Message {

		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action('admin_enqueue_scripts', array($this, 'add_scripts') );

		}
		
		public function add_meta_box( $post_type ) { 
		    global $post;
	        if(!isset($post)) return;  

       		if($post_type != 'user-groups') return;
			
			add_meta_box(
				'sent_message_to_group'
				, __( 'Wyślij wiadomość do grupy', 'kg' )
				, array( $this, 'render' )
				,'user-groups'
				,'advanced'
				,'core'
			);
		}

		public function add_scripts() {

			 if(get_current_screen()->id == 'user-groups') {
				
				 wp_register_script( 
				 	'kg_user_group_scripts', 
				 	plugins_url( 'assets/single-group.js', __FILE__ )
				 );	

				 wp_enqueue_script('kg_user_group_scripts' );

			}

		}

		public function render( $post ) {	
			  if($post->post_status == 'publish') {
			  		include plugin_dir_path( __FILE__ ) . 'views/sent-message.php';	
			  		return;
			  }
			  echo '<p>Wysłać wiadomość możesz dopiero po utworzeniu grupy.</p>';
		}
	
	}