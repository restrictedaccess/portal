<?php
include '../conf/zend_smarty_conf.php';
include '../lib/validEmail.php';


$fieldname=array('email' => 'Email', 'supervisor_email' => 'Direct Person Email', 'sec_email' => 'Secondary Contact Person', 'acct_dept_email1' => 'Accounts Department Email 1', 'acct_dept_email2' => 'Accounts Department Email 2');

$error=0;
$error_msg="";

$email = trim($_REQUEST['email']);

//if (!validEmail($email)){ 
//    echo "Invalid Email Address => ". $email;
//    exit;
//}

foreach(array_keys($fieldname) as $array_key){
	if($_REQUEST[$array_key] != ""){
		if (!validEmailv2($_REQUEST[$array_key])){
		    $error_msg .= sprintf("Invalid Email Address =>  %s\n", $_REQUEST[$array_key]);
		    $error = $error + 1;
		}
	}
}
//echo $error_msg;
//exit;


if($_REQUEST['leads_id'] != ""){
	$sql = $db->select()
		->from('leads', 'email')
		->where('id = ?', $_REQUEST['leads_id']);
	$registered_email = $db->fetchOne($sql);
	if(trim($registered_email) != $email) {
		//check the email if existing
		$sql = $db->select()
			->from('leads', 'id')
			->where('email = ?', $email);
			$id = $db->fetchOne($sql);
			//echo $leads_id;
		if($id != Null) {
			echo "Existing Email Address => ". $email;
		    exit;
		}
	}
	
	//check the leads send invoice setting
	//id, leads_id, address_to, default_email_field, cc_emails, asl_default_email, asl_cc_emails, date_added, last_update
	$emails=array();
	$sql = "SELECT * FROM leads_send_invoice_setting l where leads_id=".$_REQUEST['leads_id'];
	$leads_send_invoice_setting = $db->fetchRow($sql);
	
	$emails[]= $leads_send_invoice_setting['default_email_field'];
	if($leads_send_invoice_setting['asl_default_email']){
	    $emails[] = $leads_send_invoice_setting['asl_default_email'];
	}
	if($leads_send_invoice_setting['cc_emails']){
	    $cc_emails=explode(',',$leads_send_invoice_setting['cc_emails']);
		foreach($cc_emails as $e){
			if($e){
				$emails[] = $e;
			}
		}
	}
	if($leads_send_invoice_setting['asl_cc_emails']){
	    $asl_cc_emails=explode(',',$leads_send_invoice_setting['asl_cc_emails']);
		foreach($asl_cc_emails as $e){
			if($e){
				$emails[] = $e;
			}
		}
	}
	
	if($emails){
		$emails= array_unique($emails);
		foreach($emails as $e){
			if($e){
				if($_REQUEST[$e] == ""){
					$error_msg .= sprintf("%s cannot be NULL. It is currently used in client's send invoice settings.\n", $fieldname[$e]);
					$error = $error + 1;
					//break;
				}				
			}
		}
	}
	
	
	
}else{
	$sql = $db->select()
		->from('leads', 'id')
		->where('email = ?', $email);
		$id = $db->fetchOne($sql);
	
	if($id != Null) {
		echo "Existing Email Address => ". $email;
		exit;
	}

}

if($error > 0){
	echo $error_msg;
    exit;
}
	
echo 'ok';
exit;
?>