<p style="background-color: #FFFFFF; padding: 4px"><b>{$strings.LANG_NEXT_BIRTHDAYS}</b><br />
{foreach name=listusers item=userItem from=$object->users}
{$userItem.birthDate|date_format:$appParams.DATE_DISPLAY}&nbsp;: {$userItem.name}<br />
{/foreach}
</p>
