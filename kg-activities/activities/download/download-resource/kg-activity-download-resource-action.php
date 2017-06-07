<?php

	class KG_Activity_Download_Resource_Action extends KG_Activity_Actions {

		public function __construct($type, $single_object_name){
			parent::__construct($type, $single_object_name);
			add_action('kg_download_resource', array(&$this, 'add'), $type, 2);
		}

		public function add($user_id, $resource_id){
			return KG_Add_Activity(array(
				'type' => $this->type,
				'user_id' => $user_id,
				'action_id' => null,
				'meta' => array(
					'id' => $resource_id,
					'name' => KG_get_resource_object($resource_id)->get_name_with_subtype() 
				)
			));
		}
		
	}