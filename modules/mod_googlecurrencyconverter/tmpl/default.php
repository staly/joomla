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

$moduleclass_sfx = $params->get('moduleclass_sfx');

#$border = 0;
#$scrolling = 'auto';
#$frameborder = 0;
#$url = "http://finance.google.com/finance/converter?a=1&from=$currency_from&to=$currency_to";
#$height2 = '';
#if ($height!='') $height2 = " height=\"$height\"";

print "<div id=\"googlecurrency_container{$mod_id}\">";
require $lib;
print "</div>";

print "<script type=\"text/javascript\">googlecurrency_prepareForm('$mod_id');</script>";

#$data = 'a='.urlencode($default_location)."&process=1&mod_id=$mod_id";
#print "<script type=\"text/javascript\">gw_sendData('$mod_id', '$data');</script>";


?>
