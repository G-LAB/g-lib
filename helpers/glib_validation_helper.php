<?php

/**
 * Validation Helper
 *
 * PHP Version 5.3
 *
 * @category  Helper
 * @package   Codeigniter
 * @author    Brodkin CyberArts <support@brodkinca.com>
 * @copyright 2012 Brodkin CyberArts.
 * @license   All rights reserved.
 * @version   GIT: $Id$
 * @link      http://brodkinca.com/
 */

/**
 * Validate Email Address
 *
 * @param string $str String containing email address
 *
 * @return boolean
 */
function is_email($str)
{
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->form_validation->set_message('is_email', '%s must be a valid email address.');
    if (
        strlen($str) <= 256
        && preg_match('/([A-Z0-9._%+-]+)@([A-Z0-9.-]+\.[A-Z]{2,4})/i', $str, $part)
        && isset($part[1],$part[2])
        && strlen($part[1]) <= 64
        && strlen($part[2]) <= 255
    ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Validate Telephone Number
 *
 * @param string $str String containing telephone number
 *
 * @return boolean
 */
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

/**
 * Validate if value is greater than or equal to minimum
 *
 * @param int $val Test value
 * @param int $min Minimum value
 *
 * @return boolean
 */
function min_value ($val, $min)
{
    settype($min, "float");
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->form_validation->set_message('min_value', '%s must be at least '.$min.'.');
    if ($min <= $val) return true;
    else return false;
}

/**
 * Validate if value is less than or equal to maximum
 *
 * @param int $val Test value
 * @param int $max Maximum value
 *
 * @return boolean
 */
function max_value ($val, $max)
{
    settype($max, "float");
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->form_validation->set_message('max_value', '%s must not exceed '.$max.'.');
    if ($val >= $max) return false;
    else return true;
}
