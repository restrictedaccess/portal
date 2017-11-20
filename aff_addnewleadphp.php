<?php
include('conf/zend_smarty_conf.php');
include './lib/validEmail.php';
include './lib/CheckLeadsFullName.php';
include 'time.php';

if($_SESSION['agent_no'] =="" or $_SESSION['agent_no'] == NULL){
	header("location:index.php");
}



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$created_by_id = $_SESSION['agent_no'];
$created_by_type = 'aff';
$site = $_SERVER['HTTP_HOST'];


$query="SELECT * FROM agent WHERE agent_no =$agent_no;";
$row= $db->fetchRow($query);
$name = $row['fname']." ".$row['lname'];
$agent_code = $row['agent_code'];
$length=strlen($agent_code);
	

// Get the Affiliate Business Partner
$sql = $db->select()
	->from('agent_affiliates' , 'business_partner_id')
	->where('affiliate_id =?' , $agent_no);
$business_partner_id = $db->fetchOne($sql);


$tracking_no =$agent_code."OUTBOUNDCALL";
$time=$_REQUEST['time'];
$jobresponsibilities=$_REQUEST['jobresponsibilities'];
$rsnumber=$_REQUEST['rsnumber'];
$needrs=$_REQUEST['needrs'];
$rsinhome=$_REQUEST['rsinhome'];
$rsinoffice=$_REQUEST['rsinoffice'];
$questions=$_REQUEST['questions'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$companyposition=$_REQUEST['companyposition'];
$companyname=$_REQUEST['companyname'];
$companyaddress=$_REQUEST['companyaddress'];
$email=trim($_REQUEST['email']);
$website=$_REQUEST['website'];
$officenumber=$_REQUEST['officenumber'];
$mobile=$_REQUEST['mobile'];
$companydesc=$_REQUEST['companydesc'];
$industry=$_REQUEST['industry'];
$noofemployee=$_REQUEST['noofemployee'];
$used_rs=$_REQUEST['used_rs'];
if ($used_rs=="Yes")
{
	$usedoutsourcingstaff=$_REQUEST['usedoutsourcingstaff'];
}
if ($used_rs=="No")
{
	$usedoutsourcingstaff="";
}
	
$companyturnover=$_REQUEST['companyturnover'];
$openreferral=$_REQUEST['openreferral'];
  
  
if(!$email){
	header("location:aff_addnewlead.php?mess=2");
	exit;
}  
if (!validEmailv2($email)){
	//invalid email address
	header("location:aff_addnewlead.php?mess=3");
	exit;	
}

//check the email if existing
$sql = $db->select()
	->from('leads', 'id')
	->where('email = ?', $email);
$id = $db->fetchOne($sql);

if($id != Null) {
	//email exist
	header("location:aff_addnewlead.php?mess=4");
	exit;
}

$data = array(
			'tracking_no' => $tracking_no,
			'timestamp' => $ATZ,
			'status' => 'New Leads' ,
			'remote_staff_competences' => $jobresponsibilities,
			'remote_staff_needed' => $rsnumber,
			'remote_staff_needed_when' => $needrs,
			'remote_staff_one_home' => $rsinhome, 
			'remote_staff_one_office' => $rsinoffice,
			'your_questions' => $questions, 
			'fname' => $fname,
			'lname' => $lname, 
			'company_position' => $companyposition,
			'company_name' => $companyname, 
			'company_address' => $companyaddress, 
			'email' => $email, 
			'website'=> $website, 
			'officenumber' => $officenumber, 
			'mobile' => $mobile, 
			'company_description' => $companydesc, 
			'company_size' => $noofemployee,
			'outsourcing_experience' => $used_rs, 
			'outsourcing_experience_description' => $usedoutsourcingstaff, 
			'company_turnover' => $companyturnover,
			'show_to_affiliate' => 'YES',
			'agent_id' => $agent_no,
			'business_partner_id' => $business_partner_id,
			'location_id' => LOCATION_ID,
			'registered_in' => 'added manually', 
			'registered_url' => $_SERVER['HTTP_HOST'].'/portal/'.basename($_SERVER['SCRIPT_FILENAME']),  
			'registered_domain' => LOCATION_ID 
			);
			
$db->insert('leads', $data);		
$leads_id = $db->lastInsertId();

CheckLeadsFullName();

$data = array('personal_id' => $leads_id);
$where = "id = ".$leads_id;
$db->update('leads', $data , $where);		


$history_changes = 'Added manually';
$changes = array(
			 'leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $agent_no, 
			 'change_by_type' => 'aff'
			 );
$db->insert('leads_info_history', $changes);


$sql="SELECT * FROM agent WHERE agent_no = $agent_no;";
$result = $db->fetchRow($sql);
$AFFname = $result['work_status']." : ".$result['fname']." ".$result['lname'] . " / ";

if ($business_partner_id){
	$sql="SELECT * FROM agent WHERE agent_no =".$business_partner_id;
	$result = $db->fetchRow($sql);
	$agent_code = $result['agent_code'];
	$BPname = $result['work_status']." : ".$result['fname']." ".$result['lname'];
	$name = $AFFname.$BPname;	
}else{
	$name = $AFFname;
}


$body =  "<table width='550' style='border:#62A4D5 solid 1px; font:11px tahoma;' cellpadding='3' cellspacing='0'>
		<tr bgcolor='#62A4D5'  >
			<td colspan='3' style='color:#FFFFFF;'><b>RemoStaff</b> New Lead added manually  [".$site."]</td>
		</tr>
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>PROMOTIONAL CODE</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$tracking_no."</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>Name</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$fname." ".$lname."</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>EMAIL</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$email."</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>MOBILE NO.</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$mobile."&nbsp;</td>
		</tr>
		
		
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY NAME</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$companyname."&nbsp;</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY POSITION</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$companyposition."&nbsp;</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY ADDRESS</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$companyaddress."&nbsp;</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>OFFICE NO.</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$officenumber."&nbsp;</td>
		</tr>
		
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY DETAILS</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$companydesc."&nbsp;</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>NO. OF EMP</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$noofemployee."&nbsp;</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>REMOTE STAFF DUTIES</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$jobresponsibilities."&nbsp;</td>
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>QUESTIONS / CONCERN</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$questions."&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan='3' valign='top' style='border-bottom:#CCCCCC solid 1px;'>&nbsp;</td>
			
		</tr>
		
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>LEADS OF</td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$name."&nbsp;</td>
		</tr>
		<tr>
			<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>DATE ADDED </td>
			<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
			<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$ATZ ."&nbsp;</td>
		</tr>
		</table><div style='color:#CCCCCC;'>Leads ID : $leads_id</div>";
		//echo $body;



$subject='New Lead Added Manually From Affiliate c\o '.$AFFname;
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('new_leads@remotestaff.com.au', 'RemoteStaff');

if(!TEST){
	$mail->addTo('chrisj@remotestaff.com.au', 'Chris Jankulovski');
}else{
	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
}
//$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil Macutay');
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
$mail->setSubject($subject);
$mail->send($transport);
					
header("location:aff_addnewlead.php?mess=1");
?>