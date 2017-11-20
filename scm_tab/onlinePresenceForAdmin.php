<?php
    //2009-05-04 Lawrence Sunglao <locsunglao@yahoo.com>
    //  removed dependency on rowCount
    //requires $_GET['userid'] and $_SESSION['agent_no'] parameter
    include ('../conf.php');
    include('PreviousMonthsLib.php');
    date_default_timezone_set("Asia/Manila");

    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    $userid = $_GET['userid'];
    if (($userid == null) or ($userid == '')){
        die('Invalid user id');
    }


    /**
     *
     * object for collecting Online Presence
     *
     * @author		Lawrence Sunglao <locsunglao@yahoo.com>
     */
    class OnlinePresence {
        /**
        *
        * Initialize
        *
        */
        private $online_presence;
        function __construct($userid, $user_type, $date) {
            global $dbserver, $dbname, $dbuser, $dbpwd;

            try {
                $this->dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
            } catch (PDOException $exception) {
                die("Connection error: " . $exception->getMessage());
            }


            $this->tz_au = new DateTimeZone('Australia/Sydney');

            $start_date_obj = clone($date);
            $start_date = $start_date_obj->format('Y-m-d');
            $end_date_obj = clone($date);
            $end_date_obj->modify('+1 days');
            $end_date = $end_date_obj->format('Y-m-d');
            $query = "select expected_time, checked_in_time from online_presence_log where userid = $userid and user_type = '$user_type' and mode='presence' and expected_time BETWEEN '$start_date' and '$end_date' order by expected_time";
            $data = $this->dbh->query($query);
            $this->online_presence = array();
            forEach($data->fetchAll() as $row) {
                $expected_time = new DateTime($row['expected_time']);

                //if expected_time falls in between lunch, use the time_out of the lunch instead
                $expected_time_str = $expected_time->format('Y-m-d H:i:s');
                $query_between_lunch = "select time_out from timerecord where mode = 'lunch_break' and time_in <= '$expected_time_str' and time_out >= '$expected_time_str' and userid = $userid";
                $data_in_between_lunch = $this->dbh->query($query_between_lunch)->fetchAll();
                if (count($data_in_between_lunch) != 0) {
                    $time_out = $data_in_between_lunch[0];
                    $expected_time = new DateTime($time_out['time_out']);
                    $expected_time_str = $time_out['time_out'];
                }

                $checked_in_time = new DateTime($row['checked_in_time']);
                $seconds_difference = $checked_in_time->format('U') - $expected_time->format('U');
                $expected_time_ph = $this->FormatPHTZ($expected_time_str);
                $expected_time_au = $this->FormatAUTZ($expected_time_str);
                $checked_in_time_ph = $this->FormatPHTZ($row['checked_in_time']);
                $checked_in_time_au = $this->FormatAUTZ($row['checked_in_time']);
                $this->online_presence[] = array('expected_time_ph' => $expected_time_ph, 
                    'expected_time_au' => $expected_time_au,
                    'checked_in_time_ph' => $checked_in_time_ph, 
                    'checked_in_time_au' => $checked_in_time_au,
                    'seconds_difference' => $seconds_difference);
            }
        }

        private function FormatPHTZ($str_date) {
            $date = new DateTime($str_date);
            return $date->format('h:i a ') . ' ph';
        }

        private function FormatAUTZ($str_date) {
            $date = new DateTime($str_date);
            $date->SetTimeZone($this->tz_au);
            return $date->format('h:i a ') . ' au';
        }

        /**
        *
        * returns a list
        *
        * @return   list
        * @access	public
        */
        function GetOnlinePresence() {
            return $this->online_presence;
        }
    }   //end of OnlinePresenceClass
    

    $date = $_GET['date'];
    if ($date == '') {
        $reference_date = new DateTime();
    }
    else {
        $reference_date = new DateTime($date);
    }

    $year = $reference_date->format('Y');
    $month = $reference_date->format('m');

    //start with the 1st day
    $reference_date_str = $reference_date->format('Y-m-01');
    //reassign reference_date
    $reference_date = new DateTime($reference_date_str);
    //get number of days
    $x = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    //start with the last day of the month
    $y = $x-1;
    $reference_date->modify("+$y days");

    //days to report
    $online_presence_data = array();
    $days_to_report = array();
    for ($i = 0; $i < $x; $i++) {
        $date_clone = clone($reference_date);
        $days_to_report[] = $date_clone;

        $online_presence_obj = new OnlinePresence($userid, 'subcon', $date_clone);
        $online_presence = $online_presence_obj->GetOnlinePresence();
        if (count($online_presence) != 0) {
            $online_presence_data[] = array('date'=> $date_clone->format('D d/m'), 'online_presence' => $online_presence);
        }

        $reference_date->modify('-1 days');
    }

    $months = PreviousMonths::GetPreviousMonths(12);
    $return_data = array("months" => $months, "online_presence_data" => $online_presence_data);

    $output = json_encode($return_data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>
