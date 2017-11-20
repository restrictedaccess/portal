<?php
/**
 * 
 * Class responsible for updating leads information
 *
 * @version 0.1 - Initial commit on Leads Information
 * 
 * 02-18-2015 - Added Solr Leads Syncer Functionality - Marlon Peralta
 * 
 */
include('conf/zend_smarty_conf.php');
include './lib/addLeadsInfoHistoryChanges.php';
include ('./leads_information/AdminBPActionHistoryToLeads.php');
include './lib/validEmail.php';
include './lib/CheckLeadsFullName.php';
include 'function.php';
include 'conf.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$url = $_REQUEST['url'];//basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];
$query_string = $_SERVER['QUERY_STRING'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$mode = "Add";	

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'bp';
	
	$promo_code = $agent['agent_code'];
	$smarty->assign('agent_section',True);
	
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';

	$smarty->assign('admin_section',True);	
	$promo_code = '101';
	$admin_status=$_SESSION['status'];
	

}else{
	header("location:index.php");
}

$leads_id=$_REQUEST['leads_id'];
$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];

$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}


if (array_key_exists('_submit_check', $_POST)) {

	$status = 0;
	$mode =  $_POST['mode'];
	$leads_id = $_POST['leads_id'];
	//leads info
    $fname = stripslashes(trim($_POST['fname']));
	$lname = stripslashes(trim($_POST['lname']));
	$status = $_POST['status'];
	
	$tracking_no = $_POST['tracking_no'];
	
	
	$rating = $_POST['star'];
	$email = trim($_POST['email']);
	//$email_receives_invoice = $_POST['email_receives_invoice'];
	$leads_country = $_POST['leads_country'];

	$business_partner_id = $_POST['business_partner_id'];
	$agent_id = $_POST['agent_id'];
	if($agent_id == "") $agent_id = $business_partner_id;
	
	$company_name = stripslashes($_POST['company_name']);
	$company_position = stripslashes($_POST['company_position']);
	$company_address = stripslashes($_POST['company_address']);
	$website = stripslashes($_POST['website']);
	$officenumber = stripslashes($_POST['officenumber']);
	$mobile = stripslashes($_POST['mobile']);
	
	//$company_industry = stripslashes($_POST['company_industry']);
	//echo "<pre>";
	//print_r($company_industry);
	foreach($_POST['company_industry'] as $industry){
		$company_industry .= sprintf('%s,', $industry);
	}
	if($company_industry){
		$company_industry=substr($company_industry,0,(strlen($company_industry)-1));
	}
	//echo $company_industry;
	//echo "</pre>";
	//exit;
	$company_size = stripslashes($_POST['company_size']);
	$company_turnover = stripslashes($_POST['company_turnover']);
	$company_description = stripslashes($_POST['company_description']);
	//$call_time_preference=$_POST['call_time_preference'];
	$remote_staff_needed = stripslashes($_POST['remote_staff_needed']);
	
	$remote_staff_needed_when = stripslashes($_POST['remote_staff_needed_when']);
	$remote_staff_one_home = stripslashes($_POST['remote_staff_one_home']);
	$remote_staff_one_office = stripslashes($_POST['remote_staff_one_office']);
	$remote_staff_competences = stripslashes($_POST['remote_staff_competences']);
	$your_questions = stripslashes($_POST['your_questions']);
	
	$leads_location = stripslashes($_POST['leads_location']);
	
	
	$acct_dept_name1 = stripslashes($_POST['acct_dept_name1']);
	$acct_dept_email1 = stripslashes($_POST['acct_dept_email1']);
	$acct_dept_contact1 = stripslashes($_POST['acct_dept_contact1']);

	$acct_dept_name2 = stripslashes($_POST['acct_dept_name2']);
	$acct_dept_email2 = stripslashes($_POST['acct_dept_email2']);
	$acct_dept_contact2 = stripslashes($_POST['acct_dept_contact2']);

	$supervisor_staff_name = stripslashes($_POST['supervisor_staff_name']);
	$supervisor_job_title = stripslashes($_POST['supervisor_job_title']);
	
	$supervisor_skype = stripslashes($_POST['supervisor_skype']);
	$supervisor_email = stripslashes($_POST['supervisor_email']);
	$supervisor_contact = stripslashes($_POST['supervisor_contact']);
	$business_owners = stripslashes($_POST['business_owners']);
	$business_partners = stripslashes($_POST['business_partners']);
	
	$registered_in = $_POST['registered_in'];
	
	$secondary_contact_person = stripslashes($_POST['secondary_contact_person']);
	$sec_email = stripslashes($_POST['sec_email']);
	$sec_phone = stripslashes($_POST['sec_phone']);
	$sec_position = stripslashes($_POST['sec_position']);
	$note = stripslashes($_POST['note']);
	$preffered_communication = $_POST['preffered_communication'];
	$csro_id = $_POST['csro_id'];
	$inquiring_about = $_POST['inquiring_about'];
	
	$hiring_coordinator_id = $_POST['hiring_coordinator_id'];
	$leads_skype_id = $_POST['leads_skype_id'];
	
	$state = trim($_POST['state']);
	$gender = $_POST['gender'];
	$abn_number = $_POST['abn_number'];
	$is_test = $_POST['is_test'];
	
	if($hiring_coordinator_id == ""){
	    $hiring_coordinator_id = NULL;
	}
	
	if(!$csro_id){
		$csro_id = NULL;
	}
	
	if (!validEmailv2($email)){
		//Invalid Email Address
		//echo $email;exit;
		$status = 1;
		$smarty->assign('email_invalid', True);
		
	}
	
	if($sec_email != ""){
		if(!validEmailv2($sec_email)){
			//Invalid Email Address
			$status = 1;
			$smarty->assign('sec_email_invalid', True);
		}
	}
	if($mode == "Add"){
		//check the email if existing
		$sql = $db->select()
			->from('leads', 'id')
			->where('email = ?', $email);
			$id = $db->fetchOne($sql);
			//echo $leads_id;
		if($id != Null) {
			$status = 1;
			$smarty->assign('email_exist', True);
		}
	}else{
		$sql = $db->select()
			->from('leads', 'email')
			->where('id = ?', $leads_id);
		$registered_email = $db->fetchOne($sql);
		//echo $sql;
		if(trim($registered_email) != $email) {
				//check the email if existing
				$sql = $db->select()
					->from('leads', 'id')
					->where('email = ?', $email);
					$id = $db->fetchOne($sql);
					//echo $leads_id;
				if($id != Null) {
					$status = 1;
					$smarty->assign('email_exist', True);
				}
				//echo $mode."<br>Email : ".$email."<br>Registered Email : ".$registered_email;
		}
		
	}
	
	//exit;
	
	if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
		if($tracking_no == "") {
			$sql = $db->select()
				->from('agent' ,'agent_code')
				->where('agent_no =?',$business_partner_id);
			$agent_code = $db->fetchOne($sql);	
			$tracking_no =$agent_code."INBOUNDCALL";
		}
	}else{
		if($tracking_no == "") {
			$tracking_no ="101INBOUNDCALL";
		}
	}	
	
			if($mode == "Add"){
				$data = array(
						'tracking_no' => $tracking_no,
						'agent_id' => $agent_id, 
						'business_partner_id' => $business_partner_id, 
						'timestamp' => $ATZ, 
						'status' => $status,
						'remote_staff_competences' => $remote_staff_competences, 
						'remote_staff_needed' => $remote_staff_needed, 
						'remote_staff_needed_when' => $remote_staff_needed_when, 
						'remote_staff_one_home' => $remote_staff_one_home, 
						'remote_staff_one_office' => $remote_staff_one_office, 
						'your_questions' => $your_questions, 
						'lname' => $lname, 
						'fname' => $fname, 
						'company_position' => $company_position, 
						'company_name' => $company_name, 
						'company_address' => $company_address, 
						'email' => $email, 
						//'email_receives_invoice' => $email_receives_invoice, 
						'website' => $website, 
						'officenumber' => $officenumber, 
						'mobile' => $mobile, 
						'company_description' => $company_description, 
						'company_industry' => $company_industry, 
						'company_size' => $company_size, 
						'company_turnover' => $company_turnover, 
						'rating' => $rating, 
						'leads_country' => $leads_country,
						'state' => $state, 
						'acct_dept_name1' => $acct_dept_name1, 
						'acct_dept_name2' => $acct_dept_name2, 
						'acct_dept_contact1' => $acct_dept_contact1, 
						'acct_dept_contact2' => $acct_dept_contact2, 
						'acct_dept_email1' => $acct_dept_email1, 
						'acct_dept_email2' => $acct_dept_email2, 
						'supervisor_staff_name' => $supervisor_staff_name, 
						'supervisor_job_title' => $supervisor_job_title, 
						'supervisor_skype' => $supervisor_skype, 
						'supervisor_email' => $supervisor_email, 
						'supervisor_contact' => $supervisor_contact, 
						'business_owners' => $business_owners, 
						'business_partners' => $business_partners, 
						'location_id' => $leads_location,
						'registered_in' => 'added manually', 
						'registered_url' => $_SERVER['HTTP_HOST'].'/portal/'.basename($_SERVER['SCRIPT_FILENAME']),  
						'registered_domain' => LOCATION_ID ,
						'secondary_contact_person' => $secondary_contact_person,
						'sec_email' => $sec_email,
						'sec_phone' => $sec_phone,
						'sec_position' => $sec_position,
						'note' => $note,
						'preffered_communication' => $preffered_communication,
						'csro_id' => $csro_id,
						'inquiring_about' => $inquiring_about,
						'hiring_coordinator_id' => $hiring_coordinator_id,
						'leads_skype_id' => $leads_skype_id,
						'gender' => $gender,
						'is_test' => $is_test
						
						);
				//print_r($data);
				$leads_info = $data;
			}
			
			if($mode == "Update"){
				$data = array(
						'tracking_no' => $tracking_no,
						'agent_id' => $agent_id, 
						'business_partner_id' => $business_partner_id, 
						'remote_staff_competences' => $remote_staff_competences, 
						'remote_staff_needed' => $remote_staff_needed, 
						'remote_staff_needed_when' => $remote_staff_needed_when, 
						'remote_staff_one_home' => $remote_staff_one_home, 
						'remote_staff_one_office' => $remote_staff_one_office, 
						'your_questions' => $your_questions, 
						'lname' => $lname, 
						'fname' => $fname, 
						'company_position' => $company_position, 
						'company_name' => $company_name, 
						'company_address' => $company_address, 
						'email' => $email, 
						//'email_receives_invoice' => $email_receives_invoice, 
						'website' => $website, 
						'officenumber' => $officenumber, 
						'mobile' => $mobile, 
						'company_description' => $company_description, 
						'company_industry' => $company_industry, 
						'company_size' => $company_size, 
						'company_turnover' => $company_turnover, 
						'rating' => $rating, 
						'leads_country' => $leads_country, 
						'state' => $state,
						'acct_dept_name1' => $acct_dept_name1, 
						'acct_dept_name2' => $acct_dept_name2, 
						'acct_dept_contact1' => $acct_dept_contact1, 
						'acct_dept_contact2' => $acct_dept_contact2, 
						'acct_dept_email1' => $acct_dept_email1, 
						'acct_dept_email2' => $acct_dept_email2, 
						'supervisor_staff_name' => $supervisor_staff_name, 
						'supervisor_job_title' => $supervisor_job_title, 
						'supervisor_skype' => $supervisor_skype, 
						'supervisor_email' => $supervisor_email, 
						'supervisor_contact' => $supervisor_contact, 
						'business_owners' => $business_owners, 
						'business_partners' => $business_partners, 
						'location_id' => $leads_location ,
						'registered_in' => $registered_in ,
						'secondary_contact_person' => $secondary_contact_person,
						'sec_email' => $sec_email,
						'sec_phone' => $sec_phone,
						'sec_position' => $sec_position,
						'note' => $note,
						'preffered_communication' => $preffered_communication,
						'csro_id' => $csro_id,
						'inquiring_about' => $inquiring_about,
						'hiring_coordinator_id' => $hiring_coordinator_id,
						'leads_skype_id' => $leads_skype_id,
						'gender' => $gender,
						'abn_number' => $abn_number,
						'is_test' => $is_test
						);
				//print_r($data);exit;
				
				
				
			}
			
			
			
		if($status == 0){	
			
			if($mode == "Add" and $_POST['leads_id']==""){	
				$db->insert('leads', $data);		
				$leads_id = $db->lastInsertId();
				
				CheckLeadsFullName($leads_id, $fname, $lname);
				
				$site = $_SERVER['HTTP_HOST'];
				
				if($business_partner_id!=$agent_id){
					$sql="SELECT * FROM agent WHERE agent_no = $agent_id;";
					$result = $db->fetchRow($sql);
					$AFFname = $result['work_status']." : ".$result['fname']." ".$result['lname'] . " / ";
				}
				
				
				
				$sql="SELECT * FROM agent WHERE agent_no =".$business_partner_id;
				$result = $db->fetchRow($sql);
				$agent_code = $result['agent_code'];
				$BPname = $result['work_status']." : ".$result['fname']." ".$result['lname'];
				$name = $AFFname.$BPname;

				
				$body =  "<table width='550' style='border:#62A4D5 solid 1px; font:11px tahoma;' cellpadding='3' cellspacing='0'>
				<tr bgcolor='#62A4D5'  >
					<td colspan='3' style='color:#FFFFFF;'><b>RemoStaff</b> New Lead added manually  [".$site."]</td>
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
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>Skype</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$leads_skype_id."</td>
				</tr>
				
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>MOBILE NO.</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$mobile."&nbsp;</td>
				</tr>
				
				
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY NAME</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$company_name."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY POSITION</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$company_position."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY ADDRESS</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$company_address."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>OFFICE NO.</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$officenumber."&nbsp;</td>
				</tr>
				
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>COMPANY DETAILS</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$company_descriptio."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>NO. OF EMP</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$company_size."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>REMOTE STAFF DUTIES</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$remote_staff_competences."&nbsp;</td>
				</tr>
				
				<tr>
					<td width='149' valign='top' style='border-bottom:#CCCCCC solid 1px;'>QUESTIONS / CONCERN</td>
					<td width='6' valign='top' style='border-bottom:#CCCCCC solid 1px;'>:</td>
					<td width='325' valign='top' style='border-bottom:#CCCCCC solid 1px;'>".$your_questions."&nbsp;</td>
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
				if(!TEST){
				    $test="";
				}else{
				    $test="TEST ";
				}
				if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
					$subject='New Lead Added Manually From Sales Staff c\o '.$session_name;
				}else{
					$subject='New Lead Added from RemoteStaff Admin Section c\o '.$session_name;
				}
				
				
				$mail = new Zend_Mail('utf-8');
				$mail->setBodyHtml($body);
				$mail->setFrom('new_leads@remotestaff.com.au', 'RemoteStaff');
				if(!TEST){
					$mail->addTo('new_leads@remotestaff.com.au', 'Chris Jankulovski');
				}else{
					$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
				}
				//$mail->addBcc('normanm@remotestaff.com.au', 'Normaneil Macutay');
				//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
				$mail->setSubject($test.$subject);
				$mail->send($transport);

				//$smarty->assign('action_result' , 'New lead added successfully');
				$msg = 'New lead added successfully';
				
				$history_changes = 'Added manually';
				$changes = array(
							 'leads_id' => $leads_id ,
							 'date_change' => $ATZ, 
							 'changes' => $history_changes, 
							 'change_by_id' => $created_by_id, 
							 'change_by_type' => $created_by_type
							 );
				$db->insert('leads_info_history', $changes);
			}
			
			if($mode == "Update"){	
				//print_r($data);exit;
				addLeadsInfoHistoryChanges($data , $leads_id , $created_by_id , $created_by_type);
				$where = "id = ".$_POST['leads_id'];
				$db->update('leads', $data , $where);
				$db -> delete("solr_leads", $db -> quoteInto("id=?",$leads_id));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-leads/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-leads/");
							}		
				$smarty->assign('action_result' , 'Updated successfully');	
				$msg = 'Updated successfully';
				
				$data = array('last_updated_date' => $ATZ);
                $db->update('leads', $data, 'id='.$leads_id);
				
				
	
			}
			
			
			//sync to mongodb
				$retries = 0;
				while(true){
					try{
						if (TEST) {
							$mongo = new MongoClient(MONGODB_TEST);
							$database = $mongo -> selectDB('prod');
						} else {
							$mongo = new MongoClient(MONGODB_SERVER);
							$database = $mongo -> selectDB('prod');
						}				
						if (TEST) {
							$mongo = new MongoClient(MONGODB_TEST);
							$database2 = $mongo -> selectDB('prod');
						} else {
							$mongo = new MongoClient(MONGODB_SERVER);
							$database2 = $mongo -> selectDB('prod');
						}
						break;
					} catch(Exception $e){
						++$retries;
						
						if($retries >= 100){
							break;
						}
					}
				}
								
			$job_orders_collection = $database->selectCollection('job_orders');
			$job_orders_history_collection = $database2->selectCollection('job_orders_history');
			
			
			//record to job order history
			$cursor = $job_orders_collection->find(array("leads_id"=>intval($leads_id)));
			if ($_SESSION["admin_id"]){
				$admin = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
				if (isset($_POST["hiring_coordinator_id"])){
					$hr_assigned = $db->fetchRow($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("admin_id = ?", $_POST["hiring_coordinator_id"]));
				}
				require_once dirname(__FILE__)."/lib/JobOrderManager.php";
				$manager = new JobOrderManager($db);
				$job_order = array();
				while($cursor->hasNext()){
					$job_order = $cursor->getNext();
					$old_job_order = $job_order;
					$job_order["hc_fname"] = $hr_assigned["admin_fname"];
					$job_order["hc_lname"] = $hr_assigned["hc_lname"];
					$job_order["assigned_hiring_coordinator_id"] = $hr_assigned["admin_id"];		
					if ($old_job_order["assigned_hiring_coordinator_id"]!=$hiring_coordinator_id){					
						$job_orders_history_collection->insert(array("history"=>"Hiring Manager ".$hr_assigned["admin_fname"]." ".$hr_assigned["admin_lname"]." is Assigned to Job Order", "type"=>"assigned_hiring_manager", "old_job_order"=>$old_job_order, "job_order"=>$job_order, "tracking_code"=>$job_order["tracking_code"], "date"=>new MongoDate(strtotime(date("Y-m-d H:i:s"))), "admin"=>$admin, "hr"=>$hr_assigned));	
						$manager->assignStatus($job_order["tracking_code"], JobOrderManager::SC_ASSIGNED);
					}
				
					
				}
			}		
			
			
			
			//sync to job order history
			$db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?",$leads_id));
			
			if (TEST){
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
				file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
				
			}else{
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
				file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
				
			}
			
			$sql = $db->select()
				->from('leads' , 'status')
				->where('id =?' ,$leads_id);
			$status = $db->fetchOne($sql);	
			
			//Sync client in mongodb
			file_get_contents($base_api_url . "/mongo-index/sync-client-settings-by-id/?client_id={$leads_id}");
			
			echo '<script language="javascript">
				   alert("'.$msg.'");
				   location.href="leads_information.php?id='.$leads_id.'&lead_status='.$status.'&page_type='.$page_type.'";
				</script>';
			
			
			
		}
	
	
	
}	
//echo $leads_id;
$is_test = "no";
if($leads_id !=""){
	//LEADS INFORMATION
	$sql = $db->select()
		->from('leads')
		->where('id =?' ,$leads_id);
	$leads_info = $db->fetchRow($sql);	
	$leads_of = checkAgentAffiliates($leads_id);
	$date_registered = format_date($leads_info['timestamp']);
	$mode = "Update";	
	$is_test = $leads_info['is_test'];
}



//LEADS RATINGS
$rating = $leads_info['rating'];
if($rating == "") $rating =0;
for($i=0; $i<=5;$i++){
	//rate
	if($leads_info['rating'] == $i){
		$rate_Options .="<option value=".$i." selected='selected'>".$i."</option>";
	}else{
		$rate_Options .="<option value=".$i.">".$i."</option>";
	}	
}

//stars to be displayed
for($i=1; $i<=$rating;$i++){
	$starOptions.='<img src="images/star.png" align="top">';
}


$sql = $db->select()
	->from('country');
$countries = $db->fetchAll($sql);	
foreach($countries as $country){

	if($leads_info['leads_country'] == $country['printable_name']){
		$countryOptions .= "<option value=\"".$country['printable_name']."\" selected='selected'>".$country['printable_name']."</option>";
		
	}else{
		$countryOptions .= "<option value=\"".$country['printable_name']."\">".$country['printable_name']."</option>";
	}
	
}

$sql = $db->select()
    ->from('defined_industries', 'value');
$defined_industries	= $db->fetchAll($sql);
$company_industry = explode(',', $leads_info['company_industry']);

//echo "<pre>";
//print_r(explode(',', $leads_info['company_industry']));
//echo "</pre>";

foreach($defined_industries as $industry){
	//echo $industry['value'];
	//var_dump(in_array($industry['value'], $company_industry));
	
	if(in_array($industry['value'], $company_industry)){
		$industryoptions .= "<input type='checkbox' name='company_industry[]' value='".$industry['value']."' checked />".$industry['value']."<br>";
	}else{
		$industryoptions .= "<input type='checkbox' name='company_industry[]' value='".$industry['value']."' />".$industry['value']."<br>";
	}
	//echo $industry['value'];
	
    
}
//exit;

/*
$indutryArray=array("Accounting","Administration","Advert./Media/Entertain.","Banking & Fin. Services","Call Centre/Cust. Service","Community & Sport","Construction","Consulting & Corp. Strategy","Education & Training","Engineering","Government/Defence","Healthcare & Medical","Hospitality & Tourism","HR & Recruitment","Insurance & Superannuation","I.T. & T","Legal","Manufacturing/Operations","Mining, Oil & Gas","Primary Industry","Real Estate & Property","Retail & Consumer Prods.","Sales & Marketing","Science & Technology","Self-Employment","Trades & Services","Transport & Logistics");  
for ($i = 0; $i < count($indutryArray); $i++) {
	if($leads_info['company_industry'] == $indutryArray[$i])
	{
		$industryoptions .= "<option selected value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
	}
	else
	{
		$industryoptions .= "<option value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
	}
}
*/   
$moneyArray=array("$0 to $300,000","$300,000 to $700,000","$700,000 to $1.2m","$1.2m to $2m","$2m to $3m","$3 to $5m","Above $5m");
for ($i = 0; $i < count($moneyArray); $i++) {
	if($leads_info['company_turnover'] == $moneyArray[$i])
	{
		$moneyoptions .= "<option selected value=\"$moneyArray[$i]\">$moneyArray[$i]</option>\n";
	}
	else
	{
		$moneyoptions .= "<option value=\"$moneyArray[$i]\">$moneyArray[$i]</option>\n";
	}
}

$YesNoArray = array('Yes','No');
for ($i = 0; $i < count($YesNoArray); $i++) {
	if($leads_info['remote_staff_one_home']==$YesNoArray[$i]){
		$rsInHomeOptions .= "<option value=\"".$YesNoArray[$i]."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$rsInHomeOptions .= "<option value=\"".$YesNoArray[$i]."\" >".$YesNoArray[$i]."</option>";
	}
	
	if($leads_info['remote_staff_one_office']==$YesNoArray[$i]){
		$rsInOfficeOptions .= "<option value=\"".$YesNoArray[$i]."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$rsInOfficeOptions .= "<option value=\"".$YesNoArray[$i]."\" >".$YesNoArray[$i]."</option>";
	}
	
	//if($leads_info['email_receives_invoice'] == strtolower($YesNoArray[$i])){
	//	$email_receives_invoiceOptions .= "<option value=\"".strtolower($YesNoArray[$i])."\" selected>".$YesNoArray[$i]."</option>";
	//}else{
	//	$email_receives_invoiceOptions .= "<option value=\"".strtolower($YesNoArray[$i])."\" >".$YesNoArray[$i]."</option>";
	//}
	
	if($leads_info['apply_gst'] == strtolower($YesNoArray[$i])){
		$apply_gstOptions .= "<option value=\"".strtolower($YesNoArray[$i])."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$apply_gstOptions .= "<option value=\"".strtolower($YesNoArray[$i])."\" >".$YesNoArray[$i]."</option>";
	}
	
	if($is_test==strtolower($YesNoArray[$i]) ){
		$is_TestOptions .= "<option value=\"".$YesNoArray[$i]."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$is_TestOptions .= "<option value=\"".$YesNoArray[$i]."\" >".$YesNoArray[$i]."</option>";
	}
}	



if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){

			if($leads_id != ""){
				$business_partner_id = $leads_info['business_partner_id'];
			}else{
				$business_partner_id = $_SESSION['agent_no'];
			}
			
			$sql= $db->select()
				->from('agent')
				->where('agent_no =?',$business_partner_id);
			$bp = $db->fetchRow($sql); 	
			
			//business_partner_id
			$BPOptions.="<option value=".$bp['agent_no']." selected>".$bp['fname']." ".$bp['lname']."</option>";
			
			
			//get all ACTIVE business partners
			$sql="SELECT * FROM agent WHERE  work_status = 'BP' ORDER BY fname ASC;";
			$bps = $db->fetchAll($sql);
			foreach($bps as $bp){
					//get business partner affiliates
					$query="SELECT DISTINCT(a.agent_no),CONCAT(a.fname,' ',a.lname)AS fullname ,f.business_partner_id,a.status
							FROM agent a
							LEFT JOIN agent_affiliates f ON f.affiliate_id = a.agent_no
							WHERE a.work_status = 'AFF'
							AND f.business_partner_id = ".$bp['agent_no']."
							ORDER BY fname ASC;";
					$result = $db->fetchAll($query);
					if(count($result)>0){
						$AFFOptions.="<OPTGROUP LABEL='".strtoupper($bp['fname']." ".$bp['lname']." ".$bp['status'])."'>";
						foreach($result as $row){
							if($row['agent_no'] == $leads_info['agent_id']){
								$AFFOptions.="<option selected value=".$row['agent_no'].">".$row['fullname']." - ".$row['status']."</option>";
							}else{
								$AFFOptions.="<option value=".$row['agent_no'].">".$row['fullname']." - ".$row['status']."</option>";
							}
						}
						$AFFOptions.=" </OPTGROUP><OPTGROUP>&nbsp;</OPTGROUP>";
					}
				
			}
			
			
			
			
			
	
}else{
		
		//get all ACTIVE business partners
		$sql="SELECT * FROM agent WHERE status='ACTIVE' AND work_status = 'BP' ORDER BY fname ASC;";
		$bps = $db->fetchAll($sql);
		foreach($bps as $bp){
			//echo $bp['agent_no']."<br>";	
			if($leads_info['business_partner_id'] == $bp['agent_no']){
				$BPOptions.="<option value=".$bp['agent_no']." selected>".$bp['fname']." ".$bp['lname']."</option>";
			}else{
				$BPOptions.="<option value=".$bp['agent_no'].">".$bp['fname']." ".$bp['lname']."</option>";
			}
			
			//get business partner affiliates
			
				$query="SELECT DISTINCT(a.agent_no),CONCAT(a.fname,' ',a.lname)AS fullname ,f.business_partner_id,a.status
						FROM agent a
						LEFT JOIN agent_affiliates f ON f.affiliate_id = a.agent_no
						WHERE a.work_status = 'AFF'
						AND f.business_partner_id = ".$bp['agent_no']."
						ORDER BY fname ASC;";
				$result = $db->fetchAll($query);
				if(count($result)>0){
					$AFFOptions.=" <OPTGROUP LABEL='BP: ".$bp['fname']." ".$bp['lname']."'>";
					foreach($result as $row){
						if($row['agent_no'] == $leads_info['agent_id']){
							$AFFOptions.="<option selected value=".$row['agent_no'].">".$row['fullname']." - ".$row['status']."</option>";
						}else{
							$AFFOptions.="<option value=".$row['agent_no'].">".$row['fullname']." - ".$row['status']."</option>";
						}
					}
					$AFFOptions.=" </OPTGROUP><OPTGROUP>&nbsp;</OPTGROUP>";
				}
			
		}

}






if($leads_info['location_id'] == ""){
	$location_id = LOCATION_ID;
}else{
	$location_id = $leads_info['location_id'];
}

$sql = $db->select()
	->from('leads_location_lookup');
$leads_locations = $db->fetchAll($sql);
foreach($leads_locations as $leads_location){
	if($location_id == $leads_location['id']){
		$leads_location_options .= "<option selected value=".$leads_location['id'].">".$leads_location['location']."</option>\n";
	}else{
		$leads_location_options .= "<option value=".$leads_location['id'].">".$leads_location['location']."</option>\n";
	}
}



//check the leads tracking_no if it existing in the tracking table. If not insert it.
if($leads_id !=""){
	$sql = $db->select()
		->from('tracking' , 'id')
		->where('tracking_no =?' , $leads_info['tracking_no']);
	$tracking_id = $db->fetchOne($sql);
	//echo $tracking_id;
	if($tracking_id == ""){
		//detect whose tracking_no is this
		//get all agents
		$sql="SELECT * FROM agent;";
		$agents = $db->fetchAll($sql);
		foreach($agents as $agent){
			
			$agent_code = $agent['agent_code'];
			if($agent_code == substr($leads_info['tracking_no'],0,strlen($agent_code))){
				//echo $agent['agent_no'];
				$data= array('tracking_no' => $leads_info['tracking_no'], 'tracking_created' => $ATZ, 'tracking_createdby' => $agent['agent_no'], 'status' => 'NEW' );
				$db->insert('tracking' , $data);
				$wala = 0;
				break;
			}else{
				$wala = 1;
			}
			
		
		}
	}
}

if($wala > 0){
	// save it under Chris BP Acct.
	$data= array('tracking_no' => $leads_info['tracking_no'], 'tracking_created' => $ATZ, 'tracking_createdby' => 2, 'status' => 'NEW' );
	$db->insert('tracking' , $data);
}
/*
if($mode == "Update"){
	//promotional codes
	$sql="SELECT * FROM agent;";
	$bps = $db->fetchAll($sql);
	foreach($bps as $bp){
		
		$query = "SELECT * FROM tracking t WHERE tracking_createdby = ".$bp['agent_no']." AND status!='ARCHIVE';";
		$result = $db->fetchAll($query);
		if(count($result)>0){
				$promocodesOptions.="<OPTGROUP LABEL='".$bp['work_status']." : ".strtoupper($bp['fname']." ".$bp['lname'])."'>";
				foreach($result as $row){
					if($leads_info['tracking_no'] == $row['tracking_no']){
						$promocodesOptions.="<option selected value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
					}else{
						$promocodesOptions.="<option value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
					}
					
				}
				$promocodesOptions.="</OPTGROUP><OPTGROUP>&nbsp;</OPTGROUP>";
		}
	}
}else{
	if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
		//echo $agent['agent_code'];
		$promocodesOptions.="<option value='".$agent['agent_code']."INBOUNDCALL' >".$agent['agent_code']."INBOUNDCALL</option>";
		$promocodesOptions.="<option value='".$agent['agent_code']."OUTBOUNDCALL' >".$agent['agent_code']."OUTBOUNDCALL</option>";
	}else{
		//get all ACTIVE bp agent codes concat it with INBOUNDCALL / OUTBOUNDCALL
		$sql="SELECT * FROM agent WHERE status='ACTIVE' AND work_status = 'BP' ORDER BY fname ASC;";
		$bps = $db->fetchAll($sql);
		foreach($bps as $bp){
			//echo $bp['agent_code']."<br>";	
			$promocodesOptions.="<OPTGROUP LABEL='".strtoupper($bp['fname']." ".$bp['lname'])."'>";
				$promocodesOptions.="<option value='".$bp['agent_code']."INBOUNDCALL' >".$bp['agent_code']."INBOUNDCALL</option>";
				$promocodesOptions.="<option value='".$bp['agent_code']."OUTBOUNDCALL' >".$bp['agent_code']."OUTBOUNDCALL</option>";
			$promocodesOptions.="</OPTGROUP>";
		}	
	}
}
*/
//promotional codes
$sql="SELECT * FROM agent;";
$bps = $db->fetchAll($sql);
foreach($bps as $bp){
	
	$query = "SELECT * FROM tracking t WHERE tracking_createdby = ".$bp['agent_no']." AND status!='ARCHIVE';";
	$result = $db->fetchAll($query);
	if(count($result)>0){
			$promocodesOptions.="<OPTGROUP LABEL='".$bp['work_status']." : ".strtoupper($bp['fname']." ".$bp['lname'])."'>";
			foreach($result as $row){
				if($leads_info['tracking_no'] == $row['tracking_no']){
					$promocodesOptions.="<option selected value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
				}else{
					$promocodesOptions.="<option value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
				}
				
			}
			$promocodesOptions.="</OPTGROUP><OPTGROUP>&nbsp;</OPTGROUP>";
	}
}

$registered_in_lookup = array(				
	'home page' => 'Registered in Home page',
	'available staff' => 'Registered in Available Staff', 
	'recruitment service' => 'Registered in Recruitment Service' ,
	'contact us' => 'Registered in Contact Us page',
	'send resume' => 'Registered in Send Resume',
	'added manually' => 'Added Manually',
	'ask a question' => ' Registered in Ask A Question',
	'remote ready' => ' Registered in Remote Ready', 
	'pricing' => ' Registered in Pricing page',
	'client success' => ' Registered in Client Success page', 
	'how we work' => ' Registered in How It Works page', 
	'management tips' => ' Registered in Management Tips', 
	'our difference' => ' Registered in Our Difference page', 
	'bigger team' => ' Registered in Bigger Team page', 
	'about us' => ' Registered in About Us page', 
	'skill assessment' => ' Registered in Skill Assessment page',
	' ' => 'Unknown location'
);



$registered_in_array = array('home page','available staff','recruitment service','contact us','send resume','added manually','ask a question','remote ready', 'pricing','client success', 'how we work', 'management tips', 'our difference', 'bigger team', 'about us', 'skill assessment');
for($i=0; $i<count($registered_in_array); $i++){
	if($mode == "Update") {
		if($created_by_type == "admin"){
			if($leads_info['registered_in'] == $registered_in_array[$i]){
				$registered_Options .= "<option selected value='".$registered_in_array[$i]."'>".$registered_in_lookup[$registered_in_array[$i]]."</option>";
			}else{
				$registered_Options .= "<option value='".$registered_in_array[$i]."'>".$registered_in_lookup[$registered_in_array[$i]]."</option>";
			}
		}else{
			if($leads_info['registered_in'] == $registered_in_array[$i]){
				$registered_Options .= "<option selected value='".$registered_in_array[$i]."'>".$registered_in_lookup[$registered_in_array[$i]]."</option>";
			}
		}
	}else{
		$registered_Options = "<option selected value='added manually'>".$registered_in_lookup['added manually']."</option>";
	}
}


$preffered_communication_array = array('Email' , 'Phone' , 'Skype' , 'RS Chat' , 'SMS on Mobile');
for($i=0; $i<count($preffered_communication_array);$i++){
	if($leads_info['preffered_communication'] == $preffered_communication_array[$i]){
		$preffered_communication_Options .= "<option selected value='".$preffered_communication_array[$i]."'>".$preffered_communication_array[$i]."</option>";
	}else{
		$preffered_communication_Options .= "<option value='".$preffered_communication_array[$i]."'>".$preffered_communication_array[$i]."</option>";
	}
}


//get all admin CSRO
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('csro =?' , 'Y');
$csro_officers = $db->fetchAll($sql);
foreach($csro_officers as $csro_officer){
	if($leads_info['csro_id'] == $csro_officer['admin_id']){
		$csro_Options .= "<option selected value='".$csro_officer['admin_id']."'>".$csro_officer['admin_fname']." ".$csro_officer['admin_lname']."</option>";
	}else{
		$csro_Options .= "<option value='".$csro_officer['admin_id']."'>".$csro_officer['admin_fname']." ".$csro_officer['admin_lname']."</option>";
	}
}


//get all admin Hiring Coordinator
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('hiring_coordinator =?' , 'Y');
$hiring_coordinators = $db->fetchAll($sql);
foreach($hiring_coordinators as $hiring_coordinator){
	if($leads_info['hiring_coordinator_id'] == $hiring_coordinator['admin_id']){
		$hiring_coordinator_Options .= "<option selected value='".$hiring_coordinator['admin_id']."'>".$hiring_coordinator['admin_fname']." ".$hiring_coordinator['admin_lname']."</option>";
	}else{
		$hiring_coordinator_Options .= "<option value='".$hiring_coordinator['admin_id']."'>".$hiring_coordinator['admin_fname']." ".$hiring_coordinator['admin_lname']."</option>";
	}
}

if($leads_id){
	$sql = "SELECT counter , added_by_id , added_by_type, date_added FROM leads_inquiry WHERE leads_id =".$leads_id." GROUP BY counter;";
	$counters = $db->fetchAll($sql);
	foreach($counters as $counter){
		
		$det = new DateTime($counter['date_added']);
		//$date_added = $det->format("M. j, Y");
				
		$job_positions .= "<tr><td colspan=2><em>Added by ".getCreator($counter['added_by_id'] , $counter['added_by_type'] )." ".$date_added."</em></td></tr>";
		
		$sql = $db->select()
			->from(array('i' => 'leads_inquiry') , Array('i.id'))
			->join(array('j' => 'job_category') , 'j.category_id = i.category_id' , Array('category_name'))
			->where('leads_id =?' , $leads_id)
			->where('counter =?' , $counter['counter']);
		$positions = $db->fetchAll($sql);	
		if(count($positions)>0){
				foreach($positions as $position){
					$job_positions .="<tr>
										<td width='95%' style='padding-left:15px;'>- ".$position['category_name']."</td>
										<td width='5%'><a href='javascript:DeleteJobPosition(".$position['id'].")'>X</a></td>
										</tr>";
				}
		}
			
	
	}


	//LEADS ALTERNATE EMAILS
	$sql = $db->select()
		->from('leads_alternate_emails')
		->where('leads_id =?' , $leads_id);
	$alternate_emails = $db->fetchAll($sql);
	
}

if($leads_id!=""){
	$CLIENT_ID = ((int)$leads_id);  //must be an integer
    $client = new couchClient($couch_dsn, 'client_docs');
    //client currency settings
    $client->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
    $client->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
    $client->descending(True);
    $client->limit(1);
    $response = $client->getView('client', 'settings');
    $currency_code = $response->rows[0]->value[0];
    $currency_gst_apply = $response->rows[0]->value[1];
	$smarty->assign('currency_code', $currency_code);
    $smarty->assign('currency_gst_apply', $currency_gst_apply);
}


//echo $page_type;exit;
$smarty->assign('gender_options', Array('male', 'female', 'unsure'));
$smarty->assign('admin_status',$admin_status);
$smarty->assign('page_type',$page_type);
$smarty->assign('alternate_emails' , $alternate_emails);
$smarty->assign('job_positions',$job_positions);
$smarty->assign('query_string',$query_string);
$smarty->assign('csro_Options',$csro_Options);
$smarty->assign('hiring_coordinator_Options',$hiring_coordinator_Options);
$smarty->assign('preffered_communication_Options',$preffered_communication_Options);
$smarty->assign('registered_Options',$registered_Options);
$smarty->assign('promocodesOptions',$promocodesOptions);
$smarty->assign('leads_location_options',$leads_location_options);
$smarty->assign('BPOptions',$BPOptions);
$smarty->assign('AFFOptions',$AFFOptions);
$smarty->assign('mode',$mode);

//$smarty->assign('apply_gstOptions',$apply_gstOptions);
//$smarty->assign('email_receives_invoiceOptions',$email_receives_invoiceOptions);   
$smarty->assign('rsInOfficeOptions',$rsInOfficeOptions);   
$smarty->assign('rsInHomeOptions',$rsInHomeOptions);
$smarty->assign('is_TestOptions',$is_TestOptions);
   
$smarty->assign('moneyoptions',$moneyoptions);
$smarty->assign('industryoptions',$industryoptions);
$smarty->assign('countryOptions',$countryOptions);	
$smarty->assign('promo_code',$promo_code);	
$smarty->assign('starOptions' , $starOptions);
$smarty->assign('rate_Options' , $rate_Options);

$smarty->assign('lead_status' , $lead_status);

$smarty->assign('date_registered' , $date_registered);
$smarty->assign('leads_of' , $leads_of);
$smarty->assign('leads_info' , $leads_info);
$smarty->assign('leads_id' , $leads_id);
$smarty->assign('url',$url);
if($leads_id){
	$smarty->assign('showLeadsInfoChangesHistory' , showLeadsInfoChangesHistory($leads_id , 'yes' , '0'));
}
$smarty->display('AddUpdateLeads.tpl');
?>