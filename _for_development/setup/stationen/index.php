<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("../header.php");                                                      // Header Laden
include ("../../configuration.php");                                            // Konfiguration Laden
include ("../../system.php");                                               // Funktionen Laden
include ("menu.php");                                                           // Menü Laden                                   

if (isset($_GET['action'])) {
    $action = $_GET["action"];
} else {
    $action = "";
};

if (isset($_GET['actionid'])) {
    $actionid = $_GET["actionid"];
} else {
    $actionid = "";
};

if (isset($_GET['actionid2'])) {
    $actionid2 = $_GET["actionid2"];
} else {
    $actionid2 = "";
};

if (isset($_GET['done'])) {
    $done = $_GET['done'];
    
    if ($done == true) {
        echo '<dl id="system-message"><dd class="message message fade"><ul><li>Die Daten wurden erfolgreich geändert.</li></ul></dd></dl>';
    };  
};

// ACTIONS:---------------------------------------------------------------------
if ($action == "loeschen") {
    if ($actionid) {
        $sql_loeschen = "DELETE FROM `stationen_protokoll` WHERE `ID` = " . $actionid;
        if (mysql_query($sql_loeschen, $link)) {
            $sql_loeschen2 = "DELETE FROM `queue` WHERE `stationen_protokoll_ID` = " . $actionid;
            if (mysql_query($sql_loeschen2, $link)) {
                if ($actionid2) {
                    $sql_anzahl_protokolle = "select * FROM stationen_protokoll WHERE `stationen_ID` = '" . $actionid2 . "'";
                    if ($result_anzahl_protokolle = mysql_query($sql_anzahl_protokolle, $link)) {
                        if (mysql_num_rows($result_anzahl_protokolle) == "0") {
                            $sql_loeschen3 = "DELETE FROM `stationen` WHERE `ID` = " . $actionid2;
                            if (mysql_query($sql_loeschen3, $link)) {
                                echo '<head><meta http-equiv="refresh" content="0;URL=index.php"></head>'; 
                            } else {
                                echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
                                echo mysql_error($link); // Fehler Posten
                                echo "</li></ul></dd></dl>";
                            };
                        };   
                    } else {
                        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
                        echo mysql_error($link); // Fehler Posten
                        echo "</li></ul></dd></dl>";
                    };
                } else {
                   echo '<head><meta http-equiv="refresh" content="0;URL=index.php"></head>'; 
                };
            } else {
                echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
                echo mysql_error($link); // Fehler Posten
                echo "</li></ul></dd></dl>";
            };    
        } else {
            echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
            echo mysql_error($link); // Fehler Posten
            echo "</li></ul></dd></dl>";
        };
    };
};

if ($action == "aktivieren") {
    $sql_aktivieren = "UPDATE `stationen_protokoll` SET `aktiv` = '1' WHERE `ID` = " . $actionid;
   if (mysql_query($sql_aktivieren, $link)) {    
        echo '<head><meta http-equiv="refresh" content="0;URL=index.php"></head>';
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
        
    };
};

if ($action == "deaktivieren") {
    $sql_deaktivieren = "UPDATE `stationen_protokoll` SET `aktiv` = '0' WHERE `ID` = " . $actionid;
   if (mysql_query($sql_deaktivieren, $link)) {    
        echo '<head><meta http-equiv="refresh" content="0;URL=index.php"></head>';
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
        
    };
};

// TABELLE:---------------------------------------------------------------------
echo '<table border="0" width="100%">';
echo '<tr><td colspan="2">';
echo "<FONT SIZE=+2>Daemon Jobs<br></font><br>";   
echo '</td></tr>';
echo '<tr><td valign="top">';

echo '<div align="center">';
echo '<table border="1"><tr>';
echo '<th colspan="3">Verbindungsdaten</th>';
echo '<th colspan="6">Protokoll</th>';
echo '<th colspan="2">Queue</th>';
echo '<th rowspan="2" colspan="4" class="schmal">Möglichkeiten</th>';
echo '</tr><tr>';
echo '<th class="tabelle_top">Standort</th>';
echo '<th class="tabelle_top">IP</th>';
echo '<th class="tabelle_top">Port</th>';
echo '<th class="tabelle_top">Beschreibung</th>';
echo '<th class="tabelle_top">Type</th>';
echo '<th class="tabelle_top">Script</th>';
echo '<th class="tabelle_top">objektid</th>';
echo '<th class="tabelle_top">Status</th>';
echo '<th class="tabelle_top">Aktiv</th>';
echo '<th class="tabelle_top">Intervall</th>';
echo '<th class="tabelle_top">Last Updated</th>';
//echo '<th class="tabelle_top">SEND-<br>Command</th>';
//echo '<th class="tabelle_top">RECV-<br>Filter</th>';
//echo '<th class="tabelle_top">RECV-<br>Command</th>';
//echo '<th class="tabelle_top">Param. 1</th>';
//echo '<th class="tabelle_top">Param. 2</th>';
//echo '<th class="tabelle_top">Param. 3</th>';
echo '</tr>';

// Datenbank Abfrage
$mysqlreq = "
SELECT *, 
`stationen_protokoll`.`ID` AS 'stationen_protokoll.ID' , 
UNIX_TIMESTAMP(NOW()) - `intervall_time` AS queue_should_run_since , 
UNIX_TIMESTAMP(`queue_lastrun_timestamp`) AS queue_lastrun_timestamp , 
`queue`.`ID` AS 'queue.ID' 
FROM 
stationen_protokoll
LEFT JOIN 
stationen ON (stationen_protokoll.stationen_ID = stationen.ID)
INNER JOIN 
queue ON (stationen_protokoll.ID = queue.stationen_protokoll_ID)
WHERE (`type` = '0' OR `type` = '2')
ORDER BY `type`, `standort`, `ip`, `port`
";


if ($result = mysql_query($mysqlreq, $link)) {    
    // TESTAUSGABE //////////////////////////////////
    //echo '<div align="left">';
    //echo '<pre>';
    //print_r(mysql_fetch_assoc($result));
    //echo '</pre>'; 
    // exit;
    /////////////////////////////////////////////////

    while ($row = mysql_fetch_array($result)) {
        echo '<tr><td>';

        //echo $row['stationen_protokoll.ID'];
        echo $row['standort'];
        if (!$row['standort']) { echo "&nbsp;"; };
        echo '</td><td>';

        echo $row['ip'];
        if (!$row['ip']) { echo "&nbsp;"; };
        echo '</td><td>';

        echo $row['port'];
        if (!$row['port']) { echo "&nbsp;"; };
        echo '</td><td>';

        echo $row['beschreibung'];
        if (!$row['beschreibung']) { echo "&nbsp;"; };
        echo '</td><td>';    

        if ($row['type'] == "0") {
            echo "Station";
//        } elseif ($row['type'] == "1") {
//            echo "Aktor";
        } elseif ($row['type'] == "2") {
            echo "PHP Job";
        } else {
            echo "Error";
        };
        echo '</td><td>'; 
        
        echo $row['script'];
        if (!$row['script']) { echo "&nbsp;"; };
        echo '</td><td>';   

        echo $row['objektid'];
        if (!$row['objektid']) { echo "&nbsp;"; };
        echo '</td><td>';

        $checkport = $row['port'];
        $checkhost = $row['ip'];
        statuscheck($checkhost,$checkport);                                             // Funktion für Status Prüfung aufrufen
        echo '</td><td>'; 
        //
        if ($row['aktiv'] == "0") {
            echo "Nein";
        } elseif ($row['aktiv'] == "1") {
            echo "Ja";
        } else {
            echo "ERROR!";
        };
        echo '</td><td>'; 

        //echo $row[sendcommand] . "&nbsp;";
        //echo '</td><td>';

        //echo $row[recievefilter] . "&nbsp;";
        //echo '</td><td>';

        //echo $row[recievecommand] . "&nbsp;";
        //echo '</td><td>';

        //echo $row[parameter1] . "&nbsp;";
        //echo '</td><td>';

        //echo $row[parameter2] . "&nbsp;";
        //echo '</td><td>';   

        //echo $row[parameter3] . "&nbsp;"; 
        
        echo $row['intervall_time'] . "&nbsp;";
        echo '</td><td>';  
        
        if ($row['queue_lastrun_timestamp'] <= $row['queue_should_run_since']) {
            $farbe = '<font color="red">';
        } else {
            $farbe = '<font color="green">';
        };
        
        echo $farbe . date("d.m.Y",$row['queue_lastrun_timestamp']) . " " . date("H:i:s",$row['queue_lastrun_timestamp']) . "</font>";
        //echo '</td><td>';  

        echo "</td><td class=\"kurz\">";
        if ($row['aktiv'] == "1") {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?actionid=' . $row['stationen_protokoll.ID'] . '&action=deaktivieren">Deaktivieren</a>';
        } else {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?actionid=' . $row['stationen_protokoll.ID'] . '&action=aktivieren">Aktivieren</a>';
        };
        echo "</td><td>";
        echo '<a href="ausfuehrung.php?'. session_name() . '=' . session_id() .'&queueid=' . $row['queue.ID'] . '">Job ausfuehren</a>';
        echo "</td><td>";
        echo '<a href="edit.php?'. session_name() . '=' . session_id() .'&station_protokollid=' . $row['stationen_protokoll.ID'] . '">Bearbeiten</a>';
        echo "</td><td>";
        echo '<a href="' . $_SERVER['PHP_SELF'] . '?actionid=' . $row['stationen_protokoll.ID'] . '&actionid2=' . $row['stationen_ID'] . '&action=loeschen">Löschen</a>';
        echo "</td></tr>";
    };
} else {
    echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
    echo mysql_error($link); // Fehler Posten
    echo "</li></ul></dd></dl>";
};
echo '</td></tr></table></div>';

echo '</td></tr></table><br>';
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