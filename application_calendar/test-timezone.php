<?php
include('../conf/zend_smarty_conf.php');
//$ref_date = "Nov 23, 2010 10:54:46 AM";
$ref_date = "2010-11-23 10:54:46 AM";
$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
date_default_timezone_set('Asia/Manila');
$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
$destination_date = clone $date;
$destination_date->setTimezone('Australia/Sydney');
//$destination_date->setTimezone('Asia/Manila');
echo $destination_date;
?>