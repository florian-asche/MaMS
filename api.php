<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

include ("system_config.php");

include ("system.php");
include ("classes/global/MaMS.php");

//include ("classes/connectors/tcp_connector.php");

include ("classes/global/SystemOutput.php");
//include ("classes/global/MaMS_Queue.php");
include ("classes/global/MaMS_SQL.php");
include ("classes/global/MaMS_Data.php");

$output = NEW SystemOutput();
$MaMS_SQL = NEW MaMS_SQL();
$MaMS_Data = NEW MaMS_Data();

$selected_template = $default_configuration['default_settings']['design'];

$action = get_submit_data("action", "NULL");
$output->debug(__FUNCTION__, "[DATA] action=" . $action, "4");

if ($action == "add_queue_job") {
    // Debug
    $output->debug(__FUNCTION__, "[DATA] POST DATA ARRAY" . $output->array_output($_POST), "4");
    
    //Get data fom post or get submit
    $FormName = get_submit_data("FormName", "NULL");
    if ($FormName == "NULL") {
        $output->debug(__FUNCTION__, "[ERROR] FormName is missing!", "1");
        exit(1);
    };
    
    $page_objects_ID = get_submit_data("page_objects_ID", "NULL");
    if ($page_objects_ID == "NULL") {
        $output->debug(__FUNCTION__, "[ERROR] page_objects_ID is missing!", "1");
        exit(1);
    };    
    
    $json_data = get_submit_data("json_data", "NULL");
    if ($json_data == "NULL") {
        $output->debug(__FUNCTION__, "[ERROR] json_data is missing!", "1");
        exit(1);
    };    
    
    $json_data_encoded = json_decode($_POST["json_data"], true);
    $output->debug(__FUNCTION__, "[DATA] JSON DATA FROM POST IN ARRAY" . $output->array_output($json_data_encoded), "4");
    
    if (!isset($json_data_encoded) or !$json_data_encoded) {
        $output->debug(__FUNCTION__, "[ERROR] json_data_encoded is missing!", "1");
        exit(1);
    }
    
    $station_protocols_ID = $json_data_encoded['station_protocols_ID'];
    if (!isset($station_protocols_ID) or !$station_protocols_ID) {
        $output->debug(__FUNCTION__, "[ERROR] station_protocols_ID is missing!", "1");
        exit(1);
    }

    $priority = $json_data_encoded['priority'];
    if (!isset($priority) or !$priority) {
        $output->debug(__FUNCTION__, "[ERROR] priority is missing!", "1");
        exit(1);
    }

    $function = $json_data_encoded['function'];
    if (!isset($function) or !$function) {
        $output->debug(__FUNCTION__, "[ERROR] function is missing!", "1");
        exit(1);
    }

    // Get Protocol Default configuration for queue job
    $load_data_station_protocols = $MaMS_Data->get_station_protocols();
    if (!is_array($load_data_station_protocols[$station_protocols_ID])) {
        $output->debug(__FUNCTION__, "[ERROR] station_protocol is missing!", "1");
        exit(1);
    }
        
    $station_protocols_class = $load_data_station_protocols[$station_protocols_ID]['class'];
    $output->debug(__FUNCTION__, "[DATA] class=" . $station_protocols_class, "4");
    $station_protocols_class_configuration = get_protocol_class_configuration($station_protocols_class);
    $output->debug(__FUNCTION__, "[DATA] station_protocol_class_job_configuration: " . $output->array_output($station_protocols_class_configuration), "4");
    
    if (!is_array($station_protocols_class_configuration)) {
        $output->debug(__FUNCTION__, "[ERROR] job_configuration is missing!", "1");
        exit(1);
    }
    
    // Change some data
    $config = $json_data_encoded;
    $config['trigger_data_update'] = $station_protocols_class_configuration['send_queue']['trigger_data_update'];
    $config['archive_job'] = $station_protocols_class_configuration['send_queue']['archive_job'];
    unset($config['station_protocols_ID']);
    unset($config['priority']);
    unset($config['function']);

    $output->debug(__FUNCTION__, "[DATA] ARRAY DATA FOR DB" . $output->array_output($config), "4");

    // Make json from data
    $config_json = json_encode($config);
    $intervall_time = "1";

    $sql_set_queue = "INSERT INTO `queue` ("
            . "`station_protocols_ID`,"
            . " `priority`,"
            . " `intervall_time`,"
            . " `function`,"
            . " `config`,"
            . " `lastrun_timestamp`"
            . ") VALUES ("
            . "'$station_protocols_ID', "
            . "'$priority', "
            . "'$intervall_time', "
            . "'$function', "
            . "'$config_json', "
            . "NOW())";
    
    $output->debug(__FUNCTION__, "[SQL] " . $sql_set_queue, "4");

    $RC = $MaMS_SQL->sql_commit($sql_set_queue);
    if ($RC == "0") {
        echo "OK";
    }
    exit($RC);
} elseif ($action == "get_objekthtml") {
    //Get data fom post or get submit
    $page_objects_ID = get_submit_data("page_objects_ID", "NULL");
    
    if ($page_objects_ID == "NULL") {
        echo "ERROR: page_objects_ID missing!";
        exit(1);
    };
    
    //Smarty Laden
    require('lib/Smarty-3.1.18/libs/SmartyBC.class.php');
    $smarty = new SmartyBC();

    // Template Auswahl
    $smarty->assign('selected_template',$selected_template);
    
    // Daten holen
    $page_objects = $MaMS_Data->create_combined_page_objects_data();
    $get_objectid = $page_objects[$page_objects_ID]['page_objects']['objectid'];
    $object_template = $page_objects[$page_objects_ID]['objects']['template'];
    
    $objektdata = $MaMS_Data->get_data_latest_one($get_objectid, $object_template);
    
//    echo "<pre>";
//    print_r($objektdata);
//    echo "</pre>";
    
    // Daten an Smarty übergeben
    $smarty->assign('selected_template',$selected_template);
    $smarty->assign('objekt',$page_objects[$page_objects_ID]);
    $smarty->assign('default_configuration',$default_configuration);
    
    if (isset($objektdata['timestamp'])) {
        $timstampdiff = timstampdiff($objektdata['timestamp'], $now_timestamp);
        $objektdata['timestampdiff'] = $timstampdiff;
        $objektdata['timestampdifftext'] = sec_to_time($timstampdiff);
        $smarty->assign('objektdata',$objektdata);
    };
    
    // Smarty darstellen
    $smarty->display('templates/' . $selected_template . '/dashboard_object.tpl');
} elseif ($action == "get_mouseover") {
    if (isset($_POST["pageobjectid"])) { 
        $get_pageobjectid = $_POST["pageobjectid"]; 
    } elseif (isset($_GET["pageobjectid"])) { 
        $get_pageobjectid = $_GET["pageobjectid"]; 
    } else {
        echo "ERROR: pageobjectid missing!";
        exit;
    };
    
    //Smarty Laden
    require('lib/Smarty-3.1.18/libs/Smarty.class.php');
    $smarty = new Smarty;
    
    // Daten holen
    $page_objects = $MaMS_Data->create_combined_page_objects_data();
    $get_objectid = $page_objects[$get_pageobjectid]['page_objects']['objectid'];
    $object_template = $page_objects[$get_pageobjectid]['objects']['template'];
    
    $tabledata = $MaMS_Data->get_data_latest_by_limit('10', $get_objectid, $object_template);
    
//    echo "<pre>";
//    print_r($tabledata);
//    echo "</pre>";
    
    $evgdata = $MaMS_Data->get_evg($get_objectid);
    $minmaxdata = $MaMS_Data->get_minmax($get_objectid);
    
    $timestamp_from = $now_timestamp - (60 * 60 * 24); // 1 Tag
    $timestamp_to = $now_timestamp;
    $table_data_graph = $MaMS_Data->get_data_by_time($timestamp_from, $timestamp_to, $get_objectid, $object_template);
    //$table_data_graph = get_data_latest_by_limit('10', $get_objectid, $linki);
    $graphdata = reorga_data1($page_objects, $table_data_graph, $get_pageobjectid);
    
    // Daten an Smarty übergeben
    $smarty->assign('selected_template',$selected_template);
    $smarty->assign('objekt',$page_objects[$get_pageobjectid]);
    $smarty->assign('default_configuration',$default_configuration);
   
//    echo "<pre>";
//    
//    include ("classes/global/SystemOutput.php");
//    include ("classes/global/MaMS_Queue.php");
//    include ("classes/global/JobDaemon.php");
//    $output = NEW SystemOutput();
//    $JobDaemon = NEW JobDaemon();
//    print_r($JobDaemon->load_data_jobs());
    
    
    //print_r($page_objects[$get_pageobjectid]);
    //print_r($table_data_graph);
   // echo "</pre>";
    
    
    $smarty->assign('tabledata',$tabledata);
    $smarty->assign('evgdata',$evgdata);
    $smarty->assign('minmaxdata',$minmaxdata);
    
    $smarty->assign('graphdata',$graphdata);
      
    // Smarty darstellen
    $smarty->display('templates/' . $selected_template . '/mouseover.tpl');
} elseif ($action == "graph_bar") {
    Header("Content-type: image/png");
    $width = $_GET['width'];
    $height = $_GET['height'];
    if ($width == 0) {
        $width = 70;
    }
    if ($height == 0) {
        $height = 15;
    }
    $rating = $_GET['rating'];
    $ratingbar = (($rating/100)*$width)-2;
    $image = imagecreate($width,$height);
    $fill = ImageColorAllocate($image,0,0,255);
    //$fill = ImageColorAllocate($image,0,255,0); 
    //if ($rating > 49) { $fill = ImageColorAllocate($image,255,255,0); } 
    //if ($rating > 74) { $fill = ImageColorAllocate($image,255,128,0); } 
    //if ($rating > 89) { $fill = ImageColorAllocate($image,255,0,0); } 
    $back = ImageColorAllocate($image,205,205,205);
    $border = ImageColorAllocate($image,0,0,0);
    ImageFilledRectangle($image,0,0,$width-1,$height-1,$back);
    ImageFilledRectangle($image,1,1,$ratingbar,$height-1,$fill);
    ImageRectangle($image,0,0,$width-1,$height-1,$border);
    imagePNG($image);
    imagedestroy($image);    
} else {
    echo "ERROR: unknown action";
};
?>
