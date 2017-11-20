<?php
    //revisions 2008-07-02 11:00 am by Lawrence Sunglao<locsunglao@yahoo.com>
    //removed AM/PM stuff and just replace it with start work/stop work
    ini_set("include_path",  ".:../lib:..");
    include('../conf.php');
    require_once('TimeRecording.php');
    require_once('../online_presence/OnlinePresence.php');
    require_once('../zend_conf.php'); 
    $userid = $_SESSION['userid'];
    if ($userid == null){
        die('Invalid user id');
    }

    $subcontractor_id = $_GET['subcontractor_id'];
    if ($subcontractor_id == null){
        die('Invalid subcontractor id');
    }

    $timeRecording = new TimeRecording($userid);
    $action = $_GET['action'];
    switch ($action) {
        case null:
            die("Invalid action.");
            break;
        case '':
            die("Invalid action.");
            break;
        case 'work_start':
            $return_data = $timeRecording->RecordTimeIn($subcontractor_id);
            break;
        case 'work_end':
            $return_data = $timeRecording->RecordTimeOut();
            break;
        case 'lunch_start':
            $return_data = $timeRecording->RecordLunchStart($subcontractor_id);
            break;
        case 'lunch_end':
            $return_data = $timeRecording->RecordLunchEnd($subcontractor_id);
            break;
        default:
            die("Invalid action.");
    }

    $output = json_encode($return_data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>

