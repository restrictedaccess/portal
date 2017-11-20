<?php
/*
2010-05-20 Normaneil Macutay <normanm@remotestaff.com.au>
	- checked the newly added email if existing in the admin table
	- checked the updated email if existing in the admin table
		
2009-11-13 Normaneil Macutay <normanm@remotestaff.com.au>
	- included the admin notify_timesheet_notes in the code
	
*/
include '../conf/zend_smarty_conf.php';
include '../time.php';
include('../blowfish/blowfish_password.php');
include '../lib/validEmail.php';


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	die("Session expires. Please re-login");
}

$sql = $db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id'] );
$admin = $db->fetchRow($sql);	


$email = trim($_REQUEST['admin_email']).trim($_REQUEST['domain']);
$email = trim($email);
if (!validEmailv2($email)){
	echo sprintf("ERROR : Invalid email address => [%s]", $email);
	exit;
}
//echo $email;
//exit;
$x = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-");
$admin_password = sprintf("%s%s%s%s%s%s%s%s", $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)]);


//echo $_REQUEST['mode'];
if($_REQUEST['userid'] == ""){
	$_REQUEST['userid'] = NULL;
}


$data = array(
	'admin_fname' => $_REQUEST['admin_fname'], 
	'admin_lname' => $_REQUEST['admin_lname'], 
	'admin_email' => $email ,
	'admin_password' => doEncryptPassword($admin_password),
	'adjust_time_sheet' => $_REQUEST['adjust_time_sheet'],
	'force_logout' => $_REQUEST['force_logout'],
	'notify_invoice_notes' => $_REQUEST['notify_invoice_notes'],
	'notify_timesheet_notes' => $_REQUEST['notify_timesheet_notes'],
	'csro' => $_REQUEST['csro'],
	'status' => $_REQUEST['status'],
	'view_camera_shots' => $_REQUEST['view_camera_shots'],
	'view_screen_shots' => $_REQUEST['view_screen_shots'],
	'view_rssc_dashboard' => $_REQUEST['view_rssc_dashboard'], 
	'edit_rssc_settings' => $_REQUEST['edit_rssc_settings'],
	'signature_notes' => $_REQUEST['signature_notes'],
	'signature_contact_nos' => $_REQUEST['signature_contact_nos'],
	'signature_company' => $_REQUEST['signature_company'],
	'signature_websites' => $_REQUEST['signature_websites'],
	'admin_created_on' => $ATZ,
	'manage_staff_invoice' => $_REQUEST['manage_staff_invoice'],
	'hiring_coordinator' => $_REQUEST['hiring_coordinator'],
	'manage_recruiters' => $_REQUEST['manage_recruiters'],
	'view_inhouse_confidential' => $_REQUEST['view_inhouse_confidential'],
	'edit_admin_settings' => $_REQUEST['edit_admin_settings'],
	'view_admin_calendar' => $_REQUEST['view_admin_calendar'],
	'userid' => $_REQUEST['userid']
);

if($_REQUEST['mode'] == "add"){
	//check the email if existing
	$sql = $db->select()
			->from('admin')
			->where('admin_email = ?' , trim($email));
	$results = $db->fetchAll($sql);		
	if(count($results)>0){
		echo "Email Already Exist. Please try to enter a different email add.";
		exit();
	}
	
	$db->insert('admin', $data);
	$admin_id = $db->lastInsertId();
	
	$changes = "Newly Added";
    $data2 = array(
        'admin_id' => $admin_id, 
	    'changes' => $changes, 
	    'changed_by_id' => $_SESSION['admin_id'], 
	    'date_changes' => $ATZ
    );
    $db->insert('admin_history', $data2);
	
	//send email
	$body = "<p>New Remote Staff Admin user added successfully ".$_SERVER['HTTP_HOST']."</p>
	<p>Date Created : $ATZ</p>
	<hr>
	<p>Name : ".$_REQUEST['admin_fname']." ".$_REQUEST['admin_lname']."</p>
	<p>Restriction : ".$_REQUEST['status']."</p>
	<p>Login Details</p>
	<p><b>Email : ".$email."</b></p>
	<p><b>Password : ".$admin_password."</b></p>";
	
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	if(!TEST){
	    $mail->setSubject('New RemoteStaff Admin Users');
	    $mail->addTo($email, $_REQUEST['admin_fname'].' '.$_REQUEST['admin_lname']);
		$mail->addCc('admin@remotestaff.com.au', 'admin@remotestaff.com.au');// Adds a recipient to the mail with a "Cc" header
		//$mail->addBcc('devs@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	}else{
	    $mail->addTo('devs@remotestaff.com.au', 'DEVS');
		$mail->setSubject('TEST New RemoteStaff Admin Users');
	}	
	
	$mail->send($transport);
	
	
	//send email to devs
	foreach(array_keys($data) as $array_key){
	    $history_changes .= sprintf("<li>[%s] => %s</li>", $array_key, $data[$array_key]);
    }
	$body = "<p>Admin ".$admin['admin_fname']." added new admin user</p>
	<ul>".$history_changes."</ul>";
	
	$mail = new Zend_Mail();
	$mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
	$mail->addTo('devs@remotestaff.com.au', 'DEVS');
    if(!TEST){
		$mail->setSubject("Admin ".$admin['admin_fname']." added new admin user");
	}else{
	    $mail->setSubject("TEST Admin ".$admin['admin_fname']." added new admin user");
	}	
	$mail->send($transport);
	
	echo "Admin new user [ ".$_REQUEST['admin_fname']." ".$_REQUEST['admin_lname']." ] added successfully . An email was sent to $email";
	exit;
	
}

if($_REQUEST['mode'] == "update"){
	unset($data['admin_password']);
	unset($data['admin_created_on']);
	
	//parse the original record
	$sql = $db->select()
			->from('admin')
			->where('admin_id = ?' , $_REQUEST['admin_id']);
	//echo $sql;		
	$result = $db->fetchRow($sql);
	
	//check the email if updated
	if(trim($email)!= trim($result['admin_email'])){
		//check the email if existing
		$sql = $db->select()
				->from('admin')
				->where('admin_email = ?' , trim($email));
		$results = $db->fetchAll($sql);		
		//echo $sql;
		if(count($results)>0){
			echo "Email Already Exist. Please try to enter a different email address.";
			exit();
		}
	}
	
	//get the difference of data
	$difference = array_diff_assoc($data,$result);
	if( count($difference) > 0){
		foreach(array_keys($difference) as $array_key){
			$history_changes .= sprintf("[%s] from %s to %s,", $array_key, $result[$array_key] , $difference[$array_key]);
			$history_changes2 .= sprintf("<li>[%s] from %s to %s</li>", $array_key, $result[$array_key] , $difference[$array_key]);
		}
	
		//echo "<pre>";
		//print_r($history_changes);
		//echo "</pre>";
		
		$where = "admin_id = ".$_REQUEST['admin_id'];	
		$db->update('admin', $data , $where);
		
		//insert history
		$history_changes=substr($history_changes,0,(strlen($history_changes)-1));
		$changes = $history_changes;
		$data = array(
			'admin_id' => $_REQUEST['admin_id'], 
			'changes' => $changes, 
			'changed_by_id' => $_SESSION['admin_id'], 
			'date_changes' => $ATZ
		);
		$db->insert('admin_history', $data);
		
		
		$body = "<p>Admin ".$admin['admin_fname']." updated admin user ".$result['admin_fname']."</p>
		<ul>".$history_changes2."</ul><p>Date : ".$ATZ."</p>";
		
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyHtml($body);
		$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
		
		if(!TEST){
			$mail->addTo('admin@remotestaff.com.au', 'Admin');
			$mail->addBcc('devs@remotestaff.com.au', 'Devs');
			$mail->setSubject("Admin ".$admin['admin_fname']." updated admin user ".$result['admin_fname']);
		}else{
			$mail->addTo('devs@remotestaff.com.au', 'Devs');
			$mail->setSubject("TEST Admin ".$admin['admin_fname']." updated admin user ".$result['admin_fname']);
		}
		$mail->send($transport);
		echo sprintf("Admin user [%s %s] updated successfully", $_REQUEST['admin_fname'], $_REQUEST['admin_lname']);
		exit;
	}else{
		echo "Detected no updates has been made.";
		exit;
	}
}

echo "<pre>";
print_r($data);
echo "</pre>";
?>