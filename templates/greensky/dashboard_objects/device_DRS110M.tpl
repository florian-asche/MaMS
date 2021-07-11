<table class="object" bgcolor="{$objekt.objects.configuration.backgroundcolor}">
    <tr>
        <td class="object_header" colspan="3">
            <a class="object_header_text" href='api.php?action=get_mouseover&pageobjectid={$objekt.page_objects.ID}' onmouseover="Tip(TooltipTxt('{$objekt.page_objects.ID}'))" onmouseout="UnTip()">{$objekt.page_objects.x}.{$objekt.page_objects.y} {$objekt.objects.name}</a>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="object_content">
            <div class="object_message" id="{$objekt.page_objects.ID}__messagebefore"></div>
            
            <div class="object_data">
                {$objektdata.resolved_data.power}{$default_configuration.datatypes.power.unit}
                <br>
                {$objektdata.resolved_data.active_power}{$default_configuration.datatypes.active_power.unit}
            </div>
            
            <div class="object_message" id="{$objekt.page_objects.ID}__messageafter"></div>

            {include file="templates/{$selected_template}/time.tpl"}
        </td>
    </tr>
</table>