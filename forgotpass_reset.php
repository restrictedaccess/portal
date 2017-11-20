<?php

/* $Id: forgotpass_reset.php 2010-01-12 - mike $ > header changed :) */
// 2010-02-03
//  - added affiliate to password reset

$page = "forgotpass_reset";
require_once('./conf/zend_smarty_conf.php');
require_once('./lib/misc_functions.php');

require_once dirname(__FILE__)."/lib/Curl.php";




// SET ERROR REPORTING
//error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', FALSE);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$smarty = new Smarty();

// set the templates dir.
$smarty->template_dir = "./templates";

// just to make sure compiling dir is available
if (!is_dir("./lib/Smarty/libs/template_c")) mkdir("./lib/Smarty/libs/template_c");

$smarty->compile_dir = "./lib/Smarty/libs/template_c";

// get the task item
$task = getVar("task", "main");

// get the key
$k = getVar("k");

// DISPLAY PASSWORD REQUEST FORM
$submitted = 0;
$valid = 0;
$is_error = '';
$user_email = 'NULL';
$owner = array();




if (trim($k) != '') {
  // GET USER DATA
  $sql = "SELECT email, resetpassword_code code, resetpassword_time time, ref_table FROM user_common_request "
  . "WHERE resetpassword_code='". trim($k) . "'";
  
  $owner = $db->fetchRow($sql);
}


if ($owner) {
  
  $ref_table = $owner['ref_table'];
  
  // admin table has different fieldname for email address
  if ($ref_table == 'admin') $fldname = 'admin_email'; else $fldname = 'email';
  
  // CHECK IF USER EXIST
  $sql = "SELECT {$fldname} FROM ". $ref_table . " WHERE {$fldname}='". $owner['email'] . "'";
  
  $valid_user = $db->fetchRow($sql);
  
  if (!$valid_user)
    $is_error = 'Error occured: User not found';
  elseif ($owner['time'] < (time()-86400))
    $is_error = 'Error occured: Confirmation code expired already.';
  else $valid = 1;
  
  $user_email = $owner['email'];  
        
} else {
  // RECORD NOT FOUND
  $is_error = 'Error occured: Invalid code.';
}


// LINK IS VALID, RESET PASSWORD
if($task == "reset" && $valid == 1) {

  $user_password = $_POST['user_password'];
  $user_password2 = $_POST['user_password2'];
  
   $submitted = 1;
  
  // CHECK PASSWORD
  $is_error = check_password('', $user_password, $user_password2, 0);
    
  // IF THERE WAS NO ERROR, SAVE CHANGES
  if($is_error == '') {
    
    // we dont have standard in naming the password field, so we'll get them manually
    $pw_fldname = array('admin'=>'admin_password', 'leads'=>'password', 'agent'=>'agent_password', 'personal'=>'pass', 'affiliates'=>'agent_password', 'client_managers'=>'password');
        
    // SAVE NEW PASSWORD
    $sql = "UPDATE ". $ref_table . " SET " . $pw_fldname[$ref_table] . "='" . sha1($user_password). "' "
      . "WHERE {$fldname}='". $owner['email'] . "' LIMIT 1";
      
    $db->query($sql);
    
    // RESET CODE
    $sql = "UPDATE user_common_request SET resetpassword_code='' WHERE resetpassword_code='". trim($k) . "' LIMIT 1";
    $db->query($sql);
    
	global $base_api_url;
	
	global $curl;
		
	$tracking_code = "";
	
	$login_type = "";
	
	
	
	if($ref_table == "agent"){
		$work_status = $db->fetchRow(
			$db->select()
			->from("agent", array("work_status"))
			->where("email = ?", $owner["email"])
		);
		
		$tracking_code = "business_developer_";
		
		$login_type = "business_developer";
		
		if($work_status["work_status"] == "AFF"){
			$tracking_code = "referral_partner_";
			
			$login_type = "referral_partner";
		
		}
		
	} else if($ref_table == "personal"){
		
		$curl->get($base_api_url . "/mongo-index/sync-login-credentials/?tracking_code=subcontractors_" . $owner["email"]. "&email=" . $owner["email"]);
		$tracking_code = "personal_";
		
		$login_type = "jobseeker";
		
	} else if($ref_table == "affiliates"){
		
		$tracking_code = "referral_partner_";
		
		$login_type = "referral_partner";
		
	} else if($ref_table == "client_managers"){
		
		$tracking_code = "client_managers_";
		
		$login_type = "manager";
		
	} else if($ref_table == "leads"){
		
		$tracking_code = "leads_";
		
		$login_type = "leads";
		
	} else if($ref_table == "admin"){
		
		$tracking_code = "admin_";
	
		$login_type = "admin";
		
	}
	
	$email = $owner["email"];
		
	
	//echo $tracking_code;
	if(!empty($login_type)){
		//$curl->get($base_api_url . "/secure/update-reset-password-status/?login_type=" . $login_type . "&email=" . $email);
	}
	
	if($tracking_code != ""){
		$tracking_code .= $owner["email"];
		
		$curl->get($base_api_url . "/mongo-index/sync-login-credentials/?tracking_code=". $tracking_code . "&email=" . $owner["email"] . "&update_reset_password=true");
		
	}
	
	
	//end SYNC login_credentials
	
  } else $valid = 0;
  
} else {
  $submitted = 0;
}

// ASSIGN VARIABLES
$smarty->assign('submitted', $submitted);
$smarty->assign('valid', $valid);
$smarty->assign('is_error', $is_error);
$smarty->assign('user_email', $user_email);
$smarty->assign('k', $k);
$smarty->display($page.".tpl");



?>