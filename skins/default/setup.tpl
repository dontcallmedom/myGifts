{include file="header.tpl" title=$strings.LANG_SETUP}

<h2>{$strings.LANG_SETUP}</h2>
<form action="setup.php" method="post">
<h3>{$strings.LANG_SETUP_LANGUAGE}</h3>
<p>{$strings.LANG_SETUP_LANGUAGE_TEXT}</p>
<table border="0">
<tr><td align="right">{$strings.LANG_SETUP_LANGUAGE} : </td><td><select name="language"><option value="en">English</option><option value="fr">Francais</option><option value="de">Deutsch</option></select></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="{$strings.LANG_SAVE}" /></td></tr>
</table>
</form>

{include file="footer.tpl"}
