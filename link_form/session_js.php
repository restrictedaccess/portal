<?php
include ('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
$_SESSION["leads_id"] = $_POST["leads_id"];
$_SESSION["staff_job_title"] = $_POST["staff_job_title"];
$_SESSION["number_of_staff"] = $_POST["number_of_staff"];
$_SESSION["years_of_experience"] = $_POST["years_of_experience"];

echo json_encode(array("success"=>true));