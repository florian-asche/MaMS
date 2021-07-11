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
        $job_configuration = array(
            'object_template' => array(
                'reload_method' => '0', // 0 = Java // 1 = HTML
                'reloadtime' => '60',
            ),
            'queue' => array(
            ),
            'station' => array(
                'ip',
                'port',
                'lock_station' => '0', // If the Station should get locked
            ),
            'station_protocol' => array(
                'objectid', // If a uniqe id in setup should get generated
                'downloadpfad' => 'http://USER:PASS@192.168.0.27:88/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&u',
                'device_password',
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
        
        // Download Picture from Webacm
        
        // Archive Webcam Picture?
        
        return 0;
    }
}
