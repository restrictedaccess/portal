<?php
include '../conf/zend_smarty_conf.php';
include '../lib/validEmail.php';

$email = $_REQUEST['email'];
$cc = $_REQUEST['cc'];
$bcc = $_REQUEST['bcc'];

//$emails = array();

//array_push($emails , $email);
$cc_array = explode(",",$cc);
$bcc_array = explode(",",$bcc);


$result = array_merge_recursive($cc_array, $bcc_array);
array_push($result , $email);
//print_r($result);
foreach($result as $em){
    if($em){
	    $em = trim($em);
        if (!validEmailv2($em)){
	        echo "Invalid Email Address => ". $em;
	        exit;
        }
    }
}

echo "ok";
?>