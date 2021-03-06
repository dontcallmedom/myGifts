<?php

class Gift {

	var $userId;
	var $id;
	var $forUser;
	var $owner;
	var $name;
	var $comment;
	var $url;
	var $restricted;
	var $picture;
	var $price;
	var $qty;
	var $emptyObj;
  
	function Gift($id = "")
	{
		global $database, $user;
		
		$this->owner = $user->id;
		if (!empty($id)) {
			$this->id = (int) $id;
			$database->loadObject($this, "select * from gft_gift where owner='".addslashes($this->owner)."' and id=".$this->id);
		} else
      $this->emptyObj = true;
	}
	
	function saveGift($forUser, $name, $comment, $url, $restricted, $offered, $offeredOn, $picture, $price, $priority, $qty)
	{
		global $database;

		$restricted = Tools::checkboxToInt($restricted);
		$offered = Tools::checkboxToInt($offered);
		$name = trim(stripslashes(strip_tags($name)));
		$comment = trim(stripslashes(strip_tags($comment)));
		$url = strtr(trim(strip_tags($url)), "\"\' ", "+++");
		$picture = strtr(trim(strip_tags($picture)), "\"\' ", "+++");
		$priority = (int) $priority;
		$price = (float) $price;
		$qty = (int) $qty;

		if (empty($forUser))
			$forUser = $this->owner;
			
		if (!empty($this->id)) {
			$database->query("update gft_gift set name='".addslashes($name)."', comment='".addslashes($comment)."', url='".addslashes($url)."', restricted=$restricted, offered=$offered, offeredOn='".addslashes($offeredOn)."', picture='".addslashes($picture)."', price=$price, priority=$priority where id=".$this->id." and owner='".addslashes($this->owner)."'"); 
		} else {
      $database->lock("gft_gift");
      $id = $database->getNextId("gft_gift");
			$database->query("insert into gft_gift (id, forUser, owner, name, comment, url, restricted, offered, offeredOn, picture, price, priority) values($id, '".addslashes($forUser)."', '".addslashes($this->owner)."', '".addslashes($name)."', '".addslashes($comment)."', '".addslashes($url)."', $restricted, $offered, '".addslashes($offeredOn)."', '".addslashes($picture)."', $price, $priority)"); 
      $database->unlock("gft_gift");
    }
		return 0;
	}
	
	function removeGift()
	{
		global $database;
		
		$database->query("delete from gft_gift where id=".$this->id." and owner='".addslashes($this->owner)."'"); 

		return 0;
	}

	function claimGift($userId)
	{
		global $database;
		
		$database->query("insert into gft_claim (giftId, userId) values(".$this->id.", '".addslashes($userId)."')"); 

		return 0;
	}

	function unclaimGift($userId)
	{
		global $database;
		
		$database->query("delete from gft_claim where giftId=".$this->id." and userId='".addslashes($userId)."'"); 

		return 0;
	}
	
	function offeredGift($offeredOn)
	{
		global $database;
		
		$database->query("delete from gft_claim where giftId=".$this->id." and userId='".addslashes($userId)."'"); 

		return 0;
	}
	
	function getParams()
	{
	}
}

Controler::registerHandler("editGift", "display", "Gift", null, 1);
Controler::registerHandler("modifyGift", "action", "Gift", array("id"), 1);
Controler::registerHandler("saveGift", "action", "Gift", array("id", "forUser", "name", "comment", "url", "restricted", "offered", "offeredOn", "picture", "price", "priority", "qty"), 1);
Controler::registerNextAction("saveGift", "close_refresh");
Controler::registerHandler("removeGift", "action", "Gift", array("id"), 1);
Controler::registerHandler("claimGift", "action", "Gift", array("id", "user"), 1);
Controler::registerHandler("unclaimGift", "action", "Gift", array("id", "user"), 1);

?>
