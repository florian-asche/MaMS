<table class="object" bgcolor="{#backgroundcolor#}">
    <tr>
        <td class="object_header" colspan="3">
            <a class="object_header_text" href='api.php?action=get_mouseover&pageobjectid={$objekt.ID}' onmouseover="Tip(TooltipTxt('{$objekt.ID}'))" onmouseout="UnTip()">{$objekt.x}.{$objekt.y} {$objekt.name}</a>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="object_content">
            <div class="object_message" id="{$objekt.ID}__message"></div>
            <div class="object_data">
                {if {$objektdata.wert1} == "0"}
                    OFF
                {elseif {$objektdata.wert1} == "1"}
                    ON
                {else}
                    ERROR
                {/if}
            </div>
            <div class="object_message" id="{$objekt.ID}__messageafter"></div>

            {include file="templates/time.tpl"}

            {include file="templates/control_panels/default.tpl"}
        </td>
    </tr>
</table>