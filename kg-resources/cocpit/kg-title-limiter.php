<?php

	/*
	Add max character limit
	 */
	class KG_Title_Limiter {

		public function __construct(){
			add_filter( 'title_edit_pre', array($this, 'add_max_character_limit') , 10, 2 );
		}

		function add_max_character_limit( $content, $post_id ) {
		  	return $content;
		}

	}
