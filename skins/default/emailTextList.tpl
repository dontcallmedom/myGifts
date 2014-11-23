{$strings.LANG_EMAIL_TEXT}

{foreach name=list item=category from=$object->categories}
{$category|upper}
{foreach name=catlist item=gift from=$object->gifts.$category}
- {$gift.name}
{if $gift.comment != ""}
  {$gift.comment}
{/if}

{/foreach}

{/foreach}

{$strings.LANG_EMAIL_LINK} :
{mvc_link handler="giftList" id=$user->id absolute="1" nohtml="1"}{/mvc_link}
