<?php
    //2008-08-01 removed the Next login time message
    //returns a json object containing time to relogin,  idle time, status
    include('../conf.php');
    date_default_timezone_set("Asia/Manila");
    $user_type = $_GET['user_type'];
    if ($user_type == 'agent') {
        $userid = $_SESSION['agent_no'];
    }
    else {
        $userid = $_SESSION['userid'];
    }
    $ph_tz = new DateTimeZone('Asia/Manila');

    //add a clock
    $date_time_asia_manila = new DateTime();
    $time_asia_manila = $date_time_asia_manila->format('Y-m-d H:i:s');
    $date_time_australia_sydney = new DateTime();
    $tz_au_sydney = new DateTimeZone('Australia/Sydney');
    $date_time_australia_sydney->setTimezone($tz_au_sydney);
    $time_australia_sydney = $date_time_australia_sydney->format('Y-m-d H:i:s');
    //TODO remove this variable
    $seconds_to_relogin = 10000;

    $data = array("status_msg" => $status, 
        "color" => $color, 
        "background_color" => $background_color, 
        "seconds_idle" => $seconds_idle,
        "seconds_to_relogin" => $seconds_to_relogin,
        "time_asia_manila" => $time_asia_manila,
        "time_australia_sydney" => $time_australia_sydney
    );
    $output = json_encode($data);
    header('Content-type: text/plain');
    echo $output;
?>
