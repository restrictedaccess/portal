<?php
//require_once dirname(__FILE__) . "/../../lib/Portal.php"; 
require_once dirname(__FILE__) . "/../../skill_task_manager/classes/SkillTaskManager.php";
class EditJobSpecification /*extends Portal*/ {
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
	}
    public function render() {
        $smarty = $this -> smarty;
        $gs_job_titles_details_id = $_REQUEST["gs_job_titles_details_id"];

        $db = $this -> db;

        $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

        $gs_jrs = $db -> fetchRow($db -> select() -> from("gs_job_role_selection") -> where("gs_job_role_selection_id = ?", $gs_job_role_selection_id));

        $final_credentials = array();

        $gs_creds = $db -> fetchAll($db -> select() -> from("gs_job_titles_credentials") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        foreach ($gs_creds as $gs_cred) {
            $gs_cred["description"] = trim($gs_cred["description"]);
            if (trim($gs_cred["description"]) != "") {
                $final_credentials[] = $gs_cred;
            }
        }
        $gs_jtd["level"] = strtoupper($gs_jtd["level"]);
        $smarty -> assign("gs_jtd", $gs_jtd);
        $smarty -> assign("gs_jrs", $gs_jrs);
        $smarty -> assign("gs_creds", $final_credentials);
        $comments = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "comments") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $special_instruction = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "special_instruction") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

        $smarty -> assign("comments", $comments);
        $smarty -> assign("special_instruction", $special_instruction);

        if ($gs_jtd["created_reason"] == "New JS Form Client") {
            $required_skills = $db -> fetchAll($db -> select() -> from(array("jpst" => "job_position_skills_tasks")) -> where("sub_category_id = ?", $gs_jtd["sub_category_id"]) -> where("type = ?", "skill"));
            $required_tasks = $db -> fetchAll($db -> select() -> from(array("jpst" => "job_position_skills_tasks")) -> where("sub_category_id = ?", $gs_jtd["sub_category_id"]) -> where("type = ?", "task"));

            $ratings_skills = array();
            $ratings_skills[] = array("label" => "Beginner (1-3 years)", "value" => 1);
            $ratings_skills[] = array("label" => "Intermediate (3-5 years)", "value" => 2);
            $ratings_skills[] = array("label" => "Advanced (More than 5 years)", "value" => 3);
            $ratings_tasks = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10");

            $smarty -> assign("required_skills", $required_skills);
            $smarty -> assign("required_tasks", $required_tasks);
            $smarty -> assign("ratings_tasks", $ratings_tasks);
            $smarty -> assign("ratings_skills", $ratings_skills);
            $yesno = array("Yes", "No");
            $smarty -> assign("yesno", $yesno);

            $staff_provide_training = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "staff_provide_training") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
            $staff_make_calls = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "staff_make_calls") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
            $staff_first_time = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "staff_first_time") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
            $staff_report_directly = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "staff_report_directly") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
            $special_instruction = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "special_instruction") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

            $smarty -> assign("staff_provide_training", $staff_provide_training);
            $smarty -> assign("staff_make_calls", $staff_make_calls);
            $smarty -> assign("staff_first_time", $staff_first_time);
            $smarty -> assign("staff_report_directly", $staff_report_directly);
            $smarty -> assign("special_instruction", $special_instruction);

            $smarty -> display("edit_new_job_spec.tpl");
        } else {
            $optionsRatings = range(1, 6);

            $smarty -> assign("option_ratings", $optionsRatings);
            if ($gs_jtd["jr_cat_id"] == 1) {
                $q1 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q1") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $q2 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q2") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $q3 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q3") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $q4 = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "q4") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $lead_generation = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "lead_generation") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $telemarketer_hrs = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "telemarketer_hrs") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

                $yesno = array("YES", "NO");
                $q4_items = array("SALE", "APPOINTMENT SET", "SURVEY", "INFORMATION UPDATE");
                $campaign_types = array("Business to Business", "Business to Consumer", "Both");
                $call_types = array("Inbound", "Outbound", "Both");
                $graphic_options = array("Photoshop", "Corel Draw", "Illustrator", "Maya", "Fireworks");
                $writer_type_options = array("Article Writer", "SEO Writer", "Technical / Manual Writer", "Web Content Writer", "Research Writer", "Blogger");

                $smarty -> assign("graphic_options", $graphic_options);
                $smarty -> assign("writer_type_options", $writer_type_options);
                $smarty -> assign("q1", $q1);
                $smarty -> assign("q2", $q2);
                $smarty -> assign("q3", $q3);
                $smarty -> assign("q4", $q4);
                $smarty -> assign("telemarketer_hrs", $telemarketer_hrs);
                $smarty -> assign("lead_generation", $lead_generation);
                $smarty -> assign("yesno", $yesno);
                $smarty -> assign("q4_items", $q4_items);

                $campaign_type = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "campaign_type") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $call_type = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "call_type") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $staff_phone = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "staff_phone") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));

                $smarty -> assign("campaign_types", $campaign_types);
                $smarty -> assign("call_types", $call_types);

                $smarty -> assign("selected_campaign_type", $campaign_type);
                $smarty -> assign("selected_call_type", $call_type);
                $smarty -> assign("selected_staff_phone", $staff_phone);

                //telemarkerter flag
                if (in_array($gs_jtd["jr_list_id"], array(1, 12, 23))) {
                    $smarty -> assign("telemarketer_flag", true);
                } else {
                    $smarty -> assign("telemarketer_flag", false);
                }
                //writer flag
                if (in_array($gs_jtd["jr_list_id"], array(5, 16, 27))) {
                    $smarty -> assign("writer_flag", true);
                } else {
                    $smarty -> assign("writer_flag", false);
                }
                //marketing assistant flag
                if (in_array($gs_jtd["jr_list_id"], array(2, 13, 24))) {
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

                $smarty -> display("edit_marketing_job_spec.tpl");

            } else if ($gs_jtd["jr_cat_id"] == 2) {

                $onshore = $db -> fetchOne($db -> select() -> from("gs_job_titles_credentials", array("description")) -> where("box = ?", "onshore") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
                $yesno = array("YES", "NO");

                $smarty -> assign("onshore", $onshore);
                $smarty -> assign("yesno", $yesno);
                $smarty -> display("edit_it_job_spec.tpl");
            } else if ($gs_jtd["jr_cat_id"] == 3) {

                $smarty -> display("edit_office_job_spec.tpl");
            } else {
                $smarty -> display("edit_job_spec.tpl");
            }

        }

    }

    public function update_new_job_spec() {
        $db = $this -> db;
        $gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
        $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

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
                $db -> update("gs_job_titles_credentials", array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $_POST["special_instruction"], "box" => "special_instruction"), $db -> quoteInto("gs_job_titles_credentials_id = ?", $cred["gs_job_titles_credentials_id" ]));
                }
                }

                if (!empty($_POST["skills"])) {
                $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = '" . $gs_job_titles_details_id . "' AND gs_job_role_selection_id = '" . $gs_job_role_selection_id . "' AND box = 'skills'");
                    foreach ($_POST["skill-items"] as $key => $skill) {
                        if (!$skill) {
                        continue;
                        }
    
                            if (in_array($skill, $_POST["skills"])) {
                            $ratings = $_POST["ratings"][$key];
                            $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $skill, "box" => "skills", "rating" => $ratings);
                            $db -> insert("gs_job_titles_credentials", $data);
            
                            }
                    }
                } else {
                    $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = '" . $gs_job_titles_details_id . "' AND gs_job_role_selection_id = '" . $gs_job_role_selection_id . "' AND box = 'skills'");
                    }
                    
                    
                       
                if (!empty($_POST["tasks"])) {
                $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = '" . $gs_job_titles_details_id . "' AND gs_job_role_selection_id = '" . $gs_job_role_selection_id . "' AND box = 'tasks'");
                    foreach ($_POST["task-items"] as $key => $task) {
                        if (!$task) {
                        continue;
                        }
                        if (in_array($task, $_POST["tasks"])) {
                        $ratings = $_POST["ratings-tasks"][$key];
                        $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "gs_job_role_selection_id" => $gs_job_role_selection_id, "description" => $task, "box" => "tasks", "rating" => $ratings);
                        $db -> insert("gs_job_titles_credentials", $data);
                        }
                    }
                }else{
                    $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = '" . $gs_job_titles_details_id . "' AND gs_job_role_selection_id = '" . $gs_job_role_selection_id . "' AND box = 'tasks'");
                    }
                
             if (!empty($_REQUEST["responsibility"])) {
             $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
                 foreach ($_POST["responsibility"] as $key => $responsibility) {
                    $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "responsibility", "description" => $responsibility, "div" => "responsibility_div");
                    $db -> insert("gs_job_titles_credentials", $data);
                 }    
             } else {
                $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
                }
                
                
            if (!empty($_REQUEST["other_skills"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
                foreach ($_POST["other_skills"] as $key => $val) {
                   $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "other_skills", "description" => $val, "div" => "other_skills_div");
                   $db -> insert("gs_job_titles_credentials", $data);
                }
            } else {
                $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
                    }
                
                $new_job_creds = $db -> fetchAll($db -> select() -> from(array(
            "gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		$retries = 0;
		while(true){
			try{
				if (TEST) {
		            $mongo = new MongoClient(MONGODB_TEST);
		            $database = $mongo -> selectDB('prod_logs');
		        } else {
		            $mongo = new MongoClient(MONGODB_SERVER);
		            $database = $mongo -> selectDB('prod_logs');
		        }
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
        

        $logs = $database -> selectCollection("job_specifications_change_logs");

        if ($_SESSION["admin_id"]) {
            $admin = $db -> fetchRow($db -> select() -> from("admin", array("admin_fname", "admin_lname", "admin_id")) -> where("admin_id = ?", $_SESSION["admin_id"]));
            $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "old_job_creds" => $old_job_creds, "new_job_creds" => $new_job_creds, "admin" => $admin);
            $logs -> insert($data);
        }
        return array("success" => true);

    }

    public function update_marketing_job_spec() {

        $db = $this -> db;
        $gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
        $old_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

        if (!empty($_POST["requirement"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement'");
            foreach ($_POST["requirement"] as $key => $requirement) {
                $rating = $_POST["requirement_ratings"][$key];
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "requirement", "description" => $requirement, "rating" => $rating, "div" => "requirements_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement'");
        }

        if (!empty($_REQUEST["requirement_others"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement_others'");
            foreach ($_POST["requirement_others"] as $key => $requirement) {
                $rating = $_POST["requirement_others_ratings"][$key];
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "requirement_others", "description" => $requirement, "rating" => $rating, "div" => "requirement_others_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }

        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement_others'");
        }

        if (!empty($_REQUEST["responsibility"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
            foreach ($_POST["responsibility"] as $key => $responsibility) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "responsibility", "description" => $responsibility, "div" => "responsibility_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
        }

        if (!empty($_REQUEST["other_skills"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
            foreach ($_POST["other_skills"] as $key => $val) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "other_skills", "description" => $val, "div" => "other_skills_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
        }

        if (!empty($_REQUEST["writer_types"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'writer_type'");
            foreach ($_POST["writer_types"] as $key => $val) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "writer_type", "description" => $val, "div" => "writer_type_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'writer_type'");
        }

        $this -> __insertCredentials("comments", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("q1", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("q2", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("q3", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("q4", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("lead_generation", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("telemarketer_hrs", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("call_type", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("campaign_type", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("staff_phone", $gs_job_role_selection_id, $gs_job_titles_details_id);

        $new_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		
		$retries = 0;
		while(true){
			try{
				if (TEST) {
		            $mongo = new MongoClient(MONGODB_TEST);
		            $database = $mongo -> selectDB('prod_logs');
		        } else {
		            $mongo = new MongoClient(MONGODB_SERVER);
		            $database = $mongo -> selectDB('prod_logs');
		        }
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
        

        $logs = $database -> selectCollection("job_specifications_change_logs");

        if ($_SESSION["admin_id"]) {
            $admin = $db -> fetchRow($db -> select() -> from("admin", array("admin_fname", "admin_lname", "admin_id")) -> where("admin_id = ?", $_SESSION["admin_id"]));
            $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "old_job_creds" => $old_job_creds, "new_job_creds" => $new_job_creds, "admin" => $admin);
            $logs -> insert($data);
        }
        return array("success" => true);
    }

    public function update_office_job_spec() {
        $db = $this -> db;
        $gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
        $old_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

        $this -> __insertBatchCredentialsWithRatings("general", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("accounts_clerk", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("accounts_payable", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("accounts_receivable", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("accounting_package", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("bookkeeper", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("payroll", $gs_job_role_selection_id, $gs_job_titles_details_id);

        if (!empty($_REQUEST["responsibility"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
            foreach ($_POST["responsibility"] as $key => $responsibility) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "responsibility", "description" => $responsibility, "div" => "responsibility_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
        }

        if (!empty($_REQUEST["other_skills"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
            foreach ($_POST["other_skills"] as $key => $val) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "other_skills", "description" => $val, "div" => "other_skills_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
        }

        $this -> __insertCredentials("comments", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $new_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		$retries = 0;
		while(true){
			try{
				if (TEST) {
		            $mongo = new MongoClient(MONGODB_TEST);
		            $database = $mongo -> selectDB('prod_logs');
		        } else {
		            $mongo = new MongoClient(MONGODB_SERVER);
		            $database = $mongo -> selectDB('prod_logs');
		        }
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
        

        $logs = $database -> selectCollection("job_specifications_change_logs");

        if ($_SESSION["admin_id"]) {
            $admin = $db -> fetchRow($db -> select() -> from("admin", array("admin_fname", "admin_lname", "admin_id")) -> where("admin_id = ?", $_SESSION["admin_id"]));
            $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "old_job_creds" => $old_job_creds, "new_job_creds" => $new_job_creds, "admin" => $admin);
            $logs -> insert($data);
        }
        return array("success" => true);
    }

    public function update_other_job_spec() {

        $db = $this -> db;
        $gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
        $old_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

        if (!empty($_POST["requirement"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement'");
            foreach ($_POST["requirement"] as $key => $requirement) {
                $rating = $_POST["requirement_ratings"][$key];
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "requirement", "description" => $requirement, "rating" => $rating, "div" => "requirements_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement'");
        }

        if (!empty($_REQUEST["requirement_others"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement_others'");
            foreach ($_POST["requirement_others"] as $key => $requirement) {
                $rating = $_POST["requirement_others_ratings"][$key];
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "requirement_others", "description" => $requirement, "rating" => $rating, "div" => "requirement_others_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }

        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'requirement_others'");
        }

        if (!empty($_REQUEST["responsibility"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
            foreach ($_POST["responsibility"] as $key => $responsibility) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "responsibility", "description" => $responsibility, "div" => "responsibility_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
        }

        if (!empty($_REQUEST["other_skills"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
            foreach ($_POST["other_skills"] as $key => $val) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "other_skills", "description" => $val, "div" => "other_skills_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
        }

        $this -> __insertCredentials("comments", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $new_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		$retries = 0;
		while(true){
			try{
				if (TEST) {
		            $mongo = new MongoClient(MONGODB_TEST);
		            $database = $mongo -> selectDB('prod_logs');
		        } else {
		            $mongo = new MongoClient(MONGODB_SERVER);
		            $database = $mongo -> selectDB('prod_logs');
		        }
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
        

        $logs = $database -> selectCollection("job_specifications_change_logs");

        if ($_SESSION["admin_id"]) {
            $admin = $db -> fetchRow($db -> select() -> from("admin", array("admin_fname", "admin_lname", "admin_id")) -> where("admin_id = ?", $_SESSION["admin_id"]));
            $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "old_job_creds" => $old_job_creds, "new_job_creds" => $new_job_creds, "admin" => $admin);
            $logs -> insert($data);
        }
        return array("success" => true);
    }

    public function update_it_job_spec() {
        $db = $this -> db;
        $gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
        $old_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
        $gs_job_role_selection_id = $gs_jtd["gs_job_role_selection_id"];

        $this -> __insertBatchCredentialsWithRatings("system", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("database", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("pc_products", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("platforms", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("app_programming", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("multimedia", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertBatchCredentialsWithRatings("open_source", $gs_job_role_selection_id, $gs_job_titles_details_id);

        if (!empty($_REQUEST["responsibility"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
            foreach ($_POST["responsibility"] as $key => $responsibility) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "responsibility", "description" => $responsibility, "div" => "responsibility_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'responsibility'");
        }

        if (!empty($_REQUEST["other_skills"])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
            foreach ($_POST["other_skills"] as $key => $val) {
                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => "other_skills", "description" => $val, "div" => "other_skills_div");
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = 'other_skills'");
        }

        $this -> __insertCredentials("comments", $gs_job_role_selection_id, $gs_job_titles_details_id);
        $this -> __insertCredentials("onshore", $gs_job_role_selection_id, $gs_job_titles_details_id);

        $new_job_creds = $db -> fetchAll($db -> select() -> from(array("gs_creds" => "gs_job_titles_credentials")) -> where("gs_job_titles_details_id = ?", $gs_job_titles_details_id));
		
		$retries = 0;
		while(true){
			try{
				if (TEST) {
		            $mongo = new MongoClient(MONGODB_TEST);
		            $database = $mongo -> selectDB('prod_logs');
		        } else {
		            $mongo = new MongoClient(MONGODB_SERVER);
		            $database = $mongo -> selectDB('prod_logs');
		        }
				break;
			} catch(Exception $e){
				++$retries;
				
				if($retries >= 100){
					break;
				}
			}
		}
        

        $logs = $database -> selectCollection("job_specifications_change_logs");

        if ($_SESSION["admin_id"]) {
            $admin = $db -> fetchRow($db -> select() -> from("admin", array("admin_fname", "admin_lname", "admin_id")) -> where("admin_id = ?", $_SESSION["admin_id"]));
            $data = array("gs_job_titles_details_id" => $gs_job_titles_details_id, "old_job_creds" => $old_job_creds, "new_job_creds" => $new_job_creds, "admin" => $admin);
            $logs -> insert($data);
        }
        return array("success" => true);
    }

    private function __insertBatchCredentialsWithRatings($key, $gs_job_role_selection_id, $gs_job_titles_details_id) {
        $db = $this -> db;
        if (!empty($_POST[$key])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = '$key'");
            foreach ($_POST[$key] as $key_val => $val) {
                $rating = $_POST[$key . "_ratings"][$key_val];

                $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => $key, "description" => $val, "div" => "{$key}_div", "rating" => $rating);
                $db -> insert("gs_job_titles_credentials", $data);
            }
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id = " . $gs_job_titles_details_id . " AND box = '$key'");
        }
    }

    private function __insertCredentials($key, $gs_job_role_selection_id, $gs_job_titles_details_id) {
        $db = $this -> db;
        if (isset($_POST[$key])) {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id=" . $gs_job_titles_details_id . " AND box = '{$key}'");
            $data = array("gs_job_role_selection_id" => $gs_job_role_selection_id, "gs_job_titles_details_id" => $gs_job_titles_details_id, "box" => $key, "description" => $_POST[$key], "div" => "");

            $db -> insert("gs_job_titles_credentials", $data);
        } else {
            $db -> delete("gs_job_titles_credentials", "gs_job_titles_details_id=" . $gs_job_titles_details_id . " AND box = '{$key}'");
        }

    }

    public function addNewRequiredSkillTask() {
        $db = $this -> db;
        $manager = new SkillTaskManager($db);
        if (isset($_POST["gs_job_titles_details_id"])) {
            $gs_job_titles_details_id = $_POST["gs_job_titles_details_id"];
            $result = $manager -> addSkillTask();
            if ($result["success"]) {
                $gs_jtd = $db -> fetchRow($db -> select() -> from("gs_job_titles_details") -> where("gs_job_titles_details_id = ?", $_POST["gs_job_titles_details_id"]));
                $required_skills = $db -> fetchAll($db -> select() -> from(array("jpst" => "job_position_skills_tasks")) -> where("sub_category_id = ?", $gs_jtd["sub_category_id"]) -> where("type = ?", "skill"));
                $required_tasks = $db -> fetchAll($db -> select() -> from(array("jpst" => "job_position_skills_tasks")) -> where("sub_category_id = ?", $gs_jtd["sub_category_id"]) -> where("type = ?", "task"));
                return array("success" => true, "required_skills" => $required_skills, "required_tasks" => $required_tasks);
            } else {
                return array("success" => false, "error" => $error);
            }

        } else {
            return array("success" => false, "error" => "Missing Job Order ID");

        }

    }

}
