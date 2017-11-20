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
	
	
	$sql = $db->select()->from(array("moi"=>"merged_order_items"),
							array()
						)->joinInner(array("mo"=>"merged_orders"), 
							"mo.id = moi.merged_order_id",
							array()
						)->joinInner(array("gs_jtd"=>"gs_job_titles_details"), 
							 "gs_jtd.gs_job_titles_details_id = moi.gs_job_title_details_id",
							array()
						)->joinInner(array("gs_jrs"=>"gs_job_role_selection"),
							"gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id",
						array())
						->joinInner(array("l"=>"leads"), "l.id = gs_jrs.leads_id", array(
							"l.fname AS lead_firstname",
							"l.lname AS lead_lastname",
							"CONCAT(l.fname, ' ', l.lname) AS client",
					  		"l.business_partner_id AS business_partner_id",
					  		"l.hiring_coordinator_id AS assigned_hiring_coordinator_id",
							"l.timestamp AS timestamp",
							"l.id AS leads_id",
							"CONCAT('') AS asl_order_id",
						
						))
						->joinLeft(array("adm"=>"admin"), "adm.admin_id = l.hiring_coordinator_id",array(
							"adm.admin_fname AS hc_fname",
							"adm.admin_lname AS hc_lname"))
						->joinLeft(array("agn"=>"agent"),"agn.agent_no = l.business_partner_id",array(
							"agn.fname AS bp_fname",
						    "agn.lname AS bp_lname",
						))
				 		->joinLeft(array("jcl"=>"job_role_cat_list"),
								"jcl.jr_list_id = gs_jtd.jr_list_id",
				 				array(new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jrs.proposed_start_date END AS proposed_start_date"),
							  		"gs_jtd.gs_job_titles_details_id AS gs_job_titles_details_id",
									new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.work_status END AS work_status"),
									new Zend_Db_Expr("CASE WHEN DATE(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END) < DATE('2012-02-01') THEN 'Closed' ELSE mo.order_status END AS status"),
									new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN DATE_FORMAT(moi.date_added, '%Y-%m-%d') ELSE DATE_FORMAT(mo.date_created, '%Y-%m-%d') END AS date_filled_up"),
							 		new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(DATE_FORMAT(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END, '%Y-%m-%d'))) AS age"),
									new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.working_timezone END AS working_timezone"),
									"gs_jtd.gs_job_role_selection_id AS gs_job_role_selection_id",
									"gs_jtd.jr_list_id AS jr_list_id",
									"gs_jtd.jr_cat_id AS jr_cat_id",
						  			"gs_jtd.level AS level",
						  			"gs_jtd.no_of_staff_needed AS no_of_staff_needed",
									"gs_jtd.assigned_recruiter AS assigned_recruiter_id",
									new Zend_Db_Expr("mo.service_type AS service_type"),
							 		new Zend_Db_Expr("CASE WHEN gs_jtd.selected_job_title IS NULL THEN 'TBA When JS is Filled' ELSE gs_jtd.selected_job_title END AS job_title"),
									new Zend_Db_Expr("CASE WHEN gs_jtd.level = 'entry' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_entry_price * 12)/52)/5)/4) ELSE ((((jcl.jr_entry_price * 12)/52)/5)/8) END WHEN gs_jtd.level = 'middle' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_mid_price * 12)/52)/5)/4) ELSE ((((jcl.jr_mid_price * 12)/52)/5)/8) END WHEN gs_jtd.level = 'expert' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN ((((jcl.jr_expert_price * 12)/52)/5)/4) ELSE ((((jcl.jr_expert_price * 12)/52)/5)/8) END END AS budget_hourly"),
							  		new Zend_Db_Expr("CASE WHEN gs_jtd.level = 'entry' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN jcl.jr_entry_price*.55 ELSE jcl.jr_entry_price END WHEN gs_jtd.level = 'middle' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN (jcl.jr_mid_price*.55) ELSE jcl.jr_mid_price END WHEN gs_jtd.level = 'expert' THEN CASE WHEN gs_jtd.work_status = 'Part-Time' THEN jcl.jr_expert_price*.55 ELSE jcl.jr_expert_price END END AS budget_monthly"),
									new Zend_Db_Expr("CASE WHEN gs_jrs.jsca_id IS NOT NULL THEN gs_jrs.jsca_id ELSE CONCAT('') END AS jsca_id"),
							  		new Zend_Db_Expr("DATE_FORMAT(mo.date_closed, '%Y-%m-%d') AS date_closed"),
						 			new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
						 			new Zend_Db_Expr("mo.id AS merged_order_id"),
					 				new Zend_Db_Expr("gs_jtd.created_reason AS created_reason"),
					 				new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code"),
					 				new Zend_Db_Expr("(SELECT job_sub_category_id FROM mongo_job_orders_categories WHERE tracking_code = CONCAT(mo.id, '-', mo.service_type, '-MERGE')) AS job_order_sub_category_id"),							
					 				new Zend_Db_Expr("jcl.jr_currency AS currency")
						 
					  ))->joinLeft(array("pos"=>"posting"), "pos.job_order_id = gs_jtd.gs_job_titles_details_id", array("pos.id AS posting_id", new Zend_Db_Expr("CASE WHEN pos.classification IS NULL THEN 'non it' ELSE pos.classification END AS classification")))
					  ->where("moi.basis = 1")
					  ->where("(adm.hiring_coordinator = 'Y' OR adm.hiring_coordinator = 'N') OR l.hiring_coordinator_id IS NULL")
					  
					  
					  ;  
	if (!empty($job_orders_exclude)){
  		$sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($result)");
  	}
	
	$sql->group("gs_jtd.gs_job_titles_details_id");
	 $sql->having("tracking_code NOT IN (SELECT tracking_code FROM `mongo_job_orders`)")->having("tracking_code NOT IN (SELECT tracking_code FROM `deleted_job_orders`)");

$exchange = '/';
$queue = 'receive_job_order_query';
$consumer_tag = 'consumer';
$conn = new AMQPConnection(MQ_HOST, MQ_PORT,"job_order", "job_order", "job_order");
$ch = $conn->channel();
$ch->queue_declare($queue, false, true, false, false);
$ch->exchange_declare($exchange, 'direct', false, true, false);
$ch->queue_bind($queue, $exchange);

$msg_body =json_encode(array("script"=>"/portal/cronjobs/sync_merge_custom_to_mongo.php","query"=>$sql->__toString()));
$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
$ch->basic_publish($msg, $exchange);
$ch->close();
$conn->close();		
