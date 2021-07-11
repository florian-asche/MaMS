<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

//Array
//(
//    [18607] => Array
//        (
//            [queue] => Array
//                (
//                    [ID] => 18607
//                    [station_protocols_ID] => 18150
//                    [intervall_time] => 60
//                    [lastrun_timestamp] => 1422745555
//                    [type] => 0
//                    [function] => load_data
//                    [priority] => 20
//                    [config] => 
//                    [configuration] => Array
//                        (
//                        )
//
//                    [process_should_run_at] => 1423352640
//                    [process_should_run_since] => 607085
//                    [process_should_run] => 1
//                )
//
//            [station_protocols] => Array
//                (
//                    [ID] => 18150
//                    [stations_ID] => 18134
//                    [info] => Mobile Station
//                    [class] => Ethersex_BMP085.php
//                    [active] => 1
//                    [config] => {"objectid":"MAMS-4e193ce51a9cb54194a2"}
//                    [configuration] => Array
//                        (
//                            [objectid] => MAMS-4e193ce51a9cb54194a2
//                        )
//
//                )
//
//            [stations] => Array
//                (
//                    [ID] => 18134
//                    [config] => {"ip":"192.168.0.40","port":"2701"}
//                    [configuration] => Array
//                        (
//                            [ip] => 192.168.0.40
//                            [port] => 2701
//                        )
//
//                )
//
//            [queue_lock] => Array
//                (
//                )
//
//            [queue_lock_status] => 0
//        )
//
//)

/**
 * 
 */
class MaMS_Queue {
    /**
     * 
     */
    public function __construct() {
    }

    /**
     * 
     * @global type $output
     * @global type $default_configuration
     * @param type $original_data
     * @return type
     */
//    public function add_Mapping($original_data) {
//        global $output;
//        global $default_configuration;
//        
//        $map_data = array();
//        
//        foreach ($original_data as $key => $value) {
//            $mapping_array = array_flip($default_configuration['datatypes'][$key]['mapping']);
//            if (is_array($mapping_array)) {
//                $output->debug(__FUNCTION__, "[MAPPING] Found mapping for: " . $key . " with value=" . $value, "3");
//                $output->debug(__FUNCTION__, "[MAPPING] Map array: " . $output->array_output($mapping_array), "3");
//                $mapresult = array_search($value, $mapping_array);
//                if (isset($mapresult) and $mapresult) {
//                    $map_data[$key] = $mapresult;
//                    //$map_data[$key . "_original"] = $value;
//                } else {
//                    $output->debug(__FUNCTION__, "[MAPPING] Couldnt map data because there is no match", "1");
//                    $map_data[$key . "_original"] = $value;
//                    return "MAMS_ERROR";
//                } 
//            }
//        }
//        
//        $output->debug(__FUNCTION__, "[MAPPING] Map data: " . $output->array_output($map_data), "3");
//        return $map_data;
//    }
    
    
    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $stations_ID
     * @param type $station_protocols_ID
     * @return type
     */
    public function mams_remove_lock($stations_ID, $station_protocols_ID) {
        global $MaMS_SQL;
        global $output;

        $output->debug(__FUNCTION__, "Remove lock with stations_ID=" . $stations_ID . " and station_protocols_ID=" . $station_protocols_ID, "2");

        $sql = "DELETE FROM `queue_lock` WHERE `stations_ID` = " . $stations_ID . " AND `station_protocols_ID` = " . $station_protocols_ID;
        $RC = $MaMS_SQL->sql_commit($sql);
        $output->debug(__FUNCTION__, "RC=" . $RC, "3");
        return $RC;
    }

    
    /**
     * Add station lock to database
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $stations_ID
     * @param type $station_protocols_ID
     * @return type
     */
    public function mams_add_lock($stations_ID, $station_protocols_ID) {
        global $MaMS_SQL;
        global $output;

        $output->debug(__FUNCTION__, "Add new lock with stations_ID=" . $stations_ID . " and station_protocols_ID=" . $station_protocols_ID, "2");

        $sql = "INSERT INTO `queue_lock` (`stations_ID`, `station_protocols_ID`, `timestamp`) VALUES ('" . $stations_ID . "', '" . $station_protocols_ID . "', NOW())";
        $RC = $MaMS_SQL->sql_commit($sql);
        $output->debug(__FUNCTION__, "RC=" . $RC, "3");
        return $RC;
    }

    
    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $stations_ID
     * @param type $station_protocols_ID
     * @return type
     */
    public function mams_get_locks($stations_ID) {
        global $MaMS_SQL;
        global $MaMS_Data;
        global $output;

        $return = array();

        $output->debug(__FUNCTION__, "Searching for lock entrys to kill", "2");

        $locks = $MaMS_Data->get_queue_lock();
        foreach ($locks as $data) {
            if ($data['stations_ID'] == $stations_ID) {
                $output->debug(__FUNCTION__, "Found lock: " . $data['ID'] . " with stations_ID=" . $stations_ID . " and station_protocols_ID=" . $data['station_protocols_ID'], "2");
                $return[] = $data['ID'];
            }
        }
        return $return;
    }

    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $stations_ID
     * @param type $station_protocols_ID
     * @return type
     */
    public function mams_get_locks_count($stations_ID) {
        global $output;

        $output->debug(__FUNCTION__, "Check how many entrys are there in database...", "2");

        $locks = $this->mams_get_locks($stations_ID);
        $count = count($locks);

        $output->debug(__FUNCTION__, "Found " . $count . " locks in database", "2");
        return $count;
    }

    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $stations_ID
     * @param type $station_protocols_ID
     * @return int
     */
    public function mams_check_lock($stations_ID) {
        global $output;

        $output->debug(__FUNCTION__, "Check for Lock in database", "2");

        $locks = $this->mams_get_locks_count($stations_ID);

        if ($locks != "0") {
            $output->debug(__FUNCTION__, "Check for lock: At least one lock found!", "2");
            $RC =  1;
        } else {
            $output->debug(__FUNCTION__, "Check for lock: no lock found", "2");
            $RC = 0;
        }
        $output->debug(__FUNCTION__, "RC=" . $RC, "3");
        return $RC;
    }

    // LOCK KILL muss noch implementiert werden, aber wo ?
    // Job bauen der mams_remove_old_locks($max_run_time); ausführt!
    /**
     * 
     * @global type $output
     */
    public function mams_remove_old_locks() {
        global $output;
        global $default_configuration;
        global $MaMS_Data;

        // The jobs are killed after job_timeout. Here i give the job some time to remove the lock by soft kill. 
        // If it not work, this function comes in play.
        $buffer_for_job_end = 5;
        
        $max_run_time = ($default_configuration['daemon_settings']['job_timeout'] / 1000000) + $buffer_for_job_end;
 
        $lock_kill_time = time() - $max_run_time;

        $output->debug(__FUNCTION__, "Searching for lock entrys to kill older than " . $max_run_time . " sec. That is time: " . $lock_kill_time, "2", "YELLOW");

        $locks = $MaMS_Data->get_queue_lock();
        foreach ($locks as $data) {
            if ($data['timestamp_unix'] <= $lock_kill_time) {
                $output->debug(__FUNCTION__, "Found old lock in database: ID=" . $data['ID'] . " and timestamp=" . $data['timestamp_unix'] . " and stations_ID=" . $data['stations_ID'] . " and station_protocols_ID=" . $data['station_protocols_ID'], "3", "YELLOW");

                $RC = $this->mams_remove_lock($data['stations_ID'], $data['station_protocols_ID']);
                if ($RC != "0") {
                    $output->debug(__FUNCTION__, "REMOVE LOCK FAILED!");
                    die(1);
                }
            }
        }
        return 0;
    }
    
    
    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $ID
     * @param type $operator
     * @param type $time_diff
     * @return type
     */
    public function trigger_data_update($ID, $operator = "+", $time_diff = "0") {
        global $output;
        global $MaMS_SQL;
        
        $update_time = eval("return time() $operator $time_diff;");
        
        $output->debug(__FUNCTION__, "Set queue for update with ID=" . $ID . " to queue_lastrun_timestamp=" . $update_time . " (" . time() . $operator . $time_diff . ")", "3");
        $output->debug(__FUNCTION__, "Set to: " . date('d.m.Y H:i:s', $update_time), "3");
        
        $sql = "UPDATE `queue` SET `lastrun_timestamp` = FROM_UNIXTIME('". $update_time ."') WHERE `ID` = '" . $ID . "';";
        $RC = $MaMS_SQL->sql_commit($sql);
        $output->debug(__FUNCTION__, "RC=" . $RC, "3");
        return $RC;
    }
    
    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $ID
     * @return string
     */
    public function mv_queue_to_archive($ID) {
        global $output;
        global $MaMS_SQL;
        
        $output->debug(__FUNCTION__, "Copy queue with ID=" . $ID, "2");
        
        $sql_move = "INSERT INTO queue_archive 
                     SELECT * FROM queue WHERE `ID` = '" . $ID . "'";
        $RC_move = $MaMS_SQL->sql_commit($sql_move);
        $output->debug(__FUNCTION__, "RC_move=" . $RC_move, "3");
        
        if ($RC_move == "0") {
            $output->debug(__FUNCTION__, "Remove queue with ID=" . $ID, "2");
            $sql_remove = "DELETE FROM `queue` WHERE `ID` = " . $ID;
            $RC_remove = $MaMS_SQL->sql_commit($sql_remove);
            $output->debug(__FUNCTION__, "RC_remove=" . $RC_remove, "3");
        }
        
        if (isset($sql_remove)) {
            $RC = $RC_remove;
        } elseif (isset($RC_move)) {
            $RC = $RC_move;
        } else {
            $RC = "1";
        }
        
        return $RC;
    }
    
    /**
     * This function returns the ID for the queue job that match the params
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @global type $output
     * @param type $exclude_ID
     * @param type $station_protocols_ID
     * @return string
     */
    public function get_loaddata_queue_data($exclude_ID, $station_protocols_ID, $function = 'load_data') {
        global $output;
        global $MaMS_Data;
        
        $load_data_queue = $MaMS_Data->get_queue();
        
        $result = array();
        
        foreach ($load_data_queue as $job) {
            if ($job['station_protocols_ID'] == $station_protocols_ID) {
                if ($job['ID'] != $exclude_ID) {
                    if ($job['function'] == $function) {
                        $output->debug(__FUNCTION__, "MATCH: " . $job['ID'] . "", "3");
                        $result[] = $job;
                    }
                }
            }
        }
        
        $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($result), "4");
        
        $count = count($result);
        $output->debug(__FUNCTION__, "Found: " . $count . " matches", "3");
        if ($count != "1") {
            return "ERROR";
        } else {
            return $result['0'];
        }
    }

    /**
     * 
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @return type
     */
    public function load_all_data_jobs() {
        global $output;
        global $MaMS_Data;

        $load_data_station_protocols = $MaMS_Data->get_station_protocols();
        $load_data_stations = $MaMS_Data->get_stations();
        $load_data_queue = $MaMS_Data->get_queue();
        $load_data_queue_lock = $MaMS_Data->get_queue_lock(); // ONLY FOR VIEW

        $result = array();

        //$key = array_search('grün', $array);  // $key = 2;
        foreach ($load_data_queue as $QUEUE_JOB) {
            
            // DAS LOCK ERSTELLEN MUSS IN DIESE SCHLEIFE MIT REIN; DA DER NAESTE PROZESS ERST 
            // NACH ENDE DIESES GESTARTET WIRD WENN ALSO HIER DER LOCK GESETZT WIRD GEHT ES DANACH WEITER
            
            //echo $QUEUE_JOB['ID'];    
            //echo '<pre>';
            //print_r($load_data_objects);
            //echo '</pre>';           
            //echo "<br><br>";
            $result[$QUEUE_JOB['ID']]['queue'] = $load_data_queue[$QUEUE_JOB['ID']];


            //////////////////////////////////////
            //$key1 = array_search1($load_data_station_protocols, 'station_protocols_ID', $QUEUE_JOB['station_protocols_ID']);
            //if (count($key1) == "1") {
            //$key1 = array_shift($key1);
            if (isset($QUEUE_JOB['station_protocols_ID'])) {
                if (isset($load_data_station_protocols[$QUEUE_JOB['station_protocols_ID']]) and is_array($load_data_station_protocols[$QUEUE_JOB['station_protocols_ID']])) {
                    $result[$QUEUE_JOB['ID']]['station_protocols'] = $load_data_station_protocols[$QUEUE_JOB['station_protocols_ID']];
                } else {
                    $result[$QUEUE_JOB['ID']]['station_protocols']['station_protocols_ID'] = "NULL";
                    echo "ERROR ";
                    $output->debug(__FUNCTION__, "[ERROR] Queue with ID=" . $result[$QUEUE_JOB['ID']]['queue']['ID'] . " has configured station_protocols_ID=" . $PAGE_OBJECT['station_protocols_ID'] . " but that doesnt exists!", "1");
                }
            }

            if (isset($result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID'])) {
                if (isset($load_data_stations[$result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID']]) and is_array($load_data_stations[$result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID']])) {
                    $result[$QUEUE_JOB['ID']]['stations'] = $load_data_stations[$result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID']];
                } else {
                    $result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID'] = "NULL";
                    // Ein normaler Job kann auch ohne Station zu tun haben und ausgefuehrt werden
                    $output->debug(__FUNCTION__, "[INFO] Queue with ID=" . $result[$QUEUE_JOB['ID']]['queue']['ID'] . " has configured stations_ID=" . $PAGE_OBJECT['stations_ID'] . " but that doesnt exists!", "1");
                }    
            }

// ÜEBERFLUESSIG????
// 
// 
// 
// 
// queue im echtzeit speicher, datenbank weg machen
// nach 120s lock entfernen und prozess killen
// 
// 
// 
            // das hier in eine funktion packen ? 
            //Check if we have a lock in the database
            if (isset($result[$QUEUE_JOB['ID']]['stations']['ID'])) {
                if (isset($result[$QUEUE_JOB['ID']]['station_protocols']['ID'])) {
                    if (isset($result[$QUEUE_JOB['ID']]['stations']['configuration']['lock_station'])) {
                        if ($result[$QUEUE_JOB['ID']]['stations']['configuration']['lock_station'] == "1") {
                            // Add lock to dataset
                            $found_queue_lock = array();
                            $found_queue_lock = array_search1($load_data_queue_lock, 'stations_ID', $result[$QUEUE_JOB['ID']]['stations']['ID']);
                            //$found_queue_lock = array_search1($found_queue_lock, 'station_protocols_ID', $result[$QUEUE_JOB['ID']]['station_protocols']['ID']);
                            // ^^ removed weil ... ich will ja station locken und nicht nach protocols

                            //if (count($found_queue_lock) == "1") {
                            //$found_queue_lock = array_shift($found_queue_lock);
                            //}

                            $result[$QUEUE_JOB['ID']]['queue_lock'] = $found_queue_lock;

                            if (count($found_queue_lock) >= "1") {
                                $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "1";
                            } else {
                                $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "0";
                            }
                        } else {
                            $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "0";
                        }
                    } else {
                        $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "0";
                    }
                } else {
                    $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "0";
                }
                    
                } else {
                    $result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID'] = "NULL";
                    $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "0";
                }
//            } else {
//                $result[$QUEUE_JOB['ID']]['station_protocols']['stations_ID'] = "NULL";
//                $result[$QUEUE_JOB['ID']]['queue_lock_status'] = "0";
//            }

    //        } else {
    //            echo "ERROR";
    //            exit;
    //        }
    //
    //        echo "<pre>";
    //        print_r($found_queue_lock);
    //        echo "</pre>";
            //////////////////////////////////////

        };
        
        return($result);
    }
    
    
    /**
     * 
     * @global type $output
     * @global type $MaMS_Queue
     * @global type $absolut_pfad
     * @global type $default_configuration
     * @param type $jobdata
     */
    public function run_mams_job($checkpoint, $jobdata) {
        // Wenn der Prozess abgebrochen wird, soll aber noch der lock eintrag in der DB entfernt werden
        global $output;
        global $MaMS_Queue;
        
        global $absolut_pfad;
        global $default_configuration;

        // CHECK IF JOB (QUEUE) IS VALID
        if (!isset($jobdata['queue']['ID'])) {
            $output->debug(__FUNCTION__, "JOB DATA NOT VALID!", "1");
            exit(1);
        };
        if (!$jobdata['queue']['ID']) {
            $output->debug(__FUNCTION__, "JOB DATA NOT VALID!", "1");
            exit(1);
        };
        
//        // CHECK FOR LOCK
//        if (isset($jobdata['stations']['configuration']['lock_station'])) {
//            if ($jobdata['stations']['configuration']['lock_station'] == "1") {
//                $RC_check = $MaMS_Queue->mams_check_lock($jobdata['station_protocols']['stations_ID']);
//                if ($RC_check != "0") {
//                    $output->debug(__FUNCTION__, "LOCK FOUND!", "1");
//                    exit(1);
//                }
//            }
//        }
        
//        // ADD LOCK
//        if (isset($jobdata['stations']['configuration']['lock_station'])) {
//            if ($jobdata['stations']['configuration']['lock_station'] == "1") {
//                $RC_add = $MaMS_Queue->mams_add_lock($jobdata['station_protocols']['stations_ID'], $jobdata['queue']['station_protocols_ID']);
//                //$RC_add = "0";
//                if ($RC_add != "0") {
//                    $output->debug(__FUNCTION__, "ADD LOCK FAILED", "1");
//                    exit(1);
//                }
//            }
//        }
            
        // DEBUG OUTPUT
        $output->debug(__FUNCTION__, "Doing something fun in pid " . getmypid(), "3", "CYAN");
        $output->debug(__FUNCTION__, "stations_ID=" . $jobdata['station_protocols']['stations_ID'], "3", "CYAN");
        $output->debug(__FUNCTION__, "station_protocols=" . $jobdata['station_protocols']['info'], "3", "CYAN");

        // RUN JOB
        $output->debug(__FUNCTION__, "Load class=" . $jobdata['station_protocols']['class'] . " with function=" . $jobdata['queue']['function'], "3", "CYAN");
        
        // Check if class exists
        if (!file_exists($absolut_pfad . "/classes/protocols/" . $jobdata['station_protocols']['class'])) {
            $output->debug(__FUNCTION__, "ERROR: station_protocols_class is missing!", "1");
            exit(1);
        }
        
        // Load Class and run job
        include($absolut_pfad . "/classes/protocols/" . $jobdata['station_protocols']['class']);
        $ClassProtocol = NEW JobClass();
        $RC_job = $ClassProtocol->$jobdata['queue']['function']($jobdata);
        $output->debug(__FUNCTION__, "[" . $jobdata['queue']['function'] . "] RC=" . $RC_job, "3");
        
        // 18150 = Ethersex_BMP085.php

        // dem php script parameter beibringen?
        // über parameter kann man dann einzelne jobs testen?
        
        // RUN UPDATE QUEUE
        if ($RC_job == "0") {
            //$MaMS_Queue->trigger_data_update($jobdata['queue']['ID'], "-", "60");
            //$output->debug(__FUNCTION__, "Set to:" . date('d.m.Y H:i:s', $update_time), "3");
            $MaMS_Queue->trigger_data_update($jobdata['queue']['ID']);
            
            // MOVE QUEUE TO ARCHIVE
            if (isset($jobdata['queue']['configuration']['archive_job'])) {
                if ($jobdata['queue']['configuration']['archive_job'] == "1") {
                    $RC_archive = $MaMS_Queue->mv_queue_to_archive($jobdata['queue']['ID']);
                    if ($RC_archive != "0") {
                        $output->debug(__FUNCTION__, "QUEUE ARCHIVE FAILED", "1");
                        exit(1);
                    }
                }
            }

            // TRIGGER UPDATE FOR NORMAL QUEUE JOB
            if (isset($jobdata['queue']['configuration']['trigger_data_update'])) {
                if ($jobdata['queue']['configuration']['trigger_data_update'] == "1") {
                    // GET ID FOR -DATA FETCH- QUEUE JOB
                    //$job_ID = $MaMS_Queue->get_loaddata_queue_id($jobdata['queue']['ID'], $jobdata['station_protocols']['ID']);
                    $load_data_job_data = $MaMS_Queue->get_loaddata_queue_data($jobdata['queue']['ID'], $jobdata['station_protocols']['ID']);
                    
                    if ($load_data_job_data == "ERROR") {
                        $output->debug(__FUNCTION__, "TRIGGER FAILED 1", "1");
                        exit(1);
                    }

                    $RC_trigger = $MaMS_Queue->trigger_data_update($load_data_job_data['ID'], "-", $load_data_job_data['intervall_time']);
                    if ($RC_trigger != "0") {
                        $output->debug(__FUNCTION__, "TRIGGER FAILED 2", "1");
                        exit(1);
                    }
                }
            }
        } else {
            // RETRIGGER ON FAIL
            if (isset($jobdata['queue']['configuration']['retrigger_on_fail'])) {
                if ($jobdata['queue']['configuration']['retrigger_on_fail'] == "1") {
                    $retrigger_time_diff = $jobdata['queue']['intervall_time'] * $default_configuration['daemon_settings']['fail_multiplikator'];
                    $MaMS_Queue->trigger_data_update($jobdata['queue']['ID'], "+", $retrigger_time_diff);
                } elseif ($jobdata['queue']['configuration']['retrigger_on_fail'] == "2") {
                    $retrigger_time_diff = "0";
                    $MaMS_Queue->trigger_data_update($jobdata['queue']['ID'], "+", $retrigger_time_diff);
                }
            }
        }
        
        
        // REMOVE LOCK
        if (isset($jobdata['stations']['configuration']['lock_station'])) {
            if ($jobdata['stations']['configuration']['lock_station'] == "1") {
                $RC_remove = $MaMS_Queue->mams_remove_lock($jobdata['station_protocols']['stations_ID'], $jobdata['queue']['station_protocols_ID']);
                if ($RC_remove != "0") {
                    $output->debug(__FUNCTION__, "REMOVE LOCK FAILED", "1");
                    exit(1);
                }
            }
        }
        
        // CALCULATE RUNTIME
        $output->debug(__FUNCTION__, "Job complete after " . ( microtime( true) - $checkpoint) . " seconds", "2", "CYAN");
        
        // Some sleep for very fast proccesses
        sleep(1);
        
        // Exit Job correctly
        exit(0);
    }
}