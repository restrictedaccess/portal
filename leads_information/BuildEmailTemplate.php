<?php

function BuildEmailTemplate($mess , $text ,$template){
	$site = $_SERVER['HTTP_HOST'];
	global $db;
	
	
	if($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL){
		
		$sql=$db->select()
			->from('agent')
			->where('agent_no = ?' ,$_SESSION['agent_no']);
		$agent = $db->fetchRow($sql);
		
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
		
		$agent_code = '101';
		$name = "Admin : ".$admin['admin_fname'].' '.$admin['admin_lname'];
		$email = $admin['admin_email'];
		
		$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s<br>%s<br>%s</div>" ,$admin['signature_notes'],$name,$admin['signature_company'],$admin['signature_contact_nos'],$admin['signature_websites']);
		

	}else{
		//header("location:index.php");
		die("Session Expires. Please re-login");
	}
	
	
	if($site == "localhost") $site = "www.remotestaff.com.au";
	
	
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
	
	// Processes \r\n's first so they aren't converted twice.
	$newstr = str_replace($order, $replace, $mess);
	
	if($template == "signature") {
		$body =" <div style='font:12px Tahoma; padding:10px;'>
							<div align='justify' style='padding:15px;margin-top:10px;' >".stripslashes($newstr)."</div>
							<div align='justify' style='padding:15px;margin-top:10px;' >".$text."</div>
							<div style='margin-top:20px;'>
							<a href='http://$site/$agent_code'>
							<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>
							
							<span style='color:#00CCCC;'>$site</span>
							".$signature_notes."
							</div>
						</div>";
		return $body;
		
	} else {
		
			$body = "<div align='justify' style='padding:15px;margin-top:10px;' >".stripslashes($newstr)."</div>
					 <div align='justify' style='padding:15px;margin-top:10px;' >".$text."</div>";
			return $body;			 
	}
			
}			
			
?>			