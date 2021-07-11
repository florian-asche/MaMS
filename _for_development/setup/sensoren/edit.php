<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("../header.php");                                                      // Header Laden
include ("../../configuration.php");                                            // Konfiguration Laden
include ("../../funktionen.php");                                               // Funktionen Laden
include ("../../configuration_sensortypen.php");                                // Sensordarstellungen für die Index Seite Laden
include ("menu.php");                                                           // Menü Laden                                   

if (isset($_GET['actionid'])) {
    $actionid = $_GET["actionid"];
    if (preg_match('~^[0-9_]~', $actionid) != "1") {
        echo "SQL Injection Attack detected!";
        exit;
    };
};
    
if (!isset($_POST["step"])) {
    $step = "1";
} else {
    $step = $_POST["step"];
};

$set_details = $_POST["set_details"];
$set_groupid = $_POST["set_groupid"];
$set_subgroupid = $_POST["set_subgroupid"];
$set_aktiv = $_POST["set_aktiv"];
$set_system = $_POST["set_system"];
$set_objekt_type = $_POST["set_objekt_type"];
$set_objektid = $_POST["set_objektid"];
$set_daemonjob = $_POST["set_daemonjob"];

echo '<table border="0" width="100%">';
echo '<tr><td colspan="2">';
echo "<FONT SIZE=+2>Objekt bearbeiten<br></font><br>";   
echo '</td></tr>';
echo '<tr><td valign="top">';

if ($step == "1") {
    $sql_getqueue = "
    SELECT * 
    FROM objekte 
    WHERE `ID` = " . $actionid;
    
    if ($result = mysql_query($sql_getqueue, $link)) {
        while ($row = mysql_fetch_array($result)) {
            echo '<form action="' . $_SERVER['PHP_SELF'] . '?actionid=' . $actionid . '" method="POST">';
            echo '<table border="0" class="mini" bgcolor="#FFBF00" width="600">';
            echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
            echo "Allgemeine Einstellungen:";
            echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
            echo "<hr>";

            echo '<table border="0">';
            echo '<tr><td><label for="set_details">Beschreibung:</label></td><td>';
            echo '<input type="text" size="53px" id="set_details" name="set_details" value="' . $row["details"] . '"></td></tr>';

            echo '<tr><td><label for="set_groupid">Gruppe:</label></td><td>';
            echo '<input type="text" size="53px" id="set_groupid" name="set_groupid" value="' . $row["groupid"] . '"></td></tr>';
            
            echo '<tr><td><label for="set_subgroupid">Sub Gruppe:</label></td><td>';
            echo '<input type="text" size="53px" id="set_subgroupid" name="set_subgroupid" value="' . $row["subgroupid"] . '"></td></tr>';
            
            echo '<tr><td><label for="set_aktiv">Aktiv:</label></td><td>';
            echo '<select id="set_aktiv" style="width:100%" name="set_aktiv">';
            if ($row['aktiv'] == "0") {
                echo '<option SELECTED value="0">Nein</OPTION>';
                echo '<option value="1">Ja</option>';
            } else {
                echo '<option value="0">Nein</OPTION>';
                echo '<option SELECTED value="1">Ja</option>';
            };
            echo '</select></td></tr>';

            echo '<tr><td><label for="set_system">Sensorart:</label></td><td>';
            echo '<select id="set_system" style="width:100%" name="set_system">';
            foreach($sensortype as $sensortype_foreach) {
                if ($row['system'] == $sensortype_foreach['name']) {
                    echo "<option SELECTED value=" . $sensortype_foreach['name'] . ">" . $sensortype_foreach['beschreibung'] . "</option>";
                } else {
                    echo "<option value=" . $sensortype_foreach['name'] . ">" . $sensortype_foreach['beschreibung'] . "</option>";
                };
            };
            echo '</select></td></tr>';
            
            echo '<tr><td><label for="set_objekt_type">Type:</label></td><td>';
            echo '<select id="set_objekt_type" style="width:100%" name="set_objekt_type">';
            if ($row['objekt_type'] == "0") {
                echo '<option SELECTED value="0">Sensor</option>';
                echo '<option value="1">Aktor</option>';
            } elseif ($row['objekt_type'] == "1") {
                echo '<option value="0">Sensor</option>';
                echo '<option SELECTED value="1">Aktor</option>';
            };
            echo '</select></td></tr>';

            //echo "HIER: " . $row['stationen_protokoll_ID'];
            echo '<tr><td><label for="set_daemonjob">Daemon Job:</label></td><td>';
            echo '<select id="set_daemonjob" style="width:100%" name="set_daemonjob">';

$sql_get_daemonjobs = "
SELECT *, 
`stationen_protokoll`.`ID` AS 'stationen_protokoll.ID' , 
UNIX_TIMESTAMP(NOW()) - `intervall_time` AS queue_should_run_since , 
UNIX_TIMESTAMP(`queue_lastrun_timestamp`) AS queue_lastrun_timestamp 
FROM 
stationen_protokoll
LEFT JOIN 
stationen ON (stationen_protokoll.stationen_ID = stationen.ID)
INNER JOIN 
queue ON (stationen_protokoll.ID = queue.stationen_protokoll_ID)
ORDER BY queue.type, `stationen_protokoll.ID`
";
            $result_get_daemonjobs = mysql_query($sql_get_daemonjobs);
            while ($row_daemonjob = mysql_fetch_array($result_get_daemonjobs)) {
//                $anzahlzuordnungen = funktion_sensoren_check_zugeordnet($row_objektid["objektid"],$link);
                if ($row['stationen_protokoll_ID'] != $row_daemonjob["stationen_protokoll.ID"]) {
//                    if ($anzahlzuordnungen >= "1") {
                        echo '<option value="' . $row_daemonjob['stationen_protokoll.ID'] . '">' . $row_daemonjob['beschreibung'] . ' (STANDORT=' . $row_daemonjob['standort'] . ', IP=' . $row_daemonjob['ip'] . ', PORT=' . $row_daemonjob['port'] . ')' . '</option>';
//                    } else {
//                        echo '<option value=' . $row_objektid['objektid'] . '>' . $row_objektid['objektid'] . '</option>';
//                    };
                } elseif ($row['stationen_protokoll_ID'] == $row_daemonjob["stationen_protokoll.ID"]) {
//                    if ($anzahlzuordnungen >= "1") {
                        //echo '<option SELECTED value="' . $row_daemonjob['stationen_protokoll.ID'] . '">' . $row_daemonjob['beschreibung'] . ' (' . $row_daemonjob['ip'] . ')' . '</option>';
                        echo '<option SELECTED value="' . $row_daemonjob['stationen_protokoll.ID'] . '">' . $row_daemonjob['beschreibung'] . ' (STANDORT=' . $row_daemonjob['standort'] . ', IP=' . $row_daemonjob['ip'] . ', PORT=' . $row_daemonjob['port'] . ')' . '</option>';
//                    } else {
//                        echo '<option SELECTED value=' . $row_objektid['objektid'] . '>' . $row_objektid['objektid'] . '</option>';
//                    };      
                };
            };
            
            if ($row['stationen_protokoll_ID'] == "") {
                echo '<option SELECTED value="NULL">Keine</option>';
            } else {
                echo '<option value="NULL">Keine</option>';
            };
            
            echo '</select> (nur bei Aktor notwendig)</td></tr>';
            
            
            function funktion_sensoren_check_zugeordnet($objektid,$link) {
                $sql_getanzahlsensoren = "SELECT * FROM objekte WHERE `objektid` = '" . $objektid . "'";
                if ($result = mysql_query($sql_getanzahlsensoren, $link)) {
                    return mysql_num_rows($result);
                } else {
                    echo "ERROR!";
                };
            };
           
            echo '<tr><td><label for="set_objektid">Objekt ID:</label></td><td>';
            echo '<select id="set_objektid" style="width:100%" name="set_objektid">';
            $sql_get_objektid = "SELECT objektid FROM daten GROUP BY `objektid`";
            $result_get_objektid = mysql_query($sql_get_objektid);
            while ($row_objektid = mysql_fetch_array($result_get_objektid)) {
                $anzahlzuordnungen = funktion_sensoren_check_zugeordnet($row_objektid["objektid"],$link);
                if ($row['objektid'] != $row_objektid["objektid"]) {
                    if ($anzahlzuordnungen >= "1") {
                        echo '<option value=' . $row_objektid['objektid'] . '>' . $row_objektid['objektid'] . ' (bereits zugeordnet)' . '</option>';
                    } else {
                        echo '<option value=' . $row_objektid['objektid'] . '>' . $row_objektid['objektid'] . '</option>';
                    };
                } else {
                    if ($anzahlzuordnungen >= "1") {
                        echo '<option SELECTED value=' . $row_objektid['objektid'] . '>' . $row_objektid['objektid'] . ' (bereits zugeordnet)' . '</option>';
                    } else {
                        echo '<option SELECTED value=' . $row_objektid['objektid'] . '>' . $row_objektid['objektid'] . '</option>';
                    };
                };
            };
            echo '</select></td></tr>';
            
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
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
        echo mysql_error($link);
        echo "</li></ul></dd></dl>";
    };
};

if ($step == "2") {
    $sql_station_protokoll = "UPDATE `objekte` SET `details` = '" . $set_details . "', `groupid` = '" . $set_groupid . "', `subgroupid` = '" . $set_subgroupid . "', `aktiv` = '" . $set_aktiv . "', `objektid` = '" . $set_objektid . "', `system` = '" . $set_system . "', `objekt_type` = '" . $set_objekt_type . "', `stationen_protokoll_ID` = " . $set_daemonjob . " WHERE `ID` = '" . $actionid . "'";
    if (mysql_query($sql_station_protokoll, $link)) {    
        echo "Die Daten wurden erfolgreich geändert.<br><br>";
        echo '<head><meta http-equiv="refresh" content="0;URL=index.php?' . session_name() . '=' . session_id() . '"></head>';
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Die Daten konnten nicht in die Datenbank geschrieben werden!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
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