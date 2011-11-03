<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function tel_format($str = null)
{
	// If we have not entered a phone number just return empty
	if (empty($str)) {
		return null;
	}					 
	
	// FORMAT
	// International w/ Plus and Prefix
	if (preg_match('/^\+[\d]{1,3}[\s\.]+[\da-z\(\)\.\-]+/i', $str))
	{
		return preg_replace("/\+([\da-z]{1,3})[\s\.]+([\da-z]{3})[\-\)\.\s]?([\da-z]{3})[\-\)\.\s]?([\da-z]*)/i", "+$1 $2.$3.$4", $str);
	}
	// US Domestic 10-Digit
	elseif (preg_match('/^\+?1?[\(]?[2-9]{1}[\d]{2}[\-\)\.\s]?[\da-z]{3}[\-\.\s]?[\da-z]{4}$/i', $str))
	{
		return preg_replace("/\+?1?([\da-z]{3})[\-\)\.\s]?([\da-z]{3})[\-\)\.\s]?([\da-z]{4})/i", "+1 $1.$2.$3", $str);
	}
	else 
	{
		return preg_replace("/[^0-9A-Za-z]/", "", $str);
	}	
}

function tel_dialstring ($str)
{
	$str = tel_convert_vanity($str);
	
	// International w/ Plus and Prefix
	if (preg_match('/^\+[\d]{1,3}\s[\(\)\d\.a-z]+/i', $str))
	{
		return preg_replace('/[^\da-z\+]/i', '', $str);
	}
	// US Domestic 10-Digit
	elseif (preg_match('/^[\(]?[2-9]{1}[\d]{2}[\-\)\.\s]?[\da-z]{3}[\-\.\s]?[\da-z]{4}$/i', $str))
	{
		return '+1 '.preg_replace('/[^\da-z\+]/i', '', $str);
	}
	else
	{
		return preg_replace("/[^0-9]/", "", $str);
	}
}

function tel_convert_vanity ($str) 
{	
	// Alpha-numeric Only
	$str = preg_replace("/[^0-9A-Za-z\*]/", "", $str);
	
	// Assign Letters to Matching Numbers
	$replace = array(	'2'=>array('a','b','c'),
						'3'=>array('d','e','f'),
						'4'=>array('g','h','i'),
						'5'=>array('j','k','l'),
						'6'=>array('m','n','o'),
						'7'=>array('p','q','r','s'),
						'8'=>array('t','u','v'),
						'9'=>array('w','x','y','z'));
	
	// Convert Letters to Numbers
	foreach($replace as $digit=>$letters) {
		$str = str_ireplace($letters, $digit, $str);
	}
	
	return $str;
}