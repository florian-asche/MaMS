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
                'adc_channel',
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
        
        if (isset($jobdata['station_protocols']['configuration']['adc_channel'])) {
            $adc_channel = $jobdata['station_protocols']['configuration']['adc_channel'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing adc_channel in station_protocols configuration", "3");
            return 1;
        }
        
        $eol_delimiters = chr(10);
        $answerstrings = array(
        //    'MAMS_USELINECOUNTER',
        //    'MAMS_FILTEROUT_ANSWERS',
            '([A-F0-9]{3})',
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "100";
        $connect_debug = false;
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $adc = $ConnectClass->tcp_connect($ip, $port, "adc get " . $adc_channel . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($adc), "3");
        
        // Filter for adc
        if (preg_match("/([A-F0-9]{3})/", $adc[0])) {
            $adc_hex = $adc[0];
            $output->debug(__FUNCTION__, "[DATA] ADC HEX: " . $adc_hex, "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on hex adc failed", "1");
            return 1;
        }
        
        // Calc data
        $adc_raw =  hexdec($adc_hex);
        $output->debug(__FUNCTION__, "[DATA] ADC RAW: " . $adc_raw, "3");
        
        $percentage_original = (($adc_raw * 100)/1023);
        $percentage = round($percentage_original, 2);
        $output->debug(__FUNCTION__, "[DATA] ADC PERCENTAGE: " . $percentage, "3");
        
        // Data
        $datenarray = array(
            'adc_raw'             =>  $adc_raw,
            'percentage'          =>  $percentage,
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
}
