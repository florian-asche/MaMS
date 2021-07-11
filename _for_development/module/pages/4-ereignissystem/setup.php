<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("../../../configuration.php");                                         // Konfiguration Laden
include ("../../../setup/header.php");                                          // Header Laden
include ("../../../funktionen.php");                                            // Funktionen Laden
include ("../../../configuration_sensortypen.php");                             // Sensordarstellungen für die Index Seite Laden
include ("../../../setup/pages/menu.php");                                      // Menü Laden
funktion_systemlog((__FILE__));

$step = $_POST["step"];
$actionid = $_GET["actionid"];
if (preg_match('~^[0-9_]~', $actionid) != "1") {
    echo "SQL Injection Attack detected!";
    exit;
};

//if (!isset($_POST["step"])) {
//    $_POST["step"] = 1;
//    foreach ($_POST as $ide => $val) {
//        $$ide = $val;
//    };
//};

if(!isset($_POST['step']))
$_POST['step'] = 1;

// Alle Post Daten uebergeben
foreach ($_POST as $ide => $val) {
    $$ide = $val;
};

echo '<table border="0" width="100%">';
echo '<tr><td colspan="2">';
echo "<FONT SIZE=+2>Pages - Map bearbeiten<br></font><br>";   
echo '</td></tr>';
echo '<tr><td valign="top">';

if ($step == "1") {
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
	echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600">';
	echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
	echo "Allgemeine Einstellungen:";
	echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
	echo "<hr>";

	echo '<table border="0">';
	
	echo '<tr><td><label for="set_reihenfolge">Reihenfolge der Ausgabe:</label></td><td>';
        echo '<select id="" style="width:100%" name="set_reihenfolge">';
        if ($sysconfig['module_pages_datenausgabe']['reihenfolge']['wert'] == "0") {
            echo '<OPTION SELECTED VALUE="' . $sysconfig['module_pages_datenausgabe']['reihenfolge']['wert'] . '">Erst neu, dann alt</OPTION>';
            echo '<option value=1>Erst alt, dann neu</option>';
        } else {
            echo '<OPTION SELECTED VALUE="' . $sysconfig['module_pages_datenausgabe']['reihenfolge']['wert'] . '">Erst alt, dann neu</OPTION>';
            echo '<option value=0>Erst neu, dann alt</option>';
        };
        echo '</select>';
	
	echo '</td></tr></table><br>';
	echo '</td></tr></table>';
	
	echo '</td><td valign="top">';// TABELLE 2    
	echo "&nbsp;";

	echo '</td></tr><tr><td colspan="2">';
	echo '<div align="center">';
	echo '<input type="hidden" name="step" value="2">';
	echo '<label for="submit">&nbsp;</label>';
	echo '<input type="submit" id="submit" name="submit" value="Konfiguration Speichern" class="button" />';
	echo '</form><br><br>';
};

if ($step == "2") {		
    if (set_database_config("module_pages_datenausgabe","reihenfolge",$set_reihenfolge,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };	

    if ($setup_returncode != "1") {
            echo '<head><meta http-equiv="refresh" content="0;URL=' . $_SERVER['PHP_SELF'] . '?' . session_name() . '=' . session_id() . '"></head>';
    };
};

////////////////////////////////////////////////////////////////////////////////
echo '</td></tr></table>';
include ("../../../erw/ausgabe/copyright.php");
?>
<?php
} else {
  $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
  $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
  $extra = "index.php";
  header("Location: http://$host$uri/$extra");
};
?>