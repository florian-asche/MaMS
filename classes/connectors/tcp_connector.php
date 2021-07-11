<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

class ConnectClass {
    public function __construct() {
    }
    
    // SOME HELP WITH ASCII CHARS:
    // Example output: EOF\r\n
    // 
    // ASCII:
    //  69 = E
    //  79 = O
    //  70 = F
    //  13 = CR steht fuer .Carriage Return. und entspricht dem \r (return).
    //  10 = LF steht fuer .Line Feed. und entspricht dem \n (newline).
    
    /**
     * 
     * @global string $output
     * @param string $ip
     * @param string $port
     * @param string $request
     * @param array  $answerstrings
     * @param string $number_lines
     * @param string $eol_delimiters
     * @param string $connect_debug
     * @param string $stream
     * @param string $line
     * @param string $data
     * @return data
     */
    public function manage_break($ip, $port, $request, $answerstrings, $number_lines, $eol_delimiters, $connect_debug, $stream, $line, $data) {
        global $output;
        $break = false;

        // Check for break
        foreach ($answerstrings as $answerstring) {
            if (preg_match_all("/" . $answerstring . "/", $line, $matches, PREG_SET_ORDER)) {
                $output->debug(__FUNCTION__, "[STATUS] FOUND END: FOUND ANSWER WITH REGEX", "3");
                $output->debug(__FUNCTION__, "[STATUS] FOUND END: FOUND ANSWER WITH REGEX:" . $output->array_output($matches), "4");
                $break = true;
            }
        }

        // Check for break
        if (in_array($line, $answerstrings)) {
            $output->debug(__FUNCTION__, "[STATUS] FOUND END: ANSWER IN STRING", "3");
            $break = true;
        }

        // Check for break
        if ((count($data) + 1) >= $number_lines) {
            $output->debug(__FUNCTION__, "[STATUS] FOUND END: LINE COUNT REACHED", "3");
            if (in_array("MAMS_USELINECOUNTER", $answerstrings)) {
                $break = true;
            };
        }

        // return the result
        return $break;
    }
    
    /**
     * 
     * @param type $data
     * @param type $answerstrings
     */
    public function filter_data($data, $answerstrings) {
        global $output;
        
        $data_new = array();
        $filterbreak = false;
        
        foreach ($data as $value) {
            // Check for break
            foreach ($answerstrings as $answerstring) {
                if (preg_match_all("/" . $answerstring . "/", $value, $matches, PREG_SET_ORDER)) {
                    $output->debug(__FUNCTION__, "[STATUS] FOUND END: FOUND ANSWER WITH REGEX", "3");
                    $output->debug(__FUNCTION__, "[STATUS] FOUND END: FOUND ANSWER WITH REGEX:" . $output->array_output($matches), "4");
                    $filterbreak = true;
                }

                // Check for break
                if (in_array($value, $answerstrings)) {
                    $output->debug(__FUNCTION__, "[STATUS] FOUND END: ANSWER IN STRING", "3");
                    $filterbreak = true;
                }

                if ($filterbreak == true) {
                    $output->debug(__FUNCTION__, "[STATUS] END", "3");
                    break;
                } 
            }
        }
        return $data_new;
    }
    
    /**
     * This function collect data from tcp socket
     * 
     * HELP:
     * If you have problems with the result look for $eol_delimiters.
     * If you have data but timeout problems, the function didnt find an end for the tcp stream.
     * You can try to set "USELINECOUNTER" in $answerstrings array. You have to set a line limit for recieve. If it is to big, you ran in an timeout.
     * If you dont get any data you can set $connect_debug to true. The script then didnt use the $eol_delimiters and try to find an $answerstrings.
     * 
     * @param string $ip
     * @param string $port
     * @param string $request
     * @param array $answerstrings
     * SENDONLY       = Just send a message and dont wait for an answer
     * USELINECOUNTER = Count the number of recieved lines and end if the count is reached
     * @param string $number_lines
     * @param string $eol_delimiters
     * @param boolean $connect_debug
     * @return data
     */
    public function tcp_connect($ip, $port, $request, $answerstrings, $number_lines, $eol_delimiters, $connect_debug) {
        global $output;
        $data = array();
        $data_new = array();
        $nodata = false;
        
        $connect_timeout = "10";
        $stream_timeout = "30";
        $stream_length = "100000000";
        
        $output->debug(__FUNCTION__, "#############################################################################", "3");
        
        $output->debug(__FUNCTION__, "[CONFIG] IP " . $ip, "3");
        $output->debug(__FUNCTION__, "[CONFIG] PORT: " . $port, "3");
        $output->debug(__FUNCTION__, "[CONFIG] REQUEST RAW: " . $request, "3");
        $output->debug(__FUNCTION__, "[CONFIG] REQUEST ASCII: " . $output->str2asciiausgabe($request), "5");
        $output->debug(__FUNCTION__, "[CONFIG] ANSWERSTRING: " . $output->array_output($answerstrings), "4");
        //$output->debug(__FUNCTION__, "[CONFIG] ANSWERSTRING ASCII: " . $output->str2asciiausgabe($answerstring), "5");
        $output->debug(__FUNCTION__, "[CONFIG] NUMBER_LINES: " . $number_lines, "4");
        $output->debug(__FUNCTION__, "[CONFIG] EOFDELIMITERS: " . $eol_delimiters, "4");
        $output->debug(__FUNCTION__, "[CONFIG] EOFDELIMITERS ASCII: " . $output->str2asciiausgabe($eol_delimiters), "5");
        $output->debug(__FUNCTION__, "[CONFIG] CONNECT_DEBUG: " . $connect_debug, "4");
        
        // open stream
        $stream = fsockopen($ip, $port, $errno, $errstr, $connect_timeout);

        // check if stream is valid
        if (!$stream) {
            $output->debug(__FUNCTION__, "[STATUS] Couldnt open the connection to tcp server", "3");
            return;
        } else {
            $output->debug(__FUNCTION__, "[STATUS] OPEN: Connection to target successfully opened", "3");
            
            // Set timeout
            stream_set_timeout($stream,$stream_timeout);
            
            // Send request data to stream, write recieved data in stream variable
            fputs($stream, $request);

            // end stream if you wish no recieve of data
            if (in_array("SENDONLY", $answerstrings)) {
                // hier die zeilen aus $stream zaehlen , kann ich benutzen fuer ausgabe und wenn 0 dann error
                //wenn der count 0 ist dann prüefen ob NODATASTOP aktiviert ist, wenn ja dann ...
                //echo count(fgets($stream));
                $output->debug(__FUNCTION__, "[STATUS] END: SEND ONLY ACTIVATED - I DONT WAIT FOR AN RECIEVE", "3");
                fclose($stream);
                $output->debug(__FUNCTION__, "[STATUS] CLOSE: Connection to target successfully closed", "3");
                return;
            };

            // Check for Recieve Zero (0)
           // $output->debug(__FUNCTION__, "[STATUS] START", "3");
            //$check = stream_get_line($stream, $stream_length, $eol_delimiters);
            //$data[] = $rec_data;
            //$output->debug(__FUNCTION__, "[DATA] [" . "ZERO" . "] [RAW-ASCII] " . $output->array_output($rec_data), "3");
            
            //if (is_array($rec_data)) {            
            //while(1) {
            $startTime = time();
            $break = false;
            //while ($line = stream_get_line($stream, $stream_length, $eol_delimiters)) {
            //http://php.net/manual/en/function.stream-get-line.php
            while (!feof($stream) and !$break and (($startTime + $stream_timeout) > time())) {
                // Get data
                $line = stream_get_line($stream, $stream_length, $eol_delimiters);
                
                // Debug
                $output->debug(__FUNCTION__, "[LINE] [" . (count($data) + 1) . "] [RAW-DATA] " . $line, "3");
                $output->debug(__FUNCTION__, "[LINE] [" . (count($data) + 1) . "] [RAW-ASCII] " . $output->str2asciiausgabe($line), "3");

                // Check for data end (break)
                $break = $this->manage_break($ip, $port, $request, $answerstrings, $number_lines, $eol_delimiters, $connect_debug, $stream, $line, $data);
                
                // Check for break
                if ($line != "0" and $line == false) {
                    $output->debug(__FUNCTION__, "[ERROR] connection interrupted == ", "1");
                    $output->debug(__FUNCTION__, "[STATUS] END", "4");
                    break;
                }
                
                // Output debug: data
                $output->debug(__FUNCTION__, "[DATA] [" . (count($data) + 1) . "] " . $line, "4");
                $output->debug(__FUNCTION__, "[DATA] [" . (count($data) + 1) . "] [RAW-ASCII] " . $output->str2asciiausgabe($line), "4");
                
                // Set data
                $data[] = $line;
                
                // Do the break
                if ($break == true) {
                    $output->debug(__FUNCTION__, "[STATUS] END", "3");
                    break;
                }
            }
                
            // Check for break
            if (feof($stream)) {
                $output->debug(__FUNCTION__, "[STATUS] FOUND END: FEOF FOUND", "3");
            }
            
            // Check if we get data from while
            $output->debug(__FUNCTION__, "[DATA] [DATA COUNT] " . count($data), "3");
            
            if (count($data) == 0) {
                $output->debug(__FUNCTION__, "[ERROR] no data recieved from stream_get_line", "3");
                $nodata = true;
            }
            
//            // Debug mode
//            if ($connect_debug == true) {
//                $output->debug(__FUNCTION__, "[STATUS] AUTODEBUG: debug is activated !!!", "3");
//
//                // try a normal fgets and maybe wait for timeout
//                while ($line = fgets($stream)) {
//                    // Debug
//                    $output->debug(__FUNCTION__, "[LINE] [" . count($data) . "] " . $line, "3");
//                    $output->debug(__FUNCTION__, "[LINE] [" . count($data) . "] [RAW-ASCII] " . $output->str2asciiausgabe($line), "3");
//
//                    // Check for data end (break)
//                    $break = $this->manage_break($ip, $port, $request, $answerstrings, $number_lines, $eol_delimiters, $connect_debug, $stream, $line, $data);
//
//                    // Check for break
//                    if ($line != "0" and $line == false) {
//                        $output->debug(__FUNCTION__, "[ERROR] connection interrupted == ", "3");
//                        $output->debug(__FUNCTION__, "[STATUS] END", "3");
//                        break;
//                    }
//
//                    // Output debug: data
//                    $output->debug(__FUNCTION__, "[DATA] [" . count($data) . "] " . $line, "4");
//                    $output->debug(__FUNCTION__, "[DATA] [" . count($data) . "] [RAW-ASCII] " . $output->str2asciiausgabe($line), "4");
//
//                    // Set data
//                    $data[] = $line;
//
//                    // Do the break
//                    if ($break == true) {
//                        $output->debug(__FUNCTION__, "[STATUS] END", "3");
//                        break;
//                    }
//                }
//            }

            // Socket Meta Data Analyse
            $meta = stream_get_meta_data($stream);
            $output->debug(__FUNCTION__, "[DATA] META: " . $output->array_output($meta), "3");

            // Check for timeout
            if ($meta['timed_out']) {
                $output->debug(__FUNCTION__, "[ERROR] timeout reached", "3");
                $nodata = true;
            }
        }
            
        // Close stream
        fclose($stream);
        $output->debug(__FUNCTION__, "[STATUS] CLOSE: Connection to target successfully closed", "3");

        // Stream return output
        $output->debug(__FUNCTION__, "[STATUS] FSOCKOPEN RC=" . $errno, "3");
        if ($errno != 0) {
            $output->debug(__FUNCTION__, "[STATUS] FSOCKOPEN ERRORSTR=" . $errstr, "3");
        }
        
        $output->debug(__FUNCTION__, "[DATA] " . $output->array_output($data), "3");

        if (in_array("MAMS_FILTEROUT_ANSWERS", $answerstrings)) {
            $data_new = $this->filter_data($data, $answerstrings);
        } else {
            $data_new = $data;
        }
        
        // return false
        if ($nodata == true) {
            $output->debug(__FUNCTION__, "[ERROR] NO RETURN OF DATA", "1");
            return array();
        }
        
        return $data_new;
    }
}
?>
