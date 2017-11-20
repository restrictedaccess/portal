<?php
/**
 * 
 * Class responsible for updating task preference
 *
 * @version 0.1 - Initial commit on Staff Information
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
class UpdateTasksProcess{
	private $db;
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
		foreach($_REQUEST as $key=>$val){
			if (!is_array($val)){
				$_REQUEST[$key] = strip_tags($val);
			}
		}
	}	
	
	public function render(){
		$db = $this->db;
		$userid = $_REQUEST["userid"];
		//load preferred tasks
		$sub_categories = $db->fetchAll($db->select()->from(array("pt"=>"personal_task_preferences"), array())->joinLeft(array("jst"=>"job_position_skills_tasks"), "jst.id = pt.task_id", array("sub_category_id"))->where("pt.userid = ?", $userid)->group("jst.sub_category_id"));
		foreach($sub_categories as $key=>$subcategory){
			$sub_category_name = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $subcategory["sub_category_id"]));
			$sub_categories[$key]["sub_category_name"] = $sub_category_name;	
			$tasks = $db->fetchAll($db->select()->from(array("pt"=>"personal_task_preferences"))->joinLeft(array("jst"=>"job_position_skills_tasks"), "jst.id = pt.task_id", array("jst.value AS task_desc"))->where("pt.userid = ?", $userid)->where("jst.sub_category_id = ?", $subcategory["sub_category_id"]));
			$sub_categories[$key]["tasks"] = $tasks;
		}
		
		
		$smarty = new Smarty();
		$smarty->assign("sub_categories", $sub_categories);
		
		$categories = $this->getCategories();
		$position_first_choice_options = "<option value=''>Select Position</option>";
		foreach($categories as $key=>$category){

			$categories[$key]['subcategories'] = $this->getSubCategories($category['category']['id']);
			$position_first_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			foreach($categories[$key]['subcategories'] as $key2=>$subcategory){

				//create sub-categories option
				$selected = "";
				
				if($subcategory['category_name'] != ''){
					
					$position_first_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";
					
				}
					
			}
			$position_first_choice_options .= "</optgroup>";
		}
		
		
		$ratings_option = array();
		for($i=1;$i<=10;$i++){
			$ratings_option[] = $i;
		}
		$smarty->assign("ratings_option", $ratings_option);
		$smarty->assign("userid", $userid);
		$smarty->assign("categories",$position_first_choice_options);
		$smarty->display("updatetasks.tpl");
	}
	
	
	public function addTask(){
		$data = $_POST;
		$db = $this->db;
		$form = new AddTaskForm();
		if ($form->isValid($_POST)){
			$data = $form->getValues();
			$userid = $data["userid"];
			$data["date_created"] = date("Y-m-d H:i:s");
			
			$task = $db->fetchRow($db->select()->from("personal_task_preferences")->where("userid = ?", $userid)->where("task_id = ?", $data["task_id"]));
			if ($task){
				return array("success"=>false, "error"=>"Task preference is already added.");
			}
			
			$db->insert("personal_task_preferences", $data);
			$id = $db->lastInsertId("personal_task_preferences");
			$personal_task_preference = $db->fetchRow($db->select()->from(array("ptp"=>"personal_task_preferences"), array("ptp.ratings"))
													->joinLeft(array("jpst"=>"job_position_skills_tasks"), "jpst.id = ptp.task_id", array("jpst.value AS task"))
													->where("ptp.id = ?", $id));
			
			$history_changes = "Added new task preference <span style='color:red;'>".$personal_task_preference["task"]."</span> with ratings of <span style='color:red;'>".$personal_task_preference["ratings"]."/10</span>";
			$changeByType = $_SESSION["status"];
			if ($changeByType=="FULL-CONTROL"){
				$changeByType = "ADMIN";
			}
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			
			return array("success"=>true, "task"=>$personal_task_preference);
		}else{
			if (!isset($_REQUEST["job_position"])||!$_REQUEST["job_position"]){
				return array("success"=>false, "error"=>"Job Position is required");
			}
			if (!isset($_REQUEST["task_id"])||!$_REQUEST["task_id"]){
				return array("success"=>false, "error"=>"Task is required");
			}	
			if (!isset($_REQUEST["ratings"])||!$_REQUEST["ratings"]){
				return array("success"=>false, "error"=>"Ratings is required");
			}
			
			
			return array("success"=>false);
		}
	}
	public function updateTask(){
		$data = $_POST;
		$db = $this->db;
		$form = new UpdateTaskForm();
		if ($form->isValid($_POST)){
			$data = $form->getValues();
			$userid = $data["userid"];
			$id = $data["id"];
			$old_personal_task_preference = $db->fetchRow($db->select()->from(array("ptp"=>"personal_task_preferences"), array("ptp.ratings"))
													->joinLeft(array("jpst"=>"job_position_skills_tasks"), "jpst.id = ptp.task_id", array("jpst.value AS task"))
													->where("ptp.id = ?", $id));
			
			
			$db->update("personal_task_preferences", $data, $db->quoteInto("id = ?", $id));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$id));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			$personal_task_preference = $db->fetchRow($db->select()->from(array("ptp"=>"personal_task_preferences"), array("ptp.ratings"))
													->joinLeft(array("jpst"=>"job_position_skills_tasks"), "jpst.id = ptp.task_id", array("jpst.value AS task"))
													->where("ptp.id = ?", $id));
			
			$history_changes = "Update task preference <span style='color:red;'>".$personal_task_preference["task"]."'s ratings</span> from <span style='color:red;'>".$old_personal_task_preference["ratings"]."/10</span> to <span style='color:red;'>".$personal_task_preference["ratings"]."/10</span>";
			$changeByType = $_SESSION["status"];
			if ($changeByType=="FULL-CONTROL"){
				$changeByType = "ADMIN";
			}
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			
			return array("success"=>true, "task"=>$personal_task_preference);
		}else{
			return array("success"=>false);
		}
	}
	public function deleteTask(){
		$data = $_POST;
		$db = $this->db;
		if (isset($data["id"])){
			$id = $data["id"];
			$personal_task_preference = $db->fetchRow($db->select()->from(array("ptp"=>"personal_task_preferences"), array("ptp.ratings", "ptp.userid"))
													->joinLeft(array("jpst"=>"job_position_skills_tasks"), "jpst.id = ptp.task_id", array("jpst.value AS task"))
													->where("ptp.id = ?", $id));
			$db->delete("personal_task_preferences", $db->quoteInto("id = ?", $id));
			$userid = $personal_task_preference["userid"];
			$history_changes = "Deleted task preference <span style='color:red;'>".$personal_task_preference["task"]."'s ratings</span> with ratings of <span style='color:red'>{$personal_task_preference["ratings"]}/10</span>";
			$changeByType = $_SESSION["status"];
			if ($changeByType=="FULL-CONTROL"){
				$changeByType = "ADMIN";
			}
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}	
			return array("success"=>true);
		}else{
			return array("success"=>false);
		}
	}
	/**
	 * Get All Categories
	 */
	private function getCategories($category = null){

		$db = $this->db;

		$category_filter = '';
		if($category != null){
			$category_filter = 'and  category_id = '.$category;
		}

		$select="SELECT category_id, category_name FROM job_category
			WHERE status='posted' ".$category_filter." 
			ORDER BY category_name";
		$rows = $db->fetchAll($select);

		$categories = array();
		foreach($rows as $row){
			$category = array();
			$category['category']['id'] = $row['category_id'];
			$category['category']['name'] = $row['category_name'];
			$categories[] = $category;
		}
		return $categories;
	}
	/**
	 * Get All subcategory under the given category
	 */
	private function getSubCategories($category_id){

		$db = $this->db;
		$select = "SELECT sub_category_id, sub_category_name
				FROM job_sub_category 
				WHERE category_id='".$category_id."' AND 
				status = 'posted' 
				ORDER BY sub_category_name";
		$rows = $db->fetchAll($select);

		$subcategories = array();
		foreach($rows as $row){
			$subcategories[$row['sub_category_id']]['category_name'] = $row['sub_category_name'];
		}
		return $subcategories;
	}
	
}