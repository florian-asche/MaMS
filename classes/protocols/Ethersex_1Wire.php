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
        $RC = 0;

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
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $answerstrings2 = array(
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
        $convert = $ConnectClass->tcp_connect($ip, $port, "1w convert" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($convert), "3");

        if ($convert[0] == "OK") {
            $list = $ConnectClass->tcp_connect($ip, $port, "1w list" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
            $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($list), "3");
            if ($list) {
                foreach ($list as $objectid) {
                    if ($objectid) {
                        if ($objectid !== "OK") {
                            if ($objectid !== "") {
                                $temp = $ConnectClass->tcp_connect($ip, $port, "1w get " . $objectid . "\r\n", $answerstrings2, "1", $eol_delimiters, $connect_debug);
                                $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($temp), "3");
                                if (preg_match("/([0-9.+-]+)/", $temp[0])) {
                                    $temperature = $temp[0];
                                    $output->debug(__FUNCTION__, "[DATA] Temperature of " . $objectid . ": " . $temperature . " °C", "3");
                                    
                                    // Data
                                    $datenarray = array(
                                        'temperature_c'         =>  $temperature,
                                    );
                                    $output->debug(__FUNCTION__, "[DATA-ARRAY] " . $output->array_output($datenarray), "3");
                                    $datenarray_json = json_encode($datenarray);

                                    // database insert
                                    $db_insert_RC = $MaMS_Data->save_data($datenarray_json, $objectid);
                                    if ($db_insert_RC != "0") {
                                        $output->debug(__FUNCTION__, "[DB] insert failed", "1");
                                        $RC = 1;
                                    } 
                                } 
                            }
                        }
                    }
                }
            }
        }
            
        return $RC;
    }
}
