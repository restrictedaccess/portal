<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
$smarty = new Smarty();

$AusDate = date("Y")."-".date("m")."-".date("d");
$leads_id = $_REQUEST['leads_id'];

$query="SELECT MAX(PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '$AusDate'), EXTRACT(YEAR_MONTH FROM s.starting_date))) AS max_month_interval  FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.leads_id = $leads_id AND s.status = 'ACTIVE';";
$result = $db->fetchRow($query);
$max_month_interval = $result['max_month_interval'];


$query = "SELECT s.id ,DATE_FORMAT(s.starting_date , '%D %b %y')AS starting_date_str , CONCAT(p.fname,' ' ,p.lname)AS staff_name ,  PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '$AusDate'), EXTRACT(YEAR_MONTH FROM s.starting_date)) AS month_interval , DATEDIFF('$AusDate',s.starting_date)AS no_of_days FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.leads_id = $leads_id AND s.status = 'ACTIVE' ORDER BY s.starting_date ASC;";
$result = $db->fetchAll($query);
$no_of_staff = count($result);

//echo $query;
/*
$resultOptions = "<table width=\"100%\" cellpadding=\"3\" cellspacing=\"0\">
					<tr bgcolor = '#999999'>
					<td width=\"1%\"><b>#</b></td>
					<td width=\"7%\"><b>STAFF NAME</b></td>
					<td width=\"2%\"><b>DATE STARTED</b></td>
					<td width=\"15%\"><b>PERIOD</b></td>
					</tr>";

foreach($result as $row){
	 if($bgcolor=="#f5f5f5")
	  {
		$bgcolor="#FFFFFF";
	  }
	  else
	  {
		$bgcolor="#f5f5f5"; 
	  }
	$ctr++;
	$period = $row['month_interval']." months";
	if($period == 0){
		$period = $row['no_of_days']. " days";
	}
	$resultOptions.="<tr bgcolor='$bgcolor'>
					<td valign='top' style='border-bottom:#333333 solid 1px; border-left:#333333 solid 1px; border-right:#333333 solid 1px;'  >".$ctr."</td>
					<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>".strtoupper($row['staff_name'])."</td>
					<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>".$row['starting_date_str']."</td>
					<td valign='top' style='border-bottom:#333333 solid 1px;border-right:#333333 solid 1px;'>".$period."</td></tr>";
}
$resultOptions .= "</table>";
*/

$smarty->assign('max_month_interval',$max_month_interval);
$smarty->assign('no_of_staff',$no_of_staff);
$smarty->assign('result',$result);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('showClientHistory.tpl');

?>