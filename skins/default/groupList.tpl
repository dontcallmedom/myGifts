{$strings.LANG_GIFT_RESTRICTED}
{foreach name=listgroups item=group from=$object->groups}
{if $group.isVisible == 1}
{$group.name},
{/if}
{/foreach}
<br />{mvc_link handler="editGroupList" id=$object->userId}{$strings.LANG_EDIT}{/mvc_link}