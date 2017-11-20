<?php
include('conf/zend_smarty_conf.php');

if (!TEST){
	header('Access-Control-Allow-Origin: http://www.remotestaff.com.au');
}else{
	header('Access-Control-Allow-Origin: *');
}
header("Access-Control-Allow-Credentials: true"); 
header("Access-Control-Allow-Methods: OPTIONS, GET, POST"); 
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
/**
 * Login Script for the Quick Login above the header
 */
include "../adhoc/php/include/as_config.php";
$login_type = $_REQUEST['login_type'];
$failed_login_message = Array();
if ($login_type) {
    $password = trim($_REQUEST['password']);
    $email = trim($_REQUEST['email']);
	$recruiter = $_REQUEST['recruiter'];
	//$trial_client = $_REQUEST['trial_client'];
	$trial_staff = $_REQUEST['trial_staff'];
	$client_type = $_REQUEST['client_type'];
	
    
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
                echo json_encode(array("success"=>true, "location"=>"/portal/applicantHome.php"));				
                exit;
            }
            else {
            	echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   				exit;
            }
            break;

        case "staff":
		    if($trial_staff){
			    $service_type = 'trial_based';
				$user = new as_staff( array(0, $email) );
				$user->login( $email, trim($_REQUEST['password']) );
				
				if( $user->error){
					echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   					exit;
				}else {
					$_SESSION['service_type'] = $service_type;
					echo json_encode(array("success"=>true, "location"=>"/adhoc/php/staff/as_staff.php?service_type={$service_type}"));	
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
						echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   						exit;
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
						echo json_encode(array("success"=>true, "location"=>"/portal/subconHome.php"));	
						exit;
					}
				}
				else {
					echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   					exit;
				}
			}	
            break;

        case "business_developer":
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
				
				//changed value of logintype as per mike
				$_SESSION["logintype"] = "business_partner";
                echo json_encode(array("success"=>true, "location"=>"/portal/agentHome.php"));	
				exit;
            }
            else {
               echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   				exit;
            }
            break;

        case "admin":
			if($recruiter){
				$sql = $db->select()
						->from('admin')
						->where('admin_email = ?', $email)
						->where('admin_password = ?', $password)
						->where('status = "HR"');
				if (SERVER_NAME=="NEW_PRODUCTION"){
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
				if (SERVER_NAME=="NEW_PRODUCTION"){
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
					 echo json_encode(array("success"=>true, "location"=>"/portal/recruiter/recruiter_home.php"));	
				}else{
					echo json_encode(array("success"=>true, "location"=>"/portal/adminHome.php"));	
				}
                exit;
            }
            else {
                $details = "FAILED LOGIN DETAILS # EMAIL : ".$email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
                $logger_admin_login->info("$details");
				echo json_encode(array("success"=>false, "error"=>$error_msg));				
   				exit;
            }
            break;

        case "client":
		    //echo $client_type;exit;
		    if($client_type == 'trial_client'){
			    $service_type = 'trial_based';
                $user = new as_client(0, $email);
                $user->login( $email, trim($_REQUEST['password']) );
            
                if( $user->error){
                	echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   					exit;
                }else {
				    $_SESSION['service_type'] = $service_type;
					echo json_encode(array("success"=>true, "location"=>"/adhoc/php/client/as_client.php?service_type={$service_type}"));	
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
					$_SESSION['client_id'] = $result['leads_id'];;
                    $_SESSION['manager_id'] = $result['id'];
					$_SESSION['emailaddr'] = $email;
					echo json_encode(array("success"=>true, "location"=>"/portal/django/Manager/"));	
                    exit;
				}else{
					echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   					exit;
				}
			}else{
                $sql = $db->select()
                    ->from('leads')
                    ->where('email = ?', $email)
                    ->where('password = ?', $password)
                    ->where("status NOT IN ('deleted', 'REMOVED', 'transferred')");
                $result = $db->fetchAll($sql);
			
                if ($result) {
                    $_SESSION['client_id'] = $result[0]['id'];
                    $_SESSION['emailaddr'] = $email;
					require_once('lib/client_logs.php');
					echo json_encode(array("success"=>true, "location"=>"/portal/clientHome.php"));
                    exit;
                }
                else {
                    echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   					exit;
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
				echo json_encode(array("success"=>true, "location"=>"/portal/affHome.php"));
                exit;
            }
            else {
                echo json_encode(array("success"=>false, "error"=>"Email / Password does not match!"));				
   				exit;
            }
            break;
    }
}

