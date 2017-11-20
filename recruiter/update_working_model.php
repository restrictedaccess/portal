<?php 
include('../conf/zend_smarty_conf.php');
require_once "classes/WorkingModel.php";
$working_model = new WorkingModel($db);
echo json_encode($working_model->render());
