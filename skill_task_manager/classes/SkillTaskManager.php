<?php
//require_once dirname(__FILE__)."/../../lib/Portal.php";
class SkillTaskManager /*extends Portal*/ {
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
	}
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$categories = $db->fetchAll($db->select()->from(array("c"=>"job_category"))->where("status = ?", "posted")->order("category_name"));
		foreach($categories as $key=>$category){
			$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"))->where("category_id = ?", $category["category_id"]));
			$categories[$key]["subcategories"] = $subcategories;
		}
		$smarty->assign("categories", $categories);
		$smarty->display("index.tpl");
	}
	
	
	public function addSkillTask(){
		$db = $this->db;
		$data = $_POST;
		
		if (isset($data["value"])&&trim($data["value"])==""){
			return array("success"=>false, "error"=>"Please enter a task/skill name");
		}
		if(isset($_SESSION["admin_id"])){
			$data["admin_id"] = $_SESSION["admin_id"];
		}
		$data["date_created"] = date("Y-m-d H:i:s");
		if (isset($_REQUEST["id"])){
			$id  = $_REQUEST["id"];
			$skillTask = $db->fetchRow($db->select()->from("job_position_skills_tasks")->where("LOWER(value) = ?", strtolower($data["value"]))->where("sub_category_id = ?", $data["sub_category_id"])->where("type = ?", $data["type"])->where("id <> ?", $data["id"]));
			if ($skillTask){
				if ($data["type"]=="task"){
					return array("success"=>false, "error"=>"Task Already Added.");					
				}else{
					return array("success"=>false, "error"=>"Skill Already Added.");
				}
			}
			
			$skillTask = $db->fetchRow($db->select()->from("job_position_skills_tasks")->where("id = ?", $id));
			if ($skillTask){
				unset($data["id"]);
				$db->update("job_position_skills_tasks", $data, $db->quoteInto("id = ?", $id) );
			}else{
				$db->insert("job_position_skills_tasks", $data);
			}
		}else{
			$skillTask = $db->fetchRow($db->select()->from("job_position_skills_tasks")->where("LOWER(value) = ?", strtolower($data["value"]))->where("sub_category_id = ?", $data["sub_category_id"])->where("type = ?", $data["type"]));
			if (!$skillTask){
				$db->insert("job_position_skills_tasks", $data);			
			}else{
				if ($data["type"]=="task"){
					return array("success"=>false, "error"=>"Task Already Added.");					
				}else{
					return array("success"=>false, "error"=>"Skill Already Added."); 
				}
			}
		}
		
		return array("success"=>true);
	}
	
	public function getSkillTaskList(){
		$db = $this->db;
		$id = $_REQUEST["sub_category_id"];
		$sub_category = $db->fetchRow($db->select()->from("job_sub_category", array("sub_category_name", "sub_category_id"))->where("sub_category_id = ?", $id));
		$skillTask = $db->fetchAll($db->select()->from("job_position_skills_tasks")->where("sub_category_id = ?", $id));
		return array("success"=>true, "result"=>$skillTask, "sub_category"=>$sub_category);
	}
	
	
	public function deleteTask(){
		$id = $_REQUEST["id"];
		$db = $this->db;
		if ($id){
			$task_preference = $db->fetchRow($db->select()->from("personal_task_preferences")->where("task_id = ?", $id));
			if ($task_preference){
				return array("success"=>false, "error"=>"Task Already Added by a candidate. Cannot Delete.");
			}else{
				$db->delete("job_position_skills_tasks", $db->quoteInto("id = ?", $id));
				return array("success"=>true);
			}			
		}else{
			return array("success"=>false, "error"=>"Invalid Request");
		}

	}
	
	public function getSkillTask(){
		$db = $this->db;
		$id = $_REQUEST["id"];
		$skillTask = $db->fetchRow($db->select()->from("job_position_skills_tasks")->where("id = ?", $id));
		return array("success"=>true, "result"=>$skillTask);
	}
	
}
