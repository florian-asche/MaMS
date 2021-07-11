<?php
session_start();
if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
?>

<?php
include ("header.php");                                                         // Header Laden
include ("../configuration.php");                                               // Konfiguration Laden
include ("../system.php");                                                  // Funktionen Laden
include ("menu.php");                                                           // Menü Laden                                   

echo '<table border="0">';
echo '<tr><td colspan="2" valign="top">';
echo "<FONT SIZE=+2>Hauptseite<br></font>";   
echo '</td></tr>';
echo '<tr><td valign="top">';

echo '<table border="' . $system_debug . '" class="mini" bgcolor="#FFBF00" width="600" height="200">';
echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
echo "Willkommen " . $_SESSION['name'] . "!";
echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
echo "<hr>";  
echo "Hallo<b> </b>und Herzlich willkommen im Setup Bereich von MaMS.<br><br>";
echo 'Sie befinden sich auf der Startseite...<br> Bitte wählen Sie im oberen Menü, welche Aufgabe durchgeführt werden soll.';
echo '</font></p></td></tr>';
echo '</table>';
echo "<br>";

echo '<table border="' . $system_debug . '" class="mini" bgcolor="#FFBF00" width="600" height="200">';
echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
echo "News:";
echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
echo "<hr>";  

// Get News
$mams_news_fp = curl_init("http://mams.florian-asche.de/mamsinfo/news.txt");
curl_setopt($mams_news_fp, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($mams_news_fp, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($mams_news_fp, CURLOPT_CONNECTTIMEOUT, '5');
curl_setopt($mams_news_fp, CURLOPT_TIMEOUT, 5);
curl_setopt($mams_news_fp, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
$mams_news = curl_exec($mams_news_fp);
curl_close($mams_news_fp);
$mams_news_decoded = urldecode($mams_news);

if (!$mams_news_decoded) { $mams_news_decoded = "Error Connection to News Server..."; };
echo $mams_news_decoded;


echo '</font></p></td></tr>';
echo '</table>';
echo "<br>";


echo '</td><td>';

echo '<table border="' . $system_debug . '" class="mini" bgcolor="#FFBF00" width="600" height="200">';
echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
echo "Systemstatus:";
echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
echo "<hr>";
$dbeintraege = mysql_num_rows(mysql_query("select id from daten"));
$anzahlstationen = mysql_num_rows(mysql_query("select id from stationen_protokoll"));
$anzahlsensoren = mysql_num_rows(mysql_query("select id from objekte WHERE `objekt_type` = '0'"));
$anzahlaktoren = mysql_num_rows(mysql_query("select id from objekte WHERE `objekt_type` = '1'"));

echo "Anzahl Datensätze in der Datenbank: <b>" .  $dbeintraege . "</b> von 99.999.999.999.999 möglichen Datensätzen.<br>";
echo "Anzahl Stationen: <b>" .  $anzahlstationen . "</b><br>";
echo "Anzahl Sensoren: <b>" .  $anzahlsensoren . "</b><br>";
echo "Anzahl Aktoren: <b>" .  $anzahlaktoren . "</b><br>";
echo "<br>... comming soon";
// Welche davon sind aktiv, welche sind inaktiv etc.
echo '</font></p></td></tr>';
echo '</table>';
echo "<br>";

echo '<table border="' . $system_debug . '" class="mini" bgcolor="#FFBF00" width="600" height="200">';
echo '<td height="25" bgcolor="#FFBF00"><font size="4">';
echo "Updatestatus:";
echo '<tr><td rowspan="2" bgcolor="#FFBF00" valign="top"><p align="left"><font size="2">';
echo "<hr>";


$mams_version_now_fp = fopen("version.txt","r");
if ($mams_version_now_fp) {
	while(!feof($mams_version_now_fp)) {
		$mams_version_now = fgets($mams_version_now_fp);
	}
	fclose($mams_version_now_fp);
};
if (!$mams_version_now) { $mams_version_now = "ERROR"; };

// Get Version
$mams_version_new_fp = curl_init("http://mams.florian-asche.de/mamsinfo/version.txt");
curl_setopt($mams_version_new_fp, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($mams_version_new_fp, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($mams_version_new_fp, CURLOPT_CONNECTTIMEOUT, '5');
curl_setopt($mams_version_new_fp, CURLOPT_TIMEOUT, 5);
curl_setopt($mams_version_new_fp, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
$mams_version = curl_exec($mams_version_new_fp);
curl_close($mams_version_new_fp);
$mams_version_decoded = urldecode($mams_version);

if ($mams_version_decoded) {
    //echo $mams_version_decoded;
    preg_match("/\d+/",$mams_version_decoded,$mams_version_new_match);
    $mams_version_new = $mams_version_new_match[0];
} else {
    $mams_version_new = "ERROR";
}

echo "Sie verwenden die Version <b>" . $mams_version_now . "</b>.<br><br>";
echo "Aktuell Verfügbar ist die Version <b>" . $mams_version_new . "</b>.<br><br><br>";

if ($mams_version_now == "ERROR" OR $mams_version_new == "ERROR") {
	echo "Es konnte nicht auf Updates geprüft werden.<br>Möglicherweise steht der Update Server aktuell nicht zur Verfügung. Sollten Sie wiederholt Probleme haben, kontaktieren Sie uns bitte.!";
} else {
	if ($mams_version_now < $mams_version_new) {
		echo "Ihre Version ist ";
		echo '<img src="lib/images/veraltet.png" alt="VERALTET">';
		echo '<br><br><a href="http://mams.florian-asche.de/?Update" target="_blank">MaMS Update durchführen!</a>';
	} elseif ($mams_version_now = $mams_version_new) {
		echo "Ihre Version ist ";
		echo '<img src="lib/images/aktuell.png" alt="AKTUELL">';
	};
};

echo '</font></p></td></tr>';
echo '</table>';
echo "<br>";

echo "</td></tr></table>";
include ("../erw/ausgabe/copyright.php");
?>

<?php
} else {
  $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
  $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
  $extra = "index.php";
  header("Location: http://$host$uri/$extra");
};
?>