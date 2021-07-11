<?php

function funktion_aktor_set($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3,$SEND_WERT1,$SEND_WERT2,$SEND_WERT3) {
//    if (!$SENDCOMMAND) {
//        $SENDCOMMAND = "pwmset?";                                             // Default Sendcommand if no other given
//    };
    
//    if (!$RECEIVEFILTER) {
//        $RECEIVEFILTER = "/CHAN ([A-Z]+) ([0-9]+)/"; // Default Recievecommand if no other given
//    };
    
    if (!$RECIEVECOMMAND) {
        $RECIEVECOMMAND = "EOF\n";                                              // Default Recievecommand if no other given
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

    
    include ($absolut_pfad . "/daemon/telnetconnector.php");                    // Weitere PHP Dateien Laden
    $timestampaktu = time();

    echo "DB=" . $SEND_WERT1;
    echo "<br>";
    
    if ($SEND_WERT1 == "100") {
        $param_to_send = "O";
    } elseif ($SEND_WERT1 == "0") {
        $param_to_send = "C";
    } else {
        $param_to_send_raw = $SEND_WERT1 * 2;
        $param_to_send = "A" . dechex($param_to_send_raw);
    }
    
    echo "SENDE: " . $param_to_send;
    //exit;
    echo "<br>";

    $telnet_return = request($IP,$PORT,$param_to_send,$defaultoutput,$debug,$RECIEVECOMMAND,$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen    
    if ($telnet_return) {
        debug($debugout, $timestampaktu, "1", "hr20 set", "REQUEST START", "OK");
        if ($debug_array == "1") {                                                      			// Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
            echo '<pre>';                                                                 			// Debug Ausgabe
            print_r($telnet_return);                                                                                      // Debug Ausgabe
            echo '</pre>';                                                                			// Debug Ausgabe
            echo "#####################################################################";		 	// Debug Ausgabe
            echo "<br>";
        };                                                                              			// Ende der Debug Ausgabe
        debug($debugout, $timestampaktu, "0", "hr20 set", "DATA FROM REQUEST", $telnet_return[0]);
        // Das "i" nach der Suchmuster-Begrenzung kennzeichnet eine Suche ohne
        // Berücksichtigung von Groß- und Kleinschreibung
//        if ($telnet_return[0] == $pwmwert) {
//                debug($debugout, $timestampaktu, "0", "hr20 set Request", "DATA", "ALL OK");
//                echo "HR20 erfolgreich auf <b>" . $SEND_WERT1 . "</b> gesetzt!"; // Erfolgsmeldung ausgeben
//        } else {
//                debug($debugout, $timestampaktu, "1", "hr20 set Request", "DATA", "ERROR");
//                echo "ERROR: <b>WERT NICHT GESETZT!</b> (" . $telnet_return[0] . ")";// Fehlermeldung ausgeben
//        };
    } else {                                                                    // Ende Responseprüfung
        debug($debugout, $timestampaktu, "1", "hr20 set Request", "REQUEST START", "ERROR");
        echo "ERROR: <b>WERT NICHT GESETZT!</b> (" . $telnet_return[0] . ")";        // Fehlermeldung ausgeben
        exit(1);
    };
};
?>
