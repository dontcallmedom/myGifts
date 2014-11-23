{$strings.LANG_ALERT_U_TEXT|replace:"%name%":$object->listName}

{$strings.LANG_EMAIL_LINK} :
{mvc_link handler="giftList" id=$object->list absolute="1" nohtml="1"}{/mvc_link}
