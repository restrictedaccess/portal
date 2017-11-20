<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

$site = $_SERVER['HTTP_HOST'];
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_REQUEST['leads_id'];

if($leads_id == ""){
	die("Leads ID is missing");
}

$sql = $db->select()
	->from('leads')
	->where('id =?' , $leads_id);
$leads_info = $db->fetchRow($sql);	



if($site == "localhost") $site = "test.remotestaff.com.au";

if($_SESSION['admin_id']!="") {
	
	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$agent_code = '101';
	$name = "Admin : ".$admin['admin_fname'].' '.$admin['admin_lname'];
	$email = $admin['admin_email'];
	
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s<br>%s<br>%s</div>" ,$admin['signature_notes'],$name,$admin['signature_company'],$admin['signature_contact_nos'],$admin['signature_websites']);
	
}else if($_SESSION['agent_no']!="") {

	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$_SESSION['agent_no']);
	$agent = $db->fetchRow($sql);
	
	$agent_code = $agent['agent_code'];
	$name = "BP : ".$agent['fname'].' '.$agent['lname'];
	$email = $agent['email'];
	
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s</div>" ,$name,$agent['agent_address'],$agent['agent_contact']);
	
}else{
	die("Session Expired. Please re-login");
}



if (array_key_exists('_submit_check', $_POST)) {

	if(trim($_POST['email']) == "" or trim($_POST['email']) == " " or trim($_POST['email'])== NULL){
		
		$smarty->assign('email_error' , True);
	}else{

			$forgotpass_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $user_email ), 2, 14 );
			$forgotpass_time = time();
		
			$subject= "Remote Staff Temporary Password";
			$body =" <div style='font:12px Tahoma; padding:10px;'>
									<div align='justify' style='padding:15px;margin-top:10px;' >
										<p>".$leads_info['fname']." ".$leads_info['lname']."</p>
										<p><em>".$name."</em> have assigned a temporary  Remote Staff account for you as per your conversation earlier. This can be used when availing of any of our services online and for ease of convenience when making an inquiry. 
		</p>
		<p>Please click <a href='http://".$site."/portal/forgotpass_reset.php?k=".$forgotpass_code."'>HERE</a> to assign your own password if that doesn't work please copy and paste </p>
		<p>http://".$site."/portal/forgotpass_reset.php?k=". $forgotpass_code ." to your browser.</p>
									</div>
									<div style='margin-top:20px;'>
									<a href='http://$site/$agent_code'>
									<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>
									
									<span style='color:#00CCCC;'>$site</span>
									".$signature_notes."
									</div>
								</div>";
								
			$mail = new Zend_Mail();
			$mail->setBodyHtml($body);
			$mail->setFrom($email, $name);
			
			if(! TEST){
				$mail->addTo(trim($_POST['email']), $leads_info['fname']." ".$leads_info['lname']);
			}else{
				$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
			}
		
			$mail->setSubject($subject);
			$mail->send($transport);
			
			
			$data = array(	
						'email' => trim($_POST['email']), 
						'resetpassword_code' => $forgotpass_code, 
						'resetpassword_time' => $forgotpass_time, 
						'ref_table' => 'leads', 
						'ip_address' => $_SERVER['REMOTE_ADDR']
					);
			$db->insert('user_common_request' , $data);
			
			$smarty->assign('sent',True);
	}
	
}





$smarty->assign('site',$site);
$smarty->assign('leads_id' , $leads_id);
$smarty->assign('leads_info' , $leads_info);
$smarty->display('admin_bp_reset_password_for_lead.tpl');
?>