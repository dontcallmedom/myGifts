<?php

class Tools {

	function cleanUp($string)
	{
		return $string;
	}
	
	function getHttpParam($paramName)
	{
		global $logger;
		
		if (array_key_exists($paramName, $_GET)) {
			$logger->logMessage($logger->LOG_INFO, "$paramName =>".$_GET[$paramName]);
			return Tools::cleanUp($_GET[$paramName]);
		} else if (array_key_exists($paramName, $_POST)) {
			$logger->logMessage($logger->LOG_INFO, "$paramName =>".$_POST[$paramName]);
			return Tools::cleanUp($_POST[$paramName]);
		}
		return "";
	}

	function checkboxToInt($value)
	{
                if ($value == "on") return 1;
                else return (int) $value;
 	}

	function appendUri()
	{
		$numargs = func_num_args();
		if ($numargs == 0) return "";
		
		$uri = func_get_arg(0);
		
		if (strstr($uri, "?")) {
			$firstParam = false;
		} else {
			$uri .= "?";
			$firstParam = true;
		}
		for($i = 1; $i < $numargs; $i += 2) {
			if (!$firstParam) {
				$uri .= "&";
			} else {
				$firstParam = false;
			}
			$paramName = func_get_arg($i);
			$uri = eregi_replace("&".urlencode($paramName)."=[^&]*", "", $uri);
			$uri .= urlencode(func_get_arg($i))."=".urlencode(func_get_arg($i+1));
		}
		return $uri;
	}

}

?>
