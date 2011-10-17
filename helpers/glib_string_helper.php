<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/***************************************
* NOTES TO SELF:
* tel_convert_vanity and tel_dialtring should be good, but untested.  Add support for spaces as punctuation?
* tel_format needs an overhaul.
* tel_format needs to pass data to tel_format and trigger depreciated error.
***************************************/

function tel_format($str = '')
{
	// If we have not entered a phone number just return empty
	if (empty($str)) {
		return '';
	}
	
	// Strip out any extra characters that we do not need only keep letters and numbers
	$str = preg_replace("/[^0-9A-Za-z]/", "", $str);						 
	
	// FORMAT
	if (strlen($str) == 10) {
		$num = preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1.$2.$3", $str);
	} elseif (strlen($str) > 10) {
		$num = preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]+)/", "+$1 $2.$3.$4", $str);
	} else $num = $str;
	
	// RETURN
	return $num;
	
}

function tel_dialstring ($str)
{
	$str = tel_convert_vanity($str);
	
	if (preg_match('/^\+[\d]{1,3}[\(\)\d\.a-z]+$/i', $str))
	{
		return preg_replace('/[^\da-z\+]/i', '', $str);
	}
	elseif (preg_match('/^[\(]?[2-9]{1}[\d]{2}[\-\)\.]?[\da-z]{3}[\-\.]?[\da-z]{4}$/i', $str))
	{
		return '+1'.preg_replace('/[^\da-z\+]/i', '', $str);
	}
	else
	{
		return $str;
	}
}

function tel_convert_vanity ($str) 
{	
	// SANITIZE, ALPHANUM ONLY
	$str = preg_replace("/[^0-9A-Za-z\*]/", "", $str);
	
	// CONVERT LETTERS TO NUMBERS
	$replace = array(	'2'=>array('a','b','c'),
			 			'3'=>array('d','e','f'),
		         		'4'=>array('g','h','i'),
			 			'5'=>array('j','k','l'),
                      '6'=>array('m','n','o'),
			 			'7'=>array('p','q','r','s'),
			 			'8'=>array('t','u','v'),
			 			'9'=>array('w','x','y','z'));
	// Replace each letter with a number
	// Notice this is case insensitive with the str_ireplace instead of str_replace 
	foreach($replace as $digit=>$letters) {
		$str = str_ireplace($letters, $digit, $str);
	}
	
	return $str;
}
