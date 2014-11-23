<?php

function smarty_block_mvc_form($params, $content, &$smarty)
{
  $post = $params["post"];
  if ($post)
    $returnValue =  "<form action=\"index.php\" method=\"post\">";
  else
    $returnValue =  "<form action=\"index.php\" method=\"get\">";
	if (isset($content)) {
		$handler = $params["handler"];
    if (empty($handler)) {
      foreach (array_keys($_GET) as $keyName) {
        $returnValue .= "<input type=\"hidden\" name=\"$keyName\" value=\"".addslashes($_GET[$keyName])."\" />";
      }
    } else {
      if (!empty($params["method"]))
    			$method = $params["method"];
    		else
    			$method = "action";
      $id = $params["id"];
    
      $returnValue .= "<input type=\"hidden\" name=\"handler\" value=\"$handler\" />";
      $returnValue .= "<input type=\"hidden\" name=\"method\" value=\"$method\" /><input type=\"hidden\" name=\"id\" value=\"$id\" />";
    }
    $returnValue .= "<input type=\"hidden\" name=\"nextAction\" value=\"".$smarty->get_template_vars('nextAction')."\" />";
    $returnValue .= "$content</form>";
		return $returnValue;
	}
}

?>
