<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php');
$excludeMerge = true;

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
	
	//load all merge orders that are asl for exclusion
	if ($excludeMerge){
		$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("jsca_id", "date_added", "lead_id"))->where("service_type = 'ASL'"));
		$merge_order_ids = array();
		if (!empty($merged_orders)){
			foreach($merged_orders as $merged_order){
				try{
					$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
						->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
						->where("tbr.leads_id = ?", $merged_order["lead_id"])
						->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
							->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
							->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
							->where("tbr.leads_id = ?", $merged_order["lead_id"])
							->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
					$requests = $db->fetchAll($db->select()->union(array($sql2, $sql1)));
					foreach($requests as $request){
						$merge_order_ids[] = $request["id"];
					}
				}catch(Exception $e){
					//individual fixed trapper
					try{
						$sql1 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
							->where("tbr.job_sub_category_applicants_id = ?", $merged_order["jsca_id"])
							->where("tbr.leads_id = ?", $merged_order["lead_id"])
							->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
						$requests = $db->fetchAll($sql1);
						foreach($requests as $request){
							$merge_order_ids[] = $request["id"];
						}	
					}catch(Exception $e){
						
					}
					
					try{
						$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("tbr.id"))
							->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
							->where("jsca.sub_category_id = ?", $merged_order["jsca_id"])
							->where("tbr.leads_id = ?", $merged_order["lead_id"])
							->where("DATE(tbr.date_added) = DATE(?)", $merged_order["date_added"]);
						$requests = $db->fetchAll($sql2);	
						foreach($requests as $request){
							$merge_order_ids[] = $request["id"];
						}	
					}catch(Exception $e){
						
					}
					
				}
				
			}
			$merge_order_ids = implode(",", $merge_order_ids);
		}
	}
	
	$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "leads_id" ,"jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
	$sql = $db->select()
	->from(array("tbr"=>"tb_request_for_interview"),
	array())
	->joinInner(array("l"=>"leads"),
						"tbr.leads_id = l.id",
	array("l.fname AS lead_firstname",
							"l.lname AS lead_lastname",
							 "CONCAT(l.fname, ' ', l.lname) AS client",
					  		 "l.business_partner_id AS business_partner_id",
					  		 "l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
							 "l.timestamp AS timestamp",
							 "l.id AS leads_id",
							 "CONCAT('') AS asl_order_id")				
	)
	->joinLeft(array("rfos"=>"request_for_interview_job_order_session"),
							new Zend_Db_Expr("(CAST(rfos.job_sub_category_applicants_id AS signed) = CAST(tbr.job_sub_category_applicants_id AS signed) AND DATE(rfos.date_added) = DATE(tbr.date_added) AND (rfos.lead_id = tbr.leads_id))"),
	array())
		
	->joinLeft(array("adm"=>"admin"),
									"adm.admin_id = l.hiring_coordinator_id",
	array(
	new Zend_Db_Expr("case when adm.admin_fname is null then 'zzz' else adm.admin_fname end AS hc_fname"),
	new Zend_Db_Expr("case when adm.admin_lname is null then 'zzz' else adm.admin_lname end AS hc_lname"))
	)
	->joinLeft(array("agn"=>"agent"),
							"agn.agent_no = l.business_partner_id",
	array("agn.fname AS bp_fname",
								"agn.lname AS bp_lname",
							 	"CONCAT('TBA When JS is Filled') AS proposed_start_date",
								 "CONCAT('') AS gs_job_titles_details_id",
								 "CONCAT('TBA When JS is Filled') AS work_status",
	//new Zend_Db_Expr("(SELECT DISTINCT rfos1.status FROM request_for_interview_job_order_session rfos1 WHERE (rfos1.lead_id = tbr.leads_id AND DATE(rfos1.date_added) = DATE(tbr.date_added) AND rfos1.job_sub_category_applicants_id = tbr.job_sub_category_applicants_id) OR rfos1.session_id = tbr.session_id) AS status"),
								new Zend_Db_Expr("CASE WHEN DATE(tbr.date_added) < DATE('2012-02-01') THEN 'finish' ELSE CASE WHEN rfos.status IS NULL AND tbr.status='CANCELLED' THEN 'cancel' ELSE rfos.status END END AS status"),
								new Zend_Db_Expr("DATE_FORMAT(tbr.date_added, '%Y-%m-%d') AS date_filled_up"),
								new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(tbr.date_added)) AS age"),
						  		 "CONCAT('TBA When JS is Filled') AS working_timezone",
						  		 "CONCAT('') AS gs_job_role_selection_id",
						  		 "CONCAT('') AS jr_list_id",
						  		 "CONCAT('') AS jr_cat_id",
						  		 "CONCAT('') AS level",
						  		 "CONCAT('') AS no_of_staff_needed",
						  		 "CONCAT('') AS assigned_recruiter_id",
						  		 "CONCAT('ASL') AS service_type",
						  		 "CONCAT('TBA When JS is Filled') AS job_title",
						  		 "CONCAT('') AS budget_hourly",
						  		 "CONCAT('') AS budget_monthly",
	//new Zend_Db_Expr("CASE WHEN tbr.session_id <> 0 THEN tbr.session_id ELSE (SELECT session_id FROM tb_request_for_interview_orders tbroq WHERE tbroq.id = tbr.order_id) END AS session_id"),
	new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
	new Zend_Db_Expr("DATE_FORMAT(rfos.date_closed, '%Y-%m-%d') AS date_closed"),
	new Zend_Db_Expr("CONCAT('SINGLE') AS merge_status"),
	new Zend_Db_Expr("CONCAT('') AS merged_order_id"),
	new Zend_Db_Expr("CONCAT('') AS created_reason"),
	new Zend_Db_Expr("CONCAT(DATE_FORMAT(tbr.date_added, '%Y%m%d'), tbr.job_sub_category_applicants_id, tbr.leads_id, '-ASL') AS tracking_code"),
	new Zend_Db_Expr("(SELECT job_sub_category_id FROM mongo_job_orders_categories WHERE tracking_code = CONCAT(DATE_FORMAT(tbr.date_added, '%Y%m%d'), tbr.job_sub_category_applicants_id, tbr.leads_id, '-ASL')) AS job_order_sub_category_id"),
	new Zend_Db_Expr("CONCAT('non it') AS classification")
	))
	->where("(adm.hiring_coordinator = 'Y' OR adm.hiring_coordinator = 'N') OR l.hiring_coordinator_id IS NULL")
	->where("tbr.service_type = 'ASL'")
	->where("tbr.status <> 'ARCHIVED'")
	->where("tbr.job_sub_category_applicants_id = 0")
	//->where("tbr.status NOT IN ('CANCELLED')")
	->group("tracking_code");
		
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
			$sql->where("tbr.id NOT IN ($ids)");
		}
	}
		
	if (!empty($job_orders_exclude)&&$result!=""){
		$sql->where("tbr.id NOT IN ($result)");
	}
	if ($excludeMerge&&!empty($merged_orders)){
		$sql->where("tbr.id NOT IN($merge_order_ids)");
	}
	 $sql
	 ->having("tracking_code NOT IN (SELECT tracking_code FROM `mongo_job_orders`)")
	 ->having("tracking_code NOT IN (SELECT tracking_code FROM `deleted_job_orders`)");
$exchange = '/';
$queue = 'receive_job_order_query';
$consumer_tag = 'consumer';
$conn = new AMQPConnection(MQ_HOST, MQ_PORT,"job_order", "job_order", "job_order");
$ch = $conn->channel();
$ch->queue_declare($queue, false, true, false, false);
$ch->exchange_declare($exchange, 'direct', false, true, false);
$ch->queue_bind($queue, $exchange);

$msg_body =json_encode(array("script"=>"/portal/cronjobs/sync_asl_no_job_category_to_mongo.php","query"=>$sql->__toString()));
$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
$ch->basic_publish($msg, $exchange);
$ch->close();
$conn->close();	
