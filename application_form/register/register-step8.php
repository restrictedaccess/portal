<?php

include '../../conf/zend_smarty_conf.php';
include '../time.php';
require_once 'SimpleImage.php';

function imageResize($filename,$maxwidth,$maxheight){
	$image = new SimpleImage();  
	$image->load($filename);
	$image->resizeToWidth($maxwidth);
	if($image->getHeight($filename)<=$maxheight){
		$image->save($filename);
		return true;
	}
	else{
		unlink($filename);
		return false;
	}	
}
		
		
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if (!isset($_SESSION["userid"])){
	header("Location: /portal/application_form/registernow-step8-uploadphoto.php");
	die;
}
$userid=$_SESSION['userid'];
if(isset($_FILES['uploaded_file'])){					
	if(!empty($_FILES["uploaded_file"])){ 
						
		//Check that we have a file
		if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)){
							
			//Check if the file is JPEG image and it's size is less than 350Kb
			$filename = basename($_FILES['uploaded_file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1); 
			
			if(($ext == 'gif')||($ext == 'jpg')||($ext == 'jpeg')){
				if($_FILES["uploaded_file"]["size"] < 5000000){								
					//Determine the path to which we want to save this file
					$newname = '../../uploads/pics/'.$_SESSION['userid'].'.'.$ext;
					move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname);			
				} 							
				else {
					$error_msg = "File size exceeded! Please resize or upload a different recording";
					$error=1;
				}
			}
			else {
				$error_msg = "File extension prohibited. Please upload image files only";
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

if($newname != '') $picture = "uploads/pics/".basename($newname);
else $picture = '';

$data = array( 
	'userid' => $userid,
	'image' => $picture
);

$sql = $db->select()
	->from('personal' , 'userid')
	->where('userid = ?' ,$userid);
$exists = $db->fetchOne($sql);
if($exists){
	$where = "userid = ".$userid;
	$db->update('personal', $data, $where);
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
//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 8); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 8, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if ($_POST["action"]=="remove"){
	if ($id){
		$where = "id = ".$id." AND form = 8";
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
if ($userid){
	$user = $db->fetchRow($db->select()->from("personal", array("image"))->where("userid = ?", $userid));
	if ($user&&!(is_null($user["image"])||$user["image"]=="")){
		//create or update entry for remote ready
		$data = array();
//		$db->delete("remote_ready_criteria_entries", "userid = ".$userid." AND remote_ready_criteria_id = 1");
		$data["userid"] = $userid;
		$data["remote_ready_criteria_id"] = 1;
		$data["date_created"] = date("Y-m-d h:i:s");
//		$db->insert("remote_ready_criteria_entries", $data);
	}
}


if(isset($error_msg)){
	header("Location: ../registernow-step8-uploadphoto.php?error_msg=".$error_msg);
}
else{
	header("Location: ../registernow-step8-uploadphoto.php");
}






?>