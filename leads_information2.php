<?php
#2010-11-02: ROY - csro files upload(line 695 - 749)
mb_language('uni'); 
mb_internal_encoding('UTF-8');
include('conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$mode = $_POST['mode'];
if(!$mode) $mode = "view";

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$update_page ="updateinquiry.php";
	$create_a_quote ="agent_create_quote.php";
	$service_agreement_page = "service_agreement.php";
	$setupfee_page = "agent_set_up_fee_invoice.php";
	
	
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
	$update_page ="admin_updateinquiry.php";
	$create_a_quote ="admin_create_quote.php";
	$service_agreement_page = "admin_service_agreement.php";
	$setupfee_page = "admin_set_up_fee_invoice.php";
	$smarty->assign('admin_section',True);	

}else{

	header("location:index.php");
}

include './lib/validEmail.php';
include './lib/addLeadsInfoHistoryChanges.php';
include './leads_information/BuildEmailTemplate.php';
include ('./leads_information/AdminBPActionHistoryToLeads.php');
include ('./leads_information/LeadsSentResume.php');
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';
include 'steps_taken.php';
include 'appointment_calendar/session-variables.php';

include 'lead_activity.php';
	

$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];


//LEADS NEW INFO (This lead registered again in the system)
$sql = $db->select()
	->from('leads_new_info')
	->where('leads_id =?' , $leads_id);
$leads_new_info = $db->fetchRow($sql);

$leads_of = checkAgentAffiliates($leads_new_info['id']);
$date_registered = format_date($leads_new_info['timestamp']);
		
$smarty->assign('leads_new_info', $leads_new_info);

//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);
$smarty->assign('leads_info', $leads_info);


//GET THE LEADS MESSAGE
$sql = $db->select()
	->from('leads_message')
	->where('leads_id =?' , $leads_id)
	->where('leads_type =?' , 'regular');
//echo $sql."<br>";	
$leads_message_reg = $db->fetchAll($sql);
$smarty->assign('leads_message_reg', $leads_message_reg);


if($leads_new_info['id']){
	$sql = $db->select()
	->from('leads_message')
	->where('leads_id =?' , $leads_id)
	->where('leads_type =?' , 'temp');
//echo $sql."<br>";	
$leads_message_temp = $db->fetchAll($sql);
$smarty->assign('leads_message_temp', $leads_message_temp);
$smarty->assign('leads_message_temp_count', count($leads_message_temp));
}	



if(isset($_POST['acknowledge'])){

	//LEADS INFORMATION
	$sql = $db->select()
		->from('leads')
		->where('id =?' ,$leads_id);
	$leads_info = $db->fetchRow($sql);	
	
	//remove the flag
	$data = array('marked' => 'no' );
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);
	
	//DELETE the RECORD
	$where = "id = ".$_POST['leads_new_info_id'];	
	$db->delete('leads_new_info' , $where);

	//
	$where = "leads_id = ".$leads_id. " AND leads_new_info_id = ".$_POST['leads_new_info_id'];
	$db->delete('leads_transactions', $where);
				
	$history_changes = "Leads profile Information 2 [ ".$leads_new_info['fname']." ".$leads_new_info['lname']." ] was acknowledged , viewed and discarded<br>";
	foreach(array_keys($leads_new_info) as $array_key){
			if($leads_new_info[$array_key]){
			$history_changes .= sprintf("%s => %s  <br>", $array_key, $leads_new_info[$array_key] );
			}
	}

	$changes = array(
				 'leads_id' => $leads_id ,
				 'date_change' => $ATZ, 
				 'changes' => $history_changes, 
				 'change_by_id' => $created_by_id, 
				 'change_by_type' => $created_by_type
	);
	$db->insert('leads_info_history', $changes);
	echo "<script> alert('Successfully Acknowledge.');window.location=\"leads_information.php?id=".$leads_id."&lead_status=".$leads_info['status']."&acknowledge=TRUE\"; </script>";
}

if(isset($_POST['merge'])){

	//When Merging 
	
	//LEADS INFORMATION
	$sql = $db->select()
		->from('leads')
		->where('id =?' ,$leads_id);
	$leads_info = $db->fetchRow($sql);		

	//print_r($leads_info);
	$fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	
	//$company_name = trim($_POST['company_name']);
	//$company_position = trim($_POST['company_position']);
	//$company_address = trim($_POST['company_address']);
	//$website = trim($_POST['website']);
	$officenumber = trim($_POST['officenumber']);
	$mobile = trim($_POST['mobile']);
	//$company_industry = trim($_POST['company_industry']);
	//$company_size = trim($_POST['company_size']);
	//$company_turnover = trim($_POST['company_turnover']);
	//$company_description = trim($_POST['company_description']);
	//$remote_staff_needed = trim($_POST['remote_staff_needed']);
	//$remote_staff_needed_when = trim($_POST['remote_staff_needed_when']);
	//$remote_staff_one_home = trim($_POST['remote_staff_one_home']);
	//$remote_staff_one_office = trim($_POST['remote_staff_one_office']);
	$remote_staff_competences = trim($_POST['remote_staff_competences']);
	
	if($leads_info['officenumber']){
		$officenumber = $leads_info['officenumber']." / ".$officenumber;
	}
	if($leads_info['mobile']){
		$mobile = $leads_info['mobile']." / ".$mobile;
	}
	
	if($leads_info['remote_staff_competences']){
		$remote_staff_competences = $leads_info['remote_staff_competences']."\n\n".$remote_staff_competences;
	}
	
	$data =  array(
		'fname' => $fname,
		'lname' => $lname,
		'officenumber' => $officenumber,
		'mobile' => $mobile,
		'personal_id' => $leads_id ,
		'marked' => 'no'
	);
	
	
	//insert history
	addLeadsInfoHistoryChanges($data , $leads_id , $created_by_id , $created_by_type);
	
	//update the leads table
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);
	
	
	//update all the leads messages that are associated with $leads_id
	$data = array('leads_type' => 'regular') ;
	$where = "leads_id = ".$leads_id. " AND leads_type = 'temp'";
	$db->update('leads_message', $data , $where);
	
	//DELETE the RECORD
	$where = "id = ".$_POST['leads_new_info_id'];	
	$db->delete('leads_new_info' , $where);
	
	//important we parse all leads transactions record in this profile
	//id, leads_id, leads_new_info_id, reference_column_name, reference_no, reference_table, date_added
	$where = "leads_id = ".$leads_id." AND leads_new_info_id = ".$_POST['leads_new_info_id'];	
	$db->delete('leads_transactions' , $where);
	
	
	$history_changes = "Merged Data";
	$changes = array(
				 'leads_id' => $leads_id ,
				 'date_change' => $ATZ, 
				 'changes' => $history_changes, 
				 'change_by_id' => $created_by_id, 
				 'change_by_type' => $created_by_type
	);
	$db->insert('leads_info_history', $changes);
	
	echo "<script> alert('Successfully merged.');window.location=\"leads_information.php?id=".$leads_id."&lead_status=".$leads_info['status']."&merged=TRUE\"; </script>";

	
	
}
if(isset($_POST['separate'])){
	$separate_flag = True;
	
	if (trim($_POST['email'])){ 
			//check if the email is valid
			if (!validEmailv2(trim($_POST['email']))){
				$separate_flag = False;
				$smarty->assign('separate_mess' , 'Invalid email address');
			}
			
			//check if the email is existing
			$sql = $db->select()
				->from('leads' , 'id')
				->where('email =?' ,trim($_POST['email']));
			$id_email_exist = $db->fetchOne($sql);	
			
			if($id_email_exist){
				$separate_flag = False;
				$smarty->assign('separate_mess' , 'Email already Exist. Please try to enter a different email address');
			}
	}else{
			$separate_flag = False;
			$smarty->assign('separate_mess' , 'Please enter an email address');
	}
	
	
	if($separate_flag == True){
				$new_lead_status = $leads_new_info['status'];
				$data =  array(
					'tracking_no' => $leads_new_info['tracking_no'], 
					'agent_id' => $leads_new_info['agent_id'], 
					'business_partner_id' => $leads_new_info['business_partner_id'], 
					'timestamp' => $leads_new_info['timestamp'], 
					'status' => $leads_new_info['status'], 
					'lname' => trim($_POST['lname']), 
					'fname' => trim($_POST['fname']), 
					'email' => trim($_POST['email']),
					'officenumber' => $leads_new_info['officenumber'], 
					'mobile' => $leads_new_info['mobile'],  
					'leads_country' => $leads_new_info['leads_country'], 
					'leads_ip' => $leads_new_info['leads_ip'],
					'location_id' => $leads_new_info['location_id'], 
					'registered_in' => $leads_new_info['registered_in'], 
					'registered_url' => $leads_new_info['registered_url'], 
					'registered_domain' => $leads_new_info['registered_domain']
				);
				
				//TODO 
				// - EMAIL VALIDATION
				
				$db->insert('leads' ,$data);
				$new_leads_id = $db->lastInsertId();
				
				//update all the leads messages that are associated with $leads_id
				$data = array('leads_id' => $new_leads_id, 'leads_type' => 'regular') ;
				$where = "leads_id = ".$leads_id. " AND leads_type = 'temp'";
				$db->update('leads_message', $data , $where);
				
				
				//DELETE the RECORD
				$where = "id = ".$_POST['leads_new_info_id'];	
				$db->delete('leads_new_info' , $where);
				
				//update the personal_id of the lead
				$data = array('personal_id' => $new_leads_id);
				$where = "id = ".$new_leads_id;
				$db->update('leads', $data , $where);
				
				//update the personal_id of the lead
				$data = array('marked' => 'no' );
				$where = "id = ".$leads_id;
				$db->update('leads', $data , $where);
				
				
				//important we parse all leads transactions record in this profile
				//id, leads_id, leads_new_info_id, reference_column_name, reference_no, reference_table, date_added
				$sql = $db->select()
					->from('leads_transactions')
					->where('leads_id =?' , $leads_id)
					->where('leads_new_info_id =?' , $_POST['leads_new_info_id']);
				$transactions = $db->fetchAll($sql);	
				foreach($transactions as $transaction){
					//we assume that all column field name is leads_id , debug if not , must have a condition in this matter
					$data = array('leads_id' => $new_leads_id);
					$where = $transaction['reference_column_name']." = ".$transaction['reference_no'];
					$table = $transaction['reference_table'];
					$db->update($table, $data , $where);
					
					//delete the record after updating
					$where = "id = ".$transaction['id'];	
					$db->delete('leads_transactions' , $where);
				}
				
				
				
				
				
				//save the history
				//LEADS INFORMATION
				$sql = $db->select()
					->from('leads')
					->where('id =?' ,$leads_id);
				$leads_info = $db->fetchRow($sql);
			
				$history_changes = "Separated from #".$leads_id." ".$leads_info['fname']." ".$leads_info['lname']." [ ".$leads_info['email']." ]";
				$changes = array(
							 'leads_id' => $new_leads_id ,
							 'date_change' => $ATZ, 
							 'changes' => $history_changes, 
							 'change_by_id' => $created_by_id, 
							 'change_by_type' => $created_by_type
				);
				$db->insert('leads_info_history', $changes);
				
				$history_changes = trim($_POST['fname'])." ".trim($_POST['lname'])." [ ".trim($_POST['email'])." ] separated to  #".$leads_id." ".$leads_info['fname']." ".$leads_info['lname']." [ ".$leads_info['email']." ]";
				$changes = array(
							 'leads_id' => $leads_id ,
							 'date_change' => $ATZ, 
							 'changes' => $history_changes, 
							 'change_by_id' => $created_by_id, 
							 'change_by_type' => $created_by_type
				);
				$db->insert('leads_info_history', $changes);
			
				echo "<script> alert('Successfully separated.');window.location=\"leads_information.php?id=".$new_leads_id."&lead_status=".$new_lead_status."&separated=TRUE\"; </script>";
			
	}	
	
}


if(isset($_POST['send']))
{
	
	$leads_id=$_POST['leads_id'];
	$lead_status = $_POST['lead_status'];
	$templates = $_POST['templates'];
	
	$credit_debit_card = $_POST['credit_debit_card'];
	//echo $credit_debit_card;
	$job_order_form =$_POST['job_order'];

	$quote = $_POST['quote'];
	$service_agreement = $_POST['service_agreement'];
	$setup_fee = $_POST['setup_fee'];


	if($quote!=NULL){
	
		$quote_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Quotation Link : </b></div>";
		$quote = explode(",",$quote);
		$counter=0;
		for($i=0; $i<count($quote);$i++){
			$counter++;
			//check if this quote has already a random no for security reason		
			$query = $db->select()
				->from('quote' , 'ran')
				->where('id = ?' , $quote[$i]);
			$ran = $db->fetchOne($query);
			
			if($ran==""  or $ran==NULL){
				$ran = get_rand_id();
				$ran = CheckRan($ran,'job_order');
				
				$data = array('ran' => $ran);
				$where = "id = ".$quote[$i];	
				$db->update('quote' , $data , $where);
				
				
				$query = $db->select()
					->from('quote' , 'ran')
					->where('id = ?' , $quote[$i]);
				$ran = $db->fetchOne($query);
				
			}
			
			$quote_MESSAGE .="<p>$counter.  <a href=http://$site/portal/pdf_report/quote/?ran=$ran>http://$site/portal/pdf_report/quote/?ran=".$ran."</a></p>";
		
			// Update the Quote
			$data = array('status' => 'posted' , 'date_posted' => $ATZ);
			$where = "id = ".$quote[$i];	
			$db->update('quote' , $data , $where);
		}
		$quote_MESSAGE.="<hr>";
		
	}else{
		$quote_MESSAGE="";
	}

	if($service_agreement!=NULL){
		$service_agreement_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Service Agreement & Contract link :</b></div>";
		$service_agreement_MESSAGE .="<p><b>PART 1 </b></p>";
		
		$service_agreement = explode(",",$service_agreement);
		$counter=0;
		for($i=0; $i<count($service_agreement);$i++){
		$counter++;
			
			$query = $db->select()
					->from('service_agreement' , 'ran')
					->where('service_agreement_id = ?' , $service_agreement[$i]);
			$ran = $db->fetchOne($query);
			
			if($ran==""  or $ran==NULL){
				$ran = get_rand_id();
				$ran = CheckRan($ran,'service_agreement');
						
				$data = array('ran' => $ran);
				$where = "service_agreement_id = ".$service_agreement[$i];
				$db->update('service_agreement' , $data , $where);
				
				$query = $db->select()
					->from('service_agreement' , 'ran')
					->where('service_agreement_id = ?' , $service_agreement[$i]);
				$ran = $db->fetchOne($query);
			}
			//echo $ran."<br>";
			$service_agreement_MESSAGE .="<p>$counter. <a href='http://$site/portal/pdf_report/service_agreement/?ran=$ran' target = '_blank'>http://$site/portal/pdf_report/service_agreement/?ran=".$ran."</a></p>";
			
			// Update the Service Agreement
			$data = array('status' => 'posted' , 'date_posted' => $ATZ);
			$where = "service_agreement_id = ".$service_agreement[$i];	
			$db->update('service_agreement' , $data , $where);
			
		}
		
		if(LOCATION_ID == 1){
			$pdf_path = "http://remotestaff.com.au/portal/service-agreements/AU-Services-Contract.pdf";
		}else if(LOCATION_ID == 2){
			$pdf_path = "http://remotestaff.com.au/portal/service-agreements/UK-Services-Contract.pdf";
		}else{
			$pdf_path = "http://remotestaff.com.au/portal/service-agreements/US-Services-Contract.pdf";
		}	

		
		$service_agreement_MESSAGE .="<p><b>PART 2</b></p>";	
		$service_agreement_MESSAGE .="<p><a href='$pdf_path'> - $pdf_path</a></p>";
		
		
		
		
		$service_agreement_MESSAGE.="<hr>";
		
	}else{
		$service_agreement_MESSAGE="";
	}


	if($setup_fee!=NULL){
		$setup_fee_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Recruitment Set-Up Fee Tax Invoice link : </b></div>";
		$setup_fee = explode(",",$setup_fee);
		$counter=0;
		for($i=0; $i<count($setup_fee);$i++){
		$counter++;
			
			$query = $db->select()
				->from('set_up_fee_invoice' , 'ran')
				->where('id = ?' , $setup_fee[$i]);
			$ran = $db->fetchOne($query);
			
			
			if($ran==""  or $ran==NULL){
				$ran = get_rand_id();
				$ran = CheckRan($ran,'set_up_fee_invoice');
				
				$data = array('ran' => $ran);
				$where = "id = ".$setup_fee[$i];
				$db->update('set_up_fee_invoice' , $data , $where);
				
				
				$query = "SELECT ran FROM set_up_fee_invoice WHERE id = ".$setup_fee[$i];
				$result =  mysql_query($query);
				list($ran)=mysql_fetch_array($result);
			}	
			
			$setup_fee_MESSAGE .="<p>$counter. <a href=http://$site/portal/pdf_report/spf/?ran=$ran>http://$site/portal/pdf_report/spf/?ran=".$ran."</a></p>";
		
			// Update the set_up_fee_invoice
			$data = array('status' => 'posted' , 'post_date' => $ATZ);
			$where = "id = ".$setup_fee[$i];	
			$db->update('set_up_fee_invoice' , $data , $where);
			
		}
		
		
		
		$setup_fee_MESSAGE.="<hr>";
	}else{
		$setup_fee_MESSAGE="";
	}


	if($job_order_form=="with"){ 
	
		$ran = get_rand_id();
		$ran = CheckRan($ran,'job_order');
		
		$data = array(
			'leads_id' => $leads_id,
			'created_by_id' => $created_by_id,
			'created_by_type' => $created_by_type,
			'date_created' => $ATZ,
			'status' => 'new',
			'ran' => $ran
		);
		//print_r($data);
		
		$db->insert('job_order', $data);
		$job_order_id = $db->lastInsertId();
		
		$job_order_form_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Job Specification Form link : </b></div>";
		$job_order_form_MESSAGE .= "<p>
										<a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran' target='_blank'>
											http://$site/portal/pdf_report/job_order_form/?ran=".$ran."
										</a>
									</p>";							
		
		// Update the Quote
		$data = array('status' => 'posted' , 'date_posted' => $ATZ);
		$where = "job_order_id = ".$job_order_id;	
		$db->update('job_order' , $data , $where);
			
		$job_order_form_MESSAGE.="<hr>";
		
	}else{
		$job_order_form_MESSAGE="";
	}

	if($credit_debit_card!=NULL){
	
		$credit_debit_card_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Credit Card / Direct Debit Form link : </b></div>";
		$credit_debit_card_MESSAGE .="<p><b>1.</b> <a href='http://$site/portal/pdf_report/credit_card_debit_form/?id=$leads_id' target='_blank'>http://$site/portal/pdf_report/credit_card_debit_form/?id=".$leads_id."</a></p>";
		$credit_debit_card_MESSAGE .="<p><b>2.</b> <a href='http://$site/portal/pdf_report/credit_card_debit_form/THKGENDirectDebitForm.pdf' target='_blank'>http://$site/portal/pdf_report/credit_card_debit_form/THKGENDirectDebitForm.pdf</a></p>";
		$credit_debit_card_MESSAGE .="<hr>";
		
	}else{
		$credit_debit_card_MESSAGE="";
	}
	


	if($lead_status == "") $lead_status = 'New Leads';
	
	$email = trim($_POST['email']);
	$subject = trim($_POST['subject']);
	$message = $_POST['message'];
	$cc = trim($_POST['cc']);
	$bcc = trim($_POST['bcc']);
	
	if($subject == "") $subject = "Message from Remotestaff c/o ".$session_name;
	$text = $quote_MESSAGE.$service_agreement_MESSAGE.$setup_fee_MESSAGE.$job_order_form_MESSAGE.$credit_debit_card_MESSAGE;
	$body = BuildEmailTemplate($message , $text ,$templates);
	
	$mail = new Zend_Mail('utf-8');
	$mail->setBodyHtml($body);
	$mail->setFrom($session_email, $session_name);
	
	if(! TEST){
		$mail->addTo($email , $email);
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	}
	
	if($cc!=""){
		$cc_array = explode(",",$cc);
		for($i=0; $i<count($cc_array);$i++){
			//echo $cc_array[$i]."<br>";
			$mail->addCc($cc_array[$i]);
		}
	}
	
	if($bcc!=""){
		$bcc_array = explode(",",$bcc);
		for($i=0; $i<count($bcc_array);$i++){
			$mail->addBcc($bcc_array[$i]);
		}
	}
	
	$mail->setSubject($subject);
	
	foreach($_FILES as $userfile){
		// store the file information to variables for easier access
		$tmp_name = $userfile['tmp_name'];
		$type = $userfile['type'];
		$name = $userfile['name'];
		$size = $userfile['size'];
		
		if($tmp_name != ""){
			$myImage = file_get_contents($tmp_name);
			$at = new Zend_Mime_Part($myImage);
			$at->type        = $type;
			$at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
			$at->encoding = Zend_Mime::ENCODING_BASE64;
			$at->filename    = $name;
			$mail->addAttachment($at);
			
			$attached_file_names .= "<li>".$name."</li>";
		}

	} 

	
	$mail->send($transport);
	if($attached_file_names !=""){
		$attached_file_names_str = "Attached Files<ol>".$attached_file_names."<ol>";
	}
	//save to history table
	$data = array(
			'agent_no' => $created_by_id,
			'created_by_type' => $created_by_type,
			'leads_id' =>  $leads_id,
			'actions' => 'EMAIL',
			'subject' => $subject,
			'history' => $message.$text.$attached_file_names_str,
			'date_created' => $ATZ
			
		);
	$db->insert('history', $data);
	$history_id = $db->lastInsertId();
	
	
	$data = array(
			'leads_id' => $leads_id, 
			'leads_new_info_id' => $leads_new_info['id'], 
			'reference_column_name' => 'id',
			'reference_no' => $history_id , 
			'reference_table' => 'history', 
			'date_added' => $ATZ
		);
	$db->insert('leads_transactions', $data);
	
	
	if($quote!=NULL){
		for($i=0; $i<count($quote);$i++){
			$data= array(
				'history_id' => $history_id,
				'leads_id' => $leads_id ,
				'attachment' => $quote[$i], 
				'attachment_type' => 'Quote',
				'date_attach' => $ATZ, 
				'user_type_id' => $created_by_id, 
				'user_type' => $created_by_type
			);
			$db->insert('history_attachments', $data);
		}
	}
	
	if($service_agreement!=NULL){
		for($i=0; $i<count($service_agreement);$i++){
			
			$data= array(
				'history_id' => $history_id,
				'leads_id' => $leads_id ,
				'attachment' => $service_agreement[$i], 
				'attachment_type' => 'Service Agreement',
				'date_attach' => $ATZ, 
				'user_type_id' => $created_by_id, 
				'user_type' => $created_by_type
			);
			$db->insert('history_attachments', $data);
		}
	}
	
	if($setup_fee!=NULL){
		for($i=0; $i<count($setup_fee);$i++){
			
			$data= array(
				'history_id' => $history_id,
				'leads_id' => $leads_id ,
				'attachment' => $setup_fee[$i], 
				'attachment_type' => 'Set-Up Fee Invoice',
				'date_attach' => $ATZ, 
				'user_type_id' => $created_by_id,
				'user_type' => $created_by_type
			);
			$db->insert('history_attachments', $data);
		}
	}

	
	//$smarty->assign('mess_sent',True);
	$msg ="Message sent";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   location.href="leads_information2.php?id='.$leads_id.'&lead_status='.$lead_status.'&page_type='.$page_type.'#A";
	</script>';
	
}


if(isset($_POST['save']))
{
	$leads_id=$_POST['leads_id'];
	$lead_status = $_POST['lead_status'];
	$action = $_POST['action'];
	$message = $_POST['message'];
	
	//echo $leads_id."<br>".$lead_status."<br>".$action."<br>".$message;
	$data = array(
			'agent_no' => $created_by_id,
			'created_by_type' => $created_by_type,
			'leads_id' =>  $leads_id,
			'actions' => $action,
			'history' => $message,
			'date_created' => $ATZ
			
		);
	$db->insert('history', $data);
	
	$history_id = $db->lastInsertId();
	$data = array(
			'leads_id' => $leads_id, 
			'leads_new_info_id' => $leads_new_info['id'],
			'reference_column_name' => 'id', 
			'reference_no' => $history_id , 
			'reference_table' => 'history', 
			'date_added' => $ATZ
		);
	$db->insert('leads_transactions', $data);
}


//
if(isset($_POST['update_history']))
{
	//echo $_POST['history_id']."<br>";
	//echo $_POST['content']."<br>";
	$data = array('history' => $_POST['content']);
	$where = "id = ".$_POST['history_id'];	
	$db->update('history', $data , $where);
	$smarty->assign('update_history',True);
	
}

if(isset($_POST['delete_history']))
{
	//echo $_POST['history_id']."<br>";
	//echo $_POST['content']."<br>";
	//$data = array('history' => $_POST['content']);
	$where = "id = ".$_POST['history_id'];	
	$db->delete('history', $where);
	$smarty->assign('delete_history',True);
	
}





	






//all leads
$and = " ";
if($created_by_type == "agent"){
	$and = " AND l.business_partner_id = $agent_no ";
}
/*
$queryAllLeads = "SELECT id, CONCAT(fname,' ',lname)AS lead_name, company_name , DATE(timestamp)AS registered_date,CONCAT(MONTH(timestamp),'-',YEAR(timestamp))AS month_year
	FROM leads l
	WHERE l.status = '$lead_status'
	$and
	ORDER BY l.fname ASC;";

$result = $db->fetchAll($queryAllLeads);
foreach($result as $result)
{
	if($leads_id == $result['id'] ) {
		$leads_Options.="<option value=".$result['id']." selected>".$result['lead_name']."</option>";
	}else{
		$leads_Options.="<option value=".$result['id']." >".$result['lead_name']."</option>";
	}	
	
	if($AusDate == $result['registered_date']){
		if($leads_id == $result['id'] ) {
			$leads_Options2.="<option value=".$result['id']." selected>".$result['lead_name']."</option>";
		}else{
			$leads_Options2.="<option value=".$result['id']." >".$result['lead_name']."</option>";
		}	
	}
	
}

$queryAllLeads2 = "SELECT id, CONCAT(fname,' ',lname)AS lead_name, company_name , DATE_FORMAT(timestamp,'%D %b %y')AS timestamp
	FROM leads l
	WHERE l.status = '$lead_status'
	$and
	ORDER BY timestamp DESC;";

$result = $db->fetchAll($queryAllLeads2);
foreach($result as $result)
{
	if($leads_id == $result['id'] ) {
		$leads_Options3.="<option value=".$result['id']." selected>".$result['lead_name']."</option>";
	}else{
		$leads_Options3.="<option value=".$result['id']." >".$result['lead_name']."</option>";
	}	
	
	
}
*/
//LEADS RATINGS
$rating = $leads_new_info['rating'];
if($rating == "") $rating =0;
for($i=0; $i<=5;$i++){
	//rate
	if($leads_new_info['rating'] == $i){
		$rate_Options .="<option value=".$i." selected='selected'>".$i."</option>";
	}else{
		$rate_Options .="<option value=".$i.">".$i."</option>";
	}	
}
//stars to be displayed
for($i=1; $i<=$rating;$i++){
	$starOptions.='<img src="images/star.png" align="top">';
}

function getAttachment($id,$type,$mode){
	global $db;
	
	if($mode == "history"){
		if($type=="Quote"){
		
			$sql = $db->select()
				->from('quote')
				->where('id =?', $id);
			$row = $db->fetchRow($sql);
			$str = " <a href='./pdf_report/quote/?ran=".$row['ran']."' target='_blank' class='link10'>Quote #".$row['quote_no']."</a>";
		}
		if($type=="Set-Up Fee Invoice"){

			$sql = $db->select()
				->from('set_up_fee_invoice')
				->where('id =?', $id);
			$row = $db->fetchRow($sql);
			$str = " <a href=./pdf_report/spf/?ran=".$row['ran']."$id target='_blank' class='link10'>Invoice #".$row['invoice_number']."</a>";
		}
		if($type=="Service Agreement"){

			$sql = $db->select()
				->from('service_agreement')
				->where('service_agreement_id =?', $id);
			$row = $db->fetchRow($sql);
			$str = " <a href='./pdf_report/service_agreement/?ran=".$row['ran']."' target='_blank' class='link10'>Service Agreement #".$id."</a>";
		}
		return $str;
	}
	if($mode == "details"){
		$sql = "SELECT DATE_FORMAT(date_attach,'%D %b %y')AS date_sent FROM history_attachments WHERE attachment = $id AND attachment_type = '$type';";
		$row = $db->fetchRow($sql);
		$date_sent = $row['date_sent'];
		if($date_sent!=NULL){
			$str = "Date Sent  ".$date_sent;
		}else{
			$str ="&nbsp;";
		}
		return $str;
	}
}

function CheckRan($ran,$table){
	global $db;

	//$table value 
	if($table == "quote"){
		$column = 'id';
	}
	
	if($table == "service_agreement"){
		$column = 'service_agreement_id';
	}
	
	if($table == "quote"){
		$column = 'id';
	}
	
	if($table == "job_order"){
		$column = 'job_order_id';
	}
	
	$query = $db->select()
		->from($table , $column)
		->where('ran = ?', $ran );
	$id = $db->fetchOne($query);	
	
	if($id !=""){
		// The random character is existing in the table
		$ran = get_rand_id();
		return $ran;
	}else{
		return $ran;
	}
	
}

//QUOTES
//Check if the leads is given by quote
$sqlQuote="SELECT id,DATE_FORMAT(date_quoted,'%D %b %y')AS date_quoted, quote_no , ran FROM quote q WHERE leads_id = $leads_id;";
$quotes =  $db->fetchAll($sqlQuote);
//echo $sqlQuote;		
foreach($quotes as $quote){
	$quote_id = $quote['id'];
	$ran = $quote['ran'];

	if($ran==""  or $ran==NULL){
		$ran = get_rand_id();
		$ran = CheckRan($ran,'quote');
		$data = array('ran' => $ran);
		$where = "id = ".$quote_id;	
		$db->update('quote' , $data , $where);
	}
}

//SERVICE AGREEMENT
$sqlServiceAgreement = "SELECT DATE_FORMAT(date_created,'%D %b %y')AS date_created, service_agreement_id, q.quote_no , s.ran
									FROM service_agreement s
									LEFT JOIN quote q ON q.id = s.quote_id
									WHERE s.leads_id = $leads_id;";
$service_agreements = $db->fetchAll($sqlServiceAgreement);
foreach($service_agreements as $service_agreement){

	$service_agreement_id = $service_agreement['service_agreement_id'];
	$ran = $service_agreement['ran'];
	
	if($ran==""  or $ran==NULL){
		$ran = get_rand_id();
		$ran = CheckRan($ran,'service_agreement');
		$data = array('ran' => $ran);
		$where = "service_agreement_id = ".$service_agreement_id;	
		$db->update('service_agreement' , $data , $where);
	}
	
}




//SETUP FEE INVOICE
$sqlSetUpFeeInvoice ="SELECT id,DATE_FORMAT(invoice_date,'%D %b %y')AS invoice_date, invoice_number , ran  FROM set_up_fee_invoice s WHERE leads_id = $leads_id;";
$sfinvoices = $db->fetchAll($sqlSetUpFeeInvoice);
foreach($sfinvoices as $sfinvoice){
	$setup_fee_id = $sfinvoice['id'];
	$ran = $sfinvoice['ran'];
	
	if($ran==""  or $ran==NULL){
		$ran = get_rand_id();
		$ran = CheckRan($ran,'set_up_fee_invoice');
		$data = array('ran' => $ran);
		$where = "id = ".$setup_fee_id;	
		$db->update('set_up_fee_invoice' , $data , $where);
	}
	
}










//use in Quick Glance
if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	$sql = $db->select()
		->from('leads')
		->where('business_partner_id =?' , $_SESSION['agent_no'])
		->where('status =?' , $lead_status)
		->order('fname ASC');
		
	//$leads_list = $db->fetchAll($sql);	
}else{
	$sql = $db->select()
		->from('leads')
		->where('status =?' , $lead_status)
		->order('fname ASC');
	//$leads_list = $db->fetchAll($sql);	
}
//$smarty->assign('leads_list' , $leads_list);














//echo $leads_new_info['leads_country'];
$sql = $db->select()
	->from('country');
$countries = $db->fetchAll($sql);	
foreach($countries as $country){

	if($leads_new_info['leads_country'] == $country['printable_name']){
		$countryOptions .= "<option value=\"".$country['printable_name']."\" selected='selected'>".$country['printable_name']."</option>";
		
	}else{
		$countryOptions .= "<option value=\"".$country['printable_name']."\">".$country['printable_name']."</option>";
	}
	
}


$indutryArray=array("Accounting","Administration","Advert./Media/Entertain.","Banking & Fin. Services","Call Centre/Cust. Service","Community & Sport","Construction","Consulting & Corp. Strategy","Education & Training","Engineering","Government/Defence","Healthcare & Medical","Hospitality & Tourism","HR & Recruitment","Insurance & Superannuation","I.T. & T","Legal","Manufacturing/Operations","Mining, Oil & Gas","Primary Industry","Real Estate & Property","Retail & Consumer Prods.","Sales & Marketing","Science & Technology","Self-Employment","Trades & Services","Transport & Logistics");  
for ($i = 0; $i < count($indutryArray); $i++) {
	if($leads_new_info['company_industry'] == $indutryArray[$i])
	{
		$industryoptions .= "<option selected value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
	}
	else
	{
		$industryoptions .= "<option value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
	}
}
   
$moneyArray=array("$0 to $300,000","$300,000 to $700,000","$700,000 to $1.2m","$1.2m to $2m","$2m to $3m","$3 to $5m","Above $5m");
for ($i = 0; $i < count($moneyArray); $i++) {
	if($leads_new_info['company_turnover'] == $moneyArray[$i])
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
	if($leads_new_info['remote_staff_one_home']==$YesNoArray[$i]){
		$rsInHomeOptions .= "<option value=\"".$YesNoArray[$i]."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$rsInHomeOptions .= "<option value=\"".$YesNoArray[$i]."\" >".$YesNoArray[$i]."</option>";
	}
	
	if($leads_new_info['remote_staff_one_office']==$YesNoArray[$i]){
		$rsInOfficeOptions .= "<option value=\"".$YesNoArray[$i]."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$rsInOfficeOptions .= "<option value=\"".$YesNoArray[$i]."\" >".$YesNoArray[$i]."</option>";
	}
	
	if($leads_new_info['email_receives_invoice'] == strtolower($YesNoArray[$i])){
		$email_receives_invoiceOptions .= "<option value=\"".strtolower($YesNoArray[$i])."\" selected>".$YesNoArray[$i]."</option>";
	}else{
		$email_receives_invoiceOptions .= "<option value=\"".strtolower($YesNoArray[$i])."\" >".$YesNoArray[$i]."</option>";
	}
	

}


$action_history = AdminBPActionHistoryToLeads($leads_id , 'temp');
$admin_action_history = AdminActionHistoryToLeads($leads_id ,'temp');
$bp_action_history = BPActionHistoryToLeads($leads_id , 'temp');

$book_lead_method = 'temp';
include 'FilterBookingQuestions.php';

$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}

$smarty->assign('book_lead_method',$book_lead_method);
$smarty->assign('page_type',$page_type);
$smarty->assign('mode' , $mode);
$smarty->assign('countryOptions',$countryOptions);
$smarty->assign('industryoptions',$industryoptions);
$smarty->assign('moneyoptions',$moneyoptions);
$smarty->assign('rsInHomeOptions',$rsInHomeOptions);
$smarty->assign('rsInOfficeOptions',$rsInOfficeOptions);
$smarty->assign('email_receives_invoiceOptions',$email_receives_invoiceOptions);

$smarty->assign('upload_status',$upload_status); //roy variable

$smarty->assign('hired_staff_Options',$hired_staff_Options); //roy variable

$smarty->assign('setupfee_page',$setupfee_page);

$smarty->assign('service_agreement_page',$service_agreement_page);
$smarty->assign('create_a_quote',$create_a_quote);
$smarty->assign('update_page',$update_page);

$smarty->assign('resumes',$resumes);
$smarty->assign('action_history', $action_history);
$smarty->assign('admin_action_history', $admin_action_history);
$smarty->assign('bp_action_history', $bp_action_history);

$smarty->assign('url' ,$url);

$smarty->assign('posted_quotes', $posted_quotes);
$smarty->assign('posted_quotes_num', $posted_quotes_num);

$smarty->assign('posted_service_agreements', $posted_service_agreements);
$smarty->assign('posted_service_agreements_num', $posted_service_agreements_num);

$smarty->assign('posted_set_up_fee_invoices', $posted_set_up_fee_invoices);
$smarty->assign('posted_set_up_fee_invoices_num', $posted_set_up_fee_invoices_num);

$smarty->assign('posted_job_orders', $posted_job_orders);
$smarty->assign('posted_job_orders_num', $posted_job_orders_num);


		
$smarty->assign('sfinvoices', $sfinvoices);
$smarty->assign('service_agreements', $service_agreements);
$smarty->assign('quotes',$quotes);

$smarty->assign('starOptions' , $starOptions);
$smarty->assign('rate_Options' , $rate_Options);

$smarty->assign('stepsTaken' , getStepsTaken2($leads_id));
$smarty->assign('bttn' , $bttn);
$smarty->assign('showLeadsInfoChangesHistory' , showLeadsInfoChangesHistory($leads_id , 'yes' , '0'));

$smarty->assign('lead_status' , $lead_status);
$smarty->assign('AusDate' , format_date($AusDate));
$smarty->assign('leads_Options' , $leads_Options);
$smarty->assign('leads_Options2' , $leads_Options2);
$smarty->assign('leads_Options3' , $leads_Options3);

$smarty->assign('date_registered' , $date_registered);
$smarty->assign('leads_of' , $leads_of);
$smarty->assign('leads_id' , $leads_id);

$smarty->assign('tab1' , "class='selected'");
$smarty->display('leads_information2.tpl');
?>