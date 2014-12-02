<h2>{$strings.LANG_GROUPS|capitalize}</h2>
<table border="0">
<tr>
<td>
<ul>
{foreach name=listgroups item=group from=$object->groups}
<li><label for="group-{$group.id}"><input type="checkbox" name="groups[]" id="group-{$group.id}" value="{$group.id}"
{if $group.isVisible == 1}
 checked="checked"
{/if}
>{$group.name}</label></li>
{/foreach}
</td>
</tr>
</table>


