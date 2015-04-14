<?php
/**
* GoogleCurrencyConverter module
* This module allows you to add the Google Currency Converter in a module position.
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* v1.5 August 21, 2008
* v1.5.2 August 28, 2008. Bug Fix. When you set the default "currency from" and "currency to", in the parameters page, these options will now be correctly displayed in the frontend. Thanks to Pablo for pointing this out.
* v1.5.3 September 3, 2008. Support for non-javascript browser
* v1.5.4 May 6, 2009. check for undefined variables
Notice: Undefined index: process on line 12
Notice: Undefined index: a on line 21
Notice: Undefined index: process on line 22
Notice: Undefined index: use_css on line 44
* v1.5.6 August 31, 2009. read google data by CURL, file_get_contents() or fread()
* v1.5.7 May 16, 2010. allow multiple google currency converters on same page
* v1.7.8 Dec 5, 2011 support for Joomla 1.6 and 1.7!
* v1.7.9 Mar 26, 2012 25,000 = 25000. Also, do a trim for user input.
*/

require_once 'mod_googlecurrencyconverter_libclass.php';

if (isset($_GET['mod_id'])) $mod_id = $_GET['mod_id'];
if ($mod_id == '') $mod_id = '101';

$data = '';
if (isset($_GET['process'])) {
	#$app = new GoogleCurrencyConverter();

	if (!isset($use_curl)) $use_curl = 1;
	if (isset($_GET['use_curl'])) $use_curl = $_GET['use_curl'];
	if (!preg_match('/(1|2|3)/', $use_curl)) $use_curl = 1;
	if ($use_curl=='') $use_curl = 1;

	if ($use_curl==3) {
		$app = new GoogleCurrencyConverter3();
	} elseif ($use_curl==2) {
		$app = new GoogleCurrencyConverter2();
	} else {
		$app = new GoogleCurrencyConverter();
	}

	$a2 = trim(ltrim($_GET['a']));
	$a2 = str_replace(',', '', $a2);
	$a2 = str_replace(' ', '', $a2);

	#$url = "http://finance.google.com/finance/converter?a={$_GET['a']}&from={$_GET['from']}&to={$_GET['to']}";
	$url = "http://finance.google.com/finance/converter?a=$a2&from={$_GET['from']}&to={$_GET['to']}";
	$app->get_page($url);
	$data = $app->process();
}

$currencies = setup_currencies();

$str_a = '';
if (isset($_GET['a'])) $str_a = $_GET['a'];
if (isset($_GET['process'])) $str_a = $app->v;
if ($str_a=='') $str_a = '1';

$str_from = '';
if (isset($currency_from)) $str_from = $currency_from;
if (isset($_GET['from'])) $str_from = $_GET['from'];
if ($str_from=='') $str_from = 'USD';

$str_to = '';
if (isset($currency_to)) $str_to = $currency_to;
if (isset($_GET['to'])) $str_to = $_GET['to'];
if ($str_to=='') $str_to = 'EUR';

if (isset($_GET['label_convert'])) $label_convert = $_GET['label_convert'];
#if ($label_convert=='') $label_convert = 'Convert';
if (isset($_GET['label_into'])) $label_into = $_GET['label_into'];
#if ($label_into=='') $label_into = 'into';

if (isset($_GET['submit_button_label'])) $submit_button_label = $_GET['submit_button_label'];
if ($submit_button_label=='') $submit_button_label = 'Convert';

if (isset($_GET['style'])) $style = $_GET['style'];
if ($style<1 || $style>3) $style = '1';

if (isset($_GET['use_css']) && $_GET['use_css']==1) {
	$highlight = "class=\"highlight\"";
} else {
	$highlight = "style=\"background-color: rgb(255, 255, 160);\"";
}

# added 090831

global $mosConfig_live_site;
#if (!isset($mosConfig_live_site)) {
if (class_exists('JURI')) {
	$mosConfig_live_site = JURI::base();
	if (substr($mosConfig_live_site, -1, 1)=='/') $mosConfig_live_site = substr($mosConfig_live_site, 0, strlen($mosConfig_live_site) - 1);
}

$z = "<a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/Google-Currency-Converter-AJAX-version.php\" style=\"color:#aaa;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: normal;\">Powered by JoomlaGadgets</a>";
$z1 = "<p align=\"left\" style=\"padding:0 0 0 0;margin:0 0 0 0\">$z</p>";
$z2 = "<p align=\"right\" style=\"padding:0 0 0 0;margin:0 0 0 0\">$z</p>";

$action = $mosConfig_live_site . '/index.php';

#print '<form action="" method="get" id="currencyForm">';
print "<form action=\"$action\" method=\"get\" id=\"googlecurrencyForm{$mod_id}\">";
#print "<form action=\"$action\" method=\"GET\" id=\"googlecurrencyForm{$mod_id}\" onsubmit=\"javascript:googlecurrency_submitform('$mod_id');return false;\">";

print "<div class=\"googlecurrency\">";

if ($style==2) {
	print "<table class=\"table1\" border=0>";
	print "<tr><td class=\"td00\">";
	if ($label_convert!='') print "<span class=\"input_label\">$label_convert&nbsp;</span>";
	print "</td>";
	print "<td align=left class=\"td01\"><input name=\"a\" id=\"googlecurrency_str_a\" class=\"inputbox\" maxlength=\"12\" size=\"5\" autocomplete=\"off\" value=\"$str_a\">&nbsp;</td><td class=\"td02\">";
	select_currency_pulldownmenu($currencies, 'from', $str_from);
	print "</td><td class=\"td03\"></td></tr><tr><td class=\"td10\"></td><td align=right class=\"td11\">";
	if ($label_into!='') print "<span class=\"input_label\">$label_into&nbsp;</span>";
	print "</td><td class=\"td12\">";
	select_currency_pulldownmenu($currencies, 'to', $str_to);
	print "</td><td class=\"td13\"></td></tr><tr><td colspan = 3 class=\"td2\"><table class=\"table2\" width=100% cellpadding=2 padding-top=\"15px\" border=0><tr><td align=left class=\"td20\">";
	if ($data!='') {
		print "<div id=\"currency_converter_result\" align=left style=\"padding-top:4px;padding-bottom:4px\" class=\"result\">$app->v {$_GET['from']} = <b><span $highlight>$data</span> {$_GET['to']}</b></div>";
	} else {
		print "&nbsp;";
	}
	print "</td><td align=right class=\"td21\">";
	print "<input type=\"submit\" value=\"$submit_button_label\" class=\"button\">";
	print "</td></tr></table>";
	print "<td class=\"td23\"><span id=\"googlecurrency_loading{$mod_id}\"></span></td>";
	print "</td></tr>";
	if ($data=='') print "<tr><td colspan=3 align=right>$z2</td><td>&nbsp;</td></tr>";
	print "</table>";

} elseif ($style==3) {
	if ($label_convert!='') print "<span class=\"input_label\">$label_convert&nbsp;</span>";
	print "<input name=\"a\" class=\"inputbox\" maxlength=\"12\" size=\"5\" autocomplete=\"off\" value=\"$str_a\">&nbsp;";
	select_currency_pulldownmenu($currencies, 'from', $str_from);
	if ($label_into!='') print "<span class=\"input_label\">&nbsp;$label_into&nbsp;</span>";
	select_currency_pulldownmenu($currencies, 'to', $str_to);
	print "&nbsp;";
	print "<input type=\"submit\" value=\"$submit_button_label\" class=\"button\">&nbsp;&nbsp;";
	print "<span id=\"googlecurrency_loading{$mod_id}\"></span><br>";
	if ($data=='')  print "<div align=left style=\"padding-top:2px;\">$z1</div>";
	if ($data!='') {
		print "<div id=\"currency_converter_result\" align=left style=\"padding-top:4px;padding-bottom:4px\" class=\"result\">$app->v {$_GET['from']} = <b><span $highlight>$data</span> {$_GET['to']}</b></div>";
	}

} else {
	print "<span class=\"input_label\">$label_convert&nbsp;</span>";
	print "<input name=\"a\" class=\"inputbox\" maxlength=\"12\" size=\"5\" autocomplete=\"off\" value=\"$str_a\"><br>";
	select_currency_pulldownmenu($currencies, 'from', $str_from);
	print '<br>';
	print "<span class=\"input_label\">$label_into </span><br>";

	select_currency_pulldownmenu($currencies, 'to', $str_to);
	print "<br>";
	if ($data!='') {
		print "<div id=\"currency_converter_result\" align=left style=\"padding-top:4px;padding-bottom:4px\" class=\"result\">$app->v {$_GET['from']} = <b><span $highlight>$data</span> {$_GET['to']}</b></div>";
	}

	print "<input type=\"submit\" value=\"$submit_button_label\" class=\"button\">&nbsp;&nbsp;";
	if ($data=='')  print "<div align=left style=\"padding-top:2px;\">$z1</div>";
	print "<span id=\"googlecurrency_loading{$mod_id}\"></span>";
}


print "<input type=\"hidden\" name=\"submit_button_label\" value=\"$submit_button_label\">";

$use_css2 = '';
if (isset($use_css)) $use_css2 = $use_css;
elseif (isset($_GET['use_css'])) $use_css2 = $_GET['use_css'];
print "<input type=\"hidden\" name=\"use_css\" value=\"$use_css2\">";

print "<input type=\"hidden\" name=\"process\" value=\"1\">";

$option = '';
if (isset($_REQUEST['option'])) $option = $_REQUEST['option'];
print "<input type=\"hidden\" name=\"option\" value=\"$option\">";

$task = '';
if (isset($_REQUEST['task'])) $task = $_REQUEST['task'];
print "<input type=\"hidden\" name=\"task\" value=\"$task\">";

$id = '';
if (isset($_REQUEST['id'])) $id = $_REQUEST['id'];
print "<input type=\"hidden\" name=\"id\" value=\"$id\">";

$sectionid = '';
if (isset($_REQUEST['sectionid'])) $sectionid = $_REQUEST['sectionid'];
print "<input type=\"hidden\" name=\"sectionid\" value=\"$sectionid\">";

$catid = '';
if (isset($_REQUEST['catid'])) $catid = $_REQUEST['catid'];
print "<input type=\"hidden\" name=\"catid\" value=\"$catid\">";

$Itemid = '';
if (isset($_REQUEST['Itemid'])) $Itemid = $_REQUEST['Itemid'];
print "<input type=\"hidden\" name=\"Itemid\" value=\"$Itemid\">";
print '</div>';
print '</form>';

?>
