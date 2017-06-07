<?php

	if( KG_is_production() ) {
		KG_Config::setProtected('payu_merchant','145227');
		KG_Config::setProtected('payu_setenvironment','secure');
		KG_Config::setProtected('payu_signature','13a980d4f851f3d9a1cfc792fb1f5e50');	
	} else {
		KG_Config::setProtected('payu_merchant','145227');
		KG_Config::setProtected('payu_setenvironment','secure');
		KG_Config::setProtected('payu_signature','13a980d4f851f3d9a1cfc792fb1f5e50');	
	}

	OpenPayU_Configuration::setEnvironment('secure');
    OpenPayU_Configuration::setMerchantPosId( KG_Config::getProtected('payu_merchant') ); 
    OpenPayU_Configuration::setSignatureKey( KG_Config::getProtected('payu_signature') ); 

    