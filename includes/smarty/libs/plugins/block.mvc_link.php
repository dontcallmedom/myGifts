<?php
function smarty_block_mvc_link($params, $content, &$smarty)
{
	if (isset($content)) {
			
		$handler = $params["handler"];
		$method = $params["method"];
		$id = $params["id"];
		$class = $params["class"];
		$absolute = $params["absolute"];
		$nohtml = $params["nohtml"];
    $getBack = $params["getBack"];
    $openwindow = $params["openwindow"];
		$confirm = $params["confirm"];

		$paramStr = "";
		foreach (array_keys($params) as $paramName) {
			if (!in_array($paramName, array("handler", "method", "id", "class", "absolute", "nohtml", "getBack", "openwindow", "confirm")))
				$paramStr .= "&$paramName=".urlencode($params[$paramName]);
		}
		
		if (empty($method)) $method="display";
		
		$returnValue = "";
		if ($nohtml != "1") {
			$returnValue .= "<a href=\"";
      if (!empty($openwindow))
        $returnValue .= "javascript:openWindow('";
    }
		if ($absolute == 1) {
      $returnValue .= "http://".$_SERVER["HTTP_HOST"];
      $dirname = dirname($_SERVER["SCRIPT_NAME"]);
      if ($dirname != "/")
        $returnValue .= "$dirname/";
      else
        $returnValue .= "/";
    }
		$returnValue .= "index.php?handler=$handler&method=$method&id=$id$paramStr";

		if ($getBack == 1)
			$returnValue .= "&nextAction=".$smarty->get_template_vars('currentAction');
		
		if ($nohtml != "1") {
      if (!empty($openwindow)) {
        list($width, $height) = explode("x", $openwindow);
        $returnValue .= "', '$handler', $width, $height, '')";
      }
			$returnValue .= "\"";

			if (!empty($confirm)) {
				$returnValue .= " onClick=\"return confirm('".addslashes($confirm)."')\"";
			}

			if (!empty($class)) {
				$returnValue .= " class=\"$class\"";
			}
			$returnValue .= ">$content</a>";
		}
		
		return $returnValue;
	}
}
?>
