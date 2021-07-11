<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

/**
 * Description of SystemOutput
 *
 * @author florian
 */
class SystemOutput {

    public function __construct() {
    }
    
    
    public $_cli_colors = array(
        'LIGHT_RED' => "[1;31m",
        'LIGHT_GREEN' => "[1;32m",
        'YELLOW' => "[1;33m",
        'LIGHT_BLUE' => "[1;34m",
        'MAGENTA' => "[1;35m",
        'LIGHT_CYAN' => "[1;36m",
        'WHITE' => "[1;37m",
        'NORMAL' => "[0m",
        'BLACK' => "[0;30m",
        'RED' => "[0;31m",
        'GREEN' => "[0;32m",
        'BROWN' => "[0;33m",
        'BLUE' => "[0;34m",
        'CYAN' => "[0;36m",
        'BOLD' => "[1m",
        'UNDERSCORE' => "[4m",
        'REVERSE' => "[7m",
    );
    
    
    public $_gui_colors = array(
        'LIGHT_RED' => "#ef3d47",
        'LIGHT_GREEN' => "#00FF00",
        'YELLOW' => "#FFFF00",
        'LIGHT_BLUE' => "#ADD8E6",
        'MAGENTA' => "#FF00FF",
        'LIGHT_CYAN' => "#E0FFFF",
        'WHITE' => "#ffffff",
        'NORMAL' => "#000000",
        'BLACK' => "#000000",
        'RED' => "#FF0000",
        'GREEN' => "#006600",
        'BROWN' => "#A52A2A",
        'BLUE' => "#0000FF",
        'CYAN' => "#00FFFF",
    );

    
    public function termcolored($text, $color = "NORMAL") {
        $out = $this->_cli_colors["$color"];

        return chr(27) . "$out$text" . chr(27) . $this->_cli_colors["NORMAL"];
    }

    
    public function guicolored($text, $color = "NORMAL") {
        $infinity = $this->_gui_colors["$color"];

        return '<span style="color:' . $infinity . '">' . '$text' . '</span>';
    }

    
    public function newline() {
        $interfacedetect = isCommandLineInterface();
        //echo $interfacedetect;
        if ($interfacedetect == "cli") {
            return "\n";
        } elseif ($interfacedetect == "apache2handler") {
            return "<br>";
        } else {
            return "<br>";
        }
    }

    
    public function array_output($array) {
        //$ausgabe = newline();
        //echo "### ARRAY DEBUG ###################################################";
        $ausgabe = '<pre>';
        $ausgabe .= print_r($array, true);
        // When the second parameter is set to TRUE, print_r() will return the information rather than print it
        $ausgabe .= '</pre>';
        //echo "#####################################################################";
        //$ausgabe .= newline();

        return $ausgabe;
    }
    
    
    public function str2asciiausgabe($string) {
        //$ausgabe = newline();
        //echo "### ARRAY DEBUG ###################################################";
        $ausgabe = '<pre>';
        $ausgabe .= print_r(str2ascii($string), true);
        // When the second parameter is set to TRUE, print_r() will return the information rather than print it
        $ausgabe .= '</pre>';
        //echo "#####################################################################";
        //$ausgabe .= newline();

        return $ausgabe;
    }

    
    /**
     * Output the debug message to the various outputs (Terminal, Logfile, Syslog)
     *
     * @param string $msg The debug message
     * @param string $debug_level Define which debug level this message is
     * @param string $color Define the color for text output
     */
    public function debug($function, $msg, $debug_level = "3", $color = "BLUE") {
        global $default_configuration;

        // Standard Logging
        //$ts = strftime("%H:%M:%S", time());
        list($usec, $sec) = explode(" ", microtime());
        $ts = date("d.m.Y H:i:s:", $sec) . intval(round($usec * 1000));

        if (function_exists('posix_getpid')) {
            $ts = "$ts|" . posix_getpid();
        }

        // Logging to Terminal
        if ($default_configuration['default_settings']['log_to_terminal'] == "1") {
            if ((isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level'][$function] >= $debug_level) or (!isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level']['default'] >= $debug_level)) {
                //print "[$ts] $msg" . newline();
                //print termcolored("[$ts] $msg" . newline(), "BLUE");

                $interfacedetect = isCommandLineInterface();
                //echo $interfacedetect;
                if ($interfacedetect == "cli") {
                    print $this->termcolored("[$ts] [$function] $msg" . $this->newline(), $color);
                } elseif ($interfacedetect == "apache2handler") {
                    print $this->guicolored("[$ts] [$function] $msg" . $this->newline(), $color);
                } else {
                    print "[$ts] [$function] $msg" . $this->newline();
                }
            }
        }

        // Logging to File
        if ($default_configuration['default_settings']['log_to_file'] == "1") {
            if ((isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level'][$function] >= $debug_level) or (!isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level']['default'] >= $debug_level)) {
                $fp = fopen($default_configuration['default_settings']['logfile'], 'a+');

                if ($fp) {
                    $locked = false;

                    if (function_exists("flock")) {
                        $tries = 0;

                        // try to lock logfile for writing
                        while ($tries < 5 && !$locked = flock($fp, LOCK_EX | LOCK_NB)) {
                            sleep(1);
                            ++$tries;
                        }

                        if (!$locked) {
                            fclose($fp);
                            return;
                        }
                    }

                    fputs($fp, "[$ts] [$function] $msg\n");

                    if (function_exists("flock")) {
                        flock($fp, LOCK_UN);
                    }

                    fclose($fp);
                }
            }
        }

        // Logging to Syslog
        if ($default_configuration['default_settings']['log_to_syslog'] == "1") {
            if ((isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level'][$function] == "1") or (!isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level']['default'] == "1")) {
                syslog(LOG_ERR, "[$ts] [$function] $msg");
            } elseif ((isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level'][$function] == "2") or (!isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level']['default'] == "2")) {
                syslog(LOG_INFO, "[$ts] [$function] $msg");
            } elseif ((isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level'][$function] == "3") or (!isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level']['default'] == "3")) {
                syslog(LOG_DEBUG, "[$ts] [$function] $msg");
            } elseif ((isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level'][$function] == "4") or (!isset($default_configuration['default_settings']['debug_level'][$function]) and $default_configuration['default_settings']['debug_level']['default'] == "4")) {
                syslog(LOG_DEBUG, "[$ts] [$function] $msg");
            }
        }
    }
}
