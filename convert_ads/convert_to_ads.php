<?php
include ("../conf/zend_smarty_conf.php");
require_once ("classes/ConvertAds.php");
$convert_to_ads = new ConvertAds($db);
$convert_to_ads -> render();


