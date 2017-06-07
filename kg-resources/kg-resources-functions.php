<?php

	/**
	 * factory for resources objects
	 * @param int $id 
	 */
	function KG_get_resource_object($id, $type = false) {

		if( !$type ) {
			$wp_post = WP_Post::get_instance($id);
			if( !$wp_post ) return new WP_Error('no_resource_found', __( 'Nie znaleziono takiego zasobu', 'kg')) ;
			$type = $wp_post->post_type;
		}

		switch($type) {
			case 'pdf' : return KG_Get::get('KG_Pdf_Item', $id); break;
			case 'link' : return KG_Get::get('KG_Link_Item', $id); break;
			case 'quiz' : return KG_Get::get('KG_Quiz_Item', $id); break;
			case 'event' : return KG_Get::get('KG_Event_Item', $id); break;
			case 'task' : return KG_Get::get('KG_Task_Item', $id); break;
			default: return KG_Get::get('KG_Pdf_Item',$id);	
		}

	}