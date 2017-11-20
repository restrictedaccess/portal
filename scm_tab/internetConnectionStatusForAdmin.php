<?php
    //returns json list of time record
    define (SECONDS_IDLE_LIMIT, 180);
    include('../conf.php');
    include('InternetConnectionStatusLib.php');
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
    $days_to_report = array();
    for ($i = 0; $i < $x; $i++) {
        $date_clone = clone($reference_date);
        $days_to_report[] = $date_clone;
        $reference_date->modify('-1 days');
    }

    $internet_connection_data = array();
    forEach($days_to_report as $date_desired) {
        $internet_connection_status = new InternetConnectionStatus($userid, 'subcon', $date_desired, SECONDS_IDLE_LIMIT);
        $idle_list = $internet_connection_status->GetIdleTime();
        if (count($idle_list) != 0) {
            $internet_connection_data[] = array('date' => $date_desired->format('D d/m'), 'idle_time_list' => $idle_list);
        }
    }

    $months = PreviousMonths::GetPreviousMonths(12);
    $return_data = array('months' => $months, 'internet_connection_data' => $internet_connection_data);

    $output = json_encode($return_data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>
