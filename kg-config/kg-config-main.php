<?php


  date_default_timezone_set('Europe/Warsaw');

  define( 'ACF_LITE', true );

	KG_Config::setPublic('max_characters_title', 55) ;
	KG_Config::setPublic('max_characters_short_desc', 290) ;

	/* USERS
	   ========================================================================== */
	
	KG_Config::setPublic('questus_user_id' , 19) ;
	KG_Config::setPublic('koda_user_id' , 1) ;

	KG_Config::setPublic('default_password' , 'knowledgegarden') ;


	/* PDF
   ========================================================================== */

   KG_Config::setPublic('pdf_faq' , get_permalink( KG_Config::getPublic('faq_page_id') ));
   KG_Config::setPublic('pdf_how_to' , '/howto.pdf');


   /* PAGINATION
      ========================================================================== */
   
   KG_Config::setPublic('users_per_page', 10);
   KG_Config::setPublic('alerts_per_page', 10);
   KG_Config::setPublic('activities_per_page', 25);
   KG_Config::setPublic('quizes_results_per_page', 25);
   KG_Config::setPublic('tasks_responces_per_page', 25);
   KG_Config::setPublic('my_tasks_per_page', 999);
   KG_Config::setPublic('my_transactions_per_page', 999);

   KG_Config::setPublic('quizes_solves_stats_per_page', 10);

  KG_Config::setPublic('transactions_per_page_cocpit', 10);


   /* SUBSCRIPTIONS
      ========================================================================== */
  
  if( KG_is_production() ) {
      KG_Config::setPublic('subscription_normal_id', 816); 
      KG_Config::setPublic('subscription_premium_id', 817); 
  } else {
      KG_Config::setPublic('subscription_normal_id', 759); 
      KG_Config::setPublic('subscription_premium_id', 760); 
  }

   /* TAX
    ========================================================================== */
    
    KG_Config::setPublic('vat_tax', 0.23);  

    /* QUESTUS COMPANY DATA
    ========================================================================== */

    KG_Config::setPublic('questus_company_name', 'questus Robert Kozielski'); 
    KG_Config::setPublic('questus_company_address', '91-811 Łódź, ul. Organizacji WIN 83/7'); 
    KG_Config::setPublic('questus_company_nip', '728-156-15-72');
    KG_Config::setPublic('questus_company_regon', '473222910');
    KG_Config::setPublic('questus_company_bank_account', 'mBank- 24 1140 2017 0000 4302 0342 8828');  

    /* STATS
    ========================================================================== */

    KG_Config::setPublic('show_stats_from_year', 2015);

     /* TERMS
    ========================================================================== */

    KG_Config::setPublic('terms_pdf_link', wp_upload_dir()['baseurl'] . '/public/regulamin.pdf');

