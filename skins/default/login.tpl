{include file="header.tpl" title=$strings.LANG_LOGIN|capitalize}
<div align="center">
<h1>{$strings.LANG_LOGIN|capitalize}</h1>
{mvc_form handler="" method="action" post="1"}
<table border="0">
<tr><td align="right">{$strings.LANG_NAME} : </td><td><input type="text" size="32" maxlength="32" name="name" value="{mvc_value name="name"}" /></td></tr>
<tr><td align="right">{$strings.LANG_PASSWORD} : </td><td><input type="password" size="32 maxlength="32" name="password" /></td></tr>
<tr><td colspan="2" align="center">{if $error != ""}<span class="boldital">{$error}</span><br />{/if}<input type="checkbox" name="rememberme" />{$strings.LANG_REMEMBERME}</td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="{$strings.LANG_LOGIN}" /></td></tr>
</table>
{/mvc_form}
{if $setup.selfRegistration}
{mvc_link handler="register"}{$strings.LANG_REGISTER_LINK}{/mvc_link}
{/if}
</div>
{include file="footer.tpl"}
