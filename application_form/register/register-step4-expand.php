<?php

include '../../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step4-personal-details.php");
}



$userid=$_SESSION['userid'];
$current_status=$_POST['current_status'];
$years_worked=$_POST['years_worked'];
$months_worked=$_POST['months_worked'];
$expected_salary_neg=$_POST['expected_salary_neg'];
$expected_salary=$_POST['expected_salary'];
$salary_currency=$_POST['salary_currency'];
$latest_job_title=$_POST['latest_job_title'];

$position_first_choice=$_POST['position_first_choice'];
$position_first_choice_exp=$_POST['position_first_choice_exp'];
$position_second_choice=$_POST['position_second_choice'];
$position_second_choice_exp=$_POST['position_second_choice_exp'];
$position_third_choice=$_POST['position_third_choice'];
$position_third_choice_exp=$_POST['position_third_choice_exp'];

$history_company_name=$_POST['history_company_name'];
$history_position=$_POST['history_position'];
$history_monthfrom=$_POST['history_monthfrom'];
$history_yearfrom=$_POST['history_yearfrom'];
$history_monthto=$_POST['history_monthto'];
$history_yearto=$_POST['history_yearto'];
$history_responsibilities=$_POST['history_responsibilities'];


if($_POST['form_id'] == "") {
	$password = trim($_POST['password']);
	if($password == "") {
		//make a random string password for client 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$rand_pw = '';    
		for ($p = 0; $p < 10; $p++) {
			$rand_pw .= $characters[mt_rand(0, strlen($characters))];
		}
		$password = $rand_pw;
	}
	$pass= sha1($password);
}else{
	$sql = $db->select()
		->from('personal' ,'pass')
		->where('userid = ?' , $userid);
	$pass = $db->fetchOne($sql);	 
}


if($current_status=="still studying"){
	$intern_status=1;
	$freshgrad=0;
}
else{
	if($current_status=="fresh graduate"){
		$intern_status=0;
		$freshgrad=1;
	}else{
		$intern_status=0;
		$freshgrad=0;
	}
}


$data = array( 
	'userid' =>$userid,
	'freshgrad' => $freshgrad,
	'intern_status' => $intern_status,
	'years_worked' => $years_worked,
	'months_worked' => $months_worked,
	'expected_salary_neg' => $expected_salary_neg,
	'expected_salary' => $expected_salary,
	'salary_currency' => $salary_currency,
	'latest_job_title' => $latest_job_title,
	

	'position_first_choice' => $position_first_choice,
	'position_first_choice_exp' => $position_first_choice_exp,
	'position_second_choice' => $position_second_choice,
	'position_second_choice_exp' => $position_second_choice_exp,
	'position_third_choice' => $position_third_choice,
	'position_third_choice_exp' => $position_first_choice_exp
);

$result=array();
$result=array_merge($result,$data);
$happened = false;
for($i=0;$i<count($history_company_name);$i++){
	$db_column_suffix = $i+1;
	if ($db_column_suffix>10){
		continue;
	}
	if($i==0)$db_column_suffix = "";
	
	if ($history_monthto[$i]==""||$history_yearto[$i]==""||$history_monthto[$i]=="Present"||$history_yearto[$i]=="Present"){
		if (!$happened){
			$smarty = new Smarty();
			//get the candidate fullname
			
			$pers = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "lname", "email"))->where("userid = ?", $userid));
			if ($pers){
				if ($pers["fname"]==""&&$pers["lname"]==""){
					$smarty->assign("candidate_fullname", "Applicant");
				}else{
					$smarty->assign("candidate_fullname", $pers["fname"]." ".$pers["lname"]);
				}
				$output = $smarty->fetch("currently_employed.tpl");
				$mail = new Zend_Mail();
				if (TEST){
					$mail->setSubject("TEST - Updates on your Application at Remotestaff");
				}else{
					$mail->setSubject("Updates on your Application at Remotestaff");			
				}
				$mail->setFrom("recruitment@remotestaff.com.au","recruitment@remotestaff.com.au");
				$mail->setBodyHtml($output);
				if (TEST){
					$mail->addTo("devs@remotestaff.com.au");
				}else{
					$mail->addTo($pers["email"]);
				}
				$mail->send($transport);
				$happened = true;				
			}

		}
	
		
	}
	$result = array_merge($result,array('companyname'.$db_column_suffix => ($history_company_name[$i])));
	$result = array_merge($result,array('position'.$db_column_suffix => ($history_position[$i])));
	$result = array_merge($result,array('monthfrom'.$db_column_suffix => ($history_monthfrom[$i])));
	$result = array_merge($result,array('yearfrom'.$db_column_suffix => ($history_yearfrom[$i])));
	$result = array_merge($result,array('monthto'.$db_column_suffix => ($history_monthto[$i])));
	$result = array_merge($result,array('yearto'.$db_column_suffix => ($history_yearto[$i])));
	$result = array_merge($result,array('duties'.$db_column_suffix => str_replace("�","'",$history_responsibilities[$i])));
}


$sql = $db->select()
	->from('currentjob' , 'userid')
	->where('userid = ?' ,$userid);
$exists = $db->fetchOne($sql);
if($exists){
	$where = "userid = ".$userid;
	$db->update('currentjob', $result, $where);
}else{
	$db->insert('currentjob', $result);
}

//character reference save
$names = $_POST["name"];
$contact_details = $_POST["contact_details"];
$contact_numbers = $_POST["contact_number"];
$email_addresses = $_POST["email_address"];
$ids = $_POST["id"];
$db->delete("character_references", $db->quoteInto("userid = ?", $userid));
foreach($names as $key=>$name){
	if ($name){
		$data = array();
		
		$data["name"] = $name;
		if ($contact_details[$key]){
			$data["contact_details"] = $contact_details[$key];
		}
		if ($email_addresses[$key]){
			$data["email_address"] = $email_addresses[$key];
		}
		if ($contact_numbers[$key]){
			$data["contact_number"] = $contact_numbers[$key];
		}
		$data["userid"] = $_SESSION["userid"];
		
		if ($ids[$key]){
			$row = $db->fetchRow($db->select()->from(array("cr"=>"character_references"), array("id"))->where("cr.id = ?", $ids[$key]));	
			if ($row){
				$data["date_updated"] = date("Y-m-d h:i:s");
				$db->update("character_references", $data, $db->quoteInto("id = ?", $ids[$key]));					
			}else{
				$data["date_created"] = date("Y-m-d h:i:s");
				$db->insert("character_references", $data);	
			}
		}else{
			$data["date_created"] = date("Y-m-d h:i:s");
			$db->insert("character_references", $data);
		}
		
	}
}


$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $userid));
if ($currentjob){
	$db->delete("personal_categorization_entries", $db->quoteInto("userid = ?", $userid));
	if ($currentjob["position_first_choice"]){
		$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_first_choice"])->where("pce.userid = ?", $currentjob["userid"]));
		if (!$row){
			$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_first_choice"]));
			$db->insert("personal_categorization_entries", array("userid"=>$userid, "sub_category_id"=>$currentjob["position_first_choice"], "category_id"=>$category["category_id"]));
		}
	}
	if ($currentjob["position_second_choice"]){
		$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_second_choice"])->where("pce.userid = ?", $currentjob["userid"]));
		if (!$row){
			$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_second_choice"]));
			$db->insert("personal_categorization_entries", array("userid"=>$userid, "sub_category_id"=>$currentjob["position_second_choice"], "category_id"=>$category["category_id"]));
		}
	}
	if ($currentjob["position_third_choice"]){
		$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_third_choice"])->where("pce.userid = ?", $currentjob["userid"]));
		if (!$row){
			$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_third_choice"]));
			$db->insert("personal_categorization_entries", array("userid"=>$userid, "sub_category_id"=>$currentjob["position_third_choice"], "category_id"=>$category["category_id"]));
		}
	}	
}

if (isset($_COOKIE["promo_code"])){
	$db->update("personal", array("promotional_code"=> $_COOKIE["promo_code"]), $db->quoteInto("userid = ?", $userid));
}
if (isset($_COOKIE["promo_code"])){
	//get promo code owner
	$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("promocode = ?", $_COOKIE["promo_code"]));
	if ($promocode){
		//register as a referral with type promocode
		$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));
		
		if ($personal){
			$referral = array(
				"user_id"=>$promocode["userid"],
				"firstname"=>$personal["fname"],
				"lastname"=>$personal["lname"],
				"email"=>$personal["email"],
				"contactnumber"=>$personal["handphone_country_code"]."+".$personal["handphone_no"],
				"date_created"=>date("Y-m-d H:i:s"),
				"contacted"=>0,
				"jobseeker_id"=>$userid,
				"type"=>"promo_code"
			);
			$refer = $db->fetchRow($db->select()->from("referrals")->where("user_id = ?", $promocode["userid"])->where("jobseeker_id = ?", $userid));
			if (!$refer){
				$db->insert("referrals", $referral);
			}
		}
		
			
	}
	
}

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 4); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 4, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}



header("Location: ../registernow-step4-work-history-details.php"); 






?>