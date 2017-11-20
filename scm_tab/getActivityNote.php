<?php
    require_once('../zend_conf.php');
    $userid = $_GET['userid'];
    $date_time_str = $_GET['date_time_str'];
    $user_type = $_GET['user_type'];
    $date_time_earlier = new DateTime($date_time_str);
    $time_span = ACTIVITY_NOTE_INTERVAL * 2;
    $date_time_earlier->modify("-$time_span seconds");

    $select = $db->select("")
    ->from('activity_tracker_notes')
    ->where('userid = ?', $userid)
    ->where('checked_in_time < ?', $date_time_str)
    ->where('checked_in_time > ?', $date_time_earlier->format('Y-m-d H:i:s'))
    ->order('checked_in_time DESC')
    ->limit(1)
    ;

    $activity_tracker_note = $db->fetchRow($select);
    $expected_time = new DateTime($activity_tracker_note['expected_time']);
    $checked_in_time = new DateTime($activity_tracker_note['checked_in_time']);
    $seconds = $checked_in_time->format('U') - $expected_time->format('U');

    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;

    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;


    $activity_tracker_note['response_time'] = sprintf("%02d:h %02d:m %02d:s", $hours, $minutes, $seconds);
    $activity_tracker_note['expected_time'] = $expected_time->format("H:i:s");

//    $smarty = new Smarty();
//    $smarty->assign('activity_tracker_note', $activity_tracker_note);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header('Content-type: text/plain');
    print json_encode($activity_tracker_note);
//    $smarty->display('getActivityNote.tpl');

?>
