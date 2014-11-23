{include file="header.tpl" title=$strings.LANG_SETUP}

<h2>{$strings.LANG_SETUP}</h2>
<form action="setup.php" method="post">
<h3>{$strings.LANG_SETUP_INSTALLTYPE}</h3>
<p>{$strings.LANG_SETUP_INSTALLTYPE_TEXT}</p>
<p align="center"><select name="installType">
<option value="giftlist">{$strings.LANG_GIFTLIST}</option>
<option value="registry">{$strings.LANG_REGISTRY}</option>
</select></p>
<h3>{$strings.LANG_SETUP_ADMIN}</h3>
<p>{$strings.LANG_SETUP_ADMIN_TEXT}</p>
<table border="0">
<tr><td align="right">{$strings.LANG_NAME} : </td><td><input type="text" size="32" maxlength="32" name="name" value="{$name}" /></td></tr>
<tr><td align="right">{$strings.LANG_EMAIL} : </td><td><input type="text" size="32" maxlength="255" name="email" value="{$email}" /></td></tr>
<tr><td align="right">{$strings.LANG_PASSWORD} : </td><td><input type="password" size="32 maxlength="32" name="password" value="{$password}" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="{$strings.LANG_ADD}" /></td></tr>
<tr><td colspan="2" align="center"><i>{$text}</i></td></tr>
</table>
</form>

{include file="footer.tpl"}
