<?php
include('../conf/zend_smarty_conf.php');
require_once "classes/PricingListRender.php";

$search = new PricingListRender($db);
echo json_encode($search->multiAddPrice());
