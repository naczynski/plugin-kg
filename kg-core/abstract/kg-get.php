<?php


	/**
	 * Singleton pattern
	 * Get instance of class
	 */
	class KG_Get {


		private static $cache = array();
	    
		/**
		 * Add to cache
		 * @param array $params      
		 * @param string $object_name object name
		 * @return instance of object
		 */
	    private static function add_to_cache($object_name, $params) {

	    	$instance = self::create_instance($object_name, $params);

	    	self::$cache[] = array(
	    		'name' => $object_name,
	    		'params' => $params,
	    		'instance' => $instance
	    	);

	    	return $instance;

	    }


	    private static function is_in_cache($object_name, $params) {

	    	$ret = false;

	    	foreach (self::$cache as $entry) {
	    		
	    		if( $entry['params'] ===  $params && $entry['name'] ==  $object_name) {

	    			return $entry['instance'];

	    		}	

	    	}

	    	return $ret;

	    }

	    private static function create_instance($object_name, $params) {

	    	$reflect = new ReflectionClass($object_name);

	    	return $reflect->newInstanceArgs($params);

	    }

	    private static function get_instance($object_name, $params) {

	    	$instance = self::is_in_cache($object_name, $params);

	    	return ($instance) ? $instance : self::add_to_cache($object_name, $params);
	   
	    }

	    /**
	     * Parse args passed to get method
	     * @param  array $args all args
	     * @return array data
	     */
	    private static function parse_args($args) {

			if( empty($args[0]) ) return false;

			$object_name = $args[0];

			array_shift($args);

			$params = !empty($args) ? $args : array(); // without params

	    	return array(
	    		'object_name' => $object_name,
	    		'params' => $params
	    	);

	    }

	    /**
	     * get instance
	     * @return [type] [description]
	     */
		public static function get(){
			
			$data = self::parse_args( func_get_args() );

			return self::get_instance($data['object_name'], $data['params']);
	      
		}

	}
