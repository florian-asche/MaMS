<?php

function request($IP,$PORT,$request,$defaultoutput,$debug,$answerstring,$anzahlzeilen) {      // Anfang Subprogramm für Telnetabfrage
	#DEBUG CONFIG: ##############
	$debugausgabe = '0';                                                          // Ausgabe der Daten wie sie von der Telnet Schnittstelle kommen.
	$asciidebug   = '0';                                                          // Ausgabe der Daten in Ascii wie sie von der Telnet Schnittstelle kommen.
	#############################
	#echo "-" . $IP . "-" . $PORT;
	$rs = fsockopen($IP, $PORT, $errno, $errstr);						                            // Port oeffnen
	if (!$rs) { 
		echo "Error: Die Verbindung zum Telnetserver konnte nicht aufgebaut werden.";
                exit;
	} else {
		#### TELNET CONNECTOR TIMEOUT: ####
		stream_set_timeout($rs,30); 
		###################################
		$response = "";								                                // Response Variable leeren
		$request = $request . "\r\n";						                        // Sendevariable mit enter versehen
		if ($defaultoutput == "1") { echo "Verbindung zum Telnetserver erfolgreich aufgebaut...<br>"; };
		#echo "<br>";
		fputs($rs, $request);							                            // Daten auf den Port schreiben und empfangsdaten in Variable schreiben
		if ($debug == "0") {
			##################################################################################################################################################################################
			while (($line = fgets($rs)) !== $answerstring) {		                    // Anfang der Schleife für Datenübergabe (http://php.net/manual/de/function.fgets.php)                           
			if ($line === false) { 
				echo "Error: Connection Interrupted";
				break; 
			};
		
			$saubereVariable = str_replace(chr(13), '', $line);     	            // \r und \n aus dem String entfernen
			$saubereVariable = str_replace(chr(10), '', $saubereVariable);     	    // \r und \n aus dem String entfernen
			if ($asciidebug == "1") {                                               // Anfang Ascii Debug Ausgabe (Prüfen ob Ascii Debugger an ist)
				echo $saubereVariable;                                              // Debug Ausgabe
				echo "=";                                                           // Debug Ausgabe
				str2ascii($saubereVariable); 				                        // Debug Ausgabe
			};                                                                      // Ende Ascii Debug Ausgabe
			if ($debugausgabe == "1") {                                             // Anfang Debug Ausgabe (Prüfen ob Debugger an ist)
				echo $saubereVariable . "<br>";				                        // Debug ausgeben
			};                                                                      // Ende Debug Ausgabe
			$data[] = $saubereVariable;                                             // Daten an Variable übergeben
		};                                                                          // Ende der Schleife für Datenübergabe
		return $data;                                                             // Daten aus dem Subprogramm Ausgeben
		##################################################################################################################################################################################
		} else {                                                                  // Anfang der Debug Ausgabe (Debug Ausgabe fuer den Fall, dass nicht auf EOF reagiert wird)
			for ($i = 1; $i <= $anzahlzeilen; $i++) {                                           // Anfang Schleife für Ausgabe
				echo "<br>Ausgabe Nr.: " . $i . "<br>";                               // Debug Ausgabe
				$tempausgabe = fgets($rs);                                            // Debug Ausgabe
				echo $tempausgabe;                                                    // Debug Ausgabe
				if ($asciidebug == "1") { str2ascii($tempausgabe); };                 // Debug Ausgabe
			};                                                                      // Ende Schleife für Ausgabe
		};                                                                        // Ende der Debug Ausgabe
		fclose($rs);									                                            // Port schliessen  
	};                                                                            // Ende Subprogramm für Telnetabfrage
};

function str2ascii($string) {							                                      // Anfang des Ascii Debuggers
	for($charcounter = 0; $charcounter < strlen($string); $charcounter++) {       // Anfang Schleife fuer jedes Zeichen
		$ascii .= ord($string[$charcounter]);                                       // Debug Ausgabe
		echo ord($string[$charcounter]);                                            // Debug Ausgabe
		echo ",";                                                                   // Debug Ausgabe
	};                                                                            // Ende des Ascii Debuggers
	echo "<br><br>";                                                              // Zeilenumbruch für Debug Ausgabe
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
