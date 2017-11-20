<?php
include('../conf/zend_smarty_conf.php');
require_once "classes/QQFileUploader.php";
if (!isset($_SESSION["admin_id"])){
	echo json_encode(array("success"=>false));
	die;
}

$allowedExtensions = array("csv");
$sizeLimit = 5 * 1024 * 1024;
$uploader = new qqFileUploader($allowedExtensions,$sizeLimit);
$name = $uploader->getName();
$uploader->handleUpload(getcwd()."/../seo/");
if (file_exists(getcwd()."/../seo/$name")){
	$file_handle = fopen($name, "r");
	if ($file_handle){
		while (!feof($file_handle)) {
		   $line = fgets($file_handle);
		   if (trim($line)==""){
			   $row = $db->fetchRow($db->select()->from("defined_skills")->where("LOWER(skill_name) = ?", strtolower($line)));
			   $url = strtolower($line);
			   $url = str_replace(" ", "_", $url);
			   if (!$row){
				$db->insert("defined_skills", array("skill_name"=>$line, "url"=>$url));	
			   }else{
			   	 $db->update("defined_skills",array("skill_name"=>$line, "url"=>$url), $db->quoteInto("LOWER(skill_name) = ?", strtolower($line)));
			   }	
		   }
		   
		}
		fclose($file_handle);
		unlink($name);
		echo json_encode(array("success"=>true));	
	}else{
		echo json_encode(array("success"=>false));	
	}
}else{
	echo json_encode(array("success"=>false));	
}
