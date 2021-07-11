<?php

$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    if (!$SENDCOMMAND) {
        $SENDCOMMAND = "portstatus";                                                 // Default Sendcommand if no other given
    };
    
    if (!$RECEIVEFILTER) {
        $RECEIVEFILTER = "/PORT ([A-Za-z0-9]+) - ([0-9]+) ([0-9]+) - ([0-9]+) - ([0-9]+) ([0-9]+) - ([0-9]+) ([0-9]+)/"; // Default Recievecommand if no other given
    };
    
    if (!$RECIEVECOMMAND) {
        $RECIEVECOMMAND = "EOF\r\n";                                            // Default Recievecommand if no other given
    };
    
    
    //#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $anzahlzeilen  = '2';														      // Hier wird die Anzahl an Zeilen der Telnetübertragung angegeben die für den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    //$defaultoutput = '1';                                                     // Standard Debug Ausgabe für Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    include ($absolut_pfad . "/daemon/telnetconnector.php");                    // Weitere PHP Dateien Laden

    $response = request($IP,$PORT,$SENDCOMMAND,$defaultoutput,$debug,$RECIEVECOMMAND,$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    if ($response) {
        if ($debug_array == "1") {                                                          // Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   // Debug Ausgabe
            echo '<pre>';                                                                 // Debug Ausgabe
            print_r($response);                                                           // Debug Ausgabe
            echo '</pre>';                                                                // Debug Ausgabe
            echo "#####################################################################"; // Debug Ausgabe
            echo "<br><br><br><br>";                                                      // Debug Ausgabe
        };                                                                              // Ende der Debug Ausgabe

        if ($debug == "0") {                                                            // Prüfen ob Debug abgeschaltet (Damit er keinen muell in die DB schreibt)
            foreach ($response as $responseforeach) {                                     // Schleife für jeden Datensatz
                if (preg_match_all($RECEIVEFILTER, $responseforeach, $matches, PREG_SET_ORDER)) { // der dieser Maske entspricht
                    if ($debug_array2 == "1") {                                               // Anfang Debug Ausgabe
                        echo "### ARRAY DEBUG 2 #################################################"; // Debug Ausgabe
                        echo "<br>";                                                        // Debug Ausgabe
                        echo $matches[0][1];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][2];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][3];                                                // Debug Ausgabe
                                echo " - ";                                                 // Debug Ausgabe
                        echo $matches[0][4];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][5];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][6];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][7];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][8];                                                            // Debug Ausgabe
                        echo "<br>";                                                                    // Debug Ausgabe
                        echo "#####################################################################";   // Debug Ausgabe
                        echo "<br><br><br><br>";                                                        // Debug Ausgabe
                    };                                                                                  // Ende Debug Ausgabe

                    $port = $matches[0][1];                                                       
                    $portstatus = $matches[0][2];                                                 
                    $adcwert = $matches[0][3];
                    $waroffen = $matches[0][4];
                    $dauerstatus1 = $matches[0][5];
                    $dauerstatus1adc = $matches[0][6];  
                    $dauerstatus2 = $matches[0][7];
                    $dauerstatus2adc = $matches[0][8];

                    if ($defaultoutput == "1") { 
                        echo "objektid: <b>" . $objektid . "</b><br>";                           // Debug Ausgabe
                        echo "<br>";
                        echo "PORTSTATUS: <b>" . $portstatus . "</b><br>";                       // Debug Ausgabe
                        echo "ADC: <b>" . $adcwert . "</b><br>";                                 // Debug Ausgabe
                        echo "<br>";
                        echo "Tür war seit letzten check Offen: <b>" . $waroffen . "</b><br>";   // Debug Ausgabe
                        echo "<br>";
                        echo "1. Background Check: <b>" . $dauerstatus1 . "</b><br>";        	 // Debug Ausgabe
                        echo "1. Background Status: <b>" . $dauerstatus1adc . "</b><br>";        // Debug Ausgabe 
                        echo "<br>";
                        echo "2. Background Check: <b>" . $dauerstatus2 . "</b><br>";            // Debug Ausgabe
                        echo "2. Background Status: <b>" . $dauerstatus2adc . "</b><br>";        // Debug Ausgabe
                    }; 
                                                                                                                                                                            // Anfang Daten in die Datenbank Schreiben (Wenn der Wert ok ist)
                    $sql_neu = "INSERT INTO `data` (`wert1`, `wert2`, `wert3`, `wert4`, `wert5`, `wert6`, `wert7`, `objectid`,`timestamp`) VALUES ('$portstatus', '$adcwert', '$waroffen', '$dauerstatus1', '$dauerstatus1adc', '$dauerstatus2', '$dauerstatus2adc', '$MAMS_objektid', NOW())"; //Syntax für Datenbank
                    if ($sqldebug == "1") { echo "<br>" . $sql_neu; };                          // Debug Ausgabe (SQL Syntax)
                    if (mysql_query($sql_neu, $link)) {                                         // MySQL Verbindung Aufbauen
                        if ($defaultoutput == "1") { echo "<br>Daten erfolgreich in die Datenbank gespeichert.<br>"; }; // Ausgabe wenn mySQL Eitnrag erfolgreich
                    } else {                                                                    // Anfang mySQL Fehlermeldung Ausgeben (Wenn das Eintragen nicht erfolgreich war)
                        echo "<br>Daten nicht erfolgreich in die Datenbank gespeichert!!!<br>"; // Fehlermeldung Ausgeben
                        echo mysql_error($link);                                                // Fehlerbeschreibung Ausgeben
                    };                                                                          // Ende mySQL Fehlermeldung Ausgeben
                };                                                                              // Ende Preg Match All
            };                                                                                  // Ende der Schleife für jeden richtigen Datensatz
        };											// Ende Debugpruefung
    };                                                                                          // Ende Responseprüfung
};
?>
