<?php
include('../conf/zend_smarty_conf.php');
include '../leads_information/ShowLeadsOrder.php';
include '../lib/addLeadsInfoHistoryChanges.php';
include '../config.php';
include '../time.php';
include '../conf.php';

if (isset($_POST["status"])&&isset($_POST["id"])){
	$id = $_POST["id"];
	$row = $db->fetchRow($db->select()->from(array("rqic"=>"request_for_interview_cancellations"))->where("rqic.request_for_interview_id = ?", $_POST["id"]));
	if ($row){
		unset($row["id"]);
		$row["reason"] = $_POST["status"];
		$db->update("request_for_interview_cancellations", $row, $db->quoteInto("request_for_interview_cancellations.request_for_interview_id = ?", $_POST["id"]));
	}else{
		$row = array();
		$row["request_for_interview_id"] = $_POST["id"];
		$row["reason"] = $_POST["status"];
		$db->insert("request_for_interview_cancellations", $row);
	}

	$db->update("tb_app_appointment", array("status"=>"not active"), $db->quoteInto("request_for_interview_id = ?", $_POST["id"]));
	$db->update("tb_request_for_interview", array("status"=>"CANCELLED"), $db->quoteInto("id = ?", $id));
	$sql = $db->select()
	->from('tb_request_for_interview', 'leads_id')
	->where('id =?', $id);
	$leads_id = $db->fetchOne($sql);
	$orders_str = CheckLeadsOrderInASL($leads_id);
	if($orders_str > 0){
		$data = array('asl_orders' => 'yes');
		addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
		$db->update('leads', $data, 'id='.$leads_id);
	}else{
		$data = array('asl_orders' => 'no');
		addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['admin_id'] , 'admin');
		$db->update('leads', $data, 'id='.$leads_id);
	}

	if ($_POST["status"]=="CLIENT CANCELLED"){
		
		$sql = $db->select()
		->from(array("tbr"=>"tb_request_for_interview"), array("tbr.date_interview AS schedule"))
		->joinInner(array("pers"=>"personal"), "pers.userid = tbr.applicant_id", array("pers.fname AS staff_fname", "pers.email AS staff_email"))
	
		->joinInner(array("l"=>"leads"), "l.id = tbr.leads_id", array("l.fname AS client_fname"))
		->where('tbr.id =?', $id);
		$row = $db->fetchRow($sql);
			
		$facilitator = $db->fetchRow($db->select()
		->from(array("app"=>"tb_app_appointment"), array())
		->joinInner(array("adm"=>"admin"), "adm.admin_id = app.user_id", array("adm.admin_fname AS admin_fname", "adm.admin_lname AS admin_lname", "adm.admin_email AS admin_email"))
		->where("app.request_for_interview_id = ?", $id));
		if (!$facilitator){
			$facilitator = $db->fetchRow($db->select()
			->from(array("adm"=>"admin"),array("adm.admin_fname AS admin_fname", "adm.admin_lname AS admin_lname", "adm.admin_email AS admin_email"))
			->where("adm.admin_id = ?", $_SESSION["admin_id"]));
		}
		$admin_email = $facilitator['admin_email'];
		$name = $facilitator['admin_fname']." ".$result['admin_lname'];
		$admin_email=$facilitator['admin_email'];
		$signature_company = $facilitator['signature_company'];
		$signature_notes = $facilitator['signature_notes'];
		$signature_contact_nos = $facilitator['signature_contact_nos'];
		$signature_websites = $facilitator['signature_websites'];
		$site = $_SERVER['HTTP_HOST'];

		if($signature_notes!=""){
			$signature_notes = "<p><i>$signature_notes</i></p>";
		}else{
			$signature_notes = "";
		}
		if($signature_company!=""){
			$signature_company="<br>$signature_company";
		}else{
			$signature_company="<br>RemoteStaff";
		}
		if($signature_contact_nos!=""){
			$signature_contact_nos = "<br>$signature_contact_nos";
		}else{
			$signature_contact_nos = "";
		}
		if($signature_websites!=""){
			$signature_websites = "<br>Websites : $signature_websites";
		}else{
			$signature_websites = "";
		}

		$signature_template = $signature_notes;
		$signature_template .="<a href='http://$site/$agent_code'>
											<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
		$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : {$facilitator["admin_email"]}$signature_websites</p><br /><br />";
		//END SEGNATURE
		 
		$smarty = new Smarty();
		$smarty->assign("staff_fname", $row["staff_fname"]);
		$smarty->assign("client_fname", $row["client_fname"]);
		$smarty->assign("scheduleDate", $row["schedule"]);
		$smarty->assign("signature_admin", $signature_template);
		$output = $smarty->fetch("cancelled_candidate_autoresponder.tpl");
		
		$mail = new Zend_Mail();
		$mail->setBodyHtml($output);
		if (!TEST){
			$mail->setSubject("Updates for your application at Remotestaff");
		}else{
			$mail->setSubject("TEST - Updates for your application at Remotestaff");
		}
		$mail->setFrom($facilitator["admin_email"], "Remotestaff");
		if(!TEST){
			$mail->addTo($row["staff_email"], $row["staff_email"]);
		}else{
			$mail->addTo('devs@remotestaff.com.au', 'devs@remotestaff.com.au');
			//$mail->addTo('remote.allanaire@gmail.com', 'remote.allanaire@gmail.com');
			
		}
	    $mail->send($transport);
	}
	if ($_POST["status"]=="STAFF NO SHOW"){
		$status = "Staff No Show";
	}else if ($_POST["status"]=="CLIENT NO SHOW"){
		$status = "Client No Show";
	}else if ($_POST["status"]=="STAFF CANCELLED"){
		$status = "Staff Cancelled";
	}else if ($_POST["status"]=="CLIENT CANCELLED"){
		$status = "Client Cancelled";
	}
	$sql = $db->select()
		->from(array("tbr"=>"tb_request_for_interview"), array("tbr.applicant_id AS applicant_id","tbr.service_type AS service_type"))->where("id = ?", $id);
	$row = $db->fetchRow($sql);
	//tagging on no show
	if ($status=="Staff No Show"){
		
		if ($row){
			$sns = $db->fetchRow($db->select()->from(array("sns"=>"staff_no_show"))
				->where("sns.request_for_interview_id = ?", $id));
			if ($sns){
				$sns["date"] = date("Y-m-d h:i:s");
				$db->update("staff_no_show", $sns, $db->quoteInto("request_for_interview_id = ?", $id));				
			}else{
				$sns = array();
				$sns["userid"] = $row["applicant_id"];
				$sns["admin_id"] = $_SESSION["admin_id"];
				$sns["date"] = date("Y-m-d h:i:s");
				$sns["service_type"] = $row["service_type"];
				$sns["request_for_interview_id"] = $id;
				$db->insert("staff_no_show", $sns);
			}
		}
	}else{
		//delete tagging on the same request for interview
		$db->delete("staff_no_show", $db->quoteInto("staff_no_show.request_for_interview_id = ?", $id));
	}
	
	$db->update("tb_request_for_interview", array("date_updated"=>date("Y-m-d H:i:s")), $db->quoteInto("id = ?", $id));
	echo json_encode(array("success"=>true, "status"=>$status, "id"=>$_POST["id"]));

}else{
	echo json_encode(array("success"=>false));
}