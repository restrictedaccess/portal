<?php
include '../conf/zend_smarty_conf.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../lib/validEmail.php';
include '../time.php';

//id, leads_id, date_change, changes, change_by_id, change_by_type
if($_SESSION['admin_id']!="") {
	
	$change_by_id = $_SESSION['admin_id'] ;
	$change_by_type = 'admin';
	
}else if($_SESSION['agent_no']!="") {

	$change_by_id = $_SESSION['agent_no'] ;
	$change_by_type = 'bp';
	
}else{
	die("Session Expired. Please re-login");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id=$_REQUEST['leads_id'];
$address_to=$_REQUEST['address_to'];
$name_to_be_in_invoice=$_REQUEST['name_to_be_in_invoice'];
$default_email_field=$_REQUEST['default_email_field'];
$default_email=$_REQUEST['default_email'];

$supervisor_staff_name=$_REQUEST['supervisor_staff_name'];
$secondary_contact_person=$_REQUEST['secondary_contact_person'];
$acct_dept_name1=$_REQUEST['acct_dept_name1'];
$acct_dept_name2=$_REQUEST['acct_dept_name2'];

$supervisor_email=$_REQUEST['supervisor_email'];
$sec_email=$_REQUEST['sec_email'];
$acct_dept_email1=$_REQUEST['acct_dept_email1'];
$acct_dept_email2=$_REQUEST['acct_dept_email2'];
$cc_emails=$_REQUEST['cc_emails'];

//asl settings
$asl_default_email=$_REQUEST['asl_default_email'];
$asl_cc_emails=$_REQUEST['asl_cc_emails'];

if($supervisor_email != ''){
    if (!validEmail($supervisor_email)){ 
	   die ("Invalid Email Address => Person Directly Working with Staff");
    }
}

if($sec_email != ''){
    if (!validEmail($sec_email)){ 
	   die ("Invalid Email Address => Secondary Contact Person");
    }
}

if($acct_dept_email1 != ''){
    if (!validEmail($acct_dept_email1)){ 
	   die ("Invalid Email Address => Accounts Department Staff Email 1");
    }
}

if($acct_dept_email2 != ''){
    if (!validEmail($acct_dept_email2)){ 
	   die ("Invalid Email Address => Accounts Department Staff Email 2");
    }
}

//set up the settings
//id, leads_id, address_to, default_email_field, cc_emails, date_added, last_update
$data = array(
    'leads_id' => $leads_id,
	'address_to' => $address_to,
	'default_email_field' => $default_email_field,
	'cc_emails' => $cc_emails,
	'asl_default_email' => $asl_default_email,
	'asl_cc_emails' => $asl_cc_emails,
);

//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$sql = $db->select()
    ->from('leads_send_invoice_setting')
	->where('leads_id =?', $leads_id);
$invoice_setting = $db->fetchRow($sql);


$id = $invoice_setting['id'];
if($id){
    unset($data['leads_id']);
    $data['last_update'] = $ATZ;
	$where = "id = ".$id;	
    $db->update('leads_send_invoice_setting' ,  $data , $where);
	
	// add leads history
	if($data['address_to'] != $invoice_setting['address_to']){
	    $settings_changes .= sprintf('Client Invoice default name from %s  to %s<br>' , $invoice_setting['address_to'], $data['address_to']);
	}
	
	if($data['default_email_field'] != $invoice_setting['default_email_field']){
	    $settings_changes .= sprintf('Client Invoice default email address from %s  to %s<br>' , $invoice_setting['default_email_field'], $data['default_email_field']);
	}
	
	if($data['cc_emails'] != $invoice_setting['cc_emails']){
	    $settings_changes .= sprintf('Client Invoice Ccd email addresses from %s  to %s<br>' , $invoice_setting['cc_emails'], $data['cc_emails']);
	}
	
	if($data['asl_default_email'] != $invoice_setting['asl_default_email']){
	    $settings_changes .= sprintf('Client ASL default email address recipient from %s  to %s<br>' , $invoice_setting['asl_default_email'], $data['asl_default_email']);
	}
	
	if($data['asl_cc_emails'] != $invoice_setting['asl_cc_emails']){
	    $settings_changes .= sprintf('Client ASL Ccd email address recipients from %s  to %s<br>' , $invoice_setting['asl_cc_emails'], $data['asl_cc_emails']);
	}
	
	
	$changes = array(
	    'leads_id' => $leads_id ,
	    'date_change' => $ATZ, 
		'changes' => $settings_changes, 
		'change_by_id' => $change_by_id, 
		'change_by_type' => $change_by_type
	);
	$db->insert('leads_info_history', $changes);
	
}else{
    $data['date_added'] = $ATZ;
	$db->insert('leads_send_invoice_setting', $data);
}	

//echo "<pre>";
//print_r($data);
//echo "</pre>";


//update the leads profile
$data = array(
    'supervisor_staff_name' => $supervisor_staff_name,
	'secondary_contact_person' => $secondary_contact_person,
	'acct_dept_name1' => $acct_dept_name1,
	'acct_dept_name2' => $acct_dept_name2,
	'supervisor_email' => $supervisor_email,
	'sec_email' => $sec_email,
	'acct_dept_email1' => $acct_dept_email1,
	'acct_dept_email2' => $acct_dept_email2
);

addLeadsInfoHistoryChanges($data ,$leads_id , $change_by_id , $change_by_type);
$where = "id = ".$leads_id;	
$db->update('leads' ,  $data , $where);

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);

//Sync client in mongodb
file_get_contents($base_api_url . "/mongo-index/sync-client-settings-by-id/?client_id={$leads_id}");
				
echo 'Successfully saved settings';

exit;	
?>