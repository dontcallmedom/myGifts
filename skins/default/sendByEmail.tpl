{mvc_form handler="sendByEmail" method="action"}
<h2>{$strings.LANG_SEND_TITLE}</h2>
<p class="small">{$strings.LANG_SEND_TEXT}</p>
<div align="center">
<p><input type="text" size="20" maxlength="255" name="to" /><br />
<input type="submit" value="{$strings.LANG_SEND}" /></p>
</div>
{/mvc_form}
