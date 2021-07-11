<html>
<link rel="stylesheet" type="text/css" href="/mams/common.css">
<tbody>
<div class="header" align="center">
<a class="menuname">Measurement and Management System - Setup Bereich</a>
</div>

<div class="navigation">
<div class="navigation2">
<?php

echo '<a href="logout.php" class="menu2">Raus aus dem Setup</a>';
echo " |-| ";
echo '<a href="willkommen.php?' . session_name() . '=' . session_id() . '" class="menu2">Hauptseite</a> | ';
echo '<a href="konfiguration.php?' . session_name() . '=' . session_id() . '" class="menu2">Systemeinstellungen</a> | ';
echo '<a href="stationen/index.php?' . session_name() . '=' . session_id() . '" class="menu2">Daemon Jobs Konfigurieren</a> | ';
echo '<a href="sensoren/index.php?' . session_name() . '=' . session_id() . '" class="menu2">Objekte Zuordnen</a> | ';
echo '<a href="module/index.php?' . session_name() . '=' . session_id() . '" class="menu2">Sidebar Module</a> | ';
echo '<a href="pages/index.php?' . session_name() . '=' . session_id() . '" class="menu2">Pages</a>';
//echo '<a href="error.php" class="menu2">ErrorLog *BETA*</a>';
//echo '<a href="log.php" class="menu2">Logs *BETA*</a>';


?>
</div></div>
<div class="content">