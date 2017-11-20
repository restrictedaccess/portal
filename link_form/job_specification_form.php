<?php 

include ('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include('class.php');
require_once "classes/JobSpecificationForm.php";


if(isset($_SESSION["link_form_success"])){
	
	$smarty = new Smarty();
	$smarty -> assign('link_form_success', $_SESSION["link_form_success"]);
	
}
$job_spec_form = new JobSpecificationForm($db,$base_api_url);
$job_spec_form -> render();






	
