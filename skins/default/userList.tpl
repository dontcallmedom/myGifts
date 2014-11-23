<p><b>{$strings.LANG_USER_LIST} : </b>
{if $user->accessLevel >= 2}
{mvc_link handler="myList" method="display" class="link"}{$strings.LANG_MY_LIST}{/mvc_link}
{/if}
{foreach name=listusers item=userItem from=$object->users}
{if $userItem.id != $user->id} &bull; {mvc_link handler="giftList" method="display" id=$userItem.id class="link"}{$userItem.name}{/mvc_link}{/if}
{/foreach}
</p>
