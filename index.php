<?php
//  2012-11-01 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   allowed subcons to login even if their records are suspended, wf 3217
//2012-08-23 Normaneil Macutay <normanm@remotestaff.com.au>
//  - Added Client Managers (sub-account)
//  2011-11-28  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add a ui GET/POST parameter to establish a client login only interface, useful for login managers
//  2010-05-27  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add redirect to https
// 2010-09-06 Michael Lacanilao
//  - Add email session for jobseeker logintype
// 2011-03-29 Normaneil Macutay <normanm@remotestaff.com.au>
//  - Add recruiter checkbox in the admin login form. This will determines if the admin is a Recruiter
// 2012-12-13 Michael Lacanilao
//  - Added client type to $_SESSION
include('conf/zend_smarty_conf.php');

// trialbased config file - 2011-06-21
include "../adhoc/php/include/as_config.php";

if ($_SERVER['HTTP_HOST'] != 'www.remotestaff.com.ph' && $_SERVER['HTTP_HOST'] != 'sc.remotestaff.com.au' && $_SERVER["HTTP_HOST"] != 'beta.remotestaff.com.au' ) {  //TODO exclude .com.ph site till we wait for the SSL certificate
    if ($_SERVER["HTTP_HOST"]!="staging.remotestaff.com.au"){
    	if (TEST == False && $_SERVER['HTTPS'] != 'on') {
	        $domain = trim($_SERVER['HTTP_HOST'], 'www.');
	        $redirect= "https://".$domain.$_SERVER['REQUEST_URI'];
	        header("Location:$redirect");
	    }
    }
    

}

if ($_SERVER["HTTP_HOST"] == 'remotestaff.com.au' || $_SERVER["HTTP_HOST"] == 'www.remotestaff.com.au'){
    $ip_address = $_SERVER["REMOTE_ADDR"];
    if ($_SERVER["HTTP_X_FORWARDED_FOR"]){
        $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    //echo $ip_address;

    //office IP ADDRESS
    $office_ip = array();
    for($i=0;$i<=255;$i++){
        $office_ip[] = "103.225.38.".$i;
    }

    if (in_array($ip_address, $office_ip)){
        header("Location:http://sc.remotestaff.com.au/portal/");
        exit;
    }
}

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;
$login_type = $_POST['login_type'];
$failed_login_message = Array();
if ($login_type) {
    $password = sha1(trim($_POST['password']));
    $email = trim($_POST['email']);
	
	if( !filter_var($email, FILTER_VALIDATE_EMAIL)) $email .= '@remotestaff.com.au';
	
	$recruiter = $_REQUEST['recruiter'];
	//$trial_client = $_REQUEST['trial_client'];
	$trial_staff = $_REQUEST['trial_staff'];
	$client_type = $_REQUEST['client_type'];
	
	if(isset($_POST["is_v2"])){
		$_SESSION["is_v2"] = true;
	}
	
    
    $_SESSION['logintype'] = $login_type;
	
	if( $client_type ) $_SESSION['clienttype'] = $client_type;

    switch ($login_type) {
        case "jobseeker":
            $sql = $db->select()
                    ->from('personal', 'userid')
                    ->where('email = ?', $email)
                    ->where('pass = ?', $password);
            $userid = $db->fetchOne($sql);
            if ($userid) {
                $_SESSION['userid'] = $userid;
                $_SESSION['emailaddr'] = $email;
                $login = $db->fetchRow($db->select()->from("personal_user_logins")->where("userid = ?", $userid));
				if ($login){
					$db->update("personal_user_logins", array("last_login"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));			
				}else{
					$db->insert("personal_user_logins", array("last_login"=>date("Y-m-d H:i:s"), "userid"=>$userid));			
					
				}
				//header("Refresh:3; url=applicantHome.php");
				
               	//header("Location:applicantHome.php");
               	
               	if(!isset($_POST["is_v2"])){
					header("Location:applicantHome.php");
					exit;
				}
				header("Location:/portal/v2/secure/login");
                exit;
            }
            else {
                $failed_login_message[$login_type] = 'Email / Password does not match!';
            }
            break;

        case "staff":
		    if($trial_staff){
			    $service_type = 'trial_based';
				$user = new as_staff( array(0, $email) );
				$user->login( $email, trim($_POST['password']) );
				
				if( $user->error) $failed_login_message[$login_type] = $user->error;
				else {
					$_SESSION['service_type'] = $service_type;
					header("Location: /adhoc/php/staff/as_staff.php?service_type={$service_type}");
					exit;
				}
			}else{
			
				$sql = $db->select()
						->from('personal', 'userid')
						->where('email = ?', $email)
						->where('pass = ?', $password);
				$userid = $db->fetchOne($sql);
				if ($userid) {
					//check if it has an existing contract
					$sql = $db->select()
							->from('subcontractors', 'id')
							->where('userid = ?', $userid)
							->where('status in ("ACTIVE", "suspended")');
					$subcontracts = $db->fetchAll($sql);
					if (count($subcontracts) == 0) {
						$failed_login_message[$login_type] = 'Email / Password does not match!';
					}
					else {
						$_SESSION['userid'] = $userid;
						$_SESSION['emailaddr'] = $email;
						$login = $db->fetchRow($db->select()->from("personal_user_logins")->where("userid = ?", $userid));
						if ($login){
							$db->update("personal_user_logins", array("last_login"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));			
						}else{
							$db->insert("personal_user_logins", array("last_login"=>date("Y-m-d H:i:s"), "userid"=>$userid));			
							
						}
						//header("Refresh:1; url=subconHome.php");
						//header("Location:subconHome.php");
						if(!isset($_POST["is_v2"])){
							header("Location:subconHome.php");
							exit;
						}
						header("Location:/portal/v2/secure/login");
						exit;
					}
				}
				else {
					$failed_login_message[$login_type] = 'Email / Password does not match!';
				}
			}	
            break;

        case "business_partner":
            $sql = $db->select()
                    ->from('agent', 'agent_no')
                    ->where('email = ?', $email)
                    ->where('agent_password = ?', $password)
                    ->where('status = "ACTIVE"')
                    ->where('work_status = "BP"');
            $agent_no = $db->fetchOne($sql);
            if ($agent_no) {
                $_SESSION['agent_no'] = $agent_no;
                $_SESSION['emailaddr'] = $email;
				if(!isset($_POST["is_v2"])){
					header("Location:agentHome.php");
					exit;
				}
                header("Location:/portal/v2/secure/login");
                //header("Location:agentHome.php");
                exit;
            }
            else {
                $failed_login_message[$login_type] = 'Email / Password does not match!';
            }
            break;

        case "admin":
        	
			
			if($_POST["is_v2"]){
					
				
				$sql = $db->select()
					->from("admin_department", array("admin_id", "department_id", "is_head"))
					->joinLeft("admin", "admin.admin_id = admin_department.admin_id", array("admin_fname", "admin_lname", "userid", "email" => "admin_email", "status"))
					->joinLeft("personal", "personal.userid = admin.userid", array("image"))
					->joinLeft("department", "department.department_id = admin_department.department_id", array("department_name"))
					->joinLeft("department_slug_lookup", "department_slug_lookup.department_id = admin_department.department_id", array("url"))
					->where("admin.status != 'REMOVED'")
					->where("admin.admin_email = ?", $email)
					->where("admin.admin_password = ?", $password);
					
				$admin = $db->fetchRow($sql);
				
				
				if(!empty($admin)){
					
					$_SESSION['admin_id'] = $admin['admin_id']; 
	                $_SESSION['status'] = $admin['status'];
	                $_SESSION['emailaddr'] = $email;
	                $_SESSION['is_head'] = $admin["is_head"];
					$_SESSION['department_id'] = $admin["department_id"];
					$_SESSION['department_name'] = $admin["department_name"];
					$_SESSION['slug'] = $admin['url'];
					
					
					$details = "LOGIN DETAILS # EMAIL : ".$email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
					$logger_admin_login->info("$details");
					
					$location = "Location:/portal/v2/" . $admin["url"] . "/";
					header("Location:/portal/v2/secure/login");
					/*
					if($admin["is_head"]){
						$location .= "head-dashboard/";
						header($location);
					} else{
						$location .= "dashboard/";
						header($location);
					}
					*/ 
					
					exit;
				} else{
					$details = "FAILED LOGIN DETAILS # EMAIL : ".$email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
					$logger_admin_login->info("$details");
					$failed_login_message[$login_type] = $error_msg;
				}
				
			} else{
				if($recruiter){
					$sql = $db->select()
							->from('admin')
							->where('admin_email = ?', $email)
							->where('admin_password = ?', $password)
							->where('status = "HR"');
					//if (SERVER_NAME=="NEW_PRODUCTION"){
					if (SERVER_NAME=="NEW_PRODUCTION" && !preg_match('/^test./', $_SERVER['HTTP_HOST'], $match)){
						$sql->where("admin_id IN (SELECT admin_id FROM admin_whitelist)");	
					}
					$error_msg = 'Email / Password does not match for Recruiter!';	
					
					
						
				}else{
				
					 $sql = $db->select()
	                    ->from('admin')
	                    ->where('admin_email = ?', $email)
	                    ->where('admin_password = ?', $password)
						->where('status != "HR"')
	                    ->where('status != "PENDING"')
	                    ->where('status != "REMOVED"');
					//if (SERVER_NAME=="NEW_PRODUCTION"){
					if (SERVER_NAME=="NEW_PRODUCTION" && !preg_match('/^test./', $_SERVER['HTTP_HOST'], $match)){
						$sql->where("admin_id IN (SELECT admin_id FROM admin_whitelist)");	
					}
					 $error_msg = 'Email / Password does not match!';	
				}	
				//echo $sql;exit;	
	            $result = $db->fetchAll($sql);
	            if ($result) {
	                $_SESSION['admin_id'] = $result[0]['admin_id']; 
	                $_SESSION['status'] = $result[0]['status'];
	                $_SESSION['emailaddr'] = $email;
	                $details = "LOGIN DETAILS # EMAIL : ".$email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
	                $logger_admin_login->info("$details");
					if($recruiter){
						header("Location:/portal/recruiter/recruiter_home.php");
					}else{
						header("Location:adminHome.php");
					}
	                exit;
	            }
	            else {
	                $details = "FAILED LOGIN DETAILS # EMAIL : ".$email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
	                $logger_admin_login->info("$details");
	                $failed_login_message[$login_type] = $error_msg;
	            }
			}
			
            break;

        case "client":
		    //echo $client_type;exit;
		    if($client_type == 'trial_client'){
			    $service_type = 'trial_based';
                $user = new as_client(0, $email);
                $user->login( $email, trim($_POST['password']) );
            
                if( $user->error) $failed_login_message[$login_type] = $user->error;
			    else {
				    $_SESSION['service_type'] = $service_type;
				    header("Location: /adhoc/php/client/as_client.php?service_type={$service_type}");
				    exit;
			    }
			}else if($client_type == 'manager'){
				$sql =$db->select()
				    ->from('client_managers')
					->where('email =?', $email)
					->where('password = ?', $password)
					->where('status = "active"');
				$result = $db->fetchRow($sql);
				if($result){
					//echo $result['id'];exit;
					#$_SESSION['client_id'] = $result['leads_id'];
                    $_SESSION['manager_id'] = $result['id'];
					$_SESSION['client_id'] = $result['leads_id'];
					$_SESSION['emailaddr'] = $email;
					if(!isset($_POST["is_v2"])){
						header("Location:/portal/django/Manager/");
						exit;
					}
					header("Location:/portal/v2/secure/login");
                    //header("Location:/portal/django/Manager/");
                    exit;
				}else{
					 $failed_login_message[$login_type] = 'Email / Password does not match!';
				}
			}else{
                /*
				$sql = $db->select()
                    ->from('leads')
                    ->where('email = ?', $email)
                    ->where('password = ?', $password)
                    ->where('status = "Client"');
				*/
				$sql="SELECT id, email FROM leads l WHERE l.email='".$email."' AND l.password='".$password."' AND l.status not in('deleted', 'REMOVED', 'transferred');";
				//echo $sql;exit;
                $result = $db->fetchAll($sql);
			
                if ($result) {
                    $_SESSION['client_id'] = $result[0]['id'];
                    $_SESSION['emailaddr'] = $email;
                    $_SESSION['filled_up_visible'] = 0;
					require_once('lib/client_logs.php');
					if(!isset($_POST["is_v2"])){
						header("Location:clientHome.php");
						exit;
					}
					header("Location:/portal/v2/secure/login");
                    //header("Location:clientHome.php");
                    exit;
                }
                else {
                    $failed_login_message[$login_type] = 'Email / Password does not match!';
                }
			}
            break;

        case "referral_partner":
            $sql = $db->select()
                    ->from('agent')
                    ->where('email = ?', $email)
                    ->where('agent_password = ?', $password)
                    ->where('status = "ACTIVE"')
                    ->where('work_status = "AFF"');
            $result = $db->fetchAll($sql);
            if ($result) {
                $_SESSION['agent_no'] =$result[0]['agent_no'];
				if(!isset($_POST["is_v2"])){
					header("Location:affHome.php");
					exit;
				}
				header("Location:/portal/v2/secure/login");
				
                //header("Location:affHome.php");
                exit;
            }
            else {
                $failed_login_message[$login_type] = 'Email / Password does not match!';
            }
            break;
    }
}





$page = basename($_SERVER['SCRIPT_FILENAME']);
$location_id = LOCATION_ID;
if($location_id !=""){
	
	$active_image_array = array(
				'1' => 'remote-staff-country-active-AUS.jpg' , 
				'2' => 'remote-staff-country-active-UK.jpg' , 
				'6' => 'remote-staff-country-active-US.jpg',
				'4' => 'remote-staff-country-active-PH.jpg',
				'5' => 'remote-staff-country-active-IN.jpg'
			);

	$inactive_image_array = array(
			'1' => 'remote-staff-country-inactive-AUS.jpg' , 
			'2' => 'remote-staff-country-inactive-UK.jpg' , 
			'6' => 'remote-staff-country-inactive-US.jpg',
			'4' => 'remote-staff-country-inactive-PH.jpg',
			'5' => 'remote-staff-country-inactive-IN.jpg'
		);		
	
	$sql = $db->select()
		->from('leads_location_lookup');
	$urls = $db->fetchAll($sql);	
	
	foreach($urls as $url){
		if( !isset($active_image_array[ $url['id'] ]) ) continue;
		   
		if($url['id'] == $location_id){
			$img_result.="<img src='images/".$active_image_array[$url['id']]."' border='0'>";
		}else{
			if($url['id'] == 4){
				$img_result.='<a href="http://'.$url['location'].'/portal/"><img border="0" onmouseout=this.src="images/'.$inactive_image_array[$url['id']].'" onmouseover=this.src="images/'.$active_image_array[$url['id']].'" src="images/'.$inactive_image_array[4].'"></a>';
			}else{
				$img_result.='<a href="http://'.$url['location'].'/portal/'.$page.'"><img border="0" onmouseout=this.src="images/'.$inactive_image_array[$url['id']].'" onmouseover=this.src="images/'.$active_image_array[$url['id']].'" src="images/'.$inactive_image_array[$url['id']].'"></a>';

			}
		}
	}
	
}else{
	$img_result = '<img src="images/remote-staff-country-inactive-AUS.jpg" /><img src="images/remote-staff-country-inactive-US.jpg" /><img src="images/remote-staff-country-inactive-UK.jpg" /><img src="images/remote-staff-country-inactive-PH.jpg" />
';
}
$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $email ), 2, 17 );

$smarty->assign('hash' , $hash_code);
$smarty->assign('img_result' , $img_result);
$smarty->assign('failed_login_message', $failed_login_message);
$smarty->assign('body_attributes', 'id="loginx" class="sub-bg"');
$smarty->assign('stylesheets', Array('./css/index.css', './css/login.css'));
$smarty->assign('javascripts', Array('./js/jquery.tools.min.js','./js/login.js'));

$ui = $_REQUEST['ui'];

session_destroy();
UNSET($_SESSION);

//echo "<pre>";
//print_r($_SESSION);
//die;

//header("Location:/portal/v2/secure/login");

if ($ui == 'client') {
    $smarty->display('client_login.tpl');
}
else {
    $smarty->display('index.tpl');
}

?>
