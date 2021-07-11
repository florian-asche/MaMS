<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################


/**
 * 
 */
class MaMS_SQL {
    /**
     * 
     */
    public function __construct() {
        // Check if mySQL database connect is succsessfull
        global $output;
        global $host, $benutzer, $passwort, $dbname;
        
        $output->debug(__FUNCTION__, "Host=" . $host . " Username=" . $benutzer . " Password=" . $passwort . " Dbname=" . $dbname, "4");
        
        // Init connection
        /* add an @ sign like so to suppress warning / error messages, then do the error once your own */
        $output->debug(__FUNCTION__, "Check if mySQL connection is working...", "4");
        $linki = @new mysqli($host, $benutzer, $passwort, $dbname);
        
        // Check initialisation
        $output->debug(__FUNCTION__, "Connect RC=" . mysqli_connect_errno(), "4");
        if ($linki->connect_errno) {
            $output->debug(__FUNCTION__, "Connect failed: " . mysqli_connect_error(), "1");
            exit(1);
        }
        
        // check if server is alive
        if (!$linki->ping()) {
            $output->debug(__FUNCTION__, "ping failed: " . $linki->error, "1");
            exit(1);
        } else {
            $output->debug(__FUNCTION__, "ping OK", "4");
        }
        
        // End connection
        $linki->close();
    }
    
    
    /**
     * 
     * @param type $sqlchange
     * @return int
     */
    function sql_commit($sqlchange) {
        // Die Datenbankverbindung muss hier fest angegeben werden weil das mit Forks nicht funktioniert
        // Siehe http://www.electrictoolbox.com/mysql-connection-php-fork/
        
        global $output;
        global $host, $benutzer, $passwort, $dbname;
        
        // Init connection
        $linki = new mysqli($host, $benutzer, $passwort, $dbname);
        
        $output->debug(__FUNCTION__, "Host=" . $host . " Username=" . $benutzer . " Password=" . $passwort . " Dbname=" . $dbname, "4");
        
        // Check initialisation
        if ($linki->connect_errno) {
            $output->debug(__FUNCTION__, "Connect RC=" . mysqli_connect_errno(), "3");
            $output->debug(__FUNCTION__, "Connect failed: " . mysqli_connect_error(), "1");
        }

        // Do sql commit
        $sql_commit_RC = mysqli_query($linki, $sqlchange);
          
        // Check commit returncode
        if ($sql_commit_RC) {
            return 0;
        } else {
            $output->debug(__FUNCTION__, "Commit RC=" . $sql_commit_RC, "3");
            $output->debug(__FUNCTION__, "Connect failed: " . mysqli_error($linki), "1");
            return 1;
        }
        
        // End connection
        $linki->close();
    }
    
    
    /**
     * 
     * @global type $output
     * @global type $host
     * @global type $benutzer
     * @global type $passwort
     * @global type $dbname
     * @param type $sql
     * @return type
     */
    public function sql_get($sql) {
        global $output;
        global $host, $benutzer, $passwort, $dbname;
        
        // Init connection
        $linki = new mysqli($host, $benutzer, $passwort, $dbname);
        
        $output->debug(__FUNCTION__, "Host=" . $host . " Username=" . $benutzer . " Password=" . $passwort . " Dbname=" . $dbname, "4");
        
        // Check initialisation
        if ($linki->connect_errno) {
            $output->debug(__FUNCTION__, "Connect RC=" . mysqli_connect_errno(), "3");
            $output->debug(__FUNCTION__, "Connect failed: " . mysqli_connect_error(), "1");
        }
        
        // Get result
        $result_db = $linki->query($sql);

        // Check get returncode
        if (!$result_db) {
            $output->debug(__FUNCTION__, "Commit RC=" . $result_db, "3");
            $output->debug(__FUNCTION__, "Connect failed: " . mysqli_error($linki), "1");
            return 1;
        }
        
        // End connection
        $linki->close();
        
        // Return result
        return($result_db);
    }
}