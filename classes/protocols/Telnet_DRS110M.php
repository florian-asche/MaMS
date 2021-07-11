<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

/**
 * JobClass for Process
 */
class JobClass {
    //Clarification:
    //--------------
    // 
    //Known registers:
    // 
    //READ (length)
    //#############
    //0: voltage (4)
    //1: current (4)
    //10: Energy (8)
    //34: Serial number (12)
    //36: Meter ID (12)
    // 
    //WRITE (length)
    //##############
    //34: Serial number (12)
    //36: Meter ID (12)
    //37: Password (8)
    //40: ClearEnergy (0)
    // 
    //{} receive from energy meter
    //[] send to energy meter
    
    //http://www.regexr.com/ VERY HELPFULL
    
    public function __construct() {
        $job_configuration = array(
            'queue' => array(
            ),
            'station' => array(
                'ip',
                'port',
                'lock_station' => '1', // If the Station should get locked
            ),
            'station_protocol' => array(
                'objectid', // If a uniqe id in setup should get generated
                'device_id',
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
        
        if (isset($jobdata['station_protocols']['configuration']['device_id'])) {
            $device_id = $jobdata['station_protocols']['configuration']['device_id'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_id in station_protocols configuration", "1");
            return 1;
        }

        if (isset($jobdata['station_protocols']['configuration']['device_password'])) {
            $device_password = $jobdata['station_protocols']['configuration']['device_password'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_password in station_protocols configuration", "1");
            return 1;
        }
        
        $number_lines = "1";
        $connect_debug = false;
        
        $prestart = $ConnectClass->tcp_connect($ip, $port, "/?!".chr(13).chr(10), array('SENDONLY'), $number_lines, "", $connect_debug);
        $prestart2 = $ConnectClass->tcp_connect($ip, $port, "/?!".chr(13).chr(10), array('SENDONLY'), $number_lines, "", $connect_debug);
	usleep(280000);
        // Send start mode
	$start = $ConnectClass->tcp_connect($ip, $port, "/?".$device_id."!".chr(13).chr(10), array('YTL:'.$device_id), $number_lines, chr(13).chr(10), $connect_debug);
        
	if (!empty($start) and is_array($start) and $start['0'] == chr(47)."YTL:".$device_id) {
            usleep(80000);
            // Set prog mode
            $progmode = $ConnectClass->tcp_connect($ip, $port, chr(0x06).chr(0x30).":".chr(0x31).chr(0x0D).chr(0x0A).chr(13).chr(10), array(chr(1).'P0'.chr(2).'(00000000)'), $number_lines, chr(3).chr(96), $connect_debug);
            if ($progmode['0'] == chr(1).'P0'.chr(2).'(00000000)') {
                usleep(280000);
                // Send password
                $passwordsend = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."P1".chr(0x02)."(".$device_password.")".chr(0x03).chr(0x61), array('SENDONLY'), $number_lines, "", $connect_debug);
                usleep(280000);

                //Spannung
                $voltage_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000000()".chr(0x03).chr(0x63), array('00000000\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $voltage_match = mams_match_search($voltage_raw, "/" . "00000000\(([0-9]{4})\)" . "/");
                if (count($voltage_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $voltage = $voltage_match['0']['0']['1'] / 10;
                    $output->debug(__FUNCTION__, "[DATA] voltage=" . $voltage . "V", "3");
                }
                usleep(80000);

                //Strom
                $power_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000001()".chr(0x03).chr(0x62), array('00000001\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $power_match = mams_match_search($power_raw, "/" . "00000001\(([0-9]{4})\)" . "/");
                if (count($power_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $power = $power_match['0']['0']['1'] / 10;
                    $output->debug(__FUNCTION__, "[DATA] power=" . $power . "A", "3");
                }
                usleep(80000);

                // Frequenz
                $frequency_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000002()".chr(0x03).chr(0x61), array('00000002\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $frequency_match = mams_match_search($frequency_raw, "/" . "00000002\(([0-9]{4})\)" . "/");
                if (count($frequency_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $frequency = $frequency_match['0']['0']['1'] / 10;
                    $output->debug(__FUNCTION__, "[DATA] frequency=" . $frequency . "Hz", "3");
                }
                usleep(80000);

                //Wirkleistung
                $active_power_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000003()".chr(0x03).chr(0x60), array('0000003\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $active_power_match = mams_match_search($active_power_raw, "/" . "00000003\(([0-9]{4})\)" . "/");
                if (count($active_power_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $active_power = $active_power_match['0']['0']['1'] * 10;
                    $output->debug(__FUNCTION__, "[DATA] active_power=" . $active_power . "W", "3");
                }
                usleep(80000);

                //Blindleistung
                $reactive_power_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000004()".chr(0x03).chr(0x67), array('00000004\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $reactive_power_match = mams_match_search($reactive_power_raw, "/" . "00000004\(([0-9]{4})\)" . "/");
                if (count($reactive_power_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $reactive_power = $reactive_power_match['0']['0']['1'] * 10;
                    $output->debug(__FUNCTION__, "[DATA] reactive_power=" . $reactive_power . "VAr", "3");
                }
                usleep(80000);

                //Scheinleistung
                $apparent_power_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000005()".chr(0x03).chr(0x66), array('00000005\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $apparent_power_match = mams_match_search($apparent_power_raw, "/" . "00000005\(([0-9]{4})\)" . "/");
                if (count($apparent_power_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $apparent_power = $apparent_power_match['0']['0']['1'] * 10;
                    $output->debug(__FUNCTION__, "[DATA] apparent_power=" . $apparent_power . "VA", "3");
                }
                usleep(80000);

                //Leistungsfaktor
                $power_factor_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000006()".chr(0x03).chr(0x65), array('00000006\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $power_factor_match = mams_match_search($power_factor_raw, "/" . "00000006\(([0-9]{4})\)" . "/");
                if (count($power_factor_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $power_factor = $power_factor_match['0']['0']['1'] / 1000;
                    $output->debug(__FUNCTION__, "[DATA] power_factor=" . $power_factor . "", "3");
                }
                usleep(80000);

                //Gesamtleistung Zaehlerstand
                $total_power_meter_reading_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000010()".chr(0x03).chr(0x62), array('00000010\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $total_power_meter_reading_match = mams_match_search($total_power_meter_reading_raw, "/" . "00000010\(([0-9]{8})\)" . "/");
                if (count($total_power_meter_reading_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $total_power_meter_reading = $total_power_meter_reading_match['0']['0']['1'] / 1000;
                    $output->debug(__FUNCTION__, "[DATA] total_power_meter_reading=" . $total_power_meter_reading . "kWh", "3");
                }
                usleep(80000);

                //Gesamtleistung Zaehlerstand Kopie
                $total_power_meter_reading_copy_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000011()".chr(0x03).chr(0x63), array("00000011\(([0-9]+)\)"), $number_lines, chr(3), $connect_debug);
                $total_power_meter_reading_copy_match = mams_match_search($total_power_meter_reading_copy_raw, "/" . "00000011\(([0-9]{8})\)" . "/");
                if (count($total_power_meter_reading_copy_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $total_power_meter_reading_copy = $total_power_meter_reading_copy_match['0']['0']['1'] / 1000;
                    $output->debug(__FUNCTION__, "[DATA] total_power_meter_reading_copy=" . $total_power_meter_reading_copy . "kWh", "3");
                }
                usleep(80000);

                //Energie in Rueckwaertsrichtung
                $energy_in_reverse_direction_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000020()".chr(0x03).chr(0x61), array('00000020\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $energy_in_reverse_direction_match = mams_match_search($energy_in_reverse_direction_raw, "/" . "00000020\(([0-9]{8})\)" . "/");
                if (count($energy_in_reverse_direction_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $energy_in_reverse_direction = $energy_in_reverse_direction_match['0']['0']['1'] / 1000;
                    $output->debug(__FUNCTION__, "[DATA] energy_in_reverse_direction=" . $energy_in_reverse_direction . "kWh", "3");
                }
                usleep(80000);

                //Energie in Rueckwaertsrichtung Kopie
                $energy_in_reverse_direction_copy_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000021()".chr(0x03).chr(0x60), array('00000021\(([0-9]+)\)'), $number_lines, chr(3), $connect_debug);
                $energy_in_reverse_direction_copy_match = mams_match_search($energy_in_reverse_direction_copy_raw, "/" . "00000021\(([0-9]{8})\)" . "/");
                if (count($energy_in_reverse_direction_copy_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $energy_in_reverse_direction_copy = $energy_in_reverse_direction_copy_match['0']['0']['1'] / 1000;
                    $output->debug(__FUNCTION__, "[DATA] energy_in_reverse_direction_copy=" . $energy_in_reverse_direction_copy . "kWh", "3");
                }
                usleep(80000);

                //Temperatur
                // Often i get (001>) data, dont know why... so... as a workaround, i allow all chars
                $temperature_raw = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000032()".chr(0x03).chr(0x62), array('00000032\((.{4})\)'), $number_lines, chr(3), $connect_debug);
                $temperature_match = mams_match_search($temperature_raw, "/" . "00000032\((.{4})\)" . "/");
                if (count($temperature_match) < 1) {
                    $output->debug(__FUNCTION__, "[ERROR] missing data", "1");
                    return 1;
                } else {
                    $temperature = $temperature_match['0']['0']['1'] / 1;
                    $output->debug(__FUNCTION__, "[DATA] temperature=" . $temperature . "°C", "3");
                }
                usleep(80000);

                // End
                $exit = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."B0".chr(0x03).chr(0x71), array('SENDONLY'), $number_lines, "", $connect_debug);
                usleep(280000);

                // Data
                $datenarray = array(
                    'voltage'                           =>  $voltage,                                 //Spannung (V)
                    'power'                             =>  $power,                                   //Strom (A)
                    'frequency'                         =>  $frequency,                               //Frequenz (Hz)
                    'active_power'                      =>  $active_power,                            //Wirkleistung (W)
                    'reactive_power'                    =>  $reactive_power,                          //Blindleistung (VAr)
                    'apparent_power'                    =>  $apparent_power,                          //Scheinleistung (VA)
                    'power_factor'                      =>  $power_factor,                            //Leistungsfaktor (-)
                    'total_power_meter_reading'         =>  $total_power_meter_reading,               //Gesamtleistung Zaehlerstand (kWh)
                    'total_power_meter_reading_copy'    =>  $total_power_meter_reading_copy,          //Gesamtleistung Zaehlerstand Kopie (kWh)
                    'energy_in_reverse_direction'       =>  $energy_in_reverse_direction,             //Energie in Rueckwaertsrichtung (kWh)
                    'energy_in_reverse_direction_copy'  =>  $energy_in_reverse_direction_copy,        //Energie in Rueckwaertsrichtung Kopie (kWh)
                    'temperature_c'                     =>  $temperature,                             //Temperatur (°C)
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
            }
            return 0;
        } else {
            return 1;
        }
        
        return 0;
    }
    
    
    /**
     * Load data for object from destination
     */
    public function load_data_settings($jobdata) {
        global $output;
        global $MaMS_Queue;
        
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
        
        if (isset($jobdata['station_protocols']['configuration']['device_id'])) {
            $device_id = $jobdata['station_protocols']['configuration']['device_id'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_id in station_protocols configuration", "1");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['device_password'])) {
            $device_password = $jobdata['station_protocols']['configuration']['device_password'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_password in station_protocols configuration", "1");
            return 1;
        }
        
        $number_lines = "1";
        $connect_debug = false;
        
        $prestart = $ConnectClass->tcp_connect($ip, $port, "/?!".chr(13).chr(10), array('SENDONLY'), $number_lines, "", $connect_debug);
	usleep(80000);

	$start = $ConnectClass->tcp_connect($ip, $port, "/?".$device_id."!".chr(13).chr(10), array('YTL:'.$device_id), $number_lines, chr(13).chr(10), $connect_debug);
        
	if ($start['0'] == chr(47)."YTL:".$device_id) {
		usleep(80000);
		$progmode = $ConnectClass->tcp_connect($ip, $port, chr(0x06).chr(0x30).":".chr(0x31).chr(0x0D).chr(0x0A).chr(13).chr(10), array(chr(1).'P0'.chr(2).'(00000000)'), $number_lines, chr(3).chr(96), $connect_debug);
		if ($progmode['0'] == chr(1).'P0'.chr(2).'(00000000)') {
                    usleep(280000);
                    $passwordsend = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."P1".chr(0x02)."(".$device_password.")".chr(0x03).chr(0x61), array('SENDONLY'), $number_lines, "", $connect_debug);
                    usleep(280000);
                    
                    //Time (14 Chr)
                    //substr($zeit,4,2).".".substr($zeit,2,2).".20".substr($zeit,0,2)."; ".substr($zeit,8,2).":".substr($zeit,10,2).":".substr($zeit,12,2);
                    $time = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000031()".chr(0x03).chr(0x61), array('00000031\(([0-9A-Za-z]+)\)'), $number_lines, chr(3), $connect_debug);
                    usleep(80000);
                    
                    //Serial Number (12 Chr)
                    $serial_number = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000034()".chr(0x03).chr(0x64), array('00000034\(([0-9A-Za-z]+)\)'), $number_lines, chr(3), $connect_debug);
                    usleep(80000);
                    
                    // Baud (4*1)
                    //(1=1200; 2=2400; 3=4800; 4=9600)
                    $baudrate = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000035()".chr(0x03).chr(0x65), array('00000035\(([0-9A-Za-z]+)\)'), $number_lines, chr(3), $connect_debug);
                    usleep(80000);
                    
                    // Meter ID (12 Chr)
                    $meter_id = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."R1".chr(0x02)."00000036()".chr(0x03).chr(0x66), array('00000036\(([0-9A-Za-z]+)\)'), $number_lines, chr(3), $connect_debug);
                    usleep(80000);
                    
                    // End
                    $exit = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."B0".chr(0x03).chr(0x71), array('SENDONLY'), $number_lines, "", $connect_debug);
                }
        }

        return 0;
    }
    
    
    /**
     * Load data for object from destination
     */
    public function load_data_devIDList($jobdata) {
        global $output;
        global $MaMS_Queue;
        
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
        
        if (isset($jobdata['station_protocols']['configuration']['device_id'])) {
            $device_id = $jobdata['station_protocols']['configuration']['device_id'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_id in station_protocols configuration", "1");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['device_password'])) {
            $device_password = $jobdata['station_protocols']['configuration']['device_password'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_password in station_protocols configuration", "1");
            return 1;
        }
        
        $number_lines = "1";
        $connect_debug = true;
        
        $devices = $ConnectClass->tcp_connect($ip, $port, "/?!".chr(13).chr(10), array('SENDoONLY'), $number_lines, chr(3), $connect_debug);
        
        return 0;
    }
    
    
    /**
     * Load data for object from destination
     */
    public function send_data_reset($jobdata) {
        global $output;
        global $MaMS_Queue;
        
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
        
        if (isset($jobdata['station_protocols']['configuration']['device_id'])) {
            $device_id = $jobdata['station_protocols']['configuration']['device_id'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_id in station_protocols configuration", "1");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['device_password'])) {
            $device_password = $jobdata['station_protocols']['configuration']['device_password'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_password in station_protocols configuration", "1");
            return 1;
        }
        
        $number_lines = "1";
        $connect_debug = false;
        
        $prestart = $ConnectClass->tcp_connect($ip, $port, "/?!".chr(13).chr(10), array('SENDONLY'), $number_lines, "", $connect_debug);
	usleep(80000);

	$start = $ConnectClass->tcp_connect($ip, $port, "/?".$device_id."!".chr(13).chr(10), array('YTL:'.$device_id), $number_lines, chr(13).chr(10), $connect_debug);
        
	if ($start['0'] == chr(47)."YTL:".$device_id) {
		usleep(80000);
		$progmode = $ConnectClass->tcp_connect($ip, $port, chr(0x06).chr(0x30).":".chr(0x31).chr(0x0D).chr(0x0A).chr(13).chr(10), array(chr(1).'P0'.chr(2).'(00000000)'), $number_lines, chr(3).chr(96), $connect_debug);
		if ($progmode['0'] == chr(1).'P0'.chr(2).'(00000000)') {
                    usleep(280000);
                    
                    $passwordsend = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."P1".chr(0x02)."(".$device_password.")".chr(0x03).chr(0x61), array('SENDONLY'), $number_lines, "", $connect_debug);
                    usleep(280000);
                    
                    $reset_device = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."W1".chr(0x02)."00000040(1)".chr(0x03).chr(0x52), array('SENDONLY'), $number_lines, chr(6), $connect_debug);
                    usleep(280000);
	
                    $exit = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."B0".chr(0x03).chr(0x71), array('SENDONLY'), $number_lines, "", $connect_debug);
                }
        }
        
        return 0;
    }
    
    
    /**
     * Load data for object from destination
     */
    public function send_data_settings($jobdata) {
        global $output;
        global $MaMS_Queue;
        
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
        
        if (isset($jobdata['station_protocols']['configuration']['device_id'])) {
            $device_id = $jobdata['station_protocols']['configuration']['device_id'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_id in station_protocols configuration", "1");
            return 1;
        }
        
        if (isset($jobdata['station_protocols']['configuration']['device_password'])) {
            $device_password = $jobdata['station_protocols']['configuration']['device_password'];
        } else {
            $output->debug(__FUNCTION__, "[ERROR] missing device_password in station_protocols configuration", "1");
            return 1;
        }
        
        $number_lines = "1";
        $connect_debug = false;
        
        $prestart = $ConnectClass->tcp_connect($ip, $port, "/?!".chr(13).chr(10), array('SENDONLY'), $number_lines, "", $connect_debug);
	usleep(80000);

	$start = $ConnectClass->tcp_connect($ip, $port, "/?".$device_id."!".chr(13).chr(10), array('YTL:'.$device_id), $number_lines, chr(13).chr(10), $connect_debug);
        
	if ($start['0'] == chr(47)."YTL:".$device_id) {
		usleep(80000);
		$progmode = $ConnectClass->tcp_connect($ip, $port, chr(0x06).chr(0x30).":".chr(0x31).chr(0x0D).chr(0x0A).chr(13).chr(10), array(chr(1).'P0'.chr(2).'(00000000)'), $number_lines, chr(3).chr(96), $connect_debug);
		if ($progmode['0'] == chr(1).'P0'.chr(2).'(00000000)') {
                    usleep(280000);
                    
                    $passwordsend = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."P1".chr(0x02)."(".$device_password.")".chr(0x03).chr(0x61), array('SENDONLY'), $number_lines, "", $connect_debug);
                    usleep(280000);
                    
                    $change_password = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."W1".chr(0x02)."00000037(00000000)".chr(0x03).chr(0x52), array('SENDONLY'), $number_lines, chr(6), $connect_debug);
                    usleep(280000);

                    $change_meter_id = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."W1".chr(0x02)."00000036(".$device_id.")".chr(0x03).chr(0x52), array('SENDONLY'), $number_lines, chr(6), $connect_debug);
                    usleep(280000);
                    
                    $change_serial = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."W1".chr(0x02)."00000034(000000000000)".chr(0x03).chr(0x52), array('SENDONLY'), $number_lines, chr(6), $connect_debug);
                    usleep(280000);
           
                    $exit = $ConnectClass->tcp_connect($ip, $port, chr(0x01)."B0".chr(0x03).chr(0x71), array('SENDONLY'), $number_lines, "", $connect_debug);
                }
        }
        
        return 0;
    }  
}
