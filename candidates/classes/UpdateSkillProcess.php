<?php
/**
 * 
 * Class responsible for updating skills
 *
 * @version 0.1 - Initial commit on Staff Information
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
class UpdateSkillProcess{
	private $db;
	private $smarty;
	private $errors;
	private $success = false;
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->errors = array();
		$this->authCheck();
	}
	
	
	private function authCheck(){
	
		session_start();
		if (!isset($_SESSION["admin_id"])){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				die;
			}else{
				header("location:/portal/index.php");
			}
		}
	}	
	
	
	public function renderUpdate(){
		$db = $this->db;
		$userid = $_GET["userid"];
		if (!isset($userid)){
			die("Missing userid");
		}
		
		$smarty = $this->smarty;
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid));
		
		$form = new UpdateSkillForm();
		$form->getElement("userid")->setValue($userid);
		$smarty->assign_by_ref("form", $form);
		$smarty->assign("skills", $skills);
		$smarty->display("updateskills.tpl");
	}
	
	public function renderUpdateInfo(){
		$db = $this->db;
		$id = $_GET["id"];
		if (!isset($id)){
			die("Missing skill id");
		}
		$skill = $db->fetchRow($db->select()->from("skills")->where("id = ?", $_GET["id"]));
		$smarty = $this->smarty;
		$form = new UpdateSkillForm();
		foreach($skill as $key=>$value){
			try{
				if ($form->getElement($key)!=null){
					$form->getElement($key)->setValue($value);		
				}
					
			}catch(Exception $e){
				
			}		
		}
		$smarty->assign_by_ref("form", $form);
		$smarty->display("updateskillinfo.tpl");
		
	}
	
	public function addSkill(){
		$db = $this->db;
		$addSkillForm = new AddSkillForm();
		if ($addSkillForm->isValid($_POST)){
			$userid = $_REQUEST["userid"];
			$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid));
			foreach($skills as $skill){
				if (strtolower($skill["skill"])==strtolower($_POST["skill"])){
					echo json_encode(array("success"=>false, "error"=>"You already listed that skill. Please try again."));
					exit;
				}	
			}
			$skill = $addSkillForm->getValues();
			$db->insert("skills", $skill);
			$id = $db->lastInsertId("skills");
			$newly_added_skill = $db->fetchRow($db->select()->from("skills")->where("id = ?", $id));
			$history_changes = "Added new skill <span style='color:red;'>".$skill["skill"]."</span>";
			$changeByType = $_SESSION["status"];
			if ($changeByType=="FULL-CONTROL"){
				$changeByType = "ADMIN";
			}
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db->delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid)->limit(5));
			$this->subtractRemoteReadyScore($userid, 3);
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 3");
			if (!empty($skills)){
				//create or update entry for remote ready
				foreach($skills as $skill){
					$data = array();
					$data["userid"] = $userid;
					$data["remote_ready_criteria_id"] = 3;
					$data["date_created"] = date("Y-m-d H:i:s");
//					$db->insert("remote_ready_criteria_entries", $data);
				}
			}
			
			
			return array("success"=>true, "skill"=>$newly_added_skill);
		}else{
			return array("success"=>false);
		}	
		
	}
		
	public function updateSkill(){
		$db = $this->db;
		$updateSkillForm = new UpdateSkillForm();
		if ($updateSkillForm->isValid($_POST)){
			//before
			$userid = $_REQUEST["userid"];
			
			$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid));
			foreach($skills as $skill){
				if (strtolower($skill["skill"])==strtolower($_POST["skill"])&&($_POST["id"]!=$skill["id"])){
					echo json_encode(array("success"=>false, "error"=>"You already listed that skill. Please try again."));
					exit;
				}	
			}
			
			
			
			$skill = $updateSkillForm->getValues();
			
			
			
			
			
			$old = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("id = ?", $_REQUEST["id"]));
			
			
			$db->update("skills", $skill, $db->quoteInto("id = ?", $skill["id"]));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			$new = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("id = ?", $_REQUEST["id"]));
			
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				$changeByType = $_SESSION["status"];
				if ($changeByType=="FULL-CONTROL"){
					$changeByType = "ADMIN";
				}
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			
			}
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?", $userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			return array("success"=>true, "skill"=>$new);
		}else{
			return array("success"=>false);
		}
		
		
	}
	
	public function deleteSkill(){
		$db = $this->db;
		$skill_id = $_GET["id"];
		$skill = $db->fetchRow($db->select()->from(array("s"=>"skills"), array("userid"))->where("id = ?", $skill_id));
		$db->delete("skills", $db->quoteInto("id = ?", $skill_id));
		$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid));

        $changeByType = $_SESSION["status"];
        if ($changeByType=="FULL-CONTROL"){
            $changeByType = "ADMIN";
        }
        $db->insert("staff_history", array("changes"=>"Deleted Skill <font color=#FF0000>{$skill["skill"]}</font>", "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
		
		if (count($skills)<=5&&count($skills)>0){
			$this->subtractRemoteReadyScore($userid, 3);
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 3");
			if (!empty($skills)){
				//create or update entry for remote ready
				foreach($skills as $skill){
					$data = array();
					$data["userid"] = $userid;
					$data["remote_ready_criteria_id"] = 3;
					$data["date_created"] = date("Y-m-d H:i:s");
//					$db->insert("remote_ready_criteria_entries", $data);
				}
			}	
		}
		
		$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $skill["userid"]));
		$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$_REQUEST["userid"]));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}

		return array("success"=>true);
	}
	
	protected function subtractRemoteReadyScore($userid, $criteria){
		//subtract score
//		$db = $this->db;
//		$entries = $db->fetchAll($db->select()->from(array("rrce"=>"remote_ready_criteria_entries"), array("rrce.id AS rrce_id"))->joinLeft(array("rrc"=>"remote_ready_criteria"), "rrce.remote_ready_criteria_id = rrc.id", array("rrc.points AS points"))->where("rrce.userid = ?", $userid)->where("rrce.remote_ready_criteria_id = ?", $criteria));
//		$sum = 0;
//		foreach($entries as $entry){
//			$sum+=intval($entry["points"]);
//		}
//		//find summation entry
//		$summation = $db->fetchRow($db->select()->from(array("rrcesp"=>"remote_ready_criteria_entry_sum_points"))->where("rrcesp.userid = ?", $userid));
//		if ($summation){
//			$db->update("remote_ready_criteria_entry_sum_points", array("points"=>$summation["points"]-$sum), $db->quoteInto("userid = ?", $userid));
//			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
//		}
	}
}
