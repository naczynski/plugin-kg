<?php

	function KG_link_filter($message) {
		 return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $message);
	}
	add_filter('kg_message_content', 'KG_link_filter', 1, 1);

	function KG_add_html_new_lines($message) {
		return nl2br($message);
	}
	add_filter('kg_message_content', 'KG_add_html_new_lines', 2, 1);

	function KG_remove_slashes($message) {
		return stripslashes($message);
	}
	add_filter('kg_message_content', 'KG_remove_slashes', 3, 1);