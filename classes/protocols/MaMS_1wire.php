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
        
        $sendcommand = "1wire";
        
        if (isset($jobdata['stations']['configuration']['sendcommand'])) {
            $sendcommand = $jobdata['stations']['configuration']['sendcommand'];
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
        
        $rec_data = $ConnectClass->tcp_connect($ip, $port, $sendcommand . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($rec_data), "3");
        if ($rec_data) {
            foreach ($rec_data as $rec_data_line) {
                if ($rec_data_line) {
                    if ($rec_data_line !== "") {
                        $output->debug(__FUNCTION__, "[RETURNED-DATA-LINE] " . $output->array_output($rec_data_line), "3");
                        if (preg_match_all("/([0-9A-Z]+) Temperatur ([0-9]+): ([0-9.+-]+) Grad/", $rec_data_line, $matches, PREG_SET_ORDER)) {
                            $objectid = $matches[0][1];
                            $temperature = $matches[0][3];
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
            
        return $RC;
    }
}
