<?php
session_start();
if ($_POST["captcha_text"]){
	if ($_SESSION["captcha_text"]==md5($_POST["captcha_text"])){
		$result = array("success"=>true);	
	}else{
		$result = array("success"=>false);
	}
}else{
	$result = array("success"=>false);
}
echo json_encode($result);
