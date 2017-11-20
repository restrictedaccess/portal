<?php

/* $ rp_footer.php 2010-11-29 mike $ */

defined('SB_PAGE') or exit();


// GET TOTAL REPORTS
//$total_reports = $database->database_fetch_array($database->database_query("SELECT count(*) FROM se_reports"));


// ASSIGN ALL SMARTY VARIABLES/OBJECTS AND DISPLAY PAGE
/*$smarty->assign('total_reports', $total_reports[0]);
$smarty->assign('page', $page);
$smarty->assign_by_ref('setting', $setting);
$smarty->assign_by_ref('url', $url);
$smarty->assign_by_ref('admin', $admin);
$smarty->assign_by_ref('datetime', $datetime);
$smarty->assign_by_ref('level_menu', $level_menu);
$smarty->assign_by_ref('global_plugins', $global_plugins);
$smarty->assign('global_language', SELanguage::info('language_id'));
$smarty->assign_by_ref('lang_packlist', $lang_packlist);*/
$smarty->assign('admin', $admin);
$smarty->display("$page.tpl");
exit();
?>