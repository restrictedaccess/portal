<?php
include('../conf/zend_smarty_conf.php') ;
include '../config.php';
include '../conf.php';
include('../lib/staff_history.php');
require('../tools/CouchDBMailbox.php');


if(isset($_SESSION['admin_id']))
{
	//start: assign recruiter
	$userid = $_REQUEST["userid"];
	$admin_id = $_REQUEST['admin_id'];
	
	$lizpau = array(335, 256);
	if (!in_array($_SESSION["admin_id"], $lizpau)){
		if ($admin_id==67){
			echo json_encode(array("success"=>false, "error"=>"Tagging to former recruiter is not allowed"));
			die;
		}
	}
	if (!in_array($_SESSION["admin_id"], $lizpau)){
		$rs = $db->fetchRow($db->select()->from(array("rs"=>"recruiter_staff"), array("userid", "admin_id"))->where("rs.userid = ?", $userid));
		if ($rs){
			if (($_SESSION["admin_id"] !=$rs["admin_id"])&&($_SESSION['status'] <> "FULL-CONTROL")){	
				echo json_encode(array("success"=>false, "error"=>"Please ask the former recruiter to tag this candidate for you"));
				die;
			}
		}
		
	}
	
	
	
	$date = date("Y-m-d")." ".date("H:i:s");
	
		//start: get assigned recruiter
		$a=mysqli_query($link2,"SELECT admin_fname, admin_lname, admin_email FROM admin WHERE admin_id='$admin_id' LIMIT 1");
		$r = mysqli_fetch_array($a);	
		$new_recruiter_name = $r['admin_fname']." ".$r['admin_lname'];
		//ended: get assigned recruiter		
	
	$existing_recruiter=mysqli_query($link2,"SELECT admin_id FROM recruiter_staff WHERE userid='$userid' LIMIT 1");
	$ctr=@mysqli_num_rows($existing_recruiter);
	if ($ctr > 0)
	{
		
		$exis_result = mysqli_fetch_array($existing_recruiter);	
		$exis_admin_id = $exis_result['admin_id'];
		
		//start: get existing recruiter
		$a=mysqli_query($link2,"SELECT admin_fname, admin_lname, admin_email FROM admin WHERE admin_id='$exis_admin_id' LIMIT 1");
		$r = mysqli_fetch_array($a);	
		$exis_recruiter_name = $r['admin_fname']." ".$r['admin_lname'];
		
		//ended: get assigned recruiter				
		
		//get login admin
		$row = $db->fetchRow($db->select()->from(array("adm"=>"admin"), array("admin_fname", "admin_lname"))->where("adm.admin_id = ?", $_SESSION["admin_id"]));
		$login_recruiter_name = $row["admin_fname"]." ".$row["admin_lname"];
		
		$action = 'UPDATE';
		$changes = 'from '.$exis_recruiter_name.' to '.$new_recruiter_name;
		
		
        //updated recruiter_staff update @bug report 536
        $db->update("recruiter_staff", array("admin_id"=>$admin_id), $db->quoteInto("userid = ?", $userid));
		//get status
		$pres = $db->fetchRow($db->select()->from("pre_screened_staff", "userid")->where("userid = ?", $userid));
		if ($pres){
			$status = "PRE-SCREENED";
		}
		$unprocessed = $db->fetchRow($db->select()->from("unprocessed_staff", "userid")->where("userid = ?", $userid));
		if ($unprocessed){
			$status = "UNPROCESSED";
		}
		if (!TEST){
			if (trim($exis_recruiter_name)!=""&&$r["admin_email"]){
				$smarty = new Smarty();
				$smarty->assign("former_recruiter_fullname", $exis_recruiter_name);
				$smarty->assign("new_recruiter_fullname", $new_recruiter_name);
				$smarty->assign("recruiter_fullname", $login_recruiter_name);
				$smarty->assign("userid", $userid);
				$smarty->assign("status", $status);
				$output = $smarty->fetch("recruiter_staff_autoresponder.tpl"); 
				
				$subject = "Recruiter Staff Assignment Transfer";
				$email = $r["admin_email"];
				if (TEST){
					$email = "devs@remotestaff.com.au";
				}
				$html = $output;
				$attachments_array = array();
				$bcc_array = array();
				$cc_array = array();
				$text = "";
				$to_array = array();
				$sender =  "noreply@remotestaff.com.au";
				$from =  "noreply@remotestaff.com.au";
				$email = $r["admin_email"];
				if (TEST){
					$email = "devs@remotestaff.com.au";
				}
				$to_array[] = $email;
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);			
			}
		}else{
			$smarty = new Smarty();
			$smarty->assign("former_recruiter_fullname", $exis_recruiter_name);
			$smarty->assign("new_recruiter_fullname", $new_recruiter_name);
			$smarty->assign("recruiter_fullname", $login_recruiter_name);
			$smarty->assign("userid", $userid);
			$smarty->assign("status", $status);
			$output = $smarty->fetch("recruiter_staff_autoresponder.tpl"); 
			
			$subject = "Recruiter Staff Assignment Transfer";
			$email = $r["admin_email"];
			if (TEST){
				$email = "devs@remotestaff.com.au";
			}
			$html = $output;
			$attachments_array = array();
			$bcc_array = array();
			$cc_array = array();
			$text = "";
			$to_array = array();
			$sender =  "noreply@remotestaff.com.au";
			$from =  "noreply@remotestaff.com.au";
			$email = $r["admin_email"];
			if (TEST){
				$email = "devs@remotestaff.com.au";
			}
			$to_array[] = $email;
			SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);			
		}
		
		
		

	}
	else
	{
		$action = 'INSERT';		
		$changes = $new_recruiter_name;
		mysqli_query($link2,"INSERT INTO recruiter_staff SET userid='$userid', admin_id='$admin_id', date='$date'");
	}
	//ended: assign recruiter	


	//START: insert staff history
	staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'RECRUITER', $action, $changes);
	//ENDED: insert staff history	
	
	
	global $base_api_url;
	global $curl;
	
	$curl->get($base_api_url . '/solr-index/sync-all-candidates?userid='.$userid);
	$curl->get($base_api_url . '/mongo-index/sync-all-candidates?userid='.$userid);

	//TRIGGER SYNCER RECRUITER
	$curl->get($base_api_url . '/mongo-index/sync-all-recruiters?recruiter_id='.$admin_id);
	
	echo json_encode(array("success"=>true));
}	
?>