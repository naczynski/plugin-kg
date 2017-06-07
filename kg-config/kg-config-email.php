<?php

	//smtp develop
	
   KG_Config::setPublic('Host' ,'mailtrap.io') ;
   KG_Config::setPublic('SMTPAuth' ,true) ;
   KG_Config::setPublic('Port' , 2525) ;
   KG_Config::setPublic('Username' ,'333641fb1f6caf4fb') ;
   KG_Config::setPublic('Password' ,'775b5943eacb8e') ;

   KG_Config::setPublic('send_email_from', 'no-reply@knowledgegarden.pl');   

   KG_Config::setPublic('admin_email' , array(
   	  'kg@questus.pl',
   	  'michal@kodafive.com'
   ));
