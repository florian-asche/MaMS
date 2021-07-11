<html>
<tbody>
<meta name="author" content="Florian Asche">
<link rel="shortcut icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="icon" href="lib/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="lib/mams.css">
<link rel="stylesheet" type="text/css" href="lib/jquery.gridster.min.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-1.11.0.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-slider-pips-1.5.5.css">
<title>Measurement and Management System - Smart Home</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="pragma" content="no-cache">

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/jquery.gridster.dustmoo.js"></script>
<script type="text/javascript" src="lib/jquery-ui-1.11.0.min.js"></script>
<script type="text/javascript" src="lib/jquery-ui-slider-pips-1.5.5.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>

<script type="text/javascript" src="lib/colorPicker/colors.js"></script>
<script type="text/javascript" src="lib/colorPicker/colorPicker.data.js"></script>
<script type="text/javascript" src="lib/colorPicker/colorPicker.js"></script>
<script type="text/javascript" src="lib/colorPicker/jQuery_implementation/jqColor.js"></script>

</body>

<div id="notify" class="notifyInfo"><span id="notify_body">&nbsp;</span></div>

<div class="mams_content">
    <div class="header" align="center">
        <a class="headertext">Measurement and Management System - Smart Home</a>
    </div>

    <div class="navigation">
        {foreach $pages as $menuentry}
            {if {$menuentry.active} == "1"}
                {if {$menuentry.ID} == {$pageid}}
                <a href="index.php?pageid={$menuentry.ID}" class="menuobject-selected">{$menuentry.name}</a>
                {else}
                <a href="index.php?pageid={$menuentry.ID}" class="menuobject">{$menuentry.name}</a>
                {/if}
            {/if}
        {/foreach}

        <a href="maximal-ausgabe.php" class="menuobject">OLD</a>

        <div class="menurechts">
            <a href="http://mams.florian-asche.de" class="menuobject">Dokumentation</a>
            <a href="setup.php" class="menuobject">Setup</a>
        </div>
    </div>

    <div class="gridster">
        <ul>
        {foreach $page_objects as $objekt}
        {if {$objekt.page_objects.pageid} == {$pageid}}
            {if {$objekt.page_objects.active} == "1"}
                <li data-row="{$objekt.page_objects.x}" data-col="{$objekt.page_objects.y}" data-sizex="{$objekt.objects.configuration.sizex}" data-sizey="{$objekt.objects.configuration.sizey}" class="gs_w">
                    <script type="text/javascript" language="javascript">
                                            // objectid, time_to_first_data_reload, reloadtime
                        updateStatusStarter('{$objekt.page_objects.ID}', '2', '15');

                    </script>
                    <div id="{$objekt.page_objects.ID}_data">Loading data...</div>
                    {*{include file="templates/objekt.tpl"}*}
                </li>
            {/if}
        {/if}
        {/foreach}
        </ul>
    </div>

    <script type="text/javascript" id="code">
        var gridster;
        $(function(){ 
                gridster = $(".gridster ul").gridster({
                widget_base_dimensions: [176, 170],
                shift_larger_widgets_down: true,
                widget_margins: [2, 2],
                extra_cols: 3,
                extra_rows: 3,
                resize: {
                    enable: false
                },
            }).data('gridster');
            gridster.disable();
        });
    </script>
    
    <div class="copyright" align="center">
    Copyright &copy by <a href='http://www.florian-asche.de/'>Florian Asche</a>
    <br><FONT SIZE=1pt><FONT COLOR='#20B07F'>
    Seite in <b>{$ladezeit} Sekunden generiert</b></FONT></FONT>
    </div>
</div>
</tbody>
</html>