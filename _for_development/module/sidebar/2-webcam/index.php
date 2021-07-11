<?php
//echo $sysconfig['module_sidebar_webcam']['aktiv']['wert'];                    // Soll das Module Aktiv sein?
//echo $sysconfig['module_sidebar_webcam']['farbe']['wert'];                    // Welche Farbe soll der Hintergrund haben?
//echo $sysconfig['module_sidebar_webcam']['downloadpfad']['wert'];             // Woher soll das Bild geladen werden?
//echo $sysconfig['module_sidebar_webcam']['reload_method']['wert'];            // Welche Reload Methode soll verwendet werden? (0 = Java Reload) (1 = Meta Reload)
//echo $sysconfig['module_sidebar_webcam']['reloadtime']['wert'];               // In welchem Intervall soll das Bild neu geladen werden? (Angabe in Sekunden)
$webcambildpfad = "module/sidebar/2-webcam/";                                   // Pfad zum Module, hier wird auch das Bild abgelegt
$webcambildfilename = "webcam.jpg";                                             // Name des Bildes

if ($sysconfig['module_sidebar_webcam']['aktiv']['wert'] == "1") {                                               // Prüfen, ob das Module Aktiviert ist
    echo '<table border="0" class="mini" bgcolor="' . $sysconfig['module_sidebar_webcam']['farbe']['wert'] . '" width="300" height="255">';
    echo '<td height="22" bgcolor="' . $sysconfig['module_sidebar_webcam']['farbe']['wert'] . '"><font size="4">';
    echo "Webcam:";
    echo '</font><tr><td rowspan="2" bgcolor="' . $sysconfig['module_sidebar_webcam']['farbe']['wert'] . '" valign="top">';
    echo '<div align="center"><a href="' . $webcambildpfad . $webcambildfilename . '">';    

    if (file_exists($webcambildpfad . $webcambildfilename)) {                   // Pruefen ob Bild vorhanden ist...
        if ($javareload == "0") {
            // 15000 ms = 15 Sekunden
            $javareloadtime = $sysconfig['module_sidebar_webcam']['reloadtime']['wert'] * 1000;
            //echo $javareloadtime;
            echo '<SCRIPT LANGUAGE="JavaScript">
                  var BaseURL = "' . $webcambildpfad . '";
                  var File = "' . $webcambildfilename . '?";
                  var theTimer = setTimeout("reloadImage()",1);
                  function reloadImage() {
                        theDate = new Date();
                        var url = BaseURL;
                        url += File;
                        url += "&dummy=";
                        url += theDate.getTime().toString(10);
                        document.theImage.src = url;
                        theTimer = setTimeout("reloadImage()",' . $javareloadtime . ');   
                  }
                  </SCRIPT>';  
            echo '<img name="theImage" src="" width="290" height="220" align="center" alt="Bild nicht gefunden!">'; // Bild aus der Zwischenablage Laden';
        } else {
           echo '<head><meta http-equiv="refresh" content="' . $sysconfig['module_sidebar_webcam']['reloadtime']['wert'] . '"></head>';
           echo '<img src="' . $webcambildpfad . $webcambildfilename . '" width="290" height="220" align="center" alt="Bild nicht gefunden!">'; // Bild aus der Zwischenablage Laden
        };     
    } else {
        echo "Es konnte kein Bild gefunden werden!";
    };
    echo '</a></div>';
    echo '</td></tr>';
    echo '</table>';
    echo "<br>";
};
?>                                                  