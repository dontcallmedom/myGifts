{literal}
<script type="text/javascript">
function showHideDob(level) {
	var theObj = document.getElementById("dob");
	if (theObj) {
		if (level >= 2)
			theObj.style.display='';
		else
			theObj.style.display='none';
	}
}
</script>
{/literal}
{mvc_form handler="saveUser" method="action" id=$object->id}
<table border="0">
<tr><td align="right">{$strings.LANG_NAME} : </td><td><input type="text" size="32" maxlength="32" name="name" value="{$object->name}" /></td></tr>
<!--<tr><td align="right">{$strings.LANG_REALNAME} : </td><td><input type="text" size="32" maxlength="64" name="realname" value="{$object->realname}" /></td></tr>-->
<tr><td align="right">{$strings.LANG_EMAIL} : </td><td><input type="text" size="32" maxlength="255" name="email" value="{$object->email}" /></td></tr>
{if $setup.installType != "registry" && $user->accessLevel >= 2}
<tr id="dob"><td align="right">{$strings.LANG_DATEOFBIRTH} : </td><td>{html_select_date start_year="1900" field_order=$appParams.DATE_ORDER field_array="birthDate" time=$object->birthDate}</td></tr>
{/if}
{if $object->id == ""}
<tr><td align="right">{$strings.LANG_PASSWORD} : </td><td><input type="password" size="32 maxlength="32" name="password" /></td></tr>
{/if}
{if $user->accessLevel == 3}
<tr><td align="right">{$strings.LANG_ACCESS_LEVEL} : </td><td><select name="accessLevel" onChange="showHideDob(this.options[this.selectedIndex].value)"><option value="1">{$strings.LANG_ACCESS_LOGIN}</option><option value="2" {if $object->accessLevel == 2 || empty($object->id)}selected="selected"{/if}>{$strings.LANG_ACCESS_LIST}</option><option value="3" {if $object->accessLevel == 3}selected="selected"{/if}>{$strings.LANG_ACCESS_ADMIN}</option></select></td></tr>
<tr><td colspan="2">{displayBlock name="editGroupList" id=$object->id}</td></tr>
{/if}
<tr><td colspan="2" align="center"><input type="submit" value="{if $object->id != ""}{$strings.LANG_SAVE}{else}{$strings.LANG_ADD}{/if}" /></td></tr>
</table>
<h2>{$error}</h2>
{/mvc_form}
