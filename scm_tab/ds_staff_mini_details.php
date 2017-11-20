<?php
//2009-04-01 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack

    require('../conf/zend_smarty_conf.php');
    $userid = $_GET['userid'];

    $sql = $db->select()
        ->from(array('a' => 'activity_tracker'))
        ->join(array('p' => 'personal'),
            'a.userid = p.userid',
            array('lname', 'fname', 'email', 'skype_id', 'image'))
        ->where("a.userid = ?", $userid);
    $staff = $db->fetchRow($sql);

    $smarty = new Smarty();
    $smarty->assign('staff', $staff);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_staff_mini_details.tpl');
?>
