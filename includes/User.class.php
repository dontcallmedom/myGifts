<?php
class User {
	var $id;

  var $name;
  var $realname;
	var $email;
	var $password;
	var $birthDate;
	var $accessLevel;
  var $emptyObj;

	function User($id = "") {
		global $database;

		if (!empty ($id)) {
			$sqlQuery = "select * from gft_user where id='".addslashes($id)."'";
			$database->loadObject($this, $sqlQuery);
		} else {
			$this->accessLevel = 1;
      $this->emptyObj = true;
		}
	}

	function isLogged() {
		return (!empty ($this->name) && $this->accessLevel > 0);
	}
	function getCurrentUser() {
		if (array_key_exists("visitorID", $_COOKIE) && !empty ($_COOKIE["visitorID"])) {
			$user = new User($_COOKIE["visitorID"]);
			if (is_object($user) && $user->isLogged())
				return $user;
		}

		$name = Tools :: getHttpParam("name");
		$password = Tools :: getHttpParam("password");
		$rememberme = Tools :: getHttpParam("rememberme");

		if (!empty ($name))
			return User :: login($name, $password, $rememberme);
		else
			return null;
	}

	function & login($name, $password, $rememberme) {
		global $database;

		$sqlQuery = "select * from gft_user where name='".addslashes($name)."' and password='".md5($password)."'";
		$user = $database->loadObject(new User(), $sqlQuery);

		if ($user == null)
			return null;
		else {
			$user->remember($rememberme);
			return $user;
		}
	}

	function remember($permanent = false) {
		if (empty($this->id)) {
			$this->id = User :: generateID();
		}
		if ($permanent)
			setcookie("visitorID", $this->id, mktime(0, 0, 0, 1, 1, 2020));
		else
			setcookie("visitorID", $this->id);
	}

	function logout() {
		setcookie("visitorID", "", mktime(0, 0, 0, 1, 1, 2000));

		return 0;
	}

	function getParams() {
	}

	function saveUser($name, $realname, $email, $birthDateArray, $password, $groups, $accessLevel = 2) {
		global $database, $user;

		$accessLevel = (int) $accessLevel;
    if ($accessLevel == 0)
      $accessLevel = 1;
      
		if (empty ($name))
			return "ERROR_MISSINGNAME";
    $name = stripslashes($name);
    $realname = stripslashes($realname);

		$sqlQuery = "select 1 from gft_user where name = '".addslashes($name)."'";
		if (!empty ($this->id)) {
			$sqlQuery .= " and id != '".addslashes($this->id)."'";
		}
		$userList = $database->fetch($sqlQuery);
		if (count($userList))
			return "ERROR_DUPLICATENAME";

    $error = User::checkEmail($email);
    if (!empty($error))
      return $error;
      
		if (is_array($birthDateArray)) {
			if (!isset ($birthDateArray["Date_Year"]))
				$birthDateArray["Date_Year"] = "2004";
			if (!checkdate($birthDateArray["Date_Month"], $birthDateArray["Date_Day"], $birthDateArray["Date_Year"]))
				return "ERROR_INVALIDDATE";
      $birthDate = User::formatDate($birthDateArray);
		} else
			$birthDate = "null";

		if (empty ($this->id)) {
			if (empty ($password))
				return "ERROR_MISSINGPASSWORD";

      if ($user->accessLevel < 3 && !Setup::getParam("selfRegistration"))
        return "ERROR_INSUFFICIENTPRIVILEGES";

			//if ($user->accessLevel == 2) {
			$this->id = User :: generateID();
			$sqlQuery = "insert into gft_user (id, name, email, birthDate, password, accessLevel, creationDate) values('".addslashes($this->id)."', '".addslashes($name)."', '".addslashes($email)."', '".addslashes($birthDate)."', '".md5($password)."', $accessLevel, now())";
      if ($user->accessLevel < 3) {
        $this->remember();
        $newUser = true;
      } else
        $newUser = false;
			//}
		} else {
      if ($user->accessLevel < 3 && $user->id != $this->id)
        return "ERROR_INSUFFICIENTPRIVILEGES";
      
			$sqlQuery = "update gft_user set name='".addslashes($name)."', email='".addslashes($email)."', birthDate='".addslashes($birthDate)."'";
			if (isset ($accessLevel) && $user->accessLevel == 3)
				$sqlQuery .= ", accessLevel=$accessLevel";
			$sqlQuery .= " where id='".addslashes($this->id)."'";
      $newUser = false;
		}

		if (!empty ($sqlQuery))
			if (!$database->query($sqlQuery))
				return "ERROR_CANTSAVE";

		if (isset ($groups) && $user->accessLevel == 3) {
			$gl = new GroupList($this->id);
			$gl->saveGroupList(" ".join($groups));
		} else if ($newUser) {
      $gl = new GroupList($this->id, true);
      $gl->saveGroupList();
    }

		return 0;
	}

	function changePassword($password, $password2) {
		global $database, $user;

		if ($password != $password2)
			return "ERROR_PASSWORD_NOTMATCH";

		if ($user->accessLevel < 3 && $user->id != $this->id)
			return "ERROR_INSUFFICIENTPRIVILEGES";

		$sqlQuery = "update gft_user set password='".md5($password)."' where id='".addslashes($this->id)."'";

		$database->query($sqlQuery);

		return 0;
	}

	function deleteUser() {
		global $database, $user;

		if ($user->accessLevel < 3)
			return "ERROR_INSUFFICIENTPRIVILEGES";

		$sqlQuery = "delete from gft_user where id='".addslashes($this->id)."'";

		$database->query($sqlQuery);

		return 0;
	}

	function generateID() {
		return md5(uniqid(rand()));
	}

	function generateTicket() {
		global $database;

		$ticket = User :: generateID();
		$sqlQuery = "INSERT INTO gft_auth (ticket, user, IP, userAgent, creationDate) values('".addslashes($ticket)."', '".addslashes($this->id)."', '".addslashes($_SERVER["REMOTE_ADDR"])."', '".addslashes($_SERVER["HTTP_USER_AGENT"])."', now())";
		$result = $database->query($sqlQuery);

		setcookie("auth", $ticket, 0, "/");
		return true;
	}

 function checkEmail($email = null) {
    global $env;
    
    if ($email === null)
      $email = $this->email;
      
    if (empty($email)) {
      if (Setup :: getParam("emailMandatory"))
        return "ERROR_MISSINGEMAIL";
      else
        return "";
    } elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $email))
      return "ERROR_EMAILINVALID";
    elseif (Setup::getParam("emailExtCheck")) {
      list($alias, $domain) = explode("@", $email);
      $domainlist = explode(".", $domain);
      $ok = false;
      while (count($domainlist) > 1) {
        $domain = join(".", $domainlist);
        if (checkdnsrr($domain, "MX")) {
          $ok = true;
          break;
        }
        array_shift($domainlist);
      }
      if (!$ok)
        return "ERROR_EMAILINVALID";
    }
    return "";
  }
  
	function sendMail($to, $subject, $message) {
		$result = mail($to, $subject, $message, "From: \"$this->name\" <$this->email>\r\n"."X-Mailer: myGifts/PHP");
		if ($result)
			return 0;
		else
			return "ERROR_CANTSENDMAIL";
	}

  function formatDate($dateArr) {
    if (!isset ($dateArr["Date_Year"]))
      $dateArr["Date_Year"] = "2004";
    return $dateArr["Date_Year"]."-".$dateArr["Date_Month"]."-".$dateArr["Date_Day"];
  }
}

Controler :: registerHandler("login", "all", "User", array ("user", "name", "password", "rememberme"));
Controler :: registerHandler("changePassword", "all", "User", array ("id", "password", "password2"), 1);
Controler :: registerHandler("adminChangePassword", "display", "User", array ("id"), 3);
//Controler::registerNextAction("changePassword", "myList");
Controler :: registerHandler("logout", "action", "User", array ("user"), 1);
Controler :: registerNextAction("logout", "myList");

//Controler::registerHandler("adminUsers", "display", "User", null, 3);
Controler :: registerHandler("adminEditUser", "display", "User", array ("id"), 3);
Controler :: registerHandler("editProfile", "display", "User", array ("user"), 1);
Controler :: registerHandler("register", "display", "User");
Controler :: registerNextAction("register", "myList");
Controler :: registerHandler("saveUser", "action", "User", array ("id", "name", "realname", "email", "birthDate", "password", "groups", "accessLevel"));
Controler :: registerHandler("deleteUser", "all", "User", array ("id"), 3);
//Controler::registerNextAction("saveUser", "adminUsers");
Controler :: registerParamFormatter("birthDate", array("User", "formatDate"));
?>