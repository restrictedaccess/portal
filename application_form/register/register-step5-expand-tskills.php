<?php 

include '../../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step5-skills-details.php");
} 

$userid = $_SESSION['userid'];

$tskill = $_POST['tskill'];
$texp = $_POST['texp'];
$tprof = $_POST['tprof'];

$askill = $_POST['askill'];
$aexp = $_POST['aexp'];
$aprof = $_POST['aprof'];

if($_POST['form_id'] == '') {
	$password = trim($_POST['password']); 
	if($password == '') {
		//make a random string password for client 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$rand_pw = '';    
		for ($p = 0; $p < 10; $p++) {  
			$rand_pw .= $characters[mt_rand(0, strlen($characters))];
		}
		$password = $rand_pw;
	}
	$pass = sha1($password);
}else{
	$sql = $db->select()
		->from('personal' ,'pass')
		->where('userid = ?' , $userid);
	$pass = $db->fetchOne($sql);	 
}

$sql = "delete from skills where userid='".$userid."'";
$db->query($sql);

if($tskill == NULL){
	$tskill = array();
}

if($askill == NULL){
	$askill = array();
}

array_push ($tskill,array());
for($i=0;$i<count($tskill);$i++){
	$data = array( 
		'userid' => $userid,
		'skill' => $tskill[$i],
		'experience' => $texp[$i], 
		'proficiency' => $tprof[$i],
		'skill_type' => 'technical'
	);
	if($tskill[$i] != ''){
		$db->insert('skills', $data);
	}
}

for($i=0;$i<count($askill);$i++){
	$data = array( 
		'userid' => $userid,
		'skill' => $askill[$i],
		'experience' => $aexp[$i],
		'proficiency' => $aprof[$i],
		'skill_type' => 'admin'
	);
	if($askill[$i] != ''){
		$db->insert('skills', $data);
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
$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid)->limit(5));
//$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 3");
if (!empty($skills)){
	//create or update entry for remote ready
	foreach($skills as $skill){
		$data = array();
		$data["userid"] = $userid;
		$data["remote_ready_criteria_id"] = 3;
		$data["date_created"] = date("Y-m-d H:i:s");
//		$db->insert("remote_ready_criteria_entries", $data);
	}
}

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 5); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 5, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}



header("Location: ../registernow-step5-skills-details.php"); 






?>