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
            '([0-9.+-]+)',
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "100";
        $connect_debug = false;
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $temp = $ConnectClass->tcp_connect($ip, $port, "dht temp" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($temp), "3");
        
        $humid = $ConnectClass->tcp_connect($ip, $port, "dht humid" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($humid), "3");
        
        // Filter for temp
        if (preg_match("/([0-9.+-]+)/", $temp[0])) {
            $temperature = $temp[0];
            $output->debug(__FUNCTION__, "[DATA] Temperature: " . $temperature . " °C", "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on temperature failed", "1");
            return 1;
        }
        
        // Filter for humid
        if (preg_match("/([0-9.+-]+)/", $humid[0])) {
            $humidity = $humid[0];
            $output->debug(__FUNCTION__, "[DATA] Humidity: " . $humidity . " %", "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on humidity failed", "1");
            return 1;
        }
        
        // Data
        $datenarray = array(
            'temperature_c'     =>  $temperature,
            'humidity'          =>  $humidity,
        );
        $output->debug(__FUNCTION__, "[DATA-ARRAY] " . $output->array_output($datenarray), "3");
        $output->debug(__FUNCTION__, "[DATA] Objectid: " . $objectid, "3");
        $datenarray_json = json_encode($datenarray);
        
        // database insert
        $db_insert_RC = $MaMS_Data->save_data($datenarray_json, $objectid);
        if ($db_insert_RC != "0") {
            $output->debug(__FUNCTION__, "[DB] insert failed", "1");
            return 1;
        }
        
        return 0;
    }
}
