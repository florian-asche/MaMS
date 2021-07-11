<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################


/**
 * Defaults
 */
$now_date = date("d.m.Y");
$now_time = date("H:i:s");
$now_timestamp = time();


/**
 * Smarty Defaults
 */
define('SMARTY_DIR', $absolut_pfad . '/lib/Smarty-3.1.18/libs/');
define('SMARTY_RESOURCE_CHAR_SET', 'cp1251');


/**
 * This function returns within an array all data in ascii
 * 
 * @param type $string
 * @return type
 */
function str2ascii($string) {
    $asciidata = array();
    for($charcounter = 0; $charcounter < strlen($string); $charcounter++) {
        $translated_string[$charcounter] = $string[$charcounter];

        $ascii_replace = array(
            chr(32)=>'SPACE',
            chr(10)=>'LF',
            chr(13)=>'CR'
        ); 

        $translated_string[$charcounter] = strtr($string[$charcounter],$ascii_replace); 
        //$translated_string[$charcounter] = str_replace(chr(13), 'CR', $translated_string[$charcounter]);
        //$translated_string[$charcounter] = str_replace(chr(13), 'CR', $translated_string[$charcounter]);

        $asciidata[$charcounter][$translated_string[$charcounter]] = ord($string[$charcounter]);
    };

    return $asciidata;
}


/**
 * This function resolve the in the configuration file specifyed mapping configuration. For example (0 = off) and (1 = on)
 * This function change the data and put the old one in an new array variable
 * 
 * @global type $output
 * @global type $default_configuration
 * @param type $original_data
 * @return type
 */
function mapping_convert($original_data) {
    global $output;
    global $default_configuration;

    $map_data = array();

    foreach ($original_data as $key => $value) {
        if (isset($default_configuration['datatypes'][$key]['mapping']) and is_array($default_configuration['datatypes'][$key]['mapping'])) {
            $mapping_array = $default_configuration['datatypes'][$key]['mapping'];

            $output->debug(__FUNCTION__, "[MAPPING] Found mapping for: " . $key . " with value=" . $value, "4");
            $output->debug(__FUNCTION__, "[MAPPING] Map array: " . $output->array_output($mapping_array), "4");
            if (isset($mapping_array[$value]) and $mapping_array[$value]) {
                $mapresult = $mapping_array[$value];
                $output->debug(__FUNCTION__, "[MAPPING] MAP RESULT=" . $mapresult, "4");
                $map_data[$key] = $mapresult;
                $map_data[$key . "_original"] = $value;
            } else {
                $output->debug(__FUNCTION__, "[MAPPING] 2 Couldnt map data because there is no match", "4");
                $map_data[$key] = $value;
            }
        } else {
            $output->debug(__FUNCTION__, "[MAPPING] 1 Couldnt map data because there is no match", "4");
            $map_data[$key] = $value;
        }
    }

    $output->debug(__FUNCTION__, "[MAPPING] Map data: " . $output->array_output($map_data), "4");
    return $map_data;
}


/**
 * This function can search in an array for a specific pattern match
 * The data return whin in an array
 * 
 * mams_match_search($raw, "/" . $patternsearch . "/")
 * 
 * @global type $output
 * @param type $data
 * @param type $patternsearch
 * @return type
 */
function mams_match_search($data, $patternsearch) {
    global $output;
    
    $matches = array();
    foreach ($data as $value) {
        if (preg_match_all($patternsearch, $value, $raw_matches, PREG_SET_ORDER)) {
            $output->debug(__FUNCTION__, "[PREGMATCH] Found: " . $output->array_output($raw_matches), "4");
            $matches[] = $raw_matches;
        }
    }    
    $output->debug(__FUNCTION__, "[PREGMATCH] End result: " . $output->array_output($matches), "4");
    return $matches;
}


/**
 * 
 * @param type $feldname
 * @param type $default
 * @return type
 */
function get_post_data($feldname, $default) {
    if (isset($_POST[$feldname])) {
        // To protect from MySQL injection
        //return addslashes(mysql_real_escape_string($_POST[$feldname]));
	return addslashes($_POST[$feldname]);
    } else {
        return $default;
    };
};


/**
 * 
 * @param type $feldname
 * @param type $default
 * @return type
 */
function get_get_data($feldname, $default) {
    if (isset($_GET[$feldname])) {
        // To protect from MySQL injection
        //return addslashes(mysql_real_escape_string($_GET[$feldname]));
	return addslashes($_GET[$feldname]);
    } else {
        return $default;
    };
};


/**
 * 
 * @param type $feldname
 * @param type $default
 * @return type
 */
function get_submit_data($feldname, $default) {
    if (isset($_POST[$feldname])) { 
        // To protect from MySQL injection
        //return addslashes(mysql_real_escape_string($_POST[$feldname]));
	return addslashes($_POST[$feldname]);
    } elseif (isset($_GET[$feldname])) {
        // To protect from MySQL injection
        //return addslashes(mysql_real_escape_string($_GET[$feldname])); 
	return addslashes($_GET[$feldname]);
    } else {
        return $default;
    };
};


/**
 * Check if timestamp is in unix format
 * 
 * @param string $timestamp
 *   Target timestamp that will be checked
 * 
 * @return bool
 *   TRUE if timestamp is in unix format. FALSE on failure
 */
function is_unix_timestamp($timestamp) {
   return preg_match('/^\d+$/', $timestamp);
};


/**
 * 
 * @return string
 */
function isCommandLineInterface() {
    if (php_sapi_name() == 'cli') {
        return "cli";
    } elseif (php_sapi_name() == 'apache2handler') {
        return "web";
    } else {
        return "unknown";
    };
};


/**
 * This function get the job_configuration from protocols php file
 * 
 * @global type $output
 * @global type $absolut_pfad
 * @param type $station_protocols_class
 * @return int
 */
function get_protocol_class_configuration($station_protocols_class) {
    global $output;
    global $absolut_pfad;
    
    $output->debug(__FUNCTION__, "Load class=" . $station_protocols_class, "4", "CYAN");
    if (file_exists($absolut_pfad . "/classes/protocols/" . $station_protocols_class)) {
        include($absolut_pfad . "/classes/protocols/" . $station_protocols_class);
        $ClassProtocol = NEW JobClass();
        
        if (is_array($ClassProtocol->job_configuration)) {
            $output->debug(__FUNCTION__, "[DATA] job_configuration: " . $output->array_output($ClassProtocol->job_configuration), "4");
            return $ClassProtocol->job_configuration;
        } else {
            return 1;
        }
    } else {
        return 1;
    }
}

function ping($host, $timeout = 1) {
    /* ICMP ping packet with a pre-calculated checksum */
    $package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
    $socket = socket_create(AF_INET, SOCK_RAW, 1);
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0));
    socket_connect($socket, $host, null);

    $ts = microtime(true);
    socket_send($socket, $package, strLen($package), 0);
    if (socket_read($socket, 255)) {    
        $result = microtime(true) - $ts;
    } else {
        $result = false;
    }
    socket_close($socket);

    return $result;
}
