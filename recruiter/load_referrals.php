<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../function.php') ;
include('../lib/validEmail.php') ;
include('../time.php') ;
include('../AgentCurlMailSender.php') ;
include('../lib/staff_history.php');
include_once('../lib/staff_files_manager.php') ;

require_once 'reports/GetReferralListings.php';

$listings = new GetReferralListings($db);
echo $listings->process();