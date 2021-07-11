{if file_exists("templates/language/german.conf")}
    {config_load file="templates/language/german.conf"}
{else}
    Missing Languagefile: "templates/language/german.conf"
{/if}

<html>
<tbody>
<meta name="author" content="Florian Asche">
<link rel="shortcut icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="lib/mams.css">
<title>Measurement and Management System - Smart Home</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="pragma" content="no-cache">

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>
</body>

<div class="mams_content_mouseover">
<table width="100%" border="0" class="mouseover_object" bgcolor="{$objekt.objects.configuration.backgroundcolor}">
    <tr>
        <td class="object_header" colspan="3">
            <p class="object_header_text">{$objekt.page_objects.x}.{$objekt.page_objects.y} {$objekt.objects.name}</p>
        </td>
    </tr>
    <tr>
        <td valign="top">
            {foreach $objekt['objects']['configuration']['load_templates_mouseover'] as $key => $value}
                <br>
                <b>{$key}:</b>
                <br>
                {if file_exists("templates/{$selected_template}/mouseover/{$value}")}
                    {include file="templates/{$selected_template}/mouseover/{$value}"}
                {else}
                    Missing template file: templates/{$selected_template}/mouseover/{$value}
                {/if}
                <br>
            {/foreach}
        </td>
        <td>
            <b>Grafik:</b>
            <br>
            {include file="templates/{$selected_template}/graph.tpl"}
        </td>
    </tr>
</table>
</div>
</html>