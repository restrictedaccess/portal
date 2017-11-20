<?php
include('../conf/zend_smarty_conf.php');
$_SESSION["selected_evaluation_notes"] = $_POST["eval_notes"];
echo json_encode(array("success"=>true));
