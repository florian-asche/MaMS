<?php

// NOTE: I added tons of comments since I was using this to learn about Sessions and SessionHandlers

/** class SecureSessionHandler extends SessionHandler
 *
 *  This class is based on Eddleman's SecureSessionHandler,
 *      https://gist.github.com/eddmann/10262795
 *  but rearranged to use the SessionHandler interface so that
 *  session_start() and session_destroy() can be called,
 *  instead of the notation $session->start() and $session->destroy()
 *
 *  I have also removed the put() and get() functions since I was
 *  focusing on session handling and security, not how the data was
 *  arranged inside the session.
 *
 *  ** There is some example usage code at the end of this file **
 */

/**
 * session_start()
 *  calls: open() read()
 *
 * session_destroy()
 *  calls: destroy()
 *
 * closing a session
 *  calls: write() close()
 *
 */
 
class SecureSessionHandler extends SessionHandler {
    
    protected $key, $name, $cookie;

    /** __construct()
     *
     *  @param string $key      key to use for encrypting session file data
     *  @param string $name     session name
     *  @param array $cookie    cookie parameter overrides
     */
    public function __construct($key, $name = 'MAMS-SESSION', $cookie = [])
    {
        // Check for right php version
        if (version_compare(phpversion(), '5.4.0', '<')) {
            // php version isn't high enough
            echo "PHP VERSION TO LOW";
        }
        
        $this->key = $key;
        $this->name = $name;
        $this->cookie = $cookie;

        /** Cookie lifetime notes
         * 
         * cookie lifetime is not used except when deleting cookie in destroy().
         * Instead a server-side session data variable is used to determine if the session has expired
         *  
         * lifetime = 0 means the cookie will not expire until the browser is closed
         **/
        
        $this->cookie += [
            'lifetime' => 0, 
            'path'     => ini_get('session.cookie_path'),
            'domain'   => ini_get('session.cookie_domain'),
            'secure'   => isset($_SERVER['HTTPS']),
            'httponly' => true
        ];
        
        /** PHP + array operator
         *
         * The + operator returns the right-hand array appended to the left-hand array;
         * for keys that exist in both arrays, the elements from the left-hand array will
         * be used, and the matching elements from the right-hand array will be ignored.
         *
         * This means that the parameters from $cookie will override the defaults listed
         * in this contructor.
         */

        $this->setup();
    }

    /** setup()
     *
     *  Setup session & php ini settings
     */
    private function setup()
    {
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.save_handler', 'files');
        //ini_set('session.save_handler', 'user');
        //session_set_save_handler($session, true);
        //session_save_path(__DIR__ . '/../sessions'); // careful
        //session_save_path(__DIR__ . '/sessions');

        session_name($this->name);

        session_set_cookie_params(
            $this->cookie['lifetime'],
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );
        
        session_start();
    }

    /*---------------------------------------
     *      SessionHandler Interface
     *---------------------------------------*/
    
    /** close()
     *  closes the session file & current session.
     */
    public function close(){
        return parent::close(); 
    }
    
    /** destroy()
     *  called when session_destroy() is called
     *
     *  Empties local session data
     *  Unsets cookie by making it expired
     */
    public function destroy($session_id)
    {
        if ($session_id === '') {
            return false;
        }

        $_SESSION = [];

        // are all of these options necessary when destroying it?
        setcookie(
            $this->name,
            null,
            time() - 42000,
            $this->cookie['path'],
            $this->cookie['domain'],
            $this->cookie['secure'],
            $this->cookie['httponly']
        );

        return parent::destroy($session_id);
    }


    /** open
     *  called when session_start() is called
     *
     *  Opens file with session_id as the ending of the filename. Example:
     *          sess_uivrkk2c5ksnv2hnt5rc8tvgi5
     *
     *  We probably really want this different from what's on the cookie - the point is
     *  to make it so someone who can see into the tmp directory can't just login
     *  with anyone's session_id.
     *
     *  A fingerprint might also help with this.  See the notes on
     *  isFingerprint()
     */
    public function open($save_path, $session_id)
    {
        //error_log('save_path '.$save_path,0);
        //error_log('crypt test '. 'sess_' . $this->gen_filehash($session_id, $this->getFingerprintHash()),0);
        return parent::open($save_path, $session_id);
    }
    
    /** read()
     *  called when session_start() is called
     *
     *  Reads the session file, normally called in session_start().
     */
    public function read($session_id)
    {
        // return mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($session_id), MCRYPT_MODE_ECB);
        // return parent::read($session_id);
    
            $_success = mcrypt_decrypt(MCRYPT_3DES, $this->key, parent::read($session_id), MCRYPT_MODE_ECB);
            //$_success = parent::read($session_id);
            
            // occasionally regenerate sesson id to help prevent session fixation
            //error_log('session_id_before '.session_id(),0);
            if (mt_rand(0, 4) === 0) {
                $this->refresh();
            }
            //error_log('session_id_after '.session_id(),0);
        
            return $_success;
    }

    /** write()
     *  called just before session is closed
     *
     *  Writes to the current session file
     */
    public function write($session_id, $session_data)
    {
        return parent::write($session_id, mcrypt_encrypt(MCRYPT_3DES, $this->key, $session_data, MCRYPT_MODE_ECB));
        //return parent::write($session_id, $session_data);
    }
    
    /*---------------------------------------
     *      End SessionHandler Interface
     *---------------------------------------*/
    
    /** refresh()
     *
     *  Regenerate the session id
     */
    public function refresh()
    {
        return session_regenerate_id(true);
    }

    /** Temporary Functions
     *
     * These two are temporary functions I'm using to
     * experiment with methods of generating filenames for sessions
     *
     * Speed might also be an issue here
     */
    private function sanitize_hash($hash){
        return filter_var($hash, FILTER_CALLBACK, ['options' => function($hash) {
            return preg_replace('/[^a-zA-Z0-9$\/.]/', '', $hash);
        }]);
    }
    private function gen_filehash($text,$salt,$len=40){
        return $this->substr(sanitize_hash(password_hash($text,PASSWORD_BCRYPT,['salt'=>$salt])),0,40);
    }
    

    /** isExpired()
     *
     *  Checks to see if session has expired
     *  If not, it refeshes the time of last activity
     *
     *  DOES NOT set or check the cookie lifetime,
     *  instead it uses an internal session variable
     *
     */
    public function isExpired()
    {
        global $default_configuration;
        global $output;
        
        $ttl = $default_configuration['default_settings']['session_timeout'];
        
        if (isset($_SESSION['_last_activity'])) {
            $last = $_SESSION['_last_activity'];
        } else {
            $last = false;
        }

        $output->debug(__FUNCTION__, "last timestamp =" . $last, "4");
        
        if ($last !== false) {
            $output->debug(__FUNCTION__, (time() - $last) . ">" . ($ttl * 6), "4");
        }
        
        if ($last !== false && time() - $last > $ttl) {
            return true;
        }

        $_SESSION['_last_activity'] = time();

        return false;
    }
    
    /** getFingerprintHash()
     *
     *  Generates a fingerprint from HTTP_USER_AGENT
     *  and IP address using md5
     *
     *  Beware - setting the hash to depend on IP
     *  can cause session loss on mobile or corporate networks.
     *
     *  Also, there may be an IPv4 vs IPv6 issue here
     *  $this->cookie
     *  According to a post at security.stackexchange, MD5
     *  is easily breakable  (though it generates a nice friendly string).
     */
    public function getFingerprintHash()
    {
        return md5(
            $_SERVER['HTTP_USER_AGENT'] .
            (ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0'))
        );
    }

    /** isFingerprint()
     *
     *  Checks current fingerprint against fingerprint stored in session file / data
     *
     *  The fingerprint can stop the problem of the session file name including
     *  the session id - someone would also have to be able to decrypt the file
     *  to be able to get the fingerprint.
     *
     *  However, this Fingerprint is dependent only on the getFingerprintHash()
     *  function, which gets the fingerprint from the HTTP_USER_AGENT and IP address.
     *
     *  I suspect this would be a problem:
     *  If you get rid of the IP address all someone has to do is try a variety of
     *  common HTTP_USER_AGENTS, and eventually one will match.
     */
    public function isFingerprint()
    {
        $hash = $this->getFingerprintHash();

        if (isset($_SESSION['_fingerprint'])) {
            return $_SESSION['_fingerprint'] === $hash;
        }

        $_SESSION['_fingerprint'] = $hash;

        return true;
    }
    
    /** isValid()
     *
     *  Checks to see if current session is valid -
     *  if it has expired or if the fingerprints don't match.
     */
    public function isValid()
    {
        return ! $this->isExpired() && $this->isFingerprint();
    }

}/* end SecureSessionHandler */
?>