<?php

function smarty_function_mvc_value($params, &$smarty)
{
  global $object;
  $name = $params["name"];
  if (is_object($object) && !empty($object->$name))
    return $object->$name;
  else
    return $_GET[$name];
}

?>
