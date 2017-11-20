<?php
//2009-04-14 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack

    require('../conf/zend_smarty_conf.php');
    $userid = $_GET['userid'];
    $query_type = $_GET['query_type'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    if ($query_type == 'Single Date') {
        $date_time_start = new DateTime($start_date);
        $date_time_start_str = $date_time_start->format('Y-m-d 00:00:00');
        $date_time_end_str = $date_time_start->format('Y-m-d 23:59:59');
    }
    else {
        $date_time_start = new DateTime($start_date);
        $date_time_start_str = $date_time_start->format('Y-m-d 00:00:00');
        $date_time_end = new DateTime($end_date);
        $date_time_end_str = $date_time_end->format('Y-m-d 23:59:59');
    }

    $sql = $db->select()
        ->from(array('i' => 'internet_connection_log'),
            array("*", "TIMEDIFF(reported_time, last_seen) as timediff"))
        ->join(array('l' => 'leads'),
            'i.leads_id = l.id',
            array('lname', 'fname', 'company_name'))
        ->where("i.userid = ?", $userid)
        ->where("i.last_seen >= ?", $date_time_start_str)
        ->where("i.last_seen <= ?", $date_time_end_str);
    $internet_connection_log = $db->fetchAll($sql);
    $sum_sec = 0;
    $sum_min = 0;
    $sum_hr = 0;
    foreach ($internet_connection_log as $log) {
        $array_timediff = split(':', $log['timediff']);
        $sum_hr += $array_timediff[0];
        $sum_min += $array_timediff[1];
        $sum_sec += $array_timediff[2];
    }
    $minutes = floor($sum_sec/60);
    $secs = $sum_sec - $minutes * 60;
    $minutes += $sum_min;
    $hours = floor($minutes/60);
    $minutes = fmod($minutes, 60);
    $hours += $sum_hr;

    $total_timediff = sprintf("%02d:%02d:%02d", $hours,$minutes,$secs);


    $smarty = new Smarty();
    $smarty->assign('internet_connection_log', $internet_connection_log);
    $smarty->assign('total_timediff', $total_timediff);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_staff_internet_connection_status.tpl');
?>
