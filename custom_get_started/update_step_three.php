<?php
include ('../conf/zend_smarty_conf.php');
require_once ('classes/JobOrderPreview.php');
$job_order_preview = new JobOrderPreview($db);
$job_order_preview->process_job_order_details();
