{mvc_form handler="monitorList" method="action" id=$object->list}
<h2>{$strings.LANG_MONITOR_TITLE}</h2>
<p class="small"><input type="checkbox" value="1" name="monitor" onClick="sendRequest(this.form, 'monitorList', new Array('id', 'monitor'), 'monitorMsg')" {if $object->actif}checked="checked"{/if}/> {$strings.LANG_MONITOR_TEXT} <div id="monitorMsg"></div></p>
</div>
{/mvc_form}
