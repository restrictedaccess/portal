<?php
include('../conf/zend_smarty_conf.php');
if (!empty($_POST)){
	$skillname = $_POST["skill_name"];
	$names = $_POST["name"];
	$meta_description = $_POST["meta_description"];
	$meta_keywords = $_POST["meta_keywords"];
	$meta_title = $_POST["meta_title"];
	$url = $_POST["url"];
	$definedSkills = $db->fetchAll($db->select()->from("defined_skills")->where("lower(skill_name) = ?", strtolower($skillname)));
	
	if (!empty($definedSkills)){
		$hasSame = false;
		foreach($definedSkills as $definedSkill){
			if ($definedSkill["id"]!=$_POST["id"]){
				$hasSame = true;
			}
		}
		if (!$hasSame){
				$db->update("defined_skills", array("skill_name"=>$skillname, 
										 "meta_description"=>$meta_description,
										  "meta_keywords"=>$meta_keywords,
										  "meta_title"=>$meta_title,
										  "url"=>$url
									), $db->quoteInto("id = ?", $_POST["id"]));
			$id = $_POST["id"];
			$db->delete("defined_skill_other_terms", $db->quoteInto("defined_skill_id = ?", $id));
			if (!empty($names)){
				foreach($names as $name){
					if (trim($name)!=""){
						$db->insert("defined_skill_other_terms", array("defined_skill_id"=>$id, "name"=>$name, "date_created"=>date("Y-m-d H:i:s")));	
					}
				}	
			}
			
			echo json_encode(array("success"=>true));
		}else{
			echo json_encode(array("success"=>false, "error"=>"Skill already defined."));
		}
	}else{
		$db->update("defined_skills", array("skill_name"=>$skillname, 
									 "meta_description"=>$meta_description,
									  "meta_keywords"=>$meta_keywords,
									  "meta_title"=>$meta_title,
									  "url"=>$url
								), $db->quoteInto("id = ?", $_POST["id"]));
		$id = $_POST["id"];
		$db->delete("defined_skill_other_terms", $db->quoteInto("defined_skill_id = ?", $id));
		if (!empty($names)){
			foreach($names as $name){
				if (trim($name)!=""){
					$db->insert("defined_skill_other_terms", array("defined_skill_id"=>$id, "name"=>$name, "date_created"=>date("Y-m-d H:i:s")));	
				}
			}	
		}
		echo json_encode(array("success"=>true));
		
	}
	
}else{
	echo json_encode(array("success"=>false));
}
