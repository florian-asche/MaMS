<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
//include ("../header.php");                                                      // Header Laden
include ("../../configuration.php");                                            // Konfiguration Laden
include ("../../system.php");                                               // Funktionen Laden
include ("../../configuration_sensortypen.php");                                // Funktionen Laden
include ("menu.php");                                                           // Menü Laden                                   

echo '<table border="0" width="100%">';
echo '<tr><td colspan="2">';
echo "<FONT SIZE=+2>Daemon Job Test<br></font><br>";   
echo '</td></tr>';
echo '<tr><td valign="top">';
echo "Willkommen beim Test ihres Daemon Jobs...<br>";
echo "<br>";

if (isset($_GET['queueid'])) {
    $get_queueid = $_GET["queueid"];
    if (preg_match('~^[0-9_]~', $get_queueid) != "1") {
        echo "SQL Injection Attack detected!";
        exit;
    };
};
$objektid = load_objekte($linki);
mams_daemon_lockkill($link, '1');
mams_daemon_run($link,$absolut_pfad,$sysconfig,$objektid,$sensortype,"1",$get_queueid);
mams_daemon_lockkill($link, '1');

echo '</td></tr></table><br>';
include ("../../erw/ausgabe/copyright.php");
?>

<?php
} else {
    $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
    $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
    $extra = "index.php";
    header("Location: http://$host$uri/$extra");
};
?>