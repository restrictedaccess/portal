<?php

/*

ALTER TABLE `agent` ADD COLUMN `access_all_leads` ENUM('yes','no') NOT NULL DEFAULT 'no' COMMENT 'yes => can see all leads in the leads list' AFTER `access_aff_leads`;

*/
include './conf/zend_smarty_conf.php';
include './BD/lib/AddAgentHistoryChanges.php';
require_once dirname(__FILE__)."/lib/Curl.php";
if(!$_SESSION['admin_id'])
{
	header("location:index.php");
}

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


include 'lib/validEmail.php';

$filename = basename($_SERVER['SCRIPT_FILENAME']);

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$display = 'none';
$mode = 'add';
$btn ='<input type="submit" name="add" value="Add"  />';
$agent_no = $_REQUEST['agent_no'];

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];


//parse admin info
$sql = $db->select()
	->from('admin')
	->where('admin_id =?' , $admin_id);
$admin = $db->fetchRow($sql);

$curl = new Curl();
		
// SYNC to login_credentials
$base_api_url = "";

if (TEST){
	$base_api_url = "http://test.api.remotestaff.com.au";
}else{
	$base_api_url = "https://api.remotestaff.com.au";
}

if($agent_no){
	$display = 'block';
	$sql = $db->select()
		->from('agent')
		->where('agent_no =?' , $agent_no);
	$agent = $db->fetchRow($sql);
	$btn ='<input type="submit" name="update" value="Update"  />';
	$mode = 'edit';
	$smarty->assign('agent' , $agent);
	
	$ShowAgentInfoChangesHistory = ShowAgentInfoChangesHistory($agent_no);
	$smarty->assign('ShowAgentInfoChangesHistory' , $ShowAgentInfoChangesHistory);
}

$add_flag =  True;
$update_flag =  True;

if(isset($_POST['new'])){
	unset($agent);
	$mode = 'add';
	$display = 'block';
	$btn ='<input type="submit" name="add" value="Add"  />';
	$smarty->assign('agent' , $agent);
}

if(isset($_POST['update'])){

	$agent_no = $_POST['agent_no'];
	$fname =  trim($_POST['fname']);
	$lname =  trim($_POST['lname']);
	$email =  trim($_POST['email']);
	
	$agent_address =  trim($_POST['agent_address']);
	$agent_contact =  trim($_POST['agent_contact']);
	
	$status =  trim($_POST['status']);
	$access_all_leads =  trim($_POST['access_all_leads']);
	$access_aff_leads =  trim($_POST['access_aff_leads']);
	
	if(!$agent_no){
		$update_flag =  False;
		$display = 'block';
		$result_msg = 'Agent no is missing';
	}
	$data = array(
		'fname' => $fname,
		'lname' => $lname,
		'email' => $email,
		'agent_address' => $agent_address,
		'agent_contact' => $agent_contact,
		'access_all_leads' => $access_all_leads,
		'access_aff_leads' => $access_aff_leads,
		'status' => $status
		
	);
	if($agent['email'] != $email){
		//validate the email address
		if (!validEmailv2($email)){
			$update_flag =  False;
			$display = 'block';
			$result_msg = 'Invalid Email Address';
		}
		
		//check the email if existing
		$sql = $db->select()
			->from('agent' , 'agent_no')
			->where('email =?' , $email);
		$existing_agent_no = $db->fetchOne($sql);
		if($existing_agent_no){
			$update_flag =  False;
			$display = 'block';
			$result_msg = 'Email Address already exist. Please try a different email address';
		}
	}
	
	if(!$fname){
		$update_flag =  False;
		$display = 'block';
		$result_msg = 'First Name is required!';
	}
	
	if(!$lname){
		$update_flag =  False;
		$display = 'block';
		$result_msg = 'Last Name is required!';
	}
	
	if($update_flag ==  True){
		
		AddAgentHistoryChanges($data , $agent_no, $_SESSION['admin_id'] , 'admin');
		$where = "agent_no = ".$agent_no;
		$db->update('agent' , $data , $where);
		
		$curl->get($base_api_url . "/mongo-index/sync-login-credentials/", array("email" => $data["email"], "tracking_code" => "business_developer_" . $data["email"]));
		
		
		
		$display = 'none';
		$result_msg = $fname." ".$lname." profile updated";
		unset($data);
		$btn ='<input type="submit" name="add" value="Add"  />';
		$smarty->assign('agent' , $data);
	}else{
		$agent = $data;
		$smarty->assign('agent' , $data);
	}
	
}


if(isset($_POST['add'])){
	$fname =  trim($_POST['fname']);
	$lname =  trim($_POST['lname']);
	$email =  trim($_POST['email']);
	$agent_password =  trim($_POST['agent_password']);
	$agent_address =  trim($_POST['agent_address']);
	$agent_contact =  trim($_POST['agent_contact']);
	
	$status =  trim($_POST['status']);
	$access_all_leads =  trim($_POST['access_all_leads']);
	$access_aff_leads =  trim($_POST['access_aff_leads']);
	
	
	
	//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads, agent_bank_account, aff_marketing_plans, companyname, companyposition, integrate, country_location, commission_type
	$sql="SELECT MAX(agent_code)AS agent_code FROM agent;";
	$result = $db->fetchRow($sql);
	$agent_code = $result['agent_code'] + 001;
	$data = array(
		'fname' => $fname,
		'lname' => $lname,
		'agent_password' => sha1($password),
		'email' => $email,
		'agent_address' => $agent_address,
		'agent_contact' => $agent_contact,
		'access_all_leads' => $access_all_leads,
		'access_aff_leads' => $access_aff_leads,
		'status' => $status,
		'agent_code' => $agent_code,
		'date_registered' => $ATZ
	);
	
	//validate the email address
	if (!validEmailv2($email)){
		$add_flag =  False;
		$display = 'block';
		$result_msg = 'Invalid Email Address';
	}
	
	//check the email if existing
	$sql = $db->select()
		->from('agent' , 'agent_no')
		->where('email =?' , $email);
	$existing_agent_no = $db->fetchOne($sql);
	if($existing_agent_no){
		$add_flag =  False;
		$display = 'block';
		$result_msg = 'Email Address already exist. Please try a different email address';
	}	
	
	if(!$fname){
		$add_flag =  False;
		$display = 'block';
		$result_msg = 'First Name is required!';
	}
	
	if(!$lname){
		$add_flag =  False;
		$display = 'block';
		$result_msg = 'Last Name is required!';
	}
	
	if($add_flag == True){
		$db->insert('agent' , $data);
		
		$display = 'none';
		$result_msg = "New Business Developer ".$fname." ".$lname." user added";
		
		$add_data = array(
			 'agent_no' => $db->lastInsertId(), 
			 'change_by_id' => $_SESSION['admin_id'], 
			 'change_by_type' => 'admin', 
			 'changes' => "New Business Developer ".$fname." ".$lname." user added", 
			 'date_change' => $ATZ
		);
		
		$db->insert('agent_history' , $add_data);
		
		
		
		$curl->get($base_api_url . "/mongo-index/sync-login-credentials/", array("email" => $data["email"], "tracking_code" => "business_developer_" . $data["email"]));
		
		unset($data);
		$btn ='<input type="submit" name="add" value="Add"  />';
		$smarty->assign('agent' , $data);
	}else{
		$smarty->assign('agent' , $data);
	}
		
}



//get all status of BP
$sql = $db->select()
	->from('agent' , 'status')
	->where('work_status =?' , 'BP')
	->group('status')
	->order('status');
$statuses = $db->fetchAll($sql);
foreach($statuses as $group_status){
	$bps_str .= "<div class='tabbertab'>";
	$bps_str .= "<h2>".$group_status['status']."</h2>";
	$bps_str .= "<table width='100%' cellpadding='2' cellspacing='1' bgcolor='#CCCCCC'>";
	$bps_str .= "<tr bgcolor='#333333'>";	
	$bps_str .= "<td width='3%' style='font-weight:bold;color:#FFFFFF;' >#</td>";
	$bps_str .= "<td width='25%' style='font-weight:bold;color:#FFFFFF;'>Fullname</td>";
	$bps_str .= "<td width='7%' align='center' style='font-weight:bold;color:#FFFFFF;'>Agent Code</td>";
	$bps_str .= "<td width='20%' align='center' style='font-weight:bold;color:#FFFFFF;'>Address</td>";
	$bps_str .= "<td width='20%' style='font-weight:bold;color:#FFFFFF;'>Contact Nos.</td>";
	$bps_str .= "<td width='15%' align='center' style='font-weight:bold;color:#FFFFFF;'>Access Affiliates Leads</td>";
	$bps_str .= "<td width='10%' align='center' style='font-weight:bold;color:#FFFFFF;'>Access All Leads</td>";
	$bps_str .= "</tr>";
		//get all BP depends on the status
		$sql = $db->select()
			->from('agent')
			->where('work_status =?' , 'BP')
			->where('status =?' ,$group_status['status'])
			->order('fname');
		//$bps_str .= $sql;		
		$bps = $db->fetchAll($sql);	
		$counter = 0;
		foreach($bps as $bp){
			$counter++;
			
			$det = new DateTime($bp['date_registered']);
			$date_registered = $det->format("F j, Y");
			
			
			$bps_str .= "<tr bgcolor='#FFFFFF'>";	
			$bps_str .= "<td>".$counter."</td>";
			$bps_str .= "<td><span style='float:right;'><a href='".$filename."?agent_no=".$bp['agent_no']."'><img src='images/b_edit.png' border='0'></a></span><div><a href='javascript:ShowBDProfile(".$bp['agent_no'].")'>".$bp['fname']." ".$bp['lname']."</a><div>";
			$bps_str .= "<div><small>".$bp['email']."</small><div>";
			$bps_str .= "<div style='color:#666666;'><small>Date Added : ".$date_registered."</small><div></td>";
			$bps_str .= "<td align='center'>".$bp['agent_code']."</td>";
			$bps_str .= "<td><small>".$bp['agent_address']."</small></td>";
			$bps_str .= "<td><small>".$bp['agent_contact']."</small></td>";
			$bps_str .= "<td align='center'>".$bp['access_aff_leads']."</td>";
			$bps_str .= "<td align='center'>".strtoupper($bp['access_all_leads'])."</td>";
			$bps_str .= "</tr>";
		}	
	
	$bps_str .= "</table>";
	$bps_str .= "</div>";	
				
}	

$statusArray=array("PENDING","REMOVED","ACTIVE");
for ($i = 0; $i < count($statusArray); $i++){

	if($agent['status'] == $statusArray[$i]){
		$status_options .= "<option selected value=\"$statusArray[$i]\">$statusArray[$i]</option>\n";
	}
	else{
		$status_options.= "<option value=\"$statusArray[$i]\">$statusArray[$i]</option>\n";
	}
}

$yes_no = array("NO","YES");
for ($i = 0; $i < count($yes_no); $i++) {

	if($agent['access_all_leads'] == $yes_no[$i]){
		$access_all_leads_options .= "<option selected value=\"$yes_no[$i]\">$yes_no[$i]</option>\n";
	}
	else{
		$access_all_leads_options.= "<option value=\"$yes_no[$i]\">$yes_no[$i]</option>\n";
	}
	
	if($agent['access_aff_leads'] == $yes_no[$i]){
		$access_aff_leads_options .= "<option selected value=\"$yes_no[$i]\">$yes_no[$i]</option>\n";
	}
	else{
		$access_aff_leads_options.= "<option value=\"$yes_no[$i]\">$yes_no[$i]</option>\n";
	}
	
	
}



////////////////
$smarty->assign('mode' , $mode);
$smarty->assign('filename',$filename);
$smarty->assign('btn' , $btn);
$smarty->assign('result_msg' , $result_msg);
$smarty->assign('status_options',$status_options);
$smarty->assign('access_all_leads_options',$access_all_leads_options);
$smarty->assign('access_aff_leads_options',$access_aff_leads_options);
$smarty->assign('display',$display);
$smarty->assign('bps_str' , $bps_str);

$smarty->assign('admin' , $admin);
$smarty->display('adminnaddagent.tpl');
?>