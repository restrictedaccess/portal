<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
require_once('../conf/zend_smarty_conf.php');
require_once('../lib/misc_functions.php');
require_once('../lib/paginator.class.php');
include_once('../ticketmgmt/lib/Utils.php');
include_once('admin_revmonitor_class.php');


$filter_by = getVar('filter_by', '');
$search = getVar('search', '');
$contract_status = getVar('contract_status', 'ACTIVE');

$ipp = getVar("ipp", 0);

//revenue_monitoring::$admin_manage_confi = $ADMIN_MANAGE_INHOUSE_CONFIDENTIAL_INFO;
/*$admin_manage_confi = array(6, 154, 168, 189);

if( !in_array($_SESSION['admin_id'], $admin_manage_confi) ) {
    header("Location: /portal/index.php");
	exit;
}*/

$revmon = revenue_monitoring::get_instance($db);

$revmon->php_rates = $PHP_RATES;

if( $contract_status ) $revmon->where_clause['contract_status'] = $contract_status;

if( $search && $search != 'keyword') {
    $revmon->where_clause['filter_by'] = $filter_by;
    $revmon->where_clause['search'] = $search;
}

$revmon->pages = new Paginator;
$revmon->display('admin_revenue_monitoring');

?>