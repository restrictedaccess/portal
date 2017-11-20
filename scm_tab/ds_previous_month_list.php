<?php
//2009-04-24 Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
//  -   Initial hack
// provides a list of previous months based on philippine time

    require('../conf/zend_smarty_conf.php');

    $now = new DateTime();
    $now_str = $now->format('Y-m-01');
    $now = new DateTime($now_str);
    $available_months[$now_str] =  'Current Month';

    for ($i = 0; $i < 11; $i++) {
        $now->modify("-1 Month");
        $now_str = $now->format('Y-m-01');
        $available_months[$now_str] = $now->format('F - Y');
    }

    $smarty = new Smarty();
    $smarty->assign('available_months', $available_months);
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: text/xml");
    $smarty->display('ds_previous_month_list.tpl');
?>
