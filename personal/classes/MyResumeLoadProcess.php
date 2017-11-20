<?php
class MyResumeLoadProcess extends AbstractProcess{
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];
		$user = $this->getUser();
		$user["dateapplied"] = date("F j, Y", strtotime($user["datecreated"]));
		$user["datelastupdated"] = date("F j, Y", strtotime($user["dateupdated"]));
		$user["currentjob"] = $this->getCurrentJob($userid);
		$diff = abs(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d", strtotime($user["byear"]."-".$user["bmonth"]."-".$user["bday"]))));
		$user["age"] = floor($diff / (365*60*60*24));
		
		$user["birth_date"] = date("M d Y", strtotime($user["byear"]."-".$user["bmonth"]."-".$user["bday"]));
		$user["address"] = $user['address1']." ".$user['city']." ".$user['postcode']." <br>".$user['state']." ".$user['country_id'];
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
		/*
		$pregnant_array= array("Yes","No","No! I'm a Male Applicant","No, but I wish I was");
		for($i=0; $i<count($pregnant_array);$i++){
			if($user["pregnant"] == $i){
				$user["pregnant"] = $pregnant_array[$i];
				break;
			}
		}
		 * 
		 */
		 
		 
		 
		$user["character_references"] = $this->getCharacterReferences($userid);
		$user["skills"] = $this->getSkills($userid);
		$user["languages"] = $this->getLanguages($userid);
		$user["education"] = $this->getEducation($userid);
		$user["education"]["trainings_seminars"] = nl2br($user["education"]["trainings_seminars"]);
		$user["education"]["graduation"] = date("M Y", strtotime($user["education"]["graduate_year"]."-".$user["education"]["graduate_month"]."-1"));
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
		$smarty->assign("user", $user);
		$smarty->assign("tpl_name", "myresume");
		$smarty->display("template.tpl");
		
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
		$currentJob = $user["currentjob"];
		$list = array();
		for($i=1;$i<=10;$i++){
			$suffix="";
			if ($i>1){
				$suffix.="$i";	
			}
			if ($currentJob["companyname".$suffix]!=""){
				$list[] = array(
								"companyname"=>$currentJob["companyname".$suffix], 
								"position"=>$currentJob["position".$suffix],
								"monthfrom"=>$currentJob["monthfrom".$suffix],
								"yearfrom"=>$currentJob["yearfrom".$suffix],
								"monthto"=>$currentJob["monthto".$suffix],
								"yearto"=>$currentJob["yearto".$suffix],
								"duties"=>$currentJob["duties".$suffix],	
							);
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
		}
		
		return $skills;
	}
}