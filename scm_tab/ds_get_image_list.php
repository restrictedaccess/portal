<?php
//2009-05-11 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  security fix for admin status: Not to show screenshots to "FINANCE-ACCT"
//2009-04-21 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// provides a list of screenshot images, time outs, lunch breaks, start work/stop work given the date and userid

    require('../conf/zend_smarty_conf.php');

    //check admin status
    require('ds_validate_admin.php');
    $admin_status = $_SESSION['status'];
    if ($admin_status == "FINANCE-ACCT") {
        $smarty = new Smarty();
        $smarty->assign('status', 'error');
        $smarty->assign('message', 'Insufficient Rights.');
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        header("Content-type: text/xml");
        $smarty->display('response.tpl');
        exit;
    }


    $userid = $_GET['userid'];
    $date_param = $_GET['date_param'];

    if ($date_param == "Today") {
        $date_param = "";
    }

    $date_time_ref = new DateTime($date_param);
    $date_time_start_str = $date_time_ref->format("Y-m-d 00:00:00");
    $date_time_end_str = $date_time_ref->format("Y-m-d 23:59:59");

    //grab screenshots
    $sql = $db->select()
        ->from(array('s' => 'screenshots'))
        ->join(array('l' => 'leads'),
            's.leads_id = l.id',
            array('lname', 'fname', 'company_name'))
        ->where("s.userid = ?", $userid)
        ->where("s.post_time >= ?", $date_time_start_str)
        ->where("s.post_time <= ?", $date_time_end_str)
        ->order('s.post_time');

    $screenshots = $db->fetchAll($sql);

    foreach($screenshots as $key => $screenshot) {
        $post_time = $screenshot['post_time'];
        $time_before_screenshot = new DateTime($post_time);
        $time_before_screenshot->modify("-15 mins");
        $time_after_screenshot = new DateTime($post_time);
        $time_after_screenshot->modify("+15 mins");
        $sql = $db->select()
            ->from('activity_tracker_notes')
            ->where("userid = ?", $userid)
            ->where("checked_in_time >= ?", $time_before_screenshot->format("Y-m-d H:i:s"))
            ->where("checked_in_time <= ?", $time_after_screenshot->format("Y-m-d H:i:s"))
            ->order("checked_in_time");
        $notes = $db->fetchAll($sql);
        $screenshots[$key]['activity_note'] = $notes[0]['note'];
    }

    //grab quick breaks 
    $sql = $db->select()
        ->from('activity_tracker_breaks', array("*", "TIMEDIFF(end, start) as diff"))
        ->where("userid = ?", $userid)
        ->where("start >= ?", $date_time_start_str)
        ->where("start <= ?", $date_time_end_str);

    $breaks = $db->fetchAll($sql);


    //grab lunch breaks
    $sql = $db->select()
        ->from('timerecord', array("*","TIMEDIFF(time_out, time_in) as diff"))
        ->where("userid = ?", $userid)
        ->where("mode = 'lunch_break'")
        ->where("time_in >= ?", $date_time_start_str)
        ->where("time_in <= ?", $date_time_end_str);

    $lunch_breaks = $db->fetchAll($sql);

    //grab time records
    $sql = $db->select()
        ->from('timerecord', array("*","TIMEDIFF(time_out, time_in) as diff"))
        ->where("userid = ?", $userid)
        ->where("mode = 'regular'")
        ->where("time_in >= ?", $date_time_start_str)
        ->where("time_in <= ?", $date_time_end_str);

    $time_records = $db->fetchAll($sql);

    $smarty = new Smarty();
    $smarty->assign('userid', $userid);
    $smarty->assign('screenshots', $screenshots);
    $smarty->assign('breaks', $breaks);
    $smarty->assign('lunch_breaks', $lunch_breaks);
    $smarty->assign('time_records', $time_records);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_get_image_list.tpl');
?>
