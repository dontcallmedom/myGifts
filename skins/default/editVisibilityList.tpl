{include file="header.tpl" title=$strings.LANG_GIFT_RESTRICTED}
<script language="JavaScript">
{literal}
function move(from, to, list) {
	for (i=2;i<from.options.length;i++) {
		if (from.options[i].selected) {
			var opt = new Option(from.options[i].text,from.options[i].value);
			to.options[to.options.length]=opt;
			from.options[i]=null;
			i--;
		}
	}
}

function listValues(select, list) {
	list.value='';
	for (i=2;i<select.options.length;i++) {
		list.value = list.value + select.options[i].value + ' ';
	}
}

{/literal}
</script>
<h2>{$strings.LANG_GIFT_RESTRICTED|capitalize}</h2>
{mvc_form handler="saveVisibilityList" id=$object->giftId}
<table border="0">
<tr>
<td align="center"><select name="lstnonvisible" size="10">
<option value="">{$strings.LANG_GIFT_NOACCESS}</option>
<option value=""></option>
{foreach name=listvisibilities item=user from=$object->users}
{if $user.isVisible == 0}
<option value="{$user.id}">{$user.name}</option>
{/if}
{/foreach}
</select></td>
<td><input type="button" value=">>" onclick="move(lstnonvisible, lstvisible); listValues(lstvisible, visible);"><br><input type="button" name="delSrv" value="<<"  onclick="move(lstvisible, lstnonvisible); listValues(lstvisible, visible);"></td>
<td align="center"><select name="lstvisible" size="10">
<option value="">{$strings.LANG_GIFT_ACCESS}</option>
<option value=""></option>
{foreach name=listvisibilities item=user from=$object->users}
{if $user.isVisible == 1}
<option value="{$user.id}">{$user.name}</option>
{/if}
{/foreach}
</select></td>
</tr>
<tr><td colspan="3" align="center"><input type="submit" value="{$strings.LANG_SAVE}" /></td></tr>
</table>
<input type="hidden" name="visible" value="{foreach name=listvisibilities item=user from=$object->users}{if $user.isVisible == 1}{$user.id} {/if}{/foreach}">
{/mvc_form}
{include file="footer.tpl"}
