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
<link rel="stylesheet" type="text/css" href="lib/jquery.gridster.min.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-1.11.0.css">
<link rel="stylesheet" type="text/css" href="lib/jquery-ui-slider-pips-1.5.5.css">
<title>Measurement and Management System - Smart Home - Setup</title>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="pragma" content="no-cache">

<body>
<script type="text/javascript" src="lib/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="lib/jquery.gridster.dustmoo.js"></script>
<script type="text/javascript" src="lib/jquery-ui-1.11.0.min.js"></script>
<script type="text/javascript" src="lib/jquery-ui-slider-pips-1.5.5.min.js"></script>
<script type="text/javascript" src="lib/mams.js"></script>
<script type="text/javascript" src="lib/wz_tooltip.js"></script>
</body>

<div id="notify" class="notifyInfo"><span id="notify_body">&nbsp;</span></div>

<div class="mams_content">
    <div class="header" align="center">
        <a class="headertext">Measurement and Management System - Smart Home - Setup</a>
    </div>

    <div class="navigation">
        {foreach $menu as $menuentry}
            {if {$menuentry} == {$page}}
            <a href="setup.php?page={$menuentry}" class="menuobject-selected">{$menuentry}</a>
            {else}
            <a href="setup.php?page={$menuentry}" class="menuobject">{$menuentry}</a>
            {/if}
        {/foreach}

        <div class="menurechts">
            <a href="http://mams.florian-asche.de" class="menuobject">Dokumentation</a>
            <a href="setup/index.php" class="menuobject">Setup</a>
        </div>
    </div>

    <div class="content">
        <h1>{$page}</h1>
        <h2>Seite bearbeiten mit der ID {$set_id}</h2>
        <table border="0">
            <form action="setup.php?page=Objects&action=page_edit_submit" method="POST">
                <tr>
                    <td>
                        {#name#}
                    </td>
                    <td>
                         <input type="text" size="50%" id="page_name" name="page_name" value="{$pagedata.name|escape}" />
                    </td>
                </tr>

                <tr>
                    <td>
                        {#active_discription#}
                    </td>
                    <td>
                        <select name="page_active" id="page_active" style="width:100%">
                            {if {$pagedata.active} == "0"}
                            <option value='0' selected='selected'>{#inactive#}</option>
                            <option value='1'>{#active#}</option>
                            {else}
                            <option value='0'>{#inactive#}</option>
                            <option value='1' selected='selected'>{#active#}</option>
                            {/if}
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td align="right">
                        <input type="hidden" name="ID" value="{$pagedata.ID}">

                        <br>
                        <label for="submit">&nbsp;</label>
                        <input type="submit" id="submit" name="submit" value="{#savebutton#}" class="button" />
                        </form>
                        
                        <br><br>
                        <form action="setup.php?page=Objects&action=page_delete&set_id={$pagedata.ID}" method="POST">
                            <label for="submit">&nbsp;</label>
                            <input onclick='return confirmSubmit();' type="submit" id="submit" name="submit" value="{#delete#}" class="button" />
                        </form>
                    </td>
                </tr>
        </table>
        <br>
    </div>
    
    <div class="copyright" align="center">
    Copyright &copy by <a href='http://www.florian-asche.de/'>Florian Asche</a>
    <br><FONT SIZE=1pt><FONT COLOR='#20B07F'>
    Seite in <b>{$ladezeit} Sekunden generiert</b></FONT></FONT>
    </div>
</div>
</tbody>
</html>
