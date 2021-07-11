<?php

$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    if (!$SENDCOMMAND) {
        $SENDCOMMAND = "D";                                                 // Default SENDCOMMAND if no other given
        
    };
    
    if (!$RECEIVEFILTER) {
        //  D: [dW] [DD.MM.YY] [mm:hh:ss] [A] V: [VV] I: [IIII] S: [SSSS] B: [BBBB] Is: [IsIs] [X] [W]
        //  D: d4 01.01.09 12:28:16 A V: 30 I: 2360 S: 1650 B: 3236 Is: f793
        //$RECEIVEFILTER = "/([0-9A-Z]+) Temperatur ([0-9]+): ([0-9.+-]+) Grad/"; // Default RECEIVEFILTER if no other given
        $RECEIVEFILTER = "/D: d([0-9]+) ([0-9]+).([0-9]+).([0-9]+) ([0-9]+):([0-9]+):([0-9]+) ([A-Z-]+) V: ([0-9]+) I: ([0-9]+) S: ([0-9]+) B: ([0-9]+) Is: /"; // Default RECEIVEFILTER if no other given
    };
    
    if (!$RECIEVECOMMAND) {
        $RECIEVECOMMAND = "EOF\n";                                              // Default RECIEVECOMMAND if no other given
    };
    
    
    //#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $anzahlzeilen  = '2';						        // Hier wird die Anzahl an Zeilen der Telnetübertragung angegeben die für den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    $defaultoutput = '0';                                                       // Standard Debug Ausgabe für Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    include ($absolut_pfad . "/daemon/telnetconnector.php");                    // Weitere PHP Dateien Laden

    //$response = request($IP,$PORT,"1wire",$defaultoutput,$debug,"EOF\r\n",$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    $response = request($IP,$PORT,$SENDCOMMAND,$defaultoutput,$debug,$RECIEVECOMMAND,$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    if ($response) {
        if ($debug_array == "1") {                                              // Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   // Debug Ausgabe
            echo '<pre>';                                                                 // Debug Ausgabe
            print_r($response);                                                           // Debug Ausgabe
            echo '</pre>';                                                                // Debug Ausgabe
            echo "#####################################################################"; // Debug Ausgabe
            echo "<br><br><br><br>";                                            // Debug Ausgabe
        };                                                                      // Ende der Debug Ausgabe

        if ($debug == "0") {                                                    // Prüfen ob Debug abgeschaltet (Damit er keinen muell in die DB schreibt)
            foreach ($response as $responseforeach) {                           // Schleife für jeden Datensatz
                if (preg_match_all($RECEIVEFILTER, $responseforeach, $matches, PREG_SET_ORDER)) {       // der dieser Maske entspricht
                    if ($debug_array2 == "1") {                                                         // Anfang Debug Ausgabe
                        echo "### ARRAY DEBUG 2 #################################################";     // Debug Ausgabe
                        echo '<pre>';                                                                 // Debug Ausgabe
                        print_r($matches);                                                           // Debug Ausgabe
                        echo '</pre>';                                                               // Debug Ausgabe
                        echo "#####################################################################";   // Debug Ausgabe
                        echo "<br><br><br><br>";                                                        // Debug Ausgabe
                    };                                                                                  // Ende Debug Ausgabe

                    // D
                    // D: [dW] [DD.MM.YY] [mm:hh:ss] [A] V: [VV] I: [IIII] S: [SSSS] B: [BBBB] Is: [IsIs] [X] [W]
                    // D: d5 01.01.10 12:03:05 - V: 80 I: 2154 S: 3050 B: 3233 Is: 00000000 Ib: 06 Ic: 28 Ie: 1e E:04 X // NEW
                    // D: d4 01.01.09 13:21:16 A V: 30 I: 2140 S: 1650 B: 3236 Is: ef56 X
                    // 
                    // [0] => D: d4 01.01.09 13:21:16 A V: 30 I: 2140 S: 1650 B: 3236 Is: 
                    // [1] => 4
                    // [2] => 01
                    // [3] => 01
                    // [4] => 09
                    // [5] => 13
                    // [6] => 21
                    // [7] => 16
                    // [8] => A
                    // [9] => 30
                    // [10] => 2140
                    // [11] => 1650
                    // [12] => 3236
                    // 
                    // [dW] 	Wochentag (Montag = d1, Dienstag = d2 usw.)
                    // [DD.MM.YY] 	aktuelles Datum
                    // [mm:hh:ss] 	aktuelle Uhrzeit (mm...Minute, hh...Stunde, ss...Sekunde)
                    // [A] 	Modus (A... Automatik, M...Manuell)
                    // [VV] 	aktuelle Ventilposition in %
                    // [IIII] 	aktuelle Temperatur (2368 entspricht 23,68 °C)
                    // [SSSS] 	gewünschte Temperatur
                    // [BBBB] 	Batteriespannung in mV
                    // [IsIs] 	 ?
                    // [X] 	X...Statusbericht vom Nutzer angefordert
                    // kein X... automatisch erzeugter Statusbericht
                    // [W] 	Fenster ist geöffnet 
                    
                    $modus_raw = $matches[0][8];
                    
                    if ($modus_raw == "A") {
                        $modus = "1";
                    } else {
                        $modus = "0";
                    };
                    
                    $ventilpos = $matches[0][9];
                    $temperatur_raw = $matches[0][10];
                    $temperatur = number_format($temperatur_raw / 100, 2);
                    $solltemperatur_raw = $matches[0][11];
                    $solltemperatur = number_format($solltemperatur_raw / 100, 2);
                    $batt_raw = $matches[0][12];
                    $batt = number_format($batt_raw / 1000, 2);
                    
                    if ($defaultoutput == "1") {                                // Debug Ausgabe
                        echo "Sensor: " . $MAMS_objektid;
                        echo "<br>";
                        echo "Temperatur: " . $temperatur;  
                        echo "<br>";
                        echo "SOLL-Temperatur: " . $solltemperatur;
                        echo "<br>";
                        echo "Modus:" . $modus;
                        echo "<br>";
                        echo "Ventilposition: " . $ventilpos;
                        echo "<br>";
                        echo "Batteriespannung: " . $batt;
                        echo "<br>";
                    }; 
                    
                    $sql_neu = "INSERT INTO `data` (`wert1`, `wert2`, `wert3`, `wert4`, `wert5`, `objectid`, `timestamp`) VALUES ('" . $temperatur . "', '" . $solltemperatur . "', '" . $modus . "', '" . $ventilpos . "', '" . $batt . "', '" . $MAMS_objektid . "', NOW())"; //Syntax für Datenbank
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
