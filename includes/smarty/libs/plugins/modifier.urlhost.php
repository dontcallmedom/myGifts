<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     urlhost
 * Purpose:  returns the host of a url
 * -------------------------------------------------------------
 */
function smarty_modifier_urlhost($string)
{
	$urlParts = parse_url($string);
	
	return $urlParts["host"];
}

?>
