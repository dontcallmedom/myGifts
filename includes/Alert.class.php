<?php

class Alert {
  
  var $owner;
  var $list;
  var $listName;
  var $type;
  var $actif;
  
  function Alert($listId) {
    global $database, $user;
    if (!empty($listId)) {
      $sqlQuery = "SELECT * FROM gft_alert where list='".addslashes($listId)."' and owner='".addslashes($user->id)."'";
      $database->loadObject($this, $sqlQuery);
    }
    if (!empty($this->owner) && !empty($this->list))
      $this->actif = 1;
    else {
      $this->owner = $user->id;
      $this->list = $listId;
      $this->actif = 0;
    }
  }
  
  function saveGift($giftId, $forUser, $name) {
    if (!empty($giftId))
      return;
      
    $this->list = $forUser;
    if (Setup::getParam("sendAlertUpdate"))
      $this->sendAlerts("U");
  }
  
  function claimGift($giftId) {
    global $database, $user;
    /*if (!empty($giftId)) {
      $gift =& new Gift($giftId);
      $this->list = $gift->forUser;
    }
    if (Setup::getParam("sendAlertClaim"))
      $this->sendAlerts("C", false);
    if (Setup::getParam("sendAlertEmpty")) {
      $gl =& new GiftList($this->list);
      if ($gl->numFree() <= 1)
        $this->sendAlerts("E", false);
    }*/
  }
  
  function sendAlerts($type, $checkTime = true) {
    global $database, $user, $strings;
    
    $subject = $strings["LANG_ALERT_${type}_SUBJECT"];
    $sqlQuery = "SELECT distinct u.email, l.name, a.lastSent, a.owner FROM gft_alert a, gft_user u, gft_user l where a.list=l.id and a.owner=u.id and type='".addslashes($type)."' and list='".addslashes($this->list)."' AND u.id!='".addslashes($user->id)."'";
    $emails = $database->fetch($sqlQuery);
    if (!is_array($emails))
      return;
    $curHour = round(time()/3600);
    foreach ($emails as $emailArr) {
      if (!$checkTime || $curHour > $emailArr["lastSent"]+1) {
        if (empty($message)) {
          $this->listName = $emailArr["name"];
          $message = Controler::processTemplate("emailAlert$type", $user, $this);
        }
        $to = $emailArr["email"];
        $result = mail($to, $subject, $message, "X-Mailer: myGifts/PHP");
        //echo "<!-- mail $to : $subject / $message -->";
        $database->query("update gft_alert set lastSent=$curHour where type='".addslashes($type)."' and list='".addslashes($this->list)."' and owner='".$emailArr["owner"]."'");
      }
    }
  }
  
  function monitorList($monitor) {
    global $database, $user;

    if ($monitor && $this->actif)
      return "";
    if (!$monitor && !$this->actif)
      return "";
    
    if ($monitor)
      return $database->query("insert into gft_alert (list, owner, type) values('".addslashes($this->list)."', '".addslashes($user->id)."', 'U')");
    else
      return $database->query("delete from gft_alert where list='".addslashes($this->list)."' and owner='".addslashes($user->id)."' and type='U'");
  }
}

Controler::registerHandler("monitorList", "all", "Alert", array("id", "monitor"), 1);
Controler::registerHandler("saveGift", "action", "Alert", array("", "id", "forUser", "name"), 1);
Controler::registerHandler("claimGift", "action", "Alert", array("", "id"), 1);
?>