<?php



header('Content-Type:text/html; charset=UTF-8');
// CHANGES HISTORY
/*  2012-02-23  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   bugfix display of staff prices
*/


//Before anything else, go to the new profile
//header("Location:../v2/candidate/profile?candidate_id=" . $_GET["userid"]);
//exit;
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//START: construct
include('../conf/zend_smarty_conf.php') ;


global $base_api_url;

global $curl;


if(!method_exists($curl, "get")){
	$curl = new Curl();
}

$to_redirect = $curl->get($base_api_url . '/candidates/get-default-resume-settings-value?settings_for=redirect_to_new_jobseeker_v2');
$to_redirect = json_decode($to_redirect, true);
$will_redirect = $to_redirect["value"];

if(isset($_GET["disable_jobseeker_redirect"])){
	$will_redirect = false;
}

if($will_redirect){

	header('Location: /portal/recruiter_v2/#/jobseeker/profile/' . $_GET["userid"]);

	exit;
}

include_once('../lib/staff_files_manager.php') ;
include('../lib/staff_history.php');
putenv("TZ=Philippines/Manila") ;
include('../config.php') ;
include('../conf.php') ;
include('../function.php') ;
include('../lib/validEmail.php') ;
include('../AgentCurlMailSender.php') ;
require_once "util/HTMLUtil.php";
include('../typingtest/TypingController.php');
include('../skills_test/models/AssessmentResults.php');
include_once('../lib/users_class.php');
include('../time.php') ;
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
//added bypass to allow file uploads from sc.remotestaff.com.au
$userid = $_GET["userid"];
$host = $_GET["host"];
$_REQUEST["page_type"] = "popup";





/*

function sync_candidate_to_v2($candidate_id){
	
	global $base_api_url;
	
	global $curl;
	
	if(!method_exists($curl, "get")){
		$curl = new Curl();
	}
	
	$curl->get($base_api_url . '/solr-index/sync-all-candidates?userid='.$candidate_id);
    if(isset($_GET["only_sync_to_v2"])){
        $curl->get($base_api_url . '/mongo-index/sync-all-candidates?userid='.$candidate_id. "&sync_from_old_data=true");
    } else{
        $curl->get($base_api_url . '/mongo-index/sync-all-candidates?userid='.$candidate_id);
    }

	
	//TRIGGER SYNCER RECRUITER
	$curl->get($base_api_url . '/mongo-index/sync-all-recruiters?recruiter_id='.$_SESSION["admin_id"]);
}


sync_candidate_to_v2($userid);

if(isset($_GET["only_sync_to_v2"])){
	exit;
}

*/

if ($host=="sc.remotestaff.com.au"){
    
    $admin_id = $_GET["admin_id"];
    $_SESSION["admin_id"] = $admin_id;
    $file_manager = new staff_files_manager('../',$userid) ;
    //START: upload other files
    if(isset($_POST["upload_file"])) 
    {
        $tmpName = $_FILES['fileimg']['tmp_name'] ; 
        $other_file = $_FILES['fileimg']['name'] ;      
        $file_description = $_POST["file_description"] ;
        $upload_other_files_result = $file_manager->add_other_files($tmpName, $other_file, $file_description) ;
        
        $db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
                            if(TEST){
                                file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
                            }else{
                                file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
                            }
    
        if($upload_other_files_result == false)
        {
            $transaction_result = "1f" ; //"Error
        }
        else
        {
            
            //START: insert staff history
            $name = basename($other_file);
            staff_history($db, $userid, $admin_id, 'ADMIN', $file_description, 'INSERT', $name);
            //ENDED: insert staff history       
            
            $transaction_result = "1k" ; //"File successfully uploaded."
          
        }
		
		//sync_candidate_to_v2($userid);
        header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);
        exit;
    }
    //ENDED: upload other files
    
    
    //START: upload voice file
    if(isset($_POST['sound_btn']))
    {
        $tmpName = $_FILES['sound_file']['tmp_name']; 
        $sound = $_FILES['sound_file']['name']; 
        $soundsize= $_FILES['sound_file']['size']; 
        $soundtype = $_FILES['sound_file']['type'];
        
        $path = dirname(__FILE__);
        
        $util = new HTMLUtil();
        $upload_voice_result = $util->createVoiceFile($tmpName, $sound, $soundsize, $soundtype, $path."/../", $userid);
        
        //$upload_voice_result = $file_manager->add_voice_file($tmpName, $sound, $soundsize, $soundtype);
    
        if($upload_voice_result == false)
        {
            $transaction_result = "2f" ; //"Error
        }
        else
        {
            
            //START: insert staff history
            $name = basename($sound);
            staff_history($db, $userid, $admin_id, 'ADMIN', 'VOICE', 'INSERT', $name);
            //ENDED: insert staff history   
            
            $transaction_result = "2k" ; //"File successfully uploaded."
        }
		//sync_candidate_to_v2($userid);
        header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);   
        exit;
    }
    //ENDED: upload voice file
    
    
    //START: upload picture
    if(isset($_POST['picture']))
    {
        $tmpName = $_FILES['img']['tmp_name']; 
        $img = $_FILES['img']['name'];
        $imgsize= $_FILES['img']['size'];
        $imgtype = $_FILES['img']['type'];              
        $upload_photo_result = $file_manager->add_photo($tmpName, $img, $imgsize, $imgtype);
        
        if($upload_photo_result == false)
        {
            $transaction_result = "3f" ; //"Error
        }
        else
        {
            
            //START: insert staff history
            $name = basename($img);
            staff_history($db, $userid, $admin_id, 'ADMIN', 'PHOTO', 'INSERT', $name);
            //ENDED: insert staff history   
            
            $transaction_result = "3k" ; //"File successfully uploaded."
        }
		//sync_candidate_to_v2($userid);
        header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);   
        exit;
    }
    //ENDED: upload picture    
}





$userid = $_GET["userid"];
if (isset($_SESSION["status"])){
	$changeByType = $_SESSION["status"];
	
	
	//insert viewing logs data
	if ($changeByType=="FULL-CONTROL"){
		$changeByType = "ADMIN";
	}else{
		$changeByType = "HR";
	}
	$date = date("Y-m-d")." ".date("H:i:s");
	if (isset($_SESSION["admin_id"])){
		$history_changes = "admin viewed applicant's resume";
		
		$resume_viewing_history = $db->fetchRow($db->select()->from("resume_viewing_history")->where("userid = ?", $userid)->where("admin_id = ?", $_SESSION["admin_id"])->where("DATE(date_created) = DATE(?)", $date));
		//var_dump($resume_viewing_history);exit;
		if (!$resume_viewing_history){
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>$date, "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			$db->insert("resume_viewing_history", array("userid"=>$userid, "admin_id"=>$_SESSION["admin_id"], "date_created"=>$date));			
		}

	}else{
		$history_changes = "business developer viewed applicant's resume";
		$changeByType = "AGENT";
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>$date, "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["agent_no"]));
	}
	//sync_candidate_to_v2($userid);
}


//record staffing consultant review activity
if (isset($_REQUEST["tracking_code"])){
	$tracking_code = $_REQUEST["tracking_code"];
	if (isset($_SESSION["admin_id"])&&$tracking_code){
		$admin_id = $_SESSION["admin_id"];
		
		$is_hiring_coordinator = $db->fetchOne($db->select()->from("admin", "hiring_coordinator")->where("admin_id = ?", $admin_id));
		if ($is_hiring_coordinator&&$is_hiring_coordinator=="Y"){
					
			$activity = $db->fetchRow($db->select()->from("mongo_job_orders_sc_review_activities")->where("tracking_code = ?", $tracking_code)->where("userid = ?", $userid));
			if (!$activity){
				$db->insert("mongo_job_orders_sc_review_activities", array("tracking_code"=>$tracking_code, "userid"=>$userid, "hiring_step"=>"REVIEWING_CANDI", "date_created"=>date("Y-m-d H:i:s")));
				require_once dirname(__FILE__)."/../lib/JobOrderManager.php";
				$manager = new JobOrderManager($db);
				$manager->hiringStatus($tracking_code, JobOrderManager::SC_REVIEWING_SHORTLIST);
			}
			
		}
		//sync_candidate_to_v2($userid);
	}
}




TypingController::$dbase = $db;
$test_obj = AssessmentResults::getInstance($db);

$transaction_result = "";
$userid=$_REQUEST['userid'];
$admin_id = $_SESSION['admin_id'];
$transaction_result = $_REQUEST["transaction_result"];
$file_manager = new staff_files_manager('../',$userid) ;
//view history log insert
$smarty = new Smarty;

$staff_voice_file = $file_manager->retrieve_voice_file();





//ENDED: construct

//remove from being blacklisted if resume is accessed check if exact 6 months
if ($userid){
	$inactive_staffs = $db->fetchAll($db->select()->from(array("ina"=>"inactive_staff"), array("userid", "id", new Zend_Db_Expr("DATE_ADD(`date`, INTERVAL 6 MONTH) AS expiration_date")))->where("ina.userid = ?", $userid)->where("type = 'BLACKLISTED'")->having("DATE(expiration_date) < CURDATE()"));
	
	if($inactive_staffs || count($inactive_staffs) > 0)
	{
		foreach($inactive_staffs as $inactive_staff){
			$db->delete("inactive_staff", $db->quoteInto("id = ?", $inactive_staff["id"]));
			include_once "../time.php";	
			$changeByType = "SYSTEM";
			$history_changes = "system removed staff from being <strong style='color:red'>[BLACKLISTED]</strong>";
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			
		
		}
	}
	//sync_candidate_to_v2($userid);
}



//auto expire job applications older than 3 months
$apps = $db->fetchAll($db->select()
				->from(array("a"=>"applicants"), array("a.id", new Zend_Db_Expr("DATE_ADD(`date_apply`, INTERVAL 3 MONTH) AS expiration_date")))
				->joinInner(array("p"=>"posting"), "p.id = a.posting_id", array())
				->where("a.userid = ?", $userid)
				->where("p.status = 'ACTIVE'")
				->where("a.status <>'Sub-Contracted'")
				->where("a.expired = 0")
				->having("DATE(expiration_date) < CURDATE()"));
if (!empty($apps)){
	foreach($apps as $app){
		$db->update("applicants", array("expired"=>1), $db->quoteInto("id = ?", $app["id"]));
	}		
	//sync_candidate_to_v2($userid);
}		



//START: retrieve option tags for price lookup
function get_option_tag($product, $product_id) {
    global $db, $logger;
    //get currency available currency first
    $sql = $db->select()
        ->from(Array('p' => 'product_price_history'), Array('currency_id'))
        ->join(Array('c' => 'currency_lookup'), 'p.currency_id = c.id')
        ->distinct()
        ->where('p.product_id = ?', $product_id)
        ->order(Array('c.code'));

    $label = '';
    foreach($db->fetchAll($sql) as $currency) {
        $currency_code = $currency['code'];
        $currency_id = $currency['id'];
        $sql_amount = $db->select(Array('amount'))
            ->from('product_price_history')
            ->where('product_id = ?', $product_id)
            ->where('currency_id = ?', $currency_id)
            ->order('date DESC')
            ->limit(1);
        $amount = $db->fetchRow($sql_amount);
        $amount = $amount['amount'];
        $label .= sprintf('[%s %s] ', $currency_code, $amount);
    }
    $tag = sprintf("<option value='%s'>%s: %s</option>", $product_id, $product, $label);
    return $tag;
}
//ENDED: retrieve option tags for price lookup

//START: truncate evaluation & communications notes
function truncate_comment($string) 
{
	if(strlen($string) > 50)
	{
		return $string[0].$string[1].$string[2].$string[3].$string[4].$string[5].$string[6].$string[7].$string[8].$string[9].$string[10].$string[11].$string[12].$string[13].$string[14].$string[15].$string[16].$string[17].$string[18].$string[20].$string[21].$string[22].$string[23].$string[24].$string[25].$string[26].$string[27].$string[28].$string[29].$string[30].$string[31].$string[32].$string[33].$string[34].$string[35].$string[36].$string[37].$string[38].$string[39].$string[40].$string[41].$string[42].$string[43].$string[44].$string[45].$string[46].$string[47].$string[48].$string[49].$string[50].'...';
	}
	else
	{
		return $string;
	}
}
//ENDED: truncate evaluation & communications notes


//START: validate users
$bp_session = $_SESSION['agent_no'];
if (isset($_SESSION["logintype"])&&$_SESSION["logintype"]=="business_partner"){
	
	
	
}else{
	if($_SESSION['admin_id']!=""){
		if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE" && $bp_session == ""){
			echo "This page is for HR usage only.";
			exit;	
		}
	}else{
		echo "This page is for HR usage only.";
		exit;	
	}

//ENDED: validate users


//START: upload other files
if(isset($_POST["upload_file"])) 
{
	$tmpName = $_FILES['fileimg']['tmp_name'] ; 
	$other_file = $_FILES['fileimg']['name'] ; 		
	$file_description = $_POST["file_description"] ;
	$upload_other_files_result = $file_manager->add_other_files($tmpName, $other_file, $file_description) ;
    
    $db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
                            if(TEST){
                                file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
                            }else{
                                file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
                            }
    
	if($upload_other_files_result == false)
	{
		$transaction_result = "1f" ; //"Error
	}
	else
	{
		
		//START: insert staff history
		$name = basename($other_file);
		staff_history($db, $userid, $admin_id, 'ADMIN', $file_description, 'INSERT', $name);
		//ENDED: insert staff history		
		
		$transaction_result = "1k" ; //"File successfully uploaded."
	}
    if ($host=="sc.remotestaff.com.au"){
       header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);       
    }else{
        header("location: ?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);        
    }

}
//ENDED: upload other files


//START: upload voice file
if(isset($_POST['sound_btn']))
{
	$tmpName = $_FILES['sound_file']['tmp_name']; 
	$sound = $_FILES['sound_file']['name']; 
	$soundsize= $_FILES['sound_file']['size']; 
	$soundtype = $_FILES['sound_file']['type'];
	
	$path = dirname(__FILE__);
	
	$util = new HTMLUtil();
	$upload_voice_result = $util->createVoiceFile($tmpName, $sound, $soundsize, $soundtype, $path."/../", $userid);
	
	//$upload_voice_result = $file_manager->add_voice_file($tmpName, $sound, $soundsize, $soundtype);

	if($upload_voice_result == false)
	{
		$transaction_result = "2f" ; //"Error
	}
	else
	{
		
		//START: insert staff history
		$name = basename($sound);
		staff_history($db, $userid, $admin_id, 'ADMIN', 'VOICE', 'INSERT', $name);
		//ENDED: insert staff history	
		
		$transaction_result = "2k" ; //"File successfully uploaded."
	}
    if ($host=="sc.remotestaff.com.au"){
        header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);       
    }else{
        header("location: ?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);           
    }

}
//ENDED: upload voice file


//START: upload picture
if(isset($_POST['picture']))
{
	$tmpName = $_FILES['img']['tmp_name']; 
	$img = $_FILES['img']['name'];
	$imgsize= $_FILES['img']['size'];
	$imgtype = $_FILES['img']['type'];				
	$upload_photo_result = $file_manager->add_photo($tmpName, $img, $imgsize, $imgtype);
	
	if($upload_photo_result == false)
	{
		$transaction_result = "3f" ; //"Error
	}
	else
	{
		
		//START: insert staff history
		$name = basename($img);
		staff_history($db, $userid, $admin_id, 'ADMIN', 'PHOTO', 'INSERT', $name);
		//ENDED: insert staff history	
		
		$transaction_result = "3k" ; //"File successfully uploaded."
	}
    if ($host=="sc.remotestaff.com.au"){
        header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);   
    
    }else{
        header("location: ?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);   
        
    }
}
//ENDED: upload picture
}

//START: delete applicants files
if(isset($_REQUEST["file_id"]))
{
	$file_id = $_REQUEST["file_id"];
	$sql=$db->select()
		->from('tb_applicant_files')
		->where('id = ?', $file_id)
		->where('userid = ?', $userid);
	$f = $db->fetchRow($sql);
	$name = $f['name'];
	$file_description = $f['file_description'];
	$file_id = $_REQUEST["file_id"];
	$where = "id = '$file_id' AND userid = '$userid'";	
	$result = $db->delete('tb_applicant_files', $where);
	$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
                            if(TEST){
                                file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
                            }else{
                                file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
                            }
	if($result)
	{
		$name = basename($name);
		unlink("../applicants_files/".$name);

		//START: check deletion result
		$transaction_result = "delete-1k";
		//ENDED: check deletion result
		
		//START: insert staff history
		staff_history($db, $userid, $admin_id, 'ADMIN', $file_description, 'DELETE', $name);
		//ENDED: insert staff history		
	}
	else
	{
		//START: check deletion result
		$transaction_result = "delete-1f";
		//ENDED: check deletion result
	}
	//sync_candidate_to_v2($userid);
}
if($_REQUEST["action"] == "DEL-VOICE-FILE")
{
	$file_manager->delete_voice_file();
	
	//START: check deletion result
	$transaction_result = "delete-1k";
	//ENDED: check deletion result
		
	//START: insert staff history
	staff_history($db, $userid, $admin_id, 'ADMIN', 'VOICE', 'DELETE', '');
	//ENDED: insert staff history		
	//sync_candidate_to_v2($userid);
}
//ENDED: delete applicants files


//START: add applicants contact history
if(isset($_POST['Add']))
{
	$agent_no = $_SESSION['admin_id'];
	$action = $_REQUEST['action'];
	$txt = $_REQUEST['txt'];
	$txt1 = $_REQUEST['txt1'];
	$txt2 = $_REQUEST['txt2'];
	$txt3 = $_REQUEST['txt3'];
	$subject=$_REQUEST['subject'];
	$mode =$_REQUEST['mode'];
	$hid =$_REQUEST['hid'];
	$star=$_REQUEST['star'];
	$templates=$_REQUEST['templates'];
	$emailTemplate = $_REQUEST["emailTemplates"];
	$sent_items = array();
	
		if($mode=="")
		{
			if($action=="EMAIL")
			{
				
				$pers = $db->fetchRow($db->select()->from("personal", array("email", "alt_email", "registered_email"))->where("userid = ?", $userid));
				if ($pers){
					//check if has contract
					$subs = $db->fetchAll($db->select()->from("subcontractors")->where("userid = ?", $userid)->where("status IN ('ACTIVE', 'suspended')"));		
					if (!empty($subs)){
						$email = $pers["email"];
						$alt_email = $pers["alt_email"];
						$staff_email = array();
						foreach($subs as $sub){
							$staff_email[] = $sub["staff_email"];
						}
					}else{
						$email = $pers["email"];
						$alt_email = $pers["alt_email"];
						$staff_email = "";
					}
					
					
				}
				$cc = $_REQUEST["cc"];
				$bcc = $_REQUEST["bcc"];
				$send_to = $_REQUEST["send_to"];
				if($email == "" || $email == " ")
				{
					$transaction_result = "4f" ; //"Email not found
				}	
				else							
				{
					if (validEmailv2($email))
					{						
						$query="SELECT * FROM admin WHERE admin_id='$agent_no';";
						$result=mysqli_query($link2,$query);
						$ctr=@mysqli_num_rows($result);
						if ($ctr >0 )
						{
							$row = mysqli_fetch_array ($result); 
							$name = $row['admin_fname']." ".$row['admin_lname'];
							$agent_email=$row['admin_email'];
							$agent_address =$row['admin_email'];
							$agent_contact =$row['admin_email'];
							$agent_abn =$row['admin_email'];
							$email2 =$row['admin_email'];
							$agent_code=$row['admin_id'];
							$link="<a href='http://www.remotestaff.com.au/$agent_code' target='_blank'>http://www.remotestaff.com.au/$agent_code</a>";
							if($email2!="")
							{
								$agent_email = $email2;
							}
						}
						if($subject=="")
						{
							$subject='Message from RemoteStaff.com c/o  '.$name;
						}
										
						$fullname=$_REQUEST['fullname'];
						$txt=str_replace("\n","<br>",$txt);
						
						
						$subj=$subject;
						$mess=$txt;
						$text = $quote_MESSAGE.$service_agreement_MESSAGE.$setup_fee_MESSAGE.$credit_debit_card_MESSAGE.$job_order_form_MESSAGE;
										
						if ($templates =="signature")
						{
							$message ="<div style='font:12px Tahoma; padding:10px;'>
							<div align='justify' style='padding:15px;margin-top:10px;' >".$mess."</div>
							<div align='justify' style='padding:15px;margin-top:10px;' >".$text."</div>
							</div>";
						}
								
						if($templates=="promotional")
						{
							$message="
							<html>
							<head>
								<title>Remote Staff - Outsourcing Online Staff From The Philippines</title><style>
							</head>
							<body>
								<h1>Template For Applicantions</h1>
							</body>
							</html>";
						}
						
						if ($templates =="plain")
						{
							$message = $mess .$text;
						}	
								   
						$mail = new Zend_Mail("UTF-8");
						//File Attachment
						if (!empty($_FILES)){
							foreach($_FILES as $userfile)
							{
								// store the file information to variables for easier access
								$tmp_name = $userfile['tmp_name'];
								$type = $userfile['type'];
								$name = $userfile['name'];
								$size = $userfile['size'];
								// if the upload succeded, the file will exist
								
								if (file_exists($tmp_name))
								{
									// check to make sure that it is an uploaded file and not a system file
									if(is_uploaded_file($tmp_name))
									{
										
										
										
										
										// open the file for a binary read
										$file = fopen($tmp_name,'rb');
										// read the file content into a variable
										$data = fread($file,filesize($tmp_name));
										// close the file
										fclose($file);
										
										$at = new Zend_Mime_Part($data);
										$at->type        = $type;
										$at->disposition = Zend_Mime::DISPOSITION_INLINE;
										$at->encoding    = Zend_Mime::ENCODING_BASE64;
										$at->filename    = $name;
										
										$mail->addAttachment($at);
										
										
									}
								
								}
							}
						}
															   
						//START: signature						   
						$admin_status=$_SESSION['status'];
						$site = $_SERVER['HTTP_HOST'];
													
						$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
						$result=mysqli_query($link2,$sql);
						$ctr=@mysqli_num_rows($result);
						if ($ctr >0 )
						{
							$row = mysqli_fetch_array ($result); 
							$admin_email = $row['admin_email'];
							$name = $row['admin_fname']." ".$row['admin_lname'];
							$admin_email=$row['admin_email'];
							$signature_company = $row['signature_company'];
							$signature_notes = $row['signature_notes'];
							$signature_contact_nos = $row['signature_contact_nos'];
							$signature_websites = $row['signature_websites'];
						}

						if($signature_notes!="")
						{
							$signature_notes = "<p><i>$signature_notes</i></p>";
						}
						else
						{
							$signature_notes = "";
						}
						if($signature_company!="")
						{
							$signature_company="<br>$signature_company";
						}
						else
						{
							$signature_company="<br>RemoteStaff";
						}
						if($signature_contact_nos!="")
						{
							$signature_contact_nos = "<br>$signature_contact_nos";
						}
						else
						{
							$signature_contact_nos = "";
						}
						if($signature_websites!="")
						{
							$signature_websites = "<br>Websites : $signature_websites";
						}
						else
						{
							$signature_websites = "";
						}
													
						$signature_template = $signature_notes;
						$signature_template .="<a href='http://$site/$agent_code'>
						<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
						$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
						$message .= $signature_template;						   
						//ENDED: signature						   					   
						$validate = new Zend_Validate_EmailAddress();
						if (!empty($send_to)){
							$sent_items = array();		
								
							
							foreach($send_to as $key=>$item){
								if ($key==0){
									if ($item=="primary"){
										$to = $email;
										$sent_items[] = $to;
									}else if ($item=="alternative"){
										$to = $alt_email;
										$sent_items[] = $to;
									}else{
										$to = $staff_email;
										if (is_array($to)&&!empty($to)){
											foreach($to as $to_email){
												$sent_items[] = $to_email;
											}
										}else{
											if (is_string($to)&&trim($to)!=""){
												$sent_items[] = $to;
											}
										}
									}
									
								}else{
									if (TEST){
										
										if ($item=="primary"){
											if ($validate->isValid($email)){
												$sent_items[] = $email;
											}
										}else if ($item=="alternative"){
											if ($validate->isValid($alt_email)){
												$sent_items[] = $alt_email;
											}
										}else{
											if (is_array($staff_email)&&!empty($staff_email)){
												foreach($staff_email as $se){
													if ($validate->isValid($se)){
														$sent_items[] = $se;
													}	
												}
												
											}else{
												if (is_string($staff_email)&&$staff_email!=""){
													if ($validate->isValid($staff_email)){
														$sent_items[] = $staff_email;
													}	
												}
											}
											
										}
										$mail->addCc("devs@remotestaff.com.au", "devs@remotestaff.com.au");
									}else{
										if ($item=="primary"){
											if ($validate->isValid($email)){
												$mail->addCc($email);
												$sent_items[] = $email;
											}
										}else if ($item=="alternative"){
											if ($validate->isValid($alt_email)){
												$mail->addCc($alt_email);
												$sent_items[] = $alt_email;
											}
										}else{
											if (is_array($staff_email)&&!empty($staff_email)){
												foreach($staff_email as $se){
													if ($validate->isValid($se)){
														$mail->addCc($se);
														$sent_items[] = $se;
													}	
												}
												
											}else{
												if (is_string($staff_email)&&$staff_email!=""){
													if ($validate->isValid($staff_email)){
														$mail->addCc($staff_email);
														$sent_items[] = $staff_email;
													}	
												}
											}
										}
									}
								}
							}
						}else{
							$defaultEmail = $db->fetchRow($db->select()->from("personal", array("email"))->where("userid = ?", $userid));
							$to = $defaultEmail["email"];
						}
						
						if (TEST) 
						{
							$to = 'devs@remotestaff.com.au';
						}
						
						if ($validate->isValid($to)){
							$mail->setFrom($agent_email);
							$mail->addHeader("Reply-To", $agent_email);
							//$mail->addHeader($agent_email);
							
							if (TEST){
								$message.="<br/>The message was sent to ".implode(",", $sent_items);
							}
							
							if ($emailTemplate=="Take a Skills Test"||$emailTemplate=="Merry Christmas Contractors"||$emailTemplate=="New Pay Run Cycle"){
								$mail->setBodyHtml($_REQUEST["txt"]);
							}else{
								$mail->setBodyHtml($message);
							}
							
							
							if(!TEST){
								$mail->addTo($to);
								if($cc != "" || $cc != NULL){
									$ccs = explode(",", $cc);
									if (count($ccs)==1){
										$cc = trim($cc);
										if (validEmailv2($cc)){
											$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header	
										}
									}else{
										foreach($ccs as $cc){
											$cc = trim($cc);
											if (validEmailv2($cc)){
												$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header	
											}
										}
									}
								}
								if($bcc != "" || $bcc != NULL){
									$ccs = explode(",", $bcc);
									if (count($ccs)==1){
										$cc = trim($ccs[0]);
										if (validEmailv2($cc)){
											$mail->addBcc($cc);// Adds a recipient to the mail with a "Cc" header
										}
									}else{
										foreach($ccs as $cc){
											$cc = trim($cc);
											if (validEmailv2($cc)){
												$mail->addBcc($cc);// Adds a recipient to the mail with a "Cc" header
											}
										}
									}
								}
							}else{
								$to = "devs@remotestaff.com.au";
								$cc = "devs@remotestaff.com.au, marlon@remotestaff.com.ph";
								$bcc = "devs@remotestaff.com.au, remote.allanaire@gmail.com";
								
								$mail->addTo($to);
								
								if($cc != "" || $cc != NULL){
									$ccs = explode(",", $cc);
									if (count($ccs)==1){
										$cc = trim($cc);
										$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header
									}else{
										foreach($ccs as $cc){
											$cc = trim($cc);
											$mail->addCc($cc, $cc);// Adds a recipient to the mail with a "Cc" header
										}
									}
								}
								if($bcc != "" || $bcc != NULL){
									$ccs = explode(",", $bcc);
									if (count($ccs)==1){
										$cc = trim($ccs[0]);
										$mail->addBcc($cc);// Adds a recipient to the mail with a "Cc" header
									}else{
										foreach($ccs as $cc){
											$cc = trim($cc);
											$mail->addBcc($cc);// Adds a recipient to the mail with a "Cc" header
										}
									}
								}
							}
							
							$mail->setSubject($subject);
							$mail->send($transport);
							$mail_result = true;
						}else{
							$mail_result = false;
							
						}
						
						
						
						if($mail_result)
						{
							$datetime = date("Y-m-d")." ".date("H:i:s");
							$txt = $_REQUEST["txt"];
							if ($emailTemplate=="Take a Skills Test"||$emailTemplate=="Merry Christmas Contractors"||$emailTemplate=="New Pay Run Cycle"){
								$txt = nl2br(trim(strip_tags($txt)));
							}else{
								$txt=filterfield($_REQUEST["txt"]);
							}
								
							$history = array(
								'admin_id'=>$admin_id,
								'userid'=>$userid,
								'actions'=>"EMAIL",
								'history'=>$txt,
								'date_created'=>$datetime,
								'subject'=>$subject
							);
							
							try{
								$db->insert("applicant_history", $history);
								//start: insert staff history
								staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'COMMUNICATIONS', 'INSERT', $action);
								//ended: insert staff history							
								$transaction_result = "4k" ; //Email has been sent & Saved.
								
							}catch(Exception $e){
								$transaction_result = "4fff" ; //MySQL Error
							}
							
						}
						else
						{
							$transaction_result = "4f"; //Email not sent
						}
					}
					else
					{
						$transaction_result = "4f" ; //"Invalid Email Address.
					}	
				}
			}
			else
			{
				$datetime = date("Y-m-d")." ".date("H:i:s");
				$txt = $_POST["txt"];
				$txt=nl2br($txt);
				$data = array (
					'admin_id' => $admin_id, 
					'userid' => $userid, 
					'actions' => $action,
					'history' => $txt,
					'date_created' => $datetime,
					'subject' => ''
				);	
				$db->insert('applicant_history', $data);
				$applicant_history_id = $db->lastInsertId();
				
				if($action == "CSR")
				{
					
					$data = array (
						'applicant_history_id' => $applicant_history_id, 
						'note1' => $txt1, 
						'note2' => $txt2,
						'note3' => $txt3,
						'date_change' => $datetime
					);	
					$db->insert('applicant_history_CSR', $data);					
				}
				
				$result=mysqli_query($link2,$query);
				
				if ($applicant_history_id <> "")
				{
					//start: insert staff history
					staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'COMMUNICATIONS', 'INSERT', $action);
					//ended: insert staff history
					$transaction_result = "5k" ; //Saved.
					
					//update personal
					$AusTime = date("h:i:s"); 
					$AusDate = date("Y")."-".date("m")."-".date("d");
					$ATZ = $AusDate." ".$AusTime;
					$date = $ATZ;
					mysqli_query($link2,"UPDATE personal SET dateupdated = '".$date."' WHERE userid = ".$userid);
				}
				else
				{
					$transaction_result = "5f" ; //MySQL Error
				}
			}
			//sync_candidate_to_v2($userid);
		}

		if($mode=="update")
		{	
			$txt=filterfield($txt);
			$query="UPDATE applicant_history SET history ='$txt' WHERE id=$hid;";
			$result=mysqli_query($link2,$query);
			
			if (!$result)
			{
				$transaction_result = "5f" ; //MySQL Error
			}
			else
			{
				$transaction_result = "5k" ; //Saved.
			}
			//sync_candidate_to_v2($userid);
		}
		
		    if ($host=="sc.remotestaff.com.au"){
                header("location: http://{$host}/portal/recruiter/staff_information.php?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);   
            
            }else{
                header("location: ?userid=".$userid."&page_type=".$_REQUEST["page_type"]."&transaction_result=".$transaction_result);   
                
            }

}
//ENDED: add applicants contact history


//START: applicant history
$admin_id = $_SESSION['admin_id'];
if (isset($_SESSION["admin_id"])){
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
}

$_SESSION["available_staff_checker_userid"] = $userid;
$action = $_REQUEST['action'];
$agent_no = $_SESSION['admin_id'];
$leads_id=$_REQUEST['userid'];
$hid =$_REQUEST['hid'];
$hmode =$_REQUEST['hmode'];
$mode =$_REQUEST['mode'];
$code=$_REQUEST['code'];

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($hmode!="" && $hmode=='delete')
{
	$query="DELETE FROM applicant_history WHERE id=$hid;";
	mysqli_query($link2,$query);
	sync_candidate_to_v2($userid);
}

$sql ="SELECT * FROM applicant_history WHERE id = $hid;";
$res=mysqli_query($link2,$sql);
$ctr=@mysqli_num_rows($res);
if ($ctr >0)
{
	$row = mysqli_fetch_array($res);
	$desc=$row['history'];
}
//ENDED: applicant history



//START: get additional information
$q="SELECT * FROM tb_additional_information WHERE userid=$userid";
$r=mysqli_query($link2,$q);
$ctr=@mysqli_num_rows($r);
if ($ctr >0 )
{
	$row = mysqli_fetch_array ($r); 
	//print_r($row);
	$job_category = $row['job_category'];
	$sub_job_category = $row['sub_job_category'];
	$availability = $row['availability'];
	$expected_salary = $row['expected_salary'];
	$salary_from_previous_job = $row['salary_from_previous_job'];
	$lowest_non_negostiable_salary = $row['lowest_non_negostiable_salary'];
	$notes = $row['notes'];
	$rating = $row['rating'];

}
//ENDED: get additional information


//START: get inactive current status
$q="SELECT type FROM inactive_staff WHERE userid='$userid' LIMIT 1";
$r=mysqli_query($link2,$q);
$r = mysqli_fetch_array ($r); 
$inactive_current_status = $r["type"];
//ENDED: get inactive current status


//START: get staff information

$sql = $db->select()->from(array("p"=>"personal"), array("voice_path"))->where("p.userid = ?", $userid);
$staff = $db->fetchRow($sql);

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$voice_file_type = finfo_file($finfo, getcwd()."/../".$staff["voice_path"]);
$voice_parts = pathinfo($staff["voice_path"]);

if (strtolower($voice_parts["extension"])=="wma"||strtolower($voice_parts["extension"])=="wav"){
	$util = new HTMLUtil();
	$check = $util->convert_to_mp3($userid, "");
	if ($check=="Ok"){
	?>
	<script type="text/javascript">
		window.location.reload();
	</script>
	<?php
	} 
		
}else if (strtolower($voice_parts["extension"])=="flv"||$voice_file_type=="video/3gpp"){
	$exists = true;
	if (strtolower($voice_parts["extension"])=="flv"){
		$file_headers = @get_headers($staff["voice_path"]);
		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
		    $exists = false;
		}
		else {
		    $exists = true;
		}	
							
	}	

	if ($exists){
		$exchange = '/';
		$queue = 'mp3_conversion';
		$consumer_tag = 'consumer';
		
		
		$conn = new AMQPConnection(MP3_AMQP_HOST, MP3_AMQP_PORT,MP3_AMQP_USERNAME, MP3_AMQP_PASSWORD, MP3_AMQP_VHOST);
		$ch = $conn->channel();
		$ch->queue_declare($queue, false, true, false, false);
		$ch->exchange_declare($exchange, 'direct', false, true, false);
		$ch->queue_bind($queue, $exchange);
		
		$msg_body =json_encode(array("published_by"=>"/portal/recruiter/staff_information.php", "userid"=>$userid, "scale"=>1));
		
		$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
		$ch->basic_publish($msg, $exchange);
		$ch->close();
		$conn->close();
	}
	
}

$query="SELECT p.*, utd.date as update_date FROM personal p  left join staff_resume_up_to_date as utd on p.userid=utd.userid WHERE p.userid=$userid ";
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysqli_query($link2,$query2);

$result=mysqli_query($link2,$query);
$ctr=@mysqli_num_rows($result);
if ($ctr >0 )
{
	$row = mysqli_fetch_array ($result); 
	$row2 = mysqli_fetch_array ($result2); 
	$latest_job_title=$row2['latest_job_title'];
	$image= $row['image'];

	$voice_path = $row['voice_path'];
	$staff_name = $row['fname']." ".$row['middle_name']." ".$row['lname'];
	
	$contracts = $db->fetchAll($db->select()->from(array("s"=>"subcontractors"), array("status"))->where("s.userid = ?", $userid));
	$staff_status = getStaffStatus($userid);
	$hasActive = "";
	if($staff_status == "Inactive"){
	$hasActive = "INACTIVE"	;
	}
	foreach($contracts as $contract){
		if ($contract["status"]=="ACTIVE"){
			$hasActive= "ACTIVE";
			break;
		}
	}
	
	$staff_nickname = $row['nick_name'];
	$marital_status = $row['marital_status'];	
	$no_of_kids = $row['no_of_kids'];
	$pregnant = $row['pregnant'];
	$dmonth = $row['dmonth'];
	$dday = $row['dday'];
	$dyear = $row['dyear'];
	$pending_visa_application = $row['pending_visa_application'];
	$active_visa = $row['active_visa']; 
	$pregnant_array= array("Yes","No","No! I'm a Male Applicant","No, but I wish I was");
	if (is_numeric($pregnant)){
		for($i=0; $i<count($pregnant_array);$i++){
			if($pregnant == $i){
				$pregnant = $pregnant_array[$i];
				break;
			}
		}
	}
	switch($dmonth)
	{
		case 1:
			$dmonth= "Jan";
			break;
		case 2:
			$dmonth= "Feb";
			break;
		case 3:
			$dmonth= "Mar";
			break;
		case 4:
			$dmonth= "Apr";
			break;
		case 5:
			$dmonth= "May";
			break;
		case 6:
			$dmonth= "Jun";
			break;
		case 7:
			$dmonth= "Jul";
			break;
		case 8:
			$dmonth= "Aug";
			break;
		case 9:
			$dmonth= "Sep";
			break;
		case 10:
			$dmonth= "Oct";
			break;
		case 11:
			$dmonth= "Nov";
			break;
		case 12:
			$dmonth= "Dec";
			break;
		default:
			break;
	}
	

	if($row['datecreated'] <> "" && $row['datecreated'] <> "0000-00-00") { $dateapplied = new Zend_Date($row['datecreated'], 'YYYY-MM-dd HH:mm:ss'); }
	if($row['dateupdated'] <> "" && $row['dateupdated'] <> "0000-00-00") { $dateupdated = new Zend_Date($row['dateupdated'], 'YYYY-MM-dd HH:mm:ss'); }
	$address=$row['address1']." ".$row['city']." ".$row['postcode']." <br>".$row['state']." ".$row['country_id'];
	$address2 = $row["address2"];
	$tel=$row['tel_area_code']." - ".$row['tel_no'];
	$cell =$row['handphone_country_code']."+".$row['handphone_no'];
	
	if($row['registered_email'] <> "") { $email = $row['email']; } else { $email = ''; }
	$registered_email = $row['registered_email']; if($registered_email == "") { $registered_email = $row['email']; }
	$registered_email = str_replace(" ","",$registered_email);
	$alt_email = str_replace(" ","",$alt_email);
	$email = str_replace(" ","",$email);
	$alt_email = $row['alt_email'];
	
	$country_id = $row['country_id'];
	$skype_id = $row['skype_id'];
	
	$msn_id = $row['msn_id'];
	$yahoo_id = $row['yahoo_id'];
	$icq_id = $row['icq_id'];
	$linked_in = $row["linked_in"];
	$promotional_code = $row["promotional_code"];
	$byear = $row['byear'];
	$bmonth = $row['bmonth'];
	$bday = $row['bday'];
	$gender = $row['gender'];
	$nationality = $row['nationality'];
	$auth_no_type_id = $row['auth_no_type_id'];
	$msia_new_ic_no = $row['msia_new_ic_no'];
	$english_communication_skill = $row["english_communication_skill"];
	$residence =$row['permanent_residence'];
	
	$initial_email_password = $row['initial_email_password'];
	$initial_skype_password = $row['initial_skype_password'];

	$home_working_environment = $row['home_working_environment'];
	$internet_connection = $row['internet_connection'];
	$isp = $row['isp'];
	$computer_hardware=$row['computer_hardware'];
	$headset_quality=$row['headset_quality'];
	
	
	
	$work_from_home_before = $row['work_from_home_before']; 
	$start_worked_from_home = $row['start_worked_from_home']; 
	$has_baby = $row['has_baby']; 
	$main_caregiver = $row['main_caregiver']; 
	$reason_to_wfh = $row['reason_to_wfh']; 
	$timespan = $row['timespan']; 
	$internet_connection_others = $row['internet_connection_others']; 
	$speed_test = $row['speed_test']; 
	$internet_consequences = $row['internet_consequences']; 
	$noise_level = $row['noise_level']; 
	
	$external_source = $row['external_source']; 
	$referred_by = $row['referred_by']; 
	
	//check referral
	$referral = $db->fetchRow($db->select()->from(array("r"=>"referrals"), array())->joinInner(array("p"=>"personal"), "p.userid = r.user_id", array("p.fname AS referee_fname", "p.lname AS referee_lname", "p.userid AS referee_userid"))->where("r.jobseeker_id = ?", $row["userid"]));
	
	if ($referral){
		$link = "/portal/recruiter/staff_information.php?userid=".$referral["referee_userid"];
		$referred_by = "<a href='$link' target='_blank'>".$referral["referee_fname"]." ".$referral["referee_lname"]."</a>";
	}

	if($isp == 'Others'){
		$isp = $internet_connection_others;
	}
	
	$computer_hardware2 .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$computer_hardware2 .= str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$computer_hardware);
	if (is_null($work_from_home_before)){
		$work_from_home_before = "";
	}else{
		if($work_from_home_before == 0){
			$work_from_home_before = 'No';
		}
		else{
			$work_from_home_before = 'Yes';
		}
	}
	//echo $has_baby;exit;
	if (is_null($has_baby)){
		$has_baby = "";	
	}else{
		if($has_baby == 0){
			$has_baby = 'No';
		} else{
			$has_baby = 'Yes';
		}
	}
	
	$yr = date("Y");
	switch($bmonth)
	{
		case 1:
			$bmonth= "Jan";
			break;
		case 2:
			$bmonth= "Feb";
			break;
		case 3:
			$bmonth= "Mar";
			break;
		case 4:
			$bmonth= "Apr";
			break;
		case 5:
			$bmonth= "May";
			break;
		case 6:
			$bmonth= "Jun";
			break;
		case 7:
			$bmonth= "Jul";
			break;
		case 8:
			$bmonth= "Aug";
			break;
		case 9:
			$bmonth= "Sep";
			break;
		case 10:
			$bmonth= "Oct";
			break;
		case 11:
			$bmonth= "Nov";
			break;
		case 12:
			$month= "Dec";
			break;
		default:
			break;
	}
}
//ENDED: get staff information

//START: get hot staff
$data=mysqli_query($link2,"SELECT id FROM hot_staff WHERE userid='$userid' LIMIT 1");
$ctr=@mysqli_num_rows($data);
$hot = '';
if ($ctr > 0)
{
	$hot = '<img src="../images/hot.gif">';
}
//ENDED: get hot staff


//START: get experienced staff
$data=mysqli_query($link2,"SELECT id FROM experienced_staff WHERE userid='$userid' LIMIT 1");
$ctr=@mysqli_num_rows($data);
$experienced = '';
if ($ctr > 0)
{
	$experienced = '<font color="#FF0000" size="3"><strong>Experienced!</strong></font>';
}
//ENDED: get experienced staff


//START: star rating
$star_rating_report = "";
if($rating == "")
{
$star_rating_report = $star_rating_report."
<option value='' selected></option>";
}
else
{
$star_rating_report = $star_rating_report."
<option value='".$rating."' selected>".$rating."</option>";
}
$star_rating_report = $star_rating_report."
<option value='0'>0</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
";
//ENDED: star rating


//START: staff recruiter stamp
$q ="SELECT a.admin_id, a.admin_fname, a.admin_lname FROM recruiter_staff INNER JOIN admin AS a ON a.admin_id = recruiter_staff.admin_id WHERE recruiter_staff.userid='$userid'";
$result = $db->fetchAll($q);
$staff_admin_fullname = "";
foreach($result as $r)
{
	$staff_admin_id = $r['admin_id'];
	$staff_admin_fullname = $r["admin_fname"]." ".$r["admin_lname"];
}
$staff_recruiter_stamp = "";
$q ="SELECT admin_id, admin_fname, admin_lname 
		FROM admin 
		WHERE status='HR'   AND admin_id <> 161  
		order by admin_fname";
		
$result = $db->fetchAll($q);
foreach($result as $r)
{
	//start: don't show admin 
	if($r['admin_id'] == '56' || $r['admin_id'] == '59')		
	{
		//do nothing
	}
	else
	{
		if($staff_admin_id == $r['admin_id'])
		{
			$is_executed_temp = "yes";		
			$staff_recruiter_stamp = $staff_recruiter_stamp."<option value='".$r['admin_id']."' selected>".$r['admin_fname']."&nbsp;".$r['admin_lname']."</option>";
		}
		else
		{
			$staff_recruiter_stamp = $staff_recruiter_stamp."<option value='".$r['admin_id']."'>".$r['admin_fname']."&nbsp;".$r['admin_lname']."</option>";
		}
	}
	//ended: don't show admin 
}
if($is_executed_temp == "")
{
	$staff_recruiter_stamp = $staff_recruiter_stamp."<option value='' selected></option>";
}
//ENDED: staff recruiter stamp


//START: applicant status
$applicant_status = "<option value=''></option>";
$applicant_status_report_counter = 0;
$sql1 = $db->select()->from(array("s"=>"subcontractors"),
												 array(new Zend_Db_Expr("CONCAT('HIRED') AS status"),
												 		 "date_contracted AS date",
												 		  "s.id AS link_id",
														  "CONCAT('') AS admin_fname",
														  "CONCAT('') AS admin_lname"))
										->where("s.userid = ?", $userid);
$q ="SELECT ap.status, ap.date, ap.link_id, a.admin_fname, a.admin_lname FROM applicant_status ap, admin a WHERE a.admin_id = ap.admin_id AND ap.personal_id = '$userid'";
$sql = $db->select()->union(array($sql1, $q))->order("date DESC");
$applicant_statuses = $db->fetchAll($sql);


if (!empty($applicant_statuses)){
	foreach($applicant_statuses as $applicant_status){
		if ($applicant_status["status"]=="ENDORSED"&&!is_null($applicant_status["link_id"])){
			$endorsement = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array("id"))->where("id = ?", $applicant_status["link_id"]));
			if ($endorsement){
				$applicant_status_report_counter++;
			}
		}else if ($applicant_status["status"]=="SHORTLISTED"&&!is_null($applicant_status["link_id"])){
			$shortlist = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("id"))->where("id = ?", $applicant_status["link_id"]));	
			if ($shortlist){
				$applicant_status_report_counter++;
			}
		}else{
			$applicant_status_report_counter++;	
		}		
	}	
}
$applicant_status = "";
/*
$asl = mysqli_query($link2,"SELECT id FROM applicant_status WHERE personal_id = '$userid'");
$ctr=mysqli_num_rows($asl);

if ($ctr >0 )
{
	$applicant_status_report_counter = $ctr;
}
 * 
 */
if (isset($_SESSION["admin_id"])){
	$q ="SELECT ap.status, ap.date, a.admin_fname, a.admin_lname FROM applicant_status ap, admin a WHERE a.admin_id = ap.admin_id AND ap.personal_id = '$userid' AND a.admin_id=".$_SESSION['admin_id']." LIMIT 1;";
}else{
	$q ="SELECT ap.status, ap.date, a.admin_fname, a.admin_lname FROM applicant_status ap, admin a WHERE a.admin_id = ap.admin_id AND ap.personal_id = '$userid' LIMIT 1;";	
}

$result = $db->fetchAll($q);


foreach($result as $r)
{
	$applicant_status = "<option value='".$r['status']."' selected>".$r['status']."&nbsp;".$r['admin_fname']." ".$r['admin_lname']."-".$r['date']."</option>";
}
$applicant_status = $applicant_status."
<option value='UNPROCESSED'>UNPROCESSED</option>
<option value='PRESCREENED'>PRESCREENED</option>
<option value='SHORTLISTED'>SHORTLISTED</option>
<option value='ASL'>ASL</option>
<option value='ENDORSED'>ENDORSED</option>
<option value='TEST STAFF'>TEST STAFF</option>
<option value='HIRED SUB CON'>HIRED SUB CON</option>
<option value='RESIGNED OR CONTRACT END'>RESIGNED OR CONTRACT END</option>
<option value='EXPERIENCED ASL'>EXPERIENCED ASL</option>
";
//ENDED: applicant status


//START: applicant no show counter
$applicant_no_show_counter = 0;
$asl = mysqli_query($link2,"SELECT id FROM staff_no_show WHERE userid = '$userid'");
$ctr=mysqli_num_rows($asl);
if ($ctr >0 )
{
	$applicant_no_show_counter = $ctr;
}
//ENDED: applicant no show counter


//START: applicant no show counter
$staff_samples_counter = 0;
$asl = mysqli_query($link2,"SELECT id FROM staff_samples_email_sent WHERE userid = '$userid'");
$ctr=mysqli_num_rows($asl);
if ($ctr >0 )
{
	$staff_samples_counter = $ctr;
}
//ENDED: applicant no show counter


//START: staff resume up to date
$staff_resume_up_to_date_counter = 0;
$asl = mysqli_query($link2,"SELECT id FROM staff_resume_up_to_date WHERE userid = '$userid'");
$ctr=mysqli_num_rows($asl);
if ($ctr >0 )
{
	$staff_resume_up_to_date_counter = $ctr;
}
//ENDED: staff resume up to date

//START: asl interview counter
$asl_interview_counter = 0;
$asl = mysqli_query($link2,"SELECT id FROM tb_request_for_interview WHERE applicant_id='$userid'");
$ctr=mysqli_num_rows($asl);
if ($ctr >0 )
{
	$asl_interview_counter = $ctr;
}
//ENDED: asl interview counter


//START: staff files counter
$staff_files_counter = 0;
$sf = mysqli_query($link2,"SELECT id FROM tb_applicant_files WHERE (file_description = 'RESUME' OR file_description = 'SAMPLE WORK' OR file_description = 'MOCK CALLS' OR file_description = 'OTHER' OR file_description = 'HOME OFFICE PHOTO') AND userid='$userid'");
$ctr=mysqli_num_rows($sf);
if ($ctr >0 )
{
	$staff_files_counter = $ctr;
}

$csro_staff_files_counter = 0;
$sf = mysqli_query($link2,"SELECT id FROM tb_applicant_files WHERE file_description NOT IN ('RESUME', 'SAMPLE WORK', 'MOCK CALLS', 'OTHER', 'HOME OFFICE PHOTO') AND userid='$userid'");
$ctr=mysqli_num_rows($sf);
if ($ctr >0 )
{
	$csro_staff_files_counter = $ctr;
}
//ENDED: staff files counter


//START: availability
$q_availability = mysqli_query($link2,"SELECT id,DATE_FORMAT(evaluation_date,'%D %b %Y'), work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary FROM evaluation WHERE userid = '$userid' LIMIT 1");
list($evaluation_id,$evaluation_date, $work_fulltime, $fulltime_sched, $work_parttime, $parttime_sched, $work_freelancer, $expected_minimum_salary)=mysqli_fetch_array($q_availability);
$availability = "";
if($work_fulltime == "yes")
{
	$availability = "Full Time";
}
if($work_parttime == "yes")
{
	if(availability != "")
	{
		$availability = $availability."/Part Time";
	}
	else
	{
		$availability = "Part Time";
	}	
}
if ($work_freelancer == "yes")
{
	if($availability != "")
	{
		$availability = $availability."/Freelancer";
	}
	else
	{
		$availability = "Freelancer";
	}
}

$t =  mysqli_query($link2,"SELECT time_zone FROM staff_timezone WHERE userid='$u_id' LIMIT 1");
while ($t = mysqli_fetch_assoc($t)) 
{
	$pos = strpos($t["time_zone"], 'ANY');
	if ($pos === false)
	{
		$availability = $availability." (".$t["time_zone"].")" ;
	}
	else
	{
		$availability = $availability." (AU,UK,US)" ;
	}
}
//ENDED: availability



//START: validate transaction result
if($transaction_result <> "")
{
	switch($transaction_result)
	{
		case "1f":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "Uploading File Error!";
			break;
		case "1k";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "File Uploaded Sucessfully.";
			break;
		case "delete-1f";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "Failed to Delete File.";
			break;			
		case "delete-1k";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "File Deleted Sucessfully.";
			break;			
			
		case "2f":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "Uploading Voice File Error!";
			break;
		case "2k";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "Voice File Uploaded Sucessfully.";
			break;
			
		case "3f":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "Uploading Image File Error!";
			break;
		case "3k";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "Image File Uploaded Sucessfully.";
			break;			
			
		case "4f":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "Invalid Email Address!";
			break;
		case "4ff":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "There was a problem sending this mail !";
		case "4fff":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "MySQL Error! Email has been sent but not saved on the communication history.";			
			break;
		case "4k";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "Email has been sent and saved.";
			break;	

		case "5f":
			$return_image = "<img src='../images/transaction_failed.png' width=40>";
			$return_message = "MySQL Error!";
			break;
		case "5k";
			$return_image = "<img src='../images/transaction_okay.png' width=40>";
			$return_message = "Saved.";
			break;	
			
		default:
			break;
	}
	
	$transaction_result = '
		<table width="100%" bgcolor="#FF0000" cellpadding="1" cellspacing="1"><tr><td>
			<table bgcolor=#FFFFFF width="100%" cellpadding="3" cellspacing="3">
				<tr>
					<td>'.$return_image.'</td>
					<td width=100%><font size=3><strong>'.$return_message.'</strong></font></td>
					<td valign=top><strong><a href="javascript: clear_transaction_result(); "><img src="../images/action_delete.gif" border=0></a></strong></td>
				</tr>
			</table>
		</td></tr></table>
	';
}
//ENDED: validate transaction result


//START: evaluation report

$util = new HTMLUtil();
$evaulation_report_tab .= '
<table width=100% cellpadding=3 cellspacing="0" border=0 id="evaluation_report_list_tab">
	<thead>
	<tr>
		<td colspan=5><div class="hiresteps" id ="evaluation_notes_target"><table width="100%"><tr><td><font color="#003366"><strong>Evaluation Notes</strong></font></td><td align="right"><a href="javascript: load_evaulation('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="20%">Recruiter</td>
		<td class="td_info td_la" width="70%">Comments</td>
		<td class="td_info td_la" width="10%">Date</td>
		<td class="td_info td_la" width="0"></td>
	</tr></thead><tbody>';	
	
	
$evaulation_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0 id="evaluation_report_list">
	<thead>
	<tr>
		<td colspan=5><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Evaluation Notes</strong></font></td><td align="right"><a href="javascript: load_evaulation('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="20%">Recruiter</td>
		<td class="td_info td_la" width="70%">Comments</td>
		<td class="td_info td_la" width="10%">Date</td>
		<td class="td_info td_la" width="0"></td>
	</tr></thead><tbody>';

	$sql = $db->select()
			  ->from('evaluation_comments')
			  ->where('userid = ?', $userid)
			  ->order("ordering");
	$result = $db->fetchAll($sql);

	foreach($result as $row3)
	{
		$a = $db->fetchRow("SELECT admin_fname, admin_lname FROM admin WHERE admin_id='".$row3["comment_by"]."' LIMIT 1");
		$name = $a["admin_fname"]." ".$a["admin_lname"];
	
		$counter++;
		//$row3["comments"] = strip_tags($row3["comments"] , "<p><i><ul><li><ol><u><em><br>");
		$comments = nl2br($row3["comments"], true);
		//$comments = $util->extractText($comments);
		$date = date("F j, Y", strtotime($row3['comment_date'])); //new Zend_Date($row3['comment_date'], 'YYYY-MM-dd HH:mm:ss');
		//$id = $row3["id"];

		$evaulation_report .= '
		<tr class="evaluation_comment" data-id="'.$row3["id"].'" data-ordering="'.$counter.'">		
			<td class="td_info td_la">'.$counter.'</td>
			<td class="td_info">'.$name.'</td>
			<td class="td_info">'.$comments.'</td>
			<td class="td_info">'.$date.'</td>
			<td class="td_info">&nbsp;&nbsp;<a href="javascript: edit_notes_show_report('.$userid.', '.$row3["id"].',\'evaluation\'); ">Edit</a></font></td>
		</tr>';
		
		$evaulation_report_tab .= '
		<tr class="evaluation_comment_tab" data-id="'.$row3["id"].'" data-ordering="'.$counter.'">		
			<td class="td_info td_la">'.$counter.'</td>
			<td class="td_info">'.$name.'</td>
			<td class="td_info"><a href="javascript: view_notes_show_report('.$userid.', '.$row3["id"].',\'evaluation\'); ">'.$comments.'</a></td>
			<td class="td_info">'.$date.'</td>
			<td class="td_info">&nbsp;&nbsp;<a href="javascript: edit_notes_show_report('.$userid.', '.$row3["id"].',\'evaluation\'); ">Edit</a></font></td>
		</tr>';
		
		
		
		
		
	}



$evaulation_report .= '</tbody></table>';
$evaulation_report_tab .= '</tbody></table>';
if($counter == 0){
	$evaulation_report = "";
	$evaulation_report_tab = "";
}
//ENDED: evaluation report	


//START: admin report
$admin_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0>
	<tr>
		<td colspan=7><div class="hiresteps" id ="evaluation_notes_target"><table width="100%"><tr><td><font color="#003366"><strong>Admin</strong></font></td><td align="right"><a href="javascript: load_admin('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="15%">User</td>
		<td class="td_info td_la" width="15%">Date/Time</td>
		<td class="td_info td_la" width="15%">Type</td>
		<td class="td_info td_la" width="20%">Subject</td>
		<td class="td_info td_la" width="35%">Content</td>
		<td class="td_info td_la" width="0"></td>
	</tr>';

$sql = "SELECT e.id, e.history, DATE_FORMAT(e.date_created,'%D %b %y'), e.date_created, a.admin_fname, a.admin_lname, e.subject, e.actions FROM applicant_history e LEFT OUTER JOIN admin a ON a.admin_id = e.admin_id WHERE a.status='FULL-CONTROL' AND e.userid = $userid ORDER BY e.date_created DESC;";
$result = mysqli_query($link2,$sql);
$counter = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;	
$util = new HTMLUtil();				
while(list($id, $history, $date_created, $time_created, $admin_fname, $admin_lname, $subject, $actions)=mysqli_fetch_array($result))
{
	$counter++;

	//$history = str_replace("\n","<br>",$history);
	$time_created = date("g:i a", strtotime($time_created));
	//$history = htmlentities($history, ENT, "UTF-8");
	if ($admin_fname=="RSSC"&&$admin_lname=="Server"){
		
		$admin_fname = "SYSTEM";
		$admin_lname = "";
	}
	if($actions == "EMAIL")
	{
		$history = nl2br($history);
		$history = $util->extractText($history);
		$edit_link = '<td class="td_info"></td>';
	}
	else
	{
		$edit_link = '<td class="td_info"><font size=1><a href="javascript: delete_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Delete</a>&nbsp;&nbsp;&nbsp;<a href="javascript: edit_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Edit</a></font></td>';		
	}
	if($actions == "CSR")
	{
		$view_notes_link = "Click to view notes";
	}
	else
	{
			
		//$history = str_replace("\n","<br/>",$history);
		$history = $util->extractText("<p>".$history."</p>");
		//$view_notes_link = truncate_comment($history);
	}	
	$admin_report .= '
	<tr>
		<td class="td_info td_la" width="0">'.$counter.'</font></td>
		<td class="td_info td_la" width="15%">'.$admin_fname.' '.$admin_lname.'</td>
		<td class="td_info td_la" width="15%">'.$date_created.'&nbsp;&nbsp;<font size=1>'.$time_created.'</font></td>
		<td class="td_info td_la" width="20%">'.$actions.'</td>
		<td class="td_info td_la" width="35%">'.$subject.'</td>
		
		<td class="td_info td_la"><a href="javascript: view_notes_show_report('.$userid.', '.$id.',\'communications\'); ">'.$view_notes_link.'</a></td>
		'.$edit_link.'
	</tr>';					
} 
$admin_report .= '</table>';
if($counter == 0) $admin_report = "";
//ENDED: admin report		


//START: recruiter report
$recruiter_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0>
	<tr>
		<td colspan=7><div class="hiresteps" id="evaluation_notes_target"><table width="100%"><tr><td><font color="#003366"><strong>Recruiter</strong></font></td><td align="right"><a href="javascript: load_recruiter('.$userid.'); ">Refresh</a></td></tr></table></div></td>
	</tr>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="15%">User</td>
		<td class="td_info td_la" width="15%">Date/Time</td>
		<td class="td_info td_la" width="15%">Type</td>
		<td class="td_info td_la" width="20%">Subject</td>
		<td class="td_info td_la" width="35%">Content</td>
		<td class="td_info td_la" width="0"></td>
	</tr>';

$sql = "SELECT e.id, e.history, DATE_FORMAT(e.date_created,'%D %b %y'), e.date_created, a.admin_fname, a.admin_lname, e.subject, e.actions FROM applicant_history e LEFT OUTER JOIN admin a ON a.admin_id = e.admin_id WHERE a.status='HR' AND e.userid = $userid ORDER BY e.date_created DESC;";
$result = mysqli_query($link2,$sql);

$counter = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;	
				
while(list($id, $history, $date_created, $time_created, $admin_fname, $admin_lname, $subject, $actions)=mysqli_fetch_array($result))
{
	
	$counter++;
	//$history = str_replace("\n","<br>",$history);
	$history = strip_tags($history);
	$time_created = date("g:i a", strtotime($time_created));
	//$history = htmlentities($history, ENT_SUBSTITUTE, UTF-8);
	if($actions == "EMAIL")
	{
		$history = nl2br($history);
		$history = $util->extractText($history);
		$edit_link = '<td class="td_info"><font size=1><a href="javascript: delete_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Delete</a></td>';
	}
	else
	{
		$edit_link = '<td class="td_info"><font size=1><a href="javascript: delete_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Delete</a>&nbsp;&nbsp;&nbsp;<a href="javascript: edit_notes_show_report('.$userid.', '.$id.',\'communications\'); ">Edit</a></td>';
	}
	if($actions == "CSR")
	{
		$view_notes_link = "Click to view notes";
	}
	else
	{
		$history = strip_tags($history);
		//$history = str_replace("\n","<br>",$history);
		$view_notes_link = substr($history, 0, 100)."...";
	}
	$subject = strip_tags($subject);
	$recruiter_report .= '
	<tr>
		<td class="td_info td_la">'.$counter.'</font></td>
		<td class="td_info">'.$admin_fname.' '.$admin_lname.'</td>
		<td class="td_info">'.$date_created.'&nbsp;&nbsp;<font size=1>'.$time_created.'</font></td>
		<td class="td_info">'.$actions.'</td>
		<td class="td_info">'.$subject.'</td>
		<td class="td_info"><a href="javascript: view_notes_show_report('.$userid.', '.$id.',\'communications\'); ">'.$view_notes_link.'</a></td>
		'.$edit_link.'
	</tr>';					
} 
$recruiter_report .= '</table>';
if($counter == 0) $recruiter_report = "";
//ENDED: recruiter report	


//START: history
$history_logs_report .= '
<table width=100% cellpadding=3 cellspacing="0" border=0>
	<tr>
		<td class="td_info td_la" width="0">#</td>
		<td class="td_info td_la" width="20%">User</td>
		<td class="td_info td_la" width="20%">User Type</td>
		<td class="td_info td_la" width="45%">Description of Changes</td>
		<td class="td_info td_la" width="15%">Date</td>
	</tr>
';

$sql2 = "SELECT rs.id AS id, CONCAT('candidate replaced recruiter from <span style=\'color:#ff0000\'>', fma.admin_fname, ' ', fma.admin_lname, '</span> to <span style=\'color:#ff0000\'>', rsad.admin_fname, ' ', rsad.admin_lname, '</span>')  AS changes,
			 DATE_FORMAT(rs.date_transferred,'%D %b %y') AS date_change1,rs.date_transferred AS date_change,
			 CASE WHEN a.admin_fname IS NULL THEN 'SYSTEM' ELSE a.admin_fname END AS admin_fname, 
			 CASE WHEN a.admin_lname IS NULL THEN '' ELSE a.admin_lname END AS admin_lname,
			 CASE WHEN rs.transfer_type IN ('ADMIN', 'DELETED') THEN 'ADMIN' ELSE 'SYSTEM' END AS change_by_type 
			 FROM recruiter_staff_transfer_logs rs
			 LEFT JOIN admin a ON a.admin_id = rs.admin_id
			 LEFT JOIN admin fma ON fma.admin_id = rs.former_recruiter_id 
		 	 INNER JOIN recruiter_staff rsa ON rsa.id = rs.recruiter_staff_id
		 	 LEFT JOIN admin rsad ON rsa.admin_id = rsad.admin_id WHERE rsa.userid = '$userid'";
		 	 
$sql = "SELECT e.id AS id, e.changes AS changes, DATE_FORMAT(e.date_change,'%D %b %y') AS date_change1, e.date_change AS date_change, a.admin_fname AS admin_fname, a.admin_lname AS admin_lname, e.change_by_type AS change_by_type FROM staff_history e LEFT JOIN admin a ON a.admin_id = e.change_by_id WHERE e.userid = '$userid' UNION $sql2 ORDER BY date_change DESC;";

$result = mysqli_query($link2,$sql);

$counter = 0;
while(list($id, $comments, $date, $time, $admin_fname, $admin_lname, $type)=mysqli_fetch_array($result))
{
	
	$comments = str_replace("\n","<br>",$comments);
	$time_created = date("g:i a", strtotime($time));
	if ($admin_fname==""){
		if ($comments=="system removed staff from being <strong style='color:red'>[BLACKLISTED]</strong>"){
			$admin_fname = "SYSTEM";
			$admin_lname = "";
			$type = "SYSTEM";
		}else{
			$admin_fname = "CANDIDATE";
			$admin_lname = "";
			$type = "CANDIDATE";	
		}
		
	}
	if ($admin_fname=="RSSC"&&$admin_lname=="Server"){
		if (!(strpos($comments, "date has been reverted to its original date")===false)){
			continue;
		}	
		if (!(strpos($comments, "Date Categorized on")===false)){
			continue;
		}	
		
	}
	$counter++;
	
	if ($comments=="Candidate responded via autoresponder <span style='color:#ff0000'>STILL AVAILABLE</span>"){
		$comments = "Candidate responded <span style='color:#ff0000'>STILL AVAILABLE</span> on email Are you still available for a homebased job at Remote Staff?";
	}
	if ($comments=="Candidate responded via autoresponder <span style='color:#ff0000'>NOT INTERESTED ANYMORE</span>"){
		$comments = "Candidate responded <span style='color:#ff0000'>NOT INTERESTED ANYMORE</span> on email Are you still available for a homebased job at Remote Staff?";	
	}
	if ($admin_fname=="RSSC"&&$admin_lname=="Server"){
		if ($comments=="Candidate responded <span style='color:#ff0000'>STILL AVAILABLE</span> on email Are you still available for a homebased job at Remote Staff?"||$comments=="Candidate responded <span style='color:#ff0000'>NOT INTERESTED ANYMORE</span> on email Are you still available for a homebased job at Remote Staff?"){
			$admin_fname = "CANDIDATE";
			$admin_lname = "";
			$type = "CANDIDATE";
			
		}else{
			$admin_fname = "SYSTEM";
			$admin_lname = "";
			$type = "SYSTEM";
		}	
		
	}
	
	if ($comments=="SYSTEM sent autoresponder <span style='color:#ff0000'>Are you still available for a homebased job at RemoteStaff?</span>"){
		$comments = "System Executed sent email <span style='color:#ff0000'>Are you still available for a homebased job at RemoteStaff?</span>";
	}
	
	
	
	$history_logs_report .= '
	<tr>
		<td class="td_info td_la">'.$counter.'</font></td>
		<td class="td_info">'.$admin_fname.' '.$admin_lname.'</td>
		<td class="td_info">'.$type.'</td>
		<td class="td_info">'.$comments.'</td>
		<td class="td_info">'.$date.'&nbsp;&nbsp;'.$time_created.'</td>
	</tr>';		
} 
$history_logs_report .= '</table>';
if($counter == 0) $history_logs_report = "";
//ENDED: history


//START: work experience
$sql = $db->select()
          ->from('currentjob')
          ->where('userid = ?', $userid);
$result = $db->fetchAll($sql);


foreach($result as $row3)
{
	$company = $row3[10];
	$title= $row3[12];
	$level2 = $row3[14];
	$specialization = $row3[13];
	$industry = $row3[11];
	$month =$row3[15];
	$currency =$row3[24];
	$salary =$row3[25];
	$neg = $row3[26];
			
	$current = $row3[2];
	if ($current=="2")
	{
		$intern =$row3[5]; 
		switch ($intern)
		{
			case 'x':
				$mess=  "I am available for internship jobs.My internship period is from &nbsp;".$row3[6]." ".$row3[7]." ".$row3[8]."&nbsp;and the duration is &nbsp;".$row3[9];
				break;
			case 'p':
				$mess = "I am not looking for an internship now";
				break;
			default:
				break;
		}
	}

	switch($month)
	{
		case 1:
			$month= "Jan";
			break;
		case 2:
			$month= "Feb";
			break;
		case 3:
			$month= "Mar";
			break;
		case 4:
			$month= "Apr";
			break;
		case 5:
			$month= "May";
			break;
		case 6:
			$month= "Jun";
			break;
		case 7:
			$month= "Jul";
			break;
		case 8:
			$month= "Aug";
			break;
		case 9:
			$month= "Sep";
			break;
		case 10:
			$month= "Oct";
			break;
		case 11:
			$month= "Nov";
			break;
		case 12:
			$month= "Dec";
			break;
		default:
			break;
	}			

	$start =$month." ".$row3[16];
			
	$month2 =$row3[17];
	switch($month2)
	{
		case 1:
			$month2= "Jan";
			break;
		case 2:
			$month2= "Feb";
			break;
		case 3:
			$month2= "Mar";
			break;
		case 4:
			$month2= "Apr";
			break;
		case 5:
			$month2= "May";
			break;
		case 6:
			$month2= "Jun";
			break;
		case 7:
			$month2= "Jul";
			break;
		case 8:
			$month2= "Aug";
			break;
		case 9:
			$month2= "Sep";
			break;
		case 10:
			$month2= "Oct";
			break;
		case 11:
			$month2= "Nov";
			break;
		case 12:
			$month2= "Dec";
			break;
		default:
			break;
	}

	$end =$month2." ".$row3[18];
	$status = $row3[19];
	
	switch($status)
	{
		case 'a':
			$str = "Can start work after &nbsp;".$row3["available_notice"]." month(s) of notice period";
			break;
		case 'b':
			$str = "Can start work after &nbsp;".$row3["ayear"]."-".$row3["amonth"]."-".$row3["aday"];
			break;
		case 'p':
			$str ="I am not actively looking for a job now";
			break;
		case 'Work Immediately';
			$str ="I can work immediately";
			break;
		default:
			break;
	}
	
	
	$freshgrad = $row3['freshgrad'];
	$intern_status = $row3['intern_status'];
	//$current_status = $row['current_status'];
	if($freshgrad == 1){
		$current_status = "fresh graduate";
	}
	if($intern_status == 1){
		$current_status = "still studying";
	}

	$years_worked = 0;
	$years_worked = $row3['years_worked'];
	$months_worked = 0;
	$months_worked = $row3['months_worked'];
	
	if(($years_worked != 0)&&($months_worked != 0)){
		$current_status = "working";
	}
	
}
		
$sql = $db->select()
          ->from('currentjob')
          ->where('userid = ?', $userid);
$result = $db->fetchAll($sql);

foreach($result as $row3)
{

	// 1
	$company = $row3['companyname'];
	$position1= $row3['position'];
	$period = $row3['monthfrom']." ".$row3['yearfrom']." "."to"." ".$row3['monthto']." ".$row3['yearto'];
	$duties =$row3['duties'];
	
	// 2
	$company2 = $row3['companyname2'];
	$position2= $row3['position2'];
	$period2 = $row3['monthfrom2']." ".$row3['yearfrom2']." "."to"." ".$row3['monthto2']." ".$row3['yearto2'];
	$duties2 =$row3['duties2'];
	
	// 3
	$company3 = $row3['companyname3'];
	$position3= $row3['position3'];
	$period3 = $row3['monthfrom3']." ".$row3['yearfrom3']." "."to"." ".$row3['monthto3']." ".$row3['yearto3'];
	$duties3 =$row3['duties3'];
	
	// 4
	$company4 = $row3['companyname4'];
	$position4= $row3['position4'];
	$period4 = $row3['monthfrom4']." ".$row3['yearfrom4']." "."to"." ".$row3['monthto4']." ".$row3['yearto4'];
	$duties4 =$row3['duties4'];
	
	//5
	$company5 = $row3['companyname5'];
	$position5= $row3['position5'];
	$period5 = $row3['monthfrom5']." ".$row3['yearfrom5']." "."to"." ".$row3['monthto5']." ".$row3['yearto5'];
	$duties5 =$row3['duties5'];
	
	//6
	$company6 = $row3['companyname6'];
	$position6= $row3['position6'];
	$period6 = $row3['monthfrom6']." ".$row3['yearfrom6']." "."to"." ".$row3['monthto6']." ".$row3['yearto6'];
	$duties6 =$row3['duties6'];			
	
	//7
	$company7 = $row3['companyname7'];
	$position7= $row3['position7'];
	$period7 = $row3['monthfrom7']." ".$row3['yearfrom7']." "."to"." ".$row3['monthto7']." ".$row3['yearto7'];
	$duties7 =$row3['duties7'];			
	
	//8
	$company8 = $row3['companyname8'];
	$position8= $row3['position8'];
	$period8 = $row3['monthfrom8']." ".$row3['yearfrom8']." "."to"." ".$row3['monthto8']." ".$row3['yearto8'];
	$duties8 =$row3['duties8'];			
	
	//9
	$company9 = $row3['companyname9'];
	$position9= $row3['position9'];
	$period9 = $row3['monthfrom9']." ".$row3['yearfrom9']." "."to"." ".$row3['monthto9']." ".$row3['yearto9'];
	$duties9 =$row3['duties9'];			
	
	//10
	$company10 = $row3['companyname10'];
	$position10= $row3['position10'];
	$period10 = $row3['monthfrom10']." ".$row3['yearfrom10']." "."to"." ".$row3['monthto10']." ".$row3['yearto10'];
	$duties10 =$row3['duties10'];			
			
	///////////////////////////
	$currency =$row3['salary_currency'];
	$salary =$row3['expected_salary'];
	$neg = $row3['expected_salary_neg'];
			
	$current = $row3['freshgrad'];
	if ($current=="2")
	{
		$intern =$row3['intern_status']; 
		switch ($intern)
		{
			case 'x':
			$mess=  "I am available for internship jobs.My internship period is from &nbsp;".$row3['iday']." ".$row3['imonth']." ".$row3['iyear']."&nbsp;and the duration is &nbsp;".$row3['intern_notice'];
					break;
					case 'p':
					$mess = "I am not looking for an internship now";
					break;
					default:
					break;
							
		}
	}
			
	$status = $row3['available_status'];
	switch($status)
	{
		case 'a':
			$str = "Can start work after &nbsp;".$row3['available_notice']." weeks";
			break;
		case 'b':
			$str = "Can start work after &nbsp;".$row3['amonth']."-".$row3['aday']."-".$row3['ayear'];
			break;
		case 'p':
			$str ="I am not actively looking for a job now";
			break;
		case 'Work Immediately';
			$str ="I can work immediately";
			break;
		default:
			break;
	}
	
	for($i=1;$i<=3;$i++){
	
		if($i == 1) $position_choice = $row3['position_first_choice'];
		if($i == 2) $position_choice = $row3['position_second_choice'];
		if($i == 3) $position_choice = $row3['position_third_choice'];
		
		if($position_choice != ''){
			$query  = "SELECT * FROM job_sub_category
				where sub_category_id = ".$position_choice;		
			$result = mysqli_query($link2,$query) or die (mysqli_error());
			while($row = mysqli_fetch_array($result)){
				if($i == 1){
					$position_first_choice = $row['sub_category_name'];
				}
				if($i == 2){
					$position_second_choice = $row['sub_category_name'];	
				}
				if($i == 3){
					$position_third_choice = $row['sub_category_name'];
				}
			}
		}

	}
	
	if($row3['position_first_choice_exp'] == 'Yes'){
		$position_first_choice_exp = '(Experienced)';
	}
	else{
		$position_first_choice_exp= '(Inexperienced)';
	}

	if($row3['position_second_choice_exp'] == 'Yes'){
		$position_second_choice_exp = '(Experienced)';
	}
	else{
		$position_second_choice_exp= '(Inexperienced)';
	}
		
	if($row3['position_third_choice_exp'] == 'Yes'){
		$position_third_choice_exp = '(Experienced)';
	}
	else{
		$position_third_choice_exp= '(Inexperienced)';
	}
		
	
}
//ENDED: work experience


//START: full time rate dropdown
$q_currency=mysqli_query($link2,"SELECT p.id, p.code FROM staff_rate AS s JOIN products AS p ON s.product_id = p.id WHERE s.userid='$userid' ORDER BY s.date_updated DESC LIMIT 1");
$c = 0;
while ($r_currency = mysqli_fetch_assoc($q_currency)) 
{
    $pull_time_rate_dropdown .= get_option_tag($r_currency['code'], $r_currency['id']);
    $c++;
}

if($c == 0) 
{
	$pull_time_rate_dropdown .= "<option value='' selected></option>\n";
}	
else
{
	$pull_time_rate_dropdown .= "<option value=''></option>\n";
}

if($country_id == "IN")
{
	$q_currency=mysqli_query($link2,"SELECT DISTINCT(ph.product_id), p.id, p.code FROM products p, product_price_history ph WHERE p.id=ph.product_id AND p.code LIKE 'INR-FT%' ORDER BY ph.amount ASC");
}
else
{
	$q_currency=mysqli_query($link2,"SELECT DISTINCT(ph.product_id), p.id, p.code FROM products p, product_price_history ph WHERE p.id=ph.product_id AND p.code LIKE 'PHP-FT%' ORDER BY ph.amount ASC");
}
while ($r_currency = mysqli_fetch_assoc($q_currency)) 
{
    $c_id = $r_currency['id'];
    $pull_time_rate_dropdown .= get_option_tag($r_currency['code'], $c_id);
}
//ENDED: full time rate dropdown


//START: part time rate dropdown
$q_currency=mysqli_query($link2,"SELECT p.id, p.code FROM staff_rate AS s JOIN products AS p ON s.part_time_product_id = p.id WHERE s.userid='$userid' ORDER BY s.date_updated DESC LIMIT 1");
$c = 0;
while ($r_currency = mysqli_fetch_assoc($q_currency)) 
{
    $part_time_rate_dropdown .= get_option_tag($r_currency['code'], $r_currency['id']);
    $c++;
}

if($c == 0) 
{
	$part_time_rate_dropdown .= "<option value='' selected></option>\n";
}
else
{
	$part_time_rate_dropdown .= "<option value=''></option>\n";
}							

if($country_id == "IN")
{
	$q_currency=mysqli_query($link2,"SELECT DISTINCT(ph.product_id), p.id, p.code FROM products p, product_price_history ph WHERE p.id=ph.product_id AND p.code LIKE 'INR-PT%' ORDER BY ph.amount ASC");
}
else
{
	$q_currency=mysqli_query($link2,"SELECT DISTINCT(ph.product_id), p.id, p.code FROM products p, product_price_history ph WHERE p.id=ph.product_id AND p.code LIKE 'PHP-PT%' ORDER BY ph.amount ASC");
}
while ($r_currency = mysqli_fetch_assoc($q_currency)) 
{
    $c_id = $r_currency['id'];
    $part_time_rate_dropdown .= get_option_tag($r_currency['code'], $c_id);
}		
//ENDED: part time rate dropdown


//START: staff photo
$staff_photo = $file_manager->retrieve_photo();
//ENDED: staff photo


//START: education & highest qualification
$query="SELECT * FROM education WHERE userid=$userid";
$result=mysqli_query($link2,$query);
$ctr=@mysqli_num_rows($result);
if ($ctr >0 )
{
	$row = mysqli_fetch_array ($result, MYSQLI_NUM); 

	$level = $row[2];
	$field = $row[3];
	$score = $row[6];
	$major = $row[4];
	$school =$row[7];
	$loc = $row[8];
	$year =$row[10];
	$month =$row[9];
	$trainings = $row[11];
	$licence_cert = "";
	if(isset($row[12])){
		$licence_cert = $row[12];
	}
	$trainings = nl2br($trainings);
	$licence_cert = nl2br($licence_cert);
	switch($month)
	{
		case 1:
			$month= "Jan";
			break;
		case 2:
			$month= "Feb";
			break;
		case 3:
			$month= "Mar";
			break;
		case 4:
			$month= "Apr";
			break;
		case 5:
			$month= "May";
			break;
		case 6:
			$month= "Jun";
			break;
		case 7:
			$month= "Jul";
			break;
		case 8:
			$month= "Aug";
			break;
		case 9:
			$month= "Sep";
			break;
		case 10:
			$month= "Oct";
			break;
		case 11:
			$month= "Nov";
			break;
		case 12:
			$month= "Dec";
			break;
		default:
			break;
	}
}	
//ENDED: education & highest qualification


//START: relevant experience industry
$queryAllLeads = "SELECT id, name, userid
FROM tb_relevant_industry_experience WHERE userid='$userid'
ORDER BY name ASC;";
$result = mysqli_query($link2,$queryAllLeads);
$counter = 1;
$relevant_industry_experience .= '
<table width="100%">';
while(list($id, $name)=mysqli_fetch_array($result))
{
	$relevant_industry_experience .= '
	<tr>
		<td class="td_info td_la" width="10%">#'.$counter.'</td>
		<td class="td_info td_la" width="40%">'.$name.'</td>
		<td class="td_info td_la" width="50%" align=right><a href="javascript: delete_relevant_industry_experience('.$id.','.$userid.'); ">Delete</a></td>
	</tr>';
	$counter++;
}
$relevant_industry_experience .= "</table>";
//ENDED: relevant experience industry


//START: ASL categories
$asl_categories .= '
<table width=100%>			
	<tr>
		<td class="td_info td_la" width=0>#</td>
		<td class="td_info td_la" width=20%>Category</td>
		<td class="td_info td_la" width=20%>Sub Category</td>
		<td class="td_info td_la" width=20%>ASL</td>
		<td class="td_info td_la" width=20%>Date Added to ASL</td>
		<td class="td_info td_la" width=20%></td>
</tr>';									
$q = "SELECT id, category_id, sub_category_id, ratings, DATE_FORMAT(sub_category_applicants_date_created,'%D %b %y'), under_consideration FROM job_sub_category_applicants WHERE userid='$userid'";
$result = mysqli_query($link2,$q);

$counter = 0;
while(list($id, $category_id, $sub_category_id, $ratings, $sub_category_applicants_date_created, $underconsideration)=mysqli_fetch_array($result))
{
	$counter++;
	$cat = "SELECT category_name FROM job_category WHERE category_id='$category_id'";
	$cat_result = mysqli_query($link2,$cat);
	while(list($category_name)=mysqli_fetch_array($cat_result))
	{			
		$category_name_display = $category_name;
	}	
	$cat = "SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='$sub_category_id'";
	$cat_result = mysqli_query($link2,$cat);
	while(list($sub_category_name)=mysqli_fetch_array($cat_result))
	{
		$sub_category_name_display = $sub_category_name;
	}
	if($ratings==1)
	{
		$rating_value = '<option value="1" selected>No</option><option value="0">Yes</option><option value="2">Under consideration</option>';
	}
	else
	{
		if ($underconsideration){
			$rating_value = '<option value="1">No</option><option value="0">Yes</option><option value="2" selected>Under consideration</option>';
		}else{
			$rating_value = '<option value="1">No</option><option value="0" selected>Yes</option><option value="2">Under consideration</option>';
		}
		
	}
	$asl_categories .= '
	<tr>
		<td class="td_info td_la">'.$counter.'</td>
		<td class="td_info">'.$category_name_display.'</td>
		<td class="td_info">'.$sub_category_name_display.'</td>
		<td class="td_info">
			<select name="star" style="font:10px tahoma;" onChange="javascript: update_asl_visiblity('.$id.', this.value);" >
				<option value="">-</option>
				'.$rating_value.'
			</select>											
		</td>
		<td class="td_info">'.$sub_category_applicants_date_created.'</td>
		<td class="td_info" align=right><a href="javascript: delete_asl('.$userid.','.$id.'); "><font size=1>Delete</font></a></td>
	</tr>';
}
$asl_categories .= '</table>';
if($counter == 0) $asl_categories = "";
//ENDED: ASL categories

//START: Shortlist History
$shortlist_history .= '
<table width=100%>			
	<tr>
		<td class="td_info td_la" width=10>#</td>
		<td class="td_info td_la" width=236>Client</td>
		<td class="td_info td_la" width=127>Job Advertisement</td>
		<td class="td_info td_la" width=200>Date Shortlisted</td>
		<td class="td_info td_la" width=100>Status</td>
		<td class="td_info td_la" width=160>Action</td>
		<td class="td_info td_la" width=430>Feedback</td>
		<td class="td_info td_la" width=400>Remarks</td>
		
		
</tr>';	

$sql = $db->select()->from(array("ss"=>"tb_shortlist_history"), array("ss.id AS shortlist_id", "ss.date_listed AS date_listed", "ss.rejected", "ss.feedback", "ss.position"))
			->joinInner(array("pos"=>"posting"), "pos.id = ss.position", array("pos.jobposition AS job_title", "pos.lead_id AS lead_id"))
			->joinInner(array("l"=>"leads"), "l.id = pos.lead_id", array("CONCAT(l.fname, ' ', l.lname) AS client"))
			->where("ss.userid = ?", $userid)
			->order("ss.date_listed DESC");
$ss = $db->fetchAll($sql);
$staff_status = getStaffStatus($userid);
$i = 1;
foreach($ss as $shortlist){
	
	//get the applicant status 
	$status = $db->fetchRow($db->select()->from(array("app_stat"=>"applicant_status"), array("date"))->where("app_stat.link_id = ?", $shortlist["shortlist_id"])->where("app_stat.status = 'SHORTLISTED'"));
	if ($status){
		$date = date('F j, Y h:i A',strtotime($status["date"]));
	}else{
		$date = date('F j, Y',strtotime($shortlist["date_listed"]));
	}
	if ($shortlist["rejected"]==1){
		$rejected = "Not Qualified";
		$button = "<button data-id='".$shortlist["shortlist_id"]."' class='unreject-shortlist'>Qualified</button>";
	}else{
		$rejected = "Qualified";
		$button = "<button data-id='".$shortlist["shortlist_id"]."' class='reject-shortlist' style='font-size:0.9em'>Not Qualified</button>";
	}
	if ($staff_status == "Inactive"){
		$remarks = "Candidate no longer available";
		$rejected = "Not Qualified";
		$button = "<button disabled data-id='".$shortlist["shortlist_id"]."' class='unreject-shortlist'>Qualified</button>";
		
	}else{
		$remarks = "";
	}
	$feedback = substr(strip_tags($shortlist["feedback"]), 0, 100);
	$row = "<tr>
		<td class=\"td_info td_la\" width=10>$i</td>
		<td class=\"td_info\" width=236><a href=\"javascript: lead({$shortlist["lead_id"]}); \">{$shortlist["client"]}</a></td>
		<td class=\"td_info\" width=127><a href=\"javascript: ads({$shortlist["position"]}); \">{$shortlist["job_title"]}</a></td>
		<td class=\"td_info\" width=200>{$date}</td>
		<td class=\"td_info\" width=100>{$rejected}</td>
		<td class=\"td_info\" width=100>{$button}</td>
		<td class=\"td_info\" width=430><a href='/portal/recruiter/get_shortlist_feedback.php?id={$shortlist["shortlist_id"]}' class='feedback_view'>{$feedback}</a></td>
		<td class=\"td_info\" width=350>{$remarks}</td>
	</tr>";
	$i++;
	$shortlist_history.=$row;
}
if ($i==1){
	$shortlist_history = "";
}


//START: Endorsement History
$endorsement_history .= '
<table width=100%>			
	<tr>
		<td class="td_info td_la" width=10>#</td>
		<td class="td_info td_la" width="216">Client Name</td>
		<td class="td_info td_la" width="557">Job Advertisement</td>
		<td class="td_info td_la" width="200">Date Endorsed to Lead</td>
		<td class="td_info td_la" width="100">Status</td>
		<td class="td_info td_la" width="31"></td>
		
		
</tr>';									
$queryAllLeads = "SELECT client_name, position, job_category, date_endoesed, rejected  
FROM tb_endorsement_history WHERE userid='$userid'
ORDER BY position ASC;";

$result = mysqli_query($link2,$queryAllLeads);

$counter = 0;
while(list($client_name, $pos, $job_category, $date_endoesed, $rejected)=mysqli_fetch_array($result))
{
	$lead_id = $client_name;
	$counter++;
	$a = $db->fetchRow("SELECT fname, lname FROM leads WHERE id='$client_name' LIMIT 1");
	$client_name = $a["fname"]." ".$a["lname"];
	
	$job_position_name = "";
	$a = $db->fetchRow("SELECT jobposition FROM posting WHERE id='$pos' LIMIT 1");
	$job_position_name =$a["jobposition"];                                                        

	if($job_position_name == "")
	{
		$a = $db->fetchRow("SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='$job_category' LIMIT 1");
		$job_position_name = $a["sub_category_name"];                                                        
	}
	if ($rejected==1){
		$rejected = "Rejected";
	}else{
		$rejected = "";
	}
	$endorsement_history .= '	
	<tr>
		<td class="td_info td_la"  width=10>'.$counter.'</td>
		<td class="td_info" width=216><a href="javascript: lead('.$lead_id.'); ">'.$client_name.'</a></td>
		<td class="td_info" width=557><a href="javascript: ads('.$pos.');">'.$job_position_name.'</a></td>
        <td class="td_info" width=200>'.date('F j, Y h:i A',strtotime($date_endoesed)).'</td>
        <td class="td_info" width=100>'.$rejected.'</td>
        <td class="td_info" width=31>&nbsp;</td>
        
	</tr>';
}
$endorsement_history .= '</table>';
if($counter == 0) $endorsement_history = "";
//ENDED: Endorsement History 

//START: Job Applications
$jobapplication = '
<table width=100%>			
	<tr>
		<td class="td_info td_la" width=10>#</td>
		<td class="td_info td_la" width="377">Job Position</td>
		<td class="td_info td_la" width="236">Client Name</td>
		<td class="td_info td_la" width="300">Status</td>
		<td class="td_info td_la" width="331">Date Applied</td>
		<td class="td_info td_la" width="331">&nbsp;</td>
		
</tr>';		
$counter = 0;
$query="SELECT a.status,DATE_FORMAT(a.date_apply,'%D %b %Y'),p.id,p.companyname,p.jobposition, p.ads_title,p.sub_category_id, p.id AS posting_id, p.lead_id AS lead_id, a.id AS application_id 
FROM applicants a
JOIN posting p ON p.id = a.posting_id
WHERE a.userid= $userid
AND a.status <>'Sub-Contracted'
AND a.expired = 0 
AND p.status ='ACTIVE';";
$result=mysqli_query($link2,$query);
while(list($status,$date,$id,$companyname,$position,$ads_title,$sub_category_id, $posting_id, $lead_id, $application_id) = mysqli_fetch_array($result)){
	$counter++;	
	$status = "Unprocessed";
	//check if prescreened first
	$pres = $db->fetchRow($db->select()->from(array("pres"=>"pre_screened_staff"), array("userid"))->where("userid = ?", $userid));
	if ($pres){
		$status = "Pre-screened";
	}		
	$shortlisted = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("userid"))->where("userid = ?", $userid)->where("position = ?", $posting_id));
	if ($shortlisted){
		$status = "Shortlisted";
	}
	$endorsed = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array("userid"))->where("userid = ?", $userid)->where("position = ?", $posting_id));
	if ($endorsed){
		$status = "Endorsed";
	}
	if ($lead_id){
		$new = $db->fetchRow($db->select()
				->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
				->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
				->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
				->where("end.client_name = ?", $lead_id)
				->where("end.position = ?", $posting_id)
				->where("end.userid = ?", $userid)
				->where("tbr.status = 'NEW'")
				->where("tbr.service_type = 'CUSTOM'"));
		if ($new){
			$status = "Interview Set";
		}
		$hired = $db->fetchRow($db->select()
				->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
				->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
				->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
				->where("end.client_name = ?", $lead_id)
				->where("end.position = ?", $posting_id)
				->where("end.userid = ?", $userid)
				->where("tbr.status = 'HIRED'")
				->where("tbr.service_type = 'CUSTOM'"));
		if ($hired){
			$status = "Hired";
		}
		$rejected = $db->fetchRow($db->select()
					->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid"))
					->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id"))			
					->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.applicant_id = end.userid AND tbr.leads_id = end.client_name", array("tbr.date_interview AS date"))
					->where("end.client_name = ?", $lead_id)
					->where("end.position = ?", $posting_id)
					->where("end.userid = ?", $userid)
					->where("tbr.status = 'REJECTED'")
					->where("tbr.service_type = 'CUSTOM'"));
		if ($rejected){
			$status = "Rejected";
		}
	}
	$ads_position="";
	if($ads_title){
	    $ads_position = $ads_title;
	}else{
	    $ads_position = $position;
	}
	
	$a = $db->fetchRow("SELECT fname, lname FROM leads WHERE id='$lead_id' LIMIT 1");
	$withdraw_application = "<a href='/portal/recruiter/withdraw_application.php?id={$application_id}' class='withdraw_job_application'>Withdraw Application</a>";
	$client_name = $a["fname"]." ".$a["lname"];
	$jobapplication.="<tr><td class=\"td_info td_la\" width=0>$counter</td>
		<td class=\"td_info td_la\" width=\"377\"><a href=\"javascript: ads($posting_id);\">$ads_position</td>
		<td class=\"td_info td_la\" width=\"236\"><a href=\"javascript: lead($lead_id);\">$client_name</a></td>
		<td class=\"td_info td_la\" width=\"300\">$status</td>
		<td class=\"td_info td_la\" width=\"331\">$date</td>
		<td class=\"td_info td_la\" width=\"331\">$withdraw_application</td>
	
		
	</tr>";
	
}


if ($counter==0){
	$jobapplication = "";
}

//START: languages listings
$languages_listings .= '
<table width="100%">
	<tr>
		<td class="td_info td_la">Language</td>
		<td class="td_info td_la" align="center">Spoken</td>
		<td class="td_info td_la" align="center">Written</td>
	</tr>';
$counter = 0;
$query="SELECT id,language,spoken,written FROM language WHERE userid=$userid;";
$result=mysqli_query($link2,$query);
while(list($id,$language,$spoken,$written) = mysqli_fetch_array($result))
{
	$languages_listings .= '
	<tr>
		<td class="td_info">'.$language.'</td>
		<td class="td_info" align="center">'.$spoken.'</td>
		<td class="td_info" align="center">'.$written.'</td>
	</tr>';
}	
$languages_listings .= '</table>';
//ENDED: languages listings


//START: rs employment history
$rs_employment_history .= '
<table width="100%">
	<tr>
		<td class="td_info td_la" align="center" width="14%">Client</td>
		<td class="td_info td_la" align="center" width="14%"">Status</td>
		<td class="td_info td_la" align="center" width="14%">Job Designation</td>
		<td class="td_info td_la" align="center" width="30%">Reason</td>
		<td class="td_info td_la" align="center" width="14%">Starting Date</td>
		<td class="td_info td_la" align="center" width="14%">Date Terminated/Resigned</td>
	</tr>';
$counter = 0;
$query="SELECT leads_id, status,job_designation, DATE_FORMAT(starting_date,'%D %b %y'), DATE_FORMAT(resignation_date,'%D %b %y'), DATE_FORMAT(date_terminated,'%D %b %y'), reason, id FROM subcontractors WHERE userid='$userid' and status IN ('ACTIVE','resigned','terminated','suspended')";
$result=mysqli_query($link2,$query);

while(list($leads_id, $status, $job_designation, $starting_date, $resignation_date, $date_terminated, $reason, $subconid) = mysqli_fetch_array($result))
{
	$counter++;
	$a = $db->fetchRow("SELECT fname, lname FROM leads WHERE id=".$leads_id." LIMIT 1");
	$client_name = $a["fname"]." ".$a["lname"];
	
	if($status == 'resigned')
	{
		$date_ended = $resignation_date;
	}
	else if ($status=='terminated')
	{
		$date_ended = $date_terminated;
	}
	
	$statusLink = "<a href='/portal/contractForm.php?userid={$userid}&sid={$subconid}&lid={$leads_id}' target='_blank'>{$status}</a>";
	
	$rs_employment_history .= '
	<tr>
		<td class="td_info" align="center" width="14%">'.$client_name.'</td>
		<td class="td_info" align="center" width="14%">'.$statusLink.'</td>
		<td class="td_info" align="center" width="14%" >'.$job_designation.'</td>
		<td class="td_info" width="30%">'.$reason.'</td>
		<td class="td_info" align="center" width="14%">'.$starting_date.'</td>
		<td class="td_info" align="center" width="14%"r">'.$date_ended.'</td>
	</tr>';
	
	
	$date_ended = "";
	$starting_date = "";
}	
$rs_employment_history .= '</table>';
if($counter == 0) $rs_employment_history = '';
//ENDED: rs employment history

//started: interview feedbacks
$feedbacks = $db->fetchAll($db->select()->from(array("f"=>"request_for_interview_feedbacks"), array("f.id AS id", "f.feedback AS feedback", "f.date_created"))
							->joinLeft(array("r"=>"tb_request_for_interview"), "r.id = f.request_for_interview_id", array())
							->joinLeft(array("l"=>"leads"), "l.id = r.leads_id", array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client"), "l.id AS client_id"))
							->joinLeft(array("a"=>"admin"), "a.admin_id = f.admin_id", array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS admin")))						
							->where("r.applicant_id = ?" ,$userid));
foreach($feedbacks as $key=>$feedback){
	$feedbacks[$key]["date_created"] = date("F j, Y", strtotime($feedback["date_created"]));
}

//ended: interview feedbacks

//started: endorsement feedback
$feedback_endorsement = $db->fetchAll($db->select()->from(array("e"=>"tb_endorsement_history"))
									->joinLeft(array("a"=>"admin"), "a.admin_id = e.rejected_by", array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS rejected_admin")))
									->joinLeft(array("l"=>"leads"), "l.id = e.client_name", array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client")))
									->where("e.userid = ?", $userid)
									->where("e.rejected = 1")
						);

//started: shortlist feedback			
$feedback_shortlist = $db->fetchAll($db->select()->from(array("sh"=>"tb_shortlist_history"))
									->joinLeft(array("a"=>"admin"), "a.admin_id = sh.rejected_by", array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS rejected_admin")))
									->joinLeft(array("p"=>"posting"), "p.id = sh.position", array())
									->joinLeft(array("l"=>"leads"), "l.id = p.lead_id",  array(new Zend_Db_Expr("CONCAT(l.fname, ' ', l.lname) AS client")))
									->where("sh.userid = ?", $userid)
									->where("sh.rejected = 1")
									);			


//retrieve current work status
$work_status = $db->fetchOne($db->select()->from(array("s"=>"subcontractors"), array("work_status"))->where("status NOT IN ('resigned', 'terminated', 'deleted')")->order("date_contracted DESC")->where("userid = ?", $userid)->limit(1));
$work_status = str_replace("-", " ", $work_status);


//START: skills listings
$skill_listings .= '<table width="100%">
<tr>
	<td class="td_info td_la">Skill</td>
	<td class="td_info td_la" align="center">Experience</td>
	<td class="td_info td_la" align="center">Proficiency</td>
</tr>';
$counter = 0;
$query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
$result=mysqli_query($link2,$query);
while(list($id,$skill,$exp,$pro) = mysqli_fetch_array($result))
{
	
	if ($exp==0.5){
		$exp = "Less than 6 months";	
	}else if ($exp==0.75){
		$exp = "Over 6 months";
	}else if ($exp>10){
		$exp = "More than 10 years";
	}

	
	$skill_listings .= '
	<tr>
		<td class="td_info">'.$skill.'</td>
		<td class="td_info" align="center">'.$exp.'</td>
		<td class="td_info" align="center">'.$pro.'</td>
	</tr>';
}	
$skill_listings .= '</table>';
//ENDED: skills listings


function getStaffStatus($userid){

	global $db;
	
	$select = "select userid
		from unprocessed_staff 
		where userid='".$userid."'";
	$status = $db->fetchOne($select);
	if($status != NULL) return 'Unprocessed';
	
	$select = "select userid
		from pre_screened_staff 
		where userid='".$userid."'";
	$status = $db->fetchOne($select);
	if($status != NULL) return 'Prescreened';
	
	$select = "select userid
		from inactive_staff 
		where userid='".$userid."'";
	$status = $db->fetchOne($select);
	if($status != NULL) return 'Inactive';
	
	$select = "select userid
		from tb_endorsement_history 
		where userid='".$userid."'";
	$status = $db->fetchOne($select);
	if($status != NULL) return 'Endorsed';
	
	$select = "select userid
		from tb_shortlist_history 
		where userid='".$userid."'";
	$status = $db->fetchOne($select);
	if($status != NULL) return 'Shortlisted';
	
	$select = "select userid
		from job_sub_category_applicants 
		where userid='".$userid."'";
	$status = $db->fetchOne($select);
	if($status != NULL) return 'Categorized';
}

$status = getStaffStatus($userid);
$grey_status_array = array('Endorsed','Shortlisted','Categorized');
if(in_array($status,$grey_status_array)){
	$is_prescreened_disabled = 'disabled';
}else{
	$is_prescreened_disabled = "";
}

//checks for inactive blacklisted staff
if ($status=="Inactive"){
	$controlStatus = $_SESSION['status'];
	$sql = $db->select()
			->from("inactive_staff", array("type"))
			->where("userid = ?", $userid)->order("date DESC");
	
	$row = $db->fetchRow($sql);
	
	$admin = $db->fetchRow($db->select()->from("admin", array("csro", "status"))->where("admin_id = ?", $_SESSION["admin_id"]));
	
	if (($row["type"]=="BLACKLISTED")&&($admin["status"]!="FULL-CONTROL")&&($admin["csro"]!="Y")){
		$inactive_disabled = "disabled";
		
	}else{
		$inactive_disabled = "";
	}
	if ($row["type"]=="BLACKLISTED"){
		$endorsement_disabled = "disabled";
	}else{
		$endorsement_disabled = "";
	}
}else{
	$inactive_disabled = "";
	$endorsement_disabled = "";
}

$sql = $db->select()
		->from("inactive_staff", array("type"))
		->where("userid = ?", $userid)->order("date DESC");

$row = $db->fetchRow($sql);
if ($row["type"]=="BLACKLISTED"){
	$endorsement_disabled = "disabled";
}else{
	$endorsement_disabled = "";
}

/*$test = skills_test::getInstance();
$test_taken = $test->user_test_count_score($userid);
$smarty->assign('test_taken', $test_taken);*/

Users::$dbase = $db;
$user_obj = new Users( array('', 'jobseeker', $userid) );
// added the p.email to where clause (2013/12/18)
$test_results = $test_obj->fetchAll("result_uid={$userid} OR result_uid='{$user_obj->user_info['email']}' OR p.email='{$user_obj->user_info['email']}'");
//reconstruct new test_results
$new_test_result = array();
foreach($test_results as $key =>$test_result){
	$new_test_result[$key] = $test_result;
	$new_test_result[$key]['assessment_typing'] = ( strpos( strtolower( $test_result['assessment_title'] ), 'typing' ) !== false ? 1 : 0 ); 
}
$smarty->assign('test_taken', $new_test_result);

$typing = new TypingController(2);
$smarty->assign('typingtest', $typing->user_test_result($userid));

//load character reference
$character_references = $db->fetchAll($db->select()->from("character_references")->where("character_references.userid = ?", $userid));
$smarty->assign("character_references", $character_references);

//load all assigned csro's
$csros = $db->fetchAll($db->select()->from(array("s"=>"subcontractors"), array())
		->joinInner(array("l"=>"leads"), "l.id = s.leads_id", array())
		->joinInner(array("a"=>"admin"), "a.admin_id = l.csro_id",
			 array(new Zend_Db_Expr("CONCAT(a.admin_fname, ' ', a.admin_lname) AS csro")))
		->where("s.userid = ?", $userid)
		->where("s.status = 'ACTIVE'")
		->group("a.admin_id")
		);

if (!empty($csros)){
	if (count($csros)==1){
		$csros = $csros[0]["csro"];
	}else if (count($csros)==2){
		$csros = $csros[0]["csro"]." and ".$csros[1]["csro"];
	}else{
		$tempc = array();
		for($i=0;$i<count($csros)-2;$i++){
			$tempc[] = $csros[$i]["csro"];
		}
		$tempc = implode(", ", $tempc);
		$csros = $tempc ." and ".$csros[count($csros)-1]["csro"];
	}
	
}else{
	$csros = "";
}
if (TEST){
	file_get_contents("http://devs.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);		
}else if(STAGING){
	file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
}else{
	file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
}

require_once "classes/ResumeDetector.php";
$detector = new ResumeDetector($db);
$matches = $detector->detectMatch($userid);

//$matches = array();
if (!empty($matches)){
	$smarty->assign("hasMatch", true);
	$smarty->assign("matches", $matches);
}else{
	$smarty->assign("hasMatch", false);
	$smarty->assign("matches", $matches);	
}


//last login
$last_login = $db->fetchRow($db->select()->from("personal_user_logins")->where("userid = ?", $userid));
if ($last_login){
	$last_login = new Zend_Date($last_login["last_login"], 'YYYY-MM-dd HH:mm:ss');
	$smarty->assign("last_login",$last_login);
	
}

$interview_schedules = $db->fetchAll($db->select()->from("jobseeker_preferred_interview_schedules")->where("userid = ?", $userid));
$interview_schedule = "";
$date_interview_schedule = "";
$time_interview_schedule = "";
$preferred_method_interview = array();
foreach($interview_schedules as $interview){
	$date_interview_schedule = $interview["date_interview"];
	$time_interview_schedule = $interview["time_interview"];
	if ($interview["interview_type"]=="phone"){
		$preferred_method_interview[] = "mobile";
	}else{
		$preferred_method_interview[] = $interview["interview_type"];
	}
}
$interview_schedule = $date_interview_schedule." ".$time_interview_schedule." - ".implode(", ", $preferred_method_interview);

/* WORKING MODEL START */
$working_model_sql = $db->select()
						->from('personal_working_model')
						->where('userid=?',$userid);
$working_model = $db->fetchRow($working_model_sql);
if($working_model){
	$working_model_value = $working_model['working_model'];
}else{
	$working_model_value = 'home_based';
}
$smarty->assign('working_model_value',$working_model_value);
/* WORKING MODEL END */

$smarty->assign("interview_schedule", $interview_schedule);

$smarty->assign("feedback_endorsement", $feedback_endorsement);
$smarty->assign("feedback_shortlist", $feedback_shortlist);
$smarty->assign("csros", $csros);
$smarty->assign("feedbacks", $feedbacks);
$smarty->assign("work_status", $work_status);
$smarty->assign("staff_admin_fullname", $staff_admin_fullname);
$smarty->assign('is_prescreened_disabled', $is_prescreened_disabled);
$smarty->assign('inactive_disabled', $inactive_disabled);
$smarty->assign('endorsement_disabled', $endorsement_disabled);

$smarty->assign("shortlist_history", $shortlist_history);
$smarty->assign('alt_email', $alt_email);
$smarty->assign('inactive_current_status', $inactive_current_status);
$smarty->assign('csro_staff_files_counter', $csro_staff_files_counter);
$smarty->assign('desc', $desc);
$smarty->assign('userid', $userid);
$smarty->assign('agent_no', $agent_no);
$smarty->assign('mode', $mode);
$smarty->assign('hid', $hid);
$smarty->assign("hasActive", $hasActive);
$smarty->assign('fname', $fname);
$smarty->assign('lname', $lname);
$smarty->assign('email', $email);
$smarty->assign('registered_email', $registered_email);
$smarty->assign('alt_email', $alt_email);
$smarty->assign('page_type', "popup");
$smarty->assign('staff_name', $staff_name);
$smarty->assign('transaction_result', $transaction_result);
$smarty->assign('staff_voice_file', $staff_voice_file);
$smarty->assign('staff_files_counter', $staff_files_counter);
$smarty->assign('staff_photo', $staff_photo);
$smarty->assign('dateapplied', $dateapplied);
$smarty->assign('dateupdated', $dateupdated);
$smarty->assign('latest_job_title', $latest_job_title);
$smarty->assign('availability', $availability);
$smarty->assign('experienced', $experienced);
$smarty->assign('hot', $hot);
$smarty->assign('staff_recruiter_stamp', $staff_recruiter_stamp);
$smarty->assign('applicant_status_report_counter', $applicant_status_report_counter);
$smarty->assign('staff_samples_counter', $staff_samples_counter);
$smarty->assign('applicant_no_show_counter', $applicant_no_show_counter);
$smarty->assign('staff_resume_up_to_date_counter', $staff_resume_up_to_date_counter);
$smarty->assign('admin_id', $_SESSION['admin_id']);
$smarty->assign('asl_interview_counter', $asl_interview_counter);
$smarty->assign('pull_time_rate_dropdown', $pull_time_rate_dropdown);
$smarty->assign('part_time_rate_dropdown', $part_time_rate_dropdown);
if ($byear&&$bmonth&&$bday){
	$diff = abs(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d", strtotime($byear."-".$bmonth."-".$bday))));
	$years = floor($diff / (365*60*60*24));
	$smarty->assign('yr_byear',  $years);	
}else{
	$smarty->assign('yr_byear',  "0");
}

$smarty->assign('nationality', $nationality);
$smarty->assign('auth_no_type_id', $auth_no_type_id);
$smarty->assign('msia_new_ic_no', $msia_new_ic_no);
$smarty->assign('residence', $residence);
$smarty->assign('bmonth', $bmonth);
$smarty->assign('bday', $bday);
$smarty->assign('byear', $byear);
$smarty->assign('gender', $gender);
$smarty->assign('address', $address);
$smarty->assign('address2', $address2);

$smarty->assign('tel', $tel);
$smarty->assign('cell', $cell);
$smarty->assign('email', $email);
$smarty->assign('initial_email_password', $initial_email_password);
$smarty->assign('skype_id', $skype_id);
//load all work skype
$skypes = $db->fetchAll($db->select()->from(array("s_skype"=>"staff_skypes"))->where("userid = ?", $userid));
$smarty->assign("work_skypes", $skypes);
$smarty->assign('initial_skype_password', $initial_skype_password);
$smarty->assign('message', $message);
$smarty->assign('level', $level);
$smarty->assign('field', $field);
$smarty->assign('major', $major);
$smarty->assign('school', $school);
$smarty->assign('loc', $loc);
$smarty->assign('month', $month);
$smarty->assign('year', $year);

$smarty->assign('languages_listings', $languages_listings);
$smarty->assign('skill_listings', $skill_listings);

$smarty->assign('company', $company);
$smarty->assign('position', $position1);
$smarty->assign('period', $period);
$smarty->assign('duties', $duties);

$smarty->assign('company2', $company2);
$smarty->assign('position2', $position2);
$smarty->assign('period2', $period2);
$smarty->assign('duties2', $duties2);

$smarty->assign('company3', $company3);
$smarty->assign('position3', $position3);
$smarty->assign('period3', $period3);
$smarty->assign('duties3', $duties3);

$smarty->assign('company4', $company4);
$smarty->assign('position4', $position4);
$smarty->assign('period4', $period4);
$smarty->assign('duties4', $duties4);

$smarty->assign('company5', $company5);
$smarty->assign('position5', $position5);
$smarty->assign('period5', $period5);
$smarty->assign('duties5', $duties5);

$smarty->assign('company6', $company6);
$smarty->assign('position6', $position6);
$smarty->assign('period6', $period6);
$smarty->assign('duties6', $duties6);

$smarty->assign('company7', $company7);
$smarty->assign('position7', $position7);
$smarty->assign('period7', $period7);
$smarty->assign('duties7', $duties7);

$smarty->assign('company8', $company8);
$smarty->assign('position8', $position8);
$smarty->assign('period8', $period8);
$smarty->assign('duties8', $duties8);

$smarty->assign('company9', $company9);
$smarty->assign('position9', $position9);
$smarty->assign('period9', $period9);
$smarty->assign('duties9', $duties9);

$smarty->assign('company10', $company10);
$smarty->assign('position10', $position10);
$smarty->assign('period10', $period10);
$smarty->assign('duties10', $duties10);


//salary grade
$salary_grades = $db->fetchAll($db->select()->from("previous_job_salary_grades")->where("userid = ?", $userid));
foreach($salary_grades as $key=>$salary_grade){
	$smarty->assign("starting_grade_".$salary_grade["index"], $salary_grade["starting_grade"]);
	$smarty->assign("ending_grade_".$salary_grade["index"], $salary_grade["ending_grade"]);
	$smarty->assign("benefits_".$salary_grade["index"], $salary_grade["benefits"]);
}

//work types
$job_industries = $db->fetchAll($db->select()->from("previous_job_industries")->where("userid = ?", $userid));
foreach($job_industries as $key=>$job_industry){
	$smarty->assign("work_setup_type_".$job_industry["index"], $job_industry["work_setup_type"]);
	if ($job_industry["industry_id"]){
		$industry = $db->fetchOne($db->select()->from("defined_industries", array("value"))->where("id = ?", $job_industry["industry_id"]));
		$smarty->assign("industry_".$job_industry["index"], $industry);
		$smarty->assign("industry_id_".$job_industry["index"], $job_industry["industry_id"]);
		$smarty->assign("campaign_".$job_industry["index"], $job_industry["campaign"]);
	}
}



$smarty->assign('mess', $mess);
$smarty->assign('str', $str);
$smarty->assign('currency', $currency);
$smarty->assign('salary', $salary);
$smarty->assign('neg', $neg);
$smarty->assign('asl_categories', $asl_categories);
$smarty->assign('endorsement_history', $endorsement_history);

$smarty->assign('nick_name',$staff_nickname);
$smarty->assign('marital_status',$marital_status);	
$smarty->assign('no_of_kids',$no_of_kids);
$smarty->assign('pregnant',$pregnant);
$smarty->assign('dmonth',$dmonth);
$smarty->assign('dday',$dday);
$smarty->assign('dyear',$dyear);
$smarty->assign('pending_visa_application',$pending_visa_application);
$smarty->assign('active_visa',$active_visa);
$smarty->assign('external_source',$external_source);
$smarty->assign('referred_by',$referred_by);
$smarty->assign('position_first_choice',$position_first_choice);
$smarty->assign('position_first_choice_exp',$position_first_choice_exp);
$smarty->assign('position_second_choice',$position_second_choice);
$smarty->assign('position_second_choice_exp',$position_second_choice_exp);
$smarty->assign('position_third_choice',$position_third_choice);
$smarty->assign('position_third_choice_exp',$position_third_choice_exp);

$smarty->assign('rs_employment_history', $rs_employment_history);
$smarty->assign('relevant_industry_experience', $relevant_industry_experience);
$smarty->assign('admin_report', $admin_report);
$smarty->assign('recruiter_report', $recruiter_report);
$smarty->assign('evaulation_report', $evaulation_report);
$smarty->assign('evaulation_report_tab', $evaulation_report_tab);

$smarty->assign('history_logs_report', $history_logs_report);


$smarty->assign('home_working_environment',$home_working_environment);
$smarty->assign('work_from_home_before',$work_from_home_before);
$smarty->assign('start_worked_from_home',$start_worked_from_home);
$smarty->assign('has_baby',$has_baby);
$smarty->assign('main_caregiver',$main_caregiver);
$smarty->assign('reason_to_wfh',$reason_to_wfh);
$smarty->assign('timespan',$timespan);
	
$smarty->assign('internet_connection',$internet_connection);

$speed_test = "<a href='$speed_test' target='_blank'>{$speed_test}</a>";
$smarty->assign('speed_test',$speed_test);
	
$smarty->assign('isp',$isp);
$smarty->assign('computer_hardware2',$computer_hardware2);
$smarty->assign('internet_consequences',$internet_consequences);
$smarty->assign('noise_level' , $noise_level);
$smarty->assign('trainings',$trainings);
$smarty->assign('licence_cert',$licence_cert);

$smarty->assign('current_status',$current_status);
$smarty->assign('years_worked',$years_worked);
$smarty->assign('months_worked',$months_worked);
$smarty->assign("english_communication_skill", $english_communication_skill);
$smarty->assign('msn_id',$msn_id);
$smarty->assign('yahoo_id',$yahoo_id);
$smarty->assign('icq_id',$icq_id);
$smarty->assign('linked_in',$linked_in);
$smarty->assign("promotional_code", $promotional_code);
$smarty->assign("jobapplications", $jobapplication);


//check if has contract
$pers = $db->fetchRow($db->select()->from(array("pers"=>"personal"), array("email", "alt_email"))->where("userid = ?", $userid));
$subs = $db->fetchAll($db->select()->from("subcontractors")->where("userid = ?", $userid)->where("status IN ('ACTIVE', 'suspended')"));		
if (!empty($subs)){
	$email = $pers["email"];
	$alt_email = $pers["alt_email"];
	$staff_email = array();
	$staff_skype_ids = array();
	foreach($subs as $sub){
		$staff_email[] = $sub["staff_email"];
		$staff_skype_ids[] = $sub["skype_id"];
	}
	$smarty->assign("email", $email);
	$smarty->assign("alt_email", $alt_email);
	$smarty->assign("staff_email", $staff_email);
	$smarty->assign("staff_skype_ids", $staff_skype_ids);
	
}else{
	$email = $pers["email"];
	$alt_email = $pers["alt_email"];
	$staff_email = "";
	$staff_email = array();
	$smarty->assign("email", $email);
	$smarty->assign("alt_email", $alt_email);
	$smarty->assign("staff_email", $staff_email);
	$smarty->assign("staff_skype_ids", array());
	
}




//temporary fix for 90 day check
$count = $db->fetchOne($db->select()->from("personal_auto_sent_autoresponders", array(new Zend_Db_Expr("COUNT(*) AS count")))->where("userid = ?", $userid)->where("type = ?", "ASL_CHECK")->where("responded = 0"));
if (TEST){
	$staff_admin_id = $_SESSION["admin_id"];
}
if ($count>=10&&$_SESSION["admin_id"]==$staff_admin_id){
	$code =  $db->fetchRow($db->select()->from("personal_auto_sent_autoresponders", array("mass_responder_code"))->where("userid = ?", $userid)->where("type = ?", "ASL_CHECK")->where("responded = 0"));
	if ($code["mass_responder_code"]){
		$smarty->assign("ninety_day_code", $code["mass_responder_code"]);
	}else{
		$smarty->assign("ninety_day_code", "");
	}

}else{
	$smarty->assign("ninety_day_code", "");
}


//load preferred tasks
$sub_categories = $db->fetchAll($db->select()->from(array("pt"=>"personal_task_preferences"), array())->joinLeft(array("jst"=>"job_position_skills_tasks"), "jst.id = pt.task_id", array("sub_category_id"))->where("pt.userid = ?", $userid)->group("jst.sub_category_id"));
foreach($sub_categories as $key=>$subcategory){
	if (!$subcategory["sub_category_id"]){
		continue;
	}
	$sub_category_name = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $subcategory["sub_category_id"]));
	$sub_categories[$key]["sub_category_name"] = $sub_category_name;	
	$tasks = $db->fetchAll($db->select()->from(array("pt"=>"personal_task_preferences"))->joinLeft(array("jst"=>"job_position_skills_tasks"), "jst.id = pt.task_id", array("jst.value AS task_desc"))->where("pt.userid = ?", $userid)->where("jst.sub_category_id = ?", $subcategory["sub_category_id"]));
	$sub_categories[$key]["tasks"] = $tasks;
}
$smarty->assign("sub_categories", $sub_categories);
$host = $_SERVER['HTTP_HOST'];
$smarty->assign("server_host",$host);
$smarty->assign("TEST", TEST);
$smarty->assign("logged_admin_id", $_SESSION["admin_id"]);
$smarty->display('staff_information.tpl');
