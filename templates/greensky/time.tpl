</td></tr>
<tr>

<td class="object_time" colspan="3">
    <p align="center" >
        <font size="2">
        {if {$objektdata.timestampdiff} < "90"}
            vor {$objektdata.timestampdifftext}
        {else}
            {$objektdata.timestamp|date_format:"%d.%m.%Y"} um {$objektdata.timestamp|date_format:"%H:%M:%S"} Uhr
        {/if}
        </font>
    </p>
</td>
