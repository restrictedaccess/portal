<?php
/*
$working=0;
$lunch_break =0;
$quick_break =0;
$active_staff =0;
$not_working =0;

$sql = "SELECT count(*)AS working  FROM activity_tracker a where status = 'working';";
$working = $db->fetchOne($sql);

$sql = "SELECT count(*)AS lunch_break  FROM activity_tracker a where status = 'lunch break';";
$lunch_break = $db->fetchOne($sql);

$sql = "SELECT count(*)AS lunch_break  FROM activity_tracker a where status = 'quick break';";
$quick_break = $db->fetchOne($sql);


$sql = "SELECT COUNT(DISTINCT(userid))AS active_staff FROM subcontractors s WHERE status IN ('ACTIVE', 'suspended');";
$active_staff = $db->fetchOne($sql);

$not_working = ($active_staff - ($working+$lunch_break+$quick_break));


$smarty->assign('quick_break' , $quick_break);
$smarty->assign('lunch_break' , $lunch_break);
$smarty->assign('not_working' , $not_working);
$smarty->assign('working' , $working);
*/
?>