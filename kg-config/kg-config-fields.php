<?php

	define('POLISH_CHARACTERS', 'A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ');

	/* Group Default Information
	   ========================================================================== */
	
	// field name

	KG_Config::setPublic('kg_field_name', array(
		'label' => __( 'Imię', 'kg' ),
		'required' => true,
		'reg_exp' => '/^[' . POLISH_CHARACTERS . ']{1,31}$/', 
		'error_message' => __( 'Wpisane przez Ciebie imię zawiera błąd.', 'kg' )
	));

	// field surname

	KG_Config::setPublic('kg_field_surname', array(
		'label' => __( 'Nazwisko', 'kg' ),
		'required' => true,
		'reg_exp' => '/^[' . POLISH_CHARACTERS . '-]{1,31}$/', 
		'error_message' => __( 'Wpisane przez Ciebie nazwisko zawiera błąd.', 'kg' )
	));

	// user address

	KG_Config::setPublic('kg_user_field_address', array(
		'label' => __( 'Adres', 'kg' ),
		'required' => false,
		'reg_exp' => '/^.{1,50}$/', 
		'error_message' => __( 'Wpisany przez Ciebie adres zawiera błąd.', 'kg' )
	));

	// user post code

	KG_Config::setPublic('kg_user_field_post_code', array(
		'label' => __( 'Kod pocztowy', 'kg' ),
		'required' => false,
		'placeholder' => 'np. 95-200',
		'reg_exp' => '/^\d{2}-\d{3}$/', 
		'error_message' => __( 'To nie jest prawidłowy kod pocztowy. (np. 95-200)', 'kg' )
	));

	// user city
	
	KG_Config::setPublic('kg_user_field_city', array(
		'label' => __( 'Miasto', 'kg' ),
		'required' => false,
		'reg_exp' => '/^.{1,30}$/', 
		'error_message' => __( 'Wpisana przez Ciebie nazwa miejscowości zawiera błąd.', 'kg' )
	));

	//group default

	KG_Config::setPublic('group_fields_invoice_default', array(
		'label' => __( 'Informacje podstawowe', 'kg' ),
		'on_register_page' => true,
		'in_cocpit' => false,
		'on_my_profile_page' => false,
		'fields' => array(
			'kg_field_name',
			'kg_field_surname'
		)
	));

	KG_Config::setPublic('group_fields_default', array(
		'label' => __( 'Informacje podstawowe', 'kg' ),
		'on_register_page' => false,
		'in_cocpit' => true,
		'on_my_profile_page' => true,
		'fields' => array(
			'kg_field_name',
			'kg_field_surname',
			'kg_user_field_address',
			'kg_user_field_post_code',
			'kg_user_field_city'
		)
	));

	/* Group Job Information
	   ========================================================================== */
	
	// field soecialization

	KG_Config::setPublic('kg_field_job', array(
		'label' => __( 'Stanowisko', 'kg' ),
		'required' => false,
		'reg_exp' => '/^[' . POLISH_CHARACTERS . ' ]{1,40}$/', 
		'error_message' => __( 'Wpisane przez Ciebie stanowisko zawiera błąd.', 'kg' )
	));

	// field organisation

	KG_Config::setPublic('kg_field_organization', array(
		'label' => __( 'Organizacja', 'kg' ),
		'required' => false,
		'reg_exp' => '/^[' . POLISH_CHARACTERS . ' &]{1,40}$/', 
		'error_message' => __( 'Wpisana przez Ciebie nazwa organizacji zawiera błąd.', 'kg' )
	));

	// field trade
	
	KG_Config::setPublic('kg_field_trade', array(
		'label' => __( 'Branża', 'kg' ),
		'required' => true,
		'reg_exp' => '/^[' . POLISH_CHARACTERS . ' &]{1,40}$/', 
		'error_message' => __( 'Wpisana przez Ciebie nazwa branży zawiera błąd.', 'kg' )
	));

	//group
	
	KG_Config::setPublic('group_fields_job', array(
		'label' => __( 'Praca', 'kg' ),
		'on_register_page' => true,
		'in_cocpit' => true,
		'on_my_profile_page' => true,
		'fields' => array(
			'kg_field_job',
			'kg_field_organization',
			'kg_field_trade'
		)
	));

	/* Invoices
	   ========================================================================== */
	
	KG_Config::setPublic('kg_field_company_name', array(
		'label' => __( 'Nazwa firmy', 'kg' ),
		'required' => false,
		'reg_exp' => '/^[' . POLISH_CHARACTERS . ' ]{1,100}$/', 
		'error_message' => __( 'Wpisana przez Ciebie nazwa firmy zawiera błąd.', 'kg' )
	));

	KG_Config::setPublic('kg_field_company_address', array(
		'label' => __( 'Adres', 'kg' ),
		'required' => false,
		'reg_exp' => '/^.{1,50}$/', 
		'error_message' => __( 'Wpisany przez Ciebie adres zawiera błąd.', 'kg' )
	));


	KG_Config::setPublic('kg_field_company_post_code', array(
		'label' => __( 'Kod pocztowy', 'kg' ),
		'required' => false,
		'reg_exp' => '/^\d{2}-\d{3}$/', 
		'placeholder' => 'np. 95-200',
		'error_message' => __( 'Wpisany przez Ciebie kod pocztowy zawiera błąd. (prawidłowy format: 95-200)', 'kg' )
	));


	KG_Config::setPublic('kg_field_company_city', array(
		'label' => __( 'Miasto', 'kg' ),
		'required' => false,
		'reg_exp' => '/^.{1,30}$/', 
		'error_message' => __( 'Wpisana przez Ciebie nazwa miasta zawiera błąd.', 'kg' )
	));

	KG_Config::setPublic('kg_field_company_nip', array(
		'label' => __( 'Nip', 'kg' ),
		'required' => false,
		'placeholder' => 'np. 1341235732',
		'reg_exp' => '/^\d{10}$/', 
		'error_message' => __( 'Wpisany przez Ciebie numer NIP jest nieprawidłowy. (poprawny format: 1341235732)', 'kg' )
	));


	KG_Config::setPublic('group_fields_company', array(
		'label' => __( 'Dane firmy', 'kg' ),
		'on_register_page' => false,
		'in_cocpit' => true,
		'on_my_profile_page' => true,
		'fields' => array(
			'kg_field_company_name',
			'kg_field_company_address',
			'kg_field_company_post_code',
			'kg_field_company_city',
			'kg_field_company_nip',
		)
	));

	/* Register Groups
	   ========================================================================== */

	KG_Config::setPublic('fields_groups', array(
		'group_fields_invoice_default',
		'group_fields_default',
		'group_fields_job',
		'group_fields_company'
	));
