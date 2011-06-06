<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	function date_relative($time,$date_format='F j, Y') {
		
		if (!is_numeric($time)) $time = strtotime($time);
		
		$diff = time() - $time;
		
		if ($diff>0) {
			
			if ($diff<60) return $diff . " second".plural_int($diff)." ago";
			
			$diff = round($diff/60);
			if ($diff<60) return $diff . " minute".plural_int($diff)." ago";
			
			$diff = round($diff/60);
			if ($diff<24) return $diff . " hour".plural_int($diff)." ago";
			
			$diff = round($diff/24);
			if ($diff<7) return $diff . " day".plural_int($diff)." ago";
			
			$diff = round($diff/7);
			if ($diff<4) return $diff . " week".plural_int($diff)." ago";
			return "on " . date($date_format, $time);
		} else {
			if ($diff>-60)
				return "in " . -$diff . " second".plural_int($diff);
			$diff = round($diff/60);
			if ($diff>-60)
				return "in " . -$diff . " minute".plural_int($diff);
			$diff = round($diff/60);
			if ($diff>-24)
				return "in " . -$diff . " hour".plural_int($diff);
			$diff = round($diff/24);
			if ($diff>-7)
				return "in " . -$diff . " day".plural_int($diff);
			$diff = round($diff/7);
			if ($diff>-4)
				return "in " . -$diff . " week".plural_int($diff);
			return "on " . date($date_format, $time);
		}
	}
	
	function date_copyright ($oyear,$roman=FALSE) {
		$year = date('Y');
		
		if ($roman) {
			$CI =& get_instance();
			$CI->load->helper('number');
			if ($oyear == $year) return number_roman_format($year);
			else return number_roman_format($oyear).'-'.number_roman_format($year);
		} else {
			if ($oyear == $year) return $year;
			else return $oyear.'-'.$year;
		}
	}
	
	function plural_int ($int) {
		if (abs($int) != 1) return 's';
		else return '';
	}
	
	function strtotime_mysql ($str) {
		
		// Check for DST
		if (date('I',strtotime($str)) != true) $tz = 'MST';
		else $tz = 'MDT';
		
		$time = strtotime($str.' '.$tz);
		
		return $time;
	}
	
// End of file.