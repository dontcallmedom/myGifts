{include file="header.tpl" title=$strings.LANG_SETUP}

<h2>{$strings.LANG_SETUP}</h2>
<p>{$strings.LANG_SETUP_CANTWRITE}</p>
<ul>
<li>{$strings.LANG_SETUP_CHANGEPERMS}</li>
<li>{$strings.LANG_SETUP_COPYCONFIG}</li>
</ul>
<pre>{$text|escape:"html"}</pre>
<p align="center"><a href="#" onClick="document.setupform.submit();">{$strings.LANG_NEXT}</a></p>
<form action="setup.php" method="post" name="setupform">
<input type="hidden" name="language" value="{$language}" />
<input type="hidden" name="dbtype" value="{$dbtype}" />
<input type="hidden" name="dbserver" value="{$dbserver}" />
<input type="hidden" name="dbuser" value="{$dbuser}" />
<input type="hidden" name="dbpassword" value="{$dbpassword}" />
<input type="hidden" name="dbdatabase" value="{$dbdatabase}" />
</form>

{include file="footer.tpl"}
