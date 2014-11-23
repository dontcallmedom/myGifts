<?php
if (!empty ($_POST["dbtype"]))
	define("DBTYPE", $_POST["dbtype"]);
if (!empty ($_POST["language"]))
	define("LANG", $_POST["language"]);
if (!empty ($_POST["dbtype"]))
	define("DBTYPE", $_POST["dbtype"]);

include ("includes/includes.inc.php");

if (!defined("LANG") || LANG == "default") {
	$template = "setup.tpl";
} else
	if (!defined("DBSERVER")) {
		$template = "setupdatabase.tpl";

		if (!empty ($_POST["dbtype"])) {
			define("DBTYPE", $_POST["dbtype"]);
			define("DBSERVER", $_POST["dbserver"]);
			define("DBUSER", $_POST["dbuser"]);
			define("DBPASSWORD", $_POST["dbpassword"]);
			define("DBDATABASE", $_POST["dbdatabase"]);
			$logger->logMessage($logger->LOG_INFO, "Testing DB");
			$database = new Database(DBSERVER, DBUSER, DBPASSWORD, DBDATABASE);
			if ($database->connect()) {
				$config = "<?php\ndefine(\"LANG\", \"".LANG."\");\ndefine(\"SKIN\", \"default\");\ndefine(\"DBTYPE\", \"".DBTYPE."\");\n\ndefine(\"DBSERVER\", \"".DBSERVER."\");\ndefine(\"DBUSER\", \"".DBUSER."\");\ndefine(\"DBPASSWORD\", \"".DBPASSWORD."\");\ndefine(\"DBDATABASE\", \"".DBDATABASE."\");\n?>";
				$fp = @ fopen("config/config.inc.php", "w");
				if ($fp) {
					fwrite($fp, "$config");
					fclose($fp);

					header("Location: ".$_SERVER["SCRIPT_NAME"]);
				} else {
					$logger->logMessage($logger->LOG_INFO, "Can't write");
					$template = "setupcopyconfig.tpl";
					//$title = $strings["ERROR_SETUP_CANTWRITE"];
					$text = $config;
				}
			} else {
				$text = $strings["ERROR_DATABASE"];
			}
		}
	} else {
		$user = $database->fetch("select 1 from gft_user where accessLevel=3");
		if ($user == "ERROR_DATABASE") {
			$filename = "setup/".MVC_APP_NAME.".sql";
			$fp = fopen($filename, "r");
			$dbStruct = fread($fp, filesize($filename));
			fclose($fp);
			foreach (explode(";", $dbStruct) as $sqlQuery) {
				$sqlQuery = trim($sqlQuery);
				if (!empty ($sqlQuery) && !$database->query($sqlQuery)) {
					$template = "setupdatabase.tpl";
					if (DBTYPE == "sqlite")
						$text = $strings["ERROR_DATABASE_SQLITE"];
					else
						$text = $strings["ERROR_DATABASE"];
					break;
				}
			}
			if (empty ($text)) {
				$user = null;
				$database->query("INSERT INTO gft_group (id, name) VALUES (1, '".$strings["LANG_DEFAULT_GROUP"]."')");
			}
		}

		if ($user == null) {
			if (!empty ($_POST["name"]) && !empty ($_POST["password"])) {
				Setup :: updateParam("currency", $strings["LANG_CURRENCY"], "string");
				switch ($_POST["installType"]) {
					case "registry" :
						Setup :: updateParam("sendAlertEmpty", 1, "int");
						Setup :: updateParam("installType", "registry", "string");
						break;
					case "giftlist" :
						Setup :: updateParam("sendAlertUpdate", 1, "int");
						Setup :: updateParam("installType", "giftlist", "string");
						break;
				}
				$user = new User();
				$user->accessLevel = 3;
				$error = $user->saveUser($_POST["name"], null, $_POST["email"], null, $_POST["password"], null, 3);
				if (empty ($error))
					header("Location: ".$_SERVER["SCRIPT_NAME"]);
			}
			$template = "setupadmin.tpl";
		} else
			if ($user != "ERROR_DATABASE") {
				$template = "message.tpl";
				$title = $strings["LANG_SETUP"];
				$text = $strings["LANG_SETUP_FINISHED"];
			}
	}

$smarty = new Smarty;
$smarty->template_dir = "./skins/".SKIN."/";
$smarty->compile_dir = "./skins/".SKIN."/compiled";
$smarty->use_sub_dirs = false;
$smarty->compile_check = false;
$smarty->assign('appParams', $appParams);
$smarty->assign('strings', $strings);
@ $smarty->assign('title', $title);
@ $smarty->assign('text', $text);
@ $smarty->assign('setup', $setup);
foreach (array_keys($_POST) as $variable) {
	$smarty->assign("$variable", $_POST[$variable]);
}
$logger->logMessage($logger->LOG_INFO, "Displaying template $template");
$smarty->display("$template");

if (defined("DEBUG"))
	ob_end_flush();
exit;
?>


