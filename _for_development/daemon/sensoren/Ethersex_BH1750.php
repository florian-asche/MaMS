<?php
$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    if (!$SENDCOMMAND) {
        $SENDCOMMAND = "!bh1750 lux";                                      // Default Sendcommand if no other given
    };

//#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $debugout      = '0';							// DebugAusgabe Neu
    $anzahlzeilen  = '1';							// Hier wird die Anzahl an Zeilen der Telnetübertragung angegeben die für den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    $defaultoutput = '1';                                                       // Standard Debug Ausgabe für Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    include ($absolut_pfad . "/daemon/telnetconnector_ethersex.php");           // Weitere PHP Dateien Laden
    $timestampaktu = time();

    $objektid = $MAMS_objektid;
    $lux = request($IP,$PORT,$SENDCOMMAND,$defaultoutput,$debug,"EGAL",$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    if ($lux) {
        debug($debugout, $timestampaktu, "1", "bh1750 lux", "REQUEST START", "OK");
        if ($debug_array == "1") {                                                      			// Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
            echo '<pre>';                                                                 			// Debug Ausgabe
            print_r($lux);                                                                                      // Debug Ausgabe
            echo '</pre>';                                                                			// Debug Ausgabe
            echo "#####################################################################";		 	// Debug Ausgabe
            echo "<br>";
        };                                                                              			// Ende der Debug Ausgabe
        debug($debugout, $timestampaktu, "0", "bh1750 lux", "DATA FROM REQUEST", $lux[0]);
        
        if ($defaultoutput == "1") { 
            echo "objektid: <b>" . $objektid . "<br>";                          // Debug Ausgabe
            echo "lux: <b>" . $lux[0] . "<br>";                              // Debug Ausgabe
        }; 
        
        $sql_neu = "INSERT INTO `data` (`wert1`, `objectid`,`timestamp`) VALUES ('$lux[0]', '$objektid', NOW())"; //Syntax für Datenbank
        debug($sqldebug, $timestampaktu, "1", "mySQL", "INSERT", $sql_neu);
        if (mysql_query($sql_neu, $link)) {                                             // MySQL Verbindung Aufbauen
            debug($sqldebug, $timestampaktu, "1", "mySQL", "INSERT", "INSERT SUCCESSFULL");
        } else {                                                                        // Anfang mySQL Fehlermeldung Ausgeben (Wenn das Eintragen nicht erfolgreich war)
            echo "<br>Daten nicht erfolgreich in die Datenbank gespeichert!!!<br>";     // Fehlermeldung Ausgeben
            echo mysql_error($link);                                                    // Fehlerbeschreibung Ausgeben
        };
    } else {                                                                                // Ende Responseprüfung
        debug($debugout, $timestampaktu, "1", "bh1750 lux Request", "REQUEST START", "ERROR");
    };
};
?>
