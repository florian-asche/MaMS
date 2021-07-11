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
                'channel' => 'counter0',
                'reset_value' => '0', //Reset channel to ..., If not set, no reset is happening
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
        
        if (isset($jobdata['station_protocols']['configuration']['channel'])) {
            $channel = $jobdata['station_protocols']['configuration']['channel'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing channel in station_protocols configuration", "3");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['reset_value'])) {
            $reset_value = $jobdata['station_protocols']['configuration']['reset_value'];
        }
        
        //"/([0-9.+-]+)/"
        $patternsearch = $channel . " ([0-9.+-]+)";
        
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
        
        $answerstrings2 = array(
            'MAMS_USELINECOUNTER',
        //    'MAMS_FILTEROUT_ANSWERS',
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "100";
        $connect_debug = false;
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $raw = $ConnectClass->tcp_connect($ip, $port, "c6 get " . $channel . "\r\n", $answerstrings, $number_lines, chr(13).chr(10), $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($raw), "3");
        $output->debug(__FUNCTION__, "[DATA-COUNT] " . count($raw), "3");
        
        if (count($raw) < 1) {
            $output->debug(__FUNCTION__, "[ERROR] no data received ", "1");
            return 1;
        }
        
        // preg match search
        $matches = mams_match_search($raw, "/" . $patternsearch . "/");
                
        // Check if we have results from preg match search
        if (count($matches) != 1) {
            $output->debug(__FUNCTION__, "[ERROR] no results or more than one recieved from preg match ", "1");
            return 1;
        }
        
        $count = $matches[0][0][1];
        $output->debug(__FUNCTION__, "[DATA] Count: " . $count, "3");
            
        if (isset($reset_value)) {
            usleep(280000);
            $delete = $ConnectClass->tcp_connect($ip, $port, "c6 set " . $channel . " " . $reset_value . "\r\n", $answerstrings2, "2", chr(13).chr(10), $connect_debug);

            if (count($delete) < 1) {
                $output->debug(__FUNCTION__, "[ERROR] no data received ", "1");
                return 1;
            }
            
            // preg match search
            $delete_matches = mams_match_search($delete, "/(OK)/");

            // Check if we have results from preg match search
            if (count($delete_matches) != 1) {
                $output->debug(__FUNCTION__, "[ERROR] no results or more than one recieved from preg match ", "1");
                return 1;
            }
        }
        
        // Data
        $datenarray = array(
            'count' => $count,
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
