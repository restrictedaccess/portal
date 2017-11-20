<?php
include('../conf/zend_smarty_conf.php') ;
require_once "classes/LanguagesProcess.php";
$process = new LanguagesProcess($db);
echo json_encode($process->addLanguage());
