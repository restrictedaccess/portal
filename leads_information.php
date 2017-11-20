<?php
#2010-11-02: ROY - csro files upload(line 695 - 749)
#2010-11-03: ROY - csro files upload - function to add all staff(line 695 - 766)
mb_language('uni');
mb_internal_encoding('UTF-8');
include('conf/zend_smarty_conf.php');
require('./tools/CouchDBMailbox.php');
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';
header('Content-type: text/html; charset=utf-8');



//header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
//header("Cache-Control: no-cache");
//header("Pragma: no-cache");
$smarty = new Smarty;

$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$AusTime = date("H:i:s");
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

/*
if(isset($_GET['submitted'])){
    $msg ="Message sent";
	echo '<script language="javascript">
	   alert("'.$msg.'");

	</script>';
}
*/
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

	$view_leads_setting = $agent['view_leads_setting'];
	$access_all_leads = $agent['access_all_leads'];
	$change_by_type = 'bp';


	$agent_code = $agent['agent_code'];
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br>%s<br />%s</div>" ,$session_name,$session_email,$agent['agent_address'],$agent['agent_contact']);

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
	$admin_status=$_SESSION['status'];
	$change_by_type = 'admin';

	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br>%s<br>%s</div>" ,$admin['signature_notes'],$session_name,$session_email,$admin['signature_company'],$admin['signature_contact_nos'],$admin['signat%s<br />%s<br ure_websites']);

}else{

	header("location:index.php");
	exit;
}



$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];
$page_type = $_REQUEST['page_type'];

function BuildEmailTemplate($mess , $text ,$template, $email_sender=NULL){
    //return $email_sender;
	$site = $_SERVER['HTTP_HOST'];
	global $db;
	global $smarty;

	if (is_numeric($email_sender)) {
        $admin_id = $email_sender;
		$sql=$db->select()
			->from('admin')
			->where('admin_id = ?' ,$admin_id);
		$admin = $db->fetchRow($sql);
		$smarty->assign('admin',$admin);
		$agent_code = '101';
		if($admin['userid']){
			$sql = "SELECT job_designation, skype_id, staff_email FROM subcontractors WHERE status ='ACTIVE' AND leads_id=11 AND userid=".$admin['userid'];
			$subcon = $db->fetchRow($sql);
			$smarty->assign('subcon',$subcon);
		}
    } else {
		if($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL){

			$sql=$db->select()
				->from('agent')
				->where('agent_no = ?' ,$_SESSION['agent_no']);
			$agent = $db->fetchRow($sql);
			$agent_code = $agent['agent_code'];
			$smarty->assign('agent',$agent);
			$title = "Business Developer";

		}
		if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

			$admin_id = $_SESSION['admin_id'];
			$sql=$db->select()
				->from('admin')
				->where('admin_id = ?' ,$admin_id);
			$admin = $db->fetchRow($sql);
			$smarty->assign('admin',$admin);
			$agent_code = '101';
			if($admin['userid']){
				$sql = "SELECT job_designation, skype_id, staff_email FROM subcontractors WHERE status ='ACTIVE' AND leads_id=11 AND userid=".$admin['userid'];
				$subcon = $db->fetchRow($sql);
				$smarty->assign('subcon',$subcon);
			}


		}
	}
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';

	// Processes \r\n's first so they aren't converted twice.
	$newstr = str_replace($order, $replace, $mess);


	$body=$mess;
	if($template == "signature") {
		$smarty->assign('agent_code',$agent_code);
		$smarty->assign('title',$title);
		$smarty->assign('mess',stripslashes($newstr));
		$smarty->assign('text',$text);
		$body = $smarty->fetch('signature_template.tpl');
	}else{
		$body = "<div align='justify' style='padding:15px;margin-top:10px;' >".stripslashes($newstr)."</div>
				 <div align='justify' style='padding:15px;margin-top:10px;' >".$text."</div>";
	}
	return $body;

}


if(isset($_POST['send_save']))
{
	//include './leads_information/BuildEmailTemplate.php';
	$leads_id=$_POST['leads_id'];
	$lead_status = $_POST['lead_status'];
	$templates = $_POST['templates'];

	$credit_debit_card = $_POST['credit_debit_card'];
	$ezi_debit_form = $_POST['ezi_debit_form'];
	$job_order_form =$_POST['job_order'];

	$quote = $_POST['quote'];
	$service_agreement = $_POST['service_agreement'];
	$setup_fee = $_POST['setup_fee'];
	$credit_debit_card_MESSAGE ="";
    //echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
	//exit;
	if(trim($_POST['email'])==""){
		$msg ="Please enter an email address.";
		$url = sprintf('leads_information.php?id=%s',$leads_id);
	    echo '<script language="javascript">
	       alert("'.$msg.'");
	       location.href="'.$url.'";
	    </script>';
		exit;
	}
	//exit;
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

			$data = array(
                'leads_id' => $leads_id,
	            'date_change' => $ATZ,
	            'changes' => sprintf('Sent a Quote #%s',$quote[$i]),
	            'change_by_id' => $created_by_id,
	            'change_by_type' => $change_by_type
            );
            $db->insert('leads_info_history', $data);

		}
		$quote_MESSAGE.="<br>";

	}else{
		$quote_MESSAGE="";
	}

	if($service_agreement!=NULL){
		$service_agreement_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Service Agreement & Contract link :</b></div>";
		//service_agreement_MESSAGE .="<p><b>PART 1 </b></p>";
		$sql = $db->select()
		    ->from('leads')
			->where('id =?', $leads_id);
		$lead = $db->fetchRow($sql);

		$service_agreement = explode(",",$service_agreement);

		//print_r($service_agreement);exit;
		$counter=0;
		for($i=0; $i<count($service_agreement);$i++){
		    $counter++;
			//echo $service_agreement[$i]."<br>";
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
			$service_agreement_MESSAGE .="<p><a href='http://$site/portal/pdf_report/service_agreement/?ran=$ran' target = '_blank'>http://$site/portal/pdf_report/service_agreement/?ran=".$ran."</a></p>";

			//get quote.id
			$sql = $db->select()
			    ->from('service_agreement', 'quote_id')
				->where('service_agreement_id = ?' , $service_agreement[$i]);
			//echo $sql;exit;
			$quote_id = $db->fetchOne($sql);
						//echo $quote_id;exit;
			//now get the quote details
			$sql = $db->select()
			    ->from('quote_details')
				->where('quote_id =?', $quote_id);
			$quote_details = $db->fetchAll($sql);
			//echo $sql."<br>";

			//print_r($quote_details);exit;
			//template
			$smarty->assign('ran',$ran);
			$smarty->assign('signature_notes',$signature_notes);
			$smarty->assign('lead', $lead);
			$smarty->assign('site', $site);
			$smarty->assign('quote_details', $quote_details);
			$service_agreement_template = $smarty->fetch('service_agreement_template.tpl');

			$attachments_array =NULL;
			$to_array = NULL;
			$bcc_array=NULL;
			$cc_array = NULL;
			$from = sprintf('%s<%s>', $session_name, $session_email);
			$html = $service_agreement_template;
			$subject = "Remote Staff Service Agreement Online Form";
			//$text = NULL;

			$to_array[] = trim($_POST['email']);
			if($cc!=""){
		       $cc_array_str = explode(",",$cc);
		       for($x=0; $x<count($cc_array_str);$x++){
			       $cc_array[]=trim($cc_array_str[$x]);
		       }
	        }

	        if($bcc!=""){
		        $bcc_array_str = explode(",",$bcc);
		        for($j=0; $j<count($bcc_array_str);$j++){
			        $bcc_array[]=trim($bcc_array_str[$j]);
		        }
	        }

			//Cc and Bcc Hiring Managers and Csro
			if($_POST['cc_hm']){
				$cc_array[]=$_POST['cc_hm'];
			}

			if($_POST['cc_csro']){
				$cc_array[]=$_POST['cc_csro'];
			}

			if($_POST['bcc_hm']){
				$bcc_array[]=$_POST['bcc_hm'];
			}

			if($_POST['bcc_csro']){
				$bcc_array[]=$_POST['bcc_csro'];
			}

			//accounts and Business Developoer
			if($_POST['cc_accounts']){
				$cc_array[]=$_POST['cc_accounts'];
			}

			if($_POST['cc_bd']){
				$cc_array[]=$_POST['cc_bd'];
			}

			if($_POST['bcc_accounts']){
				$bcc_array[]=$_POST['bcc_accounts'];
			}

			if($_POST['bcc_bd']){
				$bcc_array[]=$_POST['bcc_bd'];
			}

			if($_POST['email_sender']){
				$from = $_POST['email_sender'];
				if (is_numeric($from)) {
					$sql=$db->select()
					   ->from('admin', 'admin_email')
					   ->where('admin_id =?', $from);
					$from = $db->fetchOne($sql);
				}
			}

			//echo $from;
			//exit;
			SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);


			// Update the Service Agreement
			$data = array('status' => 'posted' , 'date_posted' => $ATZ, 'posted_by' => $created_by_id, 'posted_by_type' => $created_by_type);

			$where = "service_agreement_id = ".$service_agreement[$i];
			//echo $where;exit;
			//print_r($data);exit;
			$db->update('service_agreement' , $data , $where);

			$API_URL = "https://api.remotestaff.com.au";
			if(TEST){
				$API_URL = "http://test.api.remotestaff.com.au";
			}

			file_get_contents($API_URL . "/mongo-index/sync-service-agreement?service_agreement_id=" . $service_agreement[$i]);


			$data = array(
         	      'leads_id' => $leads_id,
	            'date_change' => $ATZ,
	            'changes' => sprintf('Sent a Service Agreement #%s',$service_agreement[$i]),
	            'change_by_id' => $created_by_id,
	            'change_by_type' => $change_by_type
            );
            $db->insert('leads_info_history', $data);

		}


		$service_agreement_MESSAGE.="<br>Service Agreement Online Form link sent.";
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

			$data = array(
                'leads_id' => $leads_id,
	            'date_change' => $ATZ,
	            'changes' => sprintf('Sent a Set up Fee #%s',$setup_fee[$i]),
	            'change_by_id' => $created_by_id,
	            'change_by_type' => $change_by_type
            );
            $db->insert('leads_info_history', $data);


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

		$db->insert('gs_job_role_selection', $data);
		$custom_recruitment_id = $db->lastInsertId();
		//$site = 'localhost/new_home_pages';
		$custom_recruitment_link = sprintf('http://%s/portal/custom_get_started/step2_leads.php?ran=%s', $site, $ran);
		$job_order_form_MESSAGE = "<div style='margin-bottom:10px;color:red;' ><b>Custom Recruitment link : </b></div>";
		$job_order_form_MESSAGE .= "<p><a href='$custom_recruitment_link' target='_blank'>$custom_recruitment_link</a></p>";

		// Update the Quote
		//$data = array('status' => 'posted' , 'date_posted' => $ATZ);
		//$where = "job_order_id = ".$job_order_id;
		//$db->update('job_order' , $data , $where);

		//$job_order_form_MESSAGE.="<hr>";

		$data = array(
                'leads_id' => $leads_id,
	            'date_change' => $ATZ,
	            'changes' => sprintf('Sent a Custom Recruitment link #%s',$custom_recruitment_id),
	            'change_by_id' => $created_by_id,
	            'change_by_type' => $change_by_type
        );
        $db->insert('leads_info_history', $data);


	}else{
		$job_order_form_MESSAGE="";
	}


	if($credit_debit_card!=NULL){
		$credit_debit_card_MESSAGE .= "<div style='margin-bottom:10px;color:red;' ><b>Credit Card  Direct Debit Form link : </b></div>";
		$credit_debit_card_MESSAGE .="<p><a href='http://$site/portal/pdf_report/credit_card_debit_form/?id=$leads_id' target='_blank'>http://$site/portal/pdf_report/credit_card_debit_form/?id=".$leads_id."</a></p>";
		//$credit_debit_card_MESSAGE .= "<div style='margin-bottom:10px;color:red;' ><b>Check Credit Card  Direct Debit Form attached. </b></div>";

		$data = array(
                'leads_id' => $leads_id,
	            'date_change' => $ATZ,
	            'changes' => 'Credit Card  Direct Debit Form link',
	            'change_by_id' => $created_by_id,
	            'change_by_type' => $change_by_type
        );
        $db->insert('leads_info_history', $data);

	}


	if($ezi_debit_form!=NULL){
		$credit_debit_card_MESSAGE .= "<div style='margin-bottom:10px;color:red;' ><b>EZI Debit Form link : </b></div>";
		$credit_debit_card_MESSAGE .="<p><a href='http://$site/portal/pdf_report/credit_card_debit_form/THKGENDirectDebitForm.pdf' target='_blank'>http://$site/portal/pdf_report/credit_card_debit_form/THKGENDirectDebitForm.pdf</a></p>";

		$data = array(
                'leads_id' => $leads_id,
	            'date_change' => $ATZ,
	            'changes' => 'EZI Debit Form link',
	            'change_by_id' => $created_by_id,
	            'change_by_type' => $change_by_type
        );
        $db->insert('leads_info_history', $data);

	}



	if($lead_status == "") $lead_status = 'New Leads';

	$email = trim($_POST['email']);
	/*
	if($email==""){
		$msg ="Please enter an email address.";
		$url = sprintf('leads_information.php?id=%s',$leads_id);
	    echo '<script language="javascript">
	       alert("'.$msg.'");
	       location.href="'.$url.'";
	    </script>';
		exit;
	}
	*/
	$subject = trim($_POST['subject']);

	$message = $_POST['message'];
	$cc = trim($_POST['cc']);
	$bcc = trim($_POST['bcc']);
	if($message == "") {
	    $message = "&nbsp;";
	}

	if($subject == "") $subject = "Message from Remotestaff c/o ".$session_name;
	$text = $quote_MESSAGE.$service_agreement_MESSAGE.$setup_fee_MESSAGE.$job_order_form_MESSAGE.$credit_debit_card_MESSAGE;

	$templateList = array( "dst_start",
						   "dst_end",
						   "queens",
						   "anzac",
						   "au_australia_day",
						   "au_labour_day",
						   "au_melbourne_cup_day_2014",
						   "au_melbourne_cup_day",
						   "au_christmas_day",
						   "au_christmas_day_2014",
						   "christmas_day_2014",
						   "au_holy_week_2016",

						   "us_veterans_day_2014",
						   "us_labor_day",
						   "columbus_day",
						   "us_veterans_day",
						   "us_thanks_giving",
						   "us_christmas_day",
						   "us_new_year",

						   "ukus_christmas_day_2014",
					 	   "uk_new_year",
					  	   "uk_christmas_day");


	//echo $_POST["templates"];
	if (!in_array($_POST["template"], $templateList)){
		$body = BuildEmailTemplate($message , $text ,$templates, $_POST['email_sender']);
	}else{
		$body =$message;
	}
	//echo $body;
	//exit;
	$attachments_array =NULL;
	$to_array = NULL;
	$bcc_array=NULL;
    $cc_array = NULL;
    $from = sprintf('%s<%s>', $session_name, $session_email);
    $html = $body;
    $subject = $subject;
    //$text = NULL;
	$to_array[]=$email;

	if($cc!=""){
		$cc_array_str = explode(",",$cc);
		for($i=0; $i<count($cc_array_str);$i++){
			$cc_array[]=trim($cc_array_str[$i]);
		}
	}

	if($bcc!=""){
		$bcc_array_str = explode(",",$bcc);
		for($i=0; $i<count($bcc_array_str);$i++){
			$bcc_array[] = trim($bcc_array_str[$i]);
		}
	}


	foreach($_FILES as $userfile){
		// store the file information to variables for easier access
		$tmp_name = $userfile['tmp_name'];
		$type = $userfile['type'];
		$name = $userfile['name'];
		$size = $userfile['size'];
		if($tmp_name != ""){
			$data=array(
				'tmpfname' => $tmp_name,
				'filename' => $name,
				'type' => $type,
			);
			$attachments_array[] = $data;
			$attached_file_names .= "<li>".$name."</li>";
		}
	}


    if($credit_debit_card!=NULL){
	    //create the pdf file
		$pages = 0;
		$pdf = Zend_Pdf::load('pdf_report/credit_card_debit_form/remote_staf_credit_card_form.pdf');
		$pdf_page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf_page = $pdf->pages[$pages];

        $pdfString = $pdf->render();
	    $filename = "remote_staf_credit_card_form.pdf";

		$data=array(
			'tmpfname' => $pdfString,
			'filename' => $filename,
			'type' => 'application/pdf',
			'get_contents' => true
		);
		$attachments_array[] = $data;

	}


	//Cc and Bcc Hiring Managers and Csro
	if($_POST['cc_hm']){
		$cc_array[]=$_POST['cc_hm'];
	}

	if($_POST['cc_csro']){
		$cc_array[]=$_POST['cc_csro'];
	}

	if($_POST['bcc_hm']){
		$bcc_array[]=$_POST['bcc_hm'];
	}

	if($_POST['bcc_csro']){
		$bcc_array[]=$_POST['bcc_csro'];
	}

	//accounts and Business Developoer
	if($_POST['cc_accounts']){
		$cc_array[]=$_POST['cc_accounts'];
	}

	if($_POST['cc_bd']){
		$cc_array[]=$_POST['cc_bd'];
	}

	if($_POST['bcc_accounts']){
		$bcc_array[]=$_POST['bcc_accounts'];
	}

	if($_POST['bcc_bd']){
		$bcc_array[]=$_POST['bcc_bd'];
	}

	if($_POST['email_sender']){
		$from = $_POST['email_sender'];
		if (is_numeric($from)) {
			$sql=$db->select()
			   ->from('admin', 'admin_email')
			   ->where('admin_id =?', $from);
			$from = $db->fetchOne($sql);
		}
	}

	//echo $from;
	//exit;

	SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);


	if($attached_file_names !=""){
		$attached_file_names_str = "Attached Files<ol>".$attached_file_names."<ol>";
	}

	//save to history table
	if (!in_array($_POST["template"], $templateList)){
		$data = array(
			'agent_no' => $created_by_id,
			'created_by_type' => $created_by_type,
			'leads_id' =>  $leads_id,
			'actions' => 'EMAIL',
			'subject' => $subject,
			'history' => $message.$text.$attached_file_names_str,
			'date_created' => $ATZ

		);
	}else{

		$message = str_replace("@import url(http://fonts.googleapis.com/css?family=Orienta);", "", $message);
		$data = array(
			'agent_no' => $created_by_id,
			'created_by_type' => $created_by_type,
			'leads_id' =>  $leads_id,
			'actions' => 'EMAIL',
			'subject' => $subject,
			'history' => $message.$text.$attached_file_names_str,
			'date_created' => $ATZ

		);
	}

	$db->insert('history', $data);
	$history_id = $db->lastInsertId();

	$data = array(
         'leads_id' => $leads_id,
	     'date_change' => $ATZ,
	     'changes' => sprintf('Communication Record Type : [ %s ] Sent an email #%s', 'EMAIL', $history_id),
	     'change_by_id' => $created_by_id,
	     'change_by_type' => $change_by_type
    );
    $db->insert('leads_info_history', $data);



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

	//exit;
	$data = array('last_updated_date' => $ATZ);
    $db->update('leads', $data, 'id='.$leads_id);
	$url = sprintf('leads_information.php?id=%s&lead_status=%s&page_type=%s&submitted',$leads_id,$lead_status,$page_type);
	$msg ="Message sent";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   location.href="'.$url.'";
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
	     'date_change' => $ATZ,
	     'changes' => sprintf('Communication Record Type : [ %s ] History id #%s', $action, $history_id),
	     'change_by_id' => $created_by_id,
	     'change_by_type' => $change_by_type
    );
    $db->insert('leads_info_history', $data);

	$data = array('last_updated_date' => $ATZ);
    $db->update('leads', $data, 'id='.$leads_id);

	//$url = sprintf('leads_information.php?id=%s&lead_status=%s&page_type=%s',$leads_id,$lead_status,$page_type);
	//header("location:$url");
	//exit;

	$url = sprintf('leads_information.php?id=%s&lead_status=%s&page_type=%s&saved',$leads_id,$lead_status,$page_type);
	//$smarty->assign('mess_sent',True);
	$msg ="Actions Successfully Saved";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   location.href="'.$url.'";
	</script>';

}

if(isset($_POST['save_csr'])){
	//echo "save_csr";
	//echo $leads_id."<br>";
	//echo $created_by_id." ".$created_by_type."<br>";
	$data = array(
		'agent_no' => $created_by_id,
		'created_by_type' => $created_by_type,
		'leads_id' =>  $leads_id,
		'actions' => 'CSR',
		'date_created' => $ATZ

	);
	$db->insert('history', $data);
	$history_id = $db->lastInsertId();

	//id, history_id, question, answer
	for ($i = 0; $i < count($_POST['question']); ++$i){
		//echo $_POST['question'][$i]." ".$_POST['answer'][$i]."<br>";
		$data = array(
			'history_id' => $history_id,
			'question' => $_POST['question'][$i],
			'answer' => $_POST['answer'][$i]
		);
		$db->insert('history_csr', $data);
	}
	//exit;

	$data = array(
         'leads_id' => $leads_id,
	     'date_change' => $ATZ,
	     'changes' => sprintf('Communication Record Type : [ %s ] History id #%s', 'CSR', $history_id),
	     'change_by_id' => $created_by_id,
	     'change_by_type' => $change_by_type
    );
    $db->insert('leads_info_history', $data);

	$data = array('last_updated_date' => $ATZ);
    $db->update('leads', $data, 'id='.$leads_id);

	$url = sprintf('leads_information.php?id=%s&lead_status=%s&page_type=%s&saved',$leads_id,$lead_status,$page_type);
	//$smarty->assign('mess_sent',True);
	$msg ="Actions Successfully Saved";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   location.href="'.$url.'";
	</script>';

}


//
if(isset($_POST['update_history']))
{
	//echo $_POST['history_id']."<br>";
	//echo $_POST['content']."<br>";
	$sql = $db->select()
	    ->from('history')
		->where('id =?', $_POST['history_id']);
	$history = $db->fetchRow($sql);

	$data = array('history' => $_POST['content']);
	$where = "id = ".$_POST['history_id'];
	$db->update('history', $data , $where);
	$smarty->assign('update_history',True);

	$data = array(
         'leads_id' => $leads_id,
	     'date_change' => $ATZ,
	     'changes' => sprintf('Updated Communication Record Type : [ %s ] History id #%s from "%s" to "%s"', $history['actions'], $history['id'], $history['history'],$_POST['content'] ),
	     'change_by_id' => $created_by_id,
	     'change_by_type' => $change_by_type
    );
    $db->insert('leads_info_history', $data);


	$data = array('last_updated_date' => $ATZ);
    $db->update('leads', $data, 'id='.$leads_id);

	$url = sprintf('leads_information.php?id=%s&lead_status=%s&page_type=%s&updated',$leads_id,$lead_status,$page_type);
	//$smarty->assign('mess_sent',True);
	$msg ="Actions Successfully Updated";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   location.href="'.$url.'";
	</script>';

}

if(isset($_POST['delete_history']))
{
	$sql = $db->select()
	    ->from('history')
		->where('id =?', $_POST['history_id']);
	$history = $db->fetchRow($sql);

	$where = "id = ".$_POST['history_id'];
	$db->delete('history', $where);
	$smarty->assign('delete_history',True);

	$data = array(
         'leads_id' => $leads_id,
	     'date_change' => $ATZ,
	     'changes' => sprintf('Deleted Communication Record Type : [ %s ] History id #%s "%s" ', $history['actions'], $history['id'], $history['history'] ),
	     'change_by_id' => $created_by_id,
	     'change_by_type' => $change_by_type
    );
    $db->insert('leads_info_history', $data);


	$data = array('last_updated_date' => $ATZ);
    $db->update('leads', $data, 'id='.$leads_id);

	$url = sprintf('leads_information.php?id=%s&lead_status=%s&page_type=%s&deleted',$leads_id,$lead_status,$page_type);
	//$smarty->assign('mess_sent',True);
	$msg ="Actions Deleted";
	echo '<script language="javascript">
	   alert("'.$msg.'");
	   location.href="'.$url.'";
	</script>';
}


include './lib/addLeadsInfoHistoryChanges.php';
include ('./leads_information/AdminBPActionHistoryToLeads.php');
include ('./leads_information/LeadsSentResume.php');
//include 'steps_taken.php';
include 'lead_activity.php';
include 'appointment_calendar/session-variables.php';



//LEADS INFORMATION
$leads_id=$_REQUEST['id'];
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);
//echo "<pre>";
//print_r($leads_info);
//echo "</pre>";
//exit;
$leads_of = checkAgentAffiliates($leads_id);
$date_registered = format_date($leads_info['timestamp']);

//print_r($leads_info);

//LEADS NEW INFO (This lead registered again in the system)
$sql = $db->select()
	->from('leads_new_info')
	->where('leads_id =?' , $leads_id);
$leads_new_info = $db->fetchRow($sql);
//print_r(count($leads_new_info));
$smarty->assign('leads_new_info', $leads_new_info);
//$smarty->assign('leads_new_info_count' , count($leads_new_info));
//

//GET THE LEADS MESSAGE
$sql = $db->select()
	->from('leads_message')
	->where('leads_id =?' , $leads_id)
	->where('leads_type =?' , 'regular');
//echo $sql."<br>";
$leads_message_reg = $db->fetchAll($sql);
$smarty->assign('leads_message_reg', $leads_message_reg);
//print_r($leads_message_reg);

if($leads_new_info['id']){
	$sql = $db->select()
	->from('leads_message')
	->where('leads_id =?' , $leads_id)
	->where('leads_type =?' , 'temp');
//echo $sql."<br>";
$leads_message_temp = $db->fetchAll($sql);
$smarty->assign('leads_message_temp', $leads_message_temp);
}




//all leads
$and = " ";
if($created_by_type == "agent"){
	$and = " AND l.business_partner_id = $agent_no ";
}

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

function getAttachment($id,$type,$mode){
	global $db;

	if($mode == "history"){
		if($type=="Quote"){

			$sql = $db->select()
				->from('quote')
				->where('id =?', $id);
			$row = $db->fetchRow($sql);
			$str = " <a href='/portal/pdf_report/quote/?ran=".$row['ran']."' target='_blank' class='link10'>Quote #".$row['id']."</a>";
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

	if($table == "set_up_fee_invoice"){
		$column = 'id';
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
//print_r($quotes);

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
$sqlServiceAgreement = "SELECT DATE_FORMAT(date_created,'%D %b %y')AS date_created, service_agreement_id, q.quote_no , s.ran, accepted, date_accepted FROM service_agreement s LEFT JOIN quote q ON q.id = s.quote_id WHERE s.accepted='no' AND s.status NOT IN('removed') AND s.leads_id =$leads_id;";
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


include("leads_information-csro-include.php");


//SETUP FEE INVOICE
$sqlSetUpFeeInvoice ="SELECT id,DATE_FORMAT(invoice_date,'%D %b %y')AS invoice_date, invoice_number , ran  FROM set_up_fee_invoice s WHERE leads_id = $leads_id;";
$sfinvoices = $db->fetchAll($sqlSetUpFeeInvoice);
//print_r($sqlSetUpFeeInvoice);exit;
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

//exit;
//HISTORY
//quote
$query = "SELECT id, created_by, created_by_type, quote_no, status, DATE_FORMAT(date_posted,'%D %b %y')AS date_posted, ran  FROM quote q WHERE status='posted' AND leads_id = $leads_id;";
$posted_quotes = $db->fetchAll($query);
$posted_quotes_num = count($posted_quotes);

//service_agreement
$query = "SELECT service_agreement_id, status, DATE_FORMAT(date_posted,'%D %b %y')AS date_posted , ran  FROM service_agreement WHERE status='posted' AND leads_id = $leads_id;";
$posted_service_agreements = $db->fetchAll($query);
$posted_service_agreements_num = count($posted_service_agreements);

//set_up_fee_invoice
$query="SELECT id,invoice_number,DATE_FORMAT(post_date,'%D %b %y')AS post_date, ran FROM set_up_fee_invoice WHERE status='posted' AND leads_id = $leads_id;";
$posted_set_up_fee_invoices = $db->fetchAll($query);
$posted_set_up_fee_invoices_num = count($posted_set_up_fee_invoices);

//job_order
$query="SELECT job_order_id , DATE_FORMAT(date_posted,'%D %b %y')AS date_posted , ran FROM job_order WHERE status='posted' AND leads_id = $leads_id;";
$posted_job_orders = $db->fetchAll($query);
$posted_job_orders_num = count($posted_job_orders);


$resumes = LeadsSentResume($leads_id); //returns html result
$action_history = AdminBPActionHistoryToLeads($leads_id , 'regular');
$admin_action_history = AdminActionHistoryToLeads($leads_id ,'regular');
$bp_action_history = BPActionHistoryToLeads($leads_id , 'regular');








//use in Quick Glance
if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){

	//echo $access_all_leads;

	if($view_leads_setting){
		if($view_leads_setting == 'all'){
			$sql = $db->select()
				->from('leads')
				->where('status =?' , $lead_status)
				->order('fname ASC');
			$leads_list = $db->fetchAll($sql);
		}else{
			$sql = $db->select()
				->from('leads')
				->where('business_partner_id =?' , $view_leads_setting)
				->where('status =?' , $lead_status)
				->order('fname ASC');
			$leads_list = $db->fetchAll($sql);
		}

	}else{
		if($access_all_leads == 'YES'){
			$sql = $db->select()
				->from('leads')
				->where('status =?' , $lead_status)
				->order('fname ASC');
			$leads_list = $db->fetchAll($sql);
		}else{
			$sql = $db->select()
				->from('leads')
				->where('business_partner_id =?' , $_SESSION['agent_no'])
				->where('status =?' , $lead_status)
				->order('fname ASC');
			$leads_list = $db->fetchAll($sql);
		}
	}

}else{
	$sql = $db->select()
		->from('leads')
		->where('status =?' , $lead_status)
		->order('fname ASC');
	//$leads_list = $db->fetchAll($sql);
}
$smarty->assign('leads_list' , $leads_list);
//echo $sql;
//

//checked if the lead is existing in leads_indentical table
//id, leads_id, existing_leads_id
$identical ="";
$queryIdentical = $db->select()
		->from(array('i' => 'leads_indentical') , array('existing_leads_id'))
		->join(array('l' => 'leads') , 'l.id = i.existing_leads_id' , array('fname' , 'lname' , 'email' , 'status'))
		->where('i.leads_id =?' , $leads_id);
//echo $queryIdentical;
$identical_leads = $db->fetchAll($queryIdentical);

if(count($identical_leads) > 0){
	//$identical = count($identical_leads);

	$identical = "<ol>";
	foreach($identical_leads as $identical_lead){
		$identical .="<li>#".$identical_lead['existing_leads_id']." ".$identical_lead['fname']." ".$identical_lead['lname']." ".$identical_lead['email']." [ ".$identical_lead['status']." ] </li>";
	}
	$identical .= "</ol>";


}



//Check the lead if it has atleast 1 ACTIVE staff.
$leads_active_staff_count = 0;
$disable_str = "";
$sql = "SELECT COUNT(id)AS leads_active_staff_count FROM subcontractors s WHERE leads_id=".$leads_id." AND status IN ('ACTIVE', 'suspended') GROUP BY leads_id;";
$leads_active_staff_count = $db->fetchOne($sql);

if($leads_active_staff_count > 0){
	$disable_str = "disabled";
}



$leads_statuses = array('New Leads', 'Follow-Up', 'Keep In-Touch' , 'pending', 'asl', 'custom recruitment');
for($i=0 ; $i<count($leads_statuses);$i++) {
    if($leads_info['status'] != $leads_statuses[$i]){
	    $bttn .= "<input type='button' $disable_str value='move to ".strtolower($leads_statuses[$i])."' onclick=\"ChangeLeadStatus('".$leads_statuses[$i]."')\" /> ";
    }
}

$bttn .= "<br>";
if($_SESSION['admin_id']){
	$bttn .= "<input type='button' value='Activate Member Account / Client Settings' onclick=\"location.href='/portal/accounts_v2/#/accounts/client-setting/?client_id={$leads_id}'\" />";
    $bttn .= "<input type='button' value='Special Arrangement' onclick=\"location.href='/portal/v2/accounts/save-clients-special-arrangement/{$leads_id}'\" />";
}

if($leads_info['status'] != 'Client'){
	if($_SESSION['admin_id']){
		$bttn.="<input type='button' value='move to client' onclick=\"ChangeLeadStatus('Client')\" />";
	}
}

if(in_array($leads_info['status'],$leads_statuses)==true){
	$bttn .= "<input type='button' value='no longer a lead' onclick=\"ChangeLeadStatus('Inactive')\" /> <input type='button' value='delete' onclick=\"ConfirmRemoved()\" />";

}


/*
if(count($identical_leads) > 0){
	$bttn .= "<input type='button' class='lsb2' value='REMOVE' onclick=\"ConfirmRemoved()\" /> <input type='button' class='lsb2' value='DELETE' 	onclick=\"ChangeLeadStatus('REMOVED')\" />";
	//if($created_by_type == "admin"){
		//$bttn.="<input type='button' class='lsb2' value='DELETE THIS IDENTICAL PROFILE' onclick=\"ChangeLeadStatus('duplicate')\" /> ";
		$bttn.="<input type='button' class='lsb2' value='REMOVE IDENTICAL FLAG' onclick=\"ChangeLeadStatus('identical')\" /> ";
	//}

}else{
	$bttn .= "<input type='button' class='lsb2' value='REMOVE TO NO LONGER A LEAD' onclick=\"ChangeLeadStatus('Inactive')\" /> <input type='button' class='lsb2' value='DELETE' onclick=\"ChangeLeadStatus('REMOVED')\" />";

}
*/

//get all admin CSRO
if($leads_info['csro_id']){
    $sql = $db->select()
	    ->from('admin')
	    ->where('admin_id =?' , $leads_info['csro_id']);
    //echo $sql;
    $csro_officer = $db->fetchRow($sql);
//print_r($csro_officer);
}


//get all admin CSRO
if($leads_info['hiring_coordinator_id']){
    $sql = $db->select()
	    ->from('admin')
	    ->where('admin_id =?' , $leads_info['hiring_coordinator_id']);
    //echo $sql;
    $hiring_coordinator = $db->fetchRow($sql);
//print_r($csro_officer);
}


$job_positions="";

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


//LEADS BOOK AN INTERVIEW QUESTIONS
$book_lead_method = 'regular';
include 'FilterBookingQuestions.php';


if(!$page_type){
	$page_type = "TRUE";
}


$data = array(
    'leads_id' => $leads_id,
	'date_change' => $ATZ,
	'changes' => "Viewed Leads Profile",
	'change_by_id' => $created_by_id,
	'change_by_type' => $change_by_type
);
$db->insert('leads_info_history', $data);


$CLIENT_ID = ((int)$leads_id);  //must be an integer
$CLIENT = new couchClient($couch_dsn, 'client_docs');
//client currency settings
$CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
$CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
$CLIENT->descending(True);
$CLIENT->limit(1);
$response = $CLIENT->getView('client', 'settings');
//print_r($response);
$leads_info['apply_gst'] = $response->rows[0]->value[1];
$leads_info['currency'] = $response->rows[0]->value[0];


$data = array('last_viewed_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);


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

//echo "<pre>";
foreach ($registered_in_lookup as $key => $value){
	//echo $key." ".$value."<br>";
	if($leads_info['registered_in'] == $key){
		$leads_info['registered_in_str'] = $value;
		break;
	}
}

if($leads_info['registered_in_section']){
	$leads_info['registered_in_str'] = sprintf('%s section %s', $leads_info['registered_in_str'], $leads_info['registered_in_section']);
}

$API_URL = "//api.remotestaff.com.au";
if(TEST){
	$API_URL = "//test.api.remotestaff.com.au";
}
$retries = 0;
while(true){
	try{

		if (TEST){
			$mongo = new MongoClient(MONGODB_TEST);
		}else{
			$mongo = new MongoClient(MONGODB_SERVER);
		}
		$database = $mongo->selectDB('prod');
		break;
	} catch(Exception $e){
		++$retries;

		if($retries >= 100){
			break;
		}
	}
}
$job_orders = $database->selectCollection('job_orders');
$leads_job_orders = $job_orders->find(array('leads_id'=>intval($leads_id)));


//RECONSTRUCT LEADS JOB ORDERS
try{
	$new_leads_job_orders = array();
	foreach($leads_job_orders as $key=>$leads_job_order){
		$new_leads_job_orders[]=$leads_job_order['tracking_code'];
	}

	//JOB ORDER NOTES
	if (!empty($new_leads_job_orders)){
		$job_order_notes_sql = $db -> select()
								   -> from(array('joc'=>'job_order_comments'), array('id','tracking_code','subject','comment','date_created'))
								   -> joinLeft(array('a'=>'admin'),'joc.admin_id=a.admin_id',array('admin_fname','admin_lname'))
								   -> where('tracking_code IN(?)',$new_leads_job_orders)
								   -> where('deleted=?',0)
								   -> order(array('date_created DESC'));
		$job_order_notes = $db->fetchAll($job_order_notes_sql);
	}

}catch(Exception $e){
	$job_order_notes = array();
}


$smarty->assign("API_URL", $API_URL);
$smarty->assign('leads_active_staff_count', $leads_active_staff_count);
$smarty->assign('book_lead_method',$book_lead_method);
$smarty->assign('admin_status',$admin_status);
$smarty->assign('page_type',$page_type);
$smarty->assign('alternate_emails' , $alternate_emails);
$smarty->assign('job_positions',$job_positions);
$smarty->assign('csro_officer',$csro_officer);
$smarty->assign('hiring_coordinator',$hiring_coordinator);
$smarty->assign('identical' , $identical);
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
//$smarty->assign('stepsTaken' , getStepsTaken2($leads_id));
$smarty->assign('bttn' , $bttn);
$smarty->assign('showLeadsInfoChangesHistory' , showLeadsInfoChangesHistory($leads_id , 'yes' , '0'));
$smarty->assign('lead_status' , $lead_status);
$smarty->assign('AusDate' , format_date($AusDate));
$smarty->assign('leads_Options' , $leads_Options);
$smarty->assign('leads_Options2' , $leads_Options2);
$smarty->assign('leads_Options3' , $leads_Options3);
$smarty->assign('date_registered' , $date_registered);
$smarty->assign('leads_of' , $leads_of);
$smarty->assign('leads_info' , $leads_info);
$smarty->assign('leads_id' , $leads_id);
$smarty->assign('tab1' , "class='selected'");
$smarty->assign('job_order_notes',$job_order_notes);
$smarty->assign('leads_job_orders',$new_leads_job_orders);
$smarty->display('leads_information.tpl');
?>
