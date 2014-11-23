<?php
class Setup {

	function load() {
		global $database, $setup;

		if (is_object($database))
			$liste = $database->fetch("select * from gft_params");
		else
			$liste = null;

		if (!is_array($liste))
			return;

		foreach ($liste as $paramArr) {
			//$this->paramType[$paramArr["name"]] = $paramArr["type"];
			switch ($paramArr["type"]) {
				case "int" :
					$setup[$paramArr["name"]] = (int) $paramArr["valueInt"];
					break;
				case "string" :
					$setup[$paramArr["name"]] = $paramArr["valueStr"];
					break;
			}
		}
	}

	function getParam($name) {
		global $setup;
		if (!array_key_exists($name, $setup))
			return false;
		return $setup[$name];
	}

	function updateParam($name, $value, $type) {
		global $database, $setup;

		if (empty ($type))
			return false;

		if ($type == "string") {
			$value = "'".addslashes($value)."'";
			$col = "valueStr";
		} else
			if ($type == "int") {
				$value = (int) $value;
				$col = "valueInt";
			}

		if (empty ($col))
			return false;

		$setup[$name] = $value;
		return $database->query("replace into gft_params ($col, name, type) values($value, '$name', '$type')");
	}

	function saveSetup($selfRegistration, $dontDisplayClaimerName, $seePropositions, $displayClaimerIfOwner, $sendAlertUpdate, $sendAlertEmpty, $sendAlertClaim, $emailMandatory, $emailExtCheck, $currency) {
		Setup :: updateParam("selfRegistration", $selfRegistration, "int");
		Setup :: updateParam("dontDisplayClaimerName", $dontDisplayClaimerName, "int");
		Setup :: updateParam("seePropositions", $seePropositions, "int");
		Setup :: updateParam("displayClaimerIfOwner", $displayClaimerIfOwner, "int");
		Setup :: updateParam("sendAlertUpdate", $sendAlertUpdate, "int");
		Setup :: updateParam("sendAlertEmpty", $sendAlertEmpty, "int");
    Setup :: updateParam("sendAlertClaim", $sendAlertClaim, "int");
    Setup :: updateParam("emailMandatory", $emailMandatory, "int");
    Setup :: updateParam("emailExtCheck", $emailExtCheck, "int");
		Setup :: updateParam("currency", $currency, "string");
	}

	function getParams() {
	}
}

Controler :: registerHandler("adminSetup", "display", "Setup", null, 3);
Controler :: registerHandler("saveSetup", "all", "Setup", array ("id", "selfRegistration", "dontDisplayClaimerName", "seePropositions", "displayClaimerIfOwner", "sendAlertUpdate", "sendAlertEmpty", "sendAlertClaim", "emailMandatory", "emailExtCheck", "currency"), 3);
?>