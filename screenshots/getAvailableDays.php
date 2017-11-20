<?php
    $available_days = array();

    $ph_tz = new DateTimeZone('Asia/Manila');
    $now = new DateTime();
    $now->setTimezone($ph_tz);
    $available_days[] = array('Today', $now->format('Y-m-d'));

    $now->modify("-1 days");
    $available_days[] = array('Yesterday', $now->format('Y-m-d'));

    for ($i = 0; $i < 5; $i++) {
        $now->modify("-1 days");
        $available_days[] = array($now->format('l'), $now->format('Y-m-d'));
    }

    header('Content-type: text/plain');
    echo json_encode($available_days);
?>
