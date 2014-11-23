{include file="header.tpl" title=$strings.LANG_REGISTER}
{if $setup.selfRegistration}
<h1>{$strings.LANG_REGISTER}</h1>
{assign var="nextAction" value="myList"}
{include file="editUserForm.tpl"}
{/if}
{include file="footer.tpl"}
