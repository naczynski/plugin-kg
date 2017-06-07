<?php

	abstract class KG_Ajax {

		/**
		 * Get response object (all ajax, api calls return this object as json)
		 * @param  boolean|WP_Error $error
		 * @param  string $message 
		 * @param  string $type    
		 * @return array          [
		 */
		protected function get_object($error, $message = '', $data = array()) {
			$is_wp_error = is_wp_error($error);
			$obj = array(
				'error' => $is_wp_error ? true : $error,
				'message' =>  $is_wp_error ? $error->get_error_message() : $message
			);
			if($is_wp_error) $obj['code'] = $error->get_error_code();
			return array_merge($obj, $data);
		}

		protected function get_object_json($error, $message = '', $data = array()) {
			return json_encode($this->get_object($error, $message, $data));
		}

		public function __construct($action, $hook, $front = false) {
			add_action('wp_ajax_'.$action, $hook);
		}

	}
