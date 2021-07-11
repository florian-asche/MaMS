#!/usr/bin/env php

<?php
include ("system_config.php");

include ("system.php");
include ("classes/global/MaMS_SQL.php");
include ("classes/global/MaMS_Data.php");
include ("classes/global/MaMS.php");

include ("classes/connectors/tcp_connector.php");

include ("classes/global/SystemOutput.php");
include ("classes/global/MaMS_Queue.php");
include ("classes/global/JobDaemon.php");

$output = NEW SystemOutput();
$MaMS_SQL = NEW MaMS_SQL();
$MaMS_Data = NEW MaMS_Data();
$MaMS_Queue = NEW MaMS_Queue();
$JobDaemon = NEW JobDaemon();
$JobDaemon->run();
?>