<?php 
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("../header.php");                                                      // Header Laden
include ("../../configuration.php");                                            // Konfiguration Laden
include ("../../system.php");                                               // Funktionen Laden
include ("../../configuration_sensortypen.php");                                // Sensordarstellungen für die Index Seite Laden
include ("menu.php");                                                           // Menü Laden                                   

if (isset($_GET['action'])) {
    $action = $_GET["action"];
} else {
    $action = "";
};

if (isset($_GET['actionid'])) {
    $actionid = $_GET["actionid"];
    if (preg_match('~^[0-9_]~', $actionid) != "1") {
        echo "SQL Injection Attack detected!";
        exit;
    };
} else {
    $actionid = "";
};

if (isset($_GET['actionid2'])) {
    $actionid2 = $_GET["actionid2"];
    if (preg_match('~^[0-9_]~', $actionid2) != "1") {
        echo "SQL Injection Attack detected!";
        exit;
    };
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
    $sql_loeschen = "DELETE FROM `objekte` WHERE `ID` = " . $actionid;
    if (mysql_query($sql_loeschen, $link)) {
        echo '<head><meta http-equiv="refresh" content="0;URL=index.php"></head>'; 
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
    };
};

if ($action == "aktivieren") {
    $sql_aktivieren = "UPDATE `objekte` SET `aktiv` = '1' WHERE `ID` = " . $actionid;
   if (mysql_query($sql_aktivieren, $link)) {    
        echo '<head><meta http-equiv="refresh" content="0;URL=index.php"></head>';
    } else {
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
        echo mysql_error($link); // Fehler Posten
        echo "</li></ul></dd></dl>";
        
    };
};

if ($action == "deaktivieren") {
    $sql_deaktivieren = "UPDATE `objekte` SET `aktiv` = '0' WHERE `ID` = " . $actionid;
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
echo "<FONT SIZE=+2>Sensoren-Zuordnung<br></font><br>";   
echo '</td></tr>';
echo '<tr><td valign="top">';

echo '<div align="center">';
echo '<table border="1"><tr>';
echo '<th>Gruppe</th>';
echo '<th>Sub Gruppe</th>';
echo '<th>Beschreibung</th>';
echo '<th>Objekt ID</th>';
echo '<th>Type</th>';
echo '<th>Daemon Job</th>';
echo '<th>System</th>';
echo '<th>Aktiv</th>';
echo '<th colspan="3">Möglichkeiten</th>';
echo '</tr>';

function funktion_get_daemonjob_data($objektid,$link) {
$sql_get_daemonjob = "
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
WHERE stationen_protokoll.ID = $objektid";
if ($result = mysql_query($sql_get_daemonjob, $link)) {
while ($row = mysql_fetch_array($result)) {
    return $row['beschreibung'] . " (" . $row['ip'] . ")";
};
};
};


// Datenbank Abfrage
$mysqlreq = "
SELECT * 
FROM objekte 
ORDER BY `groupid`, `subgroupid`
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
        echo $row['groupid'] . "&nbsp;";
        echo '</td><td>';

        echo $row['subgroupid'] . "&nbsp;";
        echo '</td><td>';

        echo $row['details'] . "&nbsp;";
        echo '</td><td>';

        echo $row['objektid'] . "&nbsp;";
        echo '</td><td>';
        
        if ($row['objekt_type'] == "0") {
            echo "Sensor";
        } elseif ($row['objekt_type'] == "1") {
            echo "Aktor";
        } elseif ($row['objekt_type'] == "2") {
            echo "Other";
        } else {
            echo "Error";
        };
        echo '</td><td>';  
       
        
        if (!$row['stationen_protokoll_ID']) {
            echo "&nbsp;";
        } else {
            echo funktion_get_daemonjob_data($row['stationen_protokoll_ID'],$link);
        };
        echo '</td><td>'; 
        
        
        //echo $row['system'] . "&nbsp;";
        echo $sensortype[$row['system']]['beschreibung'] . "&nbsp;";
        echo '</td><td>';   

        if ($row['aktiv'] == "0") {
            echo "Nein";
        } elseif ($row['aktiv'] == "1") {
            echo "Ja";
        } else {
            echo "ERROR!";
        }; 

        echo "</td><td class=\"kurz\">";
        if ($row['aktiv'] == "1") {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?actionid=' . $row['ID'] . '&action=deaktivieren">Deaktivieren</a>';
        } else {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?actionid=' . $row['ID'] . '&action=aktivieren">Aktivieren</a>';
        };
        echo "</td><td>";
        echo '<a href="edit.php?'. session_name() . '=' . session_id() .'&actionid=' . $row['ID'] . '">Bearbeiten</a>';
        echo "</td><td>";
        echo '<a href="' . $_SERVER['PHP_SELF'] . '?actionid=' . $row['ID'] . '&action=loeschen">Löschen</a>';
        echo "</td></tr>";
    };
} else {
    echo '<dl id="system-message"><dd class="message message fade error"><ul><li>DB ERROR!</li><li>';
    echo mysql_error($link);
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