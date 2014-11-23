{include file="header.tpl" title=$strings.LANG_ADMIN_GROUPS_TITLE}
{include file="adminMenu.tpl"}
<h1>{if $object->id != ""}{$strings.LANG_ADMIN_GROUPS_EDIT}{else}{$strings.LANG_ADMIN_GROUPS_CREATE}{/if}</h1>
{mvc_form handler="saveGroup" method="action" id=$object->id}
<table border="0">
<tr><td align="right">{$strings.LANG_NAME} : </td><td><input type="text" size="32" maxlength="32" name="name" value="{$object->name}" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="{if $object->id != ""}{$strings.LANG_SAVE}{else}{$strings.LANG_ADD}{/if}" /></td></tr>
</table>
{/mvc_form}
{include file="footer.tpl"}
