</td></tr>
<tr align="center">

{*ON*}
<td class="object_control_panel">
<form id="{$objekt.station_protocols.ID}btn2" onsubmit="FormSubmitRequest('{$objekt.station_protocols.ID}btn2', '{$objekt.page_objects.ID}');">
<input type="hidden" id="action_wert1" name="action_wert1" value="100">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols.ID}">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
<input type="button" value="ON" onClick="FormSubmitRequest('{$objekt.station_protocols.ID}btn2', '{$objekt.page_objects.ID}');">
</form>
</td>

{*INPUTFELD*}
<td class="object_control_panel">
<form onkeypress="return event.keyCode != 13;" id="{$objekt.station_protocols.ID}btn1" onsubmit="FormSubmitRequest('{$objekt.station_protocols.ID}btn1', '{$objekt.page_objects.ID}');">
<input type="text" size="1px" id="action_wert1" name="action_wert1" value="" onkeyup="if(event.keyCode==13) FormSubmitRequest('{$objekt.station_protocols.ID}btn1', '{$objekt.page_objects.ID}');">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols.ID}">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
<input type="button" value="X" onkeyup="FormSubmitRequest('{$objekt.station_protocols.ID}btn1', '{$objekt.page_objects.ID}');" onClick="FormSubmitRequest('{$objekt.station_protocols.ID}btn1', '{$objekt.page_objects.ID}');">
</form>
</td>

            
{*OFF*}
<td class="object_control_panel">
<form id="{$objekt.station_protocols.ID}btn3" onsubmit="FormSubmitRequest('{$objekt.station_protocols.ID}btn3', '{$objekt.page_objects.ID}');">
<input type="hidden" id="action_wert1" name="action_wert1" value="0">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols.ID}">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
<input type="button" value="OFF" onClick="FormSubmitRequest('{$objekt.station_protocols.ID}btn3', '{$objekt.page_objects.ID}');">
</form>

</td></tr>