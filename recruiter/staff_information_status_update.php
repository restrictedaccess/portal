<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');
include('../time.php') ;
include('../function.php') ;

$status = $_REQUEST["status"];
$userid = $_REQUEST["userid"];
$admin_id = $_SESSION['admin_id'];
$other = @$_REQUEST['other'];

include_once('../lib/staff_status.php') ;

//START: update status
$datetime = date("Y-m-d")." ".date("H:i:s");


if ($status=="PRESCREENED"){
	if ($_SESSION["status"] <> "FULL-CONTROL"){
		$row =  $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"))->where("rs.admin_id = ?", $admin_id)->where("rs.userid = ?", $userid));
		if (!$row){
			echo json_encode(array("success"=>false, "error"=>"You can only prescreen candidates that are assigned to you"));
			die;
		}
		
		$row = $db->fetchRow($db->select()->from(array("ev"=>"evaluation_comments"), array("COUNT(ev.id) AS count"))
						->where("ev.userid = ?", $userid)
						->where("ev.comment_by = ?", $admin_id));
		if ($row&&$row["count"]<1){
			echo json_encode(array("success"=>false, "error"=>"Please enter evaluation note of your interview with this candidate"));
			die;
		}
	}
	
}


switch($status)
{
	case "SHORTLISTED":
		$sql = $db->select()
			->from('shortlisted_staff')
			->where('userid =?' , $userid);
		$result = $db->fetchRow($sql);
		$result	= $result['id'];
		if($result)
		{
			$data = array(
			'admin_id' => $admin_id,
			'date' => $datetime
			);
			$where = "userid = ".$userid;	
			$db->update('shortlisted_staff' , $data , $where);			
		}
		else
		{
			$data = array(
			'userid' => $userid,
			'admin_id' => $admin_id,
			'date' => $datetime
			);
			$db->insert('shortlisted_staff', $data);			
		}
		//$db->delete('unprocessed_staff', "userid ='".$userid."'");
		//$db->delete('inactive_staff', "userid ='".$userid."'");
		//$db->delete('pre_screened_staff', "userid ='".$userid."'");
		staff_status($db, $admin_id, $userid, 'SHORTLISTED');
		break;
		
	case "UNPROCESSED":
		$sql = $db->select()
			->from('unprocessed_staff')
			->where('userid =?' , $userid);
		$result = $db->fetchRow($sql);
		$result	= $result['id'];
		if($result)
		{
			$data = array(
			'admin_id' => $admin_id,
			'date' => $datetime
			);
			$where = "userid = ".$userid;	
			$db->update('unprocessed_staff' , $data , $where);			
		}
		else
		{
			$data = array(
			'userid' => $userid,
			'admin_id' => $admin_id,
			'date' => $datetime
			);
			$db->insert('unprocessed_staff', $data);			
		}
		staff_status($db, $admin_id, $userid, 'UNPROCESSED');
		break;	
		
	case "PRESCREENED":
		$sql = $db->select()
			->from('pre_screened_staff')
			->where('userid =?' , $userid);
		$result = $db->fetchRow($sql);
		$result	= $result['id'];
		if($result)
		{
			$data = array(
			'admin_id' => $admin_id,
			'date' => $datetime
			);
			$where = "userid = ".$userid;	
			$db->update('pre_screened_staff' , $data , $where);			
		}
		else
		{
			$data = array(
			'userid' => $userid,
			'admin_id' => $admin_id,
			'date' => $datetime
			);
			$db->insert('pre_screened_staff', $data);			
		}
		//$db->delete('unprocessed_staff', "userid ='".$userid."'");
		//$db->delete('inactive_staff', "userid ='".$userid."'");
		staff_status($db, $admin_id, $userid, 'PRE-SCREENED');
		
		
		break;
		
	case "INACTIVE":
		$sql = $db->select()
			->from('inactive_staff')
			->where('userid =?' , $userid);
		$result = $db->fetchRow($sql);
		$result	= $result['id'];
		if($result)
		{
			$data = array(
			'type' => $other,
			'date' => $datetime
			);
			$where = "userid = ".$userid;	
			$db->update('inactive_staff' , $data , $where);			
		}
		else
		{
			$data = array(
			'userid' => $userid,
			'admin_id' => $admin_id,
			'type' => $other,
			'date' => $datetime
			);
			$db->insert('inactive_staff', $data);			
		}
		$row =  $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"))->joinInner(array("adm"=>"admin"), "adm.admin_id = rs.admin_id", array("adm.admin_email AS admin_email", "adm.admin_id AS admin_id", "adm.admin_fname AS admin_fname", "adm.admin_lname AS admin_lname"))->where("rs.userid = ?", $userid));
		$smarty = new Smarty();
		
		
		if ($row){
			$admin = $db->fetchRow($db->select()->from(array("adm"=>"admin"), array("admin_id", "admin_fname", "admin_lname", "admin_email"))->where("admin_id = ?", $admin_id));
			$staff = $db->fetchRow($db->select()->from(array("pers"=>"personal"), array("pers.fname", "pers.lname", "pers.userid"))->where("userid = ?", $userid));
			
			if ($row["admin_id"]==$admin_id){
				$smarty->assign("recruiter_fullname", $admin["admin_fname"]." ".$admin["admin_lname"]);
				$smarty->assign("fullname", $staff["fname"]." ".$staff["lname"]);
				$smarty->assign("candidate_id", $userid);
				$smarty->assign("inactive_type", $other);
				$output = $smarty->fetch("inactive_autoresponder_logged_in.tpl");
			}else{
				$smarty->assign("recruiter_fullname", $row["admin_fname"]." ".$row["admin_lname"]);
				$smarty->assign("fullname", $staff["fname"]." ".$staff["lname"]);
				$smarty->assign("candidate_id", $userid);
				$smarty->assign("inactive_type", $other);
				$smarty->assign("logged_in_recruiter_fullname", $admin["admin_fname"]." ".$admin["admin_lname"]);
				$smarty->assign("currentdate", date("F j, Y"));
				$output = $smarty->fetch("inactive_autoresponder_not_logged_in.tpl");
				
			}
			$mail = new Zend_Mail();
			$mail->setBodyHtml($output);
			if (!TEST){
				$mail->setSubject("Inactive Status Change Update");
			}else{
				$mail->setSubject("TEST - Inactive Status Change Update");
			}
			$mail->setFrom("noreply@remotestaff.com.au", "noreply@remotestaff.com.au");
			if ($row["admin_id"]==$admin_id){
				if (!TEST){
					$mail->addTo($admin["admin_email"]);					
				}else{
					$mail->addTo("devs@remotestaff.com.au");
				}

			}else{
				if (!TEST){
					$mail->addTo($row["admin_email"]);					
				}else{
					$mail->addTo("devs@remotestaff.com.au");
				}
			}
			$mail->send($transport);
		}
		
		//$db->delete('unprocessed_staff', "userid ='".$userid."'");
		//$db->delete('pre_screened_staff', "userid ='".$userid."'");
		staff_status($db, $admin_id, $userid, 'INACTIVE');
		
		
		break;		
		
}
//ENDED: update status


//START: add status lookup or history
if($status == "INACTIVE")
{
	$status_to_use = $other;
}
else
{
	$status_to_use = $status;
}
$data2 = array(
'personal_id' => $userid,
'admin_id' => $admin_id,
'status' => $status_to_use,
'date' => $datetime
);
$db->insert('applicant_status', $data2);
//ENDED: add status lookup or history


$AusTime = date("h:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date = $ATZ;
mysql_query("UPDATE personal SET dateupdated = '".$date."' WHERE userid = ".$userid);


//START: insert staff history
include('../lib/staff_history.php');
staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', $status);
//ENDED: insert staff history
echo json_encode(array("success"=>true));
		
?>