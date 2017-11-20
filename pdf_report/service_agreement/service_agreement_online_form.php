<?php
include('../../conf/zend_smarty_conf.php');
include('../../tools/CouchDBMailbox.php');
$smarty = new Smarty();

$pdf_path = "http://".$_SERVER['HTTP_HOST']."/portal/service-agreements/Service_Agreement.pdf";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$site = $_SERVER['HTTP_HOST'];

$ran = $_REQUEST['ran'];

if($ran==''){
    die("Page cannot be viewed");
}

$sql = $db->select()
   ->from('service_agreement', 'service_agreement_id')
   ->where('ran = ?' , $ran);
$service_agreement_id = $db->fetchOne($sql);
			
if(!$service_agreement_id){
    die("Invalid code");
}

$sql = $db->select()
   ->from(array('s' => 'service_agreement'), Array('service_agreement_id', 'quote_id', 'leads_id', 'created_by', 'created_by_type', 'date_created', 'accepted', 'date_accepted', 'ran', 'posted_by', 'posted_by_type', 'date_opened'))
   ->join(array('l' => 'leads'), 'l.id = s.leads_id', Array('fname', 'lname', 'email', 'company_name', 'company_address', 'mobile', 'officenumber'))
   ->where('service_agreement_id = ?' , $service_agreement_id);
$service_agreement = $db->fetchRow($sql);


if($service_agreement['posted_by'] !="" and $service_agreement['posted_by_type'] != ""){
    $creator = getCreatorSA($service_agreement['posted_by'], $service_agreement['posted_by_type']);
}else{
    $creator = getCreatorSA($service_agreement['created_by'], $service_agreement['created_by_type']);
}

$data = array('date_opened' => $ATZ);
$where = "service_agreement_id = ".$service_agreement_id;	
$db->update('service_agreement' , $data , $where);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	//echo "<pre>";
	//print_r($_POST);	
	//exit;
	
	$service_agreement_id = $_POST['service_agreement_id'];
	$starting_date = $_POST['starting_date'];
	$starting_date = date("Y-m-d", strtotime($starting_date));
	
	 	
	$data = array('accepted' => 'yes', 'date_accepted' => $ATZ);
	//print_r($data);
	$where = "service_agreement_id = ".$_POST['service_agreement_id'];	
	$db->update('service_agreement' , $data , $where);
	
	//$base_api_url = "http://test.api.remotestaff.com.au";
	
	//if(!TEST){
		//$base_api_url = "https://api.remotestaff.com.au";
	//}
	//sync to mongo
	file_get_contents($base_api_url . "/mongo-index/sync-service-agreement?service_agreement_id=" . $_POST['service_agreement_id']);
	
	
	//history
	$data = array(
        'leads_id' => $_POST['leads_id'], 
        'date_change' => $ATZ, 
        'changes' => sprintf('Accepted Service Agreement #%s ',$_POST['service_agreement_id']), 
        'change_by_id' => $_POST['leads_id'], 
        'change_by_type' => 'client'
    );
    $db->insert('leads_info_history', $data);
	
    //send email to BP and Admin
	$sql = $db->select()
	    ->from('leads')
		->where('id =?', $service_agreement['leads_id']);
	$lead = $db->fetchRow($sql);	
	$business_partner_id = $lead['business_partner_id'];	
	
	$sql = $db->select()
	    ->from('agent')
		->where('agent_no =?', $business_partner_id);
	$agent = $db->fetchRow($sql);
	

	$smarty->assign('lead', $lead);
	$smarty->assign('date_accepted', $ATZ);
	$smarty->assign('creator', $creator);
	
	$link = sprintf("<a href='http://%s/portal/pdf_report/service_agreement/service_agreement_online_form.php?ran=%s'>Service Agreement #%s</a>", $_SERVER['HTTP_HOST'], $service_agreement['ran'], $_POST['service_agreement_id']);
	
	
	$smarty->assign('link', $link);
	
	
	
	$message_for_admin = $smarty->fetch('for_admin_service_agreement_accepted_template.tpl');
	$message_for_client = $smarty->fetch('for_client_service_agreement_accepted_template.tpl');
	

	$subject = sprintf('Lead #%s %s %s accepted Remote Staff Service Agreement #%s', $lead['id'], $lead['fname'], $lead['lname'], $_POST['service_agreement_id']);
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = $message_for_admin;
    $to_array = array($creator['email'], 'orders@remotestaff.com.au', 'peachy@remotestaff.com.ph');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
	
	//send email to lead
	$subject = sprintf('Thank you %s %s for accepting Remote Staff Service Agreement #%s', $lead['fname'], $lead['lname'], $_POST['service_agreement_id']);
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = $message_for_client;
    $to_array = array($lead['email']);
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
	
	//include the csro assign to lead
	if($lead['csro_id'] !=""){
		//send email to csro
		
		$sql = $db->select()
			->from('admin')
			->where('admin_id =?', $lead['csro_id']);
		$csro = $db->fetchRow($sql);
		
		$smarty->assign('csro', $csro);
		$smarty->assign('lead', $lead);
	    $smarty->assign('date_accepted', $ATZ);
	    $smarty->assign('creator', $creator);
    	$smarty->assign('link', $link);
	    $message_for_csro = $smarty->fetch('for_csro_service_agreement_accepted_template.tpl');
		
		$subject = sprintf('Lead #%s %s %s accepted Remote Staff Service Agreement #%s', $lead['id'], $lead['fname'], $lead['lname'], $_POST['service_agreement_id']);
		$attachments_array =NULL;
		$bcc_array=array('devs@remotestaff.com.au');
		$cc_array = NULL;
		$from = 'No Reply<noreply@remotestaff.com.au>';
		$html = $message_for_csro;
		$to_array = array($csro['admin_email']);
		SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
	}
		
	//echo $creator['email']." ".$creator['name'];
	$service_agreement['accepted'] = 'yes';
	$service_agreement['date_accepted'] = $ATZ;


    $data = array('date_opened' => $ATZ);
    $where = "service_agreement_id = ".$_POST['service_agreement_id'];	
    $db->update('service_agreement' , $data , $where);
	
	//Set up auto creation of staff contract
	//file_get_contents($base_api_url . "/activate-prepaid-contract/setup-contract-from-service-agreement/?id={$service_agreement_id}&starting_date={$starting_date}");

	//Save the starting date in quote_details
	file_get_contents($base_api_url . "/activate-prepaid-contract/save-starting-date-in-quote-details/?id={$service_agreement_id}&starting_date={$starting_date}");
	
	
	//Save the accepeted version of Service Agreement by client for future reference for client and admin
	date_default_timezone_set("Asia/Manila");
	global $couch_dsn;
	//save details in couchdb
	$date_created_array = array(((int)date('Y')), ((int)date('m')), ((int)date('d')), ((int)date('H')), ((int)date('i')), ((int)date('s')));
	$filename_version = sprintf('Service_Agreement_Final_V%s-%s-%s_%s-%s-%s.pdf',  date('Y'), date('m'), date('d'), date('H'), date('i') , date('s'));
	//echo $filename_version;exit;
	$couch_client = new couchClient($couch_dsn, 'leads_accepted_service_agreements');
	$doc = new stdClass();
	$doc->leads_id = $service_agreement['leads_id'];
	$doc->service_agreement_id = $_POST['service_agreement_id'];
	$doc->filename = $filename_version;
	$doc->date_accepted = $date_created_array;
	$doc->generated_by = $_SERVER['SCRIPT_FILENAME'];
	$doc->version = $date_created_array;
	try {
		$response = $couch_client->storeDoc($doc);
		$myImage = file_get_contents($pdf_path);
		$doc = $couch_client->getDoc($response->id);
		$couch_client->storeAsAttachment($doc,$myImage,$filename_version,$content_type = 'application/pdf');
	} catch (Exception $e) {
	   echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	   exit(1);
	}
	//exit;
}

function getCreator($by , $by_type)
{
    global $db;
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$row = $db->fetchRow($query);
		$name = "c/o ".$row['work_status']." ".$row['fname'] ." ".$row['lname']." ".$row['email'];
		
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$row = $db->fetchRow($query);
		$name = "c/o ADMIN ".$row['admin_fname'] ." ".$row['admin_lname']." ".$row['admin_email'];
	}
	else{
		$name="";
	}
	return $name;
	
}

function getCreatorSA($by , $by_type)
{
    global $db;
	if($by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $by;";
		$row = $db->fetchRow($query);
		$data =array('name' => sprintf('%s %s', $row['fname'], $row['lname']), 'email' => $row['email']);
	}
	else if($by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $by;";
		$row = $db->fetchRow($query);
		$data =array('name' => sprintf('%s %s', $row['admin_fname'], $row['admin_lname']), 'email' => $row['admin_email']);
	}
	else{
		$name="";
	}
	return $data;
	
}


$sql = "SELECT service_agreement_details_id, service_agreement_details FROM service_agreement_details s WHERE service_agreement_id = $service_agreement_id;";
$details = $db->fetchAll($sql);
$details_str = array();
foreach($details as $d){
    $str =  $d['service_agreement_details'];
	$chars = preg_split('/Monthly/', $str, -1, PREG_SPLIT_NO_EMPTY);
	$string = sprintf('%s<br>Monthly %s', $chars[0], $chars[1]);
	array_push($details_str, $string);
}

$smarty->assign('ran', $ran);
$smarty->assign('pdf_path', $pdf_path);
$smarty->assign('service_agreement', $service_agreement);
$smarty->assign('details_str', $details_str);
$smarty->assign('creator', $creator);
$smarty->display('online_service_agreement_form.tpl');
exit;
?>