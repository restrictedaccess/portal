<?php
include './conf/zend_smarty_conf_root.php';
include 'time.php';
include 'function.php';

if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$affiliate_id = $_REQUEST['affiliate_id'];
$other_affiliate_id = $_REQUEST['other_affiliate_id'];
$agent_id = $_SESSION['agent_no'];


if($affiliate_id!=""){
	$affiliate = $affiliate_id;
}
if($other_affiliate_id!=""){
	$affiliate = $other_affiliate_id;
}


if($affiliate_id == "" and $other_affiliate_id == "" ){
	$affiliate = $agent_id;
}



if($affiliate!=$agent_id){
	$sql="SELECT * FROM agent WHERE agent_no = $affiliate;";
	$result = $db->fetchRow($sql);
	$AFFname = $result['work_status']." : ".$result['fname']." ".$result['lname'] . " / ";
}



$sql="SELECT * FROM agent WHERE agent_no =".$_SESSION['agent_no'];
$result = $db->fetchRow($sql);
$agent_code = $result['agent_code'];
$BPname = $result['work_status']." : ".$result['fname']." ".$result['lname'];
$name = $AFFname.$BPname;

//$tracking_no =$agent_code."OUTBOUNDCALL";
$tracking_no = $_REQUEST['tracking_no'];


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
$email=$_REQUEST['email'];
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
//////////////////////////////////////
// create a personal id 

$y =date('Y');
$m =date('m');
$d= date('d');
$date =$y."-".$m."-".$d; 

$sql="SELECT * FROM leads  WHERE DATE(timestamp) = '$date';";
$result = $db->fetchAll($sql);
$ctr=count($result);
if ($ctr >0 )
{
	$ctr=$ctr+1;
	$personal_id="L".$y.$d.$m."-".$ctr;	
}
else
{	$ctr=1;
	$personal_id="L".$y.$d.$m."-".$ctr;	
}
  

$data = array(
		'tracking_no' => $tracking_no,
		'timestamp' => $ATZ ,
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
		'website' => $website, 
		'officenumber' => $officenumber, 
		'mobile' => $mobile, 
		'company_description' => $companydesc, 
		'company_size' => $noofemployee, 
		'outsourcing_experience' => $used_rs, 
		'outsourcing_experience_description' => $usedoutsourcingstaff, 
		'company_turnover' => $companyturnover,
		'personal_id' => $personal_id,
		'agent_id' => $affiliate,
		'business_partner_id' => $agent_id
		);
$db->insert('leads', $data);		
//print_r($data);		
$leads_id = $db->lastInsertId();
$site = $_SERVER['HTTP_HOST'];
$body =  "<table width='550' style='border:#62A4D5 solid 1px; font:11px tahoma;' cellpadding='3' cellspacing='0'>
<tr bgcolor='#62A4D5'  >
	<td colspan='3' style='color:#FFFFFF;'><b>RemoStaff</b> New Lead Added from Business Partner Section [".$site."]</td>
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
$subject='New Lead Added From Sales Staff c\o '.$name;
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'RemoteStaff');
if(!TEST){
	$mail->addTo('chrisj@remotestaff.com.au', 'Chris Jankulovski');
}else{
	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
}
//$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil Macutay');
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
$mail->setSubject($subject);
$mail->send($transport);


//add leads info history changes
$history_changes = 'Added manually';
$changes = array(
			 'leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $_SESSION['agent_no'], 
			 'change_by_type' => 'bp'
			 );
$db->insert('leads_info_history', $changes);
/*
$message = "New Lead added <span onclick=javascript:window.open('./viewLead.php?id=$leads_id','_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no')>".$fname." ".$lname."</span>";
//print_r($message);
$data = array(
		'users_id' => $agent_id, 
		'users_type' => 'agent', 
		'date_created' => $ATZ, 
		'message' => $message
		);
$db->insert('sticky_notes', $data);		
*/
header("location:addnewlead.php?mess=1");
?>



