<?php

function funktion_aktor_set($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$absolut_pfad,$link,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3,$SEND_WERT1,$SEND_WERT2,$SEND_WERT3) {

//#DEBUG CONFIG: ##############
    $debug         = '0';                                                       // Debug Ausgabe für den Fall, dass das Script nicht auf EOF Reagiert.
    $debugout      = '1';							// DebugAusgabe Neu
    $debug_array   = '0';                                                       // Debug Ausgabe für Array.
    $debug_array2  = '0';                                                       // Einzelne aus dem Preg_match_all herausgeholte Werte.
    //#############################

    
    include ($absolut_pfad . "/daemon/udpconnector_hexabus.php");                    // Weitere PHP Dateien Laden
    $timestampaktu = time();

    if ($SEND_WERT1 == "0") {
        $funktion = "setoff";
        $checkparameter = "OFF";
    } elseif ($SEND_WERT1 == "100") {
        $funktion = "seton";
        $checkparameter = "ON";
    };
    
    $schalter = request($IP,$PORT,$funktion,$debug,$debug_array);
    if ($schalter != "ERROR") {
        debug($debugout, $timestampaktu, "1", "hexabus set", "REQUEST START", "OK");
        if ($debug_array2 == "1") {                                                      			// Anfang der Debug Ausgabe
            echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
            echo '<pre>';                                                                 			// Debug Ausgabe
            print_r($schalter);                                                                                      // Debug Ausgabe
            echo '</pre>';                                                                			// Debug Ausgabe
            echo "#####################################################################";		 	// Debug Ausgabe
            echo "<br>";
        };

        $schaltercheck = request($IP,$PORT,"getstatus",$debug,$debug_array); 
        if ($schaltercheck) { 
            debug($debugout, $timestampaktu, "1", "hexabus getstatus check", "REQUEST START", "OK");
            debug($debugout, $timestampaktu, "0", "hexabus getstatus check", "DATA FROM REQUEST", $schaltercheck);
            if ($debug_array2 == "1") {                                                      			// Anfang der Debug Ausgabe
                echo "### ARRAY DEBUG ###################################################";   			// Debug Ausgabe
                echo '<pre>';                                                                 			// Debug Ausgabe
                print_r($schaltercheck);                                                                                      // Debug Ausgabe
                echo '</pre>';                                                                			// Debug Ausgabe
                echo "#####################################################################";		 	// Debug Ausgabe
                echo "<br>";
            };
            
            if ($schaltercheck == $checkparameter) {
                debug($debugout, $timestampaktu, "1", "hexabus getstatus check", "CHECK DATA", "ALL OK");
            } else {
                debug($debugout, $timestampaktu, "1", "hexabus set Request", "CHECK DATA", "ERROR");
                debug($debugout, $timestampaktu, "0", "hexabus set Request", "DATA FROM REQUEST", $schaltercheck);
            };
        } else {                                                                    // Ende Responseprüfung
            debug($debugout, $timestampaktu, "1", "hexabus set Request", "REQUEST START", "ERROR");
        };
    } else {                                                                    // Ende Responseprüfung
        debug($debugout, $timestampaktu, "1", "hexabus set Request", "REQUEST START", "ERROR");
        debug($debugout, $timestampaktu, "0", "hexabus set Request", "DATA FROM REQUEST", $schalter);
    };
};
?>