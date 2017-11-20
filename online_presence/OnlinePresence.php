<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependency on rowCount
    //2008-10-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  added a field for leads_id in online_presence_log table to separate clients view
    //include_once("../conf.php");
    //include_once("../time_recording/TimeRecording.php");
    date_default_timezone_set("Asia/Manila");

    try {
        $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
        die();
    }


    /**
     *
     * Updates the online_presence_log table
     *
     * @author		Lawrence Oliver Sunglao<locsunglao@yahoo.com>
     * @copyright	(c) 2008 by Lawrence Oliver Sunglao
     * @version		$Id$
     * @package		Package
     * @subpackage	SubPackage
     * @see			??
     */
    class OnlinePresence{
        const INTERVAL = '90 mins';

        /**
        *
        * constructor
        *
        * This is the long description for the Class
        *
        * @return	mixed	 Description
        * @access	private
        * @see		??
        */
        function __construct($user_id, $user_type) {
            $this->userid = $user_id;
            $this->user_type = $user_type;
            $this->table_name = 'online_presence_log';
            $this->tz_ph = new DateTimeZone('Asia/Manila');
            $this->now_date_time = new DateTime();
            $this->now_str = $this->now_date_time->format('Y-m-d H:i:s');
        }

        /**
        *
        * logs in the user
        *
        * Used twice when user logs in to the system and when user starts work
        *
        * @return	mixed	 Description
        * @access	public
        * @see		??
        */
        function logIn($leads_id = null){
            global $dbh;
            if ($leads_id) {
                $query = "INSERT INTO $this->table_name(userid, leads_id, user_type, expected_time, checked_in_time, mode) VALUES($this->userid, $leads_id, '$this->user_type', '$this->now_str', '$this->now_str', 'login')";
            }
            else {
                $query = "INSERT INTO $this->table_name(userid, user_type, expected_time, checked_in_time, mode) VALUES($this->userid, '$this->user_type', '$this->now_str', '$this->now_str', 'login')";
            }
            $dbh->exec($query);
        }

        function logOut($leads_id = null){
            global $dbh;
            if ($leads_id) {
                $query = "INSERT INTO $this->table_name(userid, leads_id, user_type, expected_time, checked_in_time, mode) VALUES($this->userid, $leads_id, '$this->user_type', '$this->now_str', '$this->now_str', 'logout')";
            }
            else {
                $query = "INSERT INTO $this->table_name(userid, user_type, expected_time, checked_in_time, mode) VALUES($this->userid, '$this->user_type', '$this->now_str', '$this->now_str', 'logout')";
            }
            $dbh->exec($query);
        }

        /**
        *
        * logs the presence
        *
        * Used twice when user logs out to the system and when user finishes work
        *
        * @return	none	 otherwise returns a message
        * @access	public
        * @see		??
        */
        /*
        function logPresence(){
            global $dbh;
            $time_recording = new TimeRecording($this->userid);
            $expected_time_obj = self::getNextLoginTime();
            $expected_time = $expected_time_obj->format('Y-m-d H:i:s');

            //do not add record if expected_time is greater than current time
            $now = time();
            if ($expected_time_obj->format('U') > $now) {
                return "Too early to log presence...";
            }

            //do not add record if previous expected_time exists
            $query = "SELECT expected_time from $this->table_name where expected_time >= '$expected_time' and userid = '$this->userid'";
            $result = $dbh->query($query)->fetchAll();
            if (count($result) != 0) {
                return "Previous record exists.";
            }

            //insert record
            $leads_id = $time_recording->GetCurrentLeadsID();
            $query = "INSERT INTO $this->table_name(userid, leads_id, user_type, expected_time, checked_in_time, mode) VALUES($this->userid, $leads_id, '$this->user_type', '$expected_time', '$this->now_str', 'presence')";
            $dbh->exec($query);
            return "Presence confirmed.";
        }
        */

        /**
        *
        * returns a DateTime Object as to when is the next login
        *
        * This is the long description for the Class
        *
        * @return	DateTime	 Description
        * @access	public
        * @see		??
        */
        /*
        function getNextLoginTime(){
            global $dbh;
            //check if user is out to lunch
            $time_recording = new TimeRecording($this->userid);
            $buttons = $time_recording->GetButtons();
            if ($buttons['lunch_end']) {
                return "At lunch.";
            }

            if ($buttons['work_start']) {
                return "Not yet working.";
            }

            $query = "SELECT max(checked_in_time) from $this->table_name where userid = $this->userid and user_type = '$this->user_type'";
            $result = $dbh->query($query)->fetchAll();

            //no record found, return Not logged in
            if (count($result) == 0) {
                return "Not logged in? Please re-login.";
            }

            $last_checked_in_time = new DateTime($result->fetchColumn(0));
            $last_checked_in_time_unix = $last_checked_in_time->format('U');
            
            //last checked in time greater than current time bail out
            $now = new DateTime();
            $now_unix = $now->format('U');
            if ($last_checked_in_time_unix > $now_unix) {
                return 'Inconsistent Data, please report it to the admin.';
            }
            
            $last_checked_in_time->modify('+' . self::INTERVAL);

            //add the interval if its in between User Lunch
            $next_login_time = $this->ProcessInBetweenUserLunch($last_checked_in_time);

            return $next_login_time;
        }
        */


        /**
        *
        * returns the time in seconds from expected time presence to current time
        *
        * This is the long description for the Class
        *
        * @return	integer	 unix time difference
        * @access	public
        * @see		??
        */
        function getTimeSpanFromExpectedPresenceTime(){
            $now = time();
            $expected_time = $this->getNextLoginTime()->format('U');
            $time_span = $now - $expected_time;
            return $time_span;
        }


        /**
        *
        * @return	boolean
        * @access	public
        * @see		??
        */
        function ProcessInBetweenUserLunch($last_checked_in_time) {
            global $dbh;
            $last_checked_in_time_str = $last_checked_in_time->format('Y-m-d H:i:s');
            $query = "SELECT time_in, time_out from timerecord where userid=$this->userid and mode='lunch_break' and time_in >= '$last_checked_in_time_str' and time_out <= '$last_checked_in_time_str'";
            $result = $dbh->query($query)->fetchAll();

            if (count($result) == 0) {
                return $last_checked_in_time;
            }
            else {
                list($time_in_str, $time_out_str) = $result[0];
                $time_in = new DateTime($time_in_str);
                $time_out = new DateTime($time_out_str);
                //subtract $last_checked_in_time;
                $seconds_after_time_in = $time_in->format('U') - $last_checked_in_time->format('U');
                $time_after_lunch = $time_out->modify("+$seconds_after_time_in seconds");
                return $time_after_lunch;
            }

        }

    }


?><?php
##~    session_start();
##~    $presence = new OnlinePresence(6, 'subcon');
##~    $presence->logIn();
##~    echo $presence->logPresence();
##~    $presence->logOut();

##~    echo $presence->getNextLoginTime()->format('Y-m-d H:i:s');
##~    $ph_tz = new DateTimeZone('Asia/Manila');
##~    echo $presence->getNextLoginTime()->setTimezone($ph_tz);
    
##~    echo $presence->getTimeSpanFromExpectedPresenceTime();

##~    $presence->getNextLoginTime();
##~    echo $presence->getNextLoginTime()->format('Y-m-d H:i:s');

##~    $presence = new SubConOnlinePresence;
##~    echo $presence->getTimeSpanFromExpectedPresenceTime();
?>
