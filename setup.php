<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

// System Laden
include ("system_config.php");

include ("system.php");
include ("classes/global/MaMS_SQL.php");
include ("classes/global/MaMS_Data.php");
include ("classes/global/MaMS.php");

include ("classes/global/MaMS_Users.php");
include ("classes/global/MaMS_Control.php");
include ("classes/global/Session.php");

//include ("classes/connectors/tcp_connector.php");

include ("classes/global/SystemOutput.php");
//include ("classes/global/MaMS_Queue.php");

$output = NEW SystemOutput();
$MaMS_SQL = NEW MaMS_SQL();
$MaMS_Data = NEW MaMS_Data();

$MaMS_Users = NEW MaMS_Users();
$MaMS_Control = NEW MaMS_Control();

// Smarty Laden
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty;

// Template Auswahl
$selected_template = $default_configuration['default_settings']['design'];
$smarty->assign('selected_template',$selected_template);

// Menu Array
$menu = array();
$menu[] = "Welcome";
//$menu[] = "System";
//$menu[] = "Users";
//$menu[] = "Pages";
$menu[] = "Objects";
//$menu[] = "Daemon Jobs";
$menu[] = "Logout";
$smarty->assign('menu',$menu);

// Get page select
$page = get_submit_data("page", "loginstart");
$smarty->assign('page',$page);





//Setup - Installation
//Wenn die Configuration.php nicht da ist und keine page angegeben ist, wird das template geladen.
//Setup - Login - View
//Setup - Login - Function
//Setup - Logout - Function

//Objects
//-New Page
//--Page 1
//--New Object
//--Object 1
//---Activate,Deactivate,Edit,Delete
//--Page 2
//[...]

//Setup - DaemonJobs
//- Index
//- Edit
//- Neu

// HTTPS USE
// Use HTTP Strict Transport Security to force client to use secure connections only
//$use_sts = true;
// iis sets HTTPS to 'off' for non-SSL requests
//if ($use_sts && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
//    header('Strict-Transport-Security: max-age=31536000');
//} elseif ($use_sts) {
//    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], true, 301);
//    // we are in cleartext at the moment, prevent further execution and output
//    die();
//}

// Je Nach Type wird ein Tempalte für ein Objekt oder ein Job geladen?
// Die Settings werden in ein JSON Array in die DB geschrieben?
$httphost = htmlspecialchars($_SERVER["HTTP_HOST"]);
$uri  = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");

if ($page == "login") {
    $username = get_post_data("username", "unknown");
    $password = get_post_data("password", "unknown");

    $output->debug(__FUNCTION__, "username=" . $username, "4");
    $output->debug(__FUNCTION__, "password=" . $password, "4");

    // save userdata in global variable
    // count data, if count is one then login is successfull

    $password_hash = $MaMS_Users->create_hash($password);
    $output->debug(__FUNCTION__, "password_hash=" . $password_hash, "4");
    
    $userdata = $MaMS_Users->get_users($username, $password_hash);
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($userdata), "4");

    if (count($userdata) == 1) {
        $output->debug(__FUNCTION__, "LOGIN OK", "3");
        $session = new SecureSessionHandler($default_configuration['default_settings']['session_timeout'], 'MAMS_SESSION');
        session_set_save_handler($session, true);

        $_SESSION['username'] = $username;
        $_SESSION['password_hash'] = $password_hash;
        $_SESSION['login'] = true;

        if (!$session->isValid()) {
            echo "Session is not valid<br>";
            session_destroy();
            
            $httphost  = htmlspecialchars($_SERVER["HTTP_HOST"]);
            $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
            $extra = "setup.php";
            header("Location: http://$httphost$uri/$extra");
        }

//        echo "SESSION_ID=" . session_id();
//        echo "<br>";
//        echo $_SESSION['username'];
//        echo $_SESSION['password_hash'];
//        echo $_SESSION['login'];
        
        $extra = "setup.php?page=Welcome";
    } else {
        $extra = "setup.php?page=loginfailed";
    };

    header("Location: http://$httphost$uri/$extra");
} elseif ($page == "loginfailed") {
    // Ladezeit berechnen
    $time_end = getmicrotime();
    $ladezeit = round($time_end - $time_start,3);
    $smarty->assign('ladezeit',$ladezeit);

    $smarty->display('templates/setup/login.tpl');
} elseif ($page == "loginstart") {
    $smarty->display('templates/setup/login.tpl');
} elseif ($page == "Welcome") {
    $userdata = $MaMS_Users->session_login_check();
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($userdata), "4");
    
    $smarty->assign('username',$userdata["username"]);
//        $count_data_in_db
//        $count_sensors
//        $count_actors
//        $count_stations

    // Objekte Laden
    //$page_objects = load_page_objects($linki);
    //echo '<pre>';
    //print_r($page_objects);
    //echo '</pre>';
    //exit;
    //$smarty->assign('page_objects',$page_objects);

    $smarty->display('templates/setup/Welcome.tpl');
} elseif ($page == "Objects") {
    // Check Login
    $userdata = $MaMS_Users->session_login_check();
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($userdata), "4");
    
    // Get action
    $action = get_submit_data("action", "Welcome");
    $smarty->assign('action',$action);
    
    // load page data
    $pages = $MaMS_Data->get_pages();
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($pages), "4");
    
    // load object data
    $page_objects = $MaMS_Data->create_combined_page_objects_data();
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($page_objects), "4");
    
    // run selected action
    if ($action == "object_activate") {
        // get data from submit
        $selected_id = get_submit_data("selected_id", "");
        
        // run action
        $MaMS_Control->object_activate($selected_id);
        
        // renew object data
        $page_objects = $MaMS_Data->create_combined_page_objects_data();
        $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($page_objects), "4");

        // Daten übergeben
        $smarty->assign('page_objects',$page_objects);
        $smarty->assign('pages',$pages);

        // Display page from smarty template
        $smarty->display('templates/setup/Objects.tpl');
    } elseif ($action == "object_deactivate") {
        // get data from submit
        $selected_id = get_submit_data("selected_id", "");
        
        // run action
        $MaMS_Control->object_deactivate($selected_id);
        
        // renew object data
        $page_objects = $MaMS_Data->create_combined_page_objects_data();
        $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($page_objects), "4");

        // Daten übergeben
        $smarty->assign('page_objects',$page_objects);
        $smarty->assign('pages',$pages);

        // Display page from smarty template
        $smarty->display('templates/setup/Objects.tpl');
    } elseif ($action == "object_deactivate") {
//    } elseif ($action == "object_deactivate") {
//    } elseif ($action == "object_deactivate") {
    } else {
        // renew object data
        $page_objects = $MaMS_Data->create_combined_page_objects_data();
        $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($page_objects), "4");

        // Daten übergeben
        $smarty->assign('page_objects',$page_objects);
        $smarty->assign('pages',$pages);

        // Display page from smarty template
        $smarty->display('templates/setup/Objects.tpl');
    }
    

    
    
    
    
    // Go for correct action
//    } elseif ($action == "page_object_delete") {
//        echo $set_id;
//        //make_sql_change("DELETE FROM `page_objects` WHERE `ID` = '$set_id'", $linki);
//        // Pruefen ob es das letzte object ist, dann aus objects löschen

//    } elseif ($action == "page_delete") {
//        echo $set_id;
//        //make_sql_change("DELETE FROM `pages` WHERE `ID` = '$set_id'", $linki);
//        // hier fehlt noch das löschen der page objekte die auf die Page matchen
//    } elseif ($action == "page_object_edit_submit") {
////            echo '<pre>';
////            print_r($_POST);
////            echo '</pre>';
//
//        // Get POST+GET Submitted Data
//        $object_name = get_post_data("object_name", "");
//        $page_objects_active = get_post_data("page_objects_active", "");
//        $x = get_post_data("x", "");
//        $y = get_post_data("y", "");
//        $template = get_post_data("template", "");
//        $controlpanel = get_post_data("controlpanel", "");
//        $station_protocol_ID = get_post_data("station_protocol_ID", "ERROR");
//        $objects_ID = get_post_data("objects_ID", "ERROR");
//        $page_objects_ID = get_post_data("page_objects_ID", "ERROR");
//        $pageid = get_post_data("pageid", "ERROR");
//
//        $objectsql = "
//            UPDATE `objects` 
//            SET 
//            `name` = '$object_name',
//            `template` = '$template',
//            `controlpanel` = '$controlpanel',
//            `station_protocols_ID` = '$station_protocol_ID'
//            WHERE `ID` = '$objects_ID'
//        ";
//
//        $page_objectsql = "
//            UPDATE `page_objects` 
//            SET 
//            `pageid` = '$pageid',
//            `active` = '$page_objects_active',
//            `x` = '$x',
//            `y` = '$y'
//             WHERE `ID` = '$page_objects_ID'
//        ";
//
//        make_sql_change($objectsql, $linki);
//        make_sql_change($page_objectsql, $linki);     
//    } elseif ($action == "page_object_add_new_submit") {
////            echo '<pre>';
////            print_r($_POST);
////            echo '</pre>';
//            
//        // Get POST+GET Submitted Data
//        $object_name = get_post_data("object_name", "");
//        $page_objects_active = get_post_data("page_objects_active", "");
//        $x = get_post_data("x", "");
//        $y = get_post_data("y", "");
//        $template = get_post_data("template", "");
//        $controlpanel = get_post_data("controlpanel", "");
//        $station_protocol_ID = get_post_data("station_protocol_ID", "ERROR");
//        $pageid = get_post_data("pageid", "ERROR");
//        $objectid = get_post_data("objectid", "ERROR");
//        $objectid_manually = get_post_data("objectid_manually", "ERROR");
//
//        if ($objectid == "manually input") {
//            $objectid = $objectid_manually;
//        };
//
//        $object_add_new = "
//            INSERT INTO `objects` (
//                `name` ,
//                `active` ,
//                `objectid` ,
//                `template` ,
//                `controlpanel` ,
//                `station_protocols_ID` ,
//                `config`
//            ) VALUES ('$object_name', '1', '$objectid', '$template', '$controlpanel', '$station_protocol_ID' , NULL)
//        ";
//        make_sql_change($object_add_new, $linki);          
//
//        $page_object_add_new = "
//      INSERT INTO `page_objects` (
//                `pageid` ,
//                `objectid` ,
//                `active` ,
//                `y` ,
//                `x`
//            ) VALUES ('$pageid', '$objectid', '$page_objects_active', '$y', '$x')
//        ";
//        make_sql_change($page_object_add_new, $linki); 
//    } elseif ($action == "page_object_add_diffpage_submit") {
////            echo '<pre>';
////            print_r($_POST);
////            echo '</pre>';
//            
//        // Get POST+GET Submitted Data
//        $page_objects_active = get_post_data("page_objects_active", "");
//        $x = get_post_data("x", "");
//        $y = get_post_data("y", "");
//        $pageid = get_post_data("pageid", "ERROR");
//        $objectid = get_post_data("objectid", "ERROR");               
//
//        $page_object_add_new = "
//      INSERT INTO `page_objects` (
//                `pageid` ,
//                `objectid` ,
//                `active` ,
//                `y` ,
//                `x`
//            ) VALUES ('$pageid', '$objectid', '$page_objects_active', '$y', '$x')
//        ";
//        make_sql_change($page_object_add_new, $linki);
//    } elseif ($action == "page_edit_submit") {
////            echo '<pre>';
////            print_r($_POST);
////            echo '</pre>';
//            
//        $page_name = get_post_data("page_name", "");
//        $page_active = get_post_data("page_active", "");
//        $ID = get_post_data("ID", "");
//
//        $page_sql = "
//            UPDATE `pages` 
//            SET 
//            `name` = '$page_name',
//            `active` = '$page_active'
//             WHERE `ID` = '$ID'
//        ";
//        make_sql_change($page_sql, $linki);
//    } elseif ($action == "page_add_submit") {
////            echo '<pre>';
////            print_r($_POST);
////            echo '</pre>';
//            
//        $page_name = get_post_data("page_name", "");
//        $page_active = get_post_data("page_active", "");
//
//        $page_sql = "
//            INSERT INTO `pages` 
//            (`ID`, `name`, `active`) 
//            VALUES 
//            (NULL, '$page_name', '$page_active')
//        ";
//        make_sql_change($page_sql, $linki);
//    };
} elseif ($page == "Logout") {
    $userdata = $MaMS_Users->session_login_check();
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($userdata), "4");
    
    session_destroy();

    $httphost  = htmlspecialchars($_SERVER["HTTP_HOST"]);
    $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
    $extra = "setup.php";
    header("Location: http://$httphost$uri/$extra");
} else {
    $userdata = $MaMS_Users->session_login_check();
    $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($userdata), "4");
    
    session_destroy();

    $httphost  = htmlspecialchars($_SERVER["HTTP_HOST"]);
    $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
    $extra = "setup.php";
    header("Location: http://$httphost$uri/$extra");
};
?>
