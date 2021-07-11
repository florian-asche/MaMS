<?php 
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
if(!isset($_POST['step'])) {
    $_POST['step'] = 1;
};

// Alle Post Daten uebergeben
foreach ($_POST as $ide => $val) {
    $$ide = $val;
};

include ("../configuration.php");                                         // Konfiguration Laden
include ("header.php");                                                   // Header Laden
include ("../funktionen.php");                                            // Funktionen Laden
include ("../configuration_sensortypen.php");                             // Sensordarstellungen für die Index Seite Laden
include ("menu.php");                                                     // Menü Laden

if (isset($_GET['done'])) {
    $done = $_GET['done'];
    
    if ($done == true) {
        echo '<dl id="system-message"><dd class="message message fade"><ul><li>Die Daten wurden erfolgreich geändert.</li></ul></dd></dl>';
    };  
};

//-Step 1---------------------------------------------------------------------------------
if ($step == 1) {
    echo '<table border="0">';
    echo '<tr><td colspan="2">';
    echo "<FONT SIZE=+2>Systemkonfiguration<br></font><br>";   
    echo '</td></tr>';
    echo '<tr><td valign="top">';

    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
    //echo "<FONT SIZE=+2>Systemkonfiguration<br></font><br>";

    echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600" height="auto">';
    echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
    echo "Allgemeine Einstellungen";
    echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
    echo "<hr>"; 
    echo '<table border="0" width="auto" id="table1"><tr><td width="250">';

    echo '<label for="set_timezone">Systemzeit:</label>';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_timezone">';
    echo '<option value="-12"';
    if ($sysconfig['global']['timezone']['wert'] == "-12") { echo " SELECTED"; };
    echo '>(UTC -12:00) Internationale westliche Datumsgrenze</option>';
    echo '<option value="-11"';
    if ($sysconfig['global']['timezone']['wert'] == "-12") { echo " SELECTED"; };
    echo '>(UTC -11:00) Midwayinseln, Samoa</option><option value="-10" >(UTC -10:00) Hawaii</option>';
    echo '<option value="-9.5"';
    if ($sysconfig['global']['timezone']['wert'] == "-9.5") { echo " SELECTED"; };
    echo '>(UTC -09:30) Taiohae, Marquesas-Inseln</option>';
    echo '<option value="-9"';
    if ($sysconfig['global']['timezone']['wert'] == "-9") { echo " SELECTED"; };
    echo '>(UTC -09:00) Alaska</option>';
    echo '<option value="-8"';
    if ($sysconfig['global']['timezone']['wert'] == "-8") { echo " SELECTED"; };
    echo '>(UTC -08:00) Pazifikküste (US &amp; Kanada)</option>';
    echo '<option value="-7"';
    if ($sysconfig['global']['timezone']['wert'] == "-7") { echo " SELECTED"; };
    echo '>(UTC -07:00) Mountain-Zeit (US &amp; Kanada)</option>';
    echo '<option value="-6"';
    if ($sysconfig['global']['timezone']['wert'] == "-6") { echo " SELECTED"; };
    echo '>(UTC -06:00) Zentralamerika (US &amp; Kanada), Mexiko-Stadt</option>';
    echo '<option value="-5"';
    if ($sysconfig['global']['timezone']['wert'] == "-5") { echo " SELECTED"; };
    echo '>(UTC -05:00) Ostküste (US &amp; Kanada), Bogota, Lima</option>';
    echo '<option value="-4.5"';
    if ($sysconfig['global']['timezone']['wert'] == "-4.5") { echo " SELECTED"; };
    echo '>(UTC -04:30) Venezuela</option>';
    echo '<option value="-4"';
    if ($sysconfig['global']['timezone']['wert'] == "-4") { echo " SELECTED"; };
    echo '>(UTC -04:00) Atlantikküste (Kanada), Caracas, La Paz</option>';
    echo '<option value="-3.5"';
    if ($sysconfig['global']['timezone']['wert'] == "-3.5") { echo " SELECTED"; };
    echo '>(UTC -03:30) St. Johns (Neufundland), Labrador</option>';
    echo '<option value="-3"';
    if ($sysconfig['global']['timezone']['wert'] == "-3") { echo " SELECTED"; };
    echo '>(UTC -03:00) Brasilien, Buenos Aires, Georgetown</option>';
    echo '<option value="-2"';
    if ($sysconfig['global']['timezone']['wert'] == "-2") { echo " SELECTED"; };
    echo '>(UTC -02:00) Mittelatlantik</option>';
    echo '<option value="-1"';
    if ($sysconfig['global']['timezone']['wert'] == "-1") { echo " SELECTED"; };
    echo '>(UTC -01:00) Azoren, Kapverden</option>';
    echo '<option value="0"';
    if ($sysconfig['global']['timezone']['wert'] == "0") { echo " SELECTED"; };
    echo '>(UTC 00:00) Westeuropäische Zeit, London, Lissabon, Casablanca</option>';
    echo '<option value="1"';
    if ($sysconfig['global']['timezone']['wert'] == "1") { echo " SELECTED"; };
    echo '>(UTC +01:00) Amsterdam, Berlin, Brüssel, Kopenhagen, Madrid, Paris</option>';
    echo '<option value="2"';
    if ($sysconfig['global']['timezone']['wert'] == "2") { echo " SELECTED"; };
    echo '>(UTC +02:00) Istanbul, Jerusalem, Kaliningrad, Südafrika</option>';
    echo '<option value="3"';
    if ($sysconfig['global']['timezone']['wert'] == "3") { echo " SELECTED"; };
    echo '>(UTC +03:00) Bagdad, Riad, Moskau, St. Petersburg</option>';
    echo '<option value="3.5"';
    if ($sysconfig['global']['timezone']['wert'] == "3.5") { echo " SELECTED"; };
    echo '>(UTC +03:30) Tehran</option><option value="4" >(UTC +04:00) Abu Dhabi, Maskat, Baku, Tiflis</option>';
    echo '<option value="4.5"';
    if ($sysconfig['global']['timezone']['wert'] == "4.5") { echo " SELECTED"; };
    echo '>(UTC +04:30) Kabul</option><option value="5" >(UTC +05:00) Jekaterinburg, Islamabad, Karatschi, Taschkent</option>';
    echo '<option value="5.5"';
    if ($sysconfig['global']['timezone']['wert'] == "5.5") { echo " SELECTED"; };
    echo '>(UTC +05:30) Bombay, Calcutta, Madras, New Delhi, Colombo</option>';
    echo '<option value="5.75"';
    if ($sysconfig['global']['timezone']['wert'] == "5.75") { echo " SELECTED"; };
    echo '>(UTC +05:45) Katmandu</option>';
    echo '<option value="6"';
    if ($sysconfig['global']['timezone']['wert'] == "6") { echo " SELECTED"; };
    echo '>(UTC +06:00) Almaty, Dhaka</option>';
    echo '<option value="6.3"';
    if ($sysconfig['global']['timezone']['wert'] == "6.3") { echo " SELECTED"; };
    echo '>(UTC +06:30) Yagoon</option>';
    echo '<option value="7"';
    if ($sysconfig['global']['timezone']['wert'] == "7") { echo " SELECTED"; };
    echo '>(UTC +07:00) Bangkok, Hanoi, Jakarta</option>';
    echo '<option value="8"';
    if ($sysconfig['global']['timezone']['wert'] == "8") { echo " SELECTED"; };
    echo '>(UTC +08:00) Peking, Perth, Singapur, Hongkong</option>';
    echo '<option value="8.75"';
    if ($sysconfig['global']['timezone']['wert'] == "8.75") { echo " SELECTED"; };
    echo '>(UTC +08:00) West-Australien</option><option value="9" >(UTC +09:00) Tokio, Seoul, Osaka, Sapporo, Jakutsk</option>';
    echo '<option value="9.5"';
    if ($sysconfig['global']['timezone']['wert'] == "9.5") { echo " SELECTED"; };
    echo '>(UTC +09:30) Adelaide, Darwin, Jakutsk</option>';
    echo '<option value="10"';
    if ($sysconfig['global']['timezone']['wert'] == "10") { echo " SELECTED"; };
    echo '>(UTC +10:00) Ost-Australien, Guam, Wladiwostok</option>';
    echo '<option value="10.5"';
    if ($sysconfig['global']['timezone']['wert'] == "10.5") { echo " SELECTED"; };
    echo '>(UTC +10:30) Lord-Howe-Insel (Australien)</option>';
    echo '<option value="11"';
    if ($sysconfig['global']['timezone']['wert'] == "11") { echo " SELECTED"; };
    echo '>(UTC +11:00) Magadan, Salomonen, Neukaledonien</option>';
    echo '<option value="11.3"';
    if ($sysconfig['global']['timezone']['wert'] == "11.3") { echo " SELECTED"; };
    echo '>(UTC +11:30) Norfolk-Inseln</option>';
    echo '<option value="12"';
    if ($sysconfig['global']['timezone']['wert'] == "12") { echo " SELECTED"; };
    echo '>(UTC +12:00) Auckland, Wellington, Fidschi, Kamtschatka</option>';
    echo '<option value="12.75"';
    if ($sysconfig['global']['timezone']['wert'] == "12.75") { echo " SELECTED"; };
    echo '>(UTC +12:45) Chatham-Inseln</option>';
    echo '<option value="13"';
    if ($sysconfig['global']['timezone']['wert'] == "13") { echo " SELECTED"; };
    echo '>(UTC +13:00) Tonga</option>';
    echo ' <option value="14"';
    if ($sysconfig['global']['timezone']['wert'] == "14") { echo " SELECTED"; };
    echo '>(UTC +14:00) Kiribati</option>';


    echo'</select>';
    echo '</td></tr><tr><td>';

    echo 'Sommer/Winterzeit automatisch erkennen:';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_system_sowizeit">';
    if ($sysconfig['global']['system_sowizeit']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['system_sowizeit']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['system_sowizeit']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    };
    echo '</select>';
    echo '</td></tr><tr><td>';

    echo '<label for="set_apache_user">Apache User:</label>';
    echo '</td><td>';
    echo '<input type="text" size="35px" id="set_apache_user" name="set_apache_user" value="' . $sysconfig['global']['apache_user']['wert'] . '" />';
    echo '</td></tr><tr><td>';

    echo '<label for="set_apache_group">Apache Gruppe:</label>';
    echo '</td><td>';
    echo '<input type="text" size="35px" id="set_apache_group" name="set_apache_group" value="' . $sysconfig['global']['apache_group']['wert'] . '" />';
    echo '</td></tr><tr><td>';


    echo 'JPGraph:';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_jpgraph_function">';
    if ($sysconfig['global']['jpgraph_function']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['jpgraph_function']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['jpgraph_function']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    };
    echo '</select>';
    echo '</td></tr><tr><td>';


    echo 'Logsystem (Öffentlicher Bereich):';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_logsystem">';
    if ($sysconfig['global']['logsystem']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['logsystem']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['logsystem']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    }; 
    echo '</select>';
    echo '</td></tr><tr><td>';

    echo 'Logsystem (Setup Bereich):';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_logsystem_setup">';
    if ($sysconfig['global']['logsystem_setup']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['logsystem_setup']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['logsystem_setup']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    };
    echo '</select>';
    echo '</td></tr></table>';

    echo '</font></p></td></tr>';
    echo '</table>';
    echo "<br>";
    
    //DAEMON
    echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600" height="auto">';
    echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
    echo "Daemon Job System";
    echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
    echo "<hr>"; 
    echo '<table border="0" width="auto" id="table1"><tr><td width="250">';

    echo '<label for="aktorautoupdate">Aktor Auto Update on Aktor_Data_Send CMD:</label>'; // Timestamp für update zurücksetzen damit direkt geupdatet wird +2s
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_aktorautoupdate">';
    if ($sysconfig['daemon']['aktorautoupdate']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['daemon']['aktorautoupdate']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['daemon']['aktorautoupdate']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    };
    echo '</select>';
    echo '</td></tr><tr><td>';

    echo '</td></tr></table>';
    echo '</td></tr></table>';
    
    
    // EINSTELLUNGEN HAUPTSEITE
    echo '</td><td valign="top">';// TABELLE 2

    echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600" height="auto">';
    echo '<td height="25" bgcolor="#FFBF00" valign="top"><font size="4">';
    echo "Einstellungen für die Hauptseite";
    echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
    echo "<hr>"; 
    echo '<table border="0" width="100%" id="table1"><tr><td width="250">';

    echo 'Neue Zeile nach X Anzahl Sensoren:';
    echo '</td><td>';
    echo '<select id="" style="width:77%" name="set_zaehler_neuezeileconf">';
    if ($sysconfig['global']['zaehler_neuezeileconf']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['zaehler_neuezeileconf']['wert'] . '">aus</OPTION>';
        echo '<option value=1>An</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['zaehler_neuezeileconf']['wert'] . '">an</OPTION>';
        echo '<option value=0>Aus</option>';
    };
    echo '</select>&nbsp;&nbsp;';
    echo '<input type="text" size="5px" id="set_zaehler_abstand" name="set_zaehler_abstand" value="' . $sysconfig['global']['zaehler_abstand']['wert'] . '" />';
    echo '</td></tr><tr><td>';

    echo 'Neue Zeile bei neuer Gruppe:';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_gruppe_neuezeileconf">';
    if ($sysconfig['global']['gruppe_neuezeileconf']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['gruppe_neuezeileconf']['wert'] . '">aus</OPTION>';
        echo '<option value=1>An</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['gruppe_neuezeileconf']['wert'] . '">an</OPTION>';
        echo '<option value=0>Aus</option>';
    };
    echo '</select>';
    echo '</td></tr><tr><td>';

    echo 'MouseOver:';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_mouseover_function">';
    if ($sysconfig['global']['mouseover_function']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['mouseover_function']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['mouseover_function']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    };
    echo '</select>';
    echo '</td></tr><tr><td>';


    echo 'Sidebar:';
    echo '</td><td>';
    echo '<select id="" style="width:100%" name="set_sidebar_gesamt">';
    if ($sysconfig['global']['sidebar_gesamt']['wert'] == "0") {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['sidebar_gesamt']['wert'] . '">aus</OPTION>';
        echo '<option value=1>an</option>';
    } else {
        echo '<OPTION SELECTED VALUE="' . $sysconfig['global']['sidebar_gesamt']['wert'] . '">an</OPTION>';
        echo '<option value=0>aus</option>';
    };
    echo '</select>';
    echo '</td></tr></table>';

    echo '</font></p></td></tr>';
    echo '</table>';
    echo "<br>";

    echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600" height="auto">';
    echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
    echo "Setupbereich";
    echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
    echo "<hr>"; 
    echo '<table border="0" width="auto" id="table1"><tr><td width="250">';

    echo '<label for="set_loginname">Loginname:</label>';
    echo '</td><td>';
    echo '<input type="text" size="35px" id="set_loginname" name="set_loginname" value="' . $sysconfig['global']['loginname']['wert'] . '" />';
    echo '</td></tr><tr><td>';

    echo '<label for="set_loginpasswort">Loginpasswort:</label>';
    echo '</td><td>';
    echo '<input type="text" size="35px" id="set_loginpasswort" name="set_loginpasswort" value="' . $sysconfig['global']['loginpasswort']['wert'] . '" />';
    echo '</td></tr><tr><td>';

    echo '</td></tr></table>';
    echo '</td></tr></table>';
    echo '</td></tr><tr><td colspan="2">';

    echo '<div align="center"><br>';
    echo '<input type="hidden" name="step" value="2" />';
    echo '<label for="submit">&nbsp;</label>';
    echo '<input type="submit" id="submit" name="submit" value="Konfiguration Speichern" class="button" />';
    echo '</form>';

    echo '</td></tr></td></tr></table><br>';
};


//-Step 2---------------------------------------------------------------------------------

if ($step == 2) {
    echo "setting configuration... reload in progress";
    $setup_returncode = "0";
    
    if (set_database_config("global","timezone",$set_timezone,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };	

    if (set_database_config("global","system_sowizeit",$set_system_sowizeit,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };	

    if (set_database_config("global","apache_user",$set_apache_user,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };	

    if (set_database_config("global","apache_group",$set_apache_group,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };	
	

	// Globals
    if (set_database_config("global","jpgraph_function",$set_jpgraph_function,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	
	
    if (set_database_config("global","logsystem",$set_logsystem,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	
    if (set_database_config("global","logsystem_setup",$set_logsystem_setup,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };

    
    // DAEMON
    if (set_database_config("daemon","aktorautoupdate",$set_aktorautoupdate,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
    
    
	// Indexseite
    if (set_database_config("global","zaehler_neuezeileconf",$set_zaehler_neuezeileconf,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	
    if (set_database_config("global","zaehler_abstand",$set_zaehler_abstand,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	
    if (set_database_config("global","gruppe_neuezeileconf",$set_gruppe_neuezeileconf,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };

    if (set_database_config("global","mouseover_function",$set_mouseover_function,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
    
    if (set_database_config("global","sidebar_gesamt",$set_sidebar_gesamt,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	

    // Setupbereich
    if (set_database_config("global","loginname",$set_loginname,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	
    if (set_database_config("global","loginpasswort",$set_loginpasswort,$link) == "0") {
            echo "<br>Alles ok";
    } else {
            echo "<br>HILFE... Alles wird gut...";
            $setup_returncode = "1";
    };
	
    if ($setup_returncode != "1") {
        echo '<head><meta http-equiv="refresh" content="0;URL=' . $_SERVER['PHP_SELF'] . '?' . session_name() . '=' . session_id() . '&done=true"></head>';
    };
};
include ("../erw/ausgabe/copyright.php");
?>

<?php
} else {
    $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
    $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
    $extra = "index.php";
    header("Location: http://$host$uri/$extra");
};
?>