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
        
        $eol_delimiters = chr(10);
        $answerstrings = array(
        //    'MAMS_USELINECOUNTER',
        //    'MAMS_FILTEROUT_ANSWERS',
            'on',
            'off',
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "100";
        $connect_debug = false;
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $pin = $ConnectClass->tcp_connect($ip, $port, "lcd backlight" . "\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($pin), "3");
        $output->debug(__FUNCTION__, "[DATA] PIN RAW: " . $pin[0], "3");
        
        // Filter for pin status
        $raw = strtoupper($pin[0]);
        $output->debug(__FUNCTION__, "[MATCH] " . $raw, "3");
        if (preg_match("/(ON)/", $raw)) {
            $device_state = "1";
        } elseif (preg_match("/(OFF)/", $raw)) {
            $device_state = "0";
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on pin raw failed", "1");
            return 1;
        }

        // Data
        $datenarray = array(
            'device_state'        =>  $device_state,
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
            if (preg_match("/(1)/", $raw)) {
                $pin_set = "on";
            } elseif (preg_match("/(0)/", $raw)) {
                $pin_set = "off";
            } else {
                $output->debug(__FUNCTION__, "[ERROR] pattern match on pin raw failed", "1");
                return 1;
            }
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing action_wert1 in queue configuration", "1");
            return 1;
        }
        
        $eol_delimiters = chr(10);
        $answerstrings = array(
        //    'USELINECOUNTER',
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "100";
        $connect_debug = false;
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $set = $ConnectClass->tcp_connect($ip, $port, "lcd backlight " . $pin_set . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($set), "3");
        
        // Filter for adc
        if ($set[0] == "OK") {
            $output->debug(__FUNCTION__, "[OK] set data succsessful", "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] set data failed failed", "1");
            return 1;
        }
        
        return 0;
    }
}