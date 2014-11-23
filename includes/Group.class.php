<?php

class Group {

	var $id;
	var $name;
	var $emptyObj;
  
	function Group($id = "")
	{
		global $database, $user;
		
		if (!empty($id)) {
			$this->id = (int) $id;
			$database->loadObject($this, "select * from gft_group where id=".$this->id);
		} else
      $this->emptyObj = true;
	}

	function saveGroup($name)
	{
    global $database, $user;

    if ($user->accessLevel < 3)
      return "ERROR_INSUFFICIENTPRIVILEGES";

		$name = strip_tags($name);

		if (!empty($this->id)) {
			$database->query("update gft_group set name='".addslashes($name)."' where id=".$this->id); 
		} else {
      $database->lock("gft_group");
      $id = $database->getNextId("gft_group");
			$database->query("insert into gft_group (id, name) values($id, '".addslashes($name)."')"); 
      $database->unlock("gft_group");
    }
		return 0;
	}
	
	function deleteGroup()
	{
		global $database, $user;
		
		if ($user->accessLevel < 3)
			return "ERROR_INSUFFICIENTPRIVILEGES";

		$database->query("delete from gft_group where id=".$this->id); 

		return 0;
	}

	function addUser($userId)
	{
		global $database;
		
		$database->query("insert into gft_users_group (groupId, userId) values(".$this->id.", '".addslashes($userId)."')"); 

		return 0;
	}

	function removeUser($userId)
	{
		global $database;
		
		$database->query("delete from gft_users_group where groupId=".$this->id." and userId='".addslashes($userId)."'"); 

		return 0;
	}
	
	function getParams()
	{
	}

}

Controler::registerHandler("adminEditGroup", "display", "Group", array("id"), 3);
Controler::registerHandler("saveGroup", "action", "Group", array("id", "name"), 3);
Controler::registerHandler("deleteGroup", "action", "Group", array("id"), 3);

?>