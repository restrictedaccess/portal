<?php 

include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step5-skills-details.php");
} 

$userid=$_SESSION['userid'];
$skill=$_POST['skill'];
$skill_exp=$_POST['skill_exp'];
$skill_proficiency=$_POST['skill_proficiency'];

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

$sql = "delete from skills where userid='".$userid."'";
$db->query($sql);
for($i=0;$i<count($skill);$i++){
	$data = array( 
		'userid' => $userid,
		'skill' => $skill[$i],
		'experience' => $skill_exp[$i],
		'proficiency' => $skill_proficiency[$i]
	);
	$db->insert('skills', $data);
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



header("Location: ../registernow-step6-languages-details.php"); 






?>