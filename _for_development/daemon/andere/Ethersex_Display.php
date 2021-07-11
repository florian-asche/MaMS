<?php

//Example for Parameter2:
//echo date("H:i:s") . " " . getlastdata($sysconfig,"MAMS-ec1d80d24fd2c0d5ab63","wert1");

function funktion_other_php_job($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$objektid,$sensortype,$absolut_pfad,$link,$sysconfig,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
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

    //$channel = strtolower($PARAMETER1);                                         // Großbuchstaben in Kleinbuchstaben umwandeln
    
    //lcd clear
    $lcd_clear = request($IP,$PORT,"lcd clear",$defaultoutput,$debug,"EGAL",$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    //lcd goto
    $lcd_goto = request($IP,$PORT,"lcd goto " . $PARAMETER1,$defaultoutput,$debug,"EGAL",$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    //lcd write
    ob_start();
    eval($PARAMETER2);
    $ausgabetext = ob_get_contents();
    ob_end_clean();
    echo "<br>";
    echo "DEBUG=" . $ausgabetext;
    echo "<br>";
    $lcd_write = request($IP,$PORT,"lcd write " . $ausgabetext,$defaultoutput,$debug,"EGAL",$anzahlzeilen);  // Subprogramm für Telnetabfrage Aufrufen
    
    if ($lcd_write) {
        debug($debugout, $timestampaktu, "1", "lcd write", "REQUEST START", "OK");
        if ($debug_array == "1") {                                                      			// Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
            echo '<pre>';                                                                 			// Debug Ausgabe
            print_r($lcd_write);                                                                                      // Debug Ausgabe
            echo '</pre>';                                                                			// Debug Ausgabe
            echo "#####################################################################";		 	// Debug Ausgabe
            echo "<br>";
        };                                                                              			// Ende der Debug Ausgabe
        debug($debugout, $timestampaktu, "0", "lcd write", "DATA FROM REQUEST", $lcd_write[0]);
        // Das "i" nach der Suchmuster-Begrenzung kennzeichnet eine Suche ohne
        // Berücksichtigung von Groß- und Kleinschreibung
        if ($lcd_write[0] == "OK") {
                debug($debugout, $timestampaktu, "0", "lcd write Request", "DATA", "ALL OK");
                echo "Display erfolgreich gesetzt!"; // Erfolgsmeldung ausgeben
        } else {
                debug($debugout, $timestampaktu, "1", "lcd write Request", "DATA", "ERROR");
                echo "ERROR: <b>Display NICHT GESETZT!</b> (" . $lcd_write[0] . ")";// Fehlermeldung ausgeben
        };
    } else {                                                                    // Ende Responseprüfung
        debug($debugout, $timestampaktu, "1", "lcd write Request", "REQUEST START", "ERROR");
        echo "ERROR: <b>Display NICHT GESETZT!</b> (" . $lcd_write[0] . ")";        // Fehlermeldung ausgeben
    };
};
?>
