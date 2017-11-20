<?php

include "../conf/zend_smarty_conf.php";
require_once "classes/Ads.php";
$ads_page= new Ads($db, $base_api_url, $curl);
$ads_page -> render();



