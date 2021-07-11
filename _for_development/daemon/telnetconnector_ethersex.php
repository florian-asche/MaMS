<?php

function request($IP,$PORT,$request,$defaultoutput,$debug,$answerstring,$anzahlzeilen) {

    $rs = fsockopen($IP, $PORT, $errno, $errstr);				// Port oeffnen
    $timestampaktu = time();
    if (!$rs) { 
        debug($defaultoutput, $timestampaktu, "0", "ERROR", "Couldnt open the connection to telnet server", "");
        exit;
    } else {
        #### TELNET CONNECTOR TIMEOUT: ####
        stream_set_timeout($rs,30); 
        ###################################
        $response = "";                                                         // Response Variable leeren
        $request = "" . $request . "\r\n";                                      // Sendevariable mit enter versehen
        debug($defaultoutput, $timestampaktu, "0", "", "Connection to target successfully opened", "");
        fputs($rs, $request);                                                   // Daten auf den Port schreiben und empfangsdaten in Variable schreiben
        $datacount = 0;
        while ($line = fgets($rs)) {
            // http://php.net/manual/de/function.fgets.php    
            $datacount++;    
            $saubereVariable = str_replace(chr(13), '', $line);     	        // \r und \n aus dem String entfernen
            $saubereVariable = str_replace(chr(10), '', $saubereVariable);     	// \r und \n aus dem String entfernen
            $data[] = $saubereVariable;                                         // Daten an Variable übergeben
            debug($defaultoutput, $timestampaktu, "0", "GET DATA RAW", "", $saubereVariable);
            debug($defaultoutput, $timestampaktu, "0", "GET DATA RAW-ASCII", $saubereVariable, str2ascii($saubereVariable));

            if ($line === false) {
                debug($defaultoutput, $timestampaktu, "0", "ERROR", "Connection Interrupted", "");
                break; 
            } elseif (preg_match_all("/" . $answerstring . "/", $saubereVariable, $matches, PREG_SET_ORDER)) {
                debug($defaultoutput, $timestampaktu, "0", "ENDE", "ReturnstringREGEX found in CLEAN-LINE", $saubereVariable);
                break;
            } elseif (preg_match_all("/" . $answerstring . "/", $line, $matches, PREG_SET_ORDER)) {
                debug($defaultoutput, $timestampaktu, "0", "ENDE", "ReturnstringREGEX found in LINE", $saubereVariable);
                break;
            } elseif ($saubereVariable == $answerstring) {
                debug($defaultoutput, $timestampaktu, "0", "ENDE", "Returnstring found in CLEAN-LINE", $saubereVariable);
                break;
            } elseif ($line == $answerstring) {
                debug($defaultoutput, $timestampaktu, "0", "ENDE", "Returnstring found in LINE", $saubereVariable);
                break;
            } elseif ($saubereVariable == "parse error") {
                debug($defaultoutput, $timestampaktu, "0", "ERROR", "Error returned", "");
                break;
            } elseif ($saubereVariable == "ERROR") {
                debug($defaultoutput, $timestampaktu, "0", "ERROR", "Error returned", "");
                break;
            } elseif ($saubereVariable == "EOF") {
                debug($defaultoutput, $timestampaktu, "0", "ENDE", "EOF found", $saubereVariable);
                break;
            } elseif ($saubereVariable == "OK") {
                debug($defaultoutput, $timestampaktu, "0", "ENDE", "OK found", $saubereVariable);
                break;
            } elseif ($datacount >= $anzahlzeilen) {
                if ($debug == "1") {
                    debug($defaultoutput, $timestampaktu, "0", "DEBUG MODE IS ON", "ANZAHLZAHLZEILEN COUNT REACHED", "");
                    break;
                };
            } elseif (feof($rs)) {
                if (feof($line) == true) { echo "TRUE"; };
                if (feof($line) == false) { echo "FALSE"; };
                // Der Zeiger auf eine Datei muss gültig sein und auf eine Datei verweisen,
                // die vorher erfolgreich mit fopen() oder fsockopen() geöffnet 
                // (und nicht bereits von fclose() geschlossen) wurde.
                debug($defaultoutput, $timestampaktu, "0", "ERROR", "FEOF found", "");
                break;
            };
        };
        echo "<br><br>";
        return $data;
    fclose($rs);                                                                // Port schliessen
    };
};

function str2ascii($string) {							// Anfang des Ascii Debuggers
    $ascii = "";
    $asciidata = "";
    for($charcounter = 0; $charcounter < strlen($string); $charcounter++) {     // Anfang Schleife fuer jedes Zeichen
        $ascii .= ord($string[$charcounter]);
        $asciidata .= ord($string[$charcounter]);
        $asciidata .= ",";
    };                                                                      
    return $asciidata;                                                          // Daten übergeben
};

#SAMPLE AUSGABE IN ASCII:
#  505653485354495348504848484867703284101109112101114971161171143249583243504946563271114971001310
#  505666485250495348504848484856533284101109112101114971161171143250583243514846563271114971001310
#  505653575270495348504848484868543284101109112101114971161171143251583243524846513271114971001310
#  505669705452495348504848484869663284101109112101114971161171143252583243514946493271114971001310
#  505653485354495348505353535365763284101109112101114971161171143253583243514946483271114971001310
#  69 79 70 1310

#SAMPLE (EOF AUSWERTUNG AM ENDE DER AUSGABE):
#  69 = E
#  79 = O
#  70 = F
#  13 = CR steht fuer .Carriage Return. und entspricht dem \r (return).
#  10 = LF steht fuer .Line Feed. und entspricht dem \n (newline).
?>
