<?php
//  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   stop script execution if admin_id session is not found
include('conf/zend_smarty_conf.php');
include_once('subcon_compliance/checkRsscUser.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;


$admin_id = $_SESSION['admin_id'];

if($admin_id == ''){
	header("location:index.php");
    exit();
}

$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);

// 2014-05-09 - test if admin user accnt is logged in on rssc  //msl
if( !preg_match('/^devs./', $_SERVER['HTTP_HOST'], $match) && (int)$admin['userid'] > 0 ) {
	// check rssc login
	$rssc_logged = false;
	$date = new DateTime();
	$date->setTimezone(new DateTimeZone('Asia/Manila'));
	$current_date = $date->format('Y:m:d');
	$split_date = explode(':', $current_date);
	$date_value = array('start' => $split_date, 'end' => $split_date, 'hour' => 23, 'minute' => 59);
	
	$check_rssc = new checkRsscUser($couch_dsn);
	$rssc_res = $check_rssc->RSSC_userTimeIn($admin['userid'], $date_value);
	if( count($rssc_res->rows) ) {
		foreach( $rssc_res->rows as $row) {
			if( $row->value[0] == 'time record' && !$row->value[1]) {
				$rssc_logged = true;
				break;
			}
		}
	}
	
	if( !$rssc_logged) {
		unset($_SESSION['admin_id']);
		exit('Invalid RSSC Session');
	}
}


if( !empty($_SESSION['admin_id']) && $_SESSION['firstrun'] == "" ) {
	$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
	$smarty->assign('session_exists', 1);
	$smarty->assign('hash',$hash_code);
	$smarty->assign('emailaddr', $_SESSION['emailaddr']);
}


$smarty->assign('admin',$admin);

$smarty->display('adminHome.tpl');
?>
