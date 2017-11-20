<?php
include('conf/zend_smarty_conf.php');
include './admin_subcon/mq_producer_schedule_prepaid_contract.php';
require_once dirname(__FILE__)."/lib/Curl.php";

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$curl = new Curl();
$ch = $curl->curl;
curl_setopt( $ch, CURLOPT_HEADER, false );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
curl_setopt( $ch, CURLOPT_VERBOSE, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
curl_setopt( $ch, CURLOPT_FAILONERROR, false );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

// SYNC to login_credentials

if($_SESSION['admin_id'] =="" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}


$sql = $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);	 


$status = 'terminated';

if(isset($_POST['convert'])){
    //echo $_POST['client']."<br>";
	
	//exit;
	//update the client.prepaid value
	$data = array('prepaid' => 'yes');	
	$db->update('clients', $data, 'leads_id ='.$_POST['client']);
	//Add history
	$changes = array(
		'leads_id' => $_POST['client'] ,
		'date_change' => $ATZ, 
		'changes' => 'Converted to Prepaid Client', 
		'change_by_id' => $_SESSION['admin_id'], 
		'change_by_type' => 'admin'
	);
	$db->insert('leads_info_history', $changes);
	
	
	$prepaid_staffs = array();
	if($_POST['userids']){
	     //echo count($_POST['userids']);exit;
	     for ($i = 0; $i < count($_POST['userids']); ++$i){
		     //echo $_POST['userids'][$i]." => ";
			 //echo $_POST['cal'][$i]."<br>";
			 $userid = $_POST['userids'][$i];
			 $sql = $db->select()
				->from('subcontractors')
				->where('status =?' , 'ACTIVE')
				->where('prepaid =?', 'no')
				->where('userid =?', $userid)
				->where('leads_id =?', $_POST['client']);
			//echo $sql;	
			$staff = $db->fetchRow($sql);
			
			
			
			$data = array('prepaid_start_date' => $_POST['cal'][$i] );
	        $db->update('subcontractors', $data, 'id ='.$staff['id']);
			
			
			$subcontractors_id = $staff['id'];
			unset($staff['id']);
			unset($staff['contract_updated']);
			unset($staff['reason']);
			unset($staff['reason_type']);
			unset($staff['replacement_request']);
			unset($staff['date_terminated']);
			//unset($staff['status']);
			$staff['prepaid_start_date'] = $_POST['cal'][$i];
			$staff['prepaid'] = 'yes';
			$staff['date_contracted'] = $ATZ;
			$staff['subcontractors_id'] = $subcontractors_id;
			$db->insert('subcontractors_temp', $staff);
			$subcontractors_temp_id = $db->lastInsertId();
			//echo $subcontractors_temp_id."<br>";
			
			//schedule the contract
			//schedule_prepaid_contract($subcontractors_temp_id);
            //echo $base_api_url;exit;
            //Use API
            $result = $curl->get($base_api_url . "/activate-prepaid-contract/activate/", array("id" => $subcontractors_temp_id, "admin_id" => $_SESSION['admin_id'] ));
			//print_r($result);
			//exit;
			
			/*
			//clone the previous staff contract subcontractors history
			$sql = $db->select()
			    ->from('subcontractors_history')
				->where('subcontractors_id =?', $subcontractors_id);
			$histories = $db->fetchAll($sql);
			foreach($histories as $h){
			    $data = array (
		            'subcontractors_id' => $subcontractors_temp_id, 
		            'date_change' => $h['date_change'], 
		            'changes' => $h['changes'], 
		            'change_by_id' => $h['change_by_id'] ,
		            'changes_status' => $h['changes_status'],
		            'note' => $h['note']
	            );
                $db->insert('subcontractors_temp_history', $data);
			}
			*/	
			
			//HISTORY
            //INSERT NEW RECORD TO THE subcontractors_history
			$history_changes .= sprintf("Prepaid Start Date %s <br>",  $_POST['cal'][$i]);
            $changes = "Contract has been scheduled for Prepaid Conversion.<br>";
            $changes .= "<b>Changes made : </b>.".$history_changes;
            $data = array (
		        'subcontractors_id' => $subcontractors_id, 
		        'date_change' => $ATZ, 
		        'changes' => $changes, 
		        'change_by_id' => $_SESSION['admin_id'] ,
		        'changes_status' => 'updated',
		        'note' => 'scheduled for prepaid conversion'
	        );
            $db->insert('subcontractors_history', $data);
			
			/*
			$changes = "Contract updated to prepaid.<br>";
			$data = array (
		        'subcontractors_id' => $subcontractors_temp_id, 
		        'date_change' => $ATZ, 
		        'changes' => $changes, 
		        'change_by_id' => $_SESSION['admin_id'] ,
		        'changes_status' => 'new',
		        'note' => 'converted to prepaid staff'
	        );
            $db->insert('subcontractors_temp_history', $data);
			*/
			
			$sql = $db->select()
				->from('personal')
				->where('userid =?', $staff['userid']);
			$personal = $db->fetchRow($sql);	
			array_push($prepaid_staffs, $personal);
		 }
	}
	//exit;
	//send email notify devs
	$sql = $db->select()
	    ->from('leads')
		->where('id =?', $_POST['client']);
	$lead = $db->fetchRow($sql);
	$smarty->assign('admin', $admin);
	$smarty->assign('lead', $lead);
	$smarty->assign('prepaid_staffs', $prepaid_staffs);
	$body = $smarty->fetch('admin_prepaid_autoresponder.tpl');		
	
    $mail = new Zend_Mail('utf-8');
    $mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
    $mail->addTo('devs@remotestaff.com.au', 'Devs');

    if(! TEST){
	    $subcject = "Admin ".$admin['admin_id']." ".$admin['admin_fname']." ".$admin['admin_lname']. " convert client ".$lead['fname']." ".$lead['lname']. " into prepaid client";
    }else{
	    $subcject = "TEST Admin ".$admin['admin_id']." ".$admin['admin_fname']." ".$admin['admin_lname']. " convert client ".$lead['fname']." ".$lead['lname']. " into prepaid client";
    }

    $mail->setSubject($subcject);
    $mail->setBodyHtml($body);
    $mail->send($transport);
	
   $msg =sprintf('Client #%s %s %s successfully converted to prepaid client.', $lead['id'], $lead['fname'], $lead['lname']);	

   $data = array('last_updated_date' => $ATZ);
   $db->update('leads', $data, 'id='.$_POST['client']);	

	echo "<script language='javascript'>
       alert('".$msg."');
       location.href='admin_prepaid_clients.php';
    </script>";
	exit;
	
}


//get all regular active clients
//$sql = "SELECT COUNT(s.id)AS no_staff, c.leads_id, l.fname, l.lname, l.email FROM clients c LEFT JOIN subcontractors s  ON s.leads_id = c.leads_id  JOIN leads l ON l.id = c.leads_id WHERE s.status = 'ACTIVE' AND c.prepaid='no' GROUP BY c.leads_id  ORDER BY l.fname;";
$sql= "SELECT  c.leads_id, l.fname, l.lname, l.email FROM clients c  JOIN leads l ON l.id = c.leads_id WHERE  c.prepaid='no' GROUP BY c.leads_id ORDER BY l.fname; ";
//echo $sql;exit;
$regular_clients = $db->fetchAll($sql);


$active_clients = array();
$non_active_clients = array();
$active_staffs = array();  
foreach ($regular_clients as $client){
    //get client active staff
    $sql = "SELECT s.userid, p.fname, p.lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status ='ACTIVE' AND prepaid='no' AND  s.leads_id = ".$client['leads_id']." ORDER BY p.fname;";
	//echo $sql;exit;
	$staffs = $db->fetchAll($sql);
	
	
    $CLIENT_ID = ((int)$client['leads_id']);  //must be an integer
    $CLIENT = new couchClient($couch_dsn, 'client_docs');
    //client currency settings
    $CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
    $CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
    $CLIENT->descending(True);
    $CLIENT->limit(1);
    $response = $CLIENT->getView('client', 'settings');

	$data= array(
	    'no_of_staff' => count($staffs),
		'leads_id' => $client['leads_id'],
		'fname' => $client['fname'],
		'lname' => $client['lname'],
		'email' => $client['email'],
		'staffs' => $staffs,
        'currency_code' => $response->rows[0]->value[0],
        'currency_gst_apply' => $response->rows[0]->value[1]				
	);
	if(count($staffs) > 0){
	    array_push($active_clients,$data);
	}//else{
	    //array_push($non_active_clients,$data);
	//}
	
}

//echo "<pre>";
//print_r($active_clients);
//echo "</pre>";
//exit;

//get all prepaid clients
//$sql = "SELECT COUNT(s.id)AS no_staff, c.leads_id, l.fname, l.lname, l.email FROM clients c JOIN subcontractors s  ON s.leads_id = c.leads_id  JOIN leads l ON l.id = c.leads_id WHERE s.status = 'ACTIVE' AND c.prepaid='yes' GROUP BY c.leads_id  ORDER BY l.fname;";
$sql= "SELECT  c.leads_id, l.fname, l.lname, l.email FROM clients c  JOIN leads l ON l.id = c.leads_id WHERE  c.prepaid='yes' GROUP BY c.leads_id ORDER BY l.fname; ";
//echo $sql;exit;
$regular_clients = $db->fetchAll($sql);

$prepaid_clients = array();
  
foreach ($regular_clients as $client){
    //get client active staff
    $sql = "SELECT s.userid, p.fname, p.lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status ='ACTIVE' AND prepaid='yes' AND  s.leads_id = ".$client['leads_id']." ORDER BY p.fname;";
	$staffs = $db->fetchAll($sql);
	
	//foreach($staffs as $staff){
	//    array_push
	//}
	$data= array(
	    'no_of_staff' => count($staffs),
		'leads_id' => $client['leads_id'],
		'fname' => $client['fname'],
		'lname' => $client['lname'],
		'email' => $client['email'],
		'staffs' => $staffs
	);
	array_push($prepaid_clients,$data);
	
	
}

//echo "<pre>";
//print_r($active_clients);
//echo "</pre>";
//exit;


$smarty->assign('javascripts', Array('prepaid/media/js/prepaid.js'));
$smarty->assign('stylesheets', Array('prepaid/media/css/prepaid.css'));

$smarty->assign('active_clients', $active_clients);
$smarty->assign('non_active_clients', $non_active_clients);
$smarty->assign('prepaid_clients', $prepaid_clients);
$smarty->assign('admin', $admin);
$smarty->display('admin_prepaid_clients.tpl');
?>