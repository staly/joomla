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

function select_currency_pulldownmenu($options, $var, $value, $postfix='', $prefix='') {
	$str = "<select name=\"$var\" id=\"$var\">";
	$str = "<select name=\"$var\" id=\"$var\" class=\"$var\">";
	foreach($options as $k=>$v) {
		$selected = '';
		if ($k==$value) $selected = ' selected';
		$str .= "<option value=\"$k\"$selected>$v</option>";
	}
	$str .= "</select>";
	print $prefix.$str.$postfix;
}

class GoogleCurrencyConverter_base {

	var $html = '';

	#function __construct() {
	#	$this->html = "";
	#}

	function process() {
		$data = $this->html;
		$a = $_GET['a'];
		$from = $_GET['from'];
		$to = $_GET['to'];

		$ok = 0;
		if (preg_match('%<td\s+.*?id="currency_converter_result"\s+.*?>(.*?)</td>%s', $data, $matches)) {
			$data = $matches[1];
			$data = str_replace('&nbsp;', ' ', $data);
		}

		$regexp = "%([\d|.]+)\s+$from\s+=\s+<span\sclass=(.*)>([\d|.]+)\s+$to\s*</span>%s";
		if (preg_match($regexp, $data, $matches)) {
			$data = $matches[3];
			$this->v = $matches[1];
			$ok = 1;
		}

		if (!$ok) $data = '';

		return $data;
	}
}

class GoogleCurrencyConverter extends GoogleCurrencyConverter_base {
	var $binary = 0;
	#var $ch;
	#var $url;

	function get_page($url) {
		if ($url!='') {
			$ch = curl_init ();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, $this->binary);
			$this->html = curl_exec($ch);
			curl_close($ch);
		}
	}
}

class GoogleCurrencyConverter2 extends GoogleCurrencyConverter_base {

	function get_page($url) {
		if ($url!='') {
			$this->html = file_get_contents($url);
		}
	}
}

class GoogleCurrencyConverter3 extends GoogleCurrencyConverter_base {

	function get_page($url) {
		if ($url!='') {
			$fp = fopen($url, "r");
			$this->html = '';
			while (!feof($fp)) {
				$this->html .= fread($fp, 4096);
			}
			fclose($fp);
		}
	}
}

function setup_currencies() {
	$currencies = array(
		"AED" => 'United Arab Emirates Dirham (AED)',
		"ANG" => 'Netherlands Antillean Guilder (ANG)',
		"ARS" => 'Argentine Peso (ARS)',
		"AUD" => 'Australian Dollar (AUD)',
		"BDT" => 'Bangladeshi Taka (BDT)',
		"BGN" => 'Bulgarian Lev (BGN)',
		"BHD" => 'Bahraini Dinar (BHD)',
		"BND" => 'Brunei Dollar (BND)',
		"BOB" => 'Bolivian Boliviano (BOB)',
		"BRL" => 'Brazilian Real (BRL)',
		"BWP" => 'Botswanan Pula (BWP)',
		"CAD" => 'Canadian Dollar (CAD)',
		"CHF" => 'Swiss Franc (CHF)',
		"CLP" => 'Chilean Peso (CLP)',
		"CNY" => 'Chinese Yuan (CNY)',
		"COP" => 'Colombian Peso (COP)',
		"CRC" => 'Costa Rican Colon (CRC)',
		"CZK" => 'Czech Republic Koruna (CZK)',
		"DKK" => 'Danish Krone (DKK)',
		"DOP" => 'Dominican Peso (DOP)',
		"DZD" => 'Algerian Dinar (DZD)',
		"EEK" => 'Estonian Kroon (EEK)',
		"EGP" => 'Egyptian Pound (EGP)',
		"EUR" => 'Euro (EUR)',
		"FJD" => 'Fijian Dollar (FJD)',
		"GBP" => 'British Pound Sterling (GBP)',
		"HKD" => 'Hong Kong Dollar (HKD)',
		"HNL" => 'Honduran Lempira (HNL)',
		"HRK" => 'Croatian Kuna (HRK)',
		"HUF" => 'Hungarian Forint (HUF)',
		"IDR" => 'Indonesian Rupiah (IDR)',
		"ILS" => 'Israeli New Sheqel (ILS)',
		"INR" => 'Indian Rupee (INR)',
		"JMD" => 'Jamaican Dollar (JMD)',
		"JOD" => 'Jordanian Dinar (JOD)',
		"JPY" => 'Japanese Yen (JPY)',
		"KES" => 'Kenyan Shilling (KES)',
		"KRW" => 'South Korean Won (KRW)',
		"KWD" => 'Kuwaiti Dinar (KWD)',
		"KYD" => 'Cayman Islands Dollar (KYD)',
		"KZT" => 'Kazakhstani Tenge (KZT)',
		"LBP" => 'Lebanese Pound (LBP)',
		"LKR" => 'Sri Lankan Rupee (LKR)',
		"LTL" => 'Lithuanian Litas (LTL)',
		"LVL" => 'Latvian Lats (LVL)',
		"MAD" => 'Moroccan Dirham (MAD)',
		"MDL" => 'Moldovan Leu (MDL)',
		"MKD" => 'Macedonian Denar (MKD)',
		"MUR" => 'Mauritian Rupee (MUR)',
		"MVR" => 'Maldivian Rufiyaa (MVR)',
		"MXN" => 'Mexican Peso (MXN)',
		"MYR" => 'Malaysian Ringgit (MYR)',
		"NAD" => 'Namibian Dollar (NAD)',
		"NGN" => 'Nigerian Naira (NGN)',
		"NIO" => 'Nicaraguan Cordoba (NIO)',
		"NOK" => 'Norwegian Krone (NOK)',
		"NPR" => 'Nepalese Rupee (NPR)',
		"NZD" => 'New Zealand Dollar (NZD)',
		"OMR" => 'Omani Rial (OMR)',
		"PEN" => 'Peruvian Nuevo Sol (PEN)',
		"PGK" => 'Papua New Guinean Kina (PGK)',
		"PHP" => 'Philippine Peso (PHP)',
		"PKR" => 'Pakistani Rupee (PKR)',
		"PLN" => 'Polish Zloty (PLN)',
		"PYG" => 'Paraguayan Guarani (PYG)',
		"QAR" => 'Qatari Rial (QAR)',
		"RON" => 'Romanian Leu (RON)',
		"RSD" => 'Serbian Dinar (RSD)',
		"RUB" => 'Russian Ruble (RUB)',
		"SAR" => 'Saudi Riyal (SAR)',
		"SCR" => 'Seychellois Rupee (SCR)',
		"SEK" => 'Swedish Krona (SEK)',
		"SGD" => 'Singapore Dollar (SGD)',
		"SKK" => 'Slovak Koruna (SKK)',
		"SLL" => 'Sierra Leonean Leone (SLL)',
		"SVC" => 'Salvadoran Colon (SVC)',
		"THB" => 'Thai Baht (THB)',
		"TND" => 'Tunisian Dinar (TND)',
		"TRY" => 'Turkish Lira (TRY)',
		"TTD" => 'Trinidad and Tobago Dollar (TTD)',
		"TWD" => 'New Taiwan Dollar (TWD)',
		"TZS" => 'Tanzanian Shilling (TZS)',
		"UAH" => 'Ukrainian Hryvnia (UAH)',
		"UGX" => 'Ugandan Shilling (UGX)',
		"USD" => 'US Dollar (USD)',
		"UYU" => 'Uruguayan Peso (UYU)',
		"UZS" => 'Uzbekistan Som (UZS)',
		"VEF" => 'Venezuelan Bolivar (VEF)',
		"VND" => 'Vietnamese Dong (VND)',
		"XOF" => 'CFA Franc BCEAO (XOF)',
		"YER" => 'Yemeni Rial (YER)',
		"ZAR" => 'South African Rand (ZAR)',
		"ZMK" => 'Zambian Kwacha (ZMK)',
	);

	return $currencies;
}
?>
