<?php
$debug = "0";
$debug_array = "0";

$timeout = "20";
$server_ip   = '[caca::50:c4ff:fe04:8332]';
$server_port = 61616;

$funktion = "getstatus";

if ($funktion == "getpower") {
    $message     = chr(0x48).chr(0x58).chr(0x30).chr(0x43).chr(0x02).chr(0x00).chr(0x00).chr(0x00).chr(0x00).chr(0x02).chr(0xf7).chr(0xcb);                       //GET POWER
    $getdata = true;
    
} elseif ($funktion == "getstatus") {
    $message     = chr(0x48).chr(0x58).chr(0x30).chr(0x43).chr(0x02).chr(0x00).chr(0x00).chr(0x00).chr(0x00).chr(0x01).chr(0xc5).chr(0x50);                       //GET STATUS
    $getdata = true;
} elseif ($funktion == "seton") {
    $message     = chr(0x48).chr(0x58).chr(0x30).chr(0x43).chr(0x04).chr(0x00).chr(0x00).chr(0x00).chr(0x00).chr(0x01).chr(0x01).chr(0x01).chr(0x57).chr(0xb6);   //ON
} elseif ($funktion == "setoff") {
    $message     = chr(0x48).chr(0x58).chr(0x30).chr(0x43).chr(0x04).chr(0x00).chr(0x00).chr(0x00).chr(0x00).chr(0x01).chr(0x01).chr(0x00).chr(0x46).chr(0x3f);   //OFF
} else {
    echo "ERROR: unbekannte Funktion!";
    exit;
}

function str2hex_encoder($string) {
	for($charcounter = 0; $charcounter < mb_strlen($string, "ASCII"); $charcounter++) {
                $hexdata = "0x";
                if (strlen(dechex(ord($string[$charcounter]))) == 1) { $hexdata = $hexdata . "0"; };
                $hexdata = $hexdata . dechex(ord($string[$charcounter]));
                $hexdaten[] = $hexdata;
	};
        return $hexdaten;
};

socket_set_timeout($fp, $timeout);
$fp = pfsockopen("udp://".$server_ip, $server_port, $errno, $errstr);
if (!$fp) {
    echo "CONNECTION ERROR: " . $errno . " - " .  $errstr;
    exit;
} else {
    $write = fwrite($fp, $message);

    if (!$write) {
        echo "ERROR: cannot writing to Port!";
        exit;
    } else {
        if ($getdata) {
        $returndata = fread($fp, 10000);
        fclose($fp);

        $returndata_hex = str2hex_encoder($returndata);
        $returndata_hex_count = count($returndata_hex);

        if ($debug_array == "1") {                                                      //Debug Ausgabe
            echo "##### ARRAY DEBUG ###################################################";
            echo '<pre>';
            print_r($returndata_hex);
            echo '</pre>';
            echo "#####################################################################";
            echo "<br><br><br><br>";
        };  

        // Header ermitteln
        $header_hex = $returndata_hex[0] . $returndata_hex[1] . $returndata_hex[2] . $returndata_hex[3];
        $header = chr($returndata_hex[0]) . chr($returndata_hex[1]) . chr($returndata_hex[2]) . chr($returndata_hex[3]);

        if ($header_hex == "0x480x580x300x43" or $header_hex == "0x480x580x300x42") {   // Header pruefen
            //echo "Header OK (" . $header . ")";

            $packetType_hex = $returndata_hex[4];
            $flags_hex = $returndata_hex[5];
            $data_type_hex = $returndata_hex[10];

            // CRC ermitteln und prüfen
            $crc1_hex = $returndata_hex[$returndata_hex_count - 2];
            $crc1 = chr($returndata_hex[$returndata_hex_count - 2]);
            $crc2_hex = $returndata_hex[$returndata_hex_count - 1];
            $crc2 = chr($returndata_hex[$returndata_hex_count - 1]);

            // Flag ermitteln
            if ($flags_hex == "0x00") { 
                $flags = "default";
            } elseif ($flags_hex == "0x01") {
                $flags = "HXB_FLAG_CONFIRM";
            } else {
                echo "ERROR: unknown flag!";
                //exit; //Eine unbekannte Flag muss nicht gleich dazu fuhren, dass der rest nicht verstanden wird.
            }

            // PacketType ermitteln
            if ($packetType_hex == "0x00") {
                $packetType = "error";
            } elseif ($packetType_hex == "0x01") {
                $packetType = "info";
            } elseif ($packetType_hex == "0x04") {
                $packetType = "write";
            } elseif ($packetType_hex == "0x02") {
                $packetType = "query";
            } else {
                echo "ERROR: packetType nicht bekannt!";
                exit;
            }

            // Data_Type und Value ermitteln
            if ($packetType != "error" AND $packetType != "query") {       // Data_Type soll bei ERROR und QUERY nicht ermittelt werden!
                if ($data_type_hex == "0x01") {
                    $data_type = "Boolen. The value filed is 1 byte wide";
                    $value_hex = $returndata_hex[11];
                    $value = hexdec($returndata_hex[11]);
                } elseif ($data_type_hex == "0x02") {
                    $data_type = "8 Bit unsigned integer (one byte)";
                    $value_hex = $returndata_hex[11];
                    $value = intval(hexdec($returndata_hex[11]));
                } elseif ($data_type_hex == "0x03") {
                    $data_type = "32 bit unsigned integer (four bytes)";
                    $value_hex = $returndata_hex[11] . $returndata_hex[12] . $returndata_hex[13] . $returndata_hex[14];
                    $value = intval(hexdec($returndata_hex[11]) . hexdec($returndata_hex[12]) . hexdec($returndata_hex[13]) . hexdec($returndata_hex[14]));
                } elseif ($data_type_hex == "0x04") {
                    $data_type = "Date/time data structure ";
                    $value_hex = "MISSING";
                    $value = "MISSING";
                } elseif ($data_type_hex == "0x05") {
                    $data_type = "32 bit float (four bytes).";
                    $value_hex = $returndata_hex[11] . $returndata_hex[12] . $returndata_hex[13] . $returndata_hex[14];
                    $value = "MISSING";
                } elseif ($data_type_hex == "0x06") {
                    $data_type = "Character string, 128 bytes of it";
                    $value_hex = $returndata_hex[11] . $returndata_hex[12] . $returndata_hex[13] . $returndata_hex[14] . $returndata_hex[15] . $returndata_hex[16] . $returndata_hex[17] . $returndata_hex[18] . $returndata_hex[19] . $returndata_hex[20] . $returndata_hex[21] . $returndata_hex[22] . $returndata_hex[23] . $returndata_hex[24] . $returndata_hex[25] . $returndata_hex[26];
                    $value = "MISSING";
                } elseif ($data_type_hex == "0x07") {
                    $data_type = "Timestamp in secondes since device was booted up";
                    $value_hex = $returndata_hex[11] . $returndata_hex[12] . $returndata_hex[13] . $returndata_hex[14];
                    $value = hexdec($returndata_hex[11]) . hexdec($returndata_hex[12]) . hexdec($returndata_hex[13]) . hexdec($returndata_hex[14]);
                } else {
                    echo "ERROR: unknown Data Type";
                    exit;
                };
            };

            // EID ermitteln
            if ($packetType != "error") {       // EID soll bei ERROR nicht ermittelt werden!
                $eid_hex = $returndata_hex[6] . $returndata_hex[7] . $returndata_hex[8] . $returndata_hex[9];
                $eid = hexdec($returndata_hex[6]) . hexdec($returndata_hex[7]) . hexdec($returndata_hex[8]) . hexdec($returndata_hex[9]);
            };

            // ErrorCode ermitteln
            if ($packetType == "error") {
                $ErrorCode_hex = $returndata_hex[6];

                if ($ErrorCode_hex == "0x00") {
                    $ErrorCode = "HXB_ERR_PACKETERROR";
                } elseif ($ErrorCode_hex == "0x01") {
                    $ErrorCode = "HXB_ERR_UNKNOWNEID";
                } elseif ($ErrorCode_hex == "0x02") {
                    $ErrorCode = "HXB_ERR_WRITEREADONLY";
                } elseif ($ErrorCode_hex == "0x03") {
                    $ErrorCode = "HXB_ERR_CRCFAILED";
                } elseif ($ErrorCode_hex == "0x04") {
                    $ErrorCode = "HXB_ERR_DATATYPE";
                } else {
                    echo "ERROR: ErrorCode unknown!";
                    exit;
                };
            };

            //Tabellen Debug Ausgabe
            if ($debug == "1") {
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>Byte</th>';
                echo '<th>0-3</th>';
                echo '<th>4</th>';
                echo '<th>5</th>';

                if ($packetType == "error") {
                    echo '<th>6</th>';
                } elseif ($packetType == "info") {
                    echo '<th>6-9</th>';
                    echo '<th>10</th>';
                    echo '<th>11++</th>';
                } elseif ($packetType == "write") {
                    echo '<th>6-9</th>';
                    echo '<th>10</th>';
                    echo '<th>11++</th>';
                } elseif ($packetType == "query") {
                    echo '<th>6-9</th>';
                };
                echo '<th>n-1</th>';
                echo '<th>n-2</th>';
                echo '</tr>';

                echo '<tr>';
                echo '<th>Field Name</th>';
                echo '<th>Header</th>';
                echo '<th>Packet Type</th>';
                echo '<th>Flags</th>';

                if ($packetType == "error") {
                    echo '<th>Error Code</th>';
                } elseif ($packetType == "info") {
                    echo '<th>EID</th>';
                    echo '<th>Data Type</th>';
                    echo '<th>Value</th>';
                } elseif ($packetType == "write") {
                    echo '<th>EID</th>';
                    echo '<th>Data Type</th>';
                    echo '<th>Value</th>';
                } elseif ($packetType == "query") {
                    echo '<th>EID</th>';
                };

                echo '<th>CRC</th>';
                echo '<th>CRC</th>';
                echo '</tr>';

                echo '<tr>';
                echo '<td>Content in Hex</td>';
                echo '<td>' . $header_hex . '</td>';
                echo '<td>' . $packetType_hex . '</td>';
                echo '<td>' . $flags_hex . '</td>';

                if ($packetType == "error") {
                    echo '<td>' . $ErrorCode_hex . '</td>';
                } elseif ($packetType == "info") {
                    echo '<td>' . $eid_hex . '</td>';
                    echo '<td>' . $data_type_hex . '</td>';
                    echo '<td>' . $value_hex . '</td>';
                } elseif ($packetType == "write") {
                    echo '<td>' . $eid_hex . '</td>';
                    echo '<td>' . $data_type_hex . '</td>';
                    echo '<td>' . $value_hex . '</td>';
                } elseif ($packetType == "query") {
                    echo '<td>' . $eid_hex . '</td>';
                };

                echo '<td>' . $crc1_hex . '</td>';
                echo '<td>' . $crc2_hex . '</td>';
                echo '</tr>';
                echo '<tr>';

                echo '<td>Content</td>';
                echo '<td>' . $header . '</td>';
                echo '<td>' . $packetType . '</td>';
                echo '<td>' . $flags . '</td>';

                if ($packetType == "error") {
                    echo '<td>' . $ErrorCode . '</td>';
                } elseif ($packetType == "info") {
                    echo '<td>' . $eid . '</td>';
                    echo '<td>' . $data_type . '</td>';
                    echo '<td>' . $value . '</td>';
                } elseif ($packetType == "write") {
                    echo '<td>' . $eid . '</td>';
                    echo '<td>' . $data_type . '</td>';
                    echo '<td>' . $value . '</td>';
                } elseif ($packetType == "query") {
                    echo '<td>' . $eid . '</td>';
                };

                echo '<td>' . $crc1 . '</td>';
                echo '<td>' . $crc2 . '</td>';
                echo '</tr>';
                echo '</table>';
            };
        } else {
            echo "Header NICHT OK (" . $header_chr . ")";
            exit;
        };

        // Funktion ermitteln und Daten ausgeben
        if ($packetType == "info") {
            if ($eid == "0001") {
                if ($value == "0") { 
                    return "OFF";
                } elseif ($value == "1") {
                    return "ON";
                } else {
                    return "ERROR";
                };
            } elseif ($eid == "0002") {
                return "HEXAPLUG-PLUS = " . $value . " Watt";
            } else {
                return "ERROR";
                exit;
            };
        };
    };
    };
};
//########################################################################################################
// Hier noch einige gesammelte Daten, die mir bei der Programmierung geholfen haben.
//########################################################################################################

//ON
//char peer0_0[] = { 0x48, 0x58, 0x30, 0x43, 0x04, 0x00, 0x00, 0x00, 0x00, 0x01, 0x01, 0x01, 0x57, 0xb6 };
//Byte       | 0-3    | 4           | 5     | 6-9                 | 10        | 11++  | n-1, n-2
//Field Name | Header | Packet Type | Flags | EID                 | Data Type | Value | CRC
//TCPDump    | "HX0C" | 0x04        | 0x00  | 0x00 0x00 0x00 0x01 | 0x01      | 0x01  | 0x57 0xb6

//OFF
//char peer0_0[] = { 0x48, 0x58, 0x30, 0x43, 0x04, 0x00, 0x00, 0x00, 0x00, 0x01, 0x01, 0x00, 0x46, 0x3f }
//Byte       | 0-3    | 4           | 5     | 6-9                 | 10        | 11++  | n-1, n-2
//Field Name | Header | Packet Type | Flags | EID                 | Data Type | Value | CRC
//TCPDump    | "HX0C" | 0x04        | 0x00  | 0x00 0x00 0x00 0x01 | 0x01      | 0x00  | 0x46 0x3f

//Status = ON
//char peer0_0[] = { 0x48, 0x58, 0x30, 0x43, 0x02, 0x00, 0x00, 0x00, 0x00, 0x01, 0xc5, 0x50 };
//char peer1_0[] = { 0x48, 0x58, 0x30, 0x43, 0x01, 0x00, 0x00, 0x00, 0x00, 0x01, 0x01, 0x01, 0xc0, 0xd7 };
//Byte       | 0-3    | 4           | 5     | 6                      | 7         | 8++ (size depending on data type of the value) | n-1, n-2
//Field Name | Header | Packet Type | Flags | EID                    | Data Type | Value                                          | CRC
//Content    | "HX0C" | 0x01        | 0x00  | 0x00 0x00 0x00 0x01    | 0x01      |  0x01                                          | 0xc0 0xd7

// STATUS = OFF
//char peer0_0[] = { 0x48, 0x58, 0x30, 0x43, 0x02, 0x00, 0x00, 0x00, 0x00, 0x01, 0xc5, 0x50 };
//char peer1_0[] = { 0x48, 0x58, 0x30, 0x43, 0x01, 0x00, 0x00, 0x00, 0x00, 0x01, 0x01, 0x00, 0xd1, 0x5e };
//Byte       | 0-3    | 4           | 5     | 6                      | 7         | 8++ (size depending on data type of the value) | n-1, n-2
//Field Name | Header | Packet Type | Flags | EID                    | Data Type | Value                                          | CRC
//Content    | "HX0C" | 0x01        | 0x00  | 0x00 0x00 0x00 0x01    | 0x01      |  0x00                                          | 0xc0 0xd7

// GET POWER
//char peer0_0[] = { 0x48, 0x58, 0x30, 0x43, 0x02, 0x00, 0x00, 0x00, 0x00, 0x02, 0xf7, 0xcb };
//Byte     | 0-3    | 4           | 5     | 6                   | 7,8
//Content  | "HX0C" | Packet Type | Flags | EID                 | CRC
//TCPDump  | "HX0C" | 0x02        | 0x00  | 0x00 0x00 0x00 0x02 | 0xf7 0xcb
//char peer1_0[] = { 0x48, 0x58, 0x30, 0x43, 0x01, 0x00, 0x00, 0x00, 0x00, 0x02, 0x03, 0x00, 0x00, 0x00, 0x20, 0xee, 0xec };
//Byte       | 0-3    | 4           | 5     | 6-9                    | 10        | 11++ (size depending on data type of the value) | n-1, n-2
//Field Name | Header | Packet Type | Flags | EID                    | Data Type | Value                                           | CRC
//Content    | "HX0C" | 0x01        | 0x00  | 0x00 0x00 0x00 0x02    | 0x03      |  0x00 0x00 0x00 0x20                            | 0xee 0xec
//                                                                                  0    0    0    32
?>