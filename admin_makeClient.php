<?php
//2010-07-22 Normaneil Macutay <normanm@remotestaff.com.au>
// - disable send mail function to client


include './conf/zend_smarty_conf_root.php';
include 'time.php';
include './lib/addLeadsInfoHistoryChanges.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$page = $_REQUEST['page'];


$sql ="SELECT * FROM leads WHERE id = $id;";
$result = $db->fetchRow($sql);
$personal_id =$id; 
$agent_id = $result['agent_id'];
$client_name = $result['fname']." ".$result['lname'];
$client_email = $result['email'];

$sql ="SELECT fname, lname, email FROM agent a WHERE agent_no = $agent_id;";
$result = $db->fetchRow($sql);
$agent_name = $result['fname']." ".$result['lname'];
$agent_email = $result['email'];


	
	/* make a random string password for client */
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $rand_pw = '';    

    for ($p = 0; $p < 10; $p++) {
        $rand_pw .= $characters[mt_rand(0, strlen($characters))];
	}

	//update the leads status and personal_id
	//update the leads status and personal_id
	$data2 = array(
		'status'   => 'Client',
		'client_since'  => $ATZ,
		'personal_id' => $personal_id
		
	);
	
	//add history
	addLeadsInfoHistoryChanges($data2 , $id , $admin_id , 'admin');
	
	//update the leads status and personal_id
	$data = array(
		'status'   => 'Client',
		'client_since'  => $ATZ,
		'personal_id' => $personal_id,
		'password' => sha1($rand_pw)
	);
	$where = "id = ".$id;
	$db->update('leads', $data, $where);

	/*
	// SEND EMAIL TO NEW CLIENT	
	$link = 'http://'.$_SERVER['HTTP_HOST'].'/portal/index.php?user=client';
    $client_email_body =
	"<p style='margin-right:5px; margin-top:10px;padding:5px;font-family:Tahoma; font-size:13px;' >
    Hi  ".$client_name." ,<br /> <br />
    Welcome to RemoteStaff!   <br /><br />
    Your login account details has been created. ".
	"Click the following link and enter your information below to login:
	<br><br>".$link."<br><br>
	Email: ".$client_email."<br>
	Password: ".$rand_pw.
	"<br><br>
	Once you have logged in, you may opt to change your password anytime using 'change password' link <br /><br >
	If there’s anyway we can help you with anything, please feel free to contact us. <br /><br />
	Best Regards,<br>
    RemoteStaff Administrator
    </p>";
	   
	$mail = new Zend_Mail();
	$mail->setBodyHtml($client_email_body);
	$mail->setFrom('info@remotestaff.com.au', 'RemoteStaff');
	if(!TEST) {
		$mail->addTo($client_email, $client_name);
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Devs');
	}
	$mail->setSubject('LOGIN DETAILS');
	$mail->send($transport);
	*/

$body = "Dear ".$agent_name.",<br /><br />
		Good news! <br /><br /><b>".$client_name."</b> one of the leads from your business network has just decided to take a Remote Staff Service provider on board.
		<br /><br />
		All papers are in and custom recruitment will commence tomorrow. <br /><br />
		Commissions applicable for this lead will be forwarded to you in details once a staff member is placed and active. <br /><br />
		Feel free to talk more about <a href='http;//www.remotestaff.com.au'>www.remotestaff.com.au</a>   to your business network.  Surely such a great opportunity is worth spreading around!<br /><br />
		If there’s anyway we can help you with anything, please feel free to contact us. <br /><br />
		<img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='241' height='70'>";
//echo $body;
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('info@remotestaff.com.au', 'RemoteStaff');
if(!TEST) {
	$mail->addTo($agent_email, $agent_name);
}else{
	$mail->addTo('devs@remotestaff.com.au', 'Devs');
}
$mail->setSubject('Information from RemoteStaff');
$mail->send($transport);

header("location:admin_apply_action.php?id=$id&page=client");

?>
