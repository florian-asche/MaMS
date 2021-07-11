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
                'pwm_channel',
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

        // #Calc#############################
        // # 0%   -> 160                    #
        // # 100% ->   0                    #
        // # -------------------------------#
        // # n = Number                     #
        // # P = Percentage                 #
        // # -------------------------------# 
        // # P = (160 - n) / 160 * 100      #
        // # n = 160 - (P * 160 / 100)      #
        // ##################################
        
        if (isset($jobdata['station_protocols']['configuration']['objectid'])) {
            $objectid = $jobdata['station_protocols']['configuration']['objectid'];
        }
        
        if (isset($jobdata['stations']['configuration']['ip'])) {
            $ip = $jobdata['stations']['configuration']['ip'];
        }
        
        if (isset($jobdata['stations']['configuration']['port'])) {
            $port = $jobdata['stations']['configuration']['port'];
        }
        
        if (isset($jobdata['station_protocols']['configuration']['pwm_channel'])) {
            $pwm_channel = $jobdata['station_protocols']['configuration']['pwm_channel'];
            $pwm_channel = strtolower($pwm_channel);
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing pwm_channel in station_protocols configuration", "3");
            return 1;
        }
        
        $eol_delimiters = chr(10);
        $answerstrings = array(
        //    'MAMS_USELINECOUNTER',
        //    'MAMS_FILTEROUT_ANSWERS',
            '([0-9.+-]{1,3})',
            'OK',
            'parse error',
            'ERROR',
            'EOF',
            'GOEXIT', 
        );
        $number_lines = "100";
        $connect_debug = false;
        
        //$data = $ConnectClass->tcp_connect($ip, $port, $request, $answerstring, $number_lines, $eol_delimiters, $connect_debug);
        $pwm = $ConnectClass->tcp_connect($ip, $port, "pwm set " . $pwm_channel . "\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($pwm), "3");
        
        // Filter for adc
        if (preg_match("/([0-9.+-]{1,3})/", $pwm[0])) {
            $pwm_raw = $pwm[0];
            $output->debug(__FUNCTION__, "[DATA] PWM RAW: " . $pwm_raw, "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on pwm raw failed", "1");
            return 1;
        }
        
        $pwm_original = round(((255-$pwm_raw)/255*100),0);
        $percentage = round($pwm_original, 2);
        $output->debug(__FUNCTION__, "[DATA] PWM PERCENTAGE: " . $percentage, "3");
        
        // Data
        $datenarray = array(
            'pwm_raw'             =>  $pwm_raw,
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


    /**
     * Send data for object to destination
     */
    public function send_data($jobdata) {
        global $output;
        $ConnectClass = NEW ConnectClass();

        // #Calc#############################
        // # 0%   -> 160                    #
        // # 100% ->   0                    #
        // # -------------------------------#
        // # n = Number                     #
        // # P = Percentage                 #
        // # -------------------------------# 
        // # P = (160 - n) / 160 * 100      #
        // # n = 160 - (P * 160 / 100)      #
        // ##################################
        
        if (isset($jobdata['station_protocols']['configuration']['objectid'])) {
            $objectid = $jobdata['station_protocols']['configuration']['objectid'];
        }
        
        if (isset($jobdata['stations']['configuration']['ip'])) {
            $ip = $jobdata['stations']['configuration']['ip'];
        }
        
        if (isset($jobdata['stations']['configuration']['port'])) {
            $port = $jobdata['stations']['configuration']['port'];
        }
        
        if (isset($jobdata['station_protocols']['configuration']['pwm_channel'])) {
            $pwm_channel = $jobdata['station_protocols']['configuration']['pwm_channel'];
            $pwm_channel = strtolower($pwm_channel);
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing pwm_channel in station_protocols configuration", "3");
            return 1;
        }
        
        if (isset($jobdata['queue']['configuration']['action_wert1'])) {
            $pwm_set_percentage = $jobdata['queue']['configuration']['action_wert1'];
            $pwm_set_percentage = (255-($pwm_set_percentage*255/100));
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing action_wert1 in queue configuration", "3");
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
        $set = $ConnectClass->tcp_connect($ip, $port, "!pwm set " . $pwm_channel . " " . $pwm_set_percentage . "\r\n", $answerstrings, $number_lines, $eol_delimiters, $connect_debug);
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