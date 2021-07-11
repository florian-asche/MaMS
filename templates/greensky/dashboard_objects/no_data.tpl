<table class="object" bgcolor="{$objekt.objects.configuration.backgroundcolor}">
    <tr>
        <td class="object_header" colspan="3">
            {$objekt.page_objects.x}.{$objekt.page_objects.y} {$objekt.objects.name}
        </td>
    </tr>
    <tr>
        <td colspan="3" class="object_content">
            <div class="object_message" id="{$objekt.page_objects.ID}__messagebefore"></div>
            
            <div class="object_data">
                NO DATA
                <br>
                ID={$objekt.objects.ID}
            </div>
            
            <div class="object_message" id="{$objekt.page_objects.ID}__messageafter"></div>

            {*include file="templates/{$selected_template}/time.tpl"*}
        </td>
    </tr>
</table>