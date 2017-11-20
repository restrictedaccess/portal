<?php
    //returns json list of time record
    include('ValidateClientUserLib.php');
    include('../time_recording/TimeRecording.php');
    require_once("../lib/Smarty/libs/Smarty.class.php");
    include('PreviousMonthsLib.php');

    date_default_timezone_set("Asia/Manila");

    $date = $_GET['date'];
    if ($date == '') {
        $now = new DateTime();
        $date = $now->format('Y-m-d');
        $show_month_list = True;
    }
    else {
        $show_month_list = False;
    }

    $leads_id = $_SESSION['client_id'];

    $month_options = PreviousMonths::GetPreviousMonths(12);
    $timeRecording = new TimeRecording($userid);

    $smarty = new Smarty();
    $smarty->assign('month_options', $month_options);
    $smarty->assign('time_records', $timeRecording->GetMonthlyTimeSheetForClient($date, $leads_id));
    $smarty->assign('show_month_list', $show_month_list);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    $smarty->display('timeSheetForClient.tpl');
?>
