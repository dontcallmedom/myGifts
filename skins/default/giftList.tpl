{if $smarty.get.print}
{if $object->ownerName == $user->name}
{include file="header-light.tpl" title=$strings.LANG_MY_LIST}
<h1>{$strings.LANG_MY_LIST}</h1>
{else}
{include file="header-light.tpl" title=$object->ownerName}
<h1>{$strings.LANG_LIST_OF} {$object->ownerName}</h1>
{/if}
{else}
{if $object->ownerName == $user->name}
{include file="header.tpl" title=$strings.LANG_MY_LIST}
{else}
{include file="header.tpl" title=$object->ownerName}
{/if}
{displayBlock name="userList" id="haslist"}
<div class="print">{mvc_link handler="giftList" method="display" id=$object->listId openwindow="640x400" print="1"}{$strings.LANG_PRINT}{/mvc_link}</div>
{if $object->ownerName == $user->name}
{if $user->accessLevel >= 2}
<h1>{$strings.LANG_MY_LIST}</h1>
{/if}
{else}
<h1>{$strings.LANG_LIST_OF} {$object->ownerName}</h1>
{/if}
{/if}
{if $object->ownerName != $user->name || $user->accessLevel >= 2}
<table border="1" width="100%" cellspacing="1" cellpadding="3" class="tbl">
<tr class="th"><td>{$strings.LANG_GIFT}</td><td align="center">{$strings.LANG_PRICE}</td><td align="center">{$strings.LANG_GIFT_PRIORITY}</td><td align="center">{$strings.LANG_GIFT_DETAILS|capitalize}</td>{if !$smarty.get.print}<td>{$strings.LANG_ACTIONS|capitalize}</td>{/if}</tr>
{foreach name=list item=gift from=$object->gifts}
{if !$gift.ownerName || $object->ownerName != $user->name || $gift.ownerName == $user->name || $setup.seePropositions}
    <tr valign="top">
     	<td class="col1" width="70%">{if $gift.ownerName && $gift.ownerName != $object->ownerName}<p class="bold">{$strings.LANG_PROPOSED_BY} {$gift.ownerName} :</p>{/if}<p>{if $gift.picture != ""}<img src="{$gift.picture|escape:"quotes"}" border="1" height="80" align="right">{/if}{$gift.name}<span class="small"><br />        
     	{if $gift.comment != ""}
	     	{$gift.comment|nl2br}<br />
     	{/if}
     	{if $gift.url != ""}
     		{$strings.LANG_MORE_INFO} <a href="{$gift.url|escape:"quotes"}" target="_blank">{$gift.url|urlhost}</a>
     	{/if}
     	</span></p></td>
    <td class="col2" align="center" valign="middle">{if $gift.price > 0}{$setup.currency} {$gift.price}{else}&nbsp;{/if}</td>
    <td class="col2" align="center" valign="middle">{if $gift.priority > 0}<img src="skins/default/static/{$gift.priority}.gif" />{else}&nbsp;{/if}</td>
    	<td class="col2" align="center" width="15%"><span class="smallital">
	    {if $gift.restricted == 1 && $gift.ownerName == $user->name}
				{displayBlock name="visibilityList" id=$gift.id}
		{elseif $gift.claimerName != "" && ($setup.displayClaimerIfOwner || $object->ownerName != $user->name)}
		    	{if $setup.dontDisplayClaimerName}<div id="claim_{$gift.id}">
		    		{if $gift.claimerId != $user->id}
					{$strings.LANG_CLAIMED}
				{else}
					{$strings.LANG_CLAIMED_BY} {$strings.LANG_ME}
				{/if}</div>
		    	{else}
				{$strings.LANG_CLAIMED_BY} {$gift.claimerName}
			{/if}
		{else}
			&nbsp;
		{/if}</span>
		</td>
{if !$smarty.get.print}
	    <td class="col3" align="center" width="15%" valign="middle"><span class="small">
	{if !$gift.ownerName || $gift.ownerName == $user->name}
	    {mvc_link handler="modifyGift" method="display" id=$gift.id class="link" openwindow="640x400"}{$strings.LANG_EDIT}{/mvc_link}<br />
	    {mvc_link handler="removeGift" method="action" id=$gift.id class="link" confirm=$strings.LANG_REMOVE_CONFIRM}{$strings.LANG_REMOVE}{/mvc_link}<br />
	{/if}
	{if $object->ownerName != $user->name}
		{if $gift.claimerName == ""}
			{mvc_link handler="claimGift" method="action" id=$gift.id class="link"}{$strings.LANG_CLAIM}{/mvc_link}
		{elseif $gift.claimerId == $user->id}
			{mvc_link handler="unclaimGift" method="action" id=$gift.id class="link"}{$strings.LANG_CLAIM_OFF}{/mvc_link}
		{else}
			&nbsp;
		{/if}
	{/if}
	    </span></td>
{/if}
	</tr>
{/if}
{foreachelse}
    <tr><td colspan="5">{$strings.LANG_EMPTY_LIST}</td></tr>
{/foreach}
{if !$smarty.get.print}
<tr><td colspan="5" align="right" class="col1">
	{$object->id}
	{mvc_link handler="modifyGift" method="display" id="" class="link" openwindow="640x400" forUser=$object->listId}{$strings.LANG_ADD_GIFT}{/mvc_link}
</td></tr>
{/if}
</table>
{else}
<p>{$strings.LANG_SELECT_LIST}</p>
{/if}
<p>&nbsp;</p>
{if $object->ownerName == $user->name}
 {if $user->accessLevel >= 2}
  {displayBlock name="sendByEmail"}
 {/if}
{else}
 {if $setup.sendAlertUpdate}
  {displayBlock name="monitorList"}
 {/if}
{/if}
{include file="footer.tpl"}
