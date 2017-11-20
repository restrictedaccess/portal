<?php
/**
 * Class responsible for rendering and processing content
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/ApplicationLoader.php";
require_once dirname(__FILE__)."/FileLoader.php";

class HomeLoader extends EditProcess{
	
	/**
	 * The application loader that loads and process applications
	 */
	private $applicationLoader;
	
	/**
	 * The file loader that loads and process files
	 */
	private $fileLoader;
	
	public function __construct($db){
		parent::__construct($db);
		$this->applicationLoader = new ApplicationLoader($db);
		$this->fileLoader = new FileLoader($db);	
	}
	
	
	public function render(){



        $this->preprocess();
		$smarty = $this->smarty;
		$db = $this->db;
		$this->syncUserInfo();
		global $base_api_url;
		$smarty->assign("base_api_url", $base_api_url);
		$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $_SESSION["userid"]));
		$smarty->assign("userid", $_SESSION["userid"]);
		$smarty->assign("applications", $this->applicationLoader->loadAllApplication($_SESSION["userid"], 3));
		$smarty->assign("remaining_application", 10-$this->applicationLoader->countActiveApplication($_SESSION["userid"]));
		$smarty->assign("progress", $this->getProgress($_SESSION["userid"]));
		$smarty->assign("files", $this->fileLoader->listAllUploads($_SESSION["userid"], 3));
		$smarty->assign("next_progress", $this->getNextProgress($_SESSION["userid"]));
		$smarty->assign("currentjob", $currentjob);
		$this->setActive("home_active");
		$smarty->display("index.tpl");
	}
	
	
	private function getNextProgress($userid){
		$db = $this->db;
		$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $userid));
		$itemsToFinish = array();
        //Commented out by Josef Balisalisa
        //Temporarily disable profile completion in jobseeker's view
//		if ($personal){
//			if ($personal["fname"]==""){
//				$itemsToFinish[] = array("step"=>1, "link"=>"/portal/jobseeker/personal_information.php", "label"=>"Update your Personal Information");
//			}
//			if ($personal["speed_test"]==""){
//				$itemsToFinish[] = array("step"=>2, "link"=>"/portal/jobseeker/working_at_home_capabilities.php", "label"=>"Update your Working at Home Capabilities");
//			}
//			$education = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("e.userid = ?", $userid));
//			if (!$education){
//				$itemsToFinish[] = array("step"=>3, "link"=>"/portal/jobseeker/educational_details.php", "label"=>"Update your Educational Details");
//			}
//			$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $userid));
//			if (!$currentjob){
//				$itemsToFinish[] = array("step"=>4, "link"=>"/portal/jobseeker/work_experience.php", "label"=>"Update your Work Experience");
//			}
//			$skill = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("userid = ?", $userid));
//			if (!$skill){
//				$itemsToFinish[] = array("step"=>5, "link"=>"/portal/jobseeker/skills.php", "label"=>"Update your Skill Details");
//			}
//			$language = $db->fetchRow($db->select()->from(array("l"=>"language"))->where("userid = ?", $userid));
//			if (!$language){
//				$itemsToFinish[] = array("step"=>6, "link"=>"/portal/jobseeker/languages.php", "label"=>"Update your Language Details");
//			}
//			if (is_null($personal["voice_path"])){
//				$itemsToFinish[] = array("step"=>7, "link"=>"", "label"=>"Upload your voice recording", "cls"=>"pop_dialog");
//			}
//			if (is_null($personal["image"])){
//				$itemsToFinish[] = array("step"=>8, "link"=>"", "label"=>"Upload your photo", "cls"=>"pop_dialog");
//			}
//		}
		if (!empty($itemsToFinish)){
			return $itemsToFinish[0];
		}else{
			return array();
		}
	}
	
	/**
	 * Get progress of profile of user
	 */
	private function getProgress($userid){
		$db = $this->db;
		$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $userid));
		$level = 0;
		if ($personal){
			if ($personal["fname"]!=""){
				$level++;
			}	
			if ($personal["speed_test"]!=""){
				$level++;
			}
			$education = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("e.userid = ?", $userid));
			if ($education){
				$level++;
			}
			$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $userid));
			if ($currentjob){
				$level++;
			}
			$skill = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("userid = ?", $userid));
			if ($skill){
				$level++;
			}
			$language = $db->fetchRow($db->select()->from(array("l"=>"language"))->where("userid = ?", $userid));
			if ($language){
				$level++;
			}
			if (!is_null($personal["voice_path"])){
				$level++;
			}
			if (!is_null($personal["image"])){
				$level++;
			}
		}
		
		$progress = round(($level/8)*100);
		return $progress;
	}
	
	/**
	 * Boots Homeloader preprocess to correctly render output
	 */
	private function preprocess(){
		$this->applicationLoader->expireApplications($_SESSION["userid"]);
		
		$userid = $_SESSION["userid"];
		$db = $this->db;
		
		//sync remote ready
		$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid)->limit(5));
		$this->subtractRemoteReadyScore($userid, 3);
			
//		$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 3");
		if (!empty($skills)){
			//create or update entry for remote ready
			foreach($skills as $skill){
				$data = array();
				$data["userid"] = $userid;
				$data["remote_ready_criteria_id"] = 3;
				$data["date_created"] = date("Y-m-d H:i:s");
//				$db->insert("remote_ready_criteria_entries", $data);
			}
		}
		
		$cj = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
		$counter = 0;
		for($i=1;$i<=10;$i++){
			$suffix = $i;
			if ($i==1){
				$suffix = "";
			}
			if (!(trim($cj["companyname".$suffix])==""||trim($cj["position".$suffix])==""||trim($cj["duties".$suffix])=="")){
				$counter++;
			}
		}
		if ($counter<=5&&$counter>0){
			$this->subtractRemoteReadyScore($userid, 4);	
//			$db->delete("remote_ready_criteria_entries", "remote_ready_criteria_id = 4 AND userid = ".$userid);
		
			$counter = 0;
			for($i=1;$i<=10;$i++){
				$suffix = $i;
				if ($i==1){
					$suffix = "";
				}
				if (!(trim($cj["companyname".$suffix])==""||trim($cj["position".$suffix])==""||trim($cj["duties".$suffix])=="")){
					if ($counter!=5){
						$data = array();
						$data["userid"] = $userid;
						$data["remote_ready_criteria_id"] = 4;
						$data["date_created"] = date("Y-m-d H:i:s");
//						$db->insert("remote_ready_criteria_entries", $data);
						$counter++;
					}
				}
			}
		}
		
		
		$personal = $db->fetchRow($db->select()->from("personal", array("image", "voice_path"))->where("userid = ?", $userid));
		if ($personal["image"]){
			$data = array();
			$this->subtractRemoteReadyScore($userid, 1);
			
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 1");
			$data["userid"] = $userid;
			$data["remote_ready_criteria_id"] = 1;
			$data["date_created"] = date("Y-m-d h:i:s");
//			$db->insert("remote_ready_criteria_entries", $data);
		}

		if ($personal["voice_path"]){
			$data = array();
			$this->subtractRemoteReadyScore($userid, 2);
			
//			$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 2");
			$data["userid"] = $userid;
			$data["remote_ready_criteria_id"] = 2;
			$data["date_created"] = date("Y-m-d h:i:s");
//			$db->insert("remote_ready_criteria_entries", $data);
		}
		
	}
}
