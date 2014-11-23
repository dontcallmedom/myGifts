{include file="header.tpl" title=$strings.LANG_ADMIN_SETUP_TITLE}
{include file="adminMenu.tpl"}
<h1>{$strings.LANG_ADMIN_SETUP_TITLE}</h1>
<p>{$strings.LANG_ADMIN_SETUP_TEXT}</p>
{mvc_form handler="saveSetup"}
<h2>{$strings.LANG_ADMIN_SETUP_CURRENCY}</h2>
{$strings.LANG_ADMIN_SETUP_CURRENCY_TEXT} : <input type="text" name="currency" size="3" value="{$setup.currency}" />
<h2>{$strings.LANG_ADMIN_SETUP_SELFREGISTRATION}</h2>
<input type="radio" name="selfRegistration" value="0" {if !$setup.selfRegistration}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SELFREGISTRATION_NO}</input>
<br />
<input type="radio" name="selfRegistration" value="1" {if $setup.selfRegistration}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SELFREGISTRATION_YES}</input>
<h2>{$strings.LANG_ADMIN_SETUP_DISPLAYCLAIMERIFOWNER}</h2>
<input type="radio" name="displayClaimerIfOwner" value="0" {if !$setup.displayClaimerIfOwner}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_DISPLAYCLAIMERIFOWNER_NO}</input>
<br />
<input type="radio" name="displayClaimerIfOwner" value="1" {if $setup.displayClaimerIfOwner}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_DISPLAYCLAIMERIFOWNER_YES}</input>
<h2>{$strings.LANG_ADMIN_SETUP_DONTDISPLAYCLAIMERNAME}</h2>
<input type="radio" name="dontDisplayClaimerName" value="0" {if !$setup.dontDisplayClaimerName}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_DONTDISPLAYCLAIMERNAME_NO}</input>
<br />
<input type="radio" name="dontDisplayClaimerName" value="1" {if $setup.dontDisplayClaimerName}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_DONTDISPLAYCLAIMERNAME_YES}</input>
<h2>{$strings.LANG_ADMIN_SETUP_SEEPROPOSITIONS}</h2>
<input type="radio" name="seePropositions" value="0" {if !$setup.seePropositions}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SEEPROPOSITIONS_NO}</input>
<br />
<input type="radio" name="seePropositions" value="1" {if $setup.seePropositions}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SEEPROPOSITIONS_YES}</input>
<h2>{$strings.LANG_ADMIN_SETUP_EMAILS}</h2>
<input type="checkbox" name="emailMandatory" value="1" {if $setup.emailMandatory}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_EMAIL_MANDATORY}</input>
<br />
<input type="checkbox" name="emailExtCheck" value="1" {if $setup.emailExtCheck}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_EMAIL_EXTCHECK}</input>
<h2>{$strings.LANG_ADMIN_SETUP_ALERTS}</h2>
<p>{$strings.LANG_ADMIN_SETUP_ALERTS_TEXT}</p>
<input type="checkbox" name="sendAlertUpdate" value="1" {if $setup.sendAlertUpdate}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SENDALERTUPDATE}</input>
<br />
<!--<input type="checkbox" name="sendAlertEmpty" value="1" {if $setup.sendAlertEmpty}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SENDALERTEMPTY}</input>
<br />
<input type="checkbox" name="sendAlertClaim" value="1" {if $setup.sendAlertClaim}checked="checked"{/if}> {$strings.LANG_ADMIN_SETUP_SENDALERTCLAIM}</input>
<br />-->
<br />
<input type="submit" value="{$strings.LANG_SAVE}" />
{/mvc_form}
<p>&nbsp;</p>
{include file="footer.tpl"}
