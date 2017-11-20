<?php
//2009-04-21 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// provides a list of previous days based on philippine time

    require('../conf/zend_smarty_conf.php');

    $now = new DateTime();
    $available_days[] = array('Today', $now->format('Y-m-d'));

    $now->modify("-1 days");
    $available_days[] = array('Yesterday', $now->format('Y-m-d'));

    for ($i = 0; $i < 5; $i++) {
        $now->modify("-1 days");
        $available_days[] = array($now->format('l'), $now->format('Y-m-d'));
    }

    $smarty = new Smarty();
    $smarty->assign('days', $available_days);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_previous_days_list.tpl');
?>
