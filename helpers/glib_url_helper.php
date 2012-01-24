<?php

function gravatar_url ($email,$size,$default,$rating=false)
{
	$email = md5( strtolower( trim( $email ) ) );

	return "https://secure.gravatar.com/avatar/$email?s=$size&d=$default&r=$rating";
}