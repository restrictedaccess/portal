<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Session expires. Please re-login");
}

$sql = "SELECT * FROM admin WHERE admin_id=".$_SESSION['admin_id'];
$admin = $db->fetchRow($sql);

$admin_id = $_REQUEST['admin_id'];

$query="SELECT * FROM admin WHERE admin_id=$admin_id;";
$result = $db->fetchRow($query);
$name = $result['admin_fname']." ".$result['admin_lname'];
//echo $name;exit;


$data = array('status' => 'REMOVED');
$where = "admin_id = ".$admin_id;	
$db->update('admin', $data , $where);

$changes = "Admin access removed.";
$data = array(
    'admin_id' => $admin_id, 
	'changes' => $changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changes' => $ATZ
);
$db->insert('admin_history', $data);

$sql=$db->select()
    ->from('recruitment_team_member', 'team_id')
	->where('admin_id =?', $admin_id);
$team_id = $db->fetchOne($sql);	
if($team_id != ""){
	$sql=$db->select()
        ->from('recruitment_team', 'team')
	    ->where('id =?', $team_id);
    $team = $db->fetchOne($sql);
	
	$where = "team_id =".$team_id." AND admin_id=".$admin_id;
	$db->delete('recruitment_team_member',$where);
	
	$changes = sprintf('Removed from [%s] Recruitment Team.', $team);
    $data = array(
        'admin_id' => $admin_id, 
	    'changes' => $changes, 
	    'changed_by_id' => $_SESSION['admin_id'], 
	    'date_changes' => $ATZ
    );
    $db->insert('admin_history', $data);
	
	$history_msg=sprintf('%s removed Admin Access and removed from %s', $name, $team);
	$data = array(
		'team_id' => $team_id, 
		'history' => $history_msg, 
		'date_history' => $ATZ, 
		'admin_id' => $_SESSION['admin_id']
	);
	$db->insert('recruitment_team_history', $data);
}


$recruiterStaff = $db->fetchAll($db->select()->from("recruiter_staff")->where("admin_id = ?", $admin_id));
foreach($recruiterStaff as $staff){
	$data = array();
	$data["recruiter_staff_id"] = $staff["id"];
	$data["former_recruiter_id"] = $staff["admin_id"];
	$data["date_transferred"] = date("Y-m-d h:i:s");
	$data["transfer_type"] = "DELETED";
	$data["admin_id"] = $_SESSION["admin_id"];
	$db->insert("recruiter_staff_transfer_logs", $data);
	$select = "SELECT admin_id,admin_fname,admin_lname 	 
				FROM `admin`
				where (status='HR' 
			OR admin_id='41' 
			OR admin_id='71'
			OR admin_id='78'
			OR admin_id='81')  
			AND status <> 'REMOVED' AND admin_id <> '67' AND admin_id <> '161' ORDER by RAND()";
	$non_deleted_recruiter = $db->fetchRow($select); 
	$db->update("recruiter_staff", array("admin_id"=>$non_deleted_recruiter["admin_id"]), $db->quoteInto("id = ?", $staff["id"]));	
}


$job_order_links = $db->fetchAll($db->select()->from("gs_job_orders_recruiters_links")->where("recruiters_id = ?", $admin_id));
foreach($job_order_links as $job_order_link){
	$data = array();
	$data["job_order_link_id"] = $job_order_link["gs_job_orders_recruiters_link_id"];
	$data["former_recruiter_id"] = $job_order_link["recruiters_id"];
	$data["date_transferred"] = date("Y-m-d h:i:s");
	$data["transfer_type"] = "DELETE";
	$db->insert("job_orders_transfer_logs", $data);
}
$db->update("gs_job_orders_recruiters_links", array("recruiters_id"=>67), $db->quoteInto("recruiters_id = ?", $admin_id));

if ($result["hiring_coordinator"]=="Y"){
	$leads = $db->fetchAll($db->select()->from("leads", array("id", "hiring_coordinator_id"))->where("hiring_coordinator_id = ?", $admin_id));
	foreach($leads as $lead){
		$data = array();
		$data["lead_id"] = $lead["id"];
		$data["former_admin_id"] = $lead["hiring_coordinator_id"];
		$data["date_transferred"] = date("Y-m-d h:i:s");
		$data["transfer_type"] = "DELETE";
		$db->insert("leads_managers_transfer_logs", $data);
	}
	$db->update("leads", array("hiring_coordinator_id"=>134), $db->quoteInto("hiring_coordinator_id = ?", $admin_id));
}

try{
	$retries=0;
	while(true){
		try{
			if (TEST){
				$mongo = new MongoClient(MONGODB_TEST);
				$database = $mongo->selectDB('prod');
			}else{
				$mongo = new MongoClient(MONGODB_SERVER);
				$database = $mongo->selectDB('prod');
			}	
			break;
		}catch(Exception $e){
			++$retries;
			
			if($retries >= 100){
				break;
			}
		}
	}
			

	$recruitment_collection = $database->selectCollection('recruitment');
	$recruitment_collection->remove(array("assigned_recruiter_id"=>$admin_id));
	
	
	if (TEST){
		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php");		
	}else{
		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php");
	}
	
}catch(Exception $e){
	
}

$body = "<p><b>Admin user [ $name ] removed access from Admin Section!</b></p>";
	
	$mail = new Zend_Mail();
	$mail->setBodyHtml($body);
	$mail->setFrom('info@remotestaff.com.au', 'remotestaff');
	$mail->addTo('devs@remotestaff.com.au', 'DEVS');
	//$mail->addCc();// Adds a recipient to the mail with a "Cc" header
	//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	if(!TEST){
	    $mail->setSubject("Admin ".$admin['admin_fname']." removed admin user ".$name);
	}else{
	    $mail->setSubject("TEST Admin ".$admin['admin_fname']." removed admin user ".$name);
	}
	
	$mail->send($transport);

//echo "Admin user [ ".$name." ] removed access from Admin Section!";
//exit;

$smarty->assign('name', $name);
$smarty->assign('admin_id', $admin_id);
$smarty->display('DeleteAdminUsers.tpl');	
?>