{include file="header.tpl" title=$strings.LANG_ADMIN_GROUPS_TITLE}
{include file="adminMenu.tpl"}
<h1>{$strings.LANG_ADMIN_CATEGORIES_TITLE}</h1>
<p>{$strings.LANG_ADMIN_CATEGORIES_TEXT}</p>
<table border="0">
{foreach name=listcategories item=category from=$object->categories}
    <tr><td class="bold">{$category.category}</td><td>{mvc_link handler="adminEditCategory" method="display" id=$category.id getBack="1"}{$strings.LANG_EDIT}{/mvc_link}{if $category.id > 1} | {mvc_link handler="deleteCategory" method="action" id=$category.id getBack="1"}{$strings.LANG_REMOVE}{/mvc_link}{/if}</td></tr>
{foreachelse}
    <tr><td>{$strings.LANG_EMPTY_LIST}</td></tr>
{/foreach}
</table>
{mvc_link handler="adminEditCategory" method="display" getBack="1"}{$strings.LANG_ADD}{/mvc_link}
<p>&nbsp;</p>
{include file="footer.tpl"}
