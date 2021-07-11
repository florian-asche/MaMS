<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################


/**
 * Calculate the microtime
 * 
 * @return type
 */
function getmicrotime() {
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
};

//Ladezeit berechnen
$time_start = getmicrotime();

// Zeitzone einstellen
date_default_timezone_set('Europe/Berlin');                                     // ja oder nein?

// Prüfen ob Konfigurationsdatei existiert
if (!isset($host)) {
    if (file_exists('configuration.php')) {
        //echo "The file configuration.php exists";
        include ("configuration.php");                                          // Konfiguration Laden
      } else {
        //echo "The file configuration.php doesn't exists";
        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Achtung! Die configuration.php konnte nicht gefunden werden. Ohne die Konfigurationsdatei kann das Webfrontend nicht laufen!</li></ul></dd></dl>';
        exit();
        if (!isset($system_debug)) { $system_debug = "0"; }
    };
};

//include('classes/global/MaMS.php');

// Prüfen ob Erweiterungen installeirt sind
//if (!extension_loaded('gd')) {
//    if (!dl('gd.so')) {
//        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Achtung! Die PHP Erweiterung gd ist nicht installiert. Bitte korrigieren Sie das!</li></ul></dd></dl>';
//    }
//}
// dl function is outdated ersetzen!!!

//# is bcmath installiert?
//    if (!dl('bcmath.so')) {
//        echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Achtung! Die PHP Erweiterung bcmath ist nicht installiert. Bitte korrigieren Sie das!</li></ul></dd></dl>';
//    }
//}

// is cURL installed yet?
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }

// Ptüfen ob Smarty Directorys beschreibbar sind
$smartydir = "templates_c";
if (!is_writeable($absolut_pfad . "/" . $smartydir)) {
    //echo "not writeable";
    echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Achtung! Das Cache Verzeichnis ' . $smartydir . ' ist nicht beschrreibbar. Bitte korrigieren Sie das!</li></ul></dd></dl>';
    exit();
}




/**
 * 
 * @param type $array
 * @param type $key
 * @param type $value
 * @return type
 */
function array_search1($array, $key, $value) {
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
            //echo $array['ID'];
        }
            
        foreach ($array as $subarray) {
            $results = array_merge($results, array_search1($subarray, $key, $value));
        }
    }

    return $results;
};

/**
 * 
 * @param type $starttimestamp
 * @param type $endtimestamp
 * @return string
 */
function timstampdiff($starttimestamp, $endtimestamp) {
     if (!is_unix_timestamp($starttimestamp)) {
         return "ERROR";
     };
     
     if (!is_unix_timestamp($endtimestamp)) {
         return "ERROR";
     };
     
     $timestampdifferenz = $endtimestamp - $starttimestamp;
     return $timestampdifferenz;
};

/**
 * 
 * @param type $sekunden
 * @return type
 */
function sec_to_time($sekunden) {
    //Needed Package: php-bcmath.x86_64
    if (!($sekunden >= 60)) {
        return '<b>' . $sekunden . '</b> Sekunden';
    }

    $minuten    = bcdiv($sekunden, '60', 0);
    $sekunden   = bcmod($sekunden, '60');

    if (!($minuten >= 60)) {
        return $minuten . ' Minuten ' . $sekunden . ' Sekunden';
    }

    $stunden    = bcdiv($minuten, '60', 0);
    $minuten    = bcmod($minuten, '60');

    if (!($stunden >= 24)) {
        return $stunden . ' Stunden ' . $minuten . ' Minuten ' . $sekunden . ' Sekunden';
    }

    $tage       = bcdiv($stunden, '24', 0);
    $stunden    = bcmod($stunden, '24');

    return $tage . ' Tage ' . $stunden . ' Stunden ' . $minuten . ' Minuten ' . $sekunden . ' Sekunden';
};

/**
 * Calculate time with timezone
 * @param type $timestamp
 * @param type $sysconfig
 * @return type
 */
function timestampcalc($timestamp,$sysconfig) {                                 
  $timezone2 = $timezone * "3600";                                              // Berechnen, wie viel bei der jeweiligen Zeitzone an Sekunden berechnet werden muss.
  
  $seconds = date_offset_get(new DateTime);              // VON RSE             // http://forum.de.selfhtml.org/archiv/2007/10/t160487/ VERSCHIEBUNG AUF DIE SOMMER ZEIT
  
  $timestamp2 = $timestamp + $timezone2;                                        // Neuen Timestamp berechnen.
  
  if ($sysconfig['global']['system_sowizeit']['wert'] == "1") {
  $timestamp2 = $timestamp + $timezone2 + $seconds;  // VON RSE
  }
  
  //return $timestamp2;
  return $timestamp;
};



//function getlastdata($sysconfig,$lastdata_sensorid,$feld) {                     // Daten aus DB holen for specific feld z.B. fuer display module
//    $result3=mysql_query("SELECT $feld FROM daten WHERE objectid = '$lastdata_sensorid' ORDER BY `ID` DESC LIMIT 1");
//    while ($row = mysql_fetch_array($result3)) {                                
//        return $row[$feld];                                                     //Wert ausgeben
//    };
//};

//function get_latest_data_json($get_objectid, $linki) {
//    //SQL Daten holen
//    //$get_objectid = "MAMS-8a6306a5a3db5e0b31e6";
//    $sql = "SELECT `objectid`, UNIX_TIMESTAMP(`timestamp`) AS timestamp, `wert1`, `wert2`, `wert3`, `wert4`, `wert5`, `wert6`, `wert7`, `wert8`, `wert9` FROM daten WHERE objectid = '" . $get_objectid . "' ORDER BY `ID` DESC LIMIT 1"; 
//    
//    if (mysqli_connect_errno()) {
//        printf("Connect failed: %s<br/>", mysqli_connect_error());
//    }
//
//    $result_db = $linki->query($sql);
//    $result = array();
//    
//    while ($row = $result_db->fetch_assoc()) {
//            $result = $row;
//    };
//    
//    return json_encode($result);
//    //$linki->close();
//};


/**
 * 
 * @param type $get_objectid
 * @param type $object_template
 * @return type
 */


//function add_additional_data($data, $object_template) {
//    global $default_configuration;
//    
//    $result = array();
//    foreach ($data as $value) {
//        //echo $value['ID'];
//        foreach($data[$value['ID']]['resolved_data'] as $key=>$wert) {
//            //echo $key . "<br>";
//            //$result[$key] = $key;
//            
//            foreach($default_configuration['templates'][$object_template]['additional_data'] as $name=>$wert) {
//                //echo $name . "-" . $wert . "<br>";
//                echo $data[$value['ID']]['resolved_data']['adc'];
//                echo "<br>";
//                //$result[$value['ID']]['additional_data'][$name] = $data[$value['ID']]['json_data']['adc'] * 10;
//                $result[$value['ID']]['additional_data'][$name] = eval("return " . $wert . ";");
//            };  
//        }
//    }
//    return($result);
//}


/**
 * 
 * @param type $page_objects
 * @param type $tabledata
 * @param type $get_pageobjectid
 * @return type
 */
function reorga_data1($page_objects, $tabledata, $get_pageobjectid) {
    $result = array();
    foreach ($page_objects[$get_pageobjectid]['objects']['configuration']['show_graph'] as $data_name) {
    
//        echo $data_name . ":";
//        echo "<br>";
            foreach ($tabledata as $tabledata_array) {
//                echo $tabledata_array['timestamp'];
//                echo "=";
//                echo $tabledata_array['resolved_data'][$data_name];
//                echo "<br>";
                
//                if (isset($result[$data_name][$tabledata_array['timestamp']])) {
//                    echo "Warning: Duplicated Data found in Database!";
//                };
                
                $result[$data_name][$tabledata_array['timestamp']] = $tabledata_array['resolved_data'][$data_name];
            }
//        echo "<br>";
    };
        
//    echo '<pre>';
//    print_r($result);
//    echo '</pre>';
//    exit;
      return $result; 
}

//function get_object_data_fieldnames($inputarray) {
//    #get all possible data field names
//    $result = array();
//    foreach ($inputarray as $value) {
//        #echo $value['ID'];
//        foreach($inputarray[$value['ID']]['json_data'] as $key=>$wert) {
//            #echo $key . "<br>";
//            $result[$key] = $key;
//        }
//    }
//    return($result);
//};


/**
 * 
 * @param type $sql
 * @param type $linki
 * @return type
 */
//function get_sql_data($sql, $linki) {   
//    if (mysqli_connect_errno()) {
//        printf("Connect failed: %s<br/>", mysqli_connect_error());
//    }
//
//    $result_db = $linki->query($sql);
//    $result = array();
//    
//    while ($row = $result_db->fetch_assoc()) {
//        $result[] = $row;
//    };
//    
//    //$linki->close();
//    return($result);
//};


/**
 * 
 * @param type $sql
 * @param type $linki
 * @return string
 */
function get_number_rows($sql, $linki) {       
    //$sqlchange = "UPDATE `page_objects` SET `ac.tive` = '0' WHERE `ID` = '4'"; 
    
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s<br/>", mysqli_connect_error());
    }

    if ($result = mysqli_query($linki, $sql)) {
            return mysqli_num_rows($result);
    } else {
            echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Die Daten konnten nicht in die Datenbank geschrieben werden!</li><li>';
            echo mysqli_error($linki); // Fehler Posten
            echo "</li></ul></dd></dl>";
            return 'error';
    };
};


/**
 * 
 * @global type $absolut_pfad
 * @global type $system_debug
 * @param type $directory
 * @return type
 */
//function get_templates($directory) {
//    global $absolut_pfad;
//    global $system_debug;
//    
//    $pfad = $absolut_pfad . "/" . $directory;
//    $di = opendir($pfad);
//    $array = array();
//    while($loop = readdir($di)) {
//        if ( !is_file($loop) and $loop != ".." and $loop != "." and $loop != "CVS" and $loop != ".git" ) {
//            if ($system_debug == 1) { echo $loop . "<br>"; };
//            if (preg_match("/^([0-9A-Za-z\-]+).tpl/", $loop, $treffer, PREG_OFFSET_CAPTURE)) {
//                $filename = $treffer[1][0];
//                //echo $filename . "<br>";
//                //$array[$filename] = get_template_conf($directory . $treffer[1][0] . '.conf');
//                $array[$filename]['filename'] = $filename;
//                //echo "<br>";
//            };
////            echo '<pre>';
////            print_r($treffer);
////            echo '</pre>';
//            //exit;
//        };
//    };
//    if ($system_debug == 1) { echo "<br>"; };                                   // Debug
//    closedir($di);  
//    sort($array);
//    return $array;
//};

//function get_template_conf($config_file) {
//    global $system_debug;
//    
//    //echo "config_file=" . $config_file . "<br>";
//    //echo "variable_name=" . $variable_name . "<br>";
//    
//    require_once(SMARTY_DIR . 'Smarty.class.php');
//    $smarty = new Smarty;
//    
//    $myVar = "";
//    $smarty->configLoad($config_file);
//    
//    // get loaded config template var #foo#
//    //$myVar = $smarty->getConfigVars($variable_name);
//    
//    // get all loaded config template vars
//    $all_config_vars = $smarty->getConfigVars();
//    
//    return $all_config_vars;
//    
//}


/**
* Get all values from specific key in a multidimensional array
*
* @param $key string
* @param $arr array
* @return null|string|array
*/
function array_value_recursive($key, array $arr){
    $val = array();
    array_walk_recursive($arr, function($v, $k) use($key, &$val){
        if($k == $key) array_push($val, $v);
    });
    return count($val) > 1 ? $val : array_pop($val);
}


// Ermitteln der Verzeichnistrennung (Windows / Unix)
if($betriebssystem == "win") {
  $verztrennung = chr(92);
};

if($betriebssystem == "unix") {
  $verztrennung = chr(47);
};


//$config_array = mysql_query("SELECT * FROM config ORDER BY `ID`");
//while ($config_foreachread = mysql_fetch_array($config_array)) {
//    //echo $config_foreachread['parameter'];
//    //$sysconfig[$config_foreachread['bereich']][$config_foreachread['parameter']]['bereich']      = $config_foreachread['bereich'];
//    //$sysconfig[$config_foreachread['bereich']][$config_foreachread['parameter']]['parameter']    = $config_foreachread['parameter'];
//    $sysconfig[$config_foreachread['bereich']][$config_foreachread['parameter']]['wert']         = $config_foreachread['wert'];
//};

//function funktion_load_sidebar($sysconfig,$system_debug,$timeaktu,$reloadinEVG,$absolut_pfad) {
//    if ($sysconfig['global']['sidebar_gesamt']['wert'] == "1") {                                               // Pruefen ob Sidebar verwendet werden soll
//        echo '</td><td height="205" valign="top">';                             // Tabelle fdz?r Sidebars Ausgeben
//        $sidebarpfad = $absolut_pfad . "/module/sidebar/";                      // Pfad Angabe fuer Auslesen der Module
//        $sidebar_module_reihenfolge = "0";     
//        $sidebarordnerdir = opendir($sidebarpfad);                              // Verzeichnisliste Erstellen
//        while($sidebarordner = readdir($sidebarordnerdir)) {                    // Schleife zur Auswertung der Verzeichnisliste
//            if ( !is_file($sidebarordner) and $sidebarordner != ".." and $sidebarordner != "." and $sidebarordner != "CVS" ) {        // Falsche Werte Herausfiltern
//                if ($system_debug == 1) { echo $sidebarordner . "<br>"; };      // Debug Ausgabe der Verzeichnisliste
//                $sidebarordner2[] = $sidebarordner;
//            };
//        };
//        if ($system_debug == 1) { echo "<br>"; };                               // Debug Ausgabe der Verzeichnisliste
//
//        closedir($sidebarordnerdir);  
//        sort($sidebarordner2);   
//        $sidebaranzahl = count($sidebarordner2);  
//
//        $start = "0";  
//        for($i=$start;$i<$sidebaranzahl;$i++) {  
//        if ($system_debug == 1) { echo $sidebarordner2[$i] . "<br>"; };         // Debug Ausgabe der Verzeichnisliste
//            if (file_exists($sidebarpfad . $sidebarordner2[$i] . "/index.php")) {
//                include ($sidebarpfad . $sidebarordner2[$i] . "/index.php");    // Sidebar Laden    
//            };        
//        };
//    };
//};

//Funktion für Status Prüfen----------------------------------------------------
//function statuscheck($checkhost,$checkport) {
//    if ($checkhost) {
//        if ($checkport) {
//            $timeout= 1;
//            if (($handle = @fsockopen($checkhost, $checkport, $errno, $errstr, $timeout)) == false) {
//                echo '<b><font color="red">Offline</font></b>';
//            } else {
//                echo '<b><font color="green">Online</font></b>';
//            };
//            @fclose($handle);
//        } else {
//            echo '<b><font color="black">None</font></b>';
//        }
//    } else {
//        echo '<b><font color="black">None</font></b>';
//    }
//}

//function set_database_config($bereich,$parameter,$wert,$link) { 
//	$sql_set_config = "UPDATE `config` SET `wert` = '" . $wert . "' WHERE `bereich` = '" . $bereich . "' AND `parameter` = '" . $parameter . "'";
//	if (mysql_query($sql_set_config, $link)) {    
//		return 0;
//	} else {
//		echo '<dl id="system-message"><dd class="message message fade error"><ul><li>Die Daten konnten nicht in die Datenbank geschrieben werden!</li><li>';
//		echo mysql_error($link); // Fehler Posten
//		echo "</li></ul></dd></dl>";
//	};
//};


//echo mb_detect_encoding($message, "auto");
function str2hex($string) {							                                      // Anfang des Ascii Debuggers
	for($charcounter = 0; $charcounter < mb_strlen($string, "ASCII"); $charcounter++) {       // Anfang Schleife fuer jedes Zeichen
                echo $charcounter;
                echo ":";
                //echo $string[$charcounter];
                echo ord($string[$charcounter]);
                echo "-";
                echo "0x";
                if (strlen(dechex(ord($string[$charcounter]))) == 1) { echo "0"; };
                echo dechex(ord($string[$charcounter]));

		echo "<br>";                                                                   // Debug Ausgabe
	};                                                                            // Ende des Ascii Debuggers
	echo "<br><br>";                                                              // Zeilenumbruch für Debug Ausgabe
};


function curl_get_content($url) {
    //reate a new cURL resource handle
    $ch = curl_init();
    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $url);
    // Set a referer
    //curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
    // User agent
    //curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, '5');
    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    // Download the given URL, and return output
    $data = curl_exec($ch);
    // Close the cURL resource, and free system resources
    curl_close($ch);
    $data_decoded = urldecode($data);
    return $data_decoded;
}


function getcurrentversion() {
    $mams_version_now_fp = fopen("version.txt","r");
    if ($mams_version_now_fp) {
        while(!feof($mams_version_now_fp)) {
            $mams_version_now = fgets($mams_version_now_fp);
        };
        fclose($mams_version_now_fp);
    };
    if (!$mams_version_now) { $mams_version_now = "ERROR"; };
    return $mams_version_now;
};


//    public function sqlToJsonAction($dbname, $tablename)
//    {
//        $db = Di::getDefault()->get($dbname);
//        $sql = "SELECT * FROM $tablename";
//        $stmt = $db->prepare($sql);
//        $stmt->execute();
//        $tab = array();
//        while ($row = $stmt->fetch()) {
//            $tab[] = $row;
//        }
//        echo json_encode($tab);
//    }


function windDir($max,$winddir) {
    // Given the wind direction, return the text label for that value.

    if (!isset($winddir)) {
            return "---";
    };

    $windlabel = array ("N","NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S","SSW","SW", "WSW", "W", "WNW", "NW", "NNW");
    // Max / Anzahl Array
    // 100 / 16
    // = 6,25

    $arraycount = count($windlabel);
    //echo "Arraycount=" . $arraycount;
    $calcsum = $max / $arraycount;
    //echo "<br>";
    //echo "Calcsum=" . $calcsum;
    //echo "<br>";

    $dir = $windlabel[ fmod((($winddir) / $calcsum),$arraycount) ];
    return "$dir";
};


function CalcBCC($string) {
    $bcc = "";
   for ($i = 0; $i <= strlen($string); $i++) {
       $bcc = $bcc ^ ord(substr($string, $i, 1));
   }
   
   return ("0x".dechex($bcc));
}
?>
