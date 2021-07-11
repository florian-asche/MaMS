</td></tr>
<tr align="center">

{*COLORPICKER*}






<td class="object_control_panel">
<form id="{$objekt.station_protocols.ID}colorpicker1">
<input id="someInput" name="someInput" class="colorpicker" value="rgb({$objektdata.resolved_data.r}, {$objektdata.resolved_data.g}, {$objektdata.resolved_data.b})" />
<input type="hidden" id="mode" name="mode" value="raw">
<input type="hidden" id="r" name="r" value="">
<input type="hidden" id="g" name="g" value="">
<input type="hidden" id="b" name="b" value="">
<input type="hidden" id="ww" name="ww" value="0">
<input type="hidden" id="cw" name="cw" value="0">
<input type="hidden" id="cw" name="cmd" value="fade">
<input type="hidden" id="t" name="t" value="600">
<input type="hidden" id="q" name="q" value="0">

<input type="hidden" id="station_protocols_ID" name="station_protocols_ID" value="{$objekt.station_protocols.ID}">
<input type="hidden" id="function" name="function" value="send_data">
<input type="hidden" id="function" name="priority" value="10">
</form>
</td>


</td></tr>


<script type="text/javascript">
{literal}
    
    var $colors = $('input.colorpicker').colorPicker({
            customBG: '#222',
            readOnly: true,
            init: function(elm, colors) { // colors is a different instance (not connected to colorPicker)
                elm.style.backgroundColor = elm.value;
                elm.style.color = colors.rgbaMixCustom.luminance > 0.22 ? '#222' : '#ddd';
            }
        }).each(function(idx, elm) {
        //$(elm).css({'background-color': this.value})
        });
{/literal}
</script>