<?php

	class KG_Api_Resources extends KG_Ajax {

		private $resouces;

		public function show_posts() {

			 $out = array();
			 if( !current_user_can('get_resources')) {
			 	echo json_encode($this->get_object(true, __('Nie masz uprawnień aby pobrać zasoby z bazy.', 'kg')));
			 	return;
			 }
			 
			 $data = array();

			 if(!empty($_POST['page'])) $data['page'] = $_POST['page'];
			 if(!empty($_POST['categories'])) $data['categories'] = $_POST['categories'];
			 if(!empty($_POST['tags'])) $data['tags'] = $_POST['tags'];
			 if(!empty($_POST['search'])) $data['search'] = $_POST['search'];
		     if(!empty($_POST['type'])) $data['type'] = $_POST['type'];
		     if(!empty($_POST['filter'])) $data['filter'] = $_POST['filter'];
		     if(!empty($_POST['show_only_cim_resources'])) $data['show_only_cim_resources'] = $_POST['show_only_cim_resources'];
		     if(!empty($_POST['sorted'])) $data['sorted'] = $_POST['sorted'];
		
		     $resouces = KG_Get::get('KG_Resources_Loop')->get($data);

		     $out = $this->get_object(false, __('Poprawnie pobrano zasoby z bazy.', 'kg'), array(
		     		'resources' =>  $resouces ,
		     		'isLastPage'=> KG_Get::get('KG_Resources_Loop')->is_last_page(), 
				    'numberAllPages' => KG_Get::get('KG_Resources_Loop')->get_page_numbers(),
				    'found' =>  KG_Get::get('KG_Resources_Loop')->get_numbers_found(),
				    'page' => KG_Get::get('KG_Resources_Loop')->get_curr_page()
		     	)); 

			 echo json_encode($out);
			 die;

		}

		public function show_post($id) {

			 $out = array();

			 if( !current_user_can('get_resources')) {
				echo json_encode($this->get_object(true, __('Nie masz uprawnień aby pobrać zasoby z bazy.', 'kg')));
				return;
			 }
			 
			 $resource = KG_get_resource_object($id)->get_serialized_fields_for(get_current_user_id());

			 $out = $this->get_object(false, __('Poprawnie pobrano zasoby z bazy.', 'kg'), array(
		     		'resource' =>  $resource
		     )); 

			 echo json_encode($out);
			 die;
		}

		public function __construct(){
       	 	add_action('slim_mapping', array(&$this, 'slim') );            
    	}

   		public function slim($slim){
	        $context = $this;
	        $slim->post('/slim/api/resources/', function()use($context){
	            $context->show_posts();      
	        });

	        $slim->post('/slim/api/resource/:id',function($id)use($context){
				if(empty($id)) {
					echo json_encode($context->get_object(true, __( 'Nie podano id zasobu.', 'kg')));
				} else {
					$context->show_post($id);
				}      			
			});
  		}

	}
	