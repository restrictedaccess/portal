<?php
//2009-04-30 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// Validates admin via session

session_start();
$admin_id = $_SESSION['admin_id'];
if ($admin_id == null){
    $smarty = new Smarty();
    $smarty->assign('status', 'error');
    $smarty->assign('message', 'Invalid Admin ID.');
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('response.tpl');
    exit;
}


?>
