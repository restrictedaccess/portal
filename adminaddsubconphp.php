<?
include './conf/zend_smarty_conf_root.php';
include 'time.php';
include 'function.php';
include 'lib/validEmail.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$site = $_SERVER['HTTP_HOST'];

$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
$result = $db->fetchRow($sql);
$name = $result['admin_fname']." ".$result['admin_lname'];
$admin_email=$result['admin_email'];
$signature_company = $result['signature_company'];
$signature_notes = $result['signature_notes'];
$signature_contact_nos = $result['signature_contact_nos'];
$signature_websites = $result['signature_websites'];

if($signature_notes!=""){
	$signature_notes = "<p><i>$signature_notes</i></p>";
}else{
	$signature_notes = "";
}
if($signature_company!=""){
	$signature_company="<br>$signature_company";
}else{
	$signature_company="<br>RemoteStaff";
}
if($signature_contact_nos!=""){
	$signature_contact_nos = "<br>$signature_contact_nos";
}else{
	$signature_contact_nos = "";
}
if($signature_websites!=""){
	$signature_websites = "<br>Websites : $signature_websites";
}else{
	$signature_websites = "";
}

$signature_template = $signature_notes;
$signature_template .="<a href='http://$site/$agent_code'>
			<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";



$fname=$_REQUEST['fname']; 
$lname=$_REQUEST['lname']; 

$email=$_REQUEST['email']; 

//$email=validEmail($_REQUEST['email']); 
if (!validEmailv2($_REQUEST['email'])){
	//die("Subcontractor email is not a valid email");
	header("location:adminaddsubcon.php?mess=3");
	exit();
}

$skype=$_REQUEST['skype']; 
$phone=$_REQUEST['phone']; 

$userid =$_REQUEST['subcon'];
$kliyente=$_REQUEST['kliyente'];


$ads=$_REQUEST['ads'];
$pass=sha1('remote');
$flag=$_REQUEST['flag']; // admin choice 1=choose to add manually, 2 = selected from the applicant list..

if ($ads=="")
{
	$ads=0;
}

/// check the client Business Partner
$sqlAgentcheck="SELECT * FROM leads WHERE id=$kliyente";
$result = $db->fetchRow($sqlAgentcheck);
$agent_no = $result['agent_id'];
$client_name = $result['fname']." ".$result['lname'];
$company_name = $result['company_name'];

if($agent_no=="")
{
	$agent_no = 2;
}



/*
echo "fname : ".$fname."<br>".
	 "lname : ".$lname."<br>".
	 "email : ".$email."<br>".
	 "pass : ".$pass."<br>".
	 "skype : ".$skype."<br>";
*/
	

	 
	 

if($flag==1)
{
	$sqlEmailCheck="SELECT * FROM personal WHERE email = '$email';";
	$result = $db->fetchAll($sqlEmailCheck);
	$rowCount = count($result);
	
	if($rowCount > 0){
		header("location:adminaddsubcon.php?mess=1");
		exit();
	}
	$data = array (
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'pass'  => $pass, 
			'skype_id' => $skype,
			'datecreated' => $ATZ,
			'status' => 'New'
			);
	//print_r($data);		
	$db->insert('personal', $data);
	$userid = $db->lastInsertId();
	
	
}


$send_to_registered_email = 0; // false
if($flag > 1){
	$sql="SELECT * FROM personal WHERE userid = $userid;";
	$result = $db->fetchRow($sql);
	$registered_email = $result['email'];
	if($registered_email!=$email){
		// Check the email if exist
		$sqlEmailCheck="SELECT * FROM personal WHERE email = '$email';";
		$result = $db->fetchAll($sqlEmailCheck);
		$rowCount = count($result);
		if($rowCount > 0){
			header("location:adminaddsubcon.php?mess=1");
			exit();
		}
		
		$send_to_registered_email = 1; // true
	}
	//update the staff email and skype in personal table
	$data = array(
		'email'   => $email,
		'skype_id'  => $skype,
		'pass' => $pass
	);
	$where = "userid = ".$userid;
	$db->update('personal', $data, $where);
	
	
}

//Save to subcontractors table
$data = array(
	'leads_id' => $kliyente, 
	'agent_id' => $agent_no, 
	'userid' => $userid ,
	'posting_id' => $ads,
	'starting_date' => $ATZ,
	'date_contracted' => $ATZ,
	'status' => 'ACTIVE'
	);
	
$db->insert('subcontractors', $data);


$data= array(
			'posting_id' => $ads, 
			'userid' => $userid, 
			'status' => 'Sub-Contracted', 
			'date_apply' => $ATZ
			);
$db->insert('applicants', $data);


$sql="SELECT * FROM personal WHERE userid = $userid;";
$result = $db->fetchRow($sql);
$fullname = $result['fname']." ".$result['lname'];
$email = $result['email'];


$body = "
<style>
body{font-family:Tahoma; font-size:14px;}
#paragraph {margin-left:10px; margin-top:5px;}
#paragraph p{margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; font-size:13px;}
#paragraph h4 {margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; }
#paragraph h3 { color:#660000;margin-left:10px; margin-right:5px; margin-top:10px;padding:5px 0 5px 10px;font-family:Tahoma; }
#paragraph ol{font-family:Tahoma; font-size:13px;}
#paragraph li { margin-bottom:10px; margin-top:10px;}
#paragraph span { margin-top:20px; color:#003399; text-align:justify;font-family:Tahoma; font-size:13px; }
</style>
<table style=' border:#FFFFFF solid 1px;' width='100%'>
<tr><td height='105' width='100%%' valign='top'>
<div id='paragraph' style=''>
<p>$date<p>
<h4>Hi&nbsp; ".strtoupper($fullname)."</h4>
<h3>This is to confirm the receipt of your contract. Welcome to RemoteStaff!!! </h3>
<p><b>Before your first day please: </b></p>
<ol>
<li>Go to <a href='http://www.remotestaff.com.au/portal/' target='_blank'>Sub-contractors System</a> , log in and check out the Starter Kit. Log in as a 'Sub-Contractor'</li>
<ul> <b>Login Detail</b>
	<li><b>Email : ".$email."</b></li>
	<li><b>Password : remote</b></li>
</ul>
<li>Log in and test out your Skype account. (please note that this has already been created, and you just need to log-in to it.)</li>
<ul><li><b>Skype ID : ".$skype."</b></li>
	<li><b>Password : innovations1</b></li>
	
</ul>
This Skype account should be used for business purpose only. You are required to be logged in to this account during working hours. 
<li>Test your Headset</li>
<li>Download the RemoteStaff Screen Capture Installer from the Sub-Contractor System Website and install it into your computer.</li>
<ul> <b>Login Detail</b>
	<li><b>Email : ".$email."</b></li>
	<li><b>Password : remote</b></li>
</ul>
The log in details for your RemoteStaff Screen Capture is the same as your log-in details for the Sub-Contractor system.
<li>Log in to your Gmail company email address at <a href='http://www.gmail.com' target='_blank'>www.gmail.com</a></li>
<ul> <b>Login Detail</b>
	<li><b>Email : ".$email."</b></li>
	<li><b>Password : remote</b></li>
</ul>
All communication between you and your client must be made through this email address. 
<li>Download Yuuguu at <a href='http://www.yuuguu.com' target='_blank'>www.yuuguu.com</a> and create an account. Using your company Gmail address</li>
</ol>
<p><b>Please follow the steps below on your first day. </b></p>
<ol>
   <li>On your first day log in to the System and click <strong>&quot;Start Work&quot;</strong>. Be on time. Log in to the RSSC.
You have to be on the system and Skype on or before your starting working time.</li>
  
   <li>Wait for me or the client to contact you via Skype.  Your client will introduce himself to you. Your client's name is <b>".strtoupper($client_name." ( ".$company_name)." )</b> </li>
   <li>While waiting, please read and study the resources on the Sub-Contractor System. After the introduction, you will be working <strong>DIRECTLY</strong> with your client. We will <strong>NOT</strong> project manage you when it comes to your tasks and activities with your client, but we check on your attendance and online visibility. Work and task related issues should be discussed directly with the client.</li>
   
  
</ol>

<span><i>**Please note that you cannot negotiate anything with the client when it comes to problems regarding the work set-up, systems, compensation and attendance. You have to discuss this directly with the RemoteStaff team.    </i></span>
<p>&nbsp;</p>

<p>Welcome to the team! Have a wonderful and productive  first working day! </p>
<p>Cheers!</p>
<p>".$signature_template."</p>
</div>
</td></tr>
</tr>
</table>
";


$to = "normanm@remotestaff.com.au";
$recipient_name = "Normaneil E. Macutay";

$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom($admin_email, $name);

//registered email
if($send_to_registered_email == 1 ){
	$mail->addTo($registered_email, $fullname);
}

//new email
//$mail->addTo($to, $fullname);
$mail->addTo($email, $fullname);
//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject('Welcome to RemoteStaff');
$mail->send($transport);

header("location:subconlist.php");









?>


