<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * User Authentification
 */
class MaMS_Users {
    /**
     * 
     */
    public function __construct() {
    }
    
    
    /**
     * Generates a secure, pseudo-random password with a safe fallback.
     * 
     * @param type $length
     * 
     * @return type
     */
    public function pseudo_rand($length) {
            if (function_exists('openssl_random_pseudo_bytes')) {
                    $is_strong = false;
                    $rand = openssl_random_pseudo_bytes($length, $is_strong);
                    if ($is_strong === true) return $rand;
            }
            $rand = '';
            $sha = '';
            for ($i = 0; $i < $length; $i++) {
                    $sha = hash('sha256', $sha . mt_rand());
                    $chr = mt_rand(0, 62);
                    $rand .= chr(hexdec($sha[$chr] . $sha[$chr + 1]));
            }
            return $rand;
    }
    
    
    /**
     * Create a Hash by salt
     * 
     * @global type $default_configuration
     * 
     * @param type $string The user submitted password
     * @param type $hash_method
     * 
     * @return type
     */
    public function create_hash($string, $hash_method = 'sha1') {
        global $default_configuration;
        $UNIQUE_SALT = $default_configuration['default_settings']['crypt_salt'];
        
        if (function_exists('hash') && in_array($hash_method, hash_algos())) {
                return hash($hash_method, $UNIQUE_SALT . $string);
        }
        
        return sha1($UNIQUE_SALT . $string);
    }
    
    
    /**
     * 
     * @global type $MaMS_SQL
     * @global type $output
     * @param type $username
     * @param type $password_hash
     */
    public function get_users($username, $password_hash) {
        global $MaMS_SQL;
        global $output;
        
        $output->debug(__FUNCTION__, "username=" . $username, "4");
        $output->debug(__FUNCTION__, "password=" . $password_hash, "4");

        // Get sql data
        $sql = "SELECT * FROM users WHERE `username` = '" . $username . "' AND `password` = '" . $password_hash . "'"
                . " LIMIT 1";
        
        $result_db = $MaMS_SQL->sql_get($sql);
        $result = array();

        while ($row = $result_db->fetch_assoc()) {
            // Add default data
            $result[] = $row;
        }
        
        return $result;
    }
    
    
    public function session_login_check() {
        global $default_configuration;
        global $output;
        
        $session = new SecureSessionHandler($default_configuration['default_settings']['session_timeout'], 'MAMS_SESSION');
        session_set_save_handler($session, true);

        if ( ! $session->isValid()) {
            echo "Session is not valid!<br>";
            session_destroy();

            $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
            $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
            $extra = "setup.php";
            header("Location: http://$host$uri/$extra");
        }

        $userdata = $this->get_users($_SESSION['username'], $_SESSION['password_hash']);
        $output->debug(__FUNCTION__, "[ARRAY] " . $output->array_output($userdata), "4");

        if (count($userdata) != 1) {
            echo "Userdata not correct from cookie!<br>";
            session_destroy();

            $host  = htmlspecialchars($_SERVER["HTTP_HOST"]);
            $uri   = rtrim(dirname(htmlspecialchars($_SERVER["PHP_SELF"])), "/\\");
            $extra = "setup.php";
            header("Location: http://$host$uri/$extra");
            
            return false;
        }
        
        return array_shift($userdata);
    }
}
