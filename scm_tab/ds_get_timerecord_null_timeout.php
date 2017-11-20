<?php
//2009-08-11 Lawrence Oliver C. Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Initial hack
// provides a list of time records with null timeout given the userid

    require('../conf/zend_smarty_conf.php');

    $userid = $_GET['userid'];

    $date = new DateTime($date_param);

    $time_record_notes_final = array();

    $sql = $db->select()
        ->from('timerecord')
        ->where("userid = ?", $userid)
        ->where("mode = 'regular' or mode = 'lunch_break'")
        ->where("time_out is NULL");

    $null_timeout_records = $db->fetchAll($sql);

    $smarty = new Smarty();
    $smarty->assign('null_timeout_records', $null_timeout_records);

    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_get_timerecord_null_timeout.tpl');
?>
