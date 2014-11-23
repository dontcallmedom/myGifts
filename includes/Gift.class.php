<?php

class Gift {

	var $userId;
	var $id;
	var $forUser;
	var $owner;
	var $name;
  var $category = 1;
	var $comment;
	var $url;
	var $restricted;
	var $picture;
	var $price;
	var $qty;
	var $emptyObj;

  var $ts_creation;
  var $ts_update;
  var $new = false;
  var $recent = false;

	function Gift($id = "")
	{
		global $database, $user;

		$this->owner = $user->id;
		if (!empty($id)) {
			$this->id = (int) $id;
			$database->loadObject($this, "select *, ".$database->timestamp("created")." as ts_created, ".$database->timestamp("updated")." as ts_updated from gft_gift where owner='".addslashes($this->owner)."' and id=".$this->id);
      $curTime = time();
      if ($curTime-$this->ts_created < 4*24*3600)
        $this->new = true;
      else if ($curTime-$this->ts_updated < 4*24*3600)
        $this->recent = true;
		} else
      $this->emptyObj = true;
    if ($this->category === null)
      $this->category = 0;
	}

	function saveGift($forUser, $name, $category, $comment, $url, $restricted, $offered, $offeredOn, $picture, $price, $priority, $qty)
	{
		global $database;

		$restricted = Tools::checkboxToInt($restricted);
		$offered = Tools::checkboxToInt($offered);
		$name = trim(stripslashes(strip_tags($name)));
    $category = (int) $category;
		$comment = trim(stripslashes(strip_tags($comment)));
		$url = strtr(trim(strip_tags($url)), "\"\' ", "+++");
		$picture = strtr(trim(strip_tags($picture)), "\"\' ", "+++");
		$priority = (int) $priority;
		$price = (float) $price;
		$qty = (int) $qty;

		if (empty($forUser))
			$forUser = $this->owner;

		if (!empty($this->id)) {
			$database->query("update gft_gift set name='".addslashes($name)."', category=$category, comment='".addslashes($comment)."', url='".addslashes($url)."', restricted=$restricted, offered=$offered, offeredOn='".addslashes($offeredOn)."', picture='".addslashes($picture)."', price=$price, priority=$priority, updated=now() where id=".$this->id." and owner='".addslashes($this->owner)."'");
		} else {
      $database->lock("gft_gift");
      $id = $database->getNextId("gft_gift");
			$database->query("insert into gft_gift (id, forUser, owner, name, category, comment, url, restricted, offered, offeredOn, picture, price, priority, created) values($id, '".addslashes($forUser)."', '".addslashes($this->owner)."', '".addslashes($name)."', $category, '".addslashes($comment)."', '".addslashes($url)."', $restricted, $offered, '".addslashes($offeredOn)."', '".addslashes($picture)."', $price, $priority, now())");
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

    if (empty($userId))
      return;

		$database->query("insert into gft_claim (giftId, userId) values(".$this->id.", '".addslashes($userId)."')");

		return 0;
	}

	function unclaimGift($userId)
	{
		global $database;

    if (empty($userId))
      return;

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
Controler::registerHandler("saveGift", "action", "Gift", array("id", "forUser", "name", "category", "comment", "url", "restricted", "offered", "offeredOn", "picture", "price", "priority", "qty"), 1);
Controler::registerNextAction("saveGift", "close_refresh");
Controler::registerHandler("removeGift", "action", "Gift", array("id"), 1);
Controler::registerHandler("claimGift", "action", "Gift", array("id", "user"), 1);
Controler::registerHandler("unclaimGift", "action", "Gift", array("id", "user"), 1);

?>
