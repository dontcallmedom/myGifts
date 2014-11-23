<?php

class GroupList {

	var $userId;
	var $groups;
	
	function GroupList($userId = "", $defaultGroups = false)
	{
		global $database;
		
		$this->userId = $userId;
		if (empty($userId) || $defaultGroups)
			$this->groups = $database->fetch("select *, 0 as isVisible from gft_group");
			if (count($this->groups) > 0) {
				$this->groups[0]["isVisible"] = 1;
			}
		else {
			$this->groups = $database->fetch("select g.*, (ug.userId IS NOT NULL) as isVisible from gft_group g LEFT OUTER JOIN gft_users_group ug ON g.id = ug.groupId and ug.userId = '".addslashes($this->userId)."'");
		}
	}
	
	function saveGroupList($groups = null)
	{
		global $database, $user;
		
    if ($groups === null) {
      foreach ($this->groups as $groupArr)
        $groups .= " ".$groupArr["id"];  
    }
		$database->query("delete from gft_users_group where userId='".addslashes($this->userId)."'"); 

		foreach (explode(" ", $groups) as $groupId) {
			if (!empty($groupId))
				$database->query("insert into gft_users_group (groupId, userId) values(".$groupId.", '".addslashes($this->userId)."')"); 
		}
		
		return "";
	}

	function getParams()
	{
	}

}

Controler::registerHandler("adminGroups", "display", "GroupList", null, 3);

Controler::registerHandler("editGroupList", "display", "GroupList", array("id"), 3);
Controler::registerHandler("saveGroupList", "action", "GroupList", array("id", "groups"), 3);

?>