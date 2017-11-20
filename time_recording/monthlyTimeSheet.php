<?php
    //2008-08-13 Lawrence Sunglao <locsunglao@yahoo.com>
    //  - modify to show whole months time record
    //  - make it an html snippet rather than json
    //returns json list of time record
    include_once('../conf.php');
    include("../lib/Smarty/libs/Smarty.class.php");
    require_once('TimeRecording.php');
    date_default_timezone_set("Asia/Manila");

    $userid = $_SESSION['userid'];
    if ($userid == null){
        die('Invalid user id');
    }

    $date = $_GET['date'];
    if (($date == null) or ($date == '')) {
        die('Error... Date required');
    }

    $timeRecording = new TimeRecording($userid);
    $now = new DateTime($date);
    $now_str = $now->format('Y-m-d');
    $time_records = $timeRecording->GetMonthlyTimeSheet($now_str);

    $smarty = new Smarty();
    $smarty->assign('time_records', $time_records);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    $smarty->display('timeSheet.tpl');
?>
