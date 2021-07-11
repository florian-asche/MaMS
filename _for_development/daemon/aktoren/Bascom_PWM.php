<?php

function funktion_aktor_set($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3,$SEND_WERT1,$SEND_WERT2,$SEND_WERT3) {
//    if (!$SENDCOMMAND) {
//        $SENDCOMMAND = "pwmset?";                                    // Default Sendcommand if no other given
//    };
    
//    if (!$RECEIVEFILTER) {
//        $RECEIVEFILTER = "/CHAN ([A-Z]+) ([0-9]+)/"; // Default Recievecommand if no other given
//    };
    
    if (!$RECIEVECOMMAND) {
        $RECIEVECOMMAND = "EOF\r\n";                                            // Default Recievecommand if no other given
    };
    

//#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $debugout      = '1';							// DebugAusgabe Neu
    $anzahlzeilen  = '1';							// Hier wird die Anzahl an Zeilen der Telnetübertragung angegeben die für den Debug erwartet wird.
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    $defaultoutput = '0';                                                       // Standard Debug Ausgabe für Logfile
    $sqldebug      = '0';                                                       // Ausgabe des MySQL Strings, so wie er in an die Datenbank gegeben wird.
    //#############################

    #Formel zur Umrechnung############
    # 0%   -> 160                    #
    # 100% ->   0                    #
    # -------------------------------#
    # n = Zahl                       #
    # P = Prozent                    #
    # -------------------------------# 
    # P = (160 - n) / 160 * 100      #
    # n = 160 - (P * 160 / 100)      #
    ##################################

    include ($absolut_pfad . "/daemon/telnetconnector.php");                    // Weitere PHP Dateien Laden
    $timestampaktu = time();

    $pwmmaximal = "255";                                                            //
    $pwmwert = $pwmmaximal-($SEND_WERT1*$pwmmaximal/100);                           // Wert des Microcontrollers in % umrechen

    $channel = strtolower($PARAMETER1);                                         // Großbuchstaben in Kleinbuchstaben umwandeln
    $pwm = request($IP,$PORT,"pwmset" . $channel . $pwmwert,$defaultoutput,$debug,$RECIEVECOMMAND,$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen    
    if ($pwm) {
        debug($debugout, $timestampaktu, "1", "pwm set", "REQUEST START", "OK");
        if ($debug_array == "1") {                                                      			// Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
            echo '<pre>';                                                                 			// Debug Ausgabe
            print_r($pwm);                                                                                      // Debug Ausgabe
            echo '</pre>';                                                                			// Debug Ausgabe
            echo "#####################################################################";		 	// Debug Ausgabe
            echo "<br>";
        };                                                                              			// Ende der Debug Ausgabe
        debug($debugout, $timestampaktu, "0", "pwm set", "DATA FROM REQUEST", $pwm[0]);
        // Das "i" nach der Suchmuster-Begrenzung kennzeichnet eine Suche ohne
        // Berücksichtigung von Groß- und Kleinschreibung
        if ($pwm[0] == $pwmwert) {
                debug($debugout, $timestampaktu, "0", "pwm set Request", "DATA", "ALL OK");
                echo "Pwm erfolgreich auf <b>" . $SEND_WERT1 . "</b> gesetzt!"; // Erfolgsmeldung ausgeben
        } else {
                debug($debugout, $timestampaktu, "1", "pwm set Request", "DATA", "ERROR");
                echo "ERROR: <b>PWM NICHT GESETZT!</b> (" . $pwm[0] . ")";// Fehlermeldung ausgeben
        };
    } else {                                                                    // Ende Responseprüfung
        debug($debugout, $timestampaktu, "1", "pwm set Request", "REQUEST START", "ERROR");
        echo "ERROR: <b>PWM NICHT GESETZT!</b> (" . $pwm[0] . ")";        // Fehlermeldung ausgeben
    };
};
?>
