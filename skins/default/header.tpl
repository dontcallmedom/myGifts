<html>
<head><title>{$title|capitalize}</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link rel="stylesheet" href="skins/default/static/style.css" />
<script type="text/javascript" src="static/common.js"></script>
<script type="text/javascript" src="static/async.js"></script>
</head>
<body class="background">
<table border="0" width="80%" align="center" cellpadding="5">
<tr valign="top"><td nowrap="nowrap" width="15%">
{if $user->name != ""}
<p class="bold">{$strings.LANG_WELCOME} {$user->name} !</p>
<p>{mvc_link}{$strings.LANG_HOME}{/mvc_link}</p>
<p>
{mvc_link handler="editProfile"}{$strings.LANG_EDIT_PROFILE}{/mvc_link}<br />
{mvc_link handler="changePassword" getBack="1"}{$strings.LANG_CHANGE_PASSWORD}{/mvc_link}</p>
<p>{mvc_link handler="logout" method="action"}{$strings.LANG_LOGOUT}{/mvc_link}
{else}
{mvc_link}{$strings.LANG_HOME}{/mvc_link}
{/if}
{if $user->accessLevel == 3}
</p><p>
{mvc_link handler="adminUsers"}{$strings.LANG_ADMIN}{/mvc_link}
{/if}
</p>
<p>&nbsp;</p>
{if $user->name != "" && $setup.installType != "registry"}
{displayBlock name="birthdayList" id="birthday"}
{/if}
</td>
<td class="tbl" width="85%">
