<?php
include '../conf/zend_smarty_conf.php';
include '../admin_subcon/subcon_function.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}

$from = date('Y-m-d') ;
$to = date('Y-m-d') ;

if (array_key_exists('_submit_check', $_POST)) {
	/*
	if($_POST['from']){
	    //$conditions .= " AND DATE(s.starting_date) >= '".$_POST['from']. "'";
		$conditions .= " AND DATE(s.starting_date) BETWEEN '".$_POST['from']. "' AND '".$_POST['to']."'";
	}
	
	//if($_POST['to']){
		$to = strtotime($_POST['to']);
		
	//}
	*/
	$from = $_POST['from'];
	$to = $_POST['to'];
}
//echo $from." ".$to;
//echo "<hr>";
//$conditions .= " AND DATE(s.starting_date) BETWEEN '".$_POST['from']. "' AND '".$to."'";

$sql = "SELECT s.id,s.starting_date, s.userid , p.fname, p.lname , p.email ,s.leads_id, CONCAT(l.fname,' ',l.lname)AS client_name, (l.email)AS leads_email, p.handphone_country_code, p.handphone_no, p.skype_id ,p.tel_area_code, p.tel_no , p.registered_email , s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour, s.work_status, s.job_designation, flexi, s.prepaid, s.staff_working_timezone, p.image , (mon_start)AS work_hour, (mon_finish)AS work_hour_finish, currency, staff_currency_id, client_price, php_monthly, p.address1, p.city, p.postcode, p.state, p.country_id, l.company_name, l.company_address, l.csro_id, ad.admin_fname, ad.admin_lname, (s.status)AS contract_status, s.date_terminated, s.resignation_date
FROM subcontractors s
LEFT JOIN personal p ON p.userid = s.userid
LEFT JOIN leads l ON l.id = s.leads_id
LEFT JOIN admin ad ON ad.admin_id = l.csro_id

WHERE ( s.status <> 'deleted') 
$conditions
ORDER BY p.fname  ;";
//echo $sql;
//echo "<hr>";
$subcontractors = $db->fetchAll($sql);
//echo "<pre>";
//print_r($subcontractors);
//echo "</pre>";
//exit;
$filter_staffs = array();
foreach($subcontractors as $subcon){
	
    if($subcon['contract_status'] == 'ACTIVE'){
	    $starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		
		//if(strtotime($starting_date) >= strtotime($from)){
			if(strtotime($starting_date) <= strtotime($to)){
			    //echo sprintf('%s %s %s %s %s<br>', $subcon['id'], $subcon['fname'], $subcon['lname'], $subcon['contract_status'], $end_date);
				array_push($filter_staffs, $subcon);
			}
		//}	
	}
	if($subcon['contract_status'] == 'resigned'){
		$end_date = $subcon['resignation_date'];
		$end_date = date('Y-m-d',strtotime($end_date));
		
		$starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
		if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) >= strtotime($to) ){
			//echo sprintf('%s %s %s %s %s<br>', $subcon['id'], $subcon['fname'], $subcon['lname'], $subcon['contract_status'], $end_date);
			array_push($filter_staffs, $subcon);
		}
		
		if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) <= strtotime($to) ){
			//echo sprintf('%s %s %s %s %s<br>', $subcon['id'], $subcon['fname'], $subcon['lname'], $subcon['contract_status'], $end_date);
			array_push($filter_staffs, $subcon);
		}
		}
		
	}
	if($subcon['contract_status'] == 'terminated'){
		$end_date = $subcon['date_terminated'];
		$end_date = date('Y-m-d',strtotime($end_date));
		
		$starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		
		if(strtotime($starting_date) <= strtotime($to)){
		if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) >= strtotime($to) ){
			//echo sprintf('%s %s %s %s %s<br>', $subcon['id'], $subcon['fname'], $subcon['lname'], $subcon['contract_status'], $end_date);
			array_push($filter_staffs, $subcon);
		}
		
		if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) <= strtotime($to) ){
			//echo sprintf('%s %s %s %s %s<br>', $subcon['id'], $subcon['fname'], $subcon['lname'], $subcon['contract_status'], $end_date);
			array_push($filter_staffs, $subcon);
		}
		}
		
	}
	//echo sprintf('%s %s %s %s %s<br>', $subcon['id'], $subcon['fname'], $subcon['lname'], $subcon['contract_status'], $end_date);
	$end_date = "";
	
	//array_push($filter_staffs, $subcon);
}
//exit;
$staffs = array();


if (array_key_exists('_submit_check', $_POST)) {
    //let's filter first
    include 'filter-subconlist.php';
    
	//echo "<pre>";
    //foreach($staffs as $staff){
    //	echo sprintf('%s %s %s<br>', $staff['id'], $staff['fname'], $staff['lname']);
    //}
    //echo "</pre>";
	$smarty->assign('staffs', $staffs);
	
}
if(isset($_POST['export'])){
    include 'subconlist-export.php';
}
//echo "<pre>";
//print_r($filter_staffs);
//echo "</pre>";

$MONTH_NUMBERS = array('01','02','03','04','05','06','07','08','09','10','11','12');
$MONTH_NAMES = array('January','February','March','April','May','June','July','August','Septempber','October','November','December');
$YEARS=array();
for($i=2008; $i<=date('Y'); $i++){
	$YEARS[]=$i;
}

$smarty->assign('MONTH_NUMBERS',$MONTH_NUMBERS);
$smarty->assign('MONTH_NAMES',$MONTH_NAMES);
$smarty->assign('YEARS', $YEARS);

$smarty->assign('from', $from);
$smarty->assign('to', $to);

$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('subconlist-exporting.tpl');
?>