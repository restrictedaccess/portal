<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_POST["id"])&&$_POST["id"]){
	if (trim($_POST["feedback"])==""){
		echo json_encode(array("success"=>false, "error"=>"Please provide a feedback."));
		die;		
	}
	
	$id = $_POST["id"];
	$data = array(
		"rejection_feedback"=>$_POST["feedback"],
		"rejected"=>1,
		"rejected_by"=>$_SESSION["admin_id"],
		"rejected_date"=>date("Y-m-d H:i:s")
	);
	$db->update("tb_endorsement_history", $data, $db->quoteInto("id = ?", $id));
	
	$endorsement = $db->fetchRow(
						$db->select()->from(array("e"=>"tb_endorsement_history"))
							->joinLeft(array("p"=>"posting"), "p.id = e.position", array("p.id AS posting_id", "p.jobposition"))
							->joinLeft(array("pers"=>"personal"), "e.userid = pers.userid", array(new Zend_Db_Expr("CONCAT(pers.fname, ' ', pers.lname) AS fullname")))
							->joinLeft(array("l"=>"leads"), "l.id = e.client_name", array(new Zend_Db_Expr("CONCAT(l.fname, ' ',l.lname) AS client")))
							->where("e.id = ?", $id));
	if ($endorsement){

		if(!$endorsement["jobposition"])
		{
			$sql=$db->select()
				->from('job_sub_category')
				->where('sub_category_id = ?', $endorsement["job_category"]);
			$pos = $db->fetchRow($sql);
			$job_position_name = $pos['sub_category_name'];
			$history_changes = "Endorsed Candidate <a href='/portal/recruiter/staff_information.php?userid={$endorsement["userid"]}' target='_blank'>{$endorsement["fullname"]}</a> was Rejected From ".$job_position_name." position";
		}else{
			$history_changes = "Endorsed Candidate <a href='/portal/recruiter/staff_information.php?userid={$endorsement["userid"]}' target='_blank'>{$endorsement["fullname"]}</a> was Rejected From <a href='/portal/Ad.php?id=".$endorsement["posting_id"]."' target='_blank'>".$endorsement["jobposition"]."</a> position";
			
		}
		
		
		$changeByType = $_SESSION["status"];
		if ($changeByType=="FULL-CONTROL"){
			$changeByType = "ADMIN";
		}
		if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
			$created_by_type = "agent";
			$created_by_id = $_SESSION["agent_no"];
		}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){
			$created_by_type = "admin";
			$created_by_id = $_SESSION['admin_id'];
		}else{
			$created_by_type = "admin";
			$created_by_id = $_SESSION['admin_id'];
		}
		$data = array(
	         'leads_id' => $endorsement["client_name"],
		     'date_change' => date("Y-m-d H:i:s"), 
		     'changes' => strip_tags($history_changes), 
		     'change_by_id' => $created_by_id, 
		     'change_by_type' => $created_by_type
	    );
	    $db->insert('leads_info_history', $data);
		
		$feedback = $history_changes."\n";
		$feedback .= "FEEDBACK: ".$_POST["feedback"];
		
		
		$data = array(
			'agent_no' => $created_by_id,
			'created_by_type' => $created_by_type,
			'leads_id' =>  $endorsement["client_name"],
			'actions' => 'FEEDBACK',
			'history' => $feedback,
			'date_created' => date("Y-m-d H:i:s")
			
		);
		
		$db->insert('history', $data);
		$history_id = $db->lastInsertId();

		$data = array(
	         'leads_id' => $endorsement["client_name"],
		     'date_change' => date("Y-m-d H:i:s"), 
		     'changes' => sprintf('Communication Record Type : [ %s ] History id #%s', 'FEEDBACK', $history_id), 
		     'change_by_id' => $created_by_id, 
		     'change_by_type' => $created_by_type
	    );
	    $db->insert('leads_info_history', $data);
		
		
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$endorsement["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));	
	}
	
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false, "error"=>"Invalid Request"));
}