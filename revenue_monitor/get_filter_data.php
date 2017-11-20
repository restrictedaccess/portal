<?php
require_once('../conf/zend_smarty_conf.php');
include_once('admin_revmonitor_class.php');

$field = $_GET['fld'];
!$field && exit;
$revmon = revenue_monitoring::get_instance($db_query_only, false);
$list = $revmon->list_filter_data($field);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Content-Type: application/json");
echo "window.parent.{$field} = ".json_encode( $list ).";";