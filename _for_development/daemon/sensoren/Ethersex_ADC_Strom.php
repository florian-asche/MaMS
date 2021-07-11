<?php
$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.
$station_protokoll_parameter1          = "Channel";
$station_protokoll_parameter1_example  = "1 - 7";
$station_protokoll_parameter2          = "MAX Strom (in A)";
$station_protokoll_parameter2_example  = "5";
$station_protokoll_parameter3          = "Multiplikator (Manuelle anpassung) (Punkt statt Komma)";
$station_protokoll_parameter3_example  = "4.5";

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    //#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $debugout      = '0';							// DebugAusgabe Neu
    $anzahlzeilen  = '1';							// Hier wird die Anzahl an Zeilen der Telnetübertragung angegeben die für den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    $defaultoutput = '0';                                                       // Standard Debug Ausgabe für Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    include ($absolut_pfad . "/daemon/telnetconnector_ethersex.php");           // Weitere PHP Dateien Laden
    $timestampaktu = time();

    $channel = strtolower($PARAMETER1);                                         // Großbuchstaben in Kleinbuchstaben umwandeln
    $objektid = $MAMS_objektid . "-STROM-" . $PARAMETER1;
    $pwm = request($IP,$PORT,"!adc vget " . $channel,$defaultoutput,$debug,"EGAL",$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    if ($pwm) {
        debug($debugout, $timestampaktu, "1", "adc vget", "REQUEST START", "OK");
        if ($debug_array == "1") {                                                      			// Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
            echo '<pre>';                                                                 			// Debug Ausgabe
            print_r($pwm);                                                                                      // Debug Ausgabe
            echo '</pre>';                                                                			// Debug Ausgabe
            echo "#####################################################################";		 	// Debug Ausgabe
            echo "<br>";
        };                                                                              			// Ende der Debug Ausgabe
        debug($debugout, $timestampaktu, "0", "adc vget", "DATA FROM REQUEST", $pwm[0]);
        // Das "i" nach der Suchmuster-Begrenzung kennzeichnet eine Suche ohne
        // Berücksichtigung von Groß- und Kleinschreibung
        if (preg_match("/([0-9.+-]+)/", $pwm[0])) {
            debug($debugout, $timestampaktu, "0", "adc vget Request", "DATA", "ALL OK");
            $controllerwert = $pwm[0];
            if ($defaultoutput == "1") { 
                            echo "objektid: <b>" . $objektid . "<br>";                      // Debug Ausgabe
                            echo "</b>Controller: " . $controllerwert . "<br>";             // Debug Ausgabe
            };
			
			$multiplikator = ($PARAMETER2/2.50);
			$stromwert1 = ($controllerwert/1000);											// Wert des Microcontrollers umrechen
            $stromwert2 = ($stromwert1-2.50);                            					// ...
			$stromwert3 = ($stromwert2*$multiplikator);                            			// ...
			$stromwert4 = ($stromwert2*$PARAMETER3);                            			// ...
			
            if ($defaultoutput == "1") { echo "Umgerechnet: " . $stromwert4 . "%"; };          // Debug Ausgabe
            $sql_neu = "INSERT INTO `data` (`wert1`, `wert2`, `objectid`,`timestamp`) VALUES ('$stromwert4', '$controllerwert', '$objektid', NOW())"; //Syntax für Datenbank
            debug($sqldebug, $timestampaktu, "1", "mySQL", "INSERT", $sql_neu);
            if (mysql_query($sql_neu, $link)) {                                             // MySQL Verbindung Aufbauen
                debug($sqldebug, $timestampaktu, "1", "mySQL", "INSERT", "INSERT SUCCESSFULL");
            } else {                                                                        // Anfang mySQL Fehlermeldung Ausgeben (Wenn das Eintragen nicht erfolgreich war)
                echo "<br>Daten nicht erfolgreich in die Datenbank gespeichert!!!<br>";     // Fehlermeldung Ausgeben
                echo mysql_error($link);                                                    // Fehlerbeschreibung Ausgeben
            };
        } else {
            debug($debugout, $timestampaktu, "1", "sht temp Request", "DATA", "ERROR");
        };
    } else {                                                                                // Ende Responseprüfung
        debug($debugout, $timestampaktu, "1", "sht temp Request", "REQUEST START", "ERROR");
    };
};
?>
