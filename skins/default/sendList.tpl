{mvc_form handler="sendByEmail" method="action"}
<h2>{$strings.LANG_SEND_TITLE}</h2>
<p class="small">{$strings.LANG_SEND_TEXT}</p>
<div align="center">
<p><input type="text" size="32" maxlength="255" name="email" /><br />
<input type="submit" value="{$strings.LANG_SEND}" /></p>
</div>
{/mvc_form}
