<?php
include('../conf/zend_smarty_conf.php');
include '../leads_information/AdminBPActionHistoryToLeads.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	

}else{

	die("Session Expires. Please re-login");
	
}

$current_date = $_REQUEST['current_date'];
$mode = $_REQUEST['mode'];

$start_date_of_leave = explode('-',$current_date);
$year = $start_date_of_leave[0];
$month = $start_date_of_leave[1];
$day = $start_date_of_leave[2];

$date = new DateTime();
$date->setDate($year, $month, $day);
		
if($mode == 'previous') {
	$date->modify("-1 day");
	$current_date = $date->format("Y-m-d");
	//echo $current_date;
}else if($mode == 'next') {
	$date->modify("+1 day");
	$current_date = $date->format("Y-m-d");
	//echo $current_date;
}else if($mode == 'event_date'){
	$current_date = $_REQUEST['current_date'];
}else{
	//mode == current
	$current_date = $AusDate;
	//echo $current_date;
}


$action_img_lookup = array(
	'EMAIL' => 'email.gif',
	'CALL' => 'yet-to-confirm.gif',
	'MAIL' => 'note.png',
	'MEETING FACE TO FACE' => 'icon-person.jpg'

);

/*
$registered_in_img_lookup = array(
	'home page' => ,
	'available staff' => ,
	'recruitment  service' => ,
	'contact us' => ,
	'send resume' => ,
	'added manually' =>
);
*/	
	
//show the total no. of leads registered
$sql = "SELECT COUNT(id)AS total_no_of_leads_registered FROM leads WHERE DATE(timestamp) = '".$current_date."'";
$result = $db->fetchRow($sql); 
$total_no_of_leads_registered = $result['total_no_of_leads_registered'];
//echo $total_no_of_leads_registered;

//total no. of leads breakdown
$sql = "SELECT COUNT(id)AS registered_in_total , registered_in FROM leads l  WHERE DATE(timestamp) = '".$current_date."'  GROUP BY registered_in;";
$total_no_of_leads_breakdowns = $db->fetchAll($sql);

//breakdown of Affiliate referral
$sql = "SELECT COUNT(id)AS total , agent_id , business_partner_id FROM leads l  WHERE DATE(timestamp) = '".$current_date."' AND agent_id != business_partner_id GROUP BY agent_id";
$affiliate_referrals = $db->fetchAll($sql);

foreach($affiliate_referrals as $affiliate_referral){
	$affiliate_referral_str .="<tr bgcolor='#FFFFFF' >
	<td valign='top' style='font-size:10px;'><img src='images/user_go.png' align='absmiddle' /> ".getCreator($affiliate_referral['agent_id'] , 'agent' )."</td>
	<td valign='top' style='font-size:10px;'>".$affiliate_referral['total']."</td>
	</tr>";
	
	$affiliate_referral_total = $affiliate_referral_total + $affiliate_referral['total'];
}

//actions
$sql = "SELECT COUNT(id)AS total , actions FROM history h WHERE DATE(date_created) = '".$current_date."' GROUP BY actions;";
$actions = $db->fetchAll($sql);


foreach($actions as $action){
	if($action['actions'] == 'MAIL'){
		$action_type = 'NOTES';
		$img = "note.png";
	}else{
		$action_type = $action['actions'];
	}
	
	
	//CALL = yet-to-confirm.gif , EMAIL = email.gif , icon-envelope.jpg , NOTES = note.png
	if($action['actions']){
		$action_str .="<tr bgcolor='#FFFFFF' >
		<td valign='top' style='font-size:10px;'><img src='images/".$action_img_lookup[$action['actions']]."' align='absmiddle' /> ".$action_type."</td>
		<td valign='top' style='font-size:10px;'>".$action['total']."</td>
		</tr>";
	}
}


//QUOTE
$sql = "SELECT COUNT(id)as total FROM `quote` q WHERE  q.status = 'posted' AND DATE(date_posted) = '".$current_date."';";
$quote_count = $db->fetchOne($sql);
//echo $quote_count;

//SETUP FEE
$sql = "SELECT COUNT(id)as total FROM `set_up_fee_invoice` s WHERE  s.status = 'posted' AND DATE(post_date) = '".$current_date."';";
$setup_fee_count = $db->fetchOne($sql);

//SERVICE AGREEMENT
$sql = "SELECT COUNT(service_agreement_id)as total FROM `service_agreement` s WHERE  s.status = 'posted' AND DATE(date_posted) = '".$current_date."';";
$service_agreement_count = $db->fetchOne($sql);

//RECRUITMENT JOB ORDER FORM
$sql = "SELECT COUNT(job_order_id) FROM `job_order` j WHERE  j.status = 'posted' AND DATE(date_posted) = '".$current_date."';";
$job_order_count = $db->fetchOne($sql);


//GET ALL BUSINESS PARTNERS

$sql = $db->select()
	->from('agent' , Array('agent_no' , 'fname' , 'lname' ,'email'))
	->where('work_status =?' ,'BP')
	->where('status =?' ,'ACTIVE');
$agents = $db->fetchAll($sql);	
foreach($agents as $agent){

		//#eeeeee,#d0d0d0
		if($bgcolor == '#FFFFCC'){
			$bgcolor = '#eeeeee';
		}else{
			$bgcolor = '#FFFFCC';
		}
		
		$agent_str .="<tr bgcolor='".$bgcolor."' ><td  style='font-size:11px;padding-left:20px;'><img src='images/resultset_next.png' align='absmiddle' /> <strong>".$agent['fname']." ".$agent['lname']."</strong><br>
		".$agent['email']."
		</td>";
		
		//LEADS
		$agent_str .="<td  valign='top' style='font-size:11px;text-transform:capitalize;'>";
				//total no. of leads breakdown
				$sql = "SELECT COUNT(id)AS registered_in_total , registered_in FROM leads l  WHERE business_partner_id =".$agent['agent_no']." AND DATE(timestamp) = '".$current_date."'  GROUP BY registered_in;";
				
				$bd_total_no_of_leads_breakdowns = $db->fetchAll($sql);
				$agent_str .="<table width='100%' cellpadding='0' cellspacing='0'>";
				foreach($bd_total_no_of_leads_breakdowns as $bd_total_no_of_leads_breakdown){
					$agent_str .="<tr><td width='60%' style='font-size:10px;' ><img src='images/user_add.png' align='absmiddle' /> ".$bd_total_no_of_leads_breakdown['registered_in']." </td><td width='40%' style='font-size:10px;'> ".$bd_total_no_of_leads_breakdown['registered_in_total']."</td></tr>";
				}
				$agent_str .="</table>";
		$agent_str .="</td>";
		//LEADS ENDS HERE
		
		//ACTIONS
		$agent_str .="<td  valign='top' style='font-size:11px;'>";
				
				$sql = "SELECT COUNT(id)AS total , actions FROM history h WHERE agent_no = ".$agent['agent_no']." AND created_by_type = 'agent' AND  DATE(date_created) = '".$current_date."' GROUP BY actions;";
				$bd_actions = $db->fetchAll($sql);
				$agent_str .="<table width='100%' cellpadding='0' cellspacing='0'>";
				foreach($bd_actions as $bd_action){
					if($bd_action['actions'] == 'MAIL'){
						$action_type = 'NOTES';
					}else{
						$action_type = $bd_action['actions'];
					}
					
					if($bd_action['actions']){
						$agent_str .="<tr >
		<td valign='top' width='90%' style='font-size:10px;'><img src='images/".$action_img_lookup[$bd_action['actions']]."' align='absmiddle' /> ".$action_type."</td>
						<td valign='top' width='10%' style='font-size:10px;'>".$bd_action['total']."</td>
						</tr>";
					}
				}
				$agent_str .="</table>";
		$agent_str .="</td>";
		//ACTION ENDS HERE
		
		
		
		
		//SENT
		$agent_str .="<td  valign='top' style='font-size:11px;;'>";
				$agent_str .="<table width='100%' cellpadding='0' cellspacing='0'>";
				//QUOTE
				$sql = "SELECT COUNT(id)as total FROM `quote` q WHERE  q.status = 'posted' AND created_by =".$agent['agent_no']." AND created_by_type = 'agent' AND DATE(date_posted) = '".$current_date."';";
				$bd_quote_count = $db->fetchOne($sql);
				$agent_str .="<tr >
	<td valign='top' width='90%' style='font-size:10px;'><img src='images/bullet_red.png' align='absmiddle' />Quote</td>
					<td valign='top' width='10%' style='font-size:10px;'>".$bd_quote_count."</td>
				</tr>";
				
				//SETUP FEE
				$sql = "SELECT COUNT(id)as total FROM `set_up_fee_invoice` s WHERE  drafted_by = ".$agent['agent_no']." AND drafted_by_type = 'agent' AND  s.status = 'posted' AND DATE(post_date) = '".$current_date."';";
				$bd_setup_fee_count = $db->fetchOne($sql);
				$agent_str .="<tr >
	<td valign='top' width='90%' style='font-size:10px;'><img src='images/bullet_red.png' align='absmiddle' />Setup Fee</td>
					<td valign='top' width='10%' style='font-size:10px;'>".$bd_setup_fee_count."</td>
				</tr>";
				
				//SERVICE AGREEMENT
				$sql = "SELECT COUNT(service_agreement_id)as total FROM `service_agreement` s WHERE  created_by =".$agent['agent_no']." AND created_by_type = 'agent' AND s.status = 'posted' AND DATE(date_posted) = '".$current_date."';";
				$bd_service_agreement_count = $db->fetchOne($sql);
				$agent_str .="<tr >
	<td valign='top' width='90%' style='font-size:10px;'><img src='images/bullet_red.png' align='absmiddle' />Service Agreement</td>
					<td valign='top' width='10%' style='font-size:10px;'>".$bd_service_agreement_count."</td>
				</tr>";
				
				//RECRUITMENT JOB ORDER FORM
				$sql = "SELECT COUNT(job_order_id) FROM `job_order` j WHERE created_by_id =".$agent['agent_no']." AND created_by_type = 'agent' AND j.status = 'posted' AND DATE(date_posted) = '".$current_date."';";
				$bd_job_order_count = $db->fetchOne($sql);
				$agent_str .="<tr >
	<td valign='top' width='90%' style='font-size:10px;'><img src='images/bullet_red.png' align='absmiddle' />Recruitment Job Order Form</td>
					<td valign='top' width='10%' style='font-size:10px;'>".$bd_job_order_count."</td>
				</tr>";
				
				
				$agent_str .="</table>";
			
		$agent_str .="</td>";
		//SENT ENDS HERE
		
		
		
		//AFFILIATE REFERRALS
		$agent_str .="<td  valign='top' style='font-size:11px;'>";
		//breakdown of Affiliate referral
		$sql = "SELECT COUNT(id)AS total , agent_id , business_partner_id FROM leads l  WHERE business_partner_id = ".$agent['agent_no']." AND DATE(timestamp) = '".$current_date."' AND agent_id != business_partner_id GROUP BY agent_id";
		$bp_affiliate_referrals = $db->fetchAll($sql);
		$agent_str .="<table width='100%' cellpadding='0' cellspacing='0'>";
		foreach($bp_affiliate_referrals as $bp_affiliate_referral){
			$agent_str .="<tr >
			<td valign='top' width='90%' style='font-size:10px;'><img src='images/user_go.png' align='absmiddle' /> ".getCreator($bp_affiliate_referral['agent_id'] , 'agent' )."</td>
			<td valign='top' width='10%' style='font-size:10px;'>".$bp_affiliate_referral['total']."</td>
			</tr>";
		}
		$agent_str .="</table>";
		$agent_str .="</td>";
		$agent_str .="</tr>";
}



$smarty->assign('date_selection' , True);

$smarty->assign('agent_str' , $agent_str);
$smarty->assign('job_order_count' , $job_order_count);
$smarty->assign('service_agreement_count' , $service_agreement_count);
$smarty->assign('setup_fee_count' , $setup_fee_count);
$smarty->assign('quote_count' , $quote_count);
$smarty->assign('action_str' , $action_str);
$smarty->assign('affiliate_referral_total' , $affiliate_referral_total);
$smarty->assign('affiliate_referral_str' , $affiliate_referral_str);
$smarty->assign('affiliate_referrals_ctr' , count($affiliate_referrals));
$smarty->assign('total_no_of_leads_breakdowns' , $total_no_of_leads_breakdowns);
$smarty->assign('total_no_of_leads_registered' , $total_no_of_leads_registered);
$smarty->assign('current_date' , $current_date);
$smarty->display('ShowBDSummaryReport.tpl');
?>