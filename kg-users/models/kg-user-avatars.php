<?php

	/**
	 * Manager user avatar
	 *
	 * In db only filename with ext (no full path to image)
	 */
	class KG_User_Avatars {

		private $upload_dir;


		private function strip_avatar_to_path($url) {
			return str_replace( $this->upload_dir['baseurl'] . '/' . KG_Config::getPublic('dir_avatart') . '/' , '', $url);
		}

		public function get_avatar_dir($file_name = '') {
			return $this->upload_dir['basedir'] . DIRECTORY_SEPARATOR . KG_Config::getPublic('dir_avatart') . DIRECTORY_SEPARATOR . $file_name;
		}

		public function get_avatar_url($file_name = '') {
			return $this->upload_dir['baseurl'] . '/' . KG_Config::getPublic('dir_avatart') . '/' . $file_name;	
		}

		public function get_default_avatar_path() {
			return $this->get_avatar_dir() . KG_Config::getPublic('default_avatar_file_name');
		}

		public function get_default_avatar_url() {
			return $this->get_avatar_url() . KG_Config::getPublic('default_avatar_file_name');
		}

		public function __construct() {
			$this->upload_dir = wp_upload_dir();
		}

	
	}