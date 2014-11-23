{include file="header.tpl" title=$strings.LANG_ADMIN_USERS_TITLE}
<h1>{$strings.LANG_ADMIN_USERS_TITLE}</h1>
{mvc_form handler="deleteUser" method="action" id=$object->id}
{$object->name|string_format:$strings.LANG_ADMIN_CONFIRM_USER_DELETE}
<p align="center"><input type="submit" value="{$strings.LANG_YES}" /> <input type="reset" value="{$strings.LANG_NO}" onClick="javascript:window.history.back();"/></p>
{/mvc_form}
{include file="footer.tpl"}
