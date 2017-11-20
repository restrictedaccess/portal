<?php
include_once '../conf/zend_smarty_conf.php';
require_once "classes/UpdateEducationProcess.php";
require_once "forms/UpdateEducationForm.php";
include '../time.php';
$candidateProfile = new UpdateEducationProcess($db);
if (!empty($_POST)){
	echo json_encode($candidateProfile->update());
}