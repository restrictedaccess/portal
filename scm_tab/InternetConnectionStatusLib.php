<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    // removed dependency on rowCount
    include_once("../conf.php");
    /**
     *
     * Library used to get internet connection idle time
     *
     * refers to internet_connection_status_log table, must consider lunch period also
     *
     * @author		Lawrence Sunglao <locsunglao@yahoo.com>
     * @version		$Id$
     * @package		Package
     * @subpackage	SubPackage
     * @see			??
     */
    class InternetConnectionStatus {
        /**
        *
        * initialize object, requires userid, desired_date, seconds_idle
        *
        * seconds_idle compares to the previous time, if its greater, append it to idle_time
        *
        * @return	none
        */
        private $dbh;
        private $idle_time = array();   //would contain last_post_time, seconds_idle
        private $userid;
        private $user_type;
        private $tz_au;
        function __construct($userid, $user_type, $desired_date, $seconds_idle_limit) {
            global $dbserver, $dbname, $dbuser, $dbpwd;
            $this->tz_au = new DateTimeZone('Australia/Sydney');
            $this->userid = $userid;
            $this->user_type = $user_type;
            
            try {
                $this->dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
            } catch (PDOException $exception) {
                die("Connection error: " . $exception->getMessage());
            }

            $start_date = new DateTime($desired_date->format('Y-m-d'));
            $end_date = new DateTime($desired_date->format('Y-m-d'));
            $end_date->modify('+1 days');

            $start_date_str = $start_date->format('Y-m-d');
            $end_date_str = $end_date->format('Y-m-d');

            //query table
            $query = "select post_time from internet_connection_status_log where userid = $this->userid and user_type = '$this->user_type' and post_time BETWEEN '$start_date_str' and '$end_date_str' order by post_time";
            $data = $this->dbh->query($query);
            $prev_post_time_str = null;
            forEach ($data->fetchAll() as $row) {
                if ($prev_post_time_str == null) {  //initial prev post time
                    $prev_post_time_str = $row['post_time'];
                }

                $post_time = new DateTime($row['post_time']);
                $prev_post_time = new DateTime($prev_post_time_str);
                $seconds_gap =  $post_time->format('U') - $prev_post_time->format('U');
                $prev_post_time_str = $row['post_time'];

                if ($seconds_gap >= $seconds_idle_limit) {
                    //check if $post_time is under lunch_break
                    if ($this->GetUserAtLunch($post_time, $prev_post_time) == false) {
                        $post_time_au = clone($post_time);
                        $post_time_au->SetTimeZone($this->tz_au);
                        $this->idle_time[] = array('last_post_time_ph' => $post_time->format('h:i a ') . 'ph', 'last_post_time_au' => $post_time_au->format('h:i a ') . 'au','seconds_idle' => $seconds_gap);
                    }
                }
            }
        }


        /**
        *
        * returns an array of idle time
        *
        * @return	mixed	 post_time, idle_seconds
        * @access	public
        * @see		??
        */
        function GetIdleTime() {
            return $this->idle_time;
        }

        /**
        *
        * check if the given time is between lunch of the user
        *
        * refer to timerecord table
        *
        * @return	boolean
        * @access   private	
        */
        private function GetUserAtLunch($date_time, $prev_post_time) {
            //query timerecord table
            $date_time_str = $date_time->format('Y-m-d H:i:s');
            $prev_post_time_str = $prev_post_time->format('Y-m-d H:i:s');
            $query = "select id from timerecord where userid = $this->userid and mode='lunch_break' and time_in >= '$prev_post_time_str' and time_out <= '$date_time_str'";
            $lunch_records = $this->dbh->query($query)->fetchAll();
            if (count($lunch_records) == 0) {
                return false;
            }
            else {
                return true;
            }
        }
    }
?><?
//    $now = new DateTime();
//    $internet_conn_stat = new InternetConnectionStatus(6, 'subcon', $now, 180);
//    echo json_encode($internet_conn_stat->GetIdleTime());
?>
