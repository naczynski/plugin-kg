<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

// prevent sending default wordpress emails
function wp_mail($to, $subject, $message, $headers, $attachments){
	return false;
}

class KG_Mails_Loader extends KG_Component {


	public $name = 'E-mails';
	public $dir = 'kg-mails';
	public $des = '';

	private $includes_others = array(

		'kg-mails-filters',

		'abstract/kg-mail', 

		//api
		'api/kg-api-mail'

	);

	private $email_types = array(

		// admins
		'contact-front' => 'mails-admin',
		// 'add-user' => 'mails-admin',

		// users
		'email-activation' => 'mails-user/account',
		'change-email'  => 'mails-user/account',
		'change-password-front' =>'mails-user/account',
		'disable-networking' => 'mails-user/account' ,
		'enable-networking' => 'mails-user/account' ,
		'recover-password' => 'mails-user/account' ,
		'set-type-cim' => 'mails-user/account' ,
		'set-type-coach' => 'mails-user/account' ,
		'set-type-default' => 'mails-user/account' ,
		'set-type-vip' => 'mails-user/account' ,
		'user-disable-cocpit' => 'mails-user/account' ,
		'user-disable-front' => 'mails-user/account' ,
		'user-enable' => 'mails-user/account',
		
		// presents
		'get-present-multi' => 'mails-user/present',
		'get-present-single' => 'mails-user/present',

		// subscriptions
		'apply-subscription' => 'mails-user/subscription',

		// transactions
		'new-transaction' => 'mails-user/transactions',
		'cancel-transaction' => 'mails-user/transactions',
		'complete-transaction' => 'mails-user/transactions',

		// messages
		'new-message' => 'mails-user/messages',

		// tasks
		'choose-award' => 'mails-user/tasks',
		'new-response' => 'mails-user/tasks'

	);

	private function get_emails_includes() {

		$emails_includes = array();

		foreach ($this->email_types as $type => $for) {		
			$emails_includes[] = $for . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . 'kg-mail-' . $type;
		}

		return $emails_includes;
	
	}

	private function get_includes() {
		return array_merge($this->includes_others, $this->get_emails_includes());
	}

	protected $includes;

	public function mailtrap($phpmailer) {

		  $phpmailer->isSMTP();
		  $phpmailer->Host = 'mailtrap.io';
		  $phpmailer->SMTPAuth = true;
		  $phpmailer->Port = 2525;
		  $phpmailer->Username = '333641fb1f6caf4fb';
		  $phpmailer->Password = '775b5943eacb8e';

	}

	public function development($phpmailer) {

		  $phpmailer->isSMTP();
		  $phpmailer->Host = 'mail.knowledgegarden.pl';
		  $phpmailer->SMTPAuth = true;
		  $phpmailer->Port = 587;
		  // $phpmailer->SMTPSecure = 'ssl';

		  $phpmailer->Username = 'no-reply@knowledgegarden.pl';
		  $phpmailer->Password = ':W0CyU%eXflV';

	}

	public function init_hooks() {

		$this->includes = $this->get_includes();

		$this->start_with_create_instances();

		if(KG_is_local()) {
			add_action('phpmailer_init', array($this, 'mailtrap') );
		} else {
			add_action('phpmailer_init', array($this, 'development') );
		}
	}

	public function init() {
		
	}
	
}
