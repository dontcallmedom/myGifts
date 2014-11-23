<select name="category">
{foreach name=categories item=category from=$object->categories}
<option value="{$category.id}" {if $object->selected == $category.id}selected="selected"{/if}>{$category.category}</option>
{/foreach}
</select>