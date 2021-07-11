<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

/**
 * JobClass for Process
 */
class JobClass {
    // http://www.ethersex.de/index.php/ECMD_Reference
    
    public function __construct() {
        $this->job_configuration = array(
            'queue' => array(
            ),
            'send_queue' => array(
                'trigger_data_update' => '0',
                'archive_job' => '1',
            ),
            'station' => array(
                'ip',
                'port',
                'lock_station' => '1', // If the Station should get locked
            ),
            'station_protocol' => array(
                'objectid', // If a uniqe id in setup should get generated
                'rfm12_family' => '1',
                'rfm12_group' => '1',
                'rfm12_device' => '1',
            ),
        );
    }
    
    /**
     * This function is loaded in setup area
     */
    public function setup() {
        
    }
 
    
    /**
     * Send data for object to destination
     */
    public function load_data($jobdata) {
        return 0;
    }
    
    /**
     * Send data for object to destination
     */
    public function send_data($jobdata) {
        global $output;
        global $default_configuration;
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
        
        if (isset($jobdata['station_protocols']['configuration']['rfm12_family'])) {
            $rfm12_family = $jobdata['station_protocols']['configuration']['rfm12_family'];
            $rfm12_family = strtolower($rfm12_family);
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing rfm12_family in station_protocols configuration", "3");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['rfm12_group'])) {
            $rfm12_group = $jobdata['station_protocols']['configuration']['rfm12_group'];
            $rfm12_group = strtolower($rfm12_group);
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing rfm12_group in station_protocols configuration", "3");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['rfm12_device'])) {
            $rfm12_device = $jobdata['station_protocols']['configuration']['rfm12_device'];
            $rfm12_device = strtolower($rfm12_device);
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing rfm12_device in station_protocols configuration", "3");
            return 1;
        }
        
        if (isset($jobdata['queue']['configuration']['action_wert1'])) {
            $raw = $jobdata['queue']['configuration']['action_wert1'];
            
            // Filter for pin status
            $output->debug(__FUNCTION__, "[MATCH] " . $raw, "3");
            if (preg_match("/(1)/", $raw)) {
                $pin_set = "1";
            } elseif (preg_match("/(0)/", $raw)) {
                $pin_set = "0";
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
        $set = $ConnectClass->tcp_connect($ip, $port, "ask intertechno " . $rfm12_family . " " . $rfm12_group . " " . $rfm12_device . " " . $pin_set . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
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