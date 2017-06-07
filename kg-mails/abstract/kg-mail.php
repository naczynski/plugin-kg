<?php

	/**
	*  Sending emails
	*/
	abstract class KG_Mail {

		private $dir;

		private $default_args;
		private $footer_template;

		private $is_show_button;
		private $button_label;
		private $button_link;

		private function is_show_action_button($label, $url){
			return $this->is_show_button || ( !empty($label) && !empty($url) ); 
		}

		protected function get_action_button_template($label='', $url=''){
			if ( !$this->is_show_action_button($label, $url) ) return '';
			
			return str_replace(
				array(
					'{{button_label}}',
					'{{button_link}}'
				),
				array(
					 $this->button_label,
					 $this->button_link
				),
				'<tr>
					<td cellspacing="20" valign="top" class="footerContent email-button-rwd" style="-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;color: #808080;font-family: Helvetica;font-size: 10px;line-height: 150%;padding-right: 0px;padding-left: 20px;text-align: left;" mc:edit="footer_content02">
					 	<center> 
						 	
						 <!--[if mso]>
							  <v:roundrect xmlns:v="urn:schemas-mxwicrosoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{button_link}}" style="height:40px;v-text-anchor:middle;width:200px;" arcsize="5%" stroke="f" fillcolor="#18a69a">
							    <w:anchorlock/>
							    <center style="color:#ffffff;font-family:sans-serif;font-size:12px;font-weight:normal;">
							      {{button_label}}
							    </center>
							  </v:roundrect>
						  <![endif]-->
					 

							<![if !mso]>
							  <table cellspacing="0" cellpadding="0"> <tr> 
								  <td align="center" bgcolor="#18a69a" style="padding-left: 38px;padding-right: 38px;-webkit-border-radius: 1px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">
								    <a href="{{button_link}}" style="font-size:12px; font-weight: normal; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								    <span style="color: #ffffff;">
								      {{button_label}}
								    </span>
								    </a>
								  </td> 
								  </tr> 
							    </table> 
							<![endif]>

						</center> 
					</td> 
				</tr>'
			);
		}

		private function set_default_args() {
			$this->default_args = array(
				'action_button' => $this->get_action_button_template(),
				'admin_email' => KG_Config::getPublic('admin_email')[0],
				'footer' => $this->get_footer(),
				'contact_info_plain' => "W razie pytań czy wątpliwości pamiętaj, że zawsze możesz się z nami skontaktować pisząc mail na: ". KG_Config::getPublic('admin_email')[0] . "\n",
				'sender' => 'Zespół Knowledge Garden',
				'footer_row_01' => 'questus | ul. Organizacji WiN 83/7, 91-811 Łódź | tel. (42) 662 00 07 |  Copyrights (c) questus 2015',
				'footer_row_02' => 'Wszelkie prawa zastrzeżone | Otrzymujesz tę wiadomość, gdyż jesteś użytkownikiem serwisu Knowledge Garden.',
				'domain' => home_url(),
				'login_url' => get_permalink( KG_Config::getPublic('login_page_id') )
			);
		}


		public function get_footer() {
			return  file_get_contents(plugin_dir_path(__DIR__) . 'templates' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR .  'footer-html.php');
		}

		protected function show_login_button(){
			$this->is_show_button = true;
			$this->button_label = __( 'Zobacz', 'kg');
			$this->button_link = get_permalink( KG_Config::getPublic('login_page_id'));
		}

		protected function not_show_login_button(){
			$this->is_show_button = false;
		}

		protected function show_button($label, $url){
			$this->is_show_button = true;
			$this->button_label = $label;
			$this->button_link = $url;
		}

		private function parse_template($template, $args) {

			if( empty($this->default_args) ) $this->set_default_args();

			// merge with default args
			$args = wp_parse_args($args, $this->default_args);
			$array_keys = array_keys($args);

			foreach($array_keys as $key => $value){
				$array_keys[$key] ='{{' . $value . '}}';
			}
			$array_values = array_values($args);
			
			$parsed_with_footer_vars = str_replace($array_keys, $array_values, $template);
			$parsed_without_footer_vars = str_replace($array_keys, $array_values, $parsed_with_footer_vars); 
			return $parsed_without_footer_vars;

		}

		/*
		Get main email template
		 */
		protected function get_main_template($content, $signature, $contact_footer = true) {
			$not_formatted = file_get_contents(plugin_dir_path(__DIR__) . 'templates' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR .  'template.html');

			if(!$not_formatted) return false; // cant read file

			$args = array(
				'content' => $content,
				'sender' => $signature,
			);

			if( !$contact_footer ) $args['contact_info'] = ''; //if dont show contact footer overide default tag 

			return $this->parse_template($not_formatted, $args);

		}

		private function get_template($name, $args = array(), $signature, $html = true) {
			$content = file_get_contents( $this->dir. DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $name . '.txt');
			$content = $this->parse_template($content, $args);
			return $html ? $this->get_main_template($content, $signature) : $content;
		}

		protected function get_template_html($args = array(), $signature = "Zespoł Knowledge Garden") {
			return $this->get_template('html', $args, $signature, true);
		}

		protected function get_template_html_from_string($string, $signature = "Zespoł Knowledge Garden", $contact_footer = true) {
			return $this->get_main_template($string, $signature, $contact_footer);
		}

		protected function get_template_plain($args = array(), $signature = "Zespoł Knowledge Garden") {
			return $this->get_template('plain', $args, $signature, false);
		}

		private $defaults = array(
			'to' => 'test@test.pl',
			'from_name' => '',
			'from_email' => '',
			'reply_name' => '',
			'reply_email' => '',
			'attachments' => array(),
			'message_plain' => '',
			'message_html' => '',
			'subject' => ''
		);

		public function send($data) {

			global $phpmailer;

			$data = wp_parse_args($data, $this->defaults);

			if(is_email($data['to'])){

				//send to admin
				$to_email = $data['to'];
				$to_label = 'Administrator';

			} else {

				// user id (send to user)
				$kg_user = KG_Get::get('KG_User', $data['to']);
				$user_id = $data['to'];
				$to_email = $kg_user->get_email();
				$to_label = $kg_user->get_name_and_surname();

			}

			$boundary = uniqid('np');

			$from_name = ( !empty($data['from_name']) ) ? $data['from_name'] : __( 'Zespół Knowledge Garden', 'kg' );
			$from_email = ( !empty($data['from_email']) ) ? $data['from_email'] :  KG_Config::getPublic('send_email_from');

			$reply_name = ( !empty($data['reply_name']) ) ? $data['reply_name'] : $data['from_name'];
			$reply_email = ( !empty($data['reply_email']) ) ? $data['reply_email'] : KG_Config::getPublic('admin_email')[0];

			// (Re)create it, if it's gone missing
			if ( !is_object( $phpmailer ) || !is_a( $phpmailer, 'PHPMailer' ) ) {
				require_once ABSPATH . WPINC . '/class-phpmailer.php';
				require_once ABSPATH . WPINC . '/class-smtp.php';
				$phpmailer = new PHPMailer( true );
			}
			
			// Empty out the values that may be set
			$phpmailer->ClearAllRecipients();
			$phpmailer->ClearAttachments();
			$phpmailer->ClearCustomHeaders();
			$phpmailer->ClearReplyTos();

			$phpmailer->CharSet = 'UTF-8';

			$phpmailer->Subject = $data['subject'];
				
			$phpmailer->From = $from_email;
			$phpmailer->FromName = $from_name;

			$phpmailer->addReplyTo( $reply_email, $reply_name);
			$phpmailer->isHTML(true);  

			// attachments
			
			foreach ((array) $data['attachments'] as $file) {
				$phpmailer->addAttachment($file);
			}

			//content

			$phpmailer->Body =  $data['message_html'];
			$phpmailer->AltBody = $data['message_plain'];              

			//to
			$phpmailer->addAddress($to_email, $to_label); 

			do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );

			// Send!
			try {
				return $phpmailer->Send();
			} catch ( phpmailerException $e ) {
				
				return false;
			}
		}

		/**
		 * Send email to all admins
		 */
		public function send_admin($data) {
			foreach ( KG_Config::getPublic('admin_email') as $email) {
				$ret = $this->send(array_merge($data, array(
					'to' => $email
				)));
				if (!$ret) return false; // if cant send
			}

			return true; // everyting ok
		}

		public function __construct($dir) {
			$this->dir = $dir;
			$this->show_login_button();
		}

	}