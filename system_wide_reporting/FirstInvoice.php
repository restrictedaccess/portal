<?php
include('../conf/zend_smarty_conf.php');

//$date = new DateTime();
//$current_date_unix = $date->format('U');
//$current_date_unix = $date->format('U');
//$current_year =   $date->format('Y');
//$current_month = '03';//  $date->format('m');
//$weekday =  $date->format('D');
//$weekday_name =  $date->format('l');
//echo "CURRENT TIME :".$current_time."<br>";
//$weekday_str = strtolower($weekday)."_start";
//echo $weekday."<hr>";

//if(!$from){
//	$from = $date->format('Y-m-d');
//}

//if(!$to){
//	$to = $from;
//}

//$start_date_of_leave = explode('-',$to);
//$year = $start_date_of_leave[0];
//$month = $start_date_of_leave[1];
//$day = $start_date_of_leave[2];

//$date = new DateTime();
//$date->setDate($year, $month, $day);
//$date->modify("+1 day");

//$date_end_str = $date->format("Y-m-d");
	
//$sql = "SELECT s.id , s.userid , s.starting_date , p.fname , p.lname ,p.email  FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status = 'ACTIVE' AND YEAR(starting_date) = '".$current_year."' AND MONTH(starting_date) = '".$current_month."'   ORDER BY s.id DESC;";	

$pop_window = $_REQUEST['pop_window'];
if($pop_window){
	$from = $_REQUEST['from'];
	$to = $_REQUEST['to'];
	$status = $_REQUEST['status'];
	
	$status_array = array("paid","posted","overdue","due date today");
	for($i=0; $i<count($status_array); $i++){
		if($status == $status_array[$i]){
			$status_options .="<option selected value='".$status_array[$i]."'>".$status_array[$i]."</option>";
		}else{
			$status_options .="<option value='".$status_array[$i]."'>".$status_array[$i]."</option>";
		}
	}
	
}
$sql = "SELECT s.id , s.userid , s.starting_date , p.fname , p.lname ,p.email,s.leads_id  FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status IN('ACTIVE', 'suspended') AND starting_date BETWEEN '".$from."' AND '".$to."'   ORDER BY s.id DESC;";
//echo $sql;exit;
	
$staffs = $db->fetchAll($sql);
$client_first_invoice=0;
$paid=0;
$due_date_today=0;
$posted=0;
$overdue=0;
$client_list = array();
foreach($staffs as $staff){

	//echo "[ ". $staff['id']." ] ".$staff['userid']." ".$staff['fname']." ".$staff['lname']." ";
	
	//get the first timesheet created for this staff.
	$sql = $db->select()
		->from('timesheet','id')
		->where('status =?' , 'open')
		->where('subcontractors_id =?' , $staff['id'])
		->limit(1);
	$timesheet_id = $db->fetchOne($sql);
	//echo $timesheet_id."<br>";
	
	//get client_invoice_id for this timesheet
	$sql = $db->select()
		->from('timesheet_client_invoice_tracking')
		->where('timesheet_id =?' , $timesheet_id)
		->limit(1);
	$timesheet_client_invoice_tracking = $db ->fetchRow($sql);
	$timesheet_client_invoice_tracking_id = $timesheet_client_invoice_tracking['id'];
	$client_invoice_id = $timesheet_client_invoice_tracking['client_invoice_id'];
	$client_invoice_details_id = $timesheet_client_invoice_tracking['client_invoice_details_id'];
	if($client_invoice_id){
		$client_first_invoice++;
		$sql=$db->select()
			->from('leads', Array('fname','lname'))
			->where('id =?' , $staff['leads_id']);
		$lead = $db->fetchRow($sql);	
		
		$sql = $db->select()
			->from('client_invoice' ,Array('status', 'invoice_payment_due_date', 'invoice_number'))
			->where('id =?' , $client_invoice_id);
		$invoice = $db->fetchRow($sql);	
		$invoice_status = $invoice['status'];
		$invoice_number = $invoice['invoice_number'];
		
		if($invoice_status == 'paid'){
			$paid++;
			$flag_status = 'paid';
		}else if($invoice_status == 'posted'){
		
			if($invoice['invoice_payment_due_date']){
				if(date("Y-m-d") < $invoice['invoice_payment_due_date']){
					$posted++;
					$flag_status = 'posted';
				}else if (date("Y-m-d") == $invoice['invoice_payment_due_date']){
					$due_date_today++;
					$flag_status = 'due date today';	
				}else{
					$overdue++;
					$flag_status = 'overdue';
				}
			}	
		}else{
			$other++;
			$flag_status = $invoice['status'];
		}
			
		$data = array(
			'subcontractor_id' => $staff['id'],
			'userid' => $staff['userid'],
			'starting_date' => $staff['starting_date'],
			'staff' => $staff['fname']." ".$staff['lname'],
			'client_invoice_id' => $client_invoice_id,
			'client_invoice_details_id' => $client_invoice_details_id,
			'leads_id' => $staff['leads_id'],
			'client' => $lead['fname']." ".$lead['lname'],
			'status' => $flag_status,
			'invoice_payment_due_date' => $invoice['invoice_payment_due_date'],
			'invoice_number' => $invoice_number
			
		);
		array_push($client_list,$data);
		
		
	}
			
}	
//echo $client_first_invoice;exit;
//print_r($client_list);exit;
if($pop_window){
	header('Content-type: text/html; charset=utf-8');
	header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	$smarty = new Smarty;
	$smarty->assign('client_list',$client_list);
	$smarty->assign('status_options',$status_options);
	$smarty->assign('status',$status);
	$smarty->assign('from',$from);
	$smarty->assign('to',$to);
	$smarty->display('FirstInvoice.tpl');
}else{
	$smarty->assign('paid',$paid);
	$smarty->assign('posted',$posted);
	$smarty->assign('due_date_today',$due_date_today);
	$smarty->assign('overdue',$overdue);
	//$smarty->assign('other',$other);
	$smarty->assign('client_first_invoice',$client_first_invoice);

}

?>