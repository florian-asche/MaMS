<?php
################################################################################
#                          Mess and Management System                          #
#              Copyright (c) by Florian Asche - www.pc-freaks.net              #
################################################################################

//Startblock--------------------------------------------------------------------
include ("configuration.php");                                                // Konfiguration Laden
include ("configuration_sensortypen.php");                                    // Sensordarstellungen für die Index Seite Laden
include ("funktionen.php");                                                   // Funktionen Laden (MYSQL CONNECT)
//include ("configuration_sensoren.php");                                       // Sensoren Zuordnung Laden
$dateaktu = date("d.m.Y");                                                      // Hier müssen sie nichts Setzen
$timeaktu = date("H:i:s");                                                      // Hier müssen sie nichts Setzen
$timestampaktu = time();                                                        // Hier müssen sie nichts Setzen
$datew = $dateaktu;                                                             // Variable Setzten für Grafik und Grafiklinks

if ($sysconfig['global']['logsystem']['wert'] == "1") {                                                        // Prüfen ob das Logsystem in der Konfiguration eingeschaltet ist.
  $pfad = (__FILE__);                                                           // Aufgerufene Datei bestimmen
  include ("erw/makelog.php");                                                  // Logsystem Laden
};

$objektidauswahl = $_GET["objektid"];

//Sensorausgabe-----------------------------------------------------------------
if ($objektid[$objektidauswahl]['aktiv'] == "1") {                             // Prüfen, ob der Sensor ausgegeben werden soll. (Variable ist in der Sensoren Konfiguarion gespeichert, welche aus dem Setup Generiert wird.)
  $system = $objektid[$objektidauswahl]['system'];                            // System aus der Sensorenkonfiguration laden
  $maximal_objektid = $objektidauswahl;                                       // objektid aus der Sensorenkonfiguration holen
  //Timestamp berechnen-------------------------------------------------------
  $vontime = "00:00:00";
  //$vondatum = "28.10.2010";
  $vondatum = $_GET["vontime"];
  //if (!$vondatum) {
  $vondatum = $dateaktu;
  //}
  list ($von_day, $von_mon, $von_year) = explode('.', $vondatum); // Datum beim Punkt aufteilen und in Variable Speichern    
  $timestampvon = strtotime($von_year . '-' . $von_mon . '-' . $von_day . ' ' . $vontime);
  $timestampbis = timestampcalc($timestampaktu,$sysconfig);                    // Zeitzone umrechnen
  //echo $timestampbis . "<br>";
  //echo $timestampvon . "-" . $timestampbis;
  //echo date("d.m.Y",$timestampvon) . '<br>';                                
  //echo date("H:i:s",$timestampvon) . '<br>';
  //$test = "0";
  //echo sensorcheck($timestampvon,$timestampbis,$system,$maximal_objektid);
  if (sensorcheck($timestampvon,$timestampbis,$system,$maximal_objektid) == $dateaktu) {                                     
  echo '<table border="' . $system_debug . '" class="mini" bgcolor="' . $ausgabe_farbe . '">';// Tabelle je Sensor
  echo '<tr><td height="130">';
  //Start Tabelle für Sensor--------------------------------------------------
  letzten3($timestampvon,$timestampbis,$system,$maximal_objektid,$sysconfig);                              // Funktion für die letzten 3 Messungen (Gespeichert in funktionen.php)
  
  echo "<br>";
  funktion_evg($maximal_objektid,$system);
  
  //Grafik ausgeben-----------------------------------------------------------    
  echo '</td><td rowspan="4" width="161" bgcolor="white">';
  if ($sysconfig['global']['jpgraph_function']['wert'] == "1") {
  echo '<img src="erw/ausgabe/grafik/index_neu.php?timestampvon=' . $timestampvon . '&timestampbis=' . $timestampbis . '&objektid=' . $maximal_objektid . '" align="center" alt="Grafikdarstellung"></a>';
  } else {
  echo '<img src="erw/ausgabe/grafik/index.php?timestampvon=' . $timestampvon . '&timestampbis=' . $timestampbis . '&objektid=' . $maximal_objektid . '" align="center" alt="Grafikdarstellung"></a>';
  };
  echo '</td></tr><tr><td height="auto">';           
  //echo 'Min., Max., Durschschnitt wird zur zeit Überarbeitet...';
  //require "erw/ausgabe/maximal-ausgabe/$system/avgminmax.php";                // Minimal, Maximal, Durchschnitt ausgeben
  //if ($system == "lufu1") { lufu1($dateaktu,$system,$maximal_objektid); }   // Weitere Daten ermitteln (Relative Luftfeuchtigkeit...)
  echo '</td></tr></table><br>';
  } else {
      echo "Es konnten keine aktuellen Daten gefunden werden!";
  };
};
?>                                                                           