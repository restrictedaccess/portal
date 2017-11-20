<?php

include '../../conf/zend_smarty_conf.php';
include '../time.php';
require_once "../../recruiter/util/HTMLUtil.php";

		
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime; 


if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step7-uploadphoto.php");
}
$ext = "";
$userid=$_SESSION['userid'];

$voice = "";
if( isset($_POST['action']) && $_POST['action'] == 'sync_vr' ){
	$result = file_get_contents("http://vps01.remotestaff.biz:5080/remote/user_stream.jsp?cid=".$userid."js");
	$result = json_encode($result);
	$result = preg_replace('/[\\\n|\\\"|\[|\]]*/', "", $result);
	//$raw_array = str_replace("\n", "", $raw_array);
	$raw_array = explode(',', $result);
	if( count($raw_array) > 1 && (int)$raw_array[1] > 0 ) {
		$voice="http://vps01.remotestaff.biz:5080/remote/audio/".$raw_array[0];
	}
}

if(isset($_FILES['uploaded_file'])){
	if(!empty($_FILES["uploaded_file"])){ 
						
		//Check that we have a file
		if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)){
							 
			//Check if the file is JPEG image and it's size is less than 350Kb
			$filename = basename($_FILES['uploaded_file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1); 
			//echo $ext;
			if(($ext == 'wav')||($ext == 'flv')||($ext == 'mp3')||($ext == 'wma')){
				if($_FILES["uploaded_file"]["size"] < 5000000){								
					//Determine the path to which we want to save this file
					$newname = '../../uploads/voice/'.$_SESSION['userid'].'.'.$ext;
					move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname);			
				} 							
				else {
					$error_msg = "File size exceeded! Please resize or upload a different recording";
					$error=1;
				}
			}
			else {
				$error_msg = "File extension prohibited. Please upload audio files only";
				$error=1;
			}
		}
		else {
			$error_msg = "No file was uploaded. Please upload a file";
			$error=1;
		}
	}
	else{
		//echo "blank fields!";
		$error=1;
	}
}



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

if($newname!="")$voice="uploads/voice/".basename($newname);
//else $voice="";

$data = array( 
	'userid' => $userid,
	'voice_path' => $voice
);

$sql = $db->select()
	->from('personal' , 'userid')
	->where('userid = ?' ,$userid);
$exists = $db->fetchOne($sql);
if($exists){
	
	$where = "userid = ".$userid;
	$db->update('personal', $data, $where);
	$util = new HTMLUtil();
;
	if (($ext=="wav")||($ext=="wma")){
		$util->convert_mp3($userid, "../../");		
	}
	
}else{
	$db->insert('personal', $data);
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
if ($userid){
	$user = $db->fetchRow($db->select()->from("personal", array("voice_path"))->where("userid = ?", $userid));
	if ($user&&!(is_null($user["voice_path"])||$user["voice_path"]=="")){
		//create or update entry for remote ready
		$data = array();
//		$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 2");
		$data["userid"] = $userid;
		$data["remote_ready_criteria_id"] = 2;
		$data["date_created"] = date("Y-m-d h:i:s");
//		$db->insert("remote_ready_criteria_entries", $data);
	}
}

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 7); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 7, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if ($_POST["action"]=="remove"){
	if ($id){
		$where = "id = ".$id." AND form = 7";
		$db->delete('applicants_form', $where);
	}	
}else{
	if($id){
		$where = "id = ".$id;
		$db->update('applicants_form', $data, $where);
	}else{
		$db->insert('applicants_form', $data);
	}
}


if(isset($error_msg)){
	header("Location: ../registernow-step7-upload-voice-recording.php?error_msg=".$error_msg);
}
else{
	header("Location: ../registernow-step7-upload-voice-recording.php?success");
}

