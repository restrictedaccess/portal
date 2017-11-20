<?php
    //2008-10-07 Lawrence Sunglao <locsunglao@yahoo.com>
    //  display only the online presence log for the current client

    include ('../conf.php');
    include('ValidateClientUserLib.php');
    include('PreviousMonthsLib.php');
    date_default_timezone_set("Asia/Manila");
    $leads_id = $_SESSION['client_id'];

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
        private $dbh;
        private $online_presence;
        function __construct($userid, $user_type, $date) {
            global $dbh, $leads_id;
            $this->dbh = $dbh;

            $this->tz_au = new DateTimeZone('Australia/Sydney');

            $start_date_obj = clone($date);
            $start_date = $start_date_obj->format('Y-m-d');
            $end_date_obj = clone($date);
            $end_date_obj->modify('+1 days');
            $end_date = $end_date_obj->format('Y-m-d');
            $query = "select expected_time, checked_in_time from online_presence_log where userid = $userid and user_type = '$user_type' and mode='presence' and expected_time BETWEEN '$start_date' and '$end_date' and leads_id = $leads_id order by expected_time";
            $data = $this->dbh->query($query);
            $this->online_presence = array();
            forEach($data->fetchAll() as $row) {
                $expected_time = new DateTime($row['expected_time']);
                $checked_in_time = new DateTime($row['checked_in_time']);
                $seconds_difference = $checked_in_time->format('U') - $expected_time->format('U');
                $expected_time_ph = $this->FormatPHTZ($row['expected_time']);
                $expected_time_au = $this->FormatAUTZ($row['expected_time']);
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
