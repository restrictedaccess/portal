<?php
include '../conf/zend_smarty_conf.php';
$gs_job_titles_credentials_id = $_REQUEST['gs_job_titles_credentials_id'];
$where = "gs_job_titles_credentials_id = ".$gs_job_titles_credentials_id;
$db->delete('gs_job_titles_credentials', $where);
?>