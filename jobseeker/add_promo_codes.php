<?php
include('../conf/zend_smarty_conf.php');
include '../time.php';
require_once "classes/PromoCodeProcess.php";
$process = new PromoCodeProcess($db);
echo json_encode($process->addPromoCode());
