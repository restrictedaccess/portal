<?php
include_once '../conf/zend_smarty_conf.php';
require_once "classes/AddCandidateProfileStep1.php";
require_once "forms/UpdateCandidateProfileForm.php";
include '../time.php';
$candidateProfile = new AddCandidateProfileStep1($db);
if (!empty($_POST)){
	$candidateProfile->update();
}
$candidateProfile->renderUpdate();	
