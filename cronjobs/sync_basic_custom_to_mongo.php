<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php');
	$job_orders_exclude = $db->fetchAll($db->select()->from("job_orders_status")->where("job_orders_status.link_type = 'Custom' AND job_orders_status.status = 'Deleted'"));
	$result = "";
	if (!empty($job_orders_exclude)){
		$result = array();
		foreach($job_orders_exclude as $item){
			$result[] = $item["link_id"];
		}
		$result = implode(",", $result);
	}

	$excludeMerge = true;
	//load all merge orders that are custom for exclusion
	if ($excludeMerge){
		$merged_orders = $db->fetchAll($db->select()->from(array("moi"=>"merged_order_items"), array("gs_job_title_details_id"))->where("gs_job_title_details_id IS NOT NULL"));
		$merge_order_ids = array();
		if (!empty($merged_orders)){
			foreach($merged_orders as $merged_order){
				$merge_order_ids[] = $merged_order["gs_job_title_details_id"];
			}
			$merge_order_ids = implode(",", $merge_order_ids);
		}
	}

	
	$join = "joinRight";

	if ($first){
		$expr = new Zend_Db_Expr("l.fname AS lead_firstname");
	}else{
		$expr = new Zend_Db_Expr('l.fname AS lead_firstname');
	}
	
	$sql = $db->select()
	->from(array("l"=>"leads"),
	array($expr,
			"l.lname AS lead_lastname",
			"CONCAT(l.fname, ' ', l.lname) AS client",
			  		 "l.business_partner_id AS business_partner_id",
			  		 "l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
					 "l.timestamp AS timestamp",
					"l.id AS leads_id",
					"CONCAT('') AS asl_order_id"
					)
					)
					->joinLeft(array("adm"=>"admin"),
				"adm.admin_id = l.hiring_coordinator_id",
					array("adm.admin_fname AS hc_fname",
					"adm.admin_lname AS hc_lname")
					)
					->joinLeft(array("agn"=>"agent"),
				"agn.agent_no = l.business_partner_id",
					array("agn.fname AS bp_fname", "agn.lname AS bp_lname"))
					->$join(array("gs_jrs"=>"gs_job_role_selection"),
				  		"gs_jrs.leads_id = l.id",
					array()
					);

					$sql->$join(array("gs_jtd"=>"gs_job_titles_details"),
				 "gs_jtd.gs_job_role_selection_id = gs_jrs.gs_job_role_selection_id",
				 array(new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jrs.proposed_start_date END AS proposed_start_date"),
				 		"gs_jtd.gs_job_titles_details_id AS gs_job_titles_details_id",
						new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.work_status END AS work_status"),
						new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END) < DATE('2012-02-01') THEN 'finish' ELSE gs_jtd.status END AS status"),
						new Zend_Db_Expr("CASE WHEN gs_jrs.session_id IS NOT NULL THEN CASE WHEN gs_jrs.request_date_added IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jrs.filled_up_date, '%Y-%m-%d') END ELSE CASE WHEN gs_jrs.filled_up_date IS NOT NULL THEN DATE_FORMAT(gs_jrs.filled_up_date, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END END AS date_filled_up"),
				 new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(CASE WHEN gs_jrs.session_id IS NOT NULL THEN DATE_FORMAT(gs_jrs.request_date_added, '%Y-%m-%d') ELSE DATE_FORMAT(gs_jtd.date_filled_up, '%Y-%m-%d') END)) AS age"),
						new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.working_timezone END AS working_timezone"),
						"gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id",
						"gs_jtd.jr_list_id AS jr_list_id",
						"gs_jtd.jr_cat_id AS jr_cat_id",
			  			"gs_jtd.level AS level",
			  			"gs_jtd.no_of_staff_needed AS no_of_staff_needed",
						"gs_jtd.assigned_recruiter AS assigned_recruiter_id",
						new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'New JS Form Client' AND gs_jrs.jsca_id IS NOT NULL THEN gs_jtd.service_type ELSE 'ASL' END END END AS service_type"),
				 		new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.selected_job_title END AS job_title")
				 		
				 		))

				 		->joinLeft(array("jcl"=>"job_role_cat_list"),
				"jcl.jr_list_id = gs_jtd.jr_list_id",
				 		array(new Zend_Db_Expr("CASE WHEN gs_jtd.level = 'entry' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_entry_price * 12)/52)/5)/4) ELSE ((((jcl.jr_entry_price * 12)/52)/5)/8) END WHEN gs_jtd.level = 'middle' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_mid_price * 12)/52)/5)/4) ELSE ((((jcl.jr_mid_price * 12)/52)/5)/8) END WHEN gs_jtd.level = 'expert' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_expert_price * 12)/52)/5)/4) ELSE ((((jcl.jr_expert_price * 12)/52)/5)/8) END END AS budget_hourly"),
					  		new Zend_Db_Expr("CASE WHEN gs_jtd.level = 'entry' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN jcl.jr_entry_price*.55 ELSE jcl.jr_entry_price END WHEN gs_jtd.level = 'middle' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN (jcl.jr_mid_price*.55) ELSE jcl.jr_mid_price END WHEN gs_jtd.level = 'expert' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN jcl.jr_expert_price*.55 ELSE jcl.jr_expert_price END END AS budget_monthly"),
					  		new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NOT NULL THEN gs_jrs.jsca_id ELSE CONCAT('') END AS jsca_id"),
						    new Zend_Db_Expr("DATE_FORMAT(gs_jtd.date_closed, '%Y-%m-%d') AS date_closed"),
						    new Zend_Db_Expr("CONCAT('SINGLE') AS merge_status"),
						    new Zend_Db_Expr("CONCAT('') AS merged_order_id"),
							new Zend_Db_Expr("gs_jtd.created_reason AS created_reason"),
							new Zend_Db_Expr("CONCAT(gs_jtd.gs_job_titles_details_id, '-', CASE WHEN gs_jrs.jsca_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'New JS Form Client' AND gs_jrs.jsca_id IS NOT NULL THEN gs_jtd.service_type ELSE 'ASL' END END END) AS tracking_code"),
							new Zend_Db_Expr("(SELECT job_sub_category_id FROM mongo_job_orders_categories WHERE tracking_code = CONCAT(gs_jtd.gs_job_titles_details_id, '-', CASE WHEN gs_jrs.jsca_id IS NULL OR gs_jtd.created_reason = 'Converted-From-ASL' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'Closed-To-Replacement' THEN gs_jtd.service_type ELSE CASE WHEN gs_jtd.created_reason = 'New JS Form Client' AND gs_jrs.jsca_id IS NOT NULL THEN gs_jtd.service_type ELSE 'ASL' END END END)) AS job_order_sub_category_id"),							
							new Zend_Db_Expr("jcl.jr_currency AS currency"),
				  		)
					  )->joinLeft(array("pos"=>"posting"), "pos.job_order_id = gs_jtd.gs_job_titles_details_id", array("pos.id AS posting_id", new Zend_Db_Expr("CASE WHEN pos.classification IS NULL THEN 'non it' ELSE pos.classification END AS classification")))
					  
						->where("(adm.hiring_coordinator = 'Y' OR adm.hiring_coordinator = 'N') OR l.hiring_coordinator_id IS NULL")
					  ->where("gs_jrs.leads_id <> '' OR gs_jrs.leads_id IS NOT NULL")
					  ->having("date_filled_up IS NOT NULL")
					  ->group(array("bp_fname", "assigned_hiring_coordinator_id", "l.id", "gs_jtd.gs_job_titles_details_id"));

	 $sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($result)");
	 if (!empty($merged_orders)){
	 	$sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($merge_order_ids)");
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

$msg_body =json_encode(array("script"=>"/portal/cronjobs/sync_basic_custom_to_mongo.php","query"=>$sql->__toString()));
$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
$ch->basic_publish($msg, $exchange);
$ch->close();
$conn->close();	