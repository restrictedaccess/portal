<?php

/* $Id: forgotpass.php 1 2010-01-11 mike lacanilao $ */
// 2010-01-14 - mike
//  fixed case-sensitive for directory path (for unix)
//  from email body - replaced the hardcoded hostname into HTTP_HOST var
// 2010-01-15 mike l. <mike.lacanilao@remotestaff.com.au>
//   - changed the header 'from' to noreply.
//   - remaining hostname string replaced with HTTP_HOST for flexibility
// 2010-02-03
//  - enabled affiliate password retrieval
// 2013-10-02 - replace the hardcoded sql query with zend db select() to handle sanitation
$page = "forgotpass";

require_once('./conf/zend_smarty_conf.php');
require_once('./lib/misc_functions.php');
require('./tools/CouchDBMailbox.php');

// SET ERROR REPORTING
//error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', FALSE);

$smarty = new Smarty();

// set the templates dir.
$smarty->template_dir = "./templates";

// just to make sure compiling dir is available
if (!is_dir("./lib/Smarty/libs/template_c")) mkdir("./lib/Smarty/libs/template_c");

$smarty->compile_dir = "./lib/Smarty/libs/template_c";

// get the task item
$task = getVar("task", "main");

$user = getVar("user");


// SET ERROR VARS
$is_error = '';
$submitted = 0;

$user_email = '';

if($task == "send_email") {
  
  $user_email = trim($_POST['email']);
  
  if (!$user_email) {
     $is_error = 'Email address is required, please try again.';
  
  } else {
    
      // define each tables
      $usertype_table = array('admin'=>'admin', 'client'=>'leads', 'agent'=>'agent',
        'applicant'=>'personal', 'subcon'=>'personal','affiliate'=>'agent', 'trial'=>'leads', 'manager' => 'client_managers');
        
      if ($user == 'admin') {
        //$sql = "SELECT admin_fname, admin_lname FROM admin WHERE admin_email='$user_email'";
        $row = $db->fetchRow( $db->select()->from('admin', array('admin_fname', 'admin_lname'))->where('admin_email=?',$user_email) );
        $name =$row['admin_fname']." ".$row['admin_lname'];
        
        $tblname = 'admin';
        
      } else {
        $tblname = 'admin';
        //$sql = "SELECT fname, lname FROM ". $usertype_table[$user]." WHERE email='$user_email'";
		$sql = $db->select()->from($usertype_table[$user], array('fname', 'lname'))->where('email=?',$user_email);
        
        // define here specific users conditions
        switch( $user ) {
          case 'client':
		  case 'trial':
            //$sql .= " AND status ='Client'";
            $sql->where('status != ?', 'Inactive')->where('status != ?', 'REMOVED');
            break;
          case 'affiliate':
            //$sql .= " AND work_status ='AFF'";
			$sql->where('work_status = ?', 'AFF');
            break;
          //case 'trial':
          //  $sql .= " AND status <> 'Inactive' AND status <> 'REMOVED'";
          //  break;
		  case 'manager':
            //$sql .= " AND status <> 'removed'";
			$sql->where('status = ?', 'active');
            break;	
        }
        /*if ($user == 'client') $sql .= " AND status ='Client'";
        elseif ($user == 'affiliate') $sql .= " AND work_status ='AFF'";*/
        
        $tblname = $usertype_table[$user];
          
        $row = $db->fetchRow($sql);
        $name =$row['fname']." ".$row['lname'];
      }
      
      
      if ($row) {
      
          $forgotpass_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $user_email ), 2, 14 );
          $forgotpass_time = time();
          $subject = 'REMOTESTAFF: Reset Password Request';
          // HEADER
          $from ="noreply@remotestaff.com.au";
          $header  = 'MIME-Version: 1.0' . "\r\n";
          $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $header .= "From: ".$from." \r\n".
                     "Reply-To: ".$from."\r\n".
                     "X-Mailer: PHP/".phpversion();
                    
          // BODY
          $message =
            "<div style='background:#F4F4F4; height:174px;'>
              <div style='background:#FFFFFF; margin-top:10px; margin-bottom:10px;margin-right:10px;'>
                <p style='margin-right:5px; margin-top:10px;padding:5px;font-family:Tahoma; font-size:13px;' >      
                
                Hi  ".$name." ,<br /> <br />
                Someone filled out the retrieve password form for you on ". $_SERVER['HTTP_HOST'] ." website. <br />
                You can just ignore this email if it's not you, and your password will remain unchanged. <br /><br />
                You can continue on to setting a new password by going to:<br />
                <a href='http://".$_SERVER['HTTP_HOST'] ."/portal/forgotpass_reset.php?k=". $forgotpass_code ."' target='_blank'>http://".$_SERVER['HTTP_HOST'] ."/portal/forgotpass_reset.php?k=". $forgotpass_code .
                "</a><br /><br />
                You have 24 hours from when this request was initiated to change your password <br /><br />
                Requested by: ". $_SERVER['REMOTE_ADDR'] ." <br /><br /><br />
              
                Best Regards,<br />
                info@remotestaff.com.au
                </p>
              </div>
          </div>";
   
        $submitted = 1;
        if (TEST) $sendto_email = 'devs@remotestaff.com.au';
        else $sendto_email = $user_email;
        
            $to_array=array($sendto_email);
            SaveToCouchDBMailbox(NULL, NULL, NULL, $from, $message, $subject, $text, $to_array, $sender=NULL, $reply_to=NULL);
        
        
        
            $sql = "INSERT INTO user_common_request (email, resetpassword_code, resetpassword_time, ref_table, ip_address) "
              . "VALUES ('$user_email', '$forgotpass_code', '$forgotpass_time', '"
              . $tblname ."', '". $_SERVER['REMOTE_ADDR'] ."')";
         
            if(!$db->query($sql)){
            $is_error = 'Sending email failed, please try again';
            } 
      }
      else 
    
        $is_error = 'Email does not exist or inactive account.';
  
  } 
      
}

// ASSIGN VARIABLES 
$smarty->assign('is_error', $is_error);
$smarty->assign('submitted', $submitted);
$smarty->assign('sbox', '1');
$smarty->assign('user', $user);
$smarty->assign('user_email', $user_email);
$smarty->display($page.".tpl");
?>