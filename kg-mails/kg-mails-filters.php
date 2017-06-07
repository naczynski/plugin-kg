<?php

	function KG_filter_email_message($message) {
		if(strlen($message) == 1) return '';
		return '<table border="0" cellpadding="10" cellspacing="0" width="100%" id="templateFooter" style="color: #5a5b5d;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;background-color: #fff;border-collapse: collapse !important;margin-top: 0px;margin-bottom: 15px;font-size: 12px"> <tr> <td>' . $message . '</td> </tr> </table>';
	}

	add_filter( 'kg_message_email_html' ,'KG_filter_email_message', 1, 1);