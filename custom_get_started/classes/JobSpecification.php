<?php
require_once dirname(__FILE__) . "/../../lib/Portal.php";
class JobSpecification extends Portal {
	
	public function __construct($db){
		
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->smarty->assign("no_session", false);
		$this->smarty->assign("disabled", false);
		
		if(!isset($_SESSION['agent_no'])){
			if (!isset($_SESSION["admin_id"])){
				$this->smarty->assign("no_session", true);
			}
		}else{
			$_SESSION['status'] = "BusinessDeveloper";
		}
		if (!isset($_SESSION["agent_no"])){
			if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
				$this->smarty->assign("no_session", true);
			}	
		}
		if(isset($_REQUEST['disabled'])) {
			$this->smarty->assign("disabled", true);
		}
	}
	public function render() {
		$db = $this -> db;

		//defaults for entry level
		$levels = array();
		$levels[] = array("value" => "entry", "label" => "ENTRY");
		$levels[] = array("value" => "mid", "label" => "MID");
		$levels[] = array("value" => "expert", "label" => "EXPERT");

		$working_statuses = array();
		$working_statuses[] = array("value" => "Full-Time", "label" => "Full-Time 9hrs w/ 1hr break");
		$working_statuses[] = array("value" => "Part-Time", "label" => "Part Time 4hrs");

		$timezones = $db -> fetchAll($db -> select() -> from("timezone_lookup") -> order("timezone"));

		//initialize
		$smarty = $this -> smarty;
		$gs_job_titles_details_id = $_REQUEST["gs_job_titles_details_id"];
		$timezones = $db -> fetchAll($db -> select() -> from("timezone_lookup") -> order("timezone"));

		$db = $this -> db;

		$gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		$gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

		$gs_jtd["formatted_date_filled_up"] = date("F d, Y H:i:s A", strtotime($gs_jtd["date_filled_up"]));
		$gs_jrs = $db -> fetchRow($db -> select() -> from("gs_job_role_selection") -> where("gs_job_role_selection_id = ?", $gs_job_role_selection_id));

		$gs_jtd["lead"] = $db -> fetchRow($db -> select() -> from("leads", array("fname", "lname", "id")) -> where("id = ?", $gs_jrs["leads_id"]));
		try {
			if ($gs_jrs["filled_up_by_type"] == "leads") {
				$gs_jrs["filled_up_by"] = $db -> fetchRow($db -> select() -> from("leads", array("fname", "lname", "id")) -> where("id = ?", $gs_jrs["filled_up_by_id"]));

			} else if ($gs_jrs["filled_up_by_type"] == "admin") {
				$gs_jrs["filled_up_by"] = $db -> fetchRow($db -> select() -> from("admin", array("admin_fname AS fname", "admin_lname AS lname", "admin_id AS id")) -> where("admin_id = ?", $gs_jrs["filled_up_by_id"]));

			} else if ($gs_jrs["filled_up_by_type"] == "agent") {
				$gs_jrs["filled_up_by"] = $db -> fetchRow($db -> select() -> from("agent", array("fname", "lname", "agent_no AS id")) -> where("agent_no = ?", $gs_jrs["filled_up_by_id"]));

			}
		} catch(Exception $e) {
			if ($gs_jrs["filled_up_by_type"] == "leads") {
				$gs_jrs["filled_up_by"] = $db -> fetchRow($db -> select() -> from("leads", array("fname", "lname", "id")) -> where("id = ?", $gs_jrs["leads_id"]));
			}
		}
		$gs_jtd["start_work_val"] = $gs_jtd["start_work"];
		$gs_jtd["finish_work_val"] = $gs_jtd["finish_work"];
		
		if (strlen($gs_jtd["start_work"]) == 2) {
			$hour = intval($gs_jtd["start_work"]);
			if ($hour <= 11) {
				if ($hour == 0) {
					$gs_jtd["start_work"] = "12:00 AM";
				} else if ($hour < 10) {
					$gs_jtd["start_work"] = "0" . $hour . ":00 AM";
				} else {
					$gs_jtd["start_work"] = $hour . ":00 AM";
				}
			} else {
				$hour = $hour - 12;
				if ($hour < 10) {
					$gs_jtd["start_work"] = "0" . $hour . ":00 PM";
				} else {
					$gs_jtd["start_work"] = $hour . ":00 PM";
				}
			}
		}

		if (strlen($gs_jtd["finish_work"]) == 2) {
			$hour = intval($gs_jtd["finish_work"]);
			if ($hour <= 11) {
				if ($hour == 0) {
					$gs_jtd["finish_work"] = "12:00 AM";
				} else if ($hour < 10) {
					$gs_jtd["finish_work"] = "0" . $hour . ":00 AM";
				} else {
					$gs_jtd["finish_work"] = $hour . ":00 AM";
				}
			} else {
				$hour = $hour - 12;
				if ($hour < 10) {
					$gs_jtd["finish_work"] = "0" . $hour . ":00 PM";
				} else {
					$gs_jtd["finish_work"] = $hour . ":00 PM";
				}
			}
		}

		$final_credentials = array();

		$posting = $db -> fetchRow($db -> select() 
		                               -> from("posting") 
		                               -> where("job_order_id = ?", $gs_job_titles_details_id)
		                               ->order("id DESC"));
		if ($posting) {
			$smarty -> assign("has_ad", true);
		} else {
			$smarty -> assign("has_ad", false);
		}
		$smarty -> assign("posting", $posting);
        
        
        if(empty($posting['sub_category_id'])){
            $smarty -> assign("old_ad", true);
        }else{
           $smarty -> assign("old_ad", false); 
        }
        
		//budget
		$price_detail = "";
		try {
			if ($gs_jtd["created_reason"] == "New JS Form Client") {
				
				$shift_times = array();
				$shift_times[] = array("value" => "00:00", "label" => "12:00 AM");
				$shift_times[] = array("value" => "00:30", "label" => "12:30 AM");
				for ($i = 1; $i <= 9; $i++) {
					$shift_times[] = array("value" => "0{$i}:00", "label" => "0{$i}:00 AM");
					$shift_times[] = array("value" => "0{$i}:30", "label" => "0{$i}:30 AM");
				}
				for ($i = 10; $i <= 11; $i++) {
					$shift_times[] = array("value" => $i . ":00", "label" => $i . ":00 AM");
					$shift_times[] = array("value" => $i . ":30", "label" => $i . ":30 AM");
				}
				$i = 12;
				$shift_times[] = array("value" => $i . ":00", "label" => $i . ":00 PM");
				$shift_times[] = array("value" => $i . ":30", "label" => $i . ":30 PM");
			
				for ($i = 1; $i <= 9; $i++) {
					$k = $i + 12;
					$shift_times[] = array("value" => "{$k}:00", "label" => "0{$i}:00 PM");
					$shift_times[] = array("value" => "{$k}:30", "label" => "0{$i}:30 PM");
				}
				for ($i = 10; $i <= 11; $i++) {
					$k = $i + 12;
					$shift_times[] = array("value" => "{$k}:00", "label" => "{$i}:00 PM");
					$shift_times[] = array("value" => "{$k}:30", "label" => "{$i}:30 PM");
				}
				$smarty -> assign("shift_times", $shift_times);
				
				$level = $gs_jtd["level"];
				if ($level == "expert") {
					$level = "advanced";
				}
				try {
					$currency = $gs_jrs["currency"];
					$jo = $db -> fetchRow($db -> select() -> from(array("jscnp" => "job_sub_categories_new_prices")) -> joinLeft(array("jsc" => "job_sub_category"), "jsc.sub_category_id = jscnp.sub_category_id", array("sub_category_name")) -> where("level = ?", $level) -> where("currency = ?", $currency) -> where("jscnp.sub_category_id = ?", $gs_jtd["sub_category_id"]) -> where("active = ?", 1));

					if ($gs_jtd["work_status"] == "Part-Time") {
						$jo["value"] = number_format($jo["value"] * .6, 2);
						$jo["hourly_value"] = number_format(((($jo["value"] * 12) / 52) / 5) / 4, 2);
					} else {
						$jo["hourly_value"] = number_format(((($jo["value"] * 12) / 52) / 5) / 8, 2);
						$jo["value"] = number_format($jo["value"], 2);
					}
					$sql2 = $db -> select() -> from('currency_lookup') -> where("code = '{$currency}'");
					$money = $db -> fetchRow($sql2);

					$price_detail = sprintf("%s%s%s Hourly / %s%s Monthly", $gs_jtd["currency"], $money["sign"], $jo["hourly_value"], $money["sign"], $jo["value"]);
					$price_detail = '<span class="label label-info">' . $price_detail . '</span>';
				} catch(Exception $e) {
						$price_detail = $this -> getBudget($gs_jtd["jr_list_id"], $gs_jtd["work_status"], $gs_jtd["level"]);
						if (trim($price_detail) == "-") {
							$price_detail = "";
						} else {
							$price_detail = '<span class="label label-info">' . $price_detail . '</span>';
						}
				}

			} else {
				$price_detail = $this -> getBudget($gs_jtd["jr_list_id"], $gs_jtd["work_status"], $gs_jtd["level"]);
				if (trim($price_detail) == "-") {
					$price_detail = "";
				} else {
					$price_detail = '<span class="label label-info">' . $price_detail . '</span>';
				}
			}

		} catch(Exception $e) {
			$price_detail = "";
		}

		$smarty -> assign("price_detail", $price_detail);

		$gs_creds = $db -> fetchAll($db -> select() -> from("gs_job_titles_credentials") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

		foreach ($gs_creds as $gs_cred) {
			$gs_cred["description"] = trim($gs_cred["description"]);

			if ($gs_jtd["created_reason"] == "New JS Form Client"  || $gs_jtd["created_reason"] == "Converted-From-ASL") {
				if ($gs_cred["box"] == "skills" || $gs_cred["box"] == "tasks") {
					try {
						$gs_cred["description"] = $db -> fetchOne($db -> select() -> from("job_position_skills_tasks", array("value")) -> where("id = ?", $gs_cred["description"]));
					} catch(Exception $e) {
						$gs_cred["description"] = "";
					}
				}
				if ($gs_cred["box"] == "skills") {
					if ($gs_cred["rating"] == 1) {
						$gs_cred["rating"] = "Beginner";
					} else if ($gs_cred["rating"] == 2) {
						$gs_cred["rating"] = "Intermediate";
					} else {
						$gs_cred["rating"] = "Advanced";
					}
				}
			}

			if (trim($gs_cred["description"]) != "") {
				$final_credentials[] = $gs_cred;
			}
		}
		$gs_jtd["level_o"] = $gs_jtd["level"];

		$gs_jtd["level"] = strtoupper($gs_jtd["level"]);

		$smarty -> assign("levels", $levels);
		$smarty -> assign("working_statuses", $working_statuses);
		$smarty -> assign("timezones", $timezones);

		$smarty -> assign("gs_jtd", $gs_jtd);
		$smarty -> assign("gs_jrs", $gs_jrs);
		$smarty -> assign("timezones", $timezones);
		$smarty -> assign("gs_creds", $final_credentials);

		if ($gs_jtd["created_reason"] == "New JS Form Client"  || $gs_jtd["created_reason"] == "Converted-From-ASL") {

			$id = $_REQUEST["gs_job_titles_details_id"];
			$retries = 0;
			while(true){
				try{
					if (TEST) {
						$mongo = new MongoClient(MONGODB_TEST);
						$database = $mongo -> selectDB('prod_file_system');
						$database2 = $mongo -> selectDB('prod');
		
					} else {
						$mongo = new MongoClient(MONGODB_SERVER);
						$database = $mongo -> selectDB('prod_file_system');
						$database2 = $mongo -> selectDB('prod');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
			

			$job_spec_collection = $database2 -> selectCollection("job_specifications");
			
			$cursor = $job_spec_collection -> findOne(array("gs_job_titles_details_id" => $id));

			$manager_first_name = $cursor['details']['manager_first_name'];
			$manager_last_name = $cursor['details']['manager_last_name'];
			$manager_email = $cursor['details']['manager_email'];
			$manager_contact_number = $cursor['details']['manager_contact_number'];
		
			$smarty -> assign('manager_first_name',$manager_first_name);
			$smarty -> assign('manager_last_name',$manager_last_name);
			$smarty -> assign('manager_email',$manager_email);
			$smarty -> assign('manager_contact_number',$manager_contact_number);
		/*
			while ($cursor -> hasNext()) {
				$job_spec = $cursor -> getNext();
				$smarty -> assign("job_spec", $job_spec);
			}
		*/
			$gridfs = $database -> getGridFS();
			$cursor = $gridfs -> find(array("gs_job_titles_details_id" => $id));
			if ($cursor -> hasNext()) {
				$smarty -> assign("has_files", true);
			} else {
				$smarty -> assign("has_files", false);
			}
			$increase_demand = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "increase_demand") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			$replacement_post = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "replacement_post") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			$support_current = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "support_current") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			$meet_new = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "meet_new") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			$experiment_role = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "experiment_role") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			
			if ($increase_demand == "checked" || $replacement_post == "checked" || $support_current == "checked" || $meet_new == "checked" || $experiment_role == "checked") {
				$smarty -> assign("increase_demand", $increase_demand);
				$smarty -> assign("replacement_post", $replacement_post);
				$smarty -> assign("support_current", $support_current);
				$smarty -> assign("meet_new", $meet_new);
				$smarty -> assign("experiment_role", $experiment_role);
				$smarty -> assign("optional_answer", true);
			} else {
				$smarty -> assign("optional_answer", false);
			}

			$smarty -> display("new_job_spec.tpl");
		} else {
			if ($gs_jtd["jr_cat_id"] == 1) {

				//telemarkerter flag
				if (in_array($gs_jtd["jr_list_id"], array(1, 12, 23))) {

					$q1 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q1") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$q2 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q2") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$q3 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q3") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$q4 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q4") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$lead_generation = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "lead_generation") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$telemarketer_hrs = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "telemarketer_hrs") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$campaign_type = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "campaign_type") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$call_type = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "call_type") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

					$smarty -> assign("q1", $q1);
					$smarty -> assign("q2", $q2);
					$smarty -> assign("q3", $q3);
					$smarty -> assign("q4", $q4);
					$smarty -> assign("telemarketer_hrs", $telemarketer_hrs);
					$smarty -> assign("lead_generation", $lead_generation);
					$smarty -> assign("campaign_type", $campaign_type);
					$smarty -> assign("call_type", $call_type);
					$smarty -> assign("telemarketer_flag", true);

				} else {
					$smarty -> assign("telemarketer_flag", false);
				}

				//Writer id's 5 = AUD, 16 = USD, 27 = POUNDS
				if (in_array($gs_jtd["jr_list_id"], array(5, 16, 27))) {
					$writer_types = $db -> fetchAll($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "writer_type") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$smarty -> assign("writer_flag", true);
					$smarty -> assign("writer_types", $writer_types);
				} else {
					$smarty -> assign("writer_flag", false);
				}

				//Marketing Assistant
				if (in_array($gs_jtd["jr_list_id"], array(2, 13, 24))) {

					$staff_phone = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "staff_phone") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
					$smarty -> assign("staff_phone", $staff_phone);
					$smarty -> assign("marketing_assistant_flag", true);
				} else {
					$smarty -> assign("marketing_assistant_flag", false);
				}

				//Graphic Designer
				if (in_array($gs_jtd["jr_list_id"], array(3, 13, 25))) {
					$smarty -> assign("graphic_designer_flag", true);
				} else {
					$smarty -> assign("graphic_designer_flag", false);
				}

				$smarty -> display("marketing_job_spec.tpl");
			} else if ($gs_jtd["jr_cat_id"] == 2) {
				$onshore = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "onshore") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
				$smarty -> assign("onshore", $onshore);
				$smarty -> display("it_job_spec.tpl");
			} else if ($gs_jtd["jr_cat_id"] == 3) {
				$smarty -> display("office_job_spec.tpl");
			} else {
				$smarty -> display("job_spec.tpl");
			}

		}

	}

	public function update() {
		$db = $this -> db;
        
        //bug fix on updating job order form
        $leads_id = $db->fetchOne($db->select()->from(array("gs_jtd"=>"gs_job_titles_details"), array())->joinLeft(array("gs_jrs"=>"gs_job_role_selection"), "gs_jrs.gs_job_role_selection_id = gs_jtd.gs_job_role_selection_id", array("gs_jrs.leads_id"))->where("gs_jtd.gs_job_titles_details_id = ?", $_REQUEST["gs_job_titles_details_id"]));
		$data = array("jr_list_id" => $_REQUEST["jr_list_id"], "no_of_staff_needed" => $_REQUEST["no_of_staff_needed"], "level" => $_REQUEST["level"], "work_status" => $_REQUEST["work_status"], "working_timezone" => $_REQUEST["working_timezone"], "start_work" => $_REQUEST["start_work"], "finish_work" => $_REQUEST["finish_work"], "selected_job_title"=>$_REQUEST["selected_job_title"]);

		$db -> update("gs_job_titles_details", $data, $db -> quoteInto("gs_job_titles_details_id = ?", $_REQUEST["gs_job_titles_details_id"]));


        $db->delete("mongo_job_orders", $db->quoteInto("leads_id = ?", $leads_id));

        if (TEST){
            file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
            file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
            file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
            file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
            file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
            file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
            
        }else{
            file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_no_job_category_to_mongo.php");
            file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_asl_via_job_category_to_mongo.php");
            file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_basic_custom_to_mongo.php");
            file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php");
            file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php");
            file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_merge_custom_to_mongo.php");
            
        }
		return array("success" => true);
	}

	private function getBudget($jr_list_id, $work_status, $level) {
		$db = $this -> db;
		if ($jr_list_id) {
			$query = $db -> select() -> from('job_role_cat_list') -> where('jr_list_id = ?', $jr_list_id);

			$resulta = $db -> fetchRow($query);
			$currency = $resulta['jr_currency'];

			$sql2 = $db -> select() -> from('currency_lookup') -> where("code = '{$currency}'");
			$money = $db -> fetchRow($sql2);
			$currency_lookup_id = $money['id'];
			$currency = $money['code'];
			$currency_symbol = $money['sign'];

			$jr_status = $resulta['jr_status'];
			$jr_list_id = $resulta['jr_list_id'];
			$jr_cat_id = $resulta['jr_cat_id'];

			$jr_entry_price = $resulta['jr_entry_price'];
			$jr_mid_price = $resulta['jr_mid_price'];
			$jr_expert_price = $resulta['jr_expert_price'];

			if ($jr_status == "system" || $jr_status == "manual") {
				if ($work_status == "Part-Time") {
					//55% of the original price
					$jr_entry_price = number_format(($jr_entry_price * .55), 2, '.', ',');
					$jr_mid_price = number_format(($jr_mid_price * .55), 2, '.', ',');
					$jr_expert_price = number_format(($jr_expert_price * .55), 2, '.', ',');

					$hr_entry_price = number_format((((($jr_entry_price * 12) / 52) / 5) / 4), 2, ".", ",");
					$hr_mid_price = number_format((((($jr_mid_price * 12) / 52) / 5) / 4), 2, ".", ",");
					$hr_expert_price = number_format((((($jr_expert_price * 12) / 52) / 5) / 4), 2, ".", ",");

					$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency, $currency_symbol, $hr_entry_price, $currency_symbol, $jr_entry_price);
					$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency, $currency_symbol, $hr_mid_price, $currency_symbol, $jr_mid_price);
					$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency, $currency_symbol, $hr_expert_price, $currency_symbol, $jr_expert_price);

				} else {

					$hr_entry_price = number_format((((($jr_entry_price * 12) / 52) / 5) / 8), 2, ".", ",");
					$hr_mid_price = number_format((((($jr_mid_price * 12) / 52) / 5) / 8), 2, ".", ",");
					$hr_expert_price = number_format((((($jr_expert_price * 12) / 52) / 5) / 8), 2, ".", ",");

					$entry_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency, $currency_symbol, $hr_entry_price, $currency_symbol, $jr_entry_price);
					$mid_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency, $currency_symbol, $hr_mid_price, $currency_symbol, $jr_mid_price);
					$expert_price_str = sprintf("%s%s%s Hourly / %s%s Monthly", $currency, $currency_symbol, $hr_expert_price, $currency_symbol, $jr_expert_price);

				}
			} else {
				$entry_price_str = "-";
				$mid_price_str = "-";
				$expert_price_str = "-";
			}

			if ($level == "entry") {
				$amount_str = $entry_price_str;
			} else if ($level == "mid") {
				$amount_str = $mid_price_str;
			} else {
				$amount_str = $expert_price_str;
			}

			return $amount_str;
		} else {
			return "";
		}
	}

}
