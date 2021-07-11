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
                'lock_station' => '0', // If the Station should get locked
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
        
        if (isset($jobdata['station_protocols']['configuration']['mode'])) {
            $mode = $jobdata['station_protocols']['configuration']['mode'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing station_protocols mode", "1");
            return 1;
        }

        $url = "http://" . $ip . ":" . $port . "/color?mode=" . $mode;    

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, false);
        $json_response = curl_exec($curl);
        $response = json_decode($json_response, true);
        
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ( $status != 200 ) { // CODE 200 = OK
            $output->debug(__FUNCTION__, "[ERROR] Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl), "1");
            return 1;
        }

        curl_close($curl);

        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($response), "3");
        
        if (isset($response) and is_array($response) and isset($response[$mode]) and is_array($response[$mode])) {
            $datenarray = array(
                'mode'        =>  $mode,
            );
            
            $datenarray = array_merge($datenarray, $response[$mode]);

            $output->debug(__FUNCTION__, "[DATA-ARRAY] " . $output->array_output($datenarray), "3");

            $output->debug(__FUNCTION__, "[DATA] Objectid: " . $objectid, "3");
            $datenarray_json = json_encode($datenarray);

            // Database insert
            $db_insert_RC = $MaMS_Data->save_data($datenarray_json, $objectid);
            if ($db_insert_RC != "0") {
                $output->debug(__FUNCTION__, "[DB] insert failed", "1");
                return 1;
            }
        } else {
            $output->debug(__FUNCTION__, "[ERROR] pattern match on array failed", "1");
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
        
        if (isset($jobdata['station_protocols']['configuration']['objectid'])) {
            $objectid = $jobdata['station_protocols']['configuration']['objectid'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing jobdata objectid", "1");
            return 1;
        }
        
        if (isset($jobdata['stations']['configuration']['ip'])) {
            $ip = $jobdata['stations']['configuration']['ip'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing jobdata ip", "1");
            return 1;
        }
        
        if (isset($jobdata['stations']['configuration']['port'])) {
            $port = $jobdata['stations']['configuration']['port'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing jobdata port", "1");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['mode'])) {
            $mode = $jobdata['station_protocols']['configuration']['mode'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing station_protocols mode", "1");
            return 1;
        }
        
        // mode - can be hsv or raw
        if ($mode == "hsv") {
            if (isset($jobdata['queue']['configuration']['h'])) {
                $h = $jobdata['queue']['configuration']['h'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata h", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['s'])) {
                $s = $jobdata['queue']['configuration']['s'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata s", "1");
                return 1;
            }        

            if (isset($jobdata['queue']['configuration']['v'])) {
                $v = $jobdata['queue']['configuration']['v'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata v", "1");
                return 1;
            }
            
            if (isset($jobdata['queue']['configuration']['ct'])) {
                $ct = $jobdata['queue']['configuration']['ct'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata ct", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['cmd'])) {
                $cmd = $jobdata['queue']['configuration']['cmd'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata cmd", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['t'])) {
                $t = $jobdata['queue']['configuration']['t'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata t", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['q'])) {
                $q = $jobdata['queue']['configuration']['q'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata q", "1");
                return 1;
            } 

            if (isset($jobdata['queue']['configuration']['d'])) {
                $d = $jobdata['queue']['configuration']['d'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata d", "1");
                return 1;
            }
            
            // hsv mode
            $jsondata = array(
                'hsv' => array(
                    'h'  => $h,  // hue (float) [0.0 - 360.0]
                    's'  => $s,  // saturation (float) [0.0 - 100.0]
                    'v'  => $v,  // value (float) [0.0 - 100.0]
                    'ct' => $ct, // ct - color temperatur in mirek [100 - 500] or kelvin [2000 - 10000] 
                ),
                'cmd' => $cmd,  // cmd - [fade/solid] fade to the new color in time t or show color for period t (cmd=solid)
                't' => $t,      // t - time (ms), the amount of time in which a transition takes place to the new color
                'q' => $q,      // q - queue(true/false), if the transition should be queued or executed directly
                'd' => $d,      // d - direction(1/0), if the transition should be via the shortest (1) or longest(0) distance between two colors
            );
        } elseif ($mode == "raw") {
            
            if (isset($jobdata['queue']['configuration']['r'])) {
                $r = $jobdata['queue']['configuration']['r'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata r", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['g'])) {
                $g = $jobdata['queue']['configuration']['g'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata g", "1");
                return 1;
            }        

            if (isset($jobdata['queue']['configuration']['b'])) {
                $b = $jobdata['queue']['configuration']['b'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata b", "1");
                return 1;
            }
            
            if (isset($jobdata['queue']['configuration']['ww'])) {
                $ww = $jobdata['queue']['configuration']['ww'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata ww", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['cw'])) {
                $cw = $jobdata['queue']['configuration']['cw'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata cw", "1");
                return 1;
            }            
            
            
            if (isset($jobdata['queue']['configuration']['cmd'])) {
                $cmd = $jobdata['queue']['configuration']['cmd'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata cmd", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['t'])) {
                $t = $jobdata['queue']['configuration']['t'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata t", "1");
                return 1;
            }

            if (isset($jobdata['queue']['configuration']['q'])) {
                $q = $jobdata['queue']['configuration']['q'];
            } else {
                $output->debug(__FUNCTION__, "[ERROR] missing jobdata q", "1");
                return 1;
            } 

            // raw mode
            $jsondata = array(
                'raw' => array(   
                    'r' => $r,   // r - value of red channel [0 - 1023]
                    'g' => $g,   // g - value of green channel [0 - 1023]
                    'b' => $b,   // b - value of blue channel [0 - 1023]
                    'ww' => $ww,  // ww - value of warm white channel [0 - 1023]
                    'cw' => $cw,  // cw - value of cold white channel [0 - 1023]
                ),
                'cmd' => $cmd,   // cmd - [fade/solid] fade to the new color in time t or show color for period t (cmd=solid)
                't'   => $t,     // t - time (ms), the amount of time in which a transition takes place to the new color
                'q'   => $q,     // q - queue(true/false), if the transition should be queued or executed directly
            );
        } else {
            $output->debug(__FUNCTION__, "[ERROR] wrong or missing mode", "1");
            return 1;
        }
        
//        
//        $jsondata = array(
//            'color' => array(
//                'h' => "0.0",
//                's' => "70.0",
//                'v' => "0.0",
//                'k' => "7000"
//                ),
//            'cmd' => array(
//                't' => "200",
//                'q' => false,
//                'd' => false
//            )
//        );        

        $output->debug(__FUNCTION__, "[DATA-ARRAY] " . $output->array_output($jsondata), "3");
        
        $url = "http://" . $ip . ":" . $port . "/color";    
        $content = json_encode($jsondata);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $response = json_decode($json_response, true);
        
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ( $status != 200 ) { // CODE 200 = OK
            $output->debug(__FUNCTION__, "[ERROR] Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl), "1");
            return 1;
        }

        curl_close($curl);

        $output->debug(__FUNCTION__, "[RETURNED-DATA] " . $output->array_output($response), "3");
        
        // CHECK IF RESPONSE IS OK
        if ($response['success'] == 'true') {
            $output->debug(__FUNCTION__, "[OK] set data succsessful", "3");
        } else {
            $output->debug(__FUNCTION__, "[ERROR] set data failed failed", "1");
            return 1;
        }
        
        return 0;
    }
}