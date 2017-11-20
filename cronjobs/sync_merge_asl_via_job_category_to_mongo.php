<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php');

	$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'ASL' AND job_orders_status.status = 'Deleted'"));
		$result = "";
		if (!empty($job_orders_exclude)){
			$result = array();
			foreach($job_orders_exclude as $item){
				try{
					$lead = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("leads_id"))->where("tbr.session_id = {$item["link_id"]}"));
					$lead = $lead["leads_id"];
						
					$requests = $db->fetchAll($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinLeft(array("jsca"=>"job_sub_category_applicants"), "jsca.id = tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $lead)
					->where("DATE(tbr.date_added) = DATE('{$item["date_added"]}')")
					->where("tbr.job_sub_category_applicants_id = {$item["jsca_id"]} OR jsca.sub_category_id = {$item["jsca_id"]}"));

					foreach($requests as $request){
						$result[] = $request["id"];
					}
				}catch(Exception $e){
						
				}
			}
			if (!empty($result)){
				$result = implode(",", $result);
			}else{
				$result="";
			}
		}
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "leads_id" ,"jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));

		$sql = $db->select()->from(array("moi"=>"merged_order_items"), array())
						->joinInner(array("mo"=>"merged_orders"), "mo.id = moi.merged_order_id", array())
						->joinLeft(array("gs_jtd"=>"gs_job_titles_details"), 
							 "gs_jtd.gs_job_titles_details_id = moi.gs_job_title_details_id",
							array()
						)
						->joinInner(array("tbr"=>"tb_request_for_interview"), "DATE(moi.date_added) = DATE(tbr.date_added) AND (moi.lead_id = tbr.leads_id)",array())
						->joinInner(array("jsca"=>"job_sub_category_applicants"),"jsca.sub_category_id = moi.jsca_id",array())
						->joinInner(array("l"=>"leads"),"tbr.leads_id = l.id",
									array("l.fname AS lead_firstname",
									"l.lname AS lead_lastname",
									 "CONCAT(l.fname, ' ', l.lname) AS client",
							  		 "l.business_partner_id AS business_partner_id",
							  		 "l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
									 "l.timestamp AS timestamp",
									 "l.id AS leads_id",
									  "CONCAT('') AS asl_order_id"))
						->joinLeft(array("adm"=>"admin"),"adm.admin_id = l.hiring_coordinator_id",array(
							 new Zend_Db_Expr("case when adm.admin_fname is null then 'zzz' else adm.admin_fname end AS hc_fname"),
							 new Zend_Db_Expr("case when adm.admin_lname is null then 'zzz' else adm.admin_lname end AS hc_lname")))
						->joinLeft(array("agn"=>"agent"), "agn.agent_no = l.business_partner_id",array(
							 new Zend_Db_Expr("agn.fname AS bp_fname"),
							 new Zend_Db_Expr("agn.lname AS bp_lname"),
							 new Zend_Db_Expr("CONCAT('TBA When JS is Filled') AS proposed_start_date"),
							 new Zend_Db_Expr("CONCAT('') AS gs_job_titles_details_id"),
							 "CONCAT('TBA When JS is Filled') AS work_status",
							new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END) < DATE('2012-02-01') THEN 'Closed' ELSE CASE WHEN mo.order_status IS NULL AND tbr.status = 'CANCELLED' THEN 'Cancel' ELSE mo.order_status END END AS status"),
							 new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN DATE_FORMAT(moi.date_added, '%Y-%m-%d') ELSE DATE_FORMAT(mo.date_created, '%Y-%m-%d') END AS date_filled_up"),
							 new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END)) AS age"),
						  		 "CONCAT('TBA When JS is Filled') AS working_timezone",
						  		 "CONCAT('') AS gs_job_role_selection_id",
						  		 "CONCAT('') AS jr_list_id",
						  		 "CONCAT('') AS jr_cat_id",
						  		 "CONCAT('') AS level",
						  		 "CONCAT('') AS no_of_staff_needed",
						  		 "CONCAT('') AS assigned_recruiter_id",
						  		 "mo.service_type AS service_type",
						  		 new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN CONCAT('TBA When JS is Filled') ELSE gs_jtd.selected_job_title END AS job_title"),
						  		 "CONCAT('') AS budget_hourly",
						  		 "CONCAT('') AS budget_monthly",
						     new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
							 new Zend_Db_Expr("DATE_FORMAT(mo.date_closed, '%Y-%m-%d') AS date_closed"),
							 new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 new Zend_Db_Expr("mo.id AS merged_order_id"),
							 new Zend_Db_Expr("CONCAT('') AS created_reason"),
							 new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code"),
							 new Zend_Db_Expr("(SELECT job_sub_category_id FROM mongo_job_orders_categories WHERE tracking_code = CONCAT(mo.id, '-', mo.service_type, '-MERGE')) AS job_order_sub_category_id"),	
							 new Zend_Db_Expr("CONCAT('non it') AS classification")
							
							
						))
					  ->where("moi.basis = 1")
					  ->where("(adm.hiring_coordinator = 'Y' OR adm.hiring_coordinator = 'N') OR l.hiring_coordinator_id IS NULL")
					 ->where("mo.service_type = 'ASL'")
					 ->where("tbr.service_type = 'ASL'")
					 ->where("tbr.status <> 'ARCHIVED'");
					// ->where("tbr.status NOT IN ('CANCELLED')");
		
		
		if (!empty($onCustomOrder)){
			$orders = array();
			$ids = array();
			foreach($onCustomOrder as $order){
				try{
					$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("tbr.job_sub_category_applicants_id = ?", $order["jsca_id"]);
					
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
					->where("tbr.leads_id = ?", $order["leads_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("jsca.sub_category_id = ?", $order["jsca_id"]);
					
					$requests = $db->fetchAll($db->select()->union(array($sql1, $sql2)));
					foreach($requests as $request){
						$ids[] = $request["id"];
					}
				}catch(Exception $e){
					continue;
				}
					
			}

			if (!empty($ids)){
				$ids = implode(",", $ids);
				$sql = $sql->where("tbr.id NOT IN ($ids)");
			}
			
		
		}
		
		
		//load merge order with details
		
	
		$mergeCustoms  = $db->fetchAll($db->select()->from("merged_order_items", array("merged_order_id"))->where("basis = 1")->where("service_type <> 'ASL'"));
		$mergeIds = array();
		foreach($mergeCustoms as $mergeCustom){
			$mergeIds[] = $mergeCustom["merged_order_id"];
		}
		if (!empty($mergeIds)){
			$sql->where("moi.merged_order_id NOT IN (".implode(",", $mergeIds).")");
		}
			
		if (!empty($job_orders_exclude)&&$result!=""){
			$sql = $sql->where("tbr.id NOT IN ($result)");	
		}
		$sql->group("moi.merged_order_id")->having("leads_id IS NOT NULL");
		$sql->having("tracking_code NOT IN (SELECT tracking_code FROM `mongo_job_orders`)")->having("tracking_code NOT IN (SELECT tracking_code FROM `deleted_job_orders`)");


$exchange = '/';
$queue = 'receive_job_order_query';
$consumer_tag = 'consumer';
$conn = new AMQPConnection(MQ_HOST, MQ_PORT,"job_order", "job_order", "job_order");
$ch = $conn->channel();
$ch->queue_declare($queue, false, true, false, false);
$ch->exchange_declare($exchange, 'direct', false, true, false);
$ch->queue_bind($queue, $exchange);

$msg_body =json_encode(array("script"=>"/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php","query"=>$sql->__toString()));
$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
$ch->basic_publish($msg, $exchange);
$ch->close();
$conn->close();		