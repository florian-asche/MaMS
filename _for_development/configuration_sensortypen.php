<?php
################################################################################
#                        Measurement and Management System                     #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################
$sensortype = array();
################################################################################

//Temperatur
$sensortype['temp1']['name']          = 'temp1';
$sensortype['temp1']['beschreibung']  = 'Thermosensor';                                  
$sensortype['temp1']['wert1']         = 'Temperatur';
$sensortype['temp1']['wert1_einheit'] = '°C';
$sensortype['temp1']['wert1_grafik']  = '1';
$sensortype['temp1']['wert2']         = '';
$sensortype['temp1']['wert2_einheit'] = '';
$sensortype['temp1']['wert2_grafik']  = '0';
$sensortype['temp1']['wert3']         = '';
$sensortype['temp1']['wert3_einheit'] = '';
$sensortype['temp1']['wert3_grafik']  = '0';
$sensortype['temp1']['wert4']         = '';
$sensortype['temp1']['wert4_einheit'] = '';
$sensortype['temp1']['wert4_grafik']  = '0';
$sensortype['temp1']['wert5']         = '';
$sensortype['temp1']['wert5_einheit'] = '';
$sensortype['temp1']['wert5_grafik']  = '0';
$sensortype['temp1']['wert6']         = '';
$sensortype['temp1']['wert6_einheit'] = '';
$sensortype['temp1']['wert6_grafik']  = '0';
$sensortype['temp1']['wert7']         = '';
$sensortype['temp1']['wert7_einheit'] = '';
$sensortype['temp1']['wert7_grafik']  = '0';
$sensortype['temp1']['wert8']         = '';                                             
$sensortype['temp1']['wert8_einheit'] = '';
$sensortype['temp1']['wert8_grafik']  = '0';
$sensortype['temp1']['wert9']         = '';
$sensortype['temp1']['wert9_einheit'] = '';
$sensortype['temp1']['wert9_grafik']  = '0';
$sensortype['temp1']['farbe']         = '#FFFF00';
$sensortype['temp1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " °C ";';

//Temperatur
$sensortype['hr20']['name']          = 'hr20';
$sensortype['hr20']['beschreibung']  = 'HR20 Thermostat';                                  
$sensortype['hr20']['wert1']         = 'Temperatur';
$sensortype['hr20']['wert1_einheit'] = '°C';
$sensortype['hr20']['wert1_grafik']  = '1';
$sensortype['hr20']['wert2']         = 'SOLL-Temperatur';
$sensortype['hr20']['wert2_einheit'] = '°C';
$sensortype['hr20']['wert2_grafik']  = '1';
$sensortype['hr20']['wert3']         = 'Modus';
$sensortype['hr20']['wert3_einheit'] = '';
$sensortype['hr20']['wert3_grafik']  = '0';
$sensortype['hr20']['wert4']         = 'Ventilposition';
$sensortype['hr20']['wert4_einheit'] = '';
$sensortype['hr20']['wert4_grafik']  = '1';
$sensortype['hr20']['wert5']         = 'Batteriespannung';
$sensortype['hr20']['wert5_einheit'] = 'Volt';
$sensortype['hr20']['wert5_grafik']  = '0';
$sensortype['hr20']['wert6']         = '';
$sensortype['hr20']['wert6_einheit'] = '';
$sensortype['hr20']['wert6_grafik']  = '0';
$sensortype['hr20']['wert7']         = '';
$sensortype['hr20']['wert7_einheit'] = '';
$sensortype['hr20']['wert7_grafik']  = '0';
$sensortype['hr20']['wert8']         = '';                                             
$sensortype['hr20']['wert8_einheit'] = '';
$sensortype['hr20']['wert8_grafik']  = '0';
$sensortype['hr20']['wert9']         = '';
$sensortype['hr20']['wert9_einheit'] = '';
$sensortype['hr20']['wert9_grafik']  = '0';
$sensortype['hr20']['farbe']         = '#FFFF00';
$sensortype['hr20']['index_ausgabe'] = 'echo "Ist: " . $rowausgabe[wert1] . " °C <br>";
                                        echo "Soll: " . $rowausgabe[wert2] . " °C ";';

//PWM
$sensortype['pwm1']['name']          = 'pwm1';
$sensortype['pwm1']['beschreibung']  = 'PWM Sensor';                                 
$sensortype['pwm1']['wert1']         = 'Eingestelle Drehpower';
$sensortype['pwm1']['wert1_einheit'] = '%';
$sensortype['pwm1']['wert1_grafik'] = '1';
$sensortype['pwm1']['wert2']         = 'Wert im MC';
$sensortype['pwm1']['wert2_einheit'] = '';
$sensortype['pwm1']['wert2_grafik'] = '0';
$sensortype['pwm1']['wert3']         = '';
$sensortype['pwm1']['wert3_einheit'] = '';
$sensortype['pwm1']['wert3_grafik'] = '0';
$sensortype['pwm1']['wert4']         = '';
$sensortype['pwm1']['wert4_einheit'] = '';
$sensortype['pwm1']['wert4_grafik'] = '0';
$sensortype['pwm1']['wert5']         = '';
$sensortype['pwm1']['wert5_einheit'] = '';
$sensortype['pwm1']['wert5_grafik'] = '0';
$sensortype['pwm1']['wert6']         = '';
$sensortype['pwm1']['wert6_einheit'] = '';
$sensortype['pwm1']['wert6_grafik'] = '0';
$sensortype['pwm1']['wert7']         = '';
$sensortype['pwm1']['wert7_einheit'] = '';
$sensortype['pwm1']['wert7_grafik'] = '0';
$sensortype['pwm1']['wert8']         = '';                                             
$sensortype['pwm1']['wert8_einheit'] = '';
$sensortype['pwm1']['wert8_grafik'] = '0';
$sensortype['pwm1']['wert9']         = '';
$sensortype['pwm1']['wert9_einheit'] = '';
$sensortype['pwm1']['wert9_grafik'] = '0';
$sensortype['pwm1']['farbe']         = '#FF5500';
//$sensortype['pwm1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " % ";';
$sensortype['pwm1']['index_ausgabe'] = 'echo "<img src=\"erw/ausgabe/bar.php?rating=" . $rowausgabe[wert1] . "&height=18&width=110\" alt=\"Bar(ERROR)\"></a>";
                                        echo " " . $rowausgabe[wert1] . " % ";
                                        ';

										//PWM
$sensortype['pwm1ethersex']['name']          = 'pwm1ethersex';
$sensortype['pwm1ethersex']['beschreibung']  = 'PWM Sensor Ethersex';                                 
$sensortype['pwm1ethersex']['wert1']         = 'Eingestelle Drehpower';
$sensortype['pwm1ethersex']['wert1_einheit'] = '%';
$sensortype['pwm1ethersex']['wert1_grafik'] = '1';
$sensortype['pwm1ethersex']['wert2']         = 'Wert im MC';
$sensortype['pwm1ethersex']['wert2_einheit'] = '';
$sensortype['pwm1ethersex']['wert2_grafik'] = '0';
$sensortype['pwm1ethersex']['wert3']         = '';
$sensortype['pwm1ethersex']['wert3_einheit'] = '';
$sensortype['pwm1ethersex']['wert3_grafik'] = '0';
$sensortype['pwm1ethersex']['wert4']         = '';
$sensortype['pwm1ethersex']['wert4_einheit'] = '';
$sensortype['pwm1ethersex']['wert4_grafik'] = '0';
$sensortype['pwm1ethersex']['wert5']         = '';
$sensortype['pwm1ethersex']['wert5_einheit'] = '';
$sensortype['pwm1ethersex']['wert5_grafik'] = '0';
$sensortype['pwm1ethersex']['wert6']         = '';
$sensortype['pwm1ethersex']['wert6_einheit'] = '';
$sensortype['pwm1ethersex']['wert6_grafik'] = '0';
$sensortype['pwm1ethersex']['wert7']         = '';
$sensortype['pwm1ethersex']['wert7_einheit'] = '';
$sensortype['pwm1ethersex']['wert7_grafik'] = '0';
$sensortype['pwm1ethersex']['wert8']         = '';                                             
$sensortype['pwm1ethersex']['wert8_einheit'] = '';
$sensortype['pwm1ethersex']['wert8_grafik'] = '0';
$sensortype['pwm1ethersex']['wert9']         = '';
$sensortype['pwm1ethersex']['wert9_einheit'] = '';
$sensortype['pwm1ethersex']['wert9_grafik'] = '0';
$sensortype['pwm1ethersex']['farbe']         = '#FF5500';
//$sensortype['pwm1ethersex']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " % ";';
$sensortype['pwm1ethersex']['index_ausgabe'] = 'echo "<img src=\"erw/ausgabe/bar.php?rating=" . $rowausgabe[wert1] . "&height=18&width=110\" alt=\"Bar(ERROR)\"></a>";
                                        echo " " . $rowausgabe[wert1] . " % ";
                                        ';
										
										
//PORTSTATUS
$sensortype['portstatus1']['name']          = 'portstatus1';
$sensortype['portstatus1']['beschreibung']  = 'Portstatus';                                
$sensortype['portstatus1']['wert1']         = 'Portstatus';
$sensortype['portstatus1']['wert1_einheit'] = '';
$sensortype['portstatus1']['wert1_grafik'] = '1';
$sensortype['portstatus1']['wert2']         = 'Wert im MC';
$sensortype['portstatus1']['wert2_einheit'] = '';
$sensortype['portstatus1']['wert2_grafik'] = '0';
$sensortype['portstatus1']['wert3']         = 'Last_State';
$sensortype['portstatus1']['wert3_einheit'] = '';
$sensortype['portstatus1']['wert3_grafik'] = '0';
//$sensortype['portstatus1']['wert4']         = 'Last_State A';
$sensortype['portstatus1']['wert4_einheit'] = '';
$sensortype['portstatus1']['wert4_grafik'] = '0';
//$sensortype['portstatus1']['wert5']         = 'Last_State A ADC';
$sensortype['portstatus1']['wert5_einheit'] = '';
$sensortype['portstatus1']['wert5_grafik'] = '0';
//$sensortype['portstatus1']['wert6']         = 'Last_State B';
$sensortype['portstatus1']['wert6_einheit'] = '';
$sensortype['portstatus1']['wert6_grafik'] = '0';
//$sensortype['portstatus1']['wert7']         = 'Last_State B ADC';
$sensortype['portstatus1']['wert7_einheit'] = '';
$sensortype['portstatus1']['wert7_grafik'] = '0';
$sensortype['portstatus1']['wert8']         = '';                                             
$sensortype['portstatus1']['wert8_einheit'] = '';
$sensortype['portstatus1']['wert8_grafik'] = '0';
$sensortype['portstatus1']['wert9']         = '';
$sensortype['portstatus1']['wert9_einheit'] = '';
$sensortype['portstatus1']['wert9_grafik'] = '0';
$sensortype['portstatus1']['farbe']         = '#FF5550';
$sensortype['portstatus1']['index_ausgabe'] = 'if($rowausgabe[wert1] == "0") { 
                                               echo "geschlossen"; 
                                               } 
                                               elseif ($rowausgabe[wert1] == "1") { 
                                               echo "geoeffnet"; 
                                               } 
                                               else {
                                               echo "ERROR!";
                                               }
                                               echo " (" . $rowausgabe[wert2] . ")<br>";
                                               
                                               if($rowausgabe[wert3] == "0") { 
                                               echo "war geschlossen"; 
                                               } 
                                               elseif ($rowausgabe[wert3] == "1") { 
                                               echo "war geoeffnet"; 
                                               } 
                                               else {
                                               echo "ERROR!";
                                               };';

//Luftfeuchtigkeit
$sensortype['lufu1']['name']          = 'lufu1';
$sensortype['lufu1']['beschreibung']  = 'Luftfeuchtigkeit';
$sensortype['lufu1']['wert1']         = 'Temperatur';
$sensortype['lufu1']['wert1_einheit'] = '°C';
$sensortype['lufu1']['wert1_grafik'] = '1';
$sensortype['lufu1']['wert2']         = 'Luftfeuchtigkeit';
$sensortype['lufu1']['wert2_einheit'] = '%';
$sensortype['lufu1']['wert2_grafik'] = '1';
$sensortype['lufu1']['wert3']         = '';
$sensortype['lufu1']['wert3_einheit'] = '';
$sensortype['lufu1']['wert3_grafik'] = '0';
$sensortype['lufu1']['wert4']         = '';
$sensortype['lufu1']['wert4_einheit'] = '';
$sensortype['lufu1']['wert4_grafik'] = '0';
$sensortype['lufu1']['wert5']         = '';
$sensortype['lufu1']['wert5_einheit'] = '';
$sensortype['lufu1']['wert5_grafik'] = '0';
$sensortype['lufu1']['wert6']         = '';
$sensortype['lufu1']['wert6_einheit'] = '';
$sensortype['lufu1']['wert6_grafik'] = '0';
$sensortype['lufu1']['wert7']         = '';
$sensortype['lufu1']['wert7_einheit'] = '';
$sensortype['lufu1']['wert7_grafik'] = '0';
$sensortype['lufu1']['wert8']         = '';                                             
$sensortype['lufu1']['wert8_einheit'] = '';
$sensortype['lufu1']['wert8_grafik'] = '0';
$sensortype['lufu1']['wert9']         = '';
$sensortype['lufu1']['wert9_einheit'] = '';
$sensortype['lufu1']['wert9_grafik'] = '0';
$sensortype['lufu1']['farbe']         = '#FF6600';
//$sensortype['lufu1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " % ";';
$sensortype['lufu1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " °C & " . $rowausgabe[wert2] . "%";';

// Stromzähler (Impulse)
$sensortype['stromsensor']['name']          = 'stromsensor';
$sensortype['stromsensor']['beschreibung']  = 'Stromzähler';
$sensortype['stromsensor']['wert1']         = 'Kilowatt';
$sensortype['stromsensor']['wert1_einheit'] = 'kW/M';
$sensortype['stromsensor']['wert1_grafik'] = '1';
$sensortype['stromsensor']['wert2']         = 'Impulse';
$sensortype['stromsensor']['wert2_einheit'] = 'Imp.';
$sensortype['stromsensor']['wert2_grafik'] = '0';
$sensortype['stromsensor']['wert3']         = '';
$sensortype['stromsensor']['wert3_einheit'] = '';
$sensortype['stromsensor']['wert3_grafik'] = '0';
$sensortype['stromsensor']['wert4']         = '';
$sensortype['stromsensor']['wert4_einheit'] = '';
$sensortype['stromsensor']['wert4_grafik'] = '0';
$sensortype['stromsensor']['wert5']         = '';
$sensortype['stromsensor']['wert5_einheit'] = '';
$sensortype['stromsensor']['wert5_grafik'] = '0';
$sensortype['stromsensor']['wert6']         = '';
$sensortype['stromsensor']['wert6_einheit'] = '';
$sensortype['stromsensor']['wert6_grafik'] = '0';
$sensortype['stromsensor']['wert7']         = '';
$sensortype['stromsensor']['wert7_einheit'] = '';
$sensortype['stromsensor']['wert7_grafik'] = '0';
$sensortype['stromsensor']['wert8']         = '';                                             
$sensortype['stromsensor']['wert8_einheit'] = '';
$sensortype['stromsensor']['wert8_grafik'] = '0';
$sensortype['stromsensor']['wert9']         = '';
$sensortype['stromsensor']['wert9_einheit'] = '';
$sensortype['stromsensor']['wert9_grafik'] = '0';
$sensortype['stromsensor']['farbe']         = '#006600';
$sensortype['stromsensor']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " kW (" . $rowausgabe[wert2] . " Imp.)";
                                          $zwischenwert = $rowausgabe[wert2] * 60;
                                          echo "<br>HG: " . $zwischenwert . "kW/H";';

// Gaszähler (Impulse)
$sensortype['gas1']['name']          = 'gas1';
$sensortype['gas1']['beschreibung']  = 'Gaszähler';
$sensortype['gas1']['wert1']         = 'Qubikmeter';
$sensortype['gas1']['wert1_einheit'] = 'qm';
$sensortype['gas1']['wert1_grafik'] = '1';
$sensortype['gas1']['wert2']         = 'Impulse';
$sensortype['gas1']['wert2_einheit'] = 'Imp.';
$sensortype['gas1']['wert2_grafik'] = '0';
$sensortype['gas1']['wert3']         = '';
$sensortype['gas1']['wert3_einheit'] = '';
$sensortype['gas1']['wert3_grafik'] = '0';
$sensortype['gas1']['wert4']         = '';
$sensortype['gas1']['wert4_einheit'] = '';
$sensortype['gas1']['wert4_grafik'] = '0';
$sensortype['gas1']['wert5']         = '';
$sensortype['gas1']['wert5_einheit'] = '';
$sensortype['gas1']['wert5_grafik'] = '0';
$sensortype['gas1']['wert6']         = '';
$sensortype['gas1']['wert6_einheit'] = '';
$sensortype['gas1']['wert6_grafik'] = '0';
$sensortype['gas1']['wert7']         = '';
$sensortype['gas1']['wert7_einheit'] = '';
$sensortype['gas1']['wert7_grafik'] = '0';
$sensortype['gas1']['wert8']         = '';                                             
$sensortype['gas1']['wert8_einheit'] = '';
$sensortype['gas1']['wert8_grafik'] = '0';
$sensortype['gas1']['wert9']         = '';
$sensortype['gas1']['wert9_einheit'] = '';
$sensortype['gas1']['wert9_grafik'] = '0';
$sensortype['gas1']['farbe']         = 'braun';
$sensortype['gas1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " qm & " . $rowausgabe[wert2] . "Imp.";';

// Wasserzähler (Impulse)
$sensortype['wasser1']['name']          = 'wasser1';
$sensortype['wasser1']['beschreibung']  = 'Wasserzähler';
$sensortype['wasser1']['wert1']         = 'Qubikmeter';
$sensortype['wasser1']['wert1_einheit'] = 'qm';
$sensortype['wasser1']['wert2']         = 'Impulse';
$sensortype['wasser1']['wert2_einheit'] = 'Imp.';
$sensortype['wasser1']['wert3']         = '';
$sensortype['wasser1']['wert3_einheit'] = '';
$sensortype['wasser1']['wert4']         = '';
$sensortype['wasser1']['wert4_einheit'] = '';
$sensortype['wasser1']['wert5']         = '';
$sensortype['wasser1']['wert5_einheit'] = '';
$sensortype['wasser1']['wert6']         = '';
$sensortype['wasser1']['wert6_einheit'] = '';
$sensortype['wasser1']['wert7']         = '';
$sensortype['wasser1']['wert7_einheit'] = '';
$sensortype['wasser1']['wert8']         = '';                                             
$sensortype['wasser1']['wert8_einheit'] = '';
$sensortype['wasser1']['wert9']         = '';
$sensortype['wasser1']['wert9_einheit'] = '';
$sensortype['wasser1']['farbe']         = 'blau';
$sensortype['wasser1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " qm & " . $rowausgabe[wert2] . "Imp.";';

// Lichtsensor
$sensortype['licht1']['name']          = 'licht1';
$sensortype['licht1']['beschreibung']  = 'Lichtsensor';
$sensortype['licht1']['wert1']         = 'Lux';
$sensortype['licht1']['wert1_einheit'] = 'lx';
$sensortype['licht1']['wert1_grafik'] = '1';
$sensortype['licht1']['wert2']         = '';
$sensortype['licht1']['wert2_einheit'] = '';
$sensortype['licht1']['wert2_grafik'] = '0';
$sensortype['licht1']['wert3']         = '';
$sensortype['licht1']['wert3_einheit'] = '';
$sensortype['licht1']['wert3_grafik'] = '0';
$sensortype['licht1']['wert4']         = '';
$sensortype['licht1']['wert4_einheit'] = '';
$sensortype['licht1']['wert4_grafik'] = '0';
$sensortype['licht1']['wert5']         = '';
$sensortype['licht1']['wert5_einheit'] = '';
$sensortype['licht1']['wert5_grafik'] = '0';
$sensortype['licht1']['wert6']         = '';
$sensortype['licht1']['wert6_einheit'] = '';
$sensortype['licht1']['wert6_grafik'] = '0';
$sensortype['licht1']['wert7']         = '';
$sensortype['licht1']['wert7_einheit'] = '';
$sensortype['licht1']['wert7_grafik'] = '0';
$sensortype['licht1']['wert8']         = '';                                             
$sensortype['licht1']['wert8_einheit'] = '';
$sensortype['licht1']['wert8_grafik'] = '0';
$sensortype['licht1']['wert9']         = '';
$sensortype['licht1']['wert9_einheit'] = '';
$sensortype['licht1']['wert9_grafik'] = '0';
$sensortype['licht1']['farbe']         = '#33CCFF';
$sensortype['licht1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " lx ";';

// Luftdrucksensor
$sensortype['druck1']['name']          = 'druck1';
$sensortype['druck1']['beschreibung']  = 'Luftdrucksensor';
//$sensortype['druck1']['wert1']         = 'Hektopascal';
//$sensortype['druck1']['wert1_einheit'] = 'hPa';
$sensortype['druck1']['wert1']         = 'Temperatur';
$sensortype['druck1']['wert1_einheit'] = '°C';
$sensortype['druck1']['wert1_grafik'] = '1';
$sensortype['druck1']['wert2']         = 'Hektopascal';
$sensortype['druck1']['wert2_einheit'] = 'hPa';
$sensortype['druck1']['wert2_grafik'] = '1';
$sensortype['druck1']['wert3']         = '';
$sensortype['druck1']['wert3_einheit'] = '';
$sensortype['druck1']['wert3_grafik'] = '0';
$sensortype['druck1']['wert4']         = '';
$sensortype['druck1']['wert4_einheit'] = '';
$sensortype['druck1']['wert4_grafik'] = '0';
$sensortype['druck1']['wert5']         = '';
$sensortype['druck1']['wert5_einheit'] = '';
$sensortype['druck1']['wert5_grafik'] = '0';
$sensortype['druck1']['wert6']         = '';
$sensortype['druck1']['wert6_einheit'] = '';
$sensortype['druck1']['wert6_grafik'] = '0';
$sensortype['druck1']['wert7']         = '';
$sensortype['druck1']['wert7_einheit'] = '';
$sensortype['druck1']['wert7_grafik'] = '0';
$sensortype['druck1']['wert8']         = '';                                             
$sensortype['druck1']['wert8_einheit'] = '';
$sensortype['druck1']['wert8_grafik'] = '0';
$sensortype['druck1']['wert9']         = '';
$sensortype['druck1']['wert9_einheit'] = '';
$sensortype['druck1']['wert9_grafik'] = '0';
$sensortype['druck1']['farbe']         = '#33CCFF';
//$sensortype['druck1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " hPa ";';
$sensortype['druck1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " °C & " . $rowausgabe[wert2] . "Pa";';

//STROM
$sensortype['strom1']['name']          = 'strom1';
$sensortype['strom1']['beschreibung']  = 'Strom Sensor';                                
$sensortype['strom1']['wert1']         = 'Ampere';
$sensortype['strom1']['wert1_einheit'] = 'A';
$sensortype['strom1']['wert1_grafik'] = '1';
$sensortype['strom1']['wert2']         = '';
$sensortype['strom1']['wert2_einheit'] = '';
$sensortype['strom1']['wert2_grafik'] = '0';
$sensortype['strom1']['wert3']         = '';
$sensortype['strom1']['wert3_einheit'] = '';
$sensortype['strom1']['wert3_grafik'] = '0';
$sensortype['strom1']['wert4']         = '';
$sensortype['strom1']['wert4_einheit'] = '';
$sensortype['strom1']['wert4_grafik'] = '0';
$sensortype['strom1']['wert5']         = '';
$sensortype['strom1']['wert5_einheit'] = '';
$sensortype['strom1']['wert5_grafik'] = '0';
$sensortype['strom1']['wert6']         = '';
$sensortype['strom1']['wert6_einheit'] = '';
$sensortype['strom1']['wert6_grafik'] = '0';
$sensortype['strom1']['wert7']         = '';
$sensortype['strom1']['wert7_einheit'] = '';
$sensortype['strom1']['wert7_grafik'] = '0';
$sensortype['strom1']['wert8']         = '';                                             
$sensortype['strom1']['wert8_einheit'] = '';
$sensortype['strom1']['wert8_grafik'] = '0';
$sensortype['strom1']['wert9']         = '';
$sensortype['strom1']['wert9_einheit'] = '';
$sensortype['strom1']['wert9_grafik'] = '0';
$sensortype['strom1']['farbe']         = '#FF5550';
$sensortype['strom1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " A ";';

//Spannung
$sensortype['spannung1']['name']          = 'spannung1';
$sensortype['spannung1']['beschreibung']  = 'Spannungssensor';                                
$sensortype['spannung1']['wert1']         = 'Volt';
$sensortype['spannung1']['wert1_einheit'] = 'V';
$sensortype['spannung1']['wert1_grafik'] = '1';
$sensortype['spannung1']['wert2']         = 'ADC';
$sensortype['spannung1']['wert2_einheit'] = 'ADC';
$sensortype['spannung1']['wert2_grafik'] = '0';
$sensortype['spannung1']['wert3']         = '';
$sensortype['spannung1']['wert3_einheit'] = '';
$sensortype['spannung1']['wert3_grafik'] = '0';
$sensortype['spannung1']['wert4']         = '';
$sensortype['spannung1']['wert4_einheit'] = '';
$sensortype['spannung1']['wert4_grafik'] = '0';
$sensortype['spannung1']['wert5']         = '';
$sensortype['spannung1']['wert5_einheit'] = '';
$sensortype['spannung1']['wert5_grafik'] = '0';
$sensortype['spannung1']['wert6']         = '';
$sensortype['spannung1']['wert6_einheit'] = '';
$sensortype['spannung1']['wert6_grafik'] = '0';
$sensortype['spannung1']['wert7']         = '';
$sensortype['spannung1']['wert7_einheit'] = '';
$sensortype['spannung1']['wert7_grafik'] = '0';
$sensortype['spannung1']['wert8']         = '';                                             
$sensortype['spannung1']['wert8_einheit'] = '';
$sensortype['spannung1']['wert8_grafik'] = '0';
$sensortype['spannung1']['wert9']         = '';
$sensortype['spannung1']['wert9_einheit'] = '';
$sensortype['spannung1']['wert9_grafik'] = '0';
$sensortype['spannung1']['farbe']         = '#FF5550';
$sensortype['spannung1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " V ";';

// Windgeschwindigkeitssensor
$sensortype['wind1']['name']          = 'wind1';
$sensortype['wind1']['beschreibung']  = 'Windgeschwindigkeitssensor';
$sensortype['wind1']['wert1']         = 'Windgeschwindigkeit';
$sensortype['wind1']['wert1_einheit'] = 'km/h';
$sensortype['wind1']['wert1_grafik'] = '1';
$sensortype['wind1']['wert2']         = '';
$sensortype['wind1']['wert2_einheit'] = '';
$sensortype['wind1']['wert2_grafik'] = '0';
$sensortype['wind1']['wert3']         = '';
$sensortype['wind1']['wert3_einheit'] = '';
$sensortype['wind1']['wert3_grafik'] = '0';
$sensortype['wind1']['wert4']         = '';
$sensortype['wind1']['wert4_einheit'] = '';
$sensortype['wind1']['wert4_grafik'] = '0';
$sensortype['wind1']['wert5']         = '';
$sensortype['wind1']['wert5_einheit'] = '';
$sensortype['wind1']['wert5_grafik'] = '0';
$sensortype['wind1']['wert6']         = '';
$sensortype['wind1']['wert6_einheit'] = '';
$sensortype['wind1']['wert6_grafik'] = '0';
$sensortype['wind1']['wert7']         = '';
$sensortype['wind1']['wert7_einheit'] = '';
$sensortype['wind1']['wert7_grafik'] = '0';
$sensortype['wind1']['wert8']         = '';                                             
$sensortype['wind1']['wert8_einheit'] = '';
$sensortype['wind1']['wert8_grafik'] = '0';
$sensortype['wind1']['wert9']         = '';
$sensortype['wind1']['wert9_einheit'] = '';
$sensortype['wind1']['wert9_grafik'] = '0';
$sensortype['wind1']['farbe']         = '#33CCFF';
$sensortype['wind1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " km/h ";';

// Sauerstoffsensor
$sensortype['otwo1']['name']          = 'otwo1';
$sensortype['otwo1']['beschreibung']  = 'Sauerstoffsensor';
$sensortype['otwo1']['wert1']         = 'Sauerstoffgehalt';
$sensortype['otwo1']['wert1_einheit'] = 'mg/l';
$sensortype['otwo1']['wert1_grafik'] = '1';
$sensortype['otwo1']['wert2']         = '';
$sensortype['otwo1']['wert2_einheit'] = '';
$sensortype['otwo1']['wert2_grafik'] = '0';
$sensortype['otwo1']['wert3']         = '';
$sensortype['otwo1']['wert3_einheit'] = '';
$sensortype['otwo1']['wert3_grafik'] = '0';
$sensortype['otwo1']['wert4']         = '';
$sensortype['otwo1']['wert4_einheit'] = '';
$sensortype['otwo1']['wert4_grafik'] = '0';
$sensortype['otwo1']['wert5']         = '';
$sensortype['otwo1']['wert5_einheit'] = '';
$sensortype['otwo1']['wert5_grafik'] = '0';
$sensortype['otwo1']['wert6']         = '';
$sensortype['otwo1']['wert6_einheit'] = '';
$sensortype['otwo1']['wert6_grafik'] = '0';
$sensortype['otwo1']['wert7']         = '';
$sensortype['otwo1']['wert7_einheit'] = '';
$sensortype['otwo1']['wert7_grafik'] = '0';
$sensortype['otwo1']['wert8']         = '';                                             
$sensortype['otwo1']['wert8_einheit'] = '';
$sensortype['otwo1']['wert8_grafik'] = '0';
$sensortype['otwo1']['wert9']         = '';
$sensortype['otwo1']['wert9_einheit'] = '';
$sensortype['otwo1']['wert9_grafik'] = '0';
$sensortype['otwo1']['farbe']         = '#33CCFF';
$sensortype['otwo1']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " mg/l ";';

// HexaBusPlug+ (Status + Stromverbrauch)
$sensortype['hexabusplugplus']['name']          = 'hexabusplugplus';
$sensortype['hexabusplugplus']['beschreibung']  = 'HexabusPlug+';
$sensortype['hexabusplugplus']['wert1']         = 'Status';
$sensortype['hexabusplugplus']['wert1_einheit'] = '';
$sensortype['hexabusplugplus']['wert1_grafik'] = '1';
$sensortype['hexabusplugplus']['wert2']         = 'Stromverbrauch';
$sensortype['hexabusplugplus']['wert2_einheit'] = 'Watt';
$sensortype['hexabusplugplus']['wert2_grafik'] = '1';
$sensortype['hexabusplugplus']['wert3']         = '';
$sensortype['hexabusplugplus']['wert3_einheit'] = '';
$sensortype['hexabusplugplus']['wert3_grafik'] = '0';
$sensortype['hexabusplugplus']['wert4']         = '';
$sensortype['hexabusplugplus']['wert4_einheit'] = '';
$sensortype['hexabusplugplus']['wert4_grafik'] = '0';
$sensortype['hexabusplugplus']['wert5']         = '';
$sensortype['hexabusplugplus']['wert5_einheit'] = '';
$sensortype['hexabusplugplus']['wert5_grafik'] = '0';
$sensortype['hexabusplugplus']['wert6']         = '';
$sensortype['hexabusplugplus']['wert6_einheit'] = '';
$sensortype['hexabusplugplus']['wert6_grafik'] = '0';
$sensortype['hexabusplugplus']['wert7']         = '';
$sensortype['hexabusplugplus']['wert7_einheit'] = '';
$sensortype['hexabusplugplus']['wert7_grafik'] = '0';
$sensortype['hexabusplugplus']['wert8']         = '';                                             
$sensortype['hexabusplugplus']['wert8_einheit'] = '';
$sensortype['hexabusplugplus']['wert8_grafik'] = '0';
$sensortype['hexabusplugplus']['wert9']         = '';
$sensortype['hexabusplugplus']['wert9_einheit'] = '';
$sensortype['hexabusplugplus']['wert9_grafik'] = '0';
$sensortype['hexabusplugplus']['farbe']         = '#006600';
$sensortype['hexabusplugplus']['index_ausgabe'] = 'if ($rowausgabe[wert1] == "0") { echo "OFF"; } elseif ($rowausgabe[wert1] == "1") { echo "ON"; } else { echo "ERROR"; };
                                                   echo " (" . $rowausgabe[wert2] . " Watt)";';

// HexaBusPlug (Status)
$sensortype['hexabusplug']['name']          = 'hexabusplug';
$sensortype['hexabusplug']['beschreibung']  = 'HexabusPlug';
$sensortype['hexabusplug']['wert1']         = 'Status';
$sensortype['hexabusplug']['wert1_einheit'] = '';
$sensortype['hexabusplug']['wert1_grafik'] = '1';
$sensortype['hexabusplug']['wert2']         = '';
$sensortype['hexabusplug']['wert2_einheit'] = '';
$sensortype['hexabusplug']['wert2_grafik'] = '0';
$sensortype['hexabusplug']['wert3']         = '';
$sensortype['hexabusplug']['wert3_einheit'] = '';
$sensortype['hexabusplug']['wert3_grafik'] = '0';
$sensortype['hexabusplug']['wert4']         = '';
$sensortype['hexabusplug']['wert4_einheit'] = '';
$sensortype['hexabusplug']['wert4_grafik'] = '0';
$sensortype['hexabusplug']['wert5']         = '';
$sensortype['hexabusplug']['wert5_einheit'] = '';
$sensortype['hexabusplug']['wert5_grafik'] = '0';
$sensortype['hexabusplug']['wert6']         = '';
$sensortype['hexabusplug']['wert6_einheit'] = '';
$sensortype['hexabusplug']['wert6_grafik'] = '0';
$sensortype['hexabusplug']['wert7']         = '';
$sensortype['hexabusplug']['wert7_einheit'] = '';
$sensortype['hexabusplug']['wert7_grafik'] = '0';
$sensortype['hexabusplug']['wert8']         = '';                                             
$sensortype['hexabusplug']['wert8_einheit'] = '';
$sensortype['hexabusplug']['wert8_grafik'] = '0';
$sensortype['hexabusplug']['wert9']         = '';
$sensortype['hexabusplug']['wert9_einheit'] = '';
$sensortype['hexabusplug']['wert9_grafik'] = '0';
$sensortype['hexabusplug']['farbe']         = '#006600';
$sensortype['hexabusplug']['index_ausgabe'] = 'if ($rowausgabe[wert1] == "0") { echo "OFF"; } elseif ($rowausgabe[wert1] == "1") { echo "ON"; } else { echo "ERROR"; };';

$sensortype['hygrometer']['name']          = 'hygrometer';
$sensortype['hygrometer']['beschreibung']  = 'Hygrometer';                                 
$sensortype['hygrometer']['wert1']         = 'Feuchtigkeit';
$sensortype['hygrometer']['wert1_einheit'] = '%';
$sensortype['hygrometer']['wert1_grafik'] = '1';
$sensortype['hygrometer']['wert2']         = 'Feuchtigkeit (BG1)';
$sensortype['hygrometer']['wert2_einheit'] = '%';
$sensortype['hygrometer']['wert2_grafik'] = '0';
$sensortype['hygrometer']['wert3']         = 'Feuchtigkeit (BG2)';
$sensortype['hygrometer']['wert3_einheit'] = '%';
$sensortype['hygrometer']['wert3_grafik'] = '0';
$sensortype['hygrometer']['wert4']         = 'ADC';
$sensortype['hygrometer']['wert4_einheit'] = '';
$sensortype['hygrometer']['wert4_grafik'] = '0';
$sensortype['hygrometer']['wert5']         = 'ADC (BG1)';
$sensortype['hygrometer']['wert5_einheit'] = '';
$sensortype['hygrometer']['wert5_grafik'] = '0';
$sensortype['hygrometer']['wert6']         = 'ADC (BG2)';
$sensortype['hygrometer']['wert6_einheit'] = '';
$sensortype['hygrometer']['wert6_grafik'] = '0';
$sensortype['hygrometer']['wert7']         = '';
$sensortype['hygrometer']['wert7_einheit'] = '';
$sensortype['hygrometer']['wert7_grafik'] = '0';
$sensortype['hygrometer']['wert8']         = '';                                             
$sensortype['hygrometer']['wert8_einheit'] = '';
$sensortype['hygrometer']['wert8_grafik'] = '0';
$sensortype['hygrometer']['wert9']         = '';
$sensortype['hygrometer']['wert9_einheit'] = '';
$sensortype['hygrometer']['wert9_grafik'] = '0';
$sensortype['hygrometer']['farbe']         = '#FF5500';
//$sensortype['hygrometer']['index_ausgabe'] = 'echo $rowausgabe[wert1] . " % ";';
$sensortype['hygrometer']['index_ausgabe'] = 'echo "<img src=\"erw/ausgabe/bar.php?rating=" . $rowausgabe[wert1] . "&height=18&width=110\" alt=\"Bar(ERROR)\"></a>";
                                        echo " " . $rowausgabe[wert1] . " % ";
                                        ';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//DEBUGGING
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//echo "### ARRAY DEBUG ###################################################";   // Debug Ausgabe
//echo '<pre>';                                                                 // Debug Ausgabe
//print_r($sensortype);                                                         // Debug Ausgabe
//echo '</pre>';                                                                // Debug Ausgabe
//echo "#####################################################################"; // Debug Ausgabe
//echo "<br><br><br><br>";   
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//foreach($sensortype as $sensortype_foreach) {
//	echo $sensortype_foreach[name];
//	echo " - ";
//	echo $sensortype_foreach[beschreibung];
//	echo "<br>";
//};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//foreach($sensortype as $sensortype_foreach) {
//echo $sensortype_foreach[feldanzahl];
  //if ($sensortype_foreach[wert1] != "") { echo $sensortype_foreach[wert1]; };
  //if ($sensortype_foreach[wert2] != "") { echo $sensortype_foreach[wert2]; };
  //if ($sensortype_foreach[wert3] != "") { echo $sensortype_foreach[wert3]; };
  //if ($sensortype_foreach[wert4] != "") { echo $sensortype_foreach[wert4]; };
  //if ($sensortype_foreach[wert5] != "") { echo $sensortype_foreach[wert5]; };
  //if ($sensortype_foreach[wert6] != "") { echo $sensortype_foreach[wert6]; };
  //if ($sensortype_foreach[wert7] != "") { echo $sensortype_foreach[wert7]; };
  //if ($sensortype_foreach[wert8] != "") { echo $sensortype_foreach[wert8]; };
  //if ($sensortype_foreach[wert9] != "") { echo $sensortype_foreach[wert9]; };
  //echo '<br>';
//};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>