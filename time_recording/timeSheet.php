<?php
    //2008-08-13 Lawrence Sunglao <locsunglao@yahoo.com>
    //  - modify to show whole months time record
    //  - make it an html snippet rather than json
    //returns json list of time record
    ini_set("include_path",  ".:../lib");
    require_once("../lib/Smarty/libs/Smarty.class.php");
    include_once('../conf.php');
    include_once('../scm_tab/PreviousMonthsLib.php');
    date_default_timezone_set("Asia/Manila");

    $userid = $_SESSION['userid'];
    if ($userid == null){
        die('Invalid user id');
    }
    require('TimeRecording.php');

    $timeRecording = new TimeRecording($userid);
//    $return_data = $timeRecording->GetTimeSheet();
    $now = new DateTime();
    $now_str = $now->format('Y-m-d');
    $time_records = $timeRecording->GetMonthlyTimeSheet($now_str);

    $smarty = new Smarty();
    $smarty->assign('time_records', $time_records);
    $month_options = PreviousMonths::GetPreviousMonths(12);
    $smarty->assign('month_options', $month_options);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    $smarty->display('timeSheet.tpl');
?>
