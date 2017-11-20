<?php
    //2009-05-13 Lawrence Sunglao <locsunglao@yahoo.com>
    //  Bug fix for 1and1 server version
    //returns json list of time record
    include("../conf.php");
    include('../time_recording/TimeRecording.php');
    require_once("../lib/Smarty/libs/Smarty.class.php");

    include('PreviousMonthsLib.php');
    $admin_id = $_SESSION['admin_id'];
    $admin_status=$_SESSION['status'];

    if ($admin_id == null){
        die('Invalid ID for Admin.');
    }

    $userid = $_GET['userid'];
    if (($userid == null) or ($userid == '')){
        die('Invalid user id');
    }

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

    $month_options = PreviousMonths::GetPreviousMonths(12);
    $timeRecording = new TimeRecording($userid);

    $smarty = new Smarty();
    $smarty->assign('month_options', $month_options);
    $smarty->assign('time_records', $timeRecording->GetMonthlyTimeSheet($date));
    $smarty->assign('show_month_list', $show_month_list);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    $smarty->display('timeSheetForAdmin.tpl');
?>
