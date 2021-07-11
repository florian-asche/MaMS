<?php
################################################################################
#               Measurement and Management System - Smart Home                 #
#              Copyright (c) by Florian Asche - www.florian-asche.de           #
################################################################################

class JobDaemon {
    //http://php.find-info.ru/php/016/ch05lev1sec4.html
    //https://github.com/gothfox/Tiny-Tiny-RSS/blob/master/update_daemon2.php
    //http://squirrelshaterobots.com/programming/php/building-a-queue-server-in-php-part-4-run-as-a-background-daemon-a-k-a-forking/
    //http://php.net/manual/de/function.pcntl-fork.php
    //https://books.google.de/books?id=J_dzm6bBLkUC&pg=PA174&lpg=PA174&dq=php+usort+pcntl_signal&source=bl&ots=-WWPeLPq-E&sig=NespGiX8b4TncV0YRiTLhli1ZNQ&hl=de&sa=X&ei=uHbBVIuBDoLlUoPYg7AF&ved=0CFEQ6AEwBg#v=onepage&q=php%20usort%20pcntl_signal&f=false

    protected $currentJobs = array();
    protected $parentPID;
    protected $additionaljobs_lastrun_timestamp;
    public $master_handlers_installed = false;
    
    
    /**
     * 
     * @global type $output
     */
    public function __construct() {
        global $output;

        $output->debug(__FUNCTION__, "Loading JobDaemon...", "3");

        //Prüfen ob PHP Forks kann
        if (!function_exists('pcntl_fork')) {
            $output->debug(__FUNCTION__, "Error: PHP requires PCNTL module!", "1");
            exit(1);
        }

        // Lockfile setzen um zu verhindern, dass der daemon mehrmals läuft
        $lock_handle = $this->make_lockfile("update_daemon.lock");
        if (!$lock_handle) {
            $output->debug(__FUNCTION__, "Error: Can't create lockfile! Maybe another daemon is already running.", "1");
            exit(1);
        }

        $this->parentPID = getmypid();
        //pcntl_signal(SIGINT, array($this, "childSignalHandler"));
        declare(ticks = 1);
    }

    
    /**
     * 
     * @param type $filename
     * @return boolean
     */
    public function make_lockfile($filename) {
        $fp = fopen("$filename", "w");

        if (flock($fp, LOCK_EX | LOCK_NB)) {
            if (function_exists('posix_getpid')) {
                fwrite($fp, posix_getpid() . "\n");
            }
            return $fp;
        } else {
            return false;
        }
    }

    // 1) SIGHUP       2) SIGINT       3) SIGQUIT      4) SIGILL       5) SIGTRAP
    // 6) SIGABRT      7) SIGBUS       8) SIGFPE       9) SIGKILL     10) SIGUSR1
    // 11) SIGSEGV     12) SIGUSR2     13) SIGPIPE     14) SIGALRM     15) SIGTERM
    // 16) SIGSTKFLT   17) SIGCHLD     18) SIGCONT     19) SIGSTOP     20) SIGTSTP
    // 21) SIGTTIN     22) SIGTTOU     23) SIGURG      24) SIGXCPU     25) SIGXFSZ
    // 26) SIGVTALRM   27) SIGPROF     28) SIGWINCH    29) SIGIO       30) SIGPWR
    // 31) SIGSYS      34) SIGRTMIN    35) SIGRTMIN+1  36) SIGRTMIN+2  37) SIGRTMIN+3
    // 38) SIGRTMIN+4  39) SIGRTMIN+5  40) SIGRTMIN+6  41) SIGRTMIN+7  42) SIGRTMIN+8
    // 43) SIGRTMIN+9  44) SIGRTMIN+10 45) SIGRTMIN+11 46) SIGRTMIN+12 47) SIGRTMIN+13
    // 48) SIGRTMIN+14 49) SIGRTMIN+15 50) SIGRTMAX-14 51) SIGRTMAX-13 52) SIGRTMAX-12
    // 53) SIGRTMAX-11 54) SIGRTMAX-10 55) SIGRTMAX-9  56) SIGRTMAX-8  57) SIGRTMAX-7
    // 58) SIGRTMAX-6  59) SIGRTMAX-5  60) SIGRTMAX-4  61) SIGRTMAX-3  62) SIGRTMAX-2
    // 63) SIGRTMAX-1  64) SIGRTMAX    

    
    /**
     * 
     * @global type $output
     * @param type $signo
     * @param type $data
     * @param type $status
     * @return boolean
     */
    public function childSignalHandler($signo = null, $pid = null, $status = null) {
        global $output;

        $backup_pid = pcntl_waitpid(-1, $status, WNOHANG);
        $pid = getmypid();
        
        $output->debug(__FUNCTION__, posix_getpid() . " - " . $this->parentPID . " - " . getmypid() . " - " . $backup_pid, "4", "GREEN");
        $output->debug(__FUNCTION__, "SIGNAL: $signo for $pid with: $status received.", "3", "RED");
        
        if ($backup_pid != "-1" AND $backup_pid != "0") {
             $output->debug(__FUNCTION__, "WARNING PID IS OVERWRITTEN", "4", "YELLOW");
            $pid = $backup_pid;
        }
        
        if ($pid == $this->parentPID) {
            // MASTER
            $output->debug(__FUNCTION__, "Recieved End for pid: $pid - MASTER", "2");
        
            // End all Children peacefully
            foreach (array_keys($this->currentJobs) as $pid) {
                //$this->currentJobs[$pid];
                $output->debug(__FUNCTION__, "MASTER ENDED! END ALL CHILDREN NOW: Found running CHILDREN with pid $pid, i end it now!", "2");
                posix_kill($pid, SIGTERM);
            }

            // Remove Lockfile
            if (file_exists("update_daemon.lock")) {
                $output->debug(__FUNCTION__, "DAEMON STOP: removing lockfile...", "3");
                unlink("update_daemon.lock");
            }
            die;
        } else {
            // CHILDREN
            $output->debug(__FUNCTION__, "Recieved End for pid: $pid - CHILDREN", "2");
            unset($this->currentJobs[$pid]);
            return true;
        }
    }

    
    /**
     * 
     * @global type $output
     * @global type $default_configuration
     */
    function check_for_timeout() {
        global $output;
        global $default_configuration;

        $output->debug(__FUNCTION__, "Checking for stucked processes", "3");

        foreach (array_keys($this->currentJobs) as $pid) {
            $started = $this->currentJobs[$pid];

            if (getmicrotime() - $started > $default_configuration['daemon_settings']['job_timeout']) {
                $output->debug(__FUNCTION__, "child process $pid seems to be stuck, aborting...", "1");
                posix_kill($pid, SIGTERM);
            }
        }
    }
    
    
    /**
     * 
     * @global type $default_configuration
     * @global type $output
     */
    public function run() {
        global $default_configuration;
        global $output;

        $output->debug(__FUNCTION__, "Daemon started...", "3");

        global $MaMS_Queue;
        $MaMS_Queue->mams_remove_old_locks();
        unset($MaMS_Queue);
        
        while (true) {
            $checkpoint = getmicrotime();
            $output->debug(__FUNCTION__, "There are " . count($this->currentJobs) . " running proccesses", "2", "GREEN");

            // Die Datenbank wird mit Abfragen nur belastet, wenn nicht schon zu viele Prozesse laufen
            if (count($this->currentJobs) >= $default_configuration['daemon_settings']['maxProcesses']) {
                $output->debug(__FUNCTION__, "Maximum children allowed, waiting...", "2");
            } else {
                $output->debug(__FUNCTION__, "Time is up, run jobs now...", "2", "RED");
                $launched = $this->check_mamsdb_for_new_jobs($checkpoint);
            }
            
            $additional_jobs_intervaltime = 10;
            if (($this->additionaljobs_lastrun_timestamp + $additional_jobs_intervaltime) >= getmicrotime()) {

                // Additional operations
                $this->check_for_timeout();

                global $MaMS_Queue;
                $MaMS_Queue->mams_remove_old_locks();
                
                $this->additionaljobs_lastrun_timestamp = getmicrotime();
            }
            
            //sleep(1);
            //http://php.net/manual/de/function.usleep.php
            // Warte 2 Sekunden
            //usleep(2000000);
            usleep($default_configuration['daemon_settings']['sleeptime']);
        }
    }
    
    
    /**
     * 
     * @global type $output
     * @global type $default_configuration
     * @param type $checkpoint
     */
    public function check_mamsdb_for_new_jobs($checkpoint) {
        global $output;
        global $MaMS_Queue;
        global $default_configuration;

        $jobdatas_done = array();
        
        $daten = $MaMS_Queue->load_all_data_jobs();

        $number_of_jobs = count($daten);
        $output->debug(__FUNCTION__, "Number of jobs in database (not sceduled for execution): " . $number_of_jobs, "2");
        
        foreach ($daten as $jobdata) {
            if ($jobdata['station_protocols']['active'] == "1") {
                if ($jobdata['queue']['process_should_run'] == "1") {
                    if ((isset($jobdata['stations']['configuration']['lock_station']) and ($jobdata['stations']['configuration']['lock_station'] == "1") and $jobdata['queue_lock_status'] == "0") 
                    or !isset($jobdata['stations']['configuration']['lock_station']) 
                    or (isset($jobdata['stations']['configuration']['lock_station']) and ($jobdata['stations']['configuration']['lock_station'] == "0"))) {
                        if (isset($jobdata['station_protocols']['class']) and $jobdata['station_protocols']['class'] != "") {
                            if (isset($jobdata['queue']['function']) and $jobdata['queue']['function'] != "") {
                                // In dieser Schleife werden unendlich viele Subprozesse geöffnet. Damit das gesetzte Limit nicht überschritten wird, hier eine Prüfung
                                if (count($this->currentJobs) < $default_configuration['daemon_settings']['maxProcesses']) {
                                    // Nochmal auf lock checken, da der oben geprüfte status nur schleifen aktuell ist, und nicht die in dieser schleife ausgeführten prozesse beachtet
                                    if ((isset($jobdata['stations']['configuration']['lock_station']) and ($jobdata['stations']['configuration']['lock_station'] == "1") and $MaMS_Queue->mams_check_lock($jobdata['station_protocols']['stations_ID']) == "0") 
                                    or !isset($jobdata['stations']['configuration']['lock_station']) 
                                    or (isset($jobdata['stations']['configuration']['lock_station']) and ($jobdata['stations']['configuration']['lock_station'] == "0"))) {

                                        // DEBUG OUTPUT
                                        $output->debug(__FUNCTION__, "[QUEUE-WORKER] checkpoint=" . $checkpoint, "4");
                                        $output->debug(__FUNCTION__, "[QUEUE-WORKER] jobdata=" . $output->array_output($jobdata), "4");
                                        $output->debug(__FUNCTION__, "[JOBDATA] " . $output->array_output($jobdata), "4", "GREEN");
                                        
                                        // ADD LOCK
                                        // Der lock Eintrag wird in der Hauptschleife ausgeführt, damit die nachfolgenden Prozesse wissen,
                                        //  welche Station gerade verwendet und gesperrt ist.
                                        if (isset($jobdata['stations']['configuration']['lock_station'])) {
                                            if ($jobdata['stations']['configuration']['lock_station'] >= "1") {
                                                $RC_add = $MaMS_Queue->mams_add_lock($jobdata['station_protocols']['stations_ID'], $jobdata['queue']['station_protocols_ID']);
                                                //$RC_add = "0";
                                                if ($RC_add != "0") {
                                                    $output->debug(__FUNCTION__, "ADD LOCK FAILED", "1");
                                                    exit(1);
                                                }
                                            }
                                        }
                                        
                                        // LAUNCH JOB
                                        $this->launchJob($checkpoint, $jobdata);
                                    } else {
                                        $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " station is locked", "4");
                                    }
                                } else {
                                    $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " max prozess is reached", "4");
                                }
                            } else {
                                $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " missing function", "4");
                            }
                        } else {
                            $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " missing class", "4");
                        }
                    } else {
                        $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " job is on lock mode", "4");
                    }
                } else {
                    $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " job should not run now", "4");
                }
            } else {
                $output->debug(__FUNCTION__, $jobdata['queue']['ID'] . " station_protocols deactivated", "4");
            }
        }
    }
    
    
    /**
     * 
     * @global type $output
     * @global type $default_configuration
     * @global type $MaMS_Queue
     * @param type $checkpoint
     * @param type $jobdata
     * @return boolean
     */
    protected function launchJob($checkpoint, $jobdata) {
        global $output;
        global $default_configuration;
        global $MaMS_Queue;

        $output->debug(__FUNCTION__, "Try to launch new job with ID=" . $jobdata['station_protocols']['ID'], "2");

        $pid = pcntl_fork();
        if ($pid == -1) {
            //Problem launching the job
            error_log('Could not launch new job, exiting');
            posix_kill($this->parentPID, SIGTERM);
            //return false;
        } else if ($pid) {
            // Parent process
            $output->debug(__FUNCTION__, "This is the master fork", "3");
            // Sometimes you can receive a signal to the childSignalHandler function before this code executes if
            // the child script executes quickly enough!
            $this->currentJobs[$pid] = $checkpoint;

            // INSTALL MASTER HANDLER
            if (!$this->master_handlers_installed) {
                $output->debug(__FUNCTION__, "Master: installing shutdown handlers", "2");
                pcntl_signal(SIGTERM, array($this, "childSignalHandler"));
                pcntl_signal(SIGCHLD, array($this, "childSignalHandler"));
                pcntl_signal(SIGINT, array($this, "childSignalHandler"));
                $this->master_handlers_installed = true;
            }
            
        } else {
            // Forked child, do your deeds....

            $output->debug(__FUNCTION__, "This is the children fork", "3");
            
            $sid = posix_setsid();
       
            if ($sid < 0) {
                $output->debug(__FUNCTION__, "ERROR! setSID IS NOT CORRECT", "1", "RED");
                exit(1);
            }
            
            $exitStatus = $MaMS_Queue->run_mams_job($checkpoint, $jobdata);

            // Debug
//            $exitStatus = "0";
//            sleep(5);
            
            $output->debug(__FUNCTION__, "GLOBAL JOB RC=" . $exitStatus);
            exit($exitStatus);
        }
        return true;
    }
}