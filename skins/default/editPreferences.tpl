{include file="header.tpl" title="$strings.LANG_LOGIN|capitalize"}
<h2>{$strings.LANG_CHANGE_PASSWORD|capitalize}</h2>

{mvc_form handler="changePassword" method="action"}
<table border="0">
<tr><td align="right">{$strings.LANG_NEW_PASSWORD} : </td><td><input type="password" size="32 maxlength="32" name="password" /></td></tr>
<tr><td align="right">{$strings.LANG_NEW_PASSWORD_AGAIN} : </td><td><input type="password" size="32 maxlength="32" name="password2" /></td></tr>
<tr><td colspan="2" align="center">{if $error != ""}<span class="boldital">{$error}</span><br />{/if}<input type="submit" value="{$strings.LANG_SAVE}" /></td></tr>
{/mvc_form}

{include file="footer.tpl"}
