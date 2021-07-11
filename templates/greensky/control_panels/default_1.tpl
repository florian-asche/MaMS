</td></tr>
<tr align="center">

{*ON*}
<td class="object_control_panel">
<form id="{$objekt.station_protocols_ID}btn2" onsubmit="SubmitRequest('{$objekt.station_protocols_ID}btn2', '{$objekt.objectid}');">
<input type="hidden" id="action_wert1" name="action_wert1" value="100">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols_ID}">
<input type="hidden" id="action" name="action" value="set_actor">
<input type="button" value="ON" onClick="SubmitRequest('{$objekt.station_protocols_ID}btn2', '{$objekt.objectid}');">
</form>
</td>

{*INPUTFELD*}
<td class="object_control_panel">
<form onkeypress="return event.keyCode != 13;" id="{$objekt.station_protocols_ID}btn1" onsubmit="SubmitRequest('{$objekt.station_protocols_ID}btn1', '{$objekt.objectid}');">
<input type="text" size="1px" id="action_wert1" name="action_wert1" value="" onkeyup="if(event.keyCode==13) SubmitRequest('{$objekt.station_protocols_ID}btn1', '{$objekt.objectid}');">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols_ID}">
<input type="hidden" id="action" name="action" value="set_actor">
<input type="button" value="X" onkeyup="SubmitRequest('{$objekt.station_protocols_ID}btn1', '{$objekt.objectid}');" onClick="SubmitRequest('{$objekt.station_protocols_ID}btn1', '{$objekt.objectid}');">
</form>
</td>

            
{*OFF*}
<td class="object_control_panel">
<form id="{$objekt.station_protocols_ID}btn3" onsubmit="SubmitRequest('{$objekt.station_protocols_ID}btn3', '{$objekt.objectid}');">
<input type="hidden" id="action_wert1" name="action_wert1" value="0">
<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols_ID}">
<input type="hidden" id="action" name="action" value="set_actor">
<input type="button" value="OFF" onClick="SubmitRequest('{$objekt.station_protocols_ID}btn3', '{$objekt.objectid}');">
</form>

</td></tr>
<tr>
    
<td colspan="3" class="object_control_panel">


<div id="slider_{$objekt.objectid}"></div>
<p id="para_{$objekt.objectid}"></p>
    
    
<script type="text/javascript" id="code">
// First of all attach a slider to an element.
$('#slider_{$objekt.objectid}').slider({
    value: {$objektdata.wert1},
    min: 0,
    max: 100,
    
    slide: function (event, ui) {
        $("#para_{$objekt.objectid}").text(ui.value);
    },

    change: function (event, ui) {
        SubmitData('{$objekt.station_protocols_ID}', ui.value);
    }
});


// And finally can add floaty numbers (if desired)  
$('#slider_{$objekt.objectid}').slider('float', {  
    handle: true,

});

</script>
</td>