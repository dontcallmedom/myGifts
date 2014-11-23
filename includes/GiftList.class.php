<?php

class GiftList {

	var $listId;
	var $gifts;
	var $ownerName;
	
	function GiftList($listId)
	{
		global $database, $user;
		
		if (empty($listId))
			$listId = $user->id;
			
		$this->listId = $listId;
		$sqlQuery = 	"SELECT g.*, u.id as claimerId, u.name as claimerName, o.name as ownerName  FROM gft_gift g
						 LEFT OUTER JOIN gft_user o ON g.owner=o.id
						 LEFT OUTER JOIN gft_claim c ON c.giftId=g.id 
						 LEFT OUTER JOIN gft_user u ON c.userId=u.id ";
		$whereClause =	"WHERE forUser ='".addslashes($listId)."' ";
		if ($listId != $user->id) {
			$sqlQuery .= "LEFT OUTER JOIN gft_visibility v ON (v.giftId=g.id AND v.userId = '".addslashes($user->id)."') ";
			$whereClause .= "AND (restricted = 0 OR v.userId is not null) ";
		}
		$whereClause .= "ORDER BY offered, offeredOn, g.name";

		$this->gifts = $database->fetch($sqlQuery.$whereClause);
		$database->loadObject($this, "select name as ownerName from gft_user where id='".addslashes($listId)."'");
	}

  function numFree() {
    $numFree = 0;
    foreach ($this->gifts as $giftArr) {
      if (empty($giftArr["claimerId"]))
        $numFree++;
    }
    return $numFree;
  }
  	
	function sendByEmail($to, $format = "")
	{
		global $user, $strings;
		
		//ob_start();
 		$message = Controler::processTemplate("emailTextList", $user, $this);
 		//$message = ob_get_contents();
		//ob_end_clean();		
		$result = $user->sendMail($to, $strings["LANG_EMAIL_SUBJECT"], $message, "X-Mailer: myGifts/PHP");
		//echo "$message";
		return $result; 
	}
	
	function getParams()
	{
	}
}

Controler::registerHandler("giftList", "display", "GiftList", array("id"));
Controler::registerHandler("myList", "display", "GiftList", array("user"), 1);
Controler::registerHandler("sendByEmail", "all", "GiftList", array("user", "to"));

?>