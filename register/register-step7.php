<?php

include '../conf/zend_smarty_conf.php';
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


if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step7-uploadphoto.php");
}
$userid=$_SESSION['userid'];
if(isset($_FILES['uploaded_file'])){					
	if(!empty($_FILES["uploaded_file"])){ 
						
		//Check that we have a file
		if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)){
							
			//Check if the file is JPEG image and it's size is less than 350Kb
			$filename = basename($_FILES['uploaded_file']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1); 
			if (!preg_match("/\.(gif|jpg|jpeg)$/i", $fileName) && ($_FILES["uploaded_file"]["size"] < 40000)){								
				//Determine the path to which we want to save this file
				$newname = '/home/remotestaff/test.remotestaff.com.au/html/portal/uploads/pics/'.$_SESSION['userid'].'.'.$ext;
				move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname);			
			} 							
			else {
				//echo "filesize exceeded!";
				$error=1;
			}
		}
		else {
			//echo "do not have the file!";
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

if($newname!="")$picture="/portal/uploads/pics/".basename($newname);
else $picture="";

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

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 7); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 7, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}




header("Location: ../registernow-step7-uploadphoto.php");






?>