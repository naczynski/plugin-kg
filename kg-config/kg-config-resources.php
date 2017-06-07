<?php
		
	KG_Config::setPublic('big_thumb_w' , 300);
	KG_Config::setPublic('big_thumb_h' , 300);

    KG_Config::setPublic('default_avatar_file_name' , 'default_avatar.jpg' );
    KG_Config::setPublic('default_resource_thumb' , get_template_directory_uri() . '/assets/default_resource.png' );


    /* ==========================================================================
       POST TYPES
       ========================================================================== */
   
    KG_Config::setPublic('all_resources_post_types' , array('link','ebook','event','pdf','quiz')); 
     
    /* ==========================================================================
       LIGHTBOX ADD PRESENT (RESOUECES)
       ========================================================================== */
   
	KG_Config::setPublic('postypes_in_present_lightbox' , array(
		'pdf'
	));

	/* ==========================================================================
	   SUBTYPES
	   ========================================================================== */
	
	KG_Config::setPublic('subtypes_main' , array(
		'abstract',
		'iti',
		'ktu'
	));
	
	KG_Config::setPublic('subtypes_link' , array(
		'video',
		'event',
		'book',
		'raport',
		'article'
	));

	/* ==========================================================================
	   RELATIONS
	   ========================================================================== */

	// Present
	KG_Config::setPublic('relation_present' , array(
		'label' => __( 'Prezenty', 'kg' ),
		'type_db' => 1, 
		'type_name' => 'present',
		'enable_download' => true
	));

	// Like
	KG_Config::setPublic('relation_like' , array(
		'label' => __( 'Polubione', 'kg' ),
		'type_db' => 2, 
		'type_name' => 'like', 
		'enable_download' => false
	));

	// Quiz
	KG_Config::setPublic('relation_quiz' , array(
		'label' => __( 'Wygrane w quizach', 'kg' ),
		'type_db' => 3, 
		'type_name' => 'quiz',
		'enable_download' => true
	));

	// Buy
	KG_Config::setPublic('relation_buy' , array(
		'label' => __( 'Kupione', 'kg' ),
		'type_db' => 4, 
		'type_name' => 'buy',
		'enable_download' => true
	));

	// Task
	KG_Config::setPublic('relation_task' , array(
		'label' => __( 'Wygrane w zadaniach', 'kg' ),
		'type_db' => 5, 
		'type_name' => 'task',
		'enable_download' => true
	));

	KG_Config::setPublic('all_relations' , array(
		KG_Config::getPublic('relation_like'),
		KG_Config::getPublic('relation_present'),
		KG_Config::getPublic('relation_buy'),
		KG_Config::getPublic('relation_quiz'),
		KG_Config::getPublic('relation_task')
	));
