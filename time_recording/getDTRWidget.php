<?php
    //returns json list of subcontractors, buttons, 

ini_set("include_path",  ini_get('include_path').".:lib:..");
    include('../conf.php');
    $userid = $_SESSION['userid'];
    if ($userid == null){
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header('Content-type: text/plain');
        echo 'Invalid user id';
        exit;
    }
    require('TimeRecording.php');

    $timeRecording = new TimeRecording($userid);
    $buttons = $timeRecording->GetButtons();
    $client_lock_status = $timeRecording->GetActiveClient();
    $return_data = array('status' => 'OK', 'buttons' => $buttons, 'client_lock_status' => $client_lock_status);

    $output = json_encode($return_data);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    echo $output;
?>
