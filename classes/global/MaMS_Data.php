<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################


/**
 * 
 */
class MaMS_Data {
    /**
     * 
     */
    public function __construct() {
    }

    
    /**
     * This function is for saving object data
     * 
     * @global type $output
     * @global type $MaMS_SQL
     * @param type $data
     * @param type $objectid
     * @return type
     */
    function save_data($data, $objectid) {
        global $output;
        global $MaMS_SQL;

        $sql_save_data = "INSERT INTO `data` (`data`, `objectid`,`timestamp`) VALUES ('$data', '$objectid', NOW())";
        $output->debug(__FUNCTION__, "[SQL] " . $sql_save_data, "3");
        $RC = $MaMS_SQL->sql_commit($sql_save_data);

        $output->debug(__FUNCTION__, "RC=" . $RC, "3");
        return $RC;
    }
    
    
    /**
     * 
     * @global type $default_configuration
     * @global type $MaMS_SQL
     * @param type $sql
     * @param type $object_template
     * @return type
     */
    public function get_data_global($sql, $object_template) {
        global $default_configuration;
        global $MaMS_SQL;

        $result_db = $MaMS_SQL->sql_get($sql);
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            // Add default data
            $result[$row['ID']] = $row;
            $result[$row['ID']]['resolved_data'] = json_decode($result[$row['ID']]['data'], true); // Convert it to array by specifying second argument to true

            // Add mapping
            $result[$row['ID']]['resolved_data'] = mapping_convert($result[$row['ID']]['resolved_data']);


            // Add additional_data
            if (isset($default_configuration['object_templates'][$object_template]['additional_data'])) {
                foreach($default_configuration['object_templates'][$object_template]['additional_data'] as $additional_data_fieldname=>$additional_data_function) {
                    //echo $additional_data_fieldname . "-" . $additional_data_function . "<br>";
                    //echo $data[$value['ID']]['resolved_data']['adc'];
                    //echo "<br>";
                    //$result[$value['ID']]['additional_data'][$name] = $data[$value['ID']]['json_data']['adc'] * 10;

                    if (isset($result[$row['ID']]['resolved_data'][$additional_data_fieldname])) {
                        echo "Das Feld ist bereits gesetzt!";
                    } else {
                        $result[$row['ID']]['resolved_data'][$additional_data_fieldname] = eval("return " . $additional_data_function . ";");
                    };
                };
            };

            // Add mapping
            $result[$row['ID']]['resolved_data'] = mapping_convert($result[$row['ID']]['resolved_data']);
        };
        //$linki->close();
        return($result);
    }
    
    
    public function get_data_latest_by_limit($number_of_data, $get_objectid, $object_template) {
        $sql = "SELECT *, UNIX_TIMESTAMP(`timestamp`) AS timestamp FROM data WHERE objectid = '" . $get_objectid . "' ORDER BY `timestamp` DESC LIMIT " . $number_of_data; 
        return $this->get_data_global($sql, $object_template); 
    }
    
    
    public function get_data_latest_one($get_objectid, $object_template) {
        $sql = "SELECT *, UNIX_TIMESTAMP(`timestamp`) AS timestamp FROM data WHERE objectid = '" . $get_objectid . "' ORDER BY `ID` DESC LIMIT 1"; 
        $result = $this->get_data_global($sql, $object_template); 
        $result = array_shift($result);
        return($result);

        //Array
        //(
        //    [ID] => 2956
        //    [objectid] => MAMS-ec1d80d24fd2c0d5ab63
        //    [timestamp] => 1424465728
        //    [event_check] => 0
        //    [data] => {"device_state":0}
        //    [resolved_data] => Array
        //        (
        //            [device_state] => OFF
        //            [device_state_original] => 0
        //        )
        //
        //)

        //Array
        //(
        //    [ID] => 2930
        //    [objectid] => MAMS-8fd35d6b4c923d638b8b
        //    [timestamp] => 1424378208
        //    [event_check] => 0
        //    [data] => {"adc_raw":463,"percentage":45.26}
        //    [resolved_data] => Array
        //        (
        //            [adc_raw] => 463
        //            [percentage] => 45.26
        //            [wind_direction] => SE
        //        )
        //
        //)
    }
    
    
    function get_data_by_time($timestamp_from, $timestamp_to, $get_objectid, $object_template) {
        $sql = "SELECT *, UNIX_TIMESTAMP(`timestamp`) AS timestamp FROM data WHERE objectid = '$get_objectid' AND UNIX_TIMESTAMP(`timestamp`) > '$timestamp_from' AND UNIX_TIMESTAMP(`timestamp`) < $timestamp_to ORDER BY `timestamp`";
        return $this->get_data_global($sql, $object_template); 
    }
    
    
    function get_evg($get_objectid) {
        global $MaMS_SQL;

        // Get sql data
        //$get_objectid = "MAMS-8a6306a5a3db5e0b31e6";
        $sql = "SELECT * FROM calc_evg WHERE objectid = '$get_objectid' ORDER BY `time`";
        $result_db = $MaMS_SQL->sql_get($sql);

        $result = array();
        while ($row = $result_db->fetch_assoc()) {
            $result[] = $row;
        };

        return($result);
    }
    
    
    function get_minmax($get_objectid) {
        global $MaMS_SQL;

        // Get sql data
        //$get_objectid = "MAMS-8a6306a5a3db5e0b31e6";
        $sql = "SELECT * FROM calc_minmax WHERE objectid = '$get_objectid' ORDER BY `time`, `type`";
        $result_db = $MaMS_SQL->sql_get($sql);

        $result = array();
        while ($row = $result_db->fetch_assoc()) {
            $result[] = $row;
        };

        return($result);
    }
    
    
    
    /**
     * 
     * @global type $MaMS_SQL
     * @return type
     */
    
//     [1] => Array
//        (
//            [ID] => 1
//            [name] => Default
//            [active] => 1
//        )
    
    public function get_pages() {
        global $MaMS_SQL;

        // Get sql data
        //$get_objectid = "MAMS-8a6306a5a3db5e0b31e6";
        $sql = "SELECT *"
                . " FROM pages"
                . " ORDER BY `ID`"; 

        $result_db = $MaMS_SQL->sql_get($sql);
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            $result[$row['ID']] = $row;
        };

        return($result);
    }
    
    
    public function get_page_objects() {
        global $MaMS_SQL;

        // Get sql data
        //$get_objectid = "MAMS-8a6306a5a3db5e0b31e6";
        $sql = "SELECT * FROM page_objects ORDER BY x,y, pageid";

        $result_db = $MaMS_SQL->sql_get($sql);
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            $result[$row['ID']] = $row;
        };

        return($result);
    }
    
    
    public function get_objects() {
        global $MaMS_SQL;
        global $default_configuration;

        // Get sql data
        $sql = "SELECT * FROM objects";
        $result_db = $MaMS_SQL->sql_get($sql);
        
        $result = array();
    
        while ($row = $result_db->fetch_assoc()) {
            $result[$row['objectid']] = $row;

            // START object_configuration --------------------------------------
            // Lokale Konfigurationsdatei
            //    -> Default
            //    -> Definiertes Template (wird hinzugefügt)
            //    -> Definierte Einstellungen überschreiben das Template falls notwendig

            $object_database_configuration = json_decode($result[$row['objectid']]['config'], true);
            if (!$object_database_configuration) {
                $object_database_configuration = array();
            }
            $result[$row['objectid']]['config_encoded'] = $object_database_configuration;

            $result[$row['objectid']]['configuration'] = $default_configuration['object_templates']['default'];
            if (isset($default_configuration['object_templates'][$result[$row['objectid']]['template']])) {
                $result[$row['objectid']]['configuration'] = array_merge($result[$row['objectid']]['configuration'], $default_configuration['object_templates'][$result[$row['objectid']]['template']]);
            };
            $result[$row['objectid']]['configuration'] = array_merge($result[$row['objectid']]['configuration'], $object_database_configuration);
            // END object_configuration ----------------------------------------
        };
    
        return($result);
    }
    
    
    function get_stations() {
        global $MaMS_SQL;
        
        // Get sql data
        $sql = "SELECT * FROM stations";
        $result_db = $MaMS_SQL->sql_get($sql);
 
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            $result[$row['ID']] = $row;

            // START configuration ---------------------------------------------
            $database_configuration = json_decode($result[$row['ID']]['config'], true);
            if (!$database_configuration) {
                $database_configuration = array();
            }
            $result[$row['ID']]['configuration'] = $database_configuration;
            // END configuration -----------------------------------------------
        };

        return($result);
    }
    
    

    function get_station_protocols() {
        global $MaMS_SQL;

        // Get sql data
        $sql = "SELECT * FROM station_protocols";
        $result_db = $MaMS_SQL->sql_get($sql);
        
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            $result[$row['ID']] = $row;

            // START configuration ---------------------------------------------
            $database_configuration = json_decode($result[$row['ID']]['config'], true);
            if (!$database_configuration) {
                $database_configuration = array();
            }
            $result[$row['ID']]['configuration'] = $database_configuration;
            // END configuration -----------------------------------------------
        };

        return($result);
    }
    
    
    function get_queue() {
        global $MaMS_SQL;

        // Get sql data
        $sql = "SELECT *, ";
        $sql .= "UNIX_TIMESTAMP(`lastrun_timestamp`) AS lastrun_timestamp ";
        $sql .= "FROM queue ";
        //$sql .= "WHERE `ID` =18672";
        $sql .= " ORDER BY ID DESC, priority DESC";
        //$sql .= " LIMIT 1";
        $result_db = $MaMS_SQL->sql_get($sql);
        
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            $result[$row['ID']] = $row;

            // START configuration ---------------------------------------------
            $database_configuration = json_decode($result[$row['ID']]['config'], true);
            if (!$database_configuration) {
                $database_configuration = array();
            }
            $result[$row['ID']]['configuration'] = $database_configuration;
            // END configuration -----------------------------------------------

            // START Should the process run ------------------------------------
            $process_should_run_at = time() - $result[$row['ID']]['intervall_time'];
            $result[$row['ID']]['process_should_run_at'] = $process_should_run_at;
            $result[$row['ID']]['process_should_run_since'] = $process_should_run_at - $result[$row['ID']]['lastrun_timestamp'];

            if ($result[$row['ID']]['process_should_run_since'] >= "0") {
                $result[$row['ID']]['process_should_run'] = "1";
            } else {
                $result[$row['ID']]['process_should_run'] = "0";
            }
            // END Should the process run --------------------------------------
        }

        return($result);
    }
    
    
    function get_queue_lock() {
        global $MaMS_SQL;

        // Get sql data
        $sql  = "SELECT *, ";
        $sql .= "UNIX_TIMESTAMP(`timestamp`) AS timestamp_unix ";
        $sql .= " FROM queue_lock";
        $result_db = $MaMS_SQL->sql_get($sql);
        
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            $result[$row['ID']] = $row;
        };
        
        return($result);
    }
    
    
    
//    [24] => Array
//        (
//            [page_objects] => Array
//                (
//                    [ID] => 24
//                    [pageid] => 1
//                    [objectid] => MAMS-ea195b713d0f6021da73
//                    [active] => 1
//                    [y] => 5
//                    [x] => 6
//                )
//
//            [objects] => Array
//                (
//                    [ID] => 24
//                    [name] => LCDBacklight
//                    [objectid] => MAMS-ea195b713d0f6021da73
//                    [template] => ethersex_pin
//                    [station_protocols_ID] => 18173
//                    [config] => 
//                    [config_encoded] => Array
//                        (
//                        )
//
//                    [configuration] => Array
//                        (
//                            [used_template] => ethersex_pin
//                            [sizex] => 1
//                            [sizey] => 1
//                            [backgroundcolor] => #006550
//                            [calc] => Array
//                                (
//                                )
//
//                            [object_type_name] => Ethersex PIN Switch
//                            [description] => PIN?
//                            [show_graph] => Array
//                                (
//                                    [0] => device_state_original
//                                )
//
//                            [show_table] => Array
//                                (
//                                    [0] => device_state
//                                )
//
//                            [load_control_panels_dashboard] => Array
//                                (
//                                )
//
//                            [default_control_panels_values] => Array
//                                (
//                                )
//
//                            [load_templates_mouseover] => Array
//                                (
//                                    [Data] => data_table.tpl
//                                    [Average] => data_evg.tpl
//                                    [Min./Max.] => data_minmax.tpl
//                                )
//
//                            [data_adaptation] => Array
//                                (
//                                )
//
//                            [additional_data] => Array
//                                (
//                                )
//
//                        )
//
//                )
//
//            [station_protocols] => Array
//                (
//                    [ID] => 18173
//                    [stations_ID] => 18142
//                    [info] => LCDBacklight
//                    [class] => Ethersex_BACKLIGHT.php
//                    [active] => 0
//                    [config] => {"objectid":"MAMS-ea195b713d0f6021da73"}
//                    [configuration] => Array
//                        (
//                            [objectid] => MAMS-ea195b713d0f6021da73
//                        )
//
//                )
//
//            [stations] => Array
//                (
//                    [ID] => 18142
//                    [config] => {"ip":"192.168.0.43","port":"2701","lock_station":"1"}
//                    [configuration] => Array
//                        (
//                            [ip] => 192.168.0.43
//                            [port] => 2701
//                            [lock_station] => 1
//                        )
//
//                )
//
//        )
    
    public function create_combined_page_objects_data() {
        global $MaMS_Data;

        $load_data_page_objects = $MaMS_Data->get_page_objects();
        $load_data_objects = $MaMS_Data->get_objects();
        $load_data_station_protocols = $MaMS_Data->get_station_protocols();
        $load_data_stations = $MaMS_Data->get_stations();
        //$load_data_queue = load_data_queue();
        //$load_data_queue_lock = load_data_queue_lock();
        //include('system_config.php');

        $result = array();

        foreach ($load_data_page_objects as $PAGE_OBJECT) {
            //echo $PAGE_OBJECT['ID'];    
            //echo '<pre>';
            //print_r($load_data_objects);
            //echo '</pre>';           
            //echo "<br><br>";

             $result[$PAGE_OBJECT['ID']]['page_objects'] = $load_data_page_objects[$PAGE_OBJECT['ID']];

             if (isset($load_data_objects[$result[$PAGE_OBJECT['ID']]['page_objects']['objectid']])) {
                $result[$PAGE_OBJECT['ID']]['objects'] = $load_data_objects[$result[$PAGE_OBJECT['ID']]['page_objects']['objectid']];
             } else {
                 $result[$PAGE_OBJECT['ID']]['objects'] = array();
                 echo "Warning: Missing Object for an Page_Object that is configured on your Page!";
                 echo "<br>";
                 echo "ID=" . $result[$PAGE_OBJECT['ID']]['page_objects']['ID'];
                 echo "<br>";
                 echo "OBJECTID=" . $result[$PAGE_OBJECT['ID']]['page_objects']['objectid'];
                 exit(1);
             };

             if (isset($load_data_station_protocols[$result[$PAGE_OBJECT['ID']]['objects']['station_protocols_ID']])) {
                $result[$PAGE_OBJECT['ID']]['station_protocols'] = $load_data_station_protocols[$result[$PAGE_OBJECT['ID']]['objects']['station_protocols_ID']];

                if (isset($load_data_stations[$result[$PAGE_OBJECT['ID']]['station_protocols']['stations_ID']])) {
                   $result[$PAGE_OBJECT['ID']]['stations'] = $load_data_stations[$result[$PAGE_OBJECT['ID']]['station_protocols']['stations_ID']];
                } else {
                    $result[$PAGE_OBJECT['ID']]['stations'] = array();
                };

                // Rausgenommen wiel es kann ja auch zwei queue geben zu der selben protokoll id
    //            if (isset($load_data_queue[$result[$PAGE_OBJECT['ID']]['station_protocols']['ID']])) {
    //               $result[$PAGE_OBJECT['ID']]['queue'] = $load_data_queue[$result[$PAGE_OBJECT['ID']]['station_protocols']['ID']];
    //            } else {
    //                $result[$PAGE_OBJECT['ID']]['queue'] = array();
    //            };
    //            
    //            if (isset($load_data_queue_lock[$result[$PAGE_OBJECT['ID']]['stations']['ID']])) {
    //               $result[$PAGE_OBJECT['ID']]['queue_lock'] = $load_data_queue_lock[$result[$PAGE_OBJECT['ID']]['stations']['ID']];
    //            } else {
    //                $result[$PAGE_OBJECT['ID']]['queue_lock'] = array();
    //            };
             } else {
                 $result[$PAGE_OBJECT['ID']]['station_protocols'] = array();
                 $result[$PAGE_OBJECT['ID']]['stations'] = array();
    //             $result[$PAGE_OBJECT['ID']]['queue'] = array();
    //             $result[$PAGE_OBJECT['ID']]['queue_lock'] = array();
             };
        };

        return($result);
    }
}