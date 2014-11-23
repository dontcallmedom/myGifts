{$strings.LANG_GIFT_RESTRICTED}
{foreach name=listvisibilities item=user from=$object->users}
{if $user.isVisible == 1}
{$user.name},
{/if}
{/foreach}
<br />{mvc_link handler="editVisibilityList" id=$gift.id}{$strings.LANG_EDIT}{/mvc_link}
