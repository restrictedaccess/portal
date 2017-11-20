<?php
//2009-04-30 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// Adds a record on the timerecord_adjustment

require('../conf/zend_smarty_conf.php');
require('ds_validate_admin.php');
$date = $_POST['date'];
$userid = $_POST['userid'];
$timerecord_id = $_POST['timerecord_id'];
$note = $_POST['note'];
$broadcast = $_POST['broadcast'];

if ($broadcast == 'true') {
    $data = array(
        'reference_date' => $date,
        'posted_by_id' => $admin_id,
        'posted_by_type' => 'admin',
        'note' => $note,
        'note_type' => 'broadcast'
    );
}
else {
    if ($timerecord_id == '') {
        $data = array(
            'reference_date' => $date,
            'userid' => $userid,
            'posted_by_id' => $admin_id,
            'posted_by_type' => 'admin',
            'note' => $note,
            'note_type' => 'unique'
        );
    }
    else {
        $data = array(
            'timerecord_id' => $timerecord_id,
            'userid' => $userid,
            'posted_by_id' => $admin_id,
            'posted_by_type' => 'admin',
            'note' => $note,
            'note_type' => 'unique'
        );
    }
}
$db->insert('timerecord_notes', $data);

$smarty = new Smarty();
$smarty->assign('status', 'ok');
$smarty->assign('message', 'Successfully added Note.');

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Content-type: text/xml");
$smarty->display('response.tpl');
?>
