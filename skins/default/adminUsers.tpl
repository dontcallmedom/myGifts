{include file="header.tpl" title=$strings.LANG_ADMIN_USERS_TITLE}
{include file="adminMenu.tpl"}
<h1>{$strings.LANG_ADMIN_USERS_TITLE}</h1>
<p>{$strings.LANG_ADMIN_USERS_TEXT}</p>
<table border="0">
{foreach name=listusers item=userItem from=$object->users}
    <tr><td class="bold">{$userItem.name}</td><td>{mvc_link handler="adminEditUser" method="display" id=$userItem.id getBack="1"}{$strings.LANG_EDIT}{/mvc_link} | {mvc_link handler="adminChangePassword" method="display" id=$userItem.id getBack="1"}{$strings.LANG_CHANGE_PASSWORD|lower}{/mvc_link} | {mvc_link handler="deleteUser" method="display" id=$userItem.id getBack="1"}{$strings.LANG_REMOVE}{/mvc_link}</td></tr>
{foreachelse}
    <tr><td>{$strings.LANG_EMPTY_LIST}</td></tr>
{/foreach}
</table>
{mvc_link handler="adminEditUser" method="display" getBack="1"}{$strings.LANG_ADD}{/mvc_link}
<p>&nbsp;</p>
{include file="footer.tpl"}
