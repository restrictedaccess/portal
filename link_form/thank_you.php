<?php 

include ('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
require_once "classes/ThankYou.php";

$job_spec_form = new ThankYou($db,$base_api_url);
$job_spec_form -> render();






	
