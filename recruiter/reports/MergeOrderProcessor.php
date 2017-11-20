<?php
class MergeOrderProcessor{
	private $db;
	
	private $status = "";
	private $page = 1;
	private $rows = 50;
	private $filter_type = 0, $date_from="", $date_to="", $filter_text="",  $keyword="", $recruiter="", $hiring_coordinator="";
	
	private $sorters = array();
	private $order_status = "", $service_type = "";
	
	/**
	 * Budget related variables ...
	 * @var string
	 */
	private $budget_from="", $budget_to="", $currency="", $cat_level="", $rate_type="", $work_type="";


	private $period_from = "", $period = "";

	private $age_from="", $age_to="";
	
	private $display = "Display";
	
	public function __construct($db){
		$this->db = $db;
		$this->gatherInput();
		
	}
	
	private function gatherInput(){
		$this->service_type = $_GET["service_type"];
		$this->order_status = $_GET["order_status"];

		if (isset($_GET["display"])){
			if ($_GET["display"]!="Displayed"){
				$this->display = $_GET["display"];
			}
		}

		if (isset($_GET["status"])){
			$this->status = $_GET["status"];
		}else{
			$this->status = "";
		}

		if (isset($_GET["page"])){
			$this->page = $_GET["page"];
		}else{
			$this->page = 1;
		}

		if (isset($_GET["rows"])){
			$this->rows = $_GET["rows"];
		}else{
			$this->rows = 100;
		}

		if (isset($_GET["filter_type"])){
			$this->filter_type = $_GET["filter_type"];
		}

		if (isset($_GET["recruiters"])){
			$this->recruiter = $_GET["recruiters"];
		}
		if (isset($_GET["hiring_coordinator"])){
			$this->hiring_coordinator = $_GET["hiring_coordinator"];
		}
		if (isset($_GET["age_from"])&&isset($_GET["age_to"])){
			$this->age_from = $_GET["age_from"];
			$this->age_to = $_GET["age_to"];
		}



		if (isset($_GET["sorter_length"])){
			$sorterLength = $_GET["sorter_length"];
			for($i=0;$i<$sorterLength;$i++){
				if (isset($_GET["column_".$i])){
					$this->sorters[] = array("column"=>$_GET["column_".$i], "direction"=>$_GET["direction_".$i]);
				}
			}
		}

		if ($this->filter_type==0){
			if (isset($_GET["keyword"])){
				$this->keyword = $_GET["keyword"];
			}


		}else{
			//Filter type

			if (($this->filter_type==1)||($this->filter_type==2)){
				$this->filter_text = $_GET["filter_text"];
			}else if ($this->filter_type==3){
				$this->date_from = $_GET["date_from"];
				$this->date_to = date("Y-m-d", strtotime("+1 day", strtotime($_GET["date_to"])));
			}else if ($this->filter_type==4){
				$this->budget_from = $_GET["budget_from"];
				$this->budget_to = $_GET["budget_to"];
				$this->currency = $_GET["currency"];
				$this->cat_level = $_GET["level"];
				$this->rate_type = $_GET["rate_type"];
				$this->work_type = $_GET["work_type"];
			}else if ($this->filter_type==5){
				$this->filter_text = $_GET["filter_text"];
			}else if ($this->filter_type==6){
				$this->period_from = $_GET["period_from"];
				$this->period = $_GET["period"];
			}

		}


	}
	
	public function getMergeASLSelect(){
		$db = $this->db;

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
		$onCustomOrder = $db->fetchAll($db->select()->from("gs_job_role_selection", array("session_id", "jsca_id", "request_date_added"))->where("session_id IS NOT NULL"));
		$sql = $db->select()->from(array("moi"=>"merged_order_items"), array())
						->joinInner(array("mo"=>"merged_orders"), "mo.id = moi.merged_order_id", array())
						->joinInner(array("tbr"=>"tb_request_for_interview"), "moi.jsca_id = tbr.job_sub_category_applicants_id AND DATE(moi.date_added) = DATE(tbr.date_added) AND (moi.lead_id = tbr.leads_id)",array())
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
							 new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END AS date_filled_up"),
							 new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END)) AS age"),
						  		 "CONCAT('TBA When JS is Filled') AS working_timezone",
						  		 "CONCAT('') AS gs_job_role_selection_id",
						  		 "CONCAT('') AS jr_list_id",
						  		 "CONCAT('') AS jr_cat_id",
						  		 "CONCAT('') AS level",
						  		 "CONCAT('') AS no_of_staff_needed",
						  		 "CONCAT('') AS assigned_recruiter_id",
						  		 "mo.service_type AS service_type",
						  		 "CONCAT('TBA When JS is Filled') AS job_title",
						  		 "CONCAT('') AS budget_hourly",
						  		 "CONCAT('') AS budget_monthly",
						     new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
							 new Zend_Db_Expr("mo.date_closed AS date_closed"),
							 new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 new Zend_Db_Expr("mo.id AS merged_order_id"),
						 	new Zend_Db_Expr("CONCAT('') AS created_reason"),
						 	new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code")
						 	
						))
					  ->where("moi.basis = 1")
					  ->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
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
					->where("tbr.session_id = ?", $order["session_id"])
					->where("DATE(tbr.date_added) = DATE(?)", $order["request_date_added"])
					->where("tbr.job_sub_category_applicants_id = ?", $order["jsca_id"]);
					
					$sql2 = $db->select()->from(array("tbr"=>"tb_request_for_interview"), array("id"))
					->joinInner(array("jsca"=>"job_sub_category_applicants"), "jsca.id=tbr.job_sub_category_applicants_id", array())
					->where("tbr.session_id = ?", $order["session_id"])
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
			if ($this->display=="Displayed"||$this->display=="Display"){
				$sql = $sql->where("tbr.id NOT IN ($result)");
			}else{
				$sql = $sql->where("tbr.id IN ($result)");
			}
		}else{
			if ($this->display=="Deleted"){
				$sql->having("leads_id < 0");
			}
		}
		$sql->group("moi.merged_order_id")->having("leads_id IS NOT NULL");
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		
		return $sql;
	}
	
	
	public function getMergeASLSelectViaJobSubCategory(){
		$db = $this->db;

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
							 new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END AS date_filled_up"),
							 new Zend_Db_Expr("(TO_DAYS(CURDATE()) - TO_DAYS(CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END)) AS age"),
						  		 "CONCAT('TBA When JS is Filled') AS working_timezone",
						  		 "CONCAT('') AS gs_job_role_selection_id",
						  		 "CONCAT('') AS jr_list_id",
						  		 "CONCAT('') AS jr_cat_id",
						  		 "CONCAT('') AS level",
						  		 "CONCAT('') AS no_of_staff_needed",
						  		 "CONCAT('') AS assigned_recruiter_id",
						  		 "mo.service_type AS service_type",
						  		 "CONCAT('TBA When JS is Filled') AS job_title",
						  		 "CONCAT('') AS budget_hourly",
						  		 "CONCAT('') AS budget_monthly",
						     new Zend_Db_Expr("tbr.job_sub_category_applicants_id AS jsca_id"),
							 new Zend_Db_Expr("mo.date_closed AS date_closed"),
							 new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 new Zend_Db_Expr("mo.id AS merged_order_id"),
							 new Zend_Db_Expr("CONCAT('') AS created_reason"),
							 new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code")
						))
					  ->where("moi.basis = 1")
					  ->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
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
			if ($this->display=="Displayed"||$this->display=="Display"){
				$sql = $sql->where("tbr.id NOT IN ($result)");
			}else{
				$sql = $sql->where("tbr.id IN ($result)");
			}
		}else{
			if ($this->display=="Deleted"){
				$sql->having("leads_id < 0");
			}
		}
		$sql->group("moi.merged_order_id")->having("leads_id IS NOT NULL");
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}	
		
		return $sql;
	}
	
	public function getMergeOrderSelect(){
		$db = $this->db;
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
										new Zend_Db_Expr("CASE WHEN DATE(mo.date_created) = DATE('1970-01-01') THEN moi.date_added ELSE mo.date_created END AS date_filled_up"),
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
								  		new Zend_Db_Expr("mo.date_closed AS date_closed"),
							 			new Zend_Db_Expr("CONCAT('MERGE') AS merge_status"),
							 			new Zend_Db_Expr("mo.id AS merged_order_id"),
						 				new Zend_Db_Expr("gs_jtd.created_reason AS created_reason"),
						 				new Zend_Db_Expr("CONCAT(mo.id, '-', mo.service_type, '-MERGE') AS tracking_code")
							 
						  ))
						  ->where("moi.basis = 1")
						  ->where("adm.hiring_coordinator = 'Y' OR l.hiring_coordinator_id IS NULL")
						  ->where("moi.service_type <> 'ASL'")
						  
						  
						  ;  
		if (!empty($job_orders_exclude)){
		  	if ($this->display=="Display"){
		  		$sql->where("gs_jtd.gs_job_titles_details_id NOT IN ($result)");
		  	}else{
		  		$sql->where("gs_jtd.gs_job_titles_details_id IN ($result)");
		  	}
		  }else{
		  	if ($this->display=="Deleted"){
		  		$sql->having("leads_id < 0");
		  	}
		}
		
		if (!($this->filter_type==7||$this->filter_type==6||$this->filter_type==3)){
			$sql->having("DATE(date_filled_up) >= DATE('2012-02-01')");	
		}
		$sql->group("gs_jtd.gs_job_titles_details_id");
		
		return $sql;
							
	}
	
}