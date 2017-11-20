<?php
/**
 * Class responsible for rendering and processing resume content
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";

class ResumeLoader extends EditProcess{
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		//load user details
		$userid = $_SESSION["userid"];
		$user = $this->getUser($userid);
		
		//update state value
		$regions = array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas');
		$ph_states_code = array("AR", "BR", "CA", "CG", "CL", "CM", "CR", "CV", "EV", "IL", "NC", "NM", "SM", "ST", "WM", "WV");
		foreach($ph_states_code as $key => $code){
			if ($code==$user["state"]){
				$user["state"] = $regions[$key];
			}
		}
		try{
			$sql = $db->select()
				->from('country')->where("iso = ?", $user["country_id"]); 
			$country = $db->fetchRow($sql);	
			$user["country"] = $country["printable_name"];			
		}catch(Exception $e){
			$user["country"] = "Philippines";
		}

		
		$user["dateapplied"] = date("F j, Y", strtotime($user["datecreated"]));
		$user["datelastupdated"] = date("F j, Y", strtotime($user["dateupdated"]));
		$user["currentjob"] = $this->getCurrentJob($userid);
		
		
		if ($user["byear"]&&$user["bmonth"]&&$user["bday"]){
			$user["birth_date"] = date("M d Y", strtotime($user["byear"]."-".$user["bmonth"]."-".$user["bday"]));		
			$diff = abs(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d", strtotime($user["byear"]."-".$user["bmonth"]."-".$user["bday"]))));
			$user["age"] = floor($diff / (365*60*60*24));
		}else{
			$user["birth_date"] = "";
			$user["age"] = "";
		}
		$user["address"] = "";
		if ($user["address1"]&&$user["city"]&&$user["postcode"]){
			$user["address"] .= $user['address1']." ".$user['city']." ".$user['postcode']." <br>";
		}
		if ($user["state"]&&$user["country_id"]){
			$user["address"] .= $user['state']." ".$user['country_id'];
		}
		$user["telephone"] = $user['tel_area_code']." - ".$user['tel_no'];
		$user["mobile"] = $user['handphone_country_code']."+".$user['handphone_no'];
		if($user["headset_quality"]=="0") {
			$user["headset_quality"] ="No Headset Available";
		}	
		if ($user["work_from_home_before"]==1){
			$user["work_from_home_before"] = "Yes";
		}else if (is_null($user["work_from_home_before"])){
			$user["work_from_home_before"] = "";
		}else{
			$user["work_from_home_before"] = "No";
		}
		if ($user["has_baby"]){
			if ($user["has_baby"]==1){
				$user["has_baby"] = "Yes";
			}else if ($user["has_baby"]==0){
				$user["has_baby"] = "No";
			}
		}else{
			if (is_null($user["has_baby"])){
				$user["has_baby"] = "";
			}else{		
				$user["has_baby"] = "No";	
			}
		}
		$user["date_delivery"] = date("M d Y", strtotime($user["dyear"]."-".$user["dmonth"]."-".$user["dday"]));
		$user["character_references"] = $this->getCharacterReferences($userid);
		$user["skills"] = $this->getSkills($userid);
		$user["languages"] = $this->getLanguages($userid);
		$user["education"] = $this->getEducation($userid);
		$user["education"]["trainings_seminars"] = nl2br($user["education"]["trainings_seminars"]);
		if ($user["education"]["graduate_month"]){
			$user["education"]["graduation"] = date("M Y", strtotime($user["education"]["graduate_year"]."-".$user["education"]["graduate_month"]."-1"));
		}else{
			$user["education"]["graduation"] = $user["education"]["graduate_year"];
		}
		$user["hardwares"] = $this->renderComputerHardware($user);
		$user["noise"] = $this->renderNoiseLevel($user);
		$user["jobs"] = $this->transformCurrentJobEntries($user);
		if ($user["gender"]=="Male"){
			$smarty->assign("pronoun", "his");
		}else{
			$smarty->assign("pronoun", "her");
		}
		$currentjob = $user["currentjob"];
		if ($currentjob["available_status"]=="p"){
			$currentjob["available_status"] = "I am not actively looking for a job now";
		}else if ($currentjob["available_status"]=="a"){
			$currentjob["available_status"] = "I can start work after {$currentjob["available_notice"]} week(s) of notice period";
		}else if ($currentjob["available_status"]=="b"){
			$currentjob["available_status"] = "I can start work after {$currentjob["aday"]} - {$currentjob["amonth"]} - {$currentjob["ayear"]}";
		}else if (strtolower($currentjob["available_status"])=="work immediately"){
			$currentjob["available_status"] = "Work Immediately";
		}else{
			$currentjob["available_status"] = "";
		}
		
		if ($currentjob["intern_status"]==1&&$currentjob["freshgrad"]==0){
			$currentjob["current_status"] = "I am still pursuing my studies and seeking internship or part-time jobs";
		}else if ($currentjob["intern_status"]==0&&$currentjob["freshgrad"]==1){
			$currentjob["current_status"] = "I am a fresh graduate seeking my first job";
		}else{
			if ($currentjob["years_worked"]==1){
				$years = "year";
			}else{
				$years = "years";
			}
			if ($currentjob["months_worked"]==1){
				$months = "month";
			}else{
				$months = "months";
			}			
			$currentjob["current_status"] = "I have been working for {$currentjob["years_worked"]} {$years} and {$currentjob["months_worked"]} {$months}.";
		}
		
		if ($currentjob["expected_salary_neg"]=="Yes"){
			$currentjob["expected_salary_neg"] = "Negotiable";			
		}else{
			$currentjob["expected_salary_neg"] = "";
		}
		
		$currentjob["position_first_choice"] = $this->getJobSubCategory($currentjob["position_first_choice"]);
		$currentjob["position_second_choice"] = $this->getJobSubCategory($currentjob["position_second_choice"]);
		$currentjob["position_third_choice"] = $this->getJobSubCategory($currentjob["position_third_choice"]);
		
		
		$user["currentjob"] = $currentjob;
		$this->setActive("resume_active");
		$smarty->assign("user", $user);
		$smarty->display("resume.tpl");
		
		
	}
	
	private function getCharacterReferences($userid){
		$db = $this->db;
		return $db->fetchAll($db->select()->from("character_references")->where("character_references.userid = ?", $userid));
	}
	
	private function getJobSubCategory($categoryId){
		$db = $this->db;
		if ($categoryId){
			$jobCategory = $db->fetchOne($db->select()->from("job_sub_category", array("sub_category_name"))->where("sub_category_id = ?", $categoryId));
			return $jobCategory;
		}else{
			return "";
		}
	}
	
	private function getCurrentJob($userid){
		$db = $this->db;
		$currentJob = $db->fetchRow($db->select()->from("currentjob")->where("currentjob.userid = ?", $userid));
		return $currentJob;
	}
	
	private function getEducation($userid){
		$db = $this->db;
		$education = $db->fetchRow($db->select()->from("education")->where("education.userid = ?", $userid));
		return $education;
	}
	
	private function transformCurrentJobEntries($user){
		$db = $this->db;	
		$currentJob = $user["currentjob"];
		
		$list = array();
		for($i=1;$i<=10;$i++){
			$suffix="";
			if ($i>1){
				$suffix.="$i";	
			}
			
			//query salary grade
			$salary_grade = $db->fetchRow($db->select()->from("previous_job_salary_grades")->where("userid = ?", $_SESSION["userid"])->where("`index` = ?", $i));
			//work types
			$job_industry = $db->fetchRow($db->select()->from(array("pji"=>"previous_job_industries"))->joinLeft(array("di"=>"defined_industries"), "di.id = pji.industry_id", array("di.value AS industry"))->where("userid = ?", $_SESSION["userid"])->where("`index` = ?", $i));
			
			
			if ($currentJob["companyname".$suffix]!=""){
				$cj = array(
								"companyname"=>$currentJob["companyname".$suffix], 
								"position"=>$currentJob["position".$suffix],
								"monthfrom"=>$currentJob["monthfrom".$suffix],
								"yearfrom"=>$currentJob["yearfrom".$suffix],
								"monthto"=>$currentJob["monthto".$suffix],
								"yearto"=>$currentJob["yearto".$suffix],
								"duties"=>$currentJob["duties".$suffix],	
								"salary_grade"=>$salary_grade,
								"job_industry"=>$job_industry
							);	
					
				
				$list[] = $cj;
			}
		}
		return $list;
	}
	
	
	private function renderNoiseLevel($user){
		$noiseLevels = explode(",", trim($user["noise_level"]));
		
		if (count($noiseLevels)>0&&($noiseLevels[0]!="")){
			$noise = "<ul style='margin-left:3px;padding-left:10px'>";
			foreach($noiseLevels as $level){
				$noise .= "<li><strong>".trim(ucfirst($level))."</strong></li>";
			}
			$noise .= "</ul>";
			return $noise;
		}else{
			return "";
		}
	}
	
	private function renderComputerHardware($user){
		$computer_hardware = $user["computer_hardware"];
		$computer_hardware = explode("\n", $computer_hardware);
		$hardware = "<ol style='margin-left:3px;padding-left:10px'>";
		$labels = array("Headset", "High performance headphones", "Printer", "Scanner", "Tablet", "Pen Tablet");
		if (count($computer_hardware)!=0){
			foreach($computer_hardware as $key=>$item){
				$specifics = explode(",", $item);
				if ($key==0||$key==1){
					if ($specifics[0]=="laptop"){
						$hardware.="<li><strong>Laptop: </strong> ({$specifics[1]}, {$specifics[2]} Processor, {$specifics[3]} RAM)</li>";
					}else if ($specifics[0]=="desktop"){
						$hardware.="<li><strong>Desktop: </strong> ({$specifics[1]}, {$specifics[2]} Processor, {$specifics[3]} RAM)</li>";
					}
				}else{
					if (trim($item)!=""){
						$hardware.="<li><strong>{$labels[$key-2]}: </strong> {$item}</li>";
					}
				}
			}
			$hardware.="</ol>";
		}else{
			return "";
		}
		return $hardware;
	}
	
	private function getLanguages($userid){
		$db = $this->db;
		$languages = $db->fetchAll($db->select()->from("language")->where("userid = ?", $userid));
		return $languages;
	}
	
	private function getSkills($userid){
		$db = $this->db;
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid));
		foreach($skills as $key=>$skill){
			if ($skill["experience"]==0.5){
				$skills[$key]["experience"] = "Less than 6 months";
			}else if ($skill["experience"]==0.75){
				$skills[$key]["experience"] = "More than 6 months";
			}else if ($skill["experience"]>10){
				$skills[$key]["experience"] = "More than 10 yrs.";
			}else if ($skill["experience"]==1){
				$skills[$key]["experience"] = $skill["experience"]." yr.";
			}else{
				$skills[$key]["experience"] = $skill["experience"]." yrs.";
			}
			if ($skill["proficiency"]==3){
				$skills[$key]["proficiency"] = "Advance";
			}else if ($skill["proficiency"]==2){
				$skills[$key]["proficiency"] = "Intermediate";
			}else if ($skill["proficiency"]==1){
				$skills[$key]["proficiency"] = "Beginner";
			}
		}
		
		return $skills;
	}
	
}
