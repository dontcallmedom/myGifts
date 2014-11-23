{include file="header.tpl" title=$strings.LANG_SETUP}

<h2>{$strings.LANG_SETUP}</h2>
<form action="setup.php" method="post">
<input type="hidden" name="language" value="{$language}" />
<h3>{$strings.LANG_SETUP_DATABASE}</h3>
<p>{$strings.LANG_SETUP_DATABASE_TEXT}</p>
<table border="0">
{if version_compare(phpversion(), "5.0.0", ">=")}
<tr><td align="right">{$strings.LANG_SETUP_DBTYPE} : </td><td><select name="dbtype"><option value="mysql">mySQL</option><option value="sqlite">SQLite</option></select></td></tr>
<tr><td colspan="2" align="center"><i>{$strings.LANG_SETUP_DBTYPE_HELP}</i></td></tr>
{else}
<tr><td align="right">{$strings.LANG_SETUP_DBTYPE} : </td><td>mySQL</td></tr>
<input type="hidden" name="dbtype" value="mysql">
{/if}
<tr><td align="right">{$strings.LANG_SETUP_DBSERVER} : </td><td><input type="text" size="20" maxlength="32" name="dbserver" value="{$dbserver}" /></td></tr>
<tr><td align="right">{$strings.LANG_SETUP_DBUSER} : </td><td><input type="text" size="20" maxlength="32" name="dbuser" value="{$dbuser}" /></td></tr>
<tr><td align="right">{$strings.LANG_SETUP_DBPASSWORD} : </td><td><input type="text" size="20" maxlength="32" name="dbpassword" value="{$dbpassword}" /></td></tr>
<tr><td align="right">{$strings.LANG_SETUP_DBDATABASE} : </td><td><input type="text" size="20" maxlength="32" name="dbdatabase" value="{$dbdatabase}" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="{$strings.LANG_SAVE}" /></td></tr>
<tr><td colspan="2" align="center"><i>{$text}</i></td></tr>
</table>
</form>

{include file="footer.tpl"}
