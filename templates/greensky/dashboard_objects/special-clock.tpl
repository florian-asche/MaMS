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
                Uhrzeit:
                <b>
                    {$smarty.now|date_format:"%H:%M:%S"}
                </b>
                <br>
                Datum: 
                <b>
                    {$smarty.now|date_format:"%d.%m.%Y"}
                </b>
            </div>
            <div class="object_message" id="{$objekt.page_objects.ID}__messageafter"></div>
        </td>
    </tr>
</table>