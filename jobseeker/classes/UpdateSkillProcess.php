<?php
/**
 * Class responsible for updating education
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../forms/AddSkillForm.php";
require_once dirname(__FILE__)."/../forms/UpdateSkillForm.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";


class UpdateSkillProcess extends EditProcess{
	
	public function render(){
		$db = $this->db;
		$userid = $_SESSION["userid"];
		if (!isset($userid)){
			die("Missing userid");
		}
		
		$smarty = $this->smarty;
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid));
		$this->syncUserInfo();
		$form = new UpdateSkillForm();
		$form->getElement("userid")->setValue($userid);
		$smarty->assign_by_ref("form", $form);
		$smarty->assign("skills", $skills);
		$this->setActive("skill_active");
		$this->setActive("resume_active");
		
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
		
		if ($skill["userid"]!=$_SESSION["userid"]){
			die("Invalid skill");
		}
		
		
		foreach($skill as $key=>$value){
			try{
				if ($form->getElement($key)!=null){
					$form->getElement($key)->setValue($value);		
				}
					
			}catch(Exception $e){
				
			}		
		}
		$this->syncUserInfo();
		$this->setActive("skill_active");
		$this->setActive("resume_active");
		
		$smarty->assign_by_ref("form", $form);
		$smarty->display("updateskillinfo.tpl");
		
	}
	
	public function addSkill(){
		$db = $this->db;
		$addSkillForm = new AddSkillForm();
		if ($addSkillForm->isValid($_POST)){
				
			$userid = $_SESSION["userid"];
			$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid));
			foreach($skills as $skill){
				if (strtolower($skill["skill"])==strtolower($_POST["skill"])){
					echo json_encode(array("success"=>false, "error"=>"You already listed this skill. Please try again."));
					exit;
				}	
			}
			$skill = $addSkillForm->getValues();
			$db->insert("skills", $skill);
			$id = $db->lastInsertId("skills");
			$new_skill = $db->fetchRow($db->select()->from("skills")->where("id = ?", $id));
			$history_changes = "Added new skill <span style='color:red;'>".$skill["skill"]."</span>";
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
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
			
			global $base_api_url;
			
			file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
			
			return array("success"=>true, "skill"=>$new_skill);
		}else{
			return array("success"=>false);
		}	
		
	}
		
	public function updateSkill(){
		$db = $this->db;
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $_SESSION["userid"]));
		foreach($skills as $skill){
			if ($skill["id"]!=$_REQUEST["id"]&&$_POST["skill"]==$skill["skill"]){
				return array("success"=>false, "error"=>"You already listed this skill. Please try again.");
			}	
		}
		
		$updateSkillForm = new UpdateSkillForm();
		if ($updateSkillForm->isValid($_POST)){
			$skill = $updateSkillForm->getValues();
			//before
			$userid = $_SESSION["userid"];
			$old = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("id = ?", $_REQUEST["id"]));
			
			
			$db->update("skills", $skill, $db->quoteInto("id = ?", $skill["id"]));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			$new = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("id = ?", $_REQUEST["id"]));
			
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
			
			}
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			global $base_api_url;
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
			
			
			file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
			
			return array("success"=>true, "skill"=>$new);
		}else{
			return array("success"=>false);
		}
		
		
		
	}
	
	public function deleteSkill(){
		$db = $this->db;
		$skill_id = $_GET["id"];
		$skill = $db->fetchRow($db->select()->from("skills")->where("id = ?", $_GET["id"]));
		if ($skill["userid"]!=$_SESSION["userid"]){
			return array("success"=>false);
		}
		$userid = $_SESSION["userid"];
		$db->delete("skills", $db->quoteInto("id = ?", $skill_id));
		$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid));
		
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
		$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $_SESSION["userid"]));
		$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
		
		global $base_api_url;
		
		file_get_contents($base_api_url . "/solr-index/sync-candidates/");
							
		
		file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
		
		
		
		return array("success"=>true);
	}
	
	
}
