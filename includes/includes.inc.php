<?php

@include_once("config/config.inc.php");

if (defined("DEBUG")) {
	ob_start();
}
	
define("MVC_APP_NAME", "myGifts");
define("MVC_APP_CODE", "gft");
define("MVC_DEFAULT_HANDLER", "myList");
define("MVC_APP_VERSION", "2.63");
define("MVC_APP_VERSION_NUM", "250");
if (!defined("LANG"))
	define("LANG", "default");
if (!defined("SKIN"))
	define("SKIN", "default");

//if (!defined("LOG_DIR"))
//	define("LOG_DIR", "../../logs/");

if (!@is_array($setup))
	$setup = array();
	
require_once("includes/Tools.class.php");
require_once("includes/Logger.class.php");
$logger =& new Logger();

if ( defined("DBTYPE") && DBTYPE == "sqlite")
	require_once("includes/Database.sqlite.class.php");
else
	require_once("includes/Database.class.php");
if (defined("DBSERVER"))
	$database =& new Database(DBSERVER, DBUSER, DBPASSWORD, DBDATABASE);

require_once("includes/Controler.class.php");
require_once("includes/smarty/libs/Smarty.class.php");

//require_once("languages/simpleMVC.".LANG.".lang.php");
require_once("languages/".MVC_APP_NAME.".".LANG.".lang.php");
require_once("includes/".MVC_APP_NAME.".inc.php");

$appParams["version"] = MVC_APP_VERSION;
if (array_key_exists("LOCALE", $appParams))
	setlocale(LC_ALL, $appParams["LOCALE"].".ISO8859-1"); 

?>
