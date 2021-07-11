<?php

$station_protokoll_objektid_generieren = "1";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_station_getdata($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    $channel = strtolower($PARAMETER1);                                         // Gro�buchstaben in Kleinbuchstaben umwandeln
    
    if (!$SENDCOMMAND) {
        $SENDCOMMAND = "portstatus";                                      // Default Sendcommand if no other given
    };
    
    if (!$RECEIVEFILTER) {
        $RECEIVEFILTER = "/PORT ([A-Za-z0-9]+) - ([0-9]+) ([0-9]+) - ([0-9]+) - ([0-9]+) ([0-9]+) - ([0-9]+) ([0-9]+)/"; // Default Recievecommand if no other given
    };
    
    if (!$RECIEVECOMMAND) {
        $RECIEVECOMMAND = "EOF\r\n";                                            // Default Recievecommand if no other given
    };
    
    
    //#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe f�r den Fall, dass das Script nicht auf EOF Reagiert.
    $anzahlzeilen  = '2';														      // Hier wird die Anzahl an Zeilen der Telnet�bertragung angegeben die f�r den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe f�r Array.
    $debug_array2  = '1';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    //$defaultoutput = '1';                                                     // Standard Debug Ausgabe f�r Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    #Formel zur Umrechnung############
    # 0%   -> 1023                   #
    # 100% ->   0                    #
    # -------------------------------#
    # n = Zahl                       #
    # P = Prozent                    #
    # -------------------------------# 
    # P = (1023 - n) / 1023 * 100    #
    # n = 1023 - (P * 1023 / 100)    #
    ##################################
    
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

        if ($debug == "0") {                                                                // Pr�fen ob Debug abgeschaltet (Damit er keinen muell in die DB schreibt)
            foreach ($response as $responseforeach) {                                       // Schleife f�r jeden Datensatz
                if (preg_match_all($RECEIVEFILTER, $responseforeach, $matches, PREG_SET_ORDER)) { // der dieser Maske entspricht
                    if ($debug_array2 == "1") {                                               // Anfang Debug Ausgabe
                        echo "### ARRAY DEBUG 2 #################################################"; // Debug Ausgabe
                        echo "<br>";                                                        // Debug Ausgabe
                        echo $matches[0][1];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][2];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
                        echo $matches[0][3];                                                // Debug Ausgabe
                        echo " - ";                                                         // Debug Ausgabe
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
                    }; 
                    
                    $objektid = $MAMS_objektid;                                 // objektid Zusammensetzen
                    $adc1 = $matches[0][3];
                    $adc1_feuchte = round(((1023-$adc1)/1023*100),0); // Wert des Microcontrollers in % umrechen
                    $adc2 = $matches[0][6];
                    $adc2_feuchte = round(((1023-$adc2)/1023*100),0); // Wert des Microcontrollers in % umrechen
                    $adc3 = $matches[0][8];
                    $adc3_feuchte = round(((1023-$adc3)/1023*100),0); // Wert des Microcontrollers in % umrechen

                    if ($defaultoutput == "1") { 
                        echo "objektid: <b>" . $objektid . "<br>"; // Debug Ausgabe
                        echo "</b>ADC Direktmessung: " . $adc1 . " = " . $adc1_feuchte . "% Feuchte.<br>";
                        echo "</b>ADC Background 1: " . $adc2 . " = " . $adc2_feuchte . "% Feuchte.<br>";
                        echo "</b>ADC Background 2: " . $adc3 . " = " . $adc3_feuchte . "% Feuchte.<br>";
                    }; 
                    
                    $sql_neu = "INSERT INTO `data` (`wert1`, `wert2`, `wert3`, `wert4`,`wert5`, `wert6`, `objectid`,`timestamp`) VALUES ('$adc1_feuchte', '$adc2_feuchte', '$adc3_feuchte', '$adc1', '$adc2', '$adc3', '$objektid', NOW())"; //Syntax f�r Datenbank
                    if ($sqldebug == "1") { echo "<br>" . $sql_neu; };                          // Debug Ausgabe (SQL Syntax)
                    if (mysql_query($sql_neu, $link)) {                                         // MySQL Verbindung Aufbauen
                        if ($defaultoutput == "1") { echo "<br>Daten erfolgreich in die Datenbank gespeichert.<br>"; };       // Ausgabe wenn mySQL Eitnrag erfolgreich
                    } else {                                                                    // Anfang mySQL Fehlermeldung Ausgeben (Wenn das Eintragen nicht erfolgreich war)
                        echo "<br>Daten nicht erfolgreich in die Datenbank gespeichert!!!<br>"; // Fehlermeldung Ausgeben
                        echo mysql_error($link);                                                // Fehlerbeschreibung Ausgeben
                    };                                                                          // Ende mySQL Fehlermeldung Ausgeben
                };                                                                              // Ende Preg Match All
            };                                                                                  // Ende der Schleife f�r jeden richtigen Datensatz
        };											// Ende Debugpruefung
    };                                                                                          // Ende Responsepr�fung
};
?>
