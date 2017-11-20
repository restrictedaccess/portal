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

if(isset($_POST['add'])){
 
   $add = True;
   $error_msg = "";
   $team = $_POST['team'];
   $team_description = $_POST['team_description'];   

   $hiring_coordinator = $_POST['hiring_coordinator'];
   $head_recruiter = $_POST['head_recruiter'];
   $recruiters = $_POST['recruiters'];
   $csros = $_POST['csros'];
   
   //print_r($recruiters);
   //exit;
   //validate submitted fields
   if($team == ""){
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
   
   //check the team name if existing
   $sql = $db->select()
       ->from('recruitment_team', 'id')
	   ->where('team =?', $team);
   $id = $db->fetchOne($sql);
   if($id){
       $add = False;
	   $error_msg .="Team name already exist. Please try a different team name.<br>";
   }	   
   
   if($add == True){
       //echo "Insert New team";
	   $data = array(
	       'team' => $team, 
		   'team_description' => $team_description, 
		   'team_created_by_id' => $_SESSION['admin_id'], 
		   'team_date_created' => $ATZ
	   );
	   $history_msg = '<p><b>New Recruitment Team created</b></p><ul>';
	   $history_msg .= sprintf('<li>Team Name : %s</li>', $team);
	   $history_msg .= sprintf('<li>Description : %s</li>', $team_description);
	   
	   $db->insert('recruitment_team', $data);
	   $team_id = $db->lastInsertId();
	   //echo $team_id;
	   
	   //save hiring coordinator
	   $data = array(
	      'team_id' => $team_id, 
		  'admin_id' => $hiring_coordinator, 
		  'member_position' => 'hiring coordinator', 
		  'team_member_created_by_id' => $_SESSION['admin_id'], 
		  'team_member_date_created' => $ATZ
	   );
	   $db->insert('recruitment_team_member', $data);
	   $history_msg .= sprintf('<li>Hiring Coordinator : %s</li>', GetAdminName($hiring_coordinator));
	   
	   
	   
	   //save head recruiter
	   $data = array(
	      'team_id' => $team_id, 
		  'admin_id' => $head_recruiter, 
		  'member_position' => 'head recruiter', 
		  'team_member_created_by_id' => $_SESSION['admin_id'], 
		  'team_member_date_created' => $ATZ
	   );
	   $db->insert('recruitment_team_member', $data);
	   $history_msg .= sprintf('<li>Head Recruiter : %s</li>', GetAdminName($head_recruiter));
	   
	   
	   //save recruiters
	   for($i=0; $i < count($recruiters); $i++){
           //echo($recruiters[$i] . "<br>");
		   //save head recruiter
	       $data = array(
	          'team_id' => $team_id, 
		      'admin_id' => $recruiters[$i], 
		      'member_position' => 'recruiter', 
		      'team_member_created_by_id' => $_SESSION['admin_id'], 
		      'team_member_date_created' => $ATZ
	       );
	       $db->insert('recruitment_team_member', $data);
		   $history_msg .= sprintf('<li>Recruiter : %s</li>', GetAdminName($recruiters[$i]));
       }
	   
	   //save csro
	   for($i=0; $i < count($csros); $i++){
           //echo($recruiters[$i] . "<br>");
		   //save head recruiter
	       $data = array(
	          'team_id' => $team_id, 
		      'admin_id' => $csros[$i], 
		      'member_position' => 'csro', 
		      'team_member_created_by_id' => $_SESSION['admin_id'], 
		      'team_member_date_created' => $ATZ
	       );
	       $db->insert('recruitment_team_member', $data);
		   $history_msg .= sprintf('<li>CSRO : %s</li>', GetAdminName($csros[$i]));
       }
	   
	   
	    $sql = $db->select()
	       ->from('recruitment_team_member')
            ->where('member_position =?', 'recruiter')
	   		->where('team_id =?', $team_id);
		$recruiters = $db->fetchAll($sql);
        foreach($recruiters as $recruiter){
		    $data = array('head_recruiter_id' => $head_recruiter);
		    $where = "admin_id =".$recruiter['admin_id'];
		    $db->update('admin' , $data , $where); 
            $history_msg .= sprintf('<li>Assigned Recruiter %s to Head Recruiter %s</li>' , ucwords(GetAdminName($recruiter['admin_id'])), ucwords(GetAdminName($head_recruiter)));						
        }
	   
	   $history_msg .="</ul>";
	   //add history
	   $data = array(
	       'team_id' => $team_id, 
		   'history' => $history_msg, 
		   'date_history' => $ATZ, 
		   'admin_id' => $_SESSION['admin_id']
	   );
	   $db->insert('recruitment_team_history', $data);
	   
	   $smarty->assign('history_msg', $history_msg);
	   $smarty->assign('summary', sprintf('Admin %s Created New Recruitment Team.<br>%s',GetAdminName($_SESSION['admin_id']), $ATZ));
	   $body = $smarty->fetch('recruitment_team_autoresponder.tpl');
	   
	   $mail = new Zend_Mail('utf-8');
	   $mail->setBodyHtml($body);
	   $mail->setFrom('noreply@remotestaff.com.au', 'noreply');
	
	   if(! TEST){
	        $mail->addTo('admin@remotestaff.com.au', 'Admin');
			$mail->addTo('ricag@remotestaff.com.au', 'Rica J.');
			$mail->addBcc('devs@remotestaff.com.au');
	   		$mail->setSubject('Remote Staff New Recruitment Team Created');
	   }else{
	        $mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	        $mail->setSubject('TEST Remote Staff New Recruitment Team Created');
	   }
	   $mail->send($transport);
	   
	   
       $msg = $team." successfully added.";
	   echo '<script language="javascript">
				   alert("'.$msg.'");
				   location.href="./";
				</script>';
   }else{
       $smarty->assign('error_msg', $error_msg);
   }
}




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
    $sql = $db->select()
	    ->from('recruitment_team_member', 'id')
		->where('member_position =?', 'hiring coordinator')
		
		->where('admin_id =?', $admin['admin_id']);
	$id = $db->fetchOne($sql);
	if(!$id){
	    $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		array_push($hc, $data);
	}
}
//echo "<pre>";
//print_r($hc);
//echo "</pre>";


//head recruiters
$sql = $db->select()
	->from('admin')
	->where('status !=?' , 'REMOVED')
	->where('manage_recruiters =?' , 'Y')
	->order('admin_fname ASC');
$head_recruiters = $db->fetchAll($sql);
$hr = array();
foreach($head_recruiters as $admin){
    $sql = $db->select()
	    ->from('recruitment_team_member', 'id')
		->where('member_position =?', 'head recruiter')
		
		->where('admin_id =?', $admin['admin_id']);
	$id = $db->fetchOne($sql);
	if(!$id){
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
    $sql = $db->select()
	    ->from('recruitment_team_member', 'id')
		->where('member_position =?', 'recruiter')		
		->where('admin_id =?', $admin['admin_id']);
	$id = $db->fetchOne($sql);
	if(!$id){
	    $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		array_push($rec, $data);
	}
}


foreach($recruiters_full_control as $rec_fc){
    $sql = $db->select()
	    ->from('recruitment_team_member', 'id')
		->where('member_position =?', 'recruiter')		
		->where('admin_id =?', $rec_fc);
	$id = $db->fetchOne($sql);
	if(!$id){
	    $sql = $db->select()
		    ->from('admin')
			->where('admin_id =?', $rec_fc);
		$admin = $db->fetchRow($sql);	
	    $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
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
    $sql = $db->select()
	    ->from('recruitment_team_member', 'id')
		->where('member_position =?', 'csro')
		
		->where('admin_id =?', $admin['admin_id']);
	$id = $db->fetchOne($sql);
	if(!$id){
	    $data = array('admin_id' => $admin['admin_id'], 'admin_fname' => $admin['admin_fname'], 'admin_lname' => $admin['admin_lname']);
		array_push($cs, $data);
	}
}

//get the latest record
$sql = $db->select()
    ->from('recruitment_team')
	->order('id DESC')
	->limit(1);
$result = $db->fetchRow($sql);
if($result){
	if(!isset($_POST['team'])){
        $team = sprintf('Team %s',($result['id'] + 1));
    }
}else{
    if(!isset($_POST['team'])){
        $team = 'Team 1';
    }
}

$smarty->assign('form_action', 'addteam.php');
$smarty->assign('button_name', 'Add Team');

$smarty->assign('team_name', $team);
$smarty->assign('team_description', $team_description);
$smarty->assign('navs', $navs);
$smarty->assign('recruiters', $rec);
$smarty->assign('head_recruiters', $hr);
$smarty->assign('hiring_coordinators', $hc);
$smarty->assign('csros',$cs);
$smarty->assign('body_attributes', "id='navaddteam'");
$smarty->display('addteam.tpl');
?>