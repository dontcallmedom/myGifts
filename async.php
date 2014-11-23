<?php
ob_start();
require("includes/includes.inc.php");
ob_end_clean();

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
    echo "Erreur de sauvegarde (utilisateur non reconnu)";
    exit;
	} elseif (Controler::needsLogin($handler) > $user->accessLevel) {
    echo "Erreur de sauvegarde (droits insuffisants)";
    exit;
	}
}

if ($loginOK) {
  $object = Controler::getObject($handler, null, $user->accessLevel);
  if (!is_array($object))
    $objectArr = array($object);
  else
    $objectArr = $object;
  foreach ($objectArr as $object)
    if (empty($error))
      $error = Controler::callAction($object, $handler);

	$logger->logMessage($logger->LOG_INFO, "nextAction avant = $nextAction/".empty($nextAction));
  if ($error)
    echo $error;
  else
    echo "OK";
}
if (defined("DEBUG"))
	ob_end_flush();
?>
