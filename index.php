<?php

require("includes/includes.inc.php");

if (!defined("DBSERVER"))
  include("setup.php");
elseif (Setup::getParam("dbVersionNum") === false || MVC_APP_VERSION_NUM > Setup::getParam("dbVersionNum"))
	include("upgrade.php");

$user = User::getCurrentUser();

$handler = Tools::getHttpParam("handler");
$method = Tools::getHttpParam("method");
$nextAction = Tools::getHttpParam("nextAction");
$error = "";
$errorCritical = false;

$logger->logMessage($logger->LOG_INFO, "appel $handler/$method");

if (empty($handler) || ($handler == "login" && $user->isLogged())) {
	$logger->logMessage($logger->LOG_INFO, "default action : ".MVC_DEFAULT_HANDLER." !");
	$handler = MVC_DEFAULT_HANDLER;
	$method = "display";
}
if (empty($method)) {
	$logger->logMessage($logger->LOG_INFO, "default method : display");
	$method = "display";
}

$displayLogin = false;
$loginOK = true;
if (Controler::needsLogin($handler) > 0) {
	if (!is_object($user) || !$user->isLogged()) {
		$logger->logMessage($logger->LOG_INFO, "$handler needs Login !");
		$nextAction = @$_SERVER["HTTP_REFERER"];
    $displayLogin = true;
    $loginOK = false;
	} elseif (Controler::needsLogin($handler) > $user->accessLevel) {
		$logger->logMessage($logger->LOG_INFO, "$user->name can't access $handler !");
		$error = "ERROR_ACCESSDENIED";
		$errorCritical = true;
    $loginOK = false;
	}
}

if ($loginOK) {
  $object = Controler::getObject($handler, null, (is_object($user)?$user->accessLevel:null));
  if (is_object($object) && $object->emptyObj)
    Controler::loadFromUrl($object);
}

if ($method != "display" && $loginOK) {
  if (!is_array($object))
    $objectArr = array($object);
  else
    $objectArr = $object;
  $paramsError = array();
  foreach ($objectArr as $object)
    if (empty($error)) {
      $error = Controler::callAction($object, $handler);
      if (!empty($error))
        $paramsError = array_merge($paramsError, Controler::getParamNames($handler, get_class($object)));
    }

	$logger->logMessage($logger->LOG_INFO, "nextAction avant = $nextAction/".empty($nextAction));
	if (empty($nextAction))
		$nextAction = Controler::nextAction($handler);
	$logger->logMessage($logger->LOG_INFO, "nextAction final = $nextAction");
	if (!empty($nextAction) && empty($error)) {
    if ($nextAction == "close_refresh" && !defined("DEBUG")) {
      print "<script type=\"text/javascript\"> window.opener.location.href = window.opener.location.href </script>";
      print "<script type=\"text/javascript\"> window.close() </script>";
    } else
		  Controler::goto($nextAction);
	} else
		Controler::gotoPrevious($error, $paramsError);
}

if (!empty($error) && $errorCritical) {
	Controler::displayError($error);
} elseif ($displayLogin) {
  $param = Tools::getHttpParam("name");
  if (!empty($param))
      $error = "ERROR_CANTLOGIN";
  Controler::displayTemplate("login", $user, $object, $nextAction, $error);
} elseif ($method != "action") {
  if (is_array($object))
    $object = array_shift($object);
	//$params = Controler::getParamsAction($object, $handler);
  Controler::displayTemplate($handler, $user, $object, $nextAction);
}


if (defined("DEBUG"))
	ob_end_flush();
?>
