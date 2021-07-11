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

//include ("classes/connectors/tcp_connector.php");

include ("classes/global/SystemOutput.php");
//include ("classes/global/MaMS_Queue.php");

$output = NEW SystemOutput();
$MaMS_SQL = NEW MaMS_SQL();
$MaMS_Data = NEW MaMS_Data();

// Smarty Laden
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty;

if (isset($_POST["pageid"])) { 
    $pageid = $_POST["pageid"]; 
} elseif (isset($_GET["pageid"])) { 
    $pageid = $_GET["pageid"]; 
} else {
    $pageid = "1";
};

// Default Variablen setzen
$smarty->assign('pageid',$pageid);
$smarty->assign('x_before','x');

// Template Auswahl
$selected_template = $default_configuration['default_settings']['design'];
$smarty->assign('selected_template',$selected_template);

// Menu Laden
$pages = $MaMS_Data->get_pages();
$smarty->assign('pages',$pages);

// Objekte Laden
$page_objects = $MaMS_Data->create_combined_page_objects_data();
//echo '<pre>';
//print_r($page_objects);
//echo '</pre>';  
//exit;
$smarty->assign('page_objects',$page_objects);

// Ladezeit berechnen
$time_end = getmicrotime();
$ladezeit = round($time_end - $time_start,3);
$smarty->assign('ladezeit',$ladezeit);

$smarty->display('templates/' . $selected_template . '/dashboard.tpl');
?>