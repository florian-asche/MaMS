<SCRIPT LANGUAGE="JavaScript">
    var BaseURL = "module/sidebar/2-webcam/";
    var File = "webcam.jpg";
    var theTimer = setTimeout("reloadImage()",1);
    
    function reloadImage() {
        theDate = new Date();
        var url = BaseURL;
        url += File;
        url += "&dummy=";
        url += theDate.getTime().toString(10);
        document.theImage.src = url;
        theTimer = setTimeout("reloadImage()",'50000');
        //alert("RELOAD");
    }
</SCRIPT>

<table class="object" bgcolor="{#backgroundcolor#}">
    <tr>
        <td class="object_header" colspan="3">
            {$objekt.x}.{$objekt.y} {$objekt.name}
        </td>
    </tr>
    <tr>
        <td colspan="3" class="object_content">
            <div class="object_message" id="{$objekt.ID}__message"></div>
            
            <div class="object_data">
                <img name="theImage" src="" width="290" height="220" align="center" alt="Bild nicht gefunden!">
            </div>
            
            <div class="object_message" id="{$objekt.ID}__messageafter"></div>
            
            {* {include file="templates/time.tpl"} *}
            
            {if {$objekt.controlpanel}}
                {include file="templates/controlpanels/{$objekt.controlpanel}.tpl"}
            {/if}
        </td>
    </tr>
</table>