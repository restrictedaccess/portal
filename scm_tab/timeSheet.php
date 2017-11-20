<?php
    //returns json list of time record
    include('ValidateAgentUserLib.php');
    include('../time_recording/TimeRecording.php');
    include('PreviousMonthsLib.php');
    date_default_timezone_set("Asia/Manila");

    $date = $_GET['date'];
    if ($date == '') {
        $now = new DateTime();
        $date = $now->format('Y-m-d');
    }

    $months = PreviousMonths::GetPreviousMonths(12);
    $timeRecording = new TimeRecording($userid);
    $return_data = array("months" => $months, "time_sheet" => $timeRecording->GetMonthlyTimeSheet($date));

    $output = json_encode($return_data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>
