<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php');

function publishQuery($sql){
	$exchange = '/';
	$queue = 'receive_recruitment_query';
	$consumer_tag = 'consumer';
	if (TEST){
		$conn = new AMQPConnection(MQ_HOST, MQ_PORT,MQ_USER,MQ_PASS, MQ_VHOST);
	}else{
		$conn = new AMQPConnection(MQ_RECRUITMENT_QUERY_HOST, MQ_RECRUITMENT_QUERY_PORT,MQ_RECRUITMENT_QUERY_USER,MQ_RECRUITMENT_QUERY_PASS, MQ_RECRUITMENT_QUERY_VHOST);	
 	}
 	$ch = $conn->channel();
	$ch->queue_declare($queue, false, true, false, false);
	$ch->exchange_declare($exchange, 'direct', false, true, false);
	$ch->queue_bind($queue, $exchange);
	
	$msg_body =json_encode(array("script"=>"/portal/cronjobs/sync_recruiter_home_to_mongo.php","query"=>$sql->__toString(), "action"=>"sync_query"));
	$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
	$ch->basic_publish($msg, $exchange);
	$ch->close();
	$conn->close();		
}

$userid = addslashes($_GET["userid"]);
if (!isset($_GET["mode"])){
	$_GET["mode"] = "update";
}
$mode = $_GET["mode"];
$key = $_GET["key"];

$candidate_to_sync = array();
$to_sync = false;
if (isset($_GET["userid"])){
	
	$db->delete("mongo_recruitment_entries", $db->quoteInto("userid = ?", $_GET["userid"]));
	try{
		$retries = 0;
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
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
			
		$recruitment_collection = $database->selectCollection('recruitment');
		$recruitment_collection->remove(array("userid"=>intval($_GET["userid"])), array("justOne"=>false));
		
		
	}catch(Exception $e){
		
	}	
	$mode = "update";
	$_GET["mode"] = "update";
	$to_sync = true;
}else if ($_SESSION["admin_id"]){
	if ($mode=="update"){
		if ($_SESSION['status']=="HR"){
			$candidates = $db_query_only->fetchAll($db->select()->from(array("rs"=>"recruiter_staff"), array("rs.userid"))->where("rs.admin_id = ?", $_SESSION["admin_id"]));			
			try{
				$retries = 0;
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
					} catch(Exception $e){
						++$retries;
						
						if($retries >= 100){
							break;
						}
					}
				}
				
					
						
				$recruitment_collection = $database->selectCollection('recruitment');
				foreach($candidate_to_sync as $candi){
					$candidate_to_sync[] = $candi["userid"];
					$recruitment_collection->remove(array("userid"=>intval($candi["userid"])));
				}
				
			}catch(Exception $e){
				
			}
			if (!empty($candidate_to_sync)){
				$result = Rand (1,2); 
				if ($result===1){
					$to_sync = true;
				}	
			}
			
		}
	}
}
if ($mode=="index_all"&&$key=="allan"){
	$to_sync = true;
}


if($to_sync){
	$sql = $db->select()->from(array("e"=>"tb_endorsement_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("e.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("e.userid IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	
	for($i=1;$i<=$page;$i++){	
	
		$sql = $db->select()->from(array("e"=>"tb_endorsement_history"), 
					array(new Zend_Db_Expr("CONCAT(e.id, '_endorsement') AS tracking_code"),
					 "e.userid AS userid", "e.id AS key",
					  new Zend_Db_Expr("CONCAT('tb_endorsement_history') AS `table`"),
					   new Zend_Db_Expr("DATE_FORMAT(e.date_endoesed, '%Y-%m-%d') AS `date`")))
					   ->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = e.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   ->limitPage($i, 10000);
		
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("e.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("e.userid IN (".implode(",", $candidate_to_sync).")");
		}
		publishQuery($sql);
	}
	
	
	$sql = $db->select()->from(array("u"=>"unprocessed_staff"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		$subquery = "SELECT userid FROM inactive_staff AS i WHERE i.userid = {$userid}";
		if ($mode=="update"){
			$sql->where("u.userid = ?", $_GET["userid"])->where("u.userid NOT IN ({$subquery})");
		}
	}else if (!empty($candidate_to_sync)){
		$subquery = "SELECT userid FROM inactive_staff AS i WHERE i.userid NOT IN(".implode(",", $candidate_to_sync).")";
		$sql->where("u.userid IN (".implode(",", $candidate_to_sync).")")->where("u.userid NOT IN ({$subquery})");
	}else{
		$subquery = "SELECT userid FROM inactive_staff AS i";
		$sql->where("u.userid NOT IN ({$subquery}) ");
	}
	
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	
	for($i=1;$i<=$page;$i++){	
		
		$sql = $db->select()->from(array("u"=>"unprocessed_staff"), 
				array(new Zend_Db_Expr("CONCAT(u.id, '_unprocessed') AS tracking_code"),
					 "u.userid AS userid", "u.id AS key",  new Zend_Db_Expr("CONCAT('unprocessed_staff') AS `table`"),
					   new Zend_Db_Expr("DATE_FORMAT(u.date, '%Y-%m-%d') AS `date`")))
					   ->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = u.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   
					   ->limitPage($i, 10000);
		if (isset($_GET["userid"])){
			$subquery = "SELECT userid FROM inactive_staff AS i WHERE i.userid = {$userid}";
			
			$sql->where("u.userid = ?", $_GET["userid"])->where("u.userid NOT IN ({$subquery})");;
		}else if (!empty($candidate_to_sync)){
			$subquery = "SELECT userid FROM inactive_staff AS i WHERE i.userid NOT IN(".implode(",", $candidate_to_sync).")";
		
			$sql->where("u.userid IN (".implode(",", $candidate_to_sync).")")->where("u.userid NOT IN ({$subquery})");;
		}else{
			$subquery = "SELECT userid FROM inactive_staff AS i";
			$sql->where("u.userid NOT IN ({$subquery}) ");
		}
		
		publishQuery($sql);
	}			
	
	$sql = $db->select()->from(array("pss"=>"pre_screened_staff"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("pss.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("pss.userid IN (".implode(",", $candidate_to_sync).")");
	}
	
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("pss"=>"pre_screened_staff"), array(new Zend_Db_Expr("CONCAT(pss.id, '_prescreened') AS tracking_code"),
								"pss.userid AS userid", "pss.id AS key", new Zend_Db_Expr("CONCAT('pre_screened_staff') AS `table`"), 
								new Zend_Db_Expr("DATE_FORMAT(pss.date, '%Y-%m-%d') AS `date`")		
								))	
								->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = pss.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   
					   			->limitPage($i, 10000);
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("pss.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("pss.userid IN (".implode(",", $candidate_to_sync).")");
		}
		publishQuery($sql);	
	}
	
	$sql = $db->select()->from(array("sh"=>"tb_shortlist_history"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("sh.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("sh.userid IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("sh"=>"tb_shortlist_history"), array(new Zend_Db_Expr("CONCAT(sh.id, '_shortlist') AS tracking_code"),
								"sh.userid AS userid", "sh.id AS key", new Zend_Db_Expr("CONCAT('tb_shortlist_history') AS `table`"), 
								new Zend_Db_Expr("DATE_FORMAT(sh.date_listed, '%Y-%m-%d') AS `date`")		
								))	
								->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = sh.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   
					   			->limitPage($i, 10000);
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("sh.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("sh.userid IN (".implode(",", $candidate_to_sync).")");
		}	  
		publishQuery($sql);	
	}
	
	$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("jsca.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("jsca.userid IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("CONCAT(jsca.id, '_categorized') AS tracking_code"),
								"jsca.userid AS userid", "jsca.id AS key", new Zend_Db_Expr("CONCAT('job_sub_category_applicants') AS `table`"), 
								new Zend_Db_Expr("DATE_FORMAT(jsca.sub_category_applicants_date_created, '%Y-%m-%d') AS `date`")		
								))	
								->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = jsca.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   
					   			->limitPage($i, 10000);
					   			
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("jsca.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("jsca.userid IN (".implode(",", $candidate_to_sync).")");
		}
		publishQuery($sql);	
	}
	
	$sql = $db->select()->from(array("ina"=>"inactive_staff"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("ina.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("ina.userid IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("ina"=>"inactive_staff"), array(new Zend_Db_Expr("CONCAT(ina.id, '_inactive') AS tracking_code"),
								"ina.userid AS userid", "ina.id AS key", new Zend_Db_Expr("CONCAT('inactive_staff') AS `table`"), "ina.type AS inactive_type", 
								new Zend_Db_Expr("DATE_FORMAT(ina.date, '%Y-%m-%d') AS `date`")		
								))	
								->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = ina.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   
					   			->limitPage($i, 10000);
					   			
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("ina.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("ina.userid IN (".implode(",", $candidate_to_sync).")");
		}
		publishQuery($sql);	
	}
	
	
	$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->where("tbr.applicant_id <> ''")->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("tbr.applicant_id = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("tbr.applicant_id IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/1000))+1;
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array(new Zend_Db_Expr("CONCAT(tbr.id, '_request_for_interview') AS tracking_code"),
								"tbr.applicant_id AS userid", "tbr.id AS key", new Zend_Db_Expr("CONCAT('tb_request_for_interview') AS `table`"), "tbr.status AS interview_status", "tbr.service_type AS interview_service_type",
								new Zend_Db_Expr("DATE_FORMAT(tbr.date_added, '%Y-%m-%d') AS `date`")		
								))	
								->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = tbr.applicant_id", array("rs.admin_id AS assigned_recruiter_id"))
					   			->joinLeft(array("s"=>"subcontractors"), "s.userid = tbr.applicant_id", array(new Zend_Db_Expr("DATE_FORMAT(s.starting_date, '%Y-%m-%d') AS contract_start_date"), "s.status AS contract_status", "s.service_type AS contract_service_type"))
					   			->group("tbr.id")
					   			->limitPage($i, 1000);
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("tbr.applicant_id = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("tbr.applicant_id IN (".implode(",", $candidate_to_sync).")");
		}
		publishQuery($sql);	
	}
	
	$sql = $db->select()->from(array("s"=>"subcontractors"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("s.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("s.userid IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("s"=>"subcontractors"), array(new Zend_Db_Expr("CONCAT(s.id, '_subcontractors') AS tracking_code"),
								"s.userid AS userid", "s.id AS key", new Zend_Db_Expr("CONCAT('subcontractors') AS `table`"), "s.status AS contract_status", "s.service_type AS contract_service_type",new Zend_Db_Expr("DATE_FORMAT(s.starting_date, '%Y-%m-%d') AS contract_start_date"),
								new Zend_Db_Expr("DATE_FORMAT(s.date_contracted, '%Y-%m-%d') AS `date`"), 	new Zend_Db_Expr("DATE_FORMAT(s.end_date, '%Y-%m-%d') AS `contract_end_date`"), 
								))	
								->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = s.userid", array("rs.admin_id AS assigned_recruiter_id"))
					   			->limitPage($i, 10000);
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("s.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("s.userid IN (".implode(",", $candidate_to_sync).")");
		}
		
		publishQuery($sql);	
	}
	
	$sql = $db->select()->from(array("sns"=>"staff_no_show"), array(new Zend_Db_Expr("SQL_CALC_FOUND_ROWS *")))->limit(1);
	if (isset($_GET["userid"])&&isset($_GET["mode"])){
		if ($mode=="update"){
			$sql->where("sns.userid = ?", $_GET["userid"]);
		}
	}else if (!empty($candidate_to_sync)){
		$sql->where("sns.userid IN (".implode(",", $candidate_to_sync).")");
	}
	$result = $db->fetchRow($sql);
	$count = $db->fetchOne("SELECT FOUND_ROWS()");
	$page = intval(ceil($count/10000))+1;
	for($i=1;$i<=$page;$i++){
		$sql = $db->select()->from(array("s"=>"staff_no_show"), array(new Zend_Db_Expr("CONCAT(s.id, '_staffnoshow') AS tracking_code"),
							"s.userid AS userid", "s.id AS key", new Zend_Db_Expr("CONCAT('staff_no_show') AS `table`"), "s.service_type AS staffnoshow_service_type",
							new Zend_Db_Expr("DATE_FORMAT(s.date, '%Y-%m-%d') AS `date`") 
							))	
							->joinLeft(array("rs"=>"recruiter_staff"), "rs.userid = s.userid", array("rs.admin_id AS assigned_recruiter_id"))
				   			->limitPage($i, 10000);
		if (isset($_GET["userid"])&&isset($_GET["mode"])){
			if ($mode=="update"){
				$sql->where("s.userid = ?", $_GET["userid"]);
			}
		}else if (!empty($candidate_to_sync)){
			$sql->where("s.userid IN (".implode(",", $candidate_to_sync).")");
		}
		publishQuery($sql);	
	}
	
}
