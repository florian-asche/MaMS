<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("../header.php");                                                      // Header Laden
include ("../../configuration.php");                                            // Konfiguration Laden
include ("../../funktionen.php");                                               // Funktionen Laden
include ("menu.php");                                                           // Menü Laden                                   

if (!isset($_POST["step"])) {
    $step = "1";
//    foreach ($_POST as $ide => $val) {
//        $$ide = $val;
//    };
} else {
    $step = $_POST["step"];
}

if (isset($_GET['station_protokollid'])) {
    $station_protokollid = $_GET["station_protokollid"];
    if (preg_match('~^[0-9_]~', $station_protokollid) != "1") {
        echo "SQL Injection Attack detected!";
        exit;
    };
};

if (isset($_GET['stationidneu'])) {
    $stationidneu = $_GET["stationidneu"];
    if (preg_match('~^[0-9_]~', $stationidneu) != "1") {
        echo "SQL Injection Attack detected!";
        exit;
    };
};

if (isset($_POST['station'])) {
$station = $_POST["station"];
}
if (isset($_POST['set_type'])) {
    $set_type = $_POST["set_type"];
}
if (isset($_POST['change_station_protokollid'])) {
$change_station_protokollid = $_POST["change_station_protokollid"];
}
if (isset($_POST['change_queueid'])) {
    $change_queueid = $_POST["change_queueid"];
}
if (isset($_POST['set_stationid'])) {
    $set_stationid = $_POST["set_stationid"];
}
if (isset($_POST['set_beschreibung'])) {
    $set_beschreibung = $_POST["set_beschreibung"];
}
if (isset($_POST["set_script"])) {
    $set_script = $_POST["set_script"];
    //if (preg_match('~^[A-Za-z0-9_]+.php~', $set_script) != "1") {
    //    echo "Path Traversal Attack detected!";
    //    exit;
    //};
};
if (isset($_POST['set_objektid'])) {
    $set_objektid = $_POST["set_objektid"];
}
if (isset($_POST['set_sendcommand'])) {
    $set_sendcommand = $_POST["set_sendcommand"];
}
if (isset($_POST['set_receivefilter'])) {
    $set_receivefilter = $_POST["set_receivefilter"];
}
if (isset($_POST['set_recievecommand'])) {
    $set_recievecommand = $_POST["set_recievecommand"];
}
if (isset($_POST['set_parameter1'])) {
    $set_parameter1 = $_POST["set_parameter1"];
}
if (isset($_POST['set_parameter2'])) {
    $set_parameter2 = $_POST["set_parameter2"];
}
if (isset($_POST['set_parameter3'])) {
    $set_parameter3 = $_POST["set_parameter3"];
}
if (isset($_POST['set_intervall_time'])) {
    $set_intervall_time = $_POST["set_intervall_time"];
}
if (isset($_POST['set_prioritaet'])) {
    $set_prioritaet = $_POST["set_prioritaet"];
}
if (isset($_POST['set_aktiv'])) {
    $set_aktiv = $_POST["set_aktiv"];
}
if (isset($_POST['set_standort'])) {
    $set_standort = $_POST["set_standort"];
}
if (isset($_POST['set_ip'])) {
    $set_ip = $_POST["set_ip"];
}

if (isset($_POST['set_port'])) {
    $set_port = $_POST["set_port"];
}

if (isset($_POST['set_user'])) {
    $set_user = $_POST["set_user"];
}

if (isset($_POST['set_pass'])) {
    $set_pass = $_POST["set_pass"];
}

echo '<table border="0" width="100%">';
echo '<tr><td colspan="2">';
echo "<FONT SIZE=+2>Daemon Jobs bearbeiten<br></font><br>";   
echo '</td></tr>';
echo '<tr><td valign="top">';

if ($step == "1") {
    echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600">';
    echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
    echo "Verbindungsdaten zur Station:";
    echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
    
    $sql_getqueue = "
    SELECT *, 
    `queue`.`ID` AS 'queue.ID' ,
    `stationen_protokoll`.`ID` AS 'stationen_protokoll.ID'
    FROM `queue` 
    INNER JOIN
    stationen_protokoll ON (stationen_protokoll.ID = queue.stationen_protokoll_ID) 
    LEFT JOIN
    stationen ON (stationen_protokoll.stationen_ID = stationen.ID)
    WHERE `stationen_protokoll`.`ID` = " . $station_protokollid;
    
    if ($result = mysql_query($sql_getqueue, $link)) {
        while ($row = mysql_fetch_array($result)) {
            echo '<table border="0" width="100%"><tr><td>';
            echo "<hr>";
            echo "Aktuell verwendete Verbindungsdaten zur Station:";
            echo '<table border="1">';

//            echo '<tr><td><label for="id">ID Der Tabelle:</label></td><td>';
//            echo $row["stationen_ID"] . "&nbsp;";
//            echo '</td></tr>';

            echo '<tr><td><label for="standort">Standort:</label></td><td>';
            echo $row["standort"] . "&nbsp;";
            echo '</td></tr>';

            echo '<tr><td><label for="ip">IP:</label></td><td>';
            echo $row["ip"] . "&nbsp;";
            echo '</td></tr>';

            echo '<tr><td><label for="port">PORT:</label></td><td>';
            echo $row["port"] . "&nbsp;";
            echo '</td></tr>';

            echo '<tr><td><label for="user">Benutzer:</label></td><td>';
            echo $row["user"] . "&nbsp;";
            echo '</td></tr>';

            echo '<tr><td><label for="pass">Passwort:</label></td><td>';
            echo $row["pass"] . "&nbsp;";
            echo '</td></tr>';
            echo '</td></tr></table><br>';  

            echo '<tr><td>';
            
            // Neue Station erstellen //////////////////////////////////////////////////////////////////////////////////
            echo "<hr><br>";
            echo "Erstellen neuer Verbindungsdaten für diese Station:<br>";
            echo '<form action="' . $_SERVER['PHP_SELF'] . '?'. session_name() . '=' . session_id() .'&station_protokollid=' . $station_protokollid . '" method="POST">';
            echo '<input type="hidden" name="step" value="9" />';
            echo '<input type="hidden" name="station" value="new" />';
            echo '<label for="submit">&nbsp;</label>';
            echo '<input type="submit" id="submit" name="submit" value="Neue Verbindungsdaten" class="button" />';
            echo '</form>';
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        
            // Sonderregelung falls eine Neue Station genutzt werden soll, die zuvor erstellt wurde...
            if ($stationidneu) {
                //echo "<b>Die neuen Verbindungsdaten wurden erstellt und können nun verwendet werden.</b><br><br>";
                echo '<dl id="system-message"><dd class="message message fade"><ul><li>Die neuen Verbindungsdaten wurden erstellt und können nun verwendet </li><li>werden. Die Daten wurden bereits ausgewählt!</li></ul></dd></dl>';
                $station_id_auswahl = $stationidneu;
            } else {
                $station_id_auswahl = $row["stationen_ID"];
            };
        
            //echo "HIER:".$station_id_auswahl;
            
            echo '<tr><td>';
            echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
            echo "<hr><br>";
            echo "Wählen Sie hier die gewünschten Verbindungsdaten:<br>";
            $sql_get_stationen = "SELECT * FROM stationen";
            $result_get_stationen = mysql_query($sql_get_stationen);
            echo '<select id="set_stationid" name="set_stationid">';
            while ($row_stationen = mysql_fetch_array($result_get_stationen)) {
                if ($station_id_auswahl == $row_stationen["ID"]) {
                    echo '<option SELECTED value=' . $row_stationen["ID"] . '>' . $row_stationen["standort"] . ' (IP=' . $row_stationen["ip"] . ', PORT=' . $row_stationen["port"] . ')</option>';
                } else {
                    echo '<option value=' . $row_stationen["ID"] . '>' . $row_stationen["standort"] . ' (IP=' . $row_stationen["ip"] . ', PORT=' . $row_stationen["port"] . ')</option>';
                };
            };
            
            if ($station_id_auswahl == "") {
                echo '<option SELECTED value="NULL">Keine</option>';
            } else {
                echo '<option value="NULL">Keine</option>';
            };
            
            echo '</select>';
            echo '</table>';
            
            
            echo '</font></p></td></tr>';
            echo '</table>';
            
            
            echo '</td><td valign="top">';// TABELLE 2    
    
            echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600">';
            echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
            echo "Allgemeine Einstellungen:";
            echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
            echo "<hr>";

            echo '<table border="0">';
            echo '<tr><td><label for="set_beschreibung">Beschreibung:</label></td><td>';
            echo '<input type="text" size="30px" id="set_beschreibung" name="set_beschreibung" value="' . $row["beschreibung"] . '"></td></tr>';

            echo '<tr><td><label for="set_script">Script:</label></td><td>';
            echo '<select id="set_script" style="width:100%" name="set_script">';
            

            // Daemon Script
            if ($row['type'] == "0") {
                $daemonscriptordner = "sensoren";
//            } elseif ($row['type'] == "1") {
//                $daemonscriptordner = "aktoren";
            } elseif ($row['type'] == "2") { 
                $daemonscriptordner = "andere";
            };
            
            $daemonscriptpfad = $absolut_pfad . "/daemon/" . $daemonscriptordner . "/";
            $daemonprotokolle = opendir($daemonscriptpfad);
            while($daemonprotokollelist = readdir($daemonprotokolle)) {
                if ( !is_dir($daemonprotokollelist) and $daemonprotokollelist != "index.php" and $daemonprotokollelist != "telnetconnector.php" and $daemonprotokollelist != "telnetconnector_ethersex.php" ) {
                    if ($row["script"] != $daemonprotokollelist) {
                        echo '<option value=' . $daemonprotokollelist . '>' . $daemonprotokollelist . '</option>';
                    } else {
                        echo '<option SELECTED value=' . $daemonprotokollelist . '>' . $daemonprotokollelist . '</option>';
                    };
                };
            };
            closedir($daemonprotokolle);  
            echo '</select></td></tr>';
            
            echo '<tr><td><label for="set_aktiv">Aktiv:</label></td><td>';
            echo '<select id="set_aktiv" style="width:100%" name="set_aktiv">';
            if ($row['aktiv'] == "0") {
                echo '<option SELECTED value="0">Nein</OPTION>';
                echo '<option value=1>Ja</option>';
            } else {
                echo '<option value=0>Nein</OPTION>';
                echo '<option SELECTED value=1>Ja</option>';
            };
            echo '</select></td></tr>';
            
            echo '</td></tr></table><br>';
            echo '</td></tr></table><br>';

            echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600">';
            echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
            echo "Protokoll Einstellungen:";
            echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
            echo "<hr>";

            echo '<table border="0">';
            echo '<tr><td><label for="set_objektid">objektid:</label></td><td>';
            echo '<input type="text" size="30px" id="set_objektid" name="set_objektid" value="' . $row["objektid"] . '"></td></tr>';

            echo '<tr><td><label for="set_sendcommand">SEND-Command:</label></td><td>';
            echo '<input type="text" size="30px" id="set_sendcommand" name="set_sendcommand" value="' . $row["sendcommand"] . '"></td></tr>';

            echo '<tr><td><label for="set_receivefilter">RECV-Filter:</label></td><td>';
            echo '<input type="text" size="30px" id="set_receivefilter" name="set_receivefilter" value="' . $row["receivefilter"] . '"></td></tr>';

            echo '<tr><td><label for="set_recievecommand">RECV-Command:</label></td><td>';
            echo '<input type="text" size="30px" id="set_recievecommand" name="set_recievecommand" value="' . $row["recievecommand"] . '"></td></tr>';

            echo '<tr><td><label for="set_parameter1">Parameter 1:</label></td><td>';
            echo '<input type="text" size="30px" id="set_parameter1" name="set_parameter1" value="' . $row["parameter1"] . '"></td></tr>';

            echo '<tr><td><label for="set_parameter2">Parameter 2:</label></td><td>';
            echo '<input type="text" size="30px" id="set_parameter2" name="set_parameter2" value="' . $row["parameter2"] . '"></td></tr>';

            echo '<tr><td><label for="set_parameter3">Parameter 3:</label></td><td>';
            echo '<input type="text" size="30px" id="set_parameter3" name="set_parameter3" value="' . $row["parameter3"] . '"></td></tr>';

            echo '<tr><td><label for="set_type">Type:</label></td><td>';
            echo '<select id="set_type" style="width:100%" name="set_type">';
            if ($row['type'] == "0") {
                echo '<option SELECTED value="0">Station</OPTION>';
//                echo '<option value="1">Aktor</option>';
                echo '<option value="2">PHP Job</option>';
            } elseif ($row['type'] == "1") {
                echo '<option value="0">Station</OPTION>';
//                echo '<option SELECTED value="1">Aktor</option>';
                echo '<option value="2">PHP Job</option>';
            } elseif ($row['type'] == "2") { 
                echo '<option value="0">Station</OPTION>';
//                echo '<option value="1">Aktor</option>';
                echo '<option SELECTED value="2">PHP Job</option>';
            } else {
                echo '<option value="0">Station</OPTION>';
//                echo '<option value="1">Aktor</option>';
                echo '<option value="2">PHP Job</option>';
                echo '<option SELECTED value="'. $row['type'] .'">ERROR</option>';
            };
            echo '</select></td></tr>';
            
            echo "</table>";
            echo '</td></tr></table><br>'; 
            
            echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600">';
            echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
            echo "Queue Einstellungen:";
            echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
            echo "<hr>";
            
            echo '<table border="0">';
            echo '<tr><td><label for="set_intervall_time">Ausfuehrungsintervall:</label></td><td>';     // Default 60
            echo '<input type="text" size="30px" id="set_intervall_time" name="set_intervall_time" value="' . $row["intervall_time"] . '"></td></tr>';

            echo '<tr><td><label for="set_prioritaet">Prioritaet:</label></td><td>';    // Default 20
            echo '<input type="text" size="30px" id="set_prioritaet" name="set_prioritaet" value="' . $row["prioritaet"] . '"></td></tr>';
            echo "</table>";
            
            echo '</td></tr></table><br>'; 

            echo '</td></tr><tr><td colspan="2">';
            echo '<div align="center">';
            echo '<input type="hidden" name="change_station_protokollid" value="' . $row["stationen_protokoll.ID"] . '" />';
            echo '<input type="hidden" name="change_queueid" value="' . $row["queue.ID"] . '" />';
            echo '<input type="hidden" name="step" value="2">';
            echo '<label for="submit">&nbsp;</label>';
            echo '<input type="submit" id="submit" name="submit" value="Konfiguration Speichern" class="button" />';
            echo '</form><br><br>';
        };
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
    };
};

if ($step == "2") {
    $sql_station_protokoll = "UPDATE `stationen_protokoll` SET `stationen_ID` = $set_stationid, `beschreibung` = '$set_beschreibung', `script` = '$set_script', `aktiv` = '$set_aktiv', `sendcommand` = '$set_sendcommand', `receivefilter` = '$set_receivefilter', `recievecommand` = '$set_recievecommand', `parameter1` = '$set_parameter1', `parameter2` = '$set_parameter2', `parameter3` = '$set_parameter3', `objektid` = '$set_objektid' WHERE `ID` = '$change_station_protokollid'";
    if (mysql_query($sql_station_protokoll, $link)) {    
        echo "Station Protokoll: Die Daten wurden erfolgreich geändert.<br><br>";
        $sql_queue = "UPDATE `queue` SET `type` = '$set_type', `stationen_protokoll_ID` = '$change_station_protokollid', `intervall_time` = '$set_intervall_time', `prioritaet` = '$set_prioritaet' WHERE `ID` = '$change_queueid'";
        if (mysql_query($sql_queue, $link)) {    
            echo "Queue: Die Daten wurden erfolgreich geändert.<br><br>";
            echo '<head><meta http-equiv="refresh" content="0;URL=index.php?' . session_name() . '=' . session_id() . '"></head>';
        } else {
            echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Die Daten konnten nicht in die Datenbank geschrieben werden!</li><li>';
            echo mysql_error($link); // Fehler Posten
            echo "</li></ul></dd></dl>";
        };
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Die Daten konnten nicht in die Datenbank geschrieben werden!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
    };
};

if ($step == "9") {
    if ($station == "new") {
        echo "Bitte geben Sie die Verbindungsdaten zu Ihrer neuen Station ein,<br> an der die Sensoren angeschlossen sind.<br><br>";

        //echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
        echo '<form action="' . $_SERVER['PHP_SELF'] . '?'. session_name() . '=' . session_id() .'&station_protokollid=' . $station_protokollid . '" method="POST">';
        echo '<table border="0" cellpadding="0" cellspacing="0">';

        echo '<tr><td><label for="set_standort">Standort:</label></td><td>';
        echo '<input type="text" id="set_standort" name="set_standort"></td></tr>';

        echo '<tr><td><label for="set_ip">IP:</label></td><td>';
        echo '<input type="text" id="set_ip" name="set_ip"></td></tr>';

        echo '<tr><td><label for="set_port">PORT:</label></td><td>';
        echo '<input type="text" id="set_port" name="set_port"></td></tr>';

        echo '<tr><td><label for="set_user">Benutzer:</label></td><td>';
        echo '<input type="text" id="set_user" name="set_user"></td></tr>';

        echo '<tr><td><label for="set_pass">Passwort:</label></td><td>';
        echo '<input type="text" id="set_pass" name="set_pass"></td></tr>';

        echo '</tr></td><tr><td colspan="2">';
        echo '<div align="right"><br>';
        echo '<input type="hidden" name="step" value="9" />';
        echo '<input type="hidden" name="station" value="making" />';
        echo '<label for="submit">&nbsp;</label>';
        echo '<input type="submit" id="submit" name="submit" value="Verbindungsdaten einrichten" class="button" />';
        echo '</form>';
        echo '</td></tr></table>';
    } elseif ($station == "making") {
        //echo "Der Eintrag in der Datenbank wird nun erstellt...<br>";
        $sql_neu = "INSERT INTO `stationen` (`standort`, `ip`, `port`, `user`, `pass`) VALUES ('" . $set_standort . "', '" . $set_ip . "', '" . $set_port . "', '" . $set_user . "', '" . $set_pass . "')";
        if (mysql_query($sql_neu, $link)) {    
            echo "Die Daten wurden erfolgreich in die Datenbank eingetragen.<br><br>";
            $mysqlid = mysql_insert_id();
            echo '<head><meta http-equiv="refresh" content="0;URL=edit.php?'. session_name() . '=' . session_id() .'&station_protokollid=' . $station_protokollid . '&stationidneu=' . $mysqlid . '"></head>'; 
        } else {
            echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Die Daten konnten nicht in die Datenbank geschrieben werden!</li><li>';
            echo mysql_error($link); // Fehler Posten
            echo "</li></ul></dd></dl>";
        };
    };
};

////////////////////////////////////////////////////////////////////////////////
echo '</td></tr></table>';
include ("../../erw/ausgabe/copyright.php");
?>

<?php
} else {
    $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
    $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
    $extra = "index.php";
    header("Location: http://$host$uri/$extra");
};
?>