<?php

	class KG_User_Generator extends KG_Generator {

		private $faker;

		public function __construct(){
			$this->faker = Faker\Factory::create();
			$this->faker->addProvider(new Faker\Provider\pl_PL\Person($this->faker));
			$this->faker->addProvider(new Faker\Provider\pl_PL\Internet($this->faker));
			$this->faker->addProvider(new Faker\Provider\pl_PL\Company($this->faker));
		}

		private function get_name(){
			return $this->faker->firstName;
		}

		private function get_surname(){
			return $this->faker->lastName;
		}

		private function get_email(){
			return $this->faker->email;	
		}

		private function get_nick_name($name, $surname){
			return $name . ' ' . $surname ;
		}

		private function get_pass(){
			return 'test';
		}

		private function get_job(){
			return $this->faker->bs;
		}

		private function get_trade(){
			return $this->faker->company;
		} 

		private function get_fields($name, $surname){
			return array(
				'kg_field_name' => $name,
				'kg_field_surname' => $surname,
				'kg_field_job' => $this->get_job(),
				'kg_field_trade' => $this->get_trade()
			);
		}

		public function add(){
			
			$name = $this->get_name();
			$surname = $this->get_surname();

			$data = array(
				'user_email' => $this->get_email(),
			    'user_login'  => $this->get_nick_name($name,$surname),
			    'user_pass' =>  $this->get_pass(),
				'fields' => $this->get_fields($name, $surname)
			);

			$user_id = KG_Get::get('KG_Add_User')->add_user($data);	
			
			$kg_user = KG_Get::get('KG_User', $user_id);
			$this->add_type($kg_user);
			$this->add_networking($kg_user);
			$this->verify_email($kg_user);

		}

		private function add_type($kg_user){
			$role = $this->faker->randomElements(array('coach','vip','cim', 'default'), 1);
			$kg_user->get_wp_user_object()->set_role($role[0]);
		}

		private function add_networking($kg_user){
			$number =  $this->faker->numberBetween(0, 1000);

			if($number > 300) {
				$kg_user->set_can_networking();
			}
		
		}

		private function verify_email($kg_user){
			$number =  $this->faker->numberBetween(0, 1000);

			if($number > 100) {
				$kg_user->activate_email();
			}
		}

	}