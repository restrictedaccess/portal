<?php
include('conf/zend_smarty_conf.php');
include './time.php'; 
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

if($_SESSION['agent_no']=="")
{
	header("location:./index.php");
	exit;
}



$agent_no = $_SESSION['agent_no'];
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

$current_date = $_REQUEST['current_date'];
if(!$current_date){
	$current_date = $AusDate;
}

$sql = $db->select()
	->from('agent')
	->where('agent_no =?' ,$_SESSION['agent_no'] );
$agent = $db->fetchRow($sql);

$monthArray=array("01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i < count($monthArray); $i++){
	if($month == $monthArray[$i]){
		$monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
	}else{
		$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
	}
}

for ($i = date("Y"); $i >=2008; $i--){
	$yearoptions .= "<option value=\"$i\">$i</option>\n";
	
}

// added by mike - 24/10/11
if( $_SESSION['agent_no'] != "" && $_SESSION['firstrun'] == "" ) {
	$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
	$smarty->assign('session_exists', 1);
	$smarty->assign('hash',$hash_code);
	$smarty->assign('emailaddr', $_SESSION['emailaddr']);
}

$smarty->assign('yearoptions',$yearoptions);

$smarty->assign('monthoptions',$monthoptions);
$smarty->assign('current_date',$current_date);
$smarty->assign('agent' , $agent);
$smarty->display('agentHome.tpl');
?>