{include file="header.tpl" title=$strings.LANG_ADMIN_GROUPS_TITLE}
{include file="adminMenu.tpl"}
<h1>{$strings.LANG_ADMIN_GROUPS_TITLE}</h1>
<p>{$strings.LANG_ADMIN_GROUPS_TEXT}</p>
<table border="0">
{foreach name=listgroups item=group from=$object->groups}
    <tr><td class="bold">{$group.name}</td><td>{mvc_link handler="editGroup" method="display" id=$group.id getBack="1"}{$strings.LANG_EDIT}{/mvc_link} | {mvc_link handler="deleteGroup" method="display" id=$group.id getBack="1"}{$strings.LANG_REMOVE}{/mvc_link}</td></tr>
{foreachelse}
    <tr><td>{$strings.LANG_EMPTY_LIST}</td></tr>
{/foreach}
</table>
{mvc_link handler="editGroup" method="display" getBack="1"}{$strings.LANG_ADD}{/mvc_link}
<p>&nbsp;</p>
{include file="footer.tpl"}
