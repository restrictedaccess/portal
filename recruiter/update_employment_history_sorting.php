<?php
include('../conf/zend_smarty_conf.php');
if ($_REQUEST["userid"]&&$_REQUEST["items"]){
	$userid = $_REQUEST["userid"];
	$items = $_REQUEST["items"];
	$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $userid));
	if ($currentjob){
		$employment_history = array();
		//collect non empty column
		$j = 1;
		for($i=1;$i<=10;$i++){
			$index = $i;
			$newIndex = $j;
			if ($i==1){
				$index = "";
			}
			if ($j==1){
				$newIndex = "";
			}
			if ( trim($currentjob["companyname".$index])!=""){
				$employment_history["companyname".$newIndex] = $currentjob["companyname".$index];
				$employment_history["position".$newIndex] = $currentjob["position".$index];
				$employment_history["monthfrom".$newIndex] = $currentjob["monthfrom".$index];
				$employment_history["yearfrom".$newIndex] = $currentjob["yearfrom".$index];
				$employment_history["monthto".$newIndex] = $currentjob["monthto".$index];
				$employment_history["yearto".$newIndex] = $currentjob["yearto".$index];
				$employment_history["duties".$newIndex] = $currentjob["duties".$index];
				
				$j++;
			}
			
		}
		
		$new_employment_history = array();
		
		
		
		$salary_grades = $db->fetchAll($db->select()->from("previous_job_salary_grades")->where("userid = ?", $userid));
		$db->delete("previous_job_salary_grades", $db->quoteInto("userid = ?", $userid));
		
		//salary grades
		foreach($items as $item){
			foreach($salary_grades as $salary_grade){
				unset($salary_grade["id"]);
				if ($salary_grade["index"]==$item["original_ordering"]){
					$salary_grade["index"] = $item["ordering"];
					$salary_grade["date_updated"] = date("Y-m-d H:i:s");
					$db->insert("previous_job_salary_grades", $salary_grade);
				}
			}
			
		}
		
		
		$industries = $db->fetchAll($db->select()->from("previous_job_industries")->where("userid = ?", $userid));
		$db->delete("previous_job_industries", $db->quoteInto("userid = ?", $userid));
		
		//industries
		foreach($items as $item){
			foreach($industries as $industry){
				unset($industry["id"]);
				if ($industry["index"]==$item["original_ordering"]){
					$industry["index"] = $item["ordering"];
					$db->insert("previous_job_industries", $industry);
				}
			}			
		}
		
		
		$k = 0;
		foreach($items as $item){
			if ($item["ordering"]==1){
				$item["ordering"] = "";
			}
			if ($item["original_ordering"]==1){
				$item["original_ordering"] = "";
			}
			$new_employment_history["companyname".$item["ordering"]] = $employment_history["companyname".$item["original_ordering"]];
			$new_employment_history["position".$item["ordering"]] = $employment_history["position".$item["original_ordering"]];
			$new_employment_history["monthfrom".$item["ordering"]] = $employment_history["monthfrom".$item["original_ordering"]];
			$new_employment_history["yearfrom".$item["ordering"]] = $employment_history["yearfrom".$item["original_ordering"]];
			$new_employment_history["monthto".$item["ordering"]] = $employment_history["monthto".$item["original_ordering"]];
			$new_employment_history["yearto".$item["ordering"]] = $employment_history["yearto".$item["original_ordering"]];
			$new_employment_history["duties".$item["ordering"]] = $employment_history["duties".$item["original_ordering"]];
			$k++;
		}
		
		for($i=$k+1;$i<=10;$i++){
			$index = $i;
			if ($i==1){
				$index = "";
			}
			$new_employment_history["companyname".$index] = "";
			$new_employment_history["position".$index] = "";
			$new_employment_history["monthfrom".$index] = "";
			$new_employment_history["monthto".$index] = "";
			$new_employment_history["yearfrom".$index] = "";
			$new_employment_history["yearto".$index] = "";
			$new_employment_history["duties".$index] = "";	
		}
	}
	$db->update("currentjob", $new_employment_history, $db->quoteInto("userid = ?", $userid));
	echo json_encode($new_employment_history);
}
