<?php
include_once '../conf/zend_smarty_conf.php';
echo json_encode($db->fetchAll($db->select()->from("currency_lookup")));