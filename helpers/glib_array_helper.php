<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
	Convert paired values to associative array, using a value as the new key.
*/
function array_flatten ($array,$key1,$key2) { 
	
	if (!is_array($array)) return FALSE;
	elseif (count($array) < 1) return array();
	
	foreach ($array as $row) {
		
		$rk1=$row[$key1];
		$newArray[$rk1] = $row[$key2];
	}
	
	return $newArray; 

}

/*
	Get the first value from an array.
*/
function array_first ($array) {
	
	return array_shift(array_values($array));
	
}
