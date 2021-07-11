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
    
    //
    //mq135
    //- ppm = ppm concentration
    //- ro = measured ro value
    //- res = ??
    //- defaultro = get/set default ro value
    //
    //mq135 ppm
    //101
    //mq135 ro
    //2579
    //mq135 res
    //43974
    //mq135 defaultro
    //41763
    //
    
    
    
    
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
        $mq135_ppm = $ConnectClass->tcp_connect($ip, $port, "mq135 ppm" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($mq135_ppm), "3");
        
        $mq135_ro = $ConnectClass->tcp_connect($ip, $port, "mq135 ro" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($mq135_ro), "3");
        
        $mq135_res = $ConnectClass->tcp_connect($ip, $port, "mq135 res" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($mq135_res), "3");
        
        $mq135_defaultro = $ConnectClass->tcp_connect($ip, $port, "mq135 defaultro" . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($mq135_defaultro), "3");

        // Filter for ppm
        if (preg_match("/([0-9.+-]+)/", $mq135_ppm[0])) {
            $mq135_ppm = $mq135_ppm[0];
            $output->debug(__FUNCTION__, "[DATA] ppm=" . $mq135_ppm, "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on ppm failed", "1");
            return 1;
        }
        
        // Filter for ro
        if (preg_match("/([0-9.+-]+)/", $mq135_ro[0])) {
            $mq135_ro = $mq135_ro[0];
            $output->debug(__FUNCTION__, "[DATA] ro=" . $mq135_ro, "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on ro failed", "1");
            return 1;
        }

        
        // Filter for ro
        if (preg_match("/([0-9.+-]+)/", $mq135_res[0])) {
            $mq135_res = $mq135_res[0];
            $output->debug(__FUNCTION__, "[DATA] res=" . $mq135_res, "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on res failed", "1");
            return 1;
        }
        
        
        // Filter for ro
        if (preg_match("/([0-9.+-]+)/", $mq135_defaultro[0])) {
            $mq135_defaultro = $mq135_defaultro[0];
            $output->debug(__FUNCTION__, "[DATA] defaultro=" . $mq135_defaultro, "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on defaultro failed", "1");
            return 1;
        }
        
        
        // Data
        $datenarray = array(
            'mq135_ppm'         =>  $mq135_ppm,
            'mq135_ro'          =>  $mq135_ro,
            'mq135_res'         =>  $mq135_res,
            'mq135_defaultro'   =>  $mq135_defaultro,
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
