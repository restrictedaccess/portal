<?php
include('../conf/zend_smarty_conf.php');
include('recruitment_functions.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	die("Session expires. Please re login.");
}

$team_id = $_GET['team_id'];
if($team_id == ""){
    die("Team ID is required!");
}

$sql = "SELECT * FROM recruitment_team WHERE id = ". $team_id;
$team = $db->fetchRow($sql);
if(!$team){
    die("Team does not exist");
}

$team_name = $_POST['team'];
$team_description = $_POST['team_description'];

//////////////////////////////////////////////

if(isset($_POST['add'])){
 
    $add = True;
    $error_msg = "";
    $team_name = $_POST['team'];
    $team_description = $_POST['team_description'];   

    $hiring_coordinator = $_POST['hiring_coordinator'];
    $head_recruiter = $_POST['head_recruiter'];
    $recruiters = $_POST['recruiters'];
    $csros = $_POST['csros'];
   
    $team_id = $_POST['team_id'];
    //print_r($recruiters);
    //exit;
    //validate submitted fields
    if($team_name == ""){
       $add = False;
	   $error_msg .="Team Name is Required.<br>";
    }
   
    if($hiring_coordinator== ""){
       $add = False;
	   $error_msg .="Please choose a Hiring Coordinator.<br>";
    }
   
    if($head_recruiter == ""){
       $add = False;
	   $error_msg .="Please choose a Head Recruiter.<br>";
    }
   
    if(count($recruiters) == 0){
       $add = False;
	   $error_msg .="No Recruiters selected.<br>";
    }
   
    if(count($csros) == 0){
       $add = False;
	   $error_msg .="No CSRO selected.<br>";
    }
    
	if($add == True){
		//update team table
		$history_changes=""; 	   
		$data = array('team' => $team_name, 'team_description' => $team_description); 
		$history_changes .= compareData($data , $team_id);      
		$db->update('recruitment_team', $data, 'id='.$team_id);
		
		
		//update members if there's any changes.
		//echo sprintf('hiring coordinator %s => %s<br>', $hiring_coordinator_id, $hiring_coordinator);
		$history_changes .= GetOriginalTeamMembers($team_id, 'hiring coordinator', $hiring_coordinator);
		$history_changes .= GetOriginalTeamMembers($team_id, 'head recruiter', $head_recruiter);
		$history_changes .= GetOriginalTeamMembers($team_id, 'recruiter', $recruiters);
		$history_changes .= GetOriginalTeamMembers($team_id, 'csro', $csros);
		//echo $msg;
		//if (!in_array($hiring_coordinator, $results)) {
		//    echo "delete and replace";
		//}
		//echo sprintf('head recruiter %s => %s<br>', $head_rercuiter_id, $head_recruiter);
		//if($hiring_coordinator_id != $hiring_coordinator)
		
		
		//add history
		if($history_changes !=""){
			$history_msg = "<p><b>Team Updates</b></p><ul>";
			$history_msg .= $history_changes;
			$history_msg .= "</ul>";
			$data = array(
				'team_id' => $team_id, 
				'history' => $history_msg, 
				'date_history' => $ATZ, 
				'admin_id' => $_SESSION['admin_id']
			);
			$db->insert('recruitment_team_history', $data);
			
			$smarty->assign('history_msg', $history_msg);
	        $smarty->assign('summary', sprintf('Admin %s Updated Recruitment Team => [ %s ].<br>%s',GetAdminName($_SESSION['admin_id']), strtoupper($team['team']), $ATZ));
	        $body = $smarty->fetch('recruitment_team_autoresponder.tpl');
	   
	        $mail = new Zend_Mail('utf-8');
	        $mail->setBodyHtml($body);
	        $mail->setFrom('noreply@remotestaff.com.au', 'noreply');
	
	        if(! TEST){
	            $mail->addTo('admin@remotestaff.com.au', 'Admin');
			    $mail->addTo('ricag@remotestaff.com.au', 'Rica J.');
			    $mail->addBcc('devs@remotestaff.com.au');
	   		    $mail->setSubject('Remote Staff Recruitment Team Updates');
	        }else{
	            $mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	            $mail->setSubject('TEST Remote Staff Recruitment Team Updates');
	        }
	        $mail->send($transport);
			
			 
		}
		
		
			 
		header("location:view.php?team_id=".$team_id);
		exit;
    }else{
       $smarty->assign('error_msg', $error_msg);
    }
	
}



//////////////////////////////////////////////




//get the assign hiring coordinator
$sql = $db->select()
    ->from('recruitment_team_member', 'admin_id')
	
	->where('member_position =?', 'hiring coordinator')
	->where('team_id =?', $team_id);
$hiring_coordinator_id = $db->fetchOne($sql);


//get the assign head recruiter
$sql = $db->select()
    ->from('recruitment_team_member', 'admin_id')
	
	->where('member_position =?', 'head recruiter')
	->where('team_id =?', $team_id);
$head_rercuiter_id = $db->fetchOne($sql);

//get all assign recruiters
$sql = $db->select()
    ->from('recruitment_team_member', 'admin_id')
	
	->where('member_position =?', 'recruiter')
	->where('team_id =?', $team_id);
$rercuiter_ids = $db->fetchAll($sql);
$rec_ids = array();
foreach($rercuiter_ids as $rec_id){
    array_push($rec_ids, $rec_id['admin_id']);
}


//get all assign csro
$sql = $db->select()
    ->from('recruitment_team_member', 'admin_id')
	
	->where('member_position =?', 'csro')
	->where('team_id =?', $team_id);
$csro_ids = $db->fetchAll($sql);
$cs_ids = array();
foreach($csro_ids as $rec_id){
    array_push($cs_ids, $rec_id['admin_id']);
}


//get all team history
$sql = $db->select()
    ->from(array('h' => 'recruitment_team_history'), Array('history', 'date_history'))
	->join(array('a' => 'admin'), 'a.admin_id = h.admin_id', Array('admin_fname', 'admin_lname'))
	->where('h.team_id =?', $team_id);
$histories = $db->fetchAll($sql);

//get all admin Hiring Coordinator
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('hiring_coordinator =?' , 'Y')
	->order('admin_fname ASC');
//echo $sql;	
$hiring_coordinators = $db->fetchAll($sql);
$hc = array();
foreach($hiring_coordinators as $admin){
    //echo $admin['admin_id']."<br>";
    if($admin['admin_id'] != $hiring_coordinator_id){
        $sql = $db->select()
	        ->from('recruitment_team_member', 'id')
		    ->where('member_position =?', 'hiring coordinator')
		    
		    ->where('admin_id =?', $admin['admin_id']);
	    $id = $db->fetchOne($sql);
	    if(!$id){
	        $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		    array_push($hc, $data);
	    }
	}else{
	     $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		 array_push($hc, $data);
	}
}


//head recruiters
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('manage_recruiters =?' , 'Y')
	->order('admin_fname ASC');
$head_recruiters = $db->fetchAll($sql);
$hr = array();
foreach($head_recruiters as $admin){
    //echo $admin['admin_id']."<br>";
    if($admin['admin_id'] != $head_rercuiter_id){
        $sql = $db->select()
	       ->from('recruitment_team_member', 'id')
		   ->where('member_position =?', 'head recruiter')
		   
		   ->where('admin_id =?', $admin['admin_id']);
	    $id = $db->fetchOne($sql);
	    if(!$id){
	       $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		   array_push($hr, $data);
	    }
	}else{
	    $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		array_push($hr, $data);
	}	
}


//recruiters
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('status =?', 'HR')
	->where('manage_recruiters =?' , 'N')
	->where('hiring_coordinator =?' , 'N')
	->where('csro =?' , 'N')
	->order('admin_fname ASC');
//echo $sql;	
$recruiters = $db->fetchAll($sql);
$rec = array();
foreach($recruiters as $admin){
    
	if (!in_array($admin['admin_id'], $rec_ids)) {
	    //echo $admin['admin_id']."<br>";
	    
	    $sql = $db->select()
	        ->from('recruitment_team_member', 'id')
		    ->where('member_position =?', 'recruiter')
		    
		    ->where('admin_id =?', $admin['admin_id']);
	    $id = $db->fetchOne($sql);
	    if(!$id){
	        $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname'], 'selected' => false);
		    array_push($rec, $data);
	    }
		
	}
	
	else{
	     $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname'], 'selected' => true);
		 array_push($rec, $data);
	}
	
}


foreach($recruiters_full_control as $rec_fc){
    $sql = $db->select()
		->from('admin')
		->where('admin_id =?', $rec_fc);
	$admin = $db->fetchRow($sql);
			
    if (!in_array($admin['admin_id'], $rec_ids)) {
		$sql = $db->select()
			->from('recruitment_team_member', 'id')
			->where('member_position =?', 'recruiter')		
			->where('admin_id =?', $rec_fc);
		$id = $db->fetchOne($sql);
		if(!$id){				
			$data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname'], 'selected' => false);
			array_push($rec, $data);
		}
	}else{
	     $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname'], 'selected' => true);
		 array_push($rec, $data);
	}
	
}

//get all admin CSRO
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('csro =?' , 'Y')
	->order('admin_fname ASC');
$csros = $db->fetchAll($sql);
$cs = array();
foreach($csros as $admin){
    if (!in_array($admin['admin_id'], $cs_ids)) {
        $sql = $db->select()
	        ->from('recruitment_team_member', 'id')
		    ->where('member_position =?', 'csro')
		    
		    ->where('admin_id =?', $admin['admin_id']);
	    $id = $db->fetchOne($sql);
	    if(!$id){
	        $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		    array_push($cs, $data);
	    }
	}else{
	    $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname'], 'selected' => true);
		array_push($cs, $data);
	}	
}




if($team_name == ""){
    $team_name = $team['team'];
}

if($team_description ==""){
   $team_description = $team['team_description'];
}

//echo $head_rercuiter_id;

$smarty->assign('hiring_coordinators', $hc);
$smarty->assign('hiring_coordinator_id',$hiring_coordinator_id);

$smarty->assign('head_recruiters', $hr);
$smarty->assign('head_rercuiter_id', $head_rercuiter_id);

$smarty->assign('recruiters', $rec);
$smarty->assign('csros', $cs);

$smarty->assign('team_name', $team_name);
$smarty->assign('team_description', $team_description);

$smarty->assign('form_action', sprintf('team.php?team_id=%s', $team_id));
$smarty->assign('button_name', 'Update Team');


$smarty->assign('team_id', $team_id);
//$smarty->assign('histories', $histories);
$smarty->assign('jscripts', Array('/portal/js/MochiKit.js'));
$smarty->display('addteam.tpl');
?>