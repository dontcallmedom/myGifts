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
<h2>{$strings.LANG_GROUPS|capitalize}</h2>
<table border="0">
<tr>
<td align="center"><select name="lstnongroups" size="10">
<option value="">{$strings.LANG_GROUPS_NOACCESS}</option>
<option value=""></option>
{foreach name=listgroups item=group from=$object->groups}
{if $group.isVisible == 0}
<option value="{$group.id}">{$group.name}</option>
{/if}
{/foreach}
</select></td>
<td><input type="button" value=">>" onclick="move(lstnongroups, lstgroups); listValues(lstgroups, groups);"><br><input type="button" name="delSrv" value="<<"  onclick="move(lstgroups, lstnongroups); listValues(lstgroups, groups);"></td>
<td align="center"><select name="lstgroups" size="10">
<option value="">{$strings.LANG_GROUPS_ACCESS}</option>
<option value=""></option>
{foreach name=listgroups item=group from=$object->groups}
{if $group.isVisible == 1}
<option value="{$group.id}">{$group.name}</option>
{/if}
{/foreach}
</select></td>
</tr>
</table>
<input type="hidden" name="groups" value="{foreach name=listgroups item=group from=$object->groups}{if $group.isVisible == 1}{$group.id} {/if}{/foreach}">

