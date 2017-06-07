<?php

	defined( 'ABSPATH' ) || exit;

	abstract class KG_Component {

		public $name = '';
		public $dir = '';
		public $desc = '';
		protected $includes = array();

		protected function get_class_name($include_name) {

			$url_elements = explode('/' , $include_name);
			$file_name = end($url_elements);
			$class_name = explode('-', $file_name);

			array_walk($class_name, function(&$item){

				if($item == 'kg') {
					$item = 'KG';
					return;
				}

				$item = ucfirst($item);

			});

			$class_name = implode('_', $class_name);
			return $class_name;

		}

		private function includes($init) {

			if ( !empty( $this->includes ) ) {

				foreach ( (array) $this->includes as $file ) {
					$path =  plugin_dir_path(__DIR__) . '../' . $this->dir . '/' . $file . '.php';

						include $path;
						$class_name = $this->get_class_name($file);

						if($init && class_exists($class_name)) {

							$reflection_name = new ReflectionClass($class_name);

							if(!$reflection_name->isAbstract()) {
								KG_Get::get($class_name); // create instance of object
							}

						}

				}

			}

		}

		protected function start_with_create_instances() {
			$this->includes(true);
		}

		protected function start_without_create_instances() {
			$this->includes(false);
		}

		abstract function init_hooks();
		abstract function init();

	}

