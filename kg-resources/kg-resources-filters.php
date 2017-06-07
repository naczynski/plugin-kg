<?php

	/* ==========================================================================
	   RESOURCE META 
	   ========================================================================== */
	
	function KG_remove_paragraphs($string) {
		return str_replace( array('<p>', '</p>') , '' , $string );
	}

	function KG_encode_qotes($string) {
		return str_replace( "'" , "&#39;" , $string );
	}

	//name
	add_filter('kg_name_before_subtype', 'KG_encode_qotes', 2, 1);
	add_filter('kg_name_no_subtype', 'KG_encode_qotes', 2, 1);

	//short desc
	add_filter('kg_short_desc', 'KG_remove_paragraphs', 2, 2);
    add_filter('kg_short_desc', 'KG_encode_qotes', 3, 1);
	
	//long desc
	add_filter('kg_long_desc', 'KG_encode_qotes', 1, 1);

	/* ==========================================================================
	   FILTER ACF RELATIONHIP FIELDS
	   ========================================================================== */
	
	function KG_filter_relationship_field_item($title, $post, $field, $the_post){

		$kg_item = KG_get_resource_object($post->ID);

		$pattern =  '<span class="relationship-item-info">{{type}}</span><div class="result-thumbnail"><img width="21" height="21" src="{{thumb}}" class="attachment-21x21 wp-post-image"/></div>{{name}}';
		
		return str_replace(array(
			'{{thumb}}',
			'{{name}}',
			'{{type}}'
		), array(
			$kg_item->get_thumbnail_small(),
			$kg_item->get_name_with_subtype(),
			$kg_item->get_subtype_name() != '' ? $kg_item->get_subtype_name() : $kg_item->get_type() 
		), $pattern);

	}

	add_filter('acf/fields/relationship/result', 'KG_filter_relationship_field_item', 1, 4);
