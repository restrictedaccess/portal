<?php

include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step6-skills-details.php");
}


$userid=$_SESSION['userid'];
$language=$_POST['language'];
$spoken=$_POST['spoken'];
$written=$_POST['written'];


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

$sql = "delete from language where userid='".$userid."'";
$db->query($sql);
for($i=0;$i<count($language);$i++){
	$data = array( 
		'userid' => $userid,
		'language' => $language[$i],
		'spoken' => $spoken[$i],
		'written' => $written[$i]  
	);
	$db->insert('language', $data); 
}

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid) 
	->where('form = ?' , 6); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 6, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}



header("Location: ../registernow-step7-uploadphoto.php"); 






?>