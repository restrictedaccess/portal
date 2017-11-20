<?php
class UpdateSkillsProcess extends AbstractProcess{
	public function process(){
		
	}
	
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];
		$user = $this->getUser();
		
		$skills_array = array('Actionscript','Adobe Fireworks','Adobe Illustrator','Adobe Indesign','Adobe Photoshop','AJAX','ASP','C#','C++','CAD','CISCO','Classic ASP','Coldfusion','Corel Draw','CSS','Drupal','HTML','JavaScript','Joomla','Link Building','Macromedia Dreamweaver','Magento','Maya','MS Access','MS Office','MS SQL','MySQL','OOP','Photoshop','PHP','SEO','SOLIDWORKS','Swishmax','Vector Works','Video Editing','Wordpress','XHTML','XML','.NET','3D MAX');
		$skills_options = '<option value="" >Select Skill</option>';
		for($i=0;$i<count($skills_array);$i++){
			$skills_options .= '<option value="'.$skills_array[$i].'" > '.$skills_array[$i].'</option>';
		}

		$admin_skills_array = array('Appointment Setting','Customer Service','Data Entry','Debt Collection','Internet Research','Lead Generation','Legal','MS Application','MS Excel','MS Powepoint','MS Word','MYOB','ORACLE','Peachtree','Photo Editing','Quickbooks','SAP','Tele Sales','Tele Survey','Telemarketing','Video Editing','Writing');
		$admin_skills_options = '<option value="" >Select Skill</option>';
		for($i=0;$i<count($admin_skills_array);$i++){
			$admin_skills_options .= '<option value="'.$admin_skills_array[$i].'" > '.$admin_skills_array[$i].'</option>';
		}


		$experience_options='<option value="" >-</option>';
		$experience_options.="<option value='0.5'>Less than 6 months</option>";
		$experience_options.="<option value='0.75'>Over 6 months</option>";
		for($i=1;$i<=10;$i++){
			if($i==1){
				$years="Year";
			}else{
				$years="Years";
			}
			
			$experience_options .= '<option value="'.$i.'" > '.$i.' '.$years.'</option>';
		}
		$experience_options.="<option value='11'>More than 10 yrs.</option>";
		


		$proficiency_array = array('Beginner','Intermediate','Advanced');
		$proficiency_options ='<option value="" >-</option>';
		for($i=1;$i<=count($proficiency_array);$i++){
			$proficiency_options .= '<option value="'.$i.'" > '.$proficiency_array[$i-1].'</option>';
		}

		
		$this->renderSkill("technical");
		$this->renderSkill("admin");
		$this->renderSkill("other");
		$smarty->assign('fname',$user["fname"]);
		$smarty->assign("userid", $userid);
		$smarty->assign("skill_options", $skills_options);
		$smarty->assign("experience_options", $experience_options);
		$smarty->assign("admin_skill_options", $admin_skills_options);
		$smarty->assign("proficiency_options", $proficiency_options);
		$smarty->display("updateskills.tpl");
		
		
	}
	
	private function renderSkill($type){
		$db = $this->db;
		$userid = $_SESSION["userid"];
		if ($type=="other"){
			$technicalSkills = $db->fetchAll($db->select()->from("skills")->where("skill_type IS NULL OR skill_type = ''")->where("userid = ?", $userid));	
		}else{
			$technicalSkills = $db->fetchAll($db->select()->from("skills")->where("skill_type = '$type'")->where("userid = ?", $userid));
		}
		$output = "";
		$i = 1;
		foreach($technicalSkills as $skill){
			if ($skill["experience"]==0.5){
				$experience = "Less than 6 months";
			}else if ($skill["experience"]==0.75){
				$experience = "More than 6 months";
			}else if ($skill["experience"]>10){
				$experience = "More than 10 yrs.";
			}else{
				$experience = $skill["experience"]."yr/s.";
			}
			
			if ($skill["proficiency"]==0||$skill["proficiency"]==1){
				$proficiency = "Beginner";
			}else if ($skill["proficiency"]==2){
				$proficiency = "Intermediate";
			}else{
				$proficiency = "Advanced";
			}
			$bgcolor="#f5f5f5";
			$output.="<tr bgcolor=$bgcolor>
			  <td width='6%' align=center><font size='1'>".$i.".</font></td>
			  <td width='33%' align=left><font size='1'>".$skill["skill"]."</font></td>
			  <td width='26%' align=center><font size='1'>".$experience."</font></td>
			  <td width='35%' align=center><font size='1'>".$proficiency."</font></td>
			  <td width='26%' align=center><font size='1'><a href='#' class='delete-skill' data-id='{$skill["id"]}' data-type='{$type}'>delete</a></font></td>
			 </tr>";
			$i++;
		}
		$this->smarty->assign($type."_skills", $output);
	}
}