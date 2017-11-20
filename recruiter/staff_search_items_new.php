<?php
include('../conf/zend_smarty_conf.php');

include '../config.php';
include '../conf.php';

include("staff_search_items_functions_new.php");

//START: loader
$max = $_REQUEST["max"];
$status = $_REQUEST["status"];
$p = $_REQUEST["p"];
if (!isset($p)) $p = 1 ;
$maxp = 20 ;
$found = search_items($db,$status,$p,$maxp,$max) ;
$pages = search_items_linkpage($status,$p,$maxp,$found[0]['max']) ;
//ENDED: loader

include("staff_search_items_format.php");
echo $data_items;
?>