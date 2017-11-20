<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}

//$MONTH_NUM=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$MONTH_STR=array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
$year = $_POST['year'];

if($year == ""){
	$year = date('Y');
}

$MONTLY_RESULTS=array();
$total_count=0;
foreach(array_keys($MONTH_STR) as $array_key){
	$sql = "SELECT COUNT(id)AS month_num_count FROM leads l WHERE MONTH(timestamp)='".$MONTH_STR[$array_key]."' AND YEAR(timestamp)='".$year."';";
	$month_num_count = $db->fetchOne($sql);
	$data=array(
	    'month_name' => $array_key,
		'month_num' => $MONTH_STR[$array_key],
		'month_num_count' => $month_num_count,
	);
	$MONTLY_RESULTS[] = $data;
	$total_count = $total_count + $month_num_count;
}


for($i=2008; $i<=date('Y'); $i++){
    $YEARS[]=$i;	
}
$smarty->assign('total_count',$total_count);
$smarty->assign('MONTLY_RESULTS', $MONTLY_RESULTS);
$smarty->assign('year',$year);
$smarty->assign('YEARS',$YEARS);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('leads_monthly_reporting.tpl');
?>