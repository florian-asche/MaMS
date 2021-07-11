<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

/**
 * JobClass for Process
 */
class JobClass {
    public function __construct() {
        $this->job_configuration = array(
            'queue' => array(
            ),
            'send_queue' => array(
                'trigger_data_update' => '1',
                'archive_job' => '1',
            ),
            'station' => array(
                'ip',
                'port',
                'lock_station' => '1', // If the Station should get locked
            ),
            'station_protocol' => array(
                'objectid', // If a uniqe id in setup should get generated
                'target_temperature_c' => '17',
                'temperature_min' => '17',
                'temperature_max' => '30',
                'openHR20F_auto_mode' => '0',
            ),
        );
    }
    
    /**
     * This function is loaded in setup area
     */
    public function setup() {
        
    }
    
    /**
     * Load data for object from destination
     */
    public function load_data($jobdata) {
        global $output;
        global $MaMS_Queue;
        global $MaMS_SQL;
        global $MaMS_Data;
        
        $ConnectClass = NEW ConnectClass();
        
        if (isset($jobdata['station_protocols']['configuration']['objectid'])) {
            $objectid = $jobdata['station_protocols']['configuration']['objectid'];
        }
        
        if (isset($jobdata['stations']['configuration']['ip'])) {
            $ip = $jobdata['stations']['configuration']['ip'];
        }
        
        if (isset($jobdata['stations']['configuration']['port'])) {
            $port = $jobdata['stations']['configuration']['port'];
        }
        
        $patternsearch = 'D: d([0-9]) ([0-9]+.[0-9]+.[0-9]+) ([0-9]+:[0-9]+:[0-9]+) ([AM-]) V: ([0-9]{2}) I: ([0-9]{4}) S: ([0-9]{4}) B: ([0-9]{4}) Is: ([a-z0-9]{8}) Ib: ([a-z0-9]{2}) Ic: ([a-z0-9]{2}) Ie: ([a-z0-9]{2}) ([X]{0,1}) {0,1}([W]{0,1})';
        $eol_delimiters = chr(10);
        $answerstrings = array(
        //    'MAMS_USELINECOUNTER',
        //    'MAMS_FILTEROUT_ANSWERS',
            $patternsearch,
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "3";
        $connect_debug = false;
        
        $prestart = $ConnectClass->tcp_connect($ip, $port, "D" . "\r\n", array('SENDONLY'), $number_lines, "", $connect_debug);
	usleep(280000);
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $raw = $ConnectClass->tcp_connect($ip, $port, "D" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($raw), "3");

        // Check if we have data to search in
        if (count($raw) < 1) {
            $output->debug(__FUNCTION__, "[ERROR] no data to search in", "1");
            return 1;
        }
        
        // preg match search
        $matches = mams_match_search($raw, "/" . $patternsearch . "/");
                
        // Check if we have results from preg match search
        if (count($matches) != 1) {
            $output->debug(__FUNCTION__, "[ERROR] no results or more than one recieved from preg match ", "1");
            return 1;
        }
        $output->debug(__FUNCTION__, "[MATCHES] " . $output->array_output($matches), "3");

        // D: [dW] [DD.MM.YY] [mm:hh:ss] [A] V: [VV] I: [IIII] S: [SSSS] B: [BBBB] Is: [IsIs] [X] [W]
        // D: d5 01.01.10 12:32:17 A V: 35 I: 1838 S: 1700 B: 3362 Is: fffff760 Ib: 00 Ic: 1c Ie: 1c X
        // D: d5 01.01.10 12:03:24 M V: 30 I: 1851 S: 0500 B: 3372 Is: 00000000 Ib: 06 Ic: 28 Ie: 1e X
        // D: d([0-9]) ([0-9]+.[0-9]+.[0-9]+) ([0-9]+:[0-9]+:[0-9]+) ([AM]) V: ([0-9]{2}) I: ([0-9]{4}) S: ([0-9]{4}) B: ([0-9]{4}) Is: ([a-z0-9]{8}) Ib: ([a-z0-9]{2}) Ic: ([a-z0-9]{2}) Ie: ([a-z0-9]{2}) ([X]{0,1}) {0,1}([W]{0,1})
        
        // [dW] 	Wochentag (Montag = d1, Dienstag = d2 usw.)
        // [DD.MM.YY] 	aktuelles Datum
        // [mm:hh:ss] 	aktuelle Uhrzeit (mm...Minute, hh...Stunde, ss...Sekunde)
        // [A] 	Modus (A... Automatik, M...Manuell)
        // [VV] 	aktuelle Ventilposition in %
        // [IIII] 	aktuelle Temperatur (2368 entspricht 23,68 °C)
        // [SSSS] 	gewünschte Temperatur
        // [BBBB] 	Batteriespannung in mV
        // [IsIs] 	 ?
        // [X] 	X...Statusbericht vom Nutzer angefordert
        // kein X... automatisch erzeugter Statusbericht
        // [W] 	Fenster ist geöffnet 
        
        // Translate from match to var for datenarray
        $mode_raw = $matches[0][0][4];
        if ($mode_raw == "M") {
            $auto_mode = "0"; // Auto Mode is off
        } elseif ($mode_raw == "A") {
            $auto_mode = "1"; // Auto Mode is on
        } else {
            $auto_mode = "99"; // Error
        }
        
        $ventil_position = $matches[0][0][5];
        $temperature_c = number_format($matches[0][0][6] / 100, 2);
        $target_temperature_c = number_format($matches[0][0][7] / 100, 2);
        $voltage = number_format($matches[0][0][8] / 1000, 2);
        $window_status_raw = $matches[0][0][14];
        
        if (isset($window_status_raw) and $window_status_raw == "W") {
            $window_status = "1";
        } else {
            $window_status = "0";
        }
        
        // Data
        $datenarray = array(
            'openHR20F_auto_mode'   =>  $auto_mode,
            'ventil_position'       =>  $ventil_position,
            'temperature_c'         =>  $temperature_c,
            'target_temperature_c'  =>  $target_temperature_c,
            'voltage'               =>  $voltage,
            'window_status'         =>  $window_status,
        );
        $output->debug(__FUNCTION__, "[DATA-ARRAY] " . $output->array_output($datenarray), "3");
        
        $output->debug(__FUNCTION__, "[DATA] Objectid: " . $objectid, "3");
        $datenarray_json = json_encode($datenarray);
        
        // Database insert
        $db_insert_RC = $MaMS_Data->save_data($datenarray_json, $objectid);
        if ($db_insert_RC != "0") {
            $output->debug(__FUNCTION__, "[DB] insert failed", "1");
            return 1;
        }
        
        return 0;
    }


    /**
     * Send data for object to destination
     */
    public function send_data($jobdata) {
        global $output;
        global $default_configuration;
        global $MaMS_Queue;
        
        $ConnectClass = NEW ConnectClass();
        
        if (isset($jobdata['station_protocols']['configuration']['objectid'])) {
            $objectid = $jobdata['station_protocols']['configuration']['objectid'];
        }
        
        if (isset($jobdata['stations']['configuration']['ip'])) {
            $ip = $jobdata['stations']['configuration']['ip'];
        }
        
        if (isset($jobdata['stations']['configuration']['port'])) {
            $port = $jobdata['stations']['configuration']['port'];
        }
        
        if (isset($jobdata['queue']['configuration']['action_wert1'])) {
            $raw = $jobdata['queue']['configuration']['action_wert1'];
            
            // Filter for pin status
            $output->debug(__FUNCTION__, "[MATCH] " . $raw, "3");
            if (preg_match("/(100)/", $raw)) {
                $send = "O";
            } elseif (preg_match("/(0)/", $raw)) {
                $send = "C";
            } else {
                $send = "A" . dechex($raw * 2);
            }
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing action_wert1 in queue configuration", "1");
            return 1;
        }
        
        $patternsearch = 'D: d([0-9]) ([0-9]+.[0-9]+.[0-9]+) ([0-9]+:[0-9]+:[0-9]+) ([AM]) V: ([0-9]{2}) I: ([0-9]{4}) S: ([0-9]{4}) B: ([0-9]{4}) Is: ([a-z0-9]{8}) Ib: ([a-z0-9]{2}) Ic: ([a-z0-9]{2}) Ie: ([a-z0-9]{2}) ([X]{0,1}) {0,1}([W]{0,1})';
        $eol_delimiters = chr(10);
        $answerstrings = array(
        //    'USELINECOUNTER',
            $patternsearch,
            'OK',
            'EOF',
        );
        $number_lines = "1";
        $connect_debug = false;
        
        // Set temperature
        $set_temperature = $ConnectClass->tcp_connect($ip, $port, $send . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($set_temperature), "3");
                
        // Check if we have results from preg match search
        if (count($set_temperature) < 1) {
            $output->debug(__FUNCTION__, "[ERROR] no results or more than one recieved from preg match ", "1");
            return 1;
        }
        
        // Set mode to manual
        $set_mode = $ConnectClass->tcp_connect($ip, $port, "M00" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($set_mode), "3");
        
        // Check if we have results from preg match search
        if (count($set_mode) < 1) {
            $output->debug(__FUNCTION__, "[ERROR] no results or more than one recieved from preg match ", "1");
            return 1;
        }
        
        return 0;
    }
}