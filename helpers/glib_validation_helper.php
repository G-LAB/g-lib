<?php

function is_email($str) {
    if (
    	strlen($str) <= 256
    	&& preg_match('/([A-Z0-9._%+-]+)@([A-Z0-9.-]+\.[A-Z]{2,4})/i',$str,$part)
    	&& isset($part[1],$part[2])
    	&& strlen($part[1]) <= 64
    	&& strlen($part[2]) <= 255
    ) {
    	return true;
    }
    else
    {
    	return false;
    }
}

function min_value ($val,$min) {
	settype($min, "float");
	$CI =& get_instance();
	$CI->form_validation->set_message('min_value', '%s must be at least '.$min.'.');
	if ($min <= $val) return TRUE;
	else return FALSE;
}

function max_value ($val,$max) {
	settype($max, "float");
	$CI =& get_instance();
	$CI->form_validation->set_message('max_value', '%s must not exceed '.$max.'.');
	if ($val > $max) return FALSE;
	else return TRUE;
}