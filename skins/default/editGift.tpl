{literal}
<script type="text/javascript">
function updatePicture(url) {
	var pict = document.giftImg;
	if (url != "")
		pict.src = url;
	else
		pict.src = "skins/default/static/noimg.gif";
}
{/literal}
</script>
{mvc_form handler="saveGift" method="action" id=$object->id}
<input type="hidden" name="forUser" value="{$smarty.get.forUser}" />
<table border="0">
<tr><td align="right">{$strings.LANG_GIFT}&nbsp;: </td><td><input type="text" size="32" maxlength="255" name="name" value="{$object->name|escape:"html"}" /></td><td rowspan="9" valign="top"><img name="giftImg" src="{if $object->picture}{$object->picture}{else}skins/default/static/noimg.gif{/if}" alt="" border="1" height="160" /></td></tr>
<tr><td align="right">{$strings.LANG_CATEGORY}&nbsp;: </td><td>{displayBlock name="editCategory" id=$object->category}</td></tr>
<tr valign="top"><td align="right">{$strings.LANG_GIFT_COMMENT}&nbsp;: </td><td><textarea rows="5" cols="32" name="comment" />{$object->comment}</textarea></td></tr>
<tr><td align="right">{$strings.LANG_GIFT_URL}&nbsp;: </td><td><input type="text" size="32" maxlength="255" name="url" value="{$object->url}" /></td></tr>
<tr><td align="right">{$strings.LANG_GIFT_PICTURE}&nbsp;: </td><td><input type="text" size="32" maxlength="255" name="picture" value="{$object->picture}" onChange="updatePicture(this.value)" /></td></tr>
<tr><td align="right">{$strings.LANG_GIFT_PRICE}&nbsp;: {$setup.currency}</td><td><input type="float" size="7" name="price" value="{$object->price}" /></td></tr>
<tr><td align="right">{$strings.LANG_GIFT_PRIORITY}</td><td>
<input type="radio" name="priority" value="0" {if $object->priority == 0}checked="checked"{/if} /><img src="skins/default/static/0.gif" />
<input type="radio" name="priority" value="1" {if $object->priority == 1}checked="checked"{/if} /><img src="skins/default/static/1.gif" />
<input type="radio" name="priority" value="2" {if $object->priority == 2}checked="checked"{/if} /><img src="skins/default/static/2.gif" />
<input type="radio" name="priority" value="3" {if $object->priority == 3}checked="checked"{/if} /><img src="skins/default/static/3.gif" />
</td></tr>
{if $smarty.get.forUser == $user->id}<tr><td colspan="2" align="center"><input type="checkbox" name="restricted" {if $object->restricted == 1}checked="checked"{/if} />{$strings.LANG_GIFT_RESTRICTED}</td></tr>{/if}
<!--{if $object->id ne ""}
<tr><td colspan="2" align="center"><input type="checkbox" name="offered" {if $object->offered == 1}checked="checked"{/if} />{$strings.LANG_GIFT_OFFERED}</td></tr>
<tr><td align="right">{$strings.LANG_GIFT_OFFERED_ON} : </td><td><input type="text" size="32" maxlength="63" name="offeredOn" value="{$object->offeredOn}" /></td></tr>
{/if}-->
<tr><td colspan="2" align="center">
{if $object->id eq ""}
<input type="submit" value="{$strings.LANG_ADD}" />
{else}
<input type="submit" value="{$strings.LANG_SAVE}" />
{/if}
</td></tr>
</table>
{/mvc_form}
