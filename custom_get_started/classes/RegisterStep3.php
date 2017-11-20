<?php
require_once dirname(__FILE__) . "/../../lib/CheckLeadsFullName.php";
require_once dirname(__FILE__) . "/../../lib/addLeadsInfoHistoryChanges.php";
require_once dirname(__FILE__) . "/../../tools/CouchDBMailbox.php";
require_once dirname(__FILE__) . "/../../jobseeker/classes/QQFileUploader.php";
require_once dirname(__FILE__) . "/../lib/get_started_function.php";
include_once dirname(__FILE__)."/location_constants.php";
require_once dirname(__FILE__). "/../../lib/Contact.php";
require_once dirname(__FILE__). "/ShowPrice.php";

function configurePriceRate($jr_list_id, $level, $work_status, $currency_lookup_id) {
	global $db;
	$query = "SELECT * FROM job_role_cat_list WHERE jr_list_id = $jr_list_id;";
	$result = $db -> fetchRow($query);
	$jr_status = $result['jr_status'];
	$jr_entry_price = $result['jr_entry_price'];
	$jr_mid_price = $result['jr_mid_price'];
	$jr_expert_price = $result['jr_expert_price'];

	if ($currency_lookup_id != "") {
		$sql = $db -> select() -> from('currency_lookup') -> where('id = ?', $currency_lookup_id);
		$currency_lookup = $db -> fetchRow($sql);
		$currency = $currency_lookup['code'];
		$currency_symbol = $currency_lookup['sign'];
	}

	if ($jr_status == "system") {

		if ($level == "entry") {
			if ($work_status == "Full-Time") {
				$selected_job_title_price = $result['jr_entry_price'];
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 8), 2, ".", ",");
			} else {
				$selected_job_title_price = ($result['jr_entry_price'] * .55);
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 4), 2, ".", ",");
			}
		}

		if ($level == "mid") {
			if ($work_status == "Full-Time") {
				$selected_job_title_price = $result['jr_mid_price'];
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 8), 2, ".", ",");
			} else {
				$selected_job_title_price = ($result['jr_mid_price'] * .55);
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 4), 2, ".", ",");
			}
		}
		if ($level == "expert") {
			if ($work_status == "Full-Time") {
				$selected_job_title_price = $result['jr_expert_price'];
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 8), 2, ".", ",");
			} else {
				$selected_job_title_price = ($result['jr_expert_price'] * .55);
				$hr_price = number_format((((($selected_job_title_price * 12) / 52) / 5) / 4), 2, ".", ",");
			}
		}

		$price_str = sprintf("%s%s%s/Hourly %s%s/Monthly ", $currency, $currency_symbol, $hr_price, $currency_symbol, $selected_job_title_price);
		return $price_str;

	}

}

class RegisterStep3{
	private $db;
	private $smarty;
	public function __construct($db) {
		$this -> db = $db;
		$this ->smarty = new Smarty();
        $rs_contact_nos = new Contact();
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
        $ip_address = (getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : $_SERVER['REMOTE_ADDR']);
		$ip_address = ($ip_address && $ip_address != '192.168.122.1' ? $ip_address : '103.225.38.20');
        $leads_country = $this->_getCCfromIP($ip_address);
		if(empty($leads_country)){
			$leads_country = 'PH';
		}
        $this->smarty->assign("leads_country", $leads_country);
        $this->smarty->assign('contact_numbers',$contact_numbers); 
		$this->smarty->assign('script','step3.js');
	}

	public function render() {
		
		//echo "<pre>";
		//print_r($_SESSION);
		//die;
		
		//GET DB INSTANCE
	    $db = $this->db;
	    
	    //GET SMARTY INSTANCE
	    $smarty = $this->smarty;
		
		//STEP 1 IS NOT FINISHED
		if(!isset($_SESSION['client_id'])&&!isset($_SESSION['leads_id'])){
			header("Location:/portal/custom_get_started/");
			die ;
		}
		
		//STEP 2 IS NOT FINISHED
		if(isset($_SESSION["job_order_ids"])&&!empty($_SESSION["job_order_ids"])) {
			$job_order_ids = $_SESSION["job_order_ids"];
		} else {
			header("Location:/portal/custom_get_started/step2.php");
			die ;
		}
		
		//STEP 3 IS FINISHED
		if(isset($_SESSION['step'])&&!empty($_SESSION['step'])){
			header("Location:/portal/custom_get_started/job_order_preview.php");
			die ;
		}
		
		//CREATE LEAD SESSION IF CLIENT ID IS ISSET
        if (!isset($_SESSION["leads_id"])&&$_SESSION["client_id"]){
			$_SESSION["leads_id"] = $_SESSION["client_id"];
        }
        
        //CREATE CLIENT SESSION IF LEADS ID IS ISSET
        if (!isset($_SESSION["client_id"])&&$_SESSION["leads_id"]){
			$_SESSION["client_id"] = $_SESSION["leads_id"];
        }
		
		//GET CLIENT ID
		$client_id = (isset($_SESSION['leads_id']) ? $_SESSION['leads_id'] : $_SESSION['client_id']);
		
		//ASSIGN CLIENT ID
        $smarty->assign("client_id",$client_id);
		
		//GS JOB ROLE SELECTION IS ISSET
        if (isset($_SESSION["gs_job_role_selection_id"])){
			$lead_sql = $db->select()
						   ->from("leads",array("fname","lname", "id"))
						   ->where("id = ?",$client_id);
            $lead = $db->fetchRow($lead_sql);    
            $smarty->assign("lead",$lead);
        }
        
        //RECONSTRUCT JOB ORDERS
		$job_orders = array();
		foreach ($job_order_ids as $key => $job_order_id){
			$job_order_sql = $db->select()
								->from("gs_job_titles_details")
								->where("gs_job_titles_details_id=?",$job_order_id);
			$job_order = $db->fetchRow($job_order_sql);
			if ($key == 0) {
				$job_order["selected"] = true;
			} else {
				$job_order["selected"] = false;
			}
			if ($job_order) {
				$job_orders[] = $job_order;
			}
		}
		
		$timezones_sql = $db->select()
							->from("timezone_lookup")
							->order("timezone");
		$timezones = $db->fetchAll($timezones_sql);
		
		$working_status = array();
		$working_status[] = array("value"=>"Full-Time", "label"=>"Full Time 9hours with 1hour break");
		$working_status[] = array("value"=>"Part-Time", "label"=>"Part Time 4hours");
		
		$smarty->assign("working_status", $working_status);
		$smarty->assign("job_orders", $job_orders);

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
		
		//ADMIN IS LOGGED IN
		if(isset($_SESSION['admin_id'])){
			$smarty->assign('admin_user',true);
		}
		
		$smarty -> assign("shift_times", $shift_times);
		$smarty -> assign("timezones", $timezones);
		$smarty	-> clear_cache('step3.tpl'); 
		$smarty -> display("step3.tpl");
	}

	public function attach_docs() {
		$db = $this -> db;
		$allowedExtensions = array("doc", "docx", "pdf", "xls", "xlsx");
		$id = $_REQUEST["gs_job_titles_details_id"];
		$sizeLimit = 5 * 1024 * 1024;
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

		$name = $uploader -> getName();
		$splitName = explode(".", $name);
		$uploader -> handleUpload(dirname(__FILE__) . "/../../uploads/csro_files/");
		$new = "uploads/csro_files/" . $id . "_attach_file." . $splitName[1];
		if (file_exists(dirname(__FILE__) . "/../../uploads/csro_files/" . $name)) {
			rename(dirname(__FILE__) . "/../../uploads/csro_files/" . $name, dirname(__FILE__) . "/../../" . $new);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$retries = 0;
			while(true){
				try{
					if (TEST) {
						$mongo = new MongoClient(MONGODB_TEST);
						$database = $mongo -> selectDB('prod_file_system');
					} else {
						$mongo = new MongoClient(MONGODB_SERVER);
						$database = $mongo -> selectDB('prod_file_system');
					}
					break;
				} catch(Exception $e){
					++$retries;
					
					if($retries >= 100){
						break;
					}
				}
			}
			
			$gridfs = $database -> getGridFS();
			$mimetype = finfo_file($finfo, dirname(__FILE__) . "/../../" . $new);
			$path_parts = pathinfo(dirname(__FILE__) . "/../../" . $new);
			$gridfs -> remove(array("gs_job_titles_details_id" => $id));
			$gridfs -> storeFile(dirname(__FILE__) . "/../../" . $new, array("gs_job_titles_details_id" => $id, "mimetype" => $mimetype, "extension" => $path_parts['extension'], "filename" => $path_parts['filename'], "basename" => $path_parts['basename'], "dirname" => $path_parts['dirname'], "original_filename" => $name));
			unlink(dirname(__FILE__) . "/../../" . $new);
			return array("success" => true, "filename" => $name, "id" => $id);
		} else {
			return array("success" => false);
		}
	}

	public function getFiles() {
		$id = $_REQUEST["gs_job_titles_details_id"];
		$retries = 0;
		while(true){
			try{
				if (TEST) {
					$mongo = new MongoClient(MONGODB_TEST);
					$database = $mongo -> selectDB('prod_file_system');
				} else {
					$mongo = new MongoClient(MONGODB_SERVER);
					$database = $mongo -> selectDB('prod_file_system');
				}
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
		
		$gridfs = $database -> getGridFS();
		$cursor = $gridfs -> find(array("gs_job_titles_details_id" => $id));
		while ($cursor -> hasNext()) {
			$file = $cursor -> getNext();
			if ($file -> file["mimetype"] == "application/zip") {

				if ($file -> file["extension"] == "docx") {
					header("Content-type:application/vnd.openxmlformats-officedocument.wordprocessingml.document");
				} else {

					header("Content-type:" . $file -> file["mimetype"]);
				}
			} else {
				header("Content-type:" . $file -> file["mimetype"]);
			}
			header("Content-Disposition: attachment; filename=" . $file -> file["original_filename"]);
			echo $file -> getBytes();
			die ;
		}
	}

	public function process() {
		$db = $this -> db;
		$smarty = new Smarty();
        $rs_contact_nos = new Contact();
        $contact_numbers = $rs_contact_nos->rs_contact_numbers($db);
        
		$ATZ = date("Y-m-d H:i:s");
		if (!isset($_SESSION["leads_id"])&&$_SESSION["client_id"]){
			 $_SESSION["leads_id"] = $_SESSION["client_id"];
		}
		if (!isset($_SESSION["client_id"])&&$_SESSION["leads_id"]){
			 $_SESSION["client_id"] = $_SESSION["leads_id"];
		}
		$leads_id = $_SESSION["leads_id"];
        $_POST["leads_id"] = $_SESSION["leads_id"];
		
		if (isset($_POST["gs_job_titles_details_id"]) && $_POST["gs_job_titles_details_id"]) {
			
			//save first to mongodb jobspecification 
			$datamongo = $_POST;

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
					
				$datamongo["required_skills"] = array();
				if (!empty($_POST["skills"])){
					foreach ($_POST["skills"] as $key => $skill) {
						$ratings = $_POST["skills-proficiency"][$key];
						
						$skill = $db->fetchRow($db->select()->from("job_position_skills_tasks")->where("id = ?", $skill));
						$skill["ratings"] = $ratings;
						unset($skill["date_created"]);
						$datamongo["required_skills"][] = $skill;
					}
				}
				
				
				
				unset($datamongo["skills"]);
				unset($datamongo["skills-proficiency"]);
				
				$datamongo["required_tasks"] = array();
				if (!empty($_POST["tasks"])){
					foreach ($_POST["tasks"] as $key => $task) {
						$ratings = $_POST["tasks-proficiency"][$key];
						$task = $db->fetchRow($db->select()->from("job_position_skills_tasks")->where("id = ?", $task));
						$task["ratings"] = $ratings;
						unset($task["date_created"]);
						$datamongo["required_tasks"][] = $task;
					}
					
				}
				
				unset($datamongo["tasks"]);
				unset($datamongo["tasks-proficiency"]);
				
				
				$job_spec_collections = $database->selectCollection("job_specifications");
				
				$job_spec = $db->fetchRow($db->select()->from("gs_job_titles_details")->where("gs_job_titles_details_id = ?", $datamongo["gs_job_titles_details_id"]));
				$job_role_selection = $db->fetchRow($db->select()->from("gs_job_role_selection")->where("gs_job_role_selection_id = ?", $job_spec["gs_job_role_selection_id"]));
				$job_spec["job_role_selection"] = $job_role_selection;
				$job_spec["details"] = $datamongo;
				$job_spec['details']["move_like_jagger"] = "step_3"; 
				
				
				$job_spec_collections->update(array("gs_job_titles_details_id"=>$datamongo["gs_job_titles_details_id"]), array('$set'=>$job_spec));
			}catch(Exception $e){
				
			}
			
			
			//save to mysql for counter reference
			
			$gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
			$gs = array("work_status" => $_POST["work_status"], "working_timezone" => $_POST["time_zone"], "start_work" => $_POST["shift_time"], "finish_work" => $_POST["shift_time_end"], "proposed_start_date" => $_POST["date_start"], "form_filled_up"=>"yes");
			$db -> update("gs_job_titles_details", $gs, $db -> quoteInto("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

			$gs_job_role_selection_id = $db -> fetchOne($db -> select() -> from("gs_job_titles_details", array("gs_job_role_selection_id")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
			$db -> update("gs_job_role_selection", array("proposed_start_date" => $_POST["date_start"]), $db -> quoteInto("gs_job_role_selection_id = ?", $gs_job_role_selection_id));

			if ($_POST["staff_provide_training"]) {
				$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", "staff_provide_training"));
				if (!$cred) {
					$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_provide_training"], "box" => "staff_provide_training"));
				} else {
					$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_provide_training"], "box" => "staff_provide_training"), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
				}
			}
			if ($_POST["staff_make_calls"]) {
				$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", "staff_make_calls"));
				if (!$cred) {
					$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_make_calls"], "box" => "staff_make_calls"));
				} else {
					$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_make_calls"], "box" => "staff_make_calls"), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
				}
			}
			if ($_POST["staff_first_time"]) {
				$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", "staff_first_time"));
				if (!$cred) {
					$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_first_time"], "box" => "staff_first_time"));
				} else {
					$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_first_time"], "box" => "staff_first_time"), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
				}
			}
			if ($_POST["staff_report_directly"]) {
				$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", "staff_report_directly"));
				if (!$cred) {
					$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_report_directly"], "box" => "staff_report_directly"));
				} else {
					$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["staff_report_directly"], "box" => "staff_report_directly"), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
				}
			}
			if ($_POST["special_instruction"]) {
				$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", "special_instruction"));
				if (!$cred) {
					$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["special_instruction"], "box" => "special_instruction"));
				} else {
					$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["special_instruction"], "box" => "special_instruction"), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
				}
			}

			if (!empty($_POST["skills"])) {
				$db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = '" . $gs_job_titles_details_id . "' AND gs_job_role_selection_id = '" . $gs_job_role_selection_id . "' AND box = 'skills'");
				foreach ($_POST["skills"] as $key => $skill) {
					$ratings = $_POST["skills-proficiency"][$key];

					$data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $skill, "box" => "skills", "rating" => $ratings);

					$db -> insert("gs_job_titles_credentials", $data);
				}
			}

			if (!empty($_POST["tasks"])) {
				$db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = '" . $gs_job_titles_details_id . "' AND gs_job_role_selection_id = '" . $gs_job_role_selection_id . "' AND box = 'tasks'");
				foreach ($_POST["tasks"] as $key => $task) {
					$ratings = $_POST["tasks-proficiency"][$key];

					$data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $task, "box" => "tasks", "rating" => $ratings);

					$db -> insert("gs_job_titles_credentials", $data);
				}
			}

			if (!empty($_REQUEST["responsibility"])){
				$db->delete("gs_job_titles_credentials", "gs_job_titles_details_id = ".$gs_job_titles_details_id." AND box = 'responsibility'");
				    foreach($_POST["responsibility"] as $key=>$responsibility){
				        if(!empty($responsibility) && $responsibility != ""){
        					    $data = array(
                                "gs_job_role_selection_id"=>$gs_job_role_selection_id,
                                "gs_job_titles_details_id"=>$gs_job_titles_details_id,
                                "box"=>"responsibility",
                                "description"=>$responsibility,
                                "div"=>"responsibility_div"
                            );  
                            $db->insert("gs_job_titles_credentials", $data);
        			}    
				    	
				}			
			}
	
			if (!empty($_REQUEST["other_skills"])){
				$db->delete("gs_job_titles_credentials", "gs_job_titles_details_id = ".$gs_job_titles_details_id." AND box = 'other_skills'");
    				foreach($_POST["other_skills"] as $key=>$other_skills){
    				    if(!empty($other_skills) && $other_skills != ""){
    					$data = array(
    						"gs_job_role_selection_id"=>$gs_job_role_selection_id,
    						"gs_job_titles_details_id"=>$gs_job_titles_details_id,
    						"box"=>"other_skills",
    						"description"=>$other_skills,
    						"div"=>"other_skills_div"
    					);	
    					$db->insert("gs_job_titles_credentials", $data);
    				}	
				}		
			}
			
			//OPTIONAL
			$this->update_checkbox("increase_demand",$gs_job_role_selection_id,$gs_job_titles_details_id);
			$this->update_checkbox("replacement_post",$gs_job_role_selection_id,$gs_job_titles_details_id);
			$this->update_checkbox("support_current",$gs_job_role_selection_id,$gs_job_titles_details_id);
			$this->update_checkbox("experiment_role",$gs_job_role_selection_id,$gs_job_titles_details_id);
			$this->update_checkbox("meet_new",$gs_job_role_selection_id,$gs_job_titles_details_id);

			/*
			$currency = $db -> fetchOne($db -> select() -> from("gs_job_role_selection", "currency") -> where("gs_job_role_selection_id = ?", $gs_job_role_selection_id));
			$_POST["leads_id"] =$_SESSION["leads_id"];
			$leads_id  =$_SESSION["leads_id"];
			
			
			if ($currency) {
				//get the currency_lookup.id of the currency
				$sql2 = $db -> select() -> from('currency_lookup', 'id') -> where('code = ?', $currency);
				$currency_lookup_id = $db -> fetchOne($sql2);

				//echo $currency_lookup_id;
				// get the unit prices
				// ID of the Recruitment Setup Fee
				// 3 = Initial Recruitment Setup Fee
				// 4 = Regular Recruitment Setup Fee (additional staff)

				//id, product_id, amount, currency_id, admin_id, date

				$free_custom_recruitment_product_id = 791;
				//get the additional price
				$query2 = $db -> select() -> from('product_price_history', 'amount') -> where('product_id = ?', $free_custom_recruitment_product_id) -> where('currency_id = ?', $currency_lookup_id);
				//echo $query2."<br>";
				$free_custom_recruitment_product_price = $db -> fetchOne($query2);

				if (!$free_custom_recruitment_product_price) {
					$free_custom_recruitment_product_price = 0;
				}
				//echo $free_custom_recruitment_product_price;exit;
				//A.

				//B. Create random string
				$random_string = rand_str();
				//B.

				//C. Save leads session id
				
				$data = array('leads_id' => $leads_id, 'random_string' => $random_string);
				$db -> insert('leads_session_transfer', $data);
				//C.

				//D. Insert new record in the leads_invoice
				$data = array('leads_id' => $leads_id, 'date_created' => $ATZ, 'invoice_date' => $ATZ, 'currency' => $currency_lookup_id, 'description' => 'Custom Recruitment Setup Fee Payment', 'status' => 'open');
				//print_r($data);
				$db -> insert('leads_invoice', $data);
				$leads_invoice_id = $db -> lastInsertId();

				$sql = "SELECT SUM(no_of_staff_needed)AS total_no_of_staff_needed , selected_job_title FROM gs_job_titles_details g WHERE gs_job_role_selection_id = $gs_job_role_selection_id GROUP BY selected_job_title;";

				$orders = $db -> fetchAll($sql);
				if (count($orders) > 0) {

					foreach ($orders as $order) {
						$total_no_of_staff_needed = $order['total_no_of_staff_needed'];
						$selected_job_title = $order['selected_job_title'];

						if ($total_no_of_staff_needed == 1) {
							//get the details in the gs_job_titles_details table per selected_job_title
							$query = $db -> select() -> from('gs_job_titles_details') -> where('selected_job_title = ?', $selected_job_title) -> where('gs_job_role_selection_id = ?', $gs_job_role_selection_id);
							$result = $db -> fetchRow($query);

							$description = sprintf("Custom recruitment of (1) %s %s level for %s working %s Monday to Friday.", $selected_job_title, $result['level'], configurePriceRate($result['jr_list_id'], $result['level'], $result['work_status'], $currency_lookup_id), $result['work_status']);

							$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => 1, 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
							$db -> insert('leads_invoice_item', $data);
							//echo $description."<hr>";
						} else {
							//echo $total_no_of_staff_needed." => ".$selected_job_title."<br>";
							$selected_job_titles = array();
							//initial staff
							$query = $db -> select() -> from('gs_job_titles_details') -> where('selected_job_title = ?', $selected_job_title) -> where('gs_job_role_selection_id = ?', $gs_job_role_selection_id) -> limit(1);

							$job_position = $db -> fetchRow($query);

							$description = sprintf("Custom recruitment of (%s) initial staff %s %s level for %s working %s Monday to Friday.", 1, $selected_job_title, $job_position['level'], configurePriceRate($job_position['jr_list_id'], $job_position['level'], $job_position['work_status'], $currency_lookup_id), $job_position['work_status']);
							//echo "<b>".$description."</b><br>";

							//push data in array
							array_push($selected_job_titles, $job_position['gs_job_titles_details_id']);

							//save data
							$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => 1, 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
							$db -> insert('leads_invoice_item', $data);

							//additional staff
							//check if the parse row column field no_of_staff_needed is greatere than 1
							if ($job_position['no_of_staff_needed'] > 1) {

								$description = sprintf("Custom recruitment of (%s) additional staff %s %s level for %s working %s Monday to Friday.", ($job_position['no_of_staff_needed'] - 1), $selected_job_title, $job_position['level'], configurePriceRate($job_position['jr_list_id'], $job_position['level'], $job_position['work_status'], $currency_lookup_id), $job_position['work_status']);
								//echo $description."<br>";
								$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => ($job_position['no_of_staff_needed'] - 1), 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
								$db -> insert('leads_invoice_item', $data);
							}

							//added staff
							$query2 = $db -> select() -> from('gs_job_titles_details') -> where('selected_job_title = ?', $selected_job_title) -> where('gs_job_role_selection_id = ?', $gs_job_role_selection_id);
							$job_positions = $db -> fetchAll($query2);
							foreach ($job_positions as $job_position) {

								$i = 0;
								if ($selected_job_titles[$i] != $job_position['gs_job_titles_details_id']) {

									$description = sprintf("Custom recruitment of (%s) additional staff %s %s level for %s working %s Monday to Friday.", $job_position['no_of_staff_needed'], $selected_job_title, $job_position['level'], configurePriceRate($job_position['jr_list_id'], $job_position['level'], $job_position['work_status'], $currency_lookup_id), $job_position['work_status']);
									//echo $description."<br>";

									$data = array('leads_invoice_id' => $leads_invoice_id, 'product_id' => $free_custom_recruitment_product_id, 'qty' => $job_position['no_of_staff_needed'], 'unit' => 'pc', 'unit_price' => $free_custom_recruitment_product_price, 'description' => $description);
									$db -> insert('leads_invoice_item', $data);

								}

							}
							//echo "<hr>";

						}

					}
				}
			}

			//G. we need to track this record
			$data = array(
						'leads_invoice_id' => $leads_invoice_id,
						'gs_job_role_selection_id' => $gs_job_role_selection_id,
						'status' => 'open', 
						'date_created' => $ATZ
						);
			$db->insert('gs_payment_track' , $data);
			//G.

			$leads_info_sql=$db->select()
				->from(array('l'=>'leads'), array('id','fname','lname','business_partner_id','email','hiring_coordinator_id'))
                ->joinLeft(array('a'=>'admin'), 'l.hiring_coordinator_id = a.admin_id', array('admin_id','admin_fname','admin_lname'))
				->where('l.id = ?' ,$leads_id);
			$leads_info = $db->fetchRow($leads_info_sql);	
			$name = $leads_info['fname']." ".$leads_info['lname'];
			$email = $leads_info['email'];
			$business_partner_id = $leads_info['business_partner_id'];
			
			if($_SESSION['filled_up_by_type'] == 'leads'){
			
				//get the business partner email
				if($business_partner_id){
					$sql = $db->select()
						->from('agent')
						->where('agent_no =?', $business_partner_id);
					$bp = $db->fetchRow($sql);
				}
			
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('admin_email', ADMIN_EMAIL);
				$smarty->assign('admin_name', ADMIN_NAME);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
                $smarty->assign('contact_numbers',$contact_numbers);
				$body = $smarty->fetch('confirm.tpl');
			
				//echo $bp['email'];exit;
			
					 
				//$mail = new Zend_Mail('utf-8');
				//$mail->setBodyHtml($body);
				//$mail->setFrom('sales@remotestaff.com.au', 'REMOTESTAFF');
				//if(! TEST){
					//$mail->addTo($email, $name);
					//$mail->addCc('orders@remotestaff.com.au', 'Order');// Adds a recipient to the mail with a "Cc" header
					//$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
					//$subject= "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE";
				//}else{
					//$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
					//$mail->addCc('orders@remotestaff.com.au', 'Order');// Adds a recipient to the mail with a "Cc" header
					//$subject= "TEST FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE";
				//}
				//$mail->setSubject($subject);
				//$mail->send($transport);

				
				//$attachments_array =NULL;
				//$to_array = array($email); //
				//$bcc_array=array('devs@remotestaff.com.au');
				//$cc_array = array('orders@remotestaff.com.au');
				//$from = "REMOTESTAFF <sales@remotestaff.com.au>";
				//$html = $body;
				//$subject = "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE";
				//SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
			    //echo $html;	
				//exit;
				//autoresponder for admin
				
			 * 
				//$mail = new Zend_Mail('utf-8');
				//$mail->setBodyHtml($body2);
				//$mail->setFrom('sales@remotestaff.com.au', 'REMOTESTAFF');
				//if(! TEST){
					//$mail->addTo('orders@remotestaff.com.au', 'Order');
					//$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
					//$subject= "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
				//}else{
					//$mail->addTo('orders@remotestaff.com.au', 'Order');
					//$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
					//$subject= "TEST FREE (admin) REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
				//}
				//$mail->setSubject($subject);
				//$mail->send($transport);
				
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('admin_email', ADMIN_EMAIL);
				$smarty->assign('admin_name', ADMIN_NAME);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
                $smarty->assign('contact_numbers', $contact_numbers);
				$body2 = $smarty->fetch('autoresponder-for-admin.tpl');	
				
				$attachments_array =NULL;
				$to_array = array('orders@remotestaff.com.au');
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = NULL;
				$from = "REMOTESTAFF <sales@remotestaff.com.au>";
				$html = $body2;
				$subject = sprintf('FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD %s %s', $leads_id, strtoupper($name));
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
			
			
			
				if($bp['email']){
					//autoresponder for BP
					//$mail = new Zend_Mail('utf-8');
					//$mail->setBodyHtml($body2);
					//$mail->setFrom('sales@remotestaff.com.au', 'REMOTESTAFF');
					//if(! TEST){
						//$mail->addTo($bp['email'], $bp['fname']." ".$bp['lname']);
						//$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
						//$subject= "FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
					//}else{
						//$mail->addTo('devs@remotestaff.com.au', $bp['fname']." ".$bp['lname']);
						//$subject= "TEST (bp) FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD ".$name;
					//}
			
					//$mail->setSubject($subject);
					//$mail->send($transport);

					
					$attachments_array =NULL;
					$to_array = array($bp['email']); //
					$bcc_array=array('devs@remotestaff.com.au');
					$cc_array = NULL;
					$from = "REMOTESTAFF <sales@remotestaff.com.au>";
					$html = $body2;
					$subject = sprintf('FREE REMOTE STAFF CUSTOM RECRUITMENT SERVICE LEAD %s %s', $leads_id, strtoupper($name));
					SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				}
			}else{
			    //send autoresponder to the one who filled up this JS form. 
				//send autoresponder to admin
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('ATZ', $ATZ);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
				$smarty->assign('filled_up_by', ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name'));
                $smarty->assign('contact_numbers',$contact_numbers);
				$body = $smarty->fetch('filled_up_by_notice_autoresponder.tpl');
				
				//$mail = new Zend_Mail('utf-8');
				//$mail->setBodyHtml($body);
				//$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
				//if(! TEST){
					//$mail->addTo(ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'email'), ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name'));
					//$mail->addBcc('devs@remotestaff.com.au', 'Remotestaff Developers');
					//$subject= "CUSTOM RECRUITMENT SERVICE CREATED AND FILLED BY ".ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name');
				//}else{
					//$mail->addTo('devs@remotestaff.com.au');
					//$subject= "TEST CUSTOM RECRUITMENT SERVICE CREATED AND FILLED BY ".ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name');
				//}
				//$mail->setSubject($subject);
				//$mail->send($transport);

				$subject= "CUSTOM RECRUITMENT SERVICE CREATED AND FILLED BY ".ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name');
				$email = ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'email');
				$attachments_array =NULL;
				$to_array = array($email);
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = NULL;
				$from = "No Reply <noreply@remotestaff.com.au>";
				$html = $body;
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				
				
				//Send notice to lead
				$smarty->assign('lead', $leads_info);
				$smarty->assign('leads_invoice_id', $leads_invoice_id);
				$smarty->assign('ATZ', $ATZ);
				$smarty->assign('site', $_SERVER['HTTP_HOST']);
				$smarty->assign('filled_up_by', ShowFilledBy($_SESSION['filled_up_by_id'], $_SESSION['filled_up_by_type'], 'name'));
				$smarty->assign('contact_numbers', $contact_numbers);
				$body = $smarty->fetch('job_order_for_lead_autoresponder.tpl');
				
				$attachments_array =NULL;
				$to_array = array($leads_info['email']);
				$bcc_array=array('devs@remotestaff.com.au');
				$cc_array = NULL;
				$from = "No Reply <noreply@remotestaff.com.au>";
				$html = $body;
				$subject= sprintf("Job Order for %s %s %s",  $leads_info['fname'], $leads_info['lname'], $leads_info['id']);
				SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, NULL, $to_array);
				
			}
			
			//update leads company description
			
			//if($_POST['company_description'] != 'Type Here'){
			    //$data = array('company_description' => $_POST['company_description']);
				//addLeadsInfoHistoryChanges($data , $_SESSION['leads_id'] , $_POST['leads_id'] , 'client');
				//$where = "id = ".$_SESSION['leads_id'];
				//$db->update('leads', $data , $where);
				//$company_description = $_POST['company_description'];
			//}
			
			
			//marked this lead in the leads list.
			$data = array('custom_recruitment_order' => 'yes', 'last_updated_date' => $ATZ);
			$where = "id = ".$_SESSION['leads_id'];
			$db->update('leads', $data, $where);
			
			
			$data = array(
			    'filled_up_by_id' => $_SESSION['filled_up_by_id'],
				'filled_up_by_type' => $_SESSION['filled_up_by_type'],
				'filled_up_date' => $ATZ
			);
			
			//echo '<PRE>';	
			//print_r($data);
			//echo '</PRE>';
			//exit;
			$where = "gs_job_role_selection_id = ".$gs_job_role_selection_id;
			$db->update('gs_job_role_selection' ,  $data , $where);
			*/
			
			$_SESSION['step'] = 'finish';
			return array("success" => true); 
			
		} else {
			return array("success" => false);
		}

	}

    private function _getALLfromIP($addr) {
        // this sprintf() wrapper is needed, because the PHP long is signed by default
        $db = $this->db;
        $ipnum = sprintf("%u", ip2long($addr));
        $query = "SELECT cc, cn FROM ip NATURAL JOIN cc WHERE ${ipnum} BETWEEN start AND end";
        $result = $db->fetchRow($query);
        
        return $result;
    }
    
    private function _getCCfromIP($addr) { 
        $data = $this->_getALLfromIP($addr);
        if($data) return $data['cn'];
        return false;
    }
    
    
    
    //FROM STEP 4 OPTIONAL
	private function update_checkbox($key_list,$gs_job_role_selection_id,$gs_job_titles_details_id){ 
		
		$db = $this->db;
		
		$val = (isset($_POST[$key_list]) ? $_POST[$key_list] : '');
		
		//$db->delete("gs_job_titles_credentials", "gs_job_titles_details_id = '".$gs_job_titles_details_id."' AND gs_job_role_selection_id = '".$gs_job_role_selection_id."' AND box = '".$key_list."'");
	
		if ($val=="on"){
			$cred = $db -> fetchRow($db -> select() -> from(array("gjtc" => "gs_job_titles_credentials")) -> where("gjtc.gs_job_titles_details_id = ?", $gs_job_titles_details_id) -> where("gjtc.gs_job_role_selection_id = ?", $gs_job_role_selection_id) -> where("box = ?", $key_list));
			if (!$cred) {
				$db -> insert("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" =>"checked", "box" => $key_list));
			} else {
				$db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" =>"checked", "box" => $key_list), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id"]));
			}
		}else{
			$db->delete("gs_job_titles_credentials", "gs_job_titles_details_id = '".$gs_job_titles_details_id."' AND gs_job_role_selection_id = '".$gs_job_role_selection_id."' AND box = '".$key_list."'");
		}
		
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
			
			$job_spec_collections = $database->selectCollection("job_specifications");
			$cursor = $job_spec_collections->find(array("gs_job_titles_details_id"=>$gs_job_titles_details_id));
			
			while($cursor->hasNext()){
				$job_spec = $cursor->getNext();
				
				if (!isset($job_spec["other_details"])){
					$other_details = array();
				}else{
					$other_details = $job_spec["other_details"];
				}
				if ($val=="on"){
					$other_details[$key_list] = "Yes";						
				}else{
					$other_details[$key_list] = "No";
				}
				
				
				$job_spec_collections->update(array("gs_job_titles_details_id"=>$gs_job_titles_details_id), array('$set'=>array("other_details"=>$other_details)));						
			}
			
		}catch(Exception $e){
			
		}

	} 

}
