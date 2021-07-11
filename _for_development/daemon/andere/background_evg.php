<?php
//background_evg_calculation($link,$PARAMETER1,$objektid,$sensortype);
//function background_evg_calculation($link,$PARAMETER1,$objektid,$sensortype) {

$station_protokoll_objektid_generieren = "0";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_other_php_job($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$objektid,$sensortype,$absolut_pfad,$link,$sysconfig,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    $timestampaktu = time();
    $dbname_time = $PARAMETER1 . "h";
    $stunden = $PARAMETER1;

    //-Eintraege in der Datenbank Loeschen-------------------------------------------------------------------------------------------------------
    $clearSQL = "DELETE FROM `calc_evg` WHERE `time`='" . $dbname_time . "'" ; // Datenbank Befehl Setzen (Alle Einträ mit Type "tag" Loeschen!)
    if (mysql_query($clearSQL, $link)) {
        echo "Datenbank wurde erfolgreich geloescht.";
    } else { 
        echo "Es traten Probleme beim loeschen der Eintraege auf.";             // Ausgabe ob Datenbankausfü erfolgreich war
    };
    echo "<br>";
    //-------------------------------------------------------------------------------------------------------------------------------------------
    //echo "TIME: " . $timestampaktu;
    //echo "<br>";
    $minuten = $stunden * 60;
    $sekunden = $minuten * 60;
    //echo $sekunden;
    //echo "<br>";
    $timestampvon = $timestampaktu - $sekunden;
    //echo $timestampvon;
    //echo "<br><br>";

    //print_r($objektid);
    echo "<hr>";
    foreach($objektid as $objektid_foreach) {                                   // Auslesen der Sensoren aus der Konfigurationsdatei
        if ($objektid_foreach['active'] == "1") {                                // Prüob der Sensor ausgegeben werden soll. (Variable ist in der Sensoren Konfiguarion gespeichert, welche aus dem Setup Generiert wird.)
            //echo "objektid: " . $objektid_foreach[objektid];
            //echo "<br>";
            $system = $objektid[$objektid_foreach['objektid']]['template'];
            //echo "SYSTEM: " . $system;
            //echo "<br>";
            if ($sensortype[$system]['wert9'] != "") {
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, avg(wert4) AS wert4, avg(wert5) AS wert5, avg(wert6) AS wert6, avg(wert7) AS wert7, avg(wert8) AS wert8, avg(wert9) AS wert9, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert8'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, avg(wert4) AS wert4, avg(wert5) AS wert5, avg(wert6) AS wert6, avg(wert7) AS wert7, avg(wert8) AS wert8, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert7'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, avg(wert4) AS wert4, avg(wert5) AS wert5, avg(wert6) AS wert6, avg(wert7) AS wert7, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert6'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, avg(wert4) AS wert4, avg(wert5) AS wert5, avg(wert6) AS wert6, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert5'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, avg(wert4) AS wert4, avg(wert5) AS wert5, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert4'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, avg(wert4) AS wert4, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert3'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, avg(wert3) AS wert3, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert2'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, avg(wert2) AS wert2, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            } elseif ($sensortype[$system]['wert1'] != "") { 
                $resultausgabe = mysql_query("SELECT avg(wert1) AS wert1, `objektid`, `timestamp` FROM daten WHERE objektid = '$objektid_foreach[objektid]' AND UNIX_TIMESTAMP(`timestamp`) > '$timestampvon'");	// Daten suchen
            };
            
            if (mysql_num_rows($resultausgabe) == 0) {
                echo "Keine Daten gefunden!";
            } else {
                while ($rowausgabe = mysql_fetch_array($resultausgabe)) {
                    if (isset($rowausgabe['wert1'])) {
                        $calcwert1 = round($rowausgabe['wert1'], "2");
                        //echo "WERT1: " . $calcwert1;
                        //echo "<br>";
                    } else {
                        $calcwert1 = "NULL";
                    };
                      
                    if (isset($rowausgabe['wert2'])) {
                        $calcwert2 = round($rowausgabe['wert2'], "2");
                        //echo "WERT2: " . $calcwert2;
                        //echo "<br>";
                    } else {
                        $calcwert2 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert3'])) {
                        $calcwert3 = round($rowausgabe['wert3'], "2");
                        //echo "WERT3: " . $calcwert3;
                        //echo "<br>";
                    } else {
                        $calcwert3 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert4'])) {
                        $calcwert4 = round($rowausgabe['wert4'], "2");
                        //echo "WERT4: " . $calcwert4;
                        //echo "<br>";
                    } else {
                        $calcwert4 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert5'])) {
                        $calcwert5 = round($rowausgabe['wert5'], "2");
                        //echo "WERT5: " . $calcwert5;
                        //echo "<br>";
                    } else {
                        $calcwert5 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert6'])) {
                        $calcwert6 = round($rowausgabe['wert6'], "2");
                        //echo "WERT6: " . $calcwert6;
                        //echo "<br>";
                    } else {
                        $calcwert6 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert7'])) {
                        $calcwert7 = round($rowausgabe['wert7'], "2");
                        //echo "WERT7: " . $calcwert7;
                        //echo "<br>";
                    } else {
                        $calcwert7 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert8'])) {
                        $calcwert8 = round($rowausgabe['wert8'], "2");
                        //echo "WERT8: " . $calcwert8;
                        //echo "<br>";
                    } else {
                        $calcwert8 = "NULL";
                    };
                    
                    if (isset($rowausgabe['wert9'])) {
                        $calcwert9 = round($rowausgabe['wert9'], "2");
                        //echo "WERT9: " . $calcwert9;
                        //echo "<br>";
                    } else {
                        $calcwert9 = "NULL";
                    };

                    //#############################################################
                    //#id				einfache nummerierung		
                    //#objektid		zuordnung welcher sensor
                    //ABGELOEST//#wertnum		wert1/2/3/4/5/6/7/8/9
                    //#datenid		id der daten tabelle
                    //ABGELOEST//#type			evg/min/max
                    //#time		24h/12h/1h
                    //#wert1			durchschnitt
                    //#wert2			durchschnitt
                    //#wert3			durchschnitt
                    //#wert4			durchschnitt
                    //#wert5			durchschnitt
                    //#wert6			durchschnitt
                    //#wert7			durchschnitt
                    //#wert8			durchschnitt
                    //#wert9			durchschnitt
                    //#############################################################				

                    //#dbentry here######################################################
                    $writeSQL = "INSERT INTO `calc_evg` (`objektid`, `time`, `wert1`, `wert2`, `wert3`, `wert4`, `wert5`, `wert6`, `wert7`, `wert8`, `wert9`) VALUES ('$objektid_foreach[objektid]', '" . $dbname_time . "', '$calcwert1', '$calcwert2', '$calcwert3', '$calcwert4', '$calcwert5', '$calcwert6', '$calcwert7', '$calcwert8', '$calcwert9')" ;                           // Datenbank Befehl Setzen (Alle Einträge mit Type "tag" Löschen!)
                    if (mysql_query($writeSQL, $link)) {
                            echo "Die Eintraege wurden erfolgreich in die Datenbank geschrieben.";
                            echo "";
                    } else {
                            print ("Es traten Probleme beim schreiben der Eintraege in die Datenbank auf.");
                            echo mysql_error($link); // Fehler Posten
                    };
                    echo "<hr>";
                    //###################################################################
                };
            };
        };
    };
};
?>
