{include file="header.tpl" title=$strings.LANG_ADMIN_USERS_TITLE}
{include file="adminMenu.tpl"}
<h1>{$strings.LANG_ADMIN_USERS_TITLE}</h1>
<h2>
{if $object->id}
{$strings.LANG_ADMIN_USERS_EDIT}
{else}
{$strings.LANG_ADMIN_USERS_CREATE}
{/if}
</h2>
{include file="editUserForm.tpl"}
{include file="footer.tpl"}
