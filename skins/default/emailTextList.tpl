{$strings.LANG_EMAIL_TEXT}

{foreach name=list item=gift from=$object->gifts}
- {$gift.name}
{if $gift.comment != ""}
  {$gift.comment}
{/if}

{/foreach}

{$strings.LANG_EMAIL_LINK} :
{mvc_link handler="giftList" id=$user->id absolute="1" nohtml="1"}{/mvc_link}
