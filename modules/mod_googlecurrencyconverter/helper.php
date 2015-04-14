<?php
/**
* GoogleCurrencyConverter module
* This module allows you to add the Google Currency Converter in a module position.
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* v1.5 August 21, 2008
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modGoogleCurrencyConverterHelper {
	
	static function getContent(&$params) {
		$a = new stdClass;
		#$a->width = strval( $params->get( 'width', '100%') );
		#$a->height = strval( $params->get( 'height', '') );
		#$a->scrolling = strval( strtolower($params->get( 'scrolling', 'auto')) );
		#$a->frameborder = strval( $params->get( 'frameborder', '0') );

		$a->currency_from = strval( $params->get( 'currency_from', 'USD') );
		$a->currency_to = strval( $params->get( 'currency_to', 'EUR') );
		$a->label_convert = strval( $params->get( 'label_convert', 'Convert') );
		$a->label_into = strval( $params->get( 'label_into', 'into') );
		$a->submit_button_label = strval( $params->get( 'submit_button_label', 'Convert') );
		$a->use_css = strval( $params->get( 'use_css', '0') );
		$a->style = strval( $params->get( 'style', '1') );

		# added 090831
		$a->use_curl = intval( $params->get( 'use_curl', '1') );

		return $a;
	}
}

function get_googlecurrency_mod_id() {
	static $i=200;
	return ++$i;
}
