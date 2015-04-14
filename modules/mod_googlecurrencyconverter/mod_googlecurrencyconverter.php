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

require_once (dirname(__FILE__).DS.'helper.php');
$lib = dirname(__FILE__).DS.'mod_googlecurrencyconverter_lib.php';
$mod_id = get_googlecurrency_mod_id();

$mosConfig_live_site = JURI::base();
$lib_base = $mosConfig_live_site."modules/mod_googlecurrencyconverter";
$lib2 = "$lib_base/mod_googlecurrencyconverter_lib.php";
$progress_gif = "$lib_base/mod_googlecurrencyconverter_progress.gif";
$js_url = "$lib_base/mod_googlecurrencyconverter_ajax.js";

$a = modGoogleCurrencyConverterHelper::getContent($params);

#$width = $a->width;
#$height = $a->height;
#$scrolling = $a->scrolling;
#$frameborder = $a->frameborder;
$currency_from = $a->currency_from;
$currency_to = $a->currency_to;
$label_convert = $a->label_convert;
$label_into = $a->label_into;
$submit_button_label = $a->submit_button_label;
$use_css = $a->use_css;
$style = $a->style;
$use_curl = $a->use_curl;

print "<script type=\"text/javascript\">
var lib_url{$mod_id}=\"$lib2\";
var progress_gif{$mod_id}=\"$progress_gif\";
var submit_button_label{$mod_id}=\"$submit_button_label\";
var label_convert{$mod_id}=\"$label_convert\";
var label_into{$mod_id}=\"$label_into\";
var style{$mod_id}=\"$style\";
var googlecurrency_use_curl{$mod_id}=\"$use_curl\";
</script>";

print "<script type=\"text/javascript\" src=\"$js_url\"></script>";

require(JModuleHelper::getLayoutPath('mod_googlecurrencyconverter'));
?>