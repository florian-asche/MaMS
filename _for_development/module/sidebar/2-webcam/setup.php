<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("../../../configuration.php");                                         // Konfiguration Laden
include ("../../../setup/header.php");                                          // Header Laden
include ("../../../funktionen.php");                                            // Funktionen Laden
include ("../../../configuration_sensortypen.php");                             // Sensordarstellungen für die Index Seite Laden
include ("../../../setup/module/menu.php");                                     // Menü Laden
funktion_systemlog((__FILE__));

$step = $_POST["step"];
$actionid = $_GET["actionid"];

if(!isset($_POST['step']))
$_POST['step'] = 1;

// Alle Post Daten uebergeben
foreach ($_POST as $ide => $val) {
    $$ide = $val;
};

echo '<table border="0" width="100%">';
echo '<tr><td colspan="2">';
echo "<FONT SIZE=+2>Module - Sidebar - Webcam bearbeiten<br></font><br>";   
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
	
	echo '<tr><td><label for="set_aktiv">Aktiv:</label></td><td>';
	echo '<select id="set_aktiv" style="width:100%" name="set_aktiv">';
	if ($sysconfig['module_sidebar_webcam']['aktiv']['wert'] == "0") {
		echo '<option SELECTED value="0">Nein</OPTION>';
		echo '<option value=1>Ja</option>';
	} else {
		echo '<option value=0>Nein</OPTION>';
		echo '<option SELECTED value=1>Ja</option>';
	};
	echo '</select></td></tr>';
	
	echo '<tr><td><label for="set_farbe">Farbe:</label></td><td>';
	echo '<input type="text" size="53px" id="set_farbe" name="set_farbe" value="' . $sysconfig['module_sidebar_webcam']['farbe']['wert'] . '"></td></tr>';

	echo '<tr><td><label for="set_downloadpfad">Downloadpfad:</label></td><td>';
	echo '<input type="text" size="53px" id="set_downloadpfad" name="set_downloadpfad" value="' . $sysconfig['module_sidebar_webcam']['downloadpfad']['wert'] . '"></td></tr>';
	
	echo '<tr><td><label for="set_reload_method">Reload Methode:</label></td><td>';
	echo '<select id="set_reload_method" style="width:100%" name="set_reload_method">';
	if ($sysconfig['module_sidebar_webcam']['reload_method']['wert'] == "0") {
		echo '<option SELECTED value="0">Java Reload</OPTION>';
		echo '<option value=1>HTTP Meta Reload</option>';
	} else {
		echo '<option value=0>Java Reload</OPTION>';
		echo '<option SELECTED value=1>HTTP Meta Reload</option>';
	};
	echo '</select></td></tr>';
	
	echo '<tr><td><label for="set_reloadtime">Reloadintervall:</label></td><td>';
	echo '<input type="text" size="53px" id="set_reloadtime" name="set_reloadtime" value="' . $sysconfig['module_sidebar_webcam']['reloadtime']['wert'] . '"></td></tr>';
	
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
    if (set_database_config("module_sidebar_webcam","aktiv",$set_aktiv,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };

    if (set_database_config("module_sidebar_webcam","farbe",$set_farbe,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };	

    if (set_database_config("module_sidebar_webcam","downloadpfad",$set_downloadpfad,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };

    if (set_database_config("module_sidebar_webcam","reload_method",$set_reload_method,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };

    if (set_database_config("module_sidebar_webcam","reloadtime",$set_reloadtime,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut";
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