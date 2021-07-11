<?php

$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    if (!$SENDCOMMAND) {
        $SENDCOMMAND = "dht11";                                                 // Default Sendcommand if no other given
    };
    
    if (!$RECEIVEFILTER) {
        $RECEIVEFILTER = "/Temperatur: ([0-9.+-]+) C und Luftfeuchtigkeit: ([0-9.+-]+) %/"; // Default Recievecommand if no other given
    };
    
    if (!$RECIEVECOMMAND) {
        $RECIEVECOMMAND = "EOF\r\n";                                            // Default Recievecommand if no other given
    };
    
    
    //#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe f�r den Fall, dass das Script nicht auf EOF Reagiert.
    $anzahlzeilen  = '2';														      // Hier wird die Anzahl an Zeilen der Telnet�bertragung angegeben die f�r den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe f�r Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    //$defaultoutput = '1';                                                     // Standard Debug Ausgabe f�r Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    include ($absolut_pfad . "/daemon/telnetconnector.php");                    // Weitere PHP Dateien Laden

    $response = request($IP,$PORT,$SENDCOMMAND,$defaultoutput,$debug,$RECIEVECOMMAND,$anzahlzeilen);  // Subprogramm f�r Telnetabfrage Aufrufen
    if ($response) {
        if ($debug_array == "1") {                                                          // Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";     // Debug Ausgabe
            echo '<pre>';                                                                   // Debug Ausgabe
            print_r($response);                                                             // Debug Ausgabe
            echo '</pre>';                                                                  // Debug Ausgabe
            echo "#####################################################################";   // Debug Ausgabe
            echo "<br><br><br><br>";                                                        // Debug Ausgabe
        };                                                                                  // Ende der Debug Ausgabe

      if ($debug == "0") {                                                                  // Pr�fen ob Debug abgeschaltet (Damit er keinen muell in die DB schreibt)
            foreach ($response as $responseforeach) {                                           // Schleife f�r jeden Datensatz
                //Temperatur: 23 C und Luftfeuchtigkeit: 42 %
                if (preg_match_all($RECEIVEFILTER, $responseforeach, $matches, PREG_SET_ORDER)) {  // der dieser Maske entspricht
                    if ($debug_array2 == "1") {                                                     // Anfang Debug Ausgabe
                        echo "### ARRAY DEBUG 2 #################################################"; // Debug Ausgabe
                        echo "<br>";                                                          // Debug Ausgabe
                        echo $matches[0][1];                                                  // Debug Ausgabe
                        echo " - ";                                                           // Debug Ausgabe
                        echo $matches[0][2];                                                  // Debug Ausgabe
                        //echo " - ";                                                         // Debug Ausgabe
                        //echo $matches[0][3];                                                // Debug Ausgabe
                        echo "<br>";                                                          // Debug Ausgabe
                        echo "#####################################################################"; // Debug Ausgabe
                        echo "<br><br><br><br>";                                              // Debug Ausgabe
                    };                                                                        // Ende Debug Ausgabe

                    $system = "DHT11";
                    $temperatur = $matches[0][1];                                               // Gefundenen Wert in Variable schreiben
                    $luftfeuchtigkeit = $matches[0][2];                                         // Gefundenen Wert in Variable schreiben

                    if ($defaultoutput == "1") { 
                        echo "Sensor <b>" . $MAMS_objektid . "</b> :" . "<br>" . "Die Temperatur betraegt <b>" . $temperatur . " Grad</b> und die Luftfeuchtigkeit liegt bei <b>" . $luftfeuchtigkeit . "</b> Prozent"; // Debug Ausgabe
                    }; 

                    if ($luftfeuchtigkeit >= "255") {                                                                           // Falsche Temperaturwerte rausfiltern
                        $sql_neu = "INSERT INTO `data` (`wert1`, `wert2`, `objectid`,`timestamp`) VALUES ('$temperatur', '$luftfeuchtigkeit', '$MAMS_objektid', NOW(), '1')"; //Syntax f�r Datenbank
                    } else {                                                                                                    // Anfang Daten in die Datenbank Schreiben (Wenn der Wert ok ist)
                        $sql_neu = "INSERT INTO `data` (`wert1`, `wert2`, `objectid`,`timestamp`) VALUES ('$temperatur', '$luftfeuchtigkeit', '$MAMS_objektid', NOW())"; //Syntax f�r Datenbank
                    };

                    if ($sqldebug == "1") { echo "<br>" . $sql_neu; };                                                          // Debug Ausgabe (SQL Syntax)

                    if (mysql_query($sql_neu, $link)) {                                                                         // MySQL Verbindung Aufbauen
                        if ($defaultoutput == "1") { echo "<br>Daten erfolgreich in die Datenbank gespeichert.<br>"; };         // Ausgabe wenn mySQL Eitnrag erfolgreich
                    } else {                                                                                                    // Anfang mySQL Fehlermeldung Ausgeben (Wenn das Eintragen nicht erfolgreich war)
                        echo "<br>Daten nicht erfolgreich in die Datenbank gespeichert!!!<br>";                                 // Fehlermeldung Ausgeben
                        echo mysql_error($link);                                                                                // Fehlerbeschreibung Ausgeben
                    };                                                                                                          // Ende mySQL Fehlermeldung Ausgeben
                };                                                                                                              // Ende Preg Match All
            };                                                                                                                  // Ende der Schleife f�r jeden richtigen Datensatz
        };                                                                                                                      // Ende Debugpruefung
    };                                                                                                                          // Ende Responsepr�fung
};
?>
