<?php
class Controler {

	function registerHandler($handler, $method, $class = null, $params = null, $needsLogin = false) {
		global $G_CTRL_HANDLERS, $G_CTRL_METHOD, $G_CTRL_PARAMS, $G_CTRL_NEEDS_LOGIN, $logger;

		$logger->logMessage($logger->LOG_INFO, "registerHandler($handler, $method, $class, ...)");

		if (!is_array($G_CTRL_HANDLERS)) {
			$G_CTRL_HANDLERS = array ();
		}
		if (array_key_exists($handler, $G_CTRL_HANDLERS))
			$G_CTRL_HANDLERS[$handler] = array ($G_CTRL_HANDLERS[$handler], $class);
		else
			$G_CTRL_HANDLERS[$handler] = $class;

		if (!is_array($G_CTRL_METHOD)) {
			$G_CTRL_METHOD = array ();
		}
		$G_CTRL_METHOD[$handler] = $method;

		if (!is_array($G_CTRL_PARAMS)) {
			$G_CTRL_PARAMS = array ();
		}
		$G_CTRL_PARAMS["$handler-".strtolower($class)] = $params;

		if (!is_array($G_CTRL_NEEDS_LOGIN)) {
			$G_CTRL_NEEDS_LOGIN = array ();
		}
		if (array_key_exists($handler, $G_CTRL_NEEDS_LOGIN))
			$G_CTRL_NEEDS_LOGIN[$handler] = array ($G_CTRL_NEEDS_LOGIN[$handler], $needsLogin);
		else
			$G_CTRL_NEEDS_LOGIN[$handler] = $needsLogin;
	}

	function registerNextAction($handler, $nextAction) {
		global $G_CTRL_NEXT_ACTION;
		if (!is_array($G_CTRL_NEXT_ACTION)) {
			$G_CTRL_NEXT_ACTION = array ();
		}
		$G_CTRL_NEXT_ACTION[$handler] = $nextAction;
	}

  function registerParamFormatter($paramName, $formatter) {
    global $G_CTRL_PARAM_FMT;
    if (!is_array($G_CTRL_PARAM_FMT)) {
      $G_CTRL_PARAM_FMT = array ();
    }
    $G_CTRL_PARAM_FMT[$paramName] = $formatter;
  }

	function getHandler($handler) {
		global $G_CTRL_HANDLERS, $logger;
		$logger->logMessage($logger->LOG_INFO, "getHandler($handler) => ".var_export($G_CTRL_HANDLERS[$handler], true));
		return $G_CTRL_HANDLERS[$handler];
	}

	function & getObject($handler, $id = null, $accessLevel = null) {
		global $G_CTRL_PARAMS, $user, $logger;

		$classArr = Controler :: getHandler($handler);
		if (empty ($classArr))
			return null;

		if (!is_array($classArr))
			$classArr = array ($classArr);
		$objectArr = array ();
		foreach ($classArr as $class) {
			if (empty ($class))
				continue;

			$paramsArr = $G_CTRL_PARAMS["$handler-".strtolower($class)];

			$logger->logMessage($logger->LOG_INFO, "getObject ($id) -> $class");

			if ($id === null && is_array($paramsArr) && count($paramsArr) > 0) {
				$paramName = $paramsArr[0];
				$logger->logMessage($logger->LOG_INFO, "id($handler) = $paramName");
				if ($paramName == "user")
					$id = $user->id;
				else
					if (!empty ($paramName)) {
						$id = Tools :: getHttpParam($paramName);
					}
			}
			if ($id === null)
				$id = Tools :: getHttpParam("id");

			if (!empty ($id))
				$objectArr[] = @ new $class ($id);
			else
				$objectArr[] = @ new $class ();
		}
		if (count($objectArr) == 1)
			return $objectArr[0];
		else
			return $objectArr;
	}

  function loadFromUrl($object) {
    foreach (array_keys(get_object_vars($object)) as $varName) {
      $object->$varName = Tools::getHttpParam($varName);
    }
  }
  
	function getParamNames($handler, $class) {
		global $G_CTRL_PARAMS;

		$class = strtolower($class);
		if (is_array($G_CTRL_PARAMS["$handler-$class"]))
			return $G_CTRL_PARAMS["$handler-$class"];
		else
			return array ();
	}

	function & getParamValues($handler, $class) {
		global $user;

		$params = array ();
		$class = strtolower($class);

		foreach (array_slice(Controler :: getParamNames($handler, $class), 1) as $paramName) {
			if ($paramName == "user")
				$params["user"] = $user->id;
			else
				$params[$paramName] = Tools :: getHttpParam($paramName);
		}

		return $params;
	}

  function formatParam($paramName, $paramValue) {
    global $G_CTRL_PARAM_FMT;

    if (!array_key_exists($paramName, $G_CTRL_PARAM_FMT))
      return $paramValue;
    else
      return call_user_func_array($G_CTRL_PARAM_FMT[$paramName], array($paramValue));
  }
  
	function callAction(& $object, $handler) {
		global $logger;

		$logger->logMessage($logger->LOG_INFO, "callAction $handler");

		if (!is_object($object))
			return false;

		$params = Controler :: getParamValues($handler, get_class($object));
		return call_user_func_array(array ($object, $handler), $params);
	}

	function getParamsAction(& $object, $handler) {
		global $logger;

		$logger->logMessage($logger->LOG_INFO, "getParamsAction $handler");
		if (!is_object($object))
			return false;

		$params = Controler :: getParamValues($handler, get_class($object));
		//print_r($params);
		return call_user_func_array(array ($object, "getParams"), $params);
	}

	function needsLogin($handler) {
		global $G_CTRL_NEEDS_LOGIN;
		if (is_array($G_CTRL_NEEDS_LOGIN[$handler]))
			return array_reduce($G_CTRL_NEEDS_LOGIN[$handler], "min");
		else
			return $G_CTRL_NEEDS_LOGIN[$handler];
	}

	function nextAction($handler) {
		global $G_CTRL_NEXT_ACTION, $logger;
		if (!array_key_exists($handler, $G_CTRL_NEXT_ACTION))
			return null;
		$logger->logMessage($logger->LOG_INFO, "nextAction($handler) =".$G_CTRL_NEXT_ACTION[$handler]);
		return $G_CTRL_NEXT_ACTION[$handler];
	}

	function goto($handler) {
		global $logger;
		$logger->logMessage($logger->LOG_INFO, "goto : $handler");
		if (strpos($handler, "/") === false)
			$uri = $_SERVER["SCRIPT_NAME"]."?handler=".urlencode($handler);
		else
			$uri = $handler;
		if (defined("DEBUG"))
			echo "<a href=\"$uri\">suite</a>";
		else
			header("Location: $uri");
	}

	function gotoPrevious($error = "", $params = null) {
		if (!empty ($_SERVER["HTTP_REFERER"])) {
			$nextUri = $_SERVER["HTTP_REFERER"];
			$nextUri = Tools :: appendUri($nextUri, "error", $error);
			if (is_array($params))
				foreach ($params as $param) {
          $paramValue = Tools::getHttpParam($param);
          $nextUri = Tools :: appendUri($nextUri, $param, Controler::formatParam($param, $paramValue));
        }
			if (defined("DEBUG"))
				echo "<a href=\"$nextUri\">suite</a>";
			else
				header("Location: $nextUri");
		} else
			Controler :: goto(DEFAULT_HANDLER);
	}

	function displayTemplate($template, & $user, & $object, $nextAction = "", $error = "") {
		echo Controler :: processTemplate($template, $user, $object, $nextAction, $error);
	}

	function processTemplate($template, & $user, & $object, $nextAction = "", $error = "") {
		global $smarty, $strings, $logger, $handler, $setup, $appParams;

		$logger->logMessage($logger->LOG_INFO, "display $template.tpl");
		$logger->logMessage($logger->LOG_INFO, "object : ".var_export($object, true));

		if (!isset ($smarty)) {
			$smarty = & new Smarty;
			$smarty->template_dir = "./skins/".SKIN."/";
			$smarty->compile_dir = "./skins/".SKIN."/compiled";
			$smarty->use_sub_dirs = false;
			$smarty->compile_check = false;
			//$smarty->debugging = true;
		}
		$smarty->assign('appParams', $appParams);
		$smarty->assign('strings', $strings);
		$smarty->assign('currentAction', $handler);
		$smarty->assign('nextAction', $nextAction);
		$smarty->assign('user', $user);
		$smarty->assign('object', $object);
		$smarty->assign('setup', $setup);
		if (empty ($error))
			$error = Tools :: getHttpParam("error");
		if (!empty ($error)) {
			$smarty->assign('error', $strings["ERROR"]." : ".$strings[$error]);
			$logger->logMessage($logger->LOG_INFO, "error =".$strings[$error]);
		}

		//$smarty->display("$handler.tpl");
		return $smarty->fetch("$template.tpl");
	}

	function displayError($error) {
		global $smarty, $strings, $logger, $appParams;

		$logger->logMessage($logger->LOG_INFO, "display error");

		if (!isset ($smarty)) {
			$smarty = & new Smarty;
			$smarty->template_dir = "./skins/".SKIN."/";
			$smarty->compile_dir = "./skins/".SKIN."/compiled";
			$smarty->use_sub_dirs = false;
			$smarty->compile_check = false;
			//$smarty->debugging = true;
		}
		$smarty->assign('strings', $strings);
		$smarty->assign('appParams', $appParams);
		//$smarty->assign('nextAction', $nextAction);
		$smarty->assign('title', $strings["ERROR"]);
		$smarty->assign('text', $strings[$error]);
		$smarty->display("message.tpl");
	}
}

Controler :: registerHandler("credits", "display");
?>