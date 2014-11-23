<?php

class VisibilityList {

	var $giftId;
	var $users;
	
	function VisibilityList($giftId)
	{
		global $database, $user;
		
		if (!empty($giftId)) {
      	$this->giftId = (int) $giftId;
      	$sqlQuery  = "select u.id, u.name, (v.giftId is not null) as isVisible ";
      	$sqlQuery .= "from gft_user u LEFT OUTER JOIN gft_visibility v ON (u.id = v.userId AND v.giftId = ".$this->giftId."), ";
      	$sqlQuery .= "gft_users_group ug, gft_users_group me ";
      	$sqlQuery .= "where ug.userId = u.id and ug.groupId = me.groupId and me.userId = '".addslashes($user->id)."'";
      
      	$this->users = $database->fetch($sqlQuery);
    }
	}

	function saveVisibilityList($visible)
	{
		global $database;
		
		$database->query("delete from gft_visibility where giftId = ".$this->giftId);
		foreach (explode(" ", $visible) as $user) {
			if (!empty($user))
				$database->query("insert into gft_visibility (giftId, userId) values(".$this->giftId.", '".addslashes($user)."')");
		}
		
		return 0;
	}
	
	function getParams()
	{
	}
}

Controler::registerHandler("visibilityList", "display", "VisibilityList", array("id"), 1);
Controler::registerHandler("editVisibilityList", "display", "VisibilityList", array("id"), 1);
Controler::registerHandler("saveVisibilityList", "action", "VisibilityList", array("id", "visible"), 1);
Controler::registerNextAction("saveVisibilityList", "myList");

?>
