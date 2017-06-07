<?php

	KG_Config::setPublic('category_knowledge_to_inspire' , 88);
	KG_Config::setPublic('category_knowledge_to_share' , 89);
	KG_Config::setPublic('category_knowledge_to_master' , 90);
	KG_Config::setPublic('category_knowledge_to_listen' , 102);

	KG_Config::setPublic('category_case_study' , 97);
	KG_Config::setPublic('category_quzies' , 100);
	KG_Config::setPublic('category_events' , 98);
	KG_Config::setPublic('category_tasks' , 101);
	

	KG_Config::setPublic('category_knowledge' , 87);
	KG_Config::setPublic('category_recommended' , 92);
	KG_Config::setPublic('category_challenges' , 99);
	KG_Config::setPublic('category_cim' , 103);


	KG_Config::setPublic('categories_all' , array(
		KG_Config::getPublic('category_knowledge'),
		KG_Config::getPublic('category_recommended'),
		KG_Config::getPublic('category_challenges'),
		KG_Config::getPublic('category_cim'),
		KG_Config::getPublic('category_knowledge_to_share'),
		KG_Config::getPublic('category_knowledge_to_master'),
		KG_Config::getPublic('category_knowledge_to_listen'),
		KG_Config::getPublic('category_knowledge_to_inspire'),
		KG_Config::setPublic('category_case_study' , 97),
		KG_Config::setPublic('category_quzies' , 100),
		KG_Config::setPublic('category_events' , 98),
		KG_Config::setPublic('category_tasks' , 101)
	));

	KG_Config::setPublic('categories_main' , array(
		KG_Config::getPublic('category_knowledge'),
		KG_Config::getPublic('category_recommended'),
		KG_Config::getPublic('category_challenges'),
		KG_Config::getPublic('category_cim')
	));

	KG_Config::setPublic('categories_can_buy' , array(
		KG_Config::getPublic('category_knowledge_to_share'),
		KG_Config::getPublic('category_knowledge_to_master'),
		KG_Config::getPublic('category_knowledge_to_listen')
	));

	KG_Config::setPublic('categories_additional_desc' , array(
		KG_Config::getPublic('category_knowledge_to_inspire'),
		KG_Config::getPublic('category_knowledge_to_share'),
		KG_Config::getPublic('category_knowledge_to_master'),
		KG_Config::getPublic('category_knowledge_to_listen')
	));

	KG_Config::setPublic('categories_in_lightbox' , array(
		KG_Config::getPublic('category_knowledge_to_share'),
		KG_Config::getPublic('category_knowledge_to_master'),
		KG_Config::getPublic('category_knowledge_to_listen')
	));