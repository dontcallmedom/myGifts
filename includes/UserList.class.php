<?php

class UserList {

	var $users;
	
	function UserList($type = null)
	{
		global $database, $user;

		if (is_object($user) && !empty($user->id)) {
			if ($user->accessLevel == 3) {
				$sqlQuery = "select distinct u.* from gft_user u ";
				if ($type == "birthday") {
					$sqlQuery .= "where u.accessLevel >= 2 && DAYOFYEAR(u.birthDate) >= DAYOFYEAR(now()) order by DAYOFYEAR(u.birthDate) LIMIT 0,5";
				} else if ($type == "haslist")
          $sqlQuery .= "where u.accessLevel >= 2";
        else
					$sqlQuery .= "order by u.name";
			} else {
 				$sqlQuery  = "select distinct u.* from gft_user u, gft_users_group ug, gft_users_group me ";
        $sqlQuery .= "where ug.userId = u.id and ug.groupId = me.groupId and me.userId = '".addslashes($user->id)."'";
				if ($type == "birthday") {
					$sqlQuery .= "and DAYOFYEAR(u.birthDate) >= DAYOFYEAR(now()) order by DAYOFYEAR(u.birthDate) LIMIT 0,5";
        } else if ($type == "haslist")
          $sqlQuery .= "and u.accessLevel >= 2";
        else 
					$sqlQuery .= "order by u.name";
			}
			$this->users = $database->fetch($sqlQuery);
		} else
			$this->users = array();
	}
	
	function getParams()
	{
	}
}

Controler::registerHandler("userList", "display", "UserList");
Controler::registerHandler("birthdayList", "display", "UserList", array("id"));
Controler::registerHandler("adminUsers", "display", "UserList", null, 3);
Controler::registerHandler("admin", "display", "UserList", null, 3);

?>
