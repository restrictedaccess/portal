<?php
//2010-09-29 Normaneil Macutay <normanm@remotestaff.com.au>
// - disable email function


include './conf/zend_smarty_conf_root.php';
include 'config.php';
include 'function.php';
include 'time.php';

if($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL){
		
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$_SESSION['agent_no']);
	$agent = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	
	$agent_code = $agent['agent_code'];
	$name = "BP : ".$agent['fname'].' '.$agent['lname'];
	$email = $agent['email'];
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s</div>" ,$name,$agent['agent_address'],$agent['agent_contact']);
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	
	$agent_code = '101';
	$name = "Admin : ".$admin['admin_fname'].' '.$admin['admin_lname'];
	$email = $admin['admin_email'];
	
		
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s<br>%s<br>%s</div>" ,$admin['signature_notes'],$name,$admin['signature_company'],$admin['signature_contact_nos'],$admin['signature_websites']);
	
	

}else{
	
	die("Session Expires. Please re-login");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



function CheckRan($ran,$table){
	$query = "SELECT * FROM $table WHERE ran = '$ran';";
	$result =  mysql_query($query);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
		// The random character is existing in the table
		$ran = get_rand_id();
		return $ran;
	}else{
		return $ran;
	}
}

$leads_id = $_REQUEST['leads_id'];
$ran = get_rand_id();
$ran = CheckRan($ran,'job_order');
$site = $_SERVER['HTTP_HOST'];

$data = array(
		'leads_id' => $leads_id, 
		'created_by_id' => $created_by_id, 
		'created_by_type' => $created_by_type,
		'date_created' => $ATZ,
		'date_posted' => $ATZ,
		'status' => 'posted',
		'ran' => $ran,
		'job_order_notes' => 'created and filled up in behalf of the client'
	);
	
$db->insert('job_order', $data);
$job_order_id = $db->lastInsertId();



$query ="SELECT * FROM leads WHERE id = $leads_id;";
$result = $db->fetchRow($query);

$text =  "<p>The job specification form below has been created by   ".$name." for you. 
			<br><br /> Please click on the link below<br><br /><b>Job Order #".$job_order_id."</b><br /><br />
			<a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran' target='_blank'>									http://$site/portal/pdf_report/job_order_form/?ran=".$ran."
									</a>
			</p><p>Should you want to edit and add more to this job specification, please click on the link and overwrite. Please don’t forget to click on &quot;SUBMIT&quot; button. </p>";

$body =" <div style='font:12px Tahoma; padding:10px;'>
				<div align='justify' style='padding:15px;margin-top:10px;' >Dear ".$result['fname']." ".$result['lname'].",".$text."</div>
				<div style='margin-top:20px;border-top:#CCCCCC solid 1px;'><br /><br />
				<a href='$site/$agent_code'>
				<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>
				<span style='color:#00CCCC;'>$site</span><br /><br />
				".$signature_notes."
				</div>
			</div>";
					
						
$recipient_name = $result['fname']." ".$result['lname'];
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom($email, $name);

if(! TEST){
	$mail->addTo($result['email'] , $recipient_name);
}else{
	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
}

$mail->setSubject('RemoteStaff Job Specification form [ '.$site.' ]');
//$mail->send($transport);

echo "<div style='padding:10px; font:12px Arial; line-height:25px;'>New Job Order #".$job_order_id." has been created and sent to ".$recipient_name." [ ".$result['email']." ]<div><a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran' target='_blank'>http://$site/portal/pdf_report/job_order_form/?ran=".$ran."</a></div></div>";
?>