<?php
//2009-05-11 Lawrence Sunglao <locsunglao@yahoo.com>
//  -   add admin status for removal of screenshot button on front end
//2009-03-25 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack

    require('../conf/zend_smarty_conf.php');
    require('ds_validate_admin.php');

    $s = $_GET['s'];

    //check admin status
    $sql = $db->select()
        ->from('admin', 'status')
        ->where('admin_id = ?', $admin_id);
    $admin_status = $db->fetchOne($sql);

    $sql = $db->select()
        ->from(array('a' => 'activity_tracker'))
        ->join(array('p' => 'personal'),
            'a.userid = p.userid',
            array('lname','fname','email','skype_id','image'))
        ->where("p.fname like ? OR p.lname like ?", "%$s%", "%$s%")
        ->order(array('p.fname', 'p.lname'));
    $staff = $db->fetchAll($sql);

    $smarty = new Smarty();
    $smarty->assign('staff', $staff);
    $smarty->assign('admin_status', $admin_status);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_staff.tpl');
?>
