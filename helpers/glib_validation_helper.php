<?php

function is_email($str)
{
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->form_validation->set_message('is_email', '%s must be a valid email address.');
    if (
        strlen($str) <= 256
        && preg_match('/([A-Z0-9._%+-]+)@([A-Z0-9.-]+\.[A-Z]{2,4})/i',$str,$part)
        && isset($part[1],$part[2])
        && strlen($part[1]) <= 64
        && strlen($part[2]) <= 255
    ) {
        return true;
    } else {
        return false;
    }
}

function is_tel($str)
{
    $CI =& get_instance();
    $CI->load->library('form_validation');
    if (preg_match('/^\+[\d]{1,3}\s[\(\)\s\d\.a-z]+$/i', $str)) {
        return true;
    } elseif (preg_match('/^[\(]?[2-9]{1}[\d]{2}[\-\)\.]?[\s]?[\da-z]{3}[\-\.]?[\da-z]{4}$/i', $str)) {
        return true;
    } else {
        $CI->form_validation->set_message('is_tel', '%s must be a valid, 10-digit, U.S. phone number or an international number beginning with a plus sign and country code.');

        return false;
    }
}

function min_value ($val,$min)
{
    settype($min, "float");
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->form_validation->set_message('min_value', '%s must be at least '.$min.'.');
    if ($min <= $val) return TRUE;
    else return FALSE;
}

function max_value ($val,$max)
{
    settype($max, "float");
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->form_validation->set_message('max_value', '%s must not exceed '.$max.'.');
    if ($val > $max) return FALSE;
    else return TRUE;
}
