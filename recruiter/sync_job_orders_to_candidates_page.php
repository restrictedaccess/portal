<?php
include('../conf/zend_smarty_conf.php');


global $curl;

global $base_api_url;

$curl->get($base_api_url . "/mysql-index/sync-candidate-joborder/");

