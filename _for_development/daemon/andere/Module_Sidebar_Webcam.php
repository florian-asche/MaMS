<?php

$station_protokoll_objektid_generieren = "0";                                   // Hier wird festgelegt, ob eine Manuelle objektid generiert werden muss.

function funktion_other_php_job($IP,$PORT,$SENDCOMMAND,$RECEIVEFILTER,$RECIEVECOMMAND,$MAMS_objektid,$objektid,$sensortype,$absolut_pfad,$link,$sysconfig,$defaultoutput,$PARAMETER1,$PARAMETER2,$PARAMETER3) {
    $webcambildpfad = $absolut_pfad . "/module/sidebar/2-webcam/";                  // Pfad zum Module, hier wird auch das Bild abgelegt
    $webcambildfilename = "webcam.jpg";                                             // Name des Bildes

    if ($sysconfig['module_sidebar_webcam']['aktiv']['wert'] == "1") {     
        if (FALSE === @fopen($sysconfig['module_sidebar_webcam']['downloadpfad']['wert'], 'r')) {
            echo "Error: Die Verbindung zur Webcam-Bild DownloadSource konnte nicht aufgebaut werden."; 
        } else { 
            $fp = fopen($webcambildpfad . $webcambildfilename, "w+");
            $result["webcam"] = file_get_contents($sysconfig['module_sidebar_webcam']['downloadpfad']['wert'], False);
            fwrite($fp, $result["webcam"]);
            fclose($fp);
            chown($webcambildpfad . $webcambildfilename, $sysconfig['global']['apache_user']['wert']);
            chgrp($webcambildpfad . $webcambildfilename, $sysconfig['global']['apache_group']['wert']);
            echo "Download of <b>" .  $sysconfig['module_sidebar_webcam']['downloadpfad']['wert'] . " </b>complete.";
        };
    };
}
?>