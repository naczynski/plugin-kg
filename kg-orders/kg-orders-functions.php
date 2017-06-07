<?php

	function KG_get_order_object($data){

		if (empty($data['type']) || empty($data['user_id'])) return; 

		switch( (int) $data['type']){
			case 1: return KG_Get::get('KG_Single_Order_Item_Resource', $data); break;
			case 2: 
				$data = array_merge($data, array(
					'relation_id' => 0,
					'date' => '',
					'action_id' => 0
				));
				return KG_Get::get('KG_Single_Order_Item_Present', $data); 
				break;
			case 3: return KG_Get::get('KG_Single_Order_Item_Subscription', $data); break;		
		}

	}

	function KG_get_order_object_from_json($json){
		return KG_get_order_object( json_decode($json, true) ); 
	}

	function KG_get_order_object_by_payu_id($payu_id){
		global $wpdb;
		$table = KG_Config::getPublic('table_transactions');
		$data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT id FROM {$table} WHERE payu_id = %s",
				$payu_id
			) , ARRAY_A
		);
		return !empty($data['id']) ? KG_Get::get('KG_Transaction', (int) $data['id'] ) : false;
	}

	function KG_Transaction_Factory($data, $invoice_receiver_data = array()){

		if($data['total_brutto'] == 0){
			return new WP_Error('no_basket_object', __( 'Nie można stworzyć transakcji na kwotę 0 zł.', 'kg' ) );
		}	
		global $wpdb;
		$data = array_merge($data, array(
			'invoice_data' => json_encode($invoice_receiver_data, JSON_UNESCAPED_UNICODE)
		));

		$insert = $wpdb->insert(
			KG_Config::getPublic('table_transactions'),
			$data,
			array(
				'%s',
				'%d',
				'%f',
				'%f',
				'%s',
				'%d',
				'%d',
				'%d',
				'%f',
				'%f',
				'%f',
				'%s',
				'%s'
			)
		);

		if($insert){

			$transaction_id = $wpdb->insert_id;

		    KG_Get::get('KG_Basket')->clear();
		    $kg_transaction = KG_Get::get('KG_Transaction', array_merge($data, array('id'=> $transaction_id) )) ;
		    $kg_transaction->generate_invoice(); 
		    // do_action('kg_create_transaction',  $kg_transaction);
			// kg_payu_transaction_id
			return $kg_transaction;	
		}

		return $transaction_id;
	}
