{if $object->id}
{include file="header-light.tpl" title=$strings.LANG_EDIT_GIFT|capitalize}
<h1>{$strings.LANG_EDIT_GIFT|capitalize}</h1>
{else}
{include file="header-light.tpl" title=$strings.LANG_ADD_GIFT|capitalize}
<h1>{$strings.LANG_ADD_GIFT|capitalize}</h1>
{/if}
{include file="editGift.tpl"}
{include file="footer.tpl"}
