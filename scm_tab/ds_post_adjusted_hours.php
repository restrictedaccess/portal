<?php
//2009-05-15 Lawrence Sunglao <locsunglao@yahoo.com>
//  -   Security on users with adjust_time_sheet could only use this
//2009-04-30 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// Adds a record on the timerecord_adjustment

require('../conf/zend_smarty_conf.php');
require('ds_validate_admin.php');

$timerecord_id = $_POST['timerecord_id'];
$total_hrs = $_POST['total_hrs'];

$now = new DateTime();

    //check for adjust_time_sheet
    $sql = $db->select()
        ->from('admin', 'adjust_time_sheet')
        ->where('admin_id = ?', $admin_id);
    $adjust_time_sheet = $db->fetchOne($sql);

if ($adjust_time_sheet != "Y"){
    $smarty = new Smarty();
    $smarty->assign('status', 'error');
    $smarty->assign('message', 'Invalid Admin ID.');
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('response.tpl');
    exit;
}

$data = array(
    'timerecord_id' => $timerecord_id,
    'total_hrs' => $total_hrs,
    'admin_id' => $admin_id,
    'system_generated' => 'N',
    'time_updated' => $now->format("Y-m-d H:i:s")
);

$db->insert('timerecord_adjustment', $data);

$smarty = new Smarty();
$smarty->assign('status', 'ok');
$smarty->assign('message', 'Successfully updated time record.');

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Content-type: text/xml");
$smarty->display('response.tpl');
?>
