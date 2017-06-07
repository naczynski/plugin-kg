<?php

	function KG_add_many_users($how_many){
		for ($i=0; $i < $how_many ; $i++) { 
			KG_Get::get('KG_User_Generator')->add();
			error_log($i . '/' . $how_many);
		}
	}