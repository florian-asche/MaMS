<?php
$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

$statusarray = array(
    0 => "off",
    1 => "on"
);

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    //#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Debug Ausgabe für Array.
    $debugout      = '0';							// DebugAusgabe Neu
    $defaultoutput = '1';                                                     // Standard Debug Ausgabe für Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    include ($absolut_pfad . "/daemon/udpconnector_hexabus.php");               // Weitere PHP Dateien Laden
    $timestampaktu = time();

    $hexaplugstatus = request($IP,$PORT,"getstatus",$debug,$debug_array);
    if ($hexaplugstatus) {
            debug($debugout, $timestampaktu, "1", "getstatus Request", "REQUEST START", "OK");                                                                            				// Ende der Debug Ausgabe
            debug($debugout, $timestampaktu, "0", "getstatus Request", "DATA FROM REQUEST", $hexaplugstatus);
            if ($hexaplugstatus == "ON" OR $hexaplugstatus == "OFF") {
                debug($debugout, $timestampaktu, "0", "getstatus Request", "DATA", "ALL OK");
                
                if ($hexaplugstatus == "ON") {
                    $hexaplugstatusbinaer = "1";
                } elseif ($hexaplugstatus == "OFF") {
                    $hexaplugstatusbinaer = "0";
                };
  
                if ($defaultoutput == "1") {
                    echo "HexaPlug ist: <b>" . $hexaplugstatus . " (" . $hexaplugstatusbinaer . ")</b><br>";
                }; 
                
                $sql_neu = "INSERT INTO `data` (`wert1`, `objectid`,`timestamp`) VALUES ('$hexaplugstatusbinaer', '$MAMS_objektid', NOW())"; //Syntax für Datenbank
                debug($sqldebug, $timestampaktu, "1", "mySQL", "INSERT", $sql_neu);
                if (mysql_query($sql_neu, $link)) {                                         // MySQL Verbindung Aufbauen
                    debug($sqldebug, $timestampaktu, "0", "mySQL", "INSERT", "INSERT SUCCESSFULL");
                } else {                                                                    // Anfang mySQL Fehlermeldung Ausgeben (Wenn das Eintragen nicht erfolgreich war)
                    echo "<br>Daten nicht erfolgreich in die Datenbank gespeichert!!!<br>"; // Fehlermeldung Ausgeben
                    echo mysql_error($link);                                                // Fehlerbeschreibung Ausgeben
                };
            } else {
                debug($debugout, $timestampaktu, "1", "getstatus Request", "DATA", "ERROR");
            };
    } else {                                                                              // Ende Responseprüfung
            debug($debugout, $timestampaktu, "1", "getstatus Request", "REQUEST START", "ERROR");
    };
};
?>
